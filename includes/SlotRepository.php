<?php
/**
 * PawNest & CozyPaws - SlotRepository
 * Tính toán khung giờ còn trống (free slots) cho ngày đã chọn
 */

declare(strict_types=1);

require_once __DIR__ . '/db.php';

class SlotRepository {
    /**
     * Danh sách tất cả khung giờ hoạt động chuẩn trong ngày (08:00 - 18:00)
     */
    private const ALL_SLOTS = [
        '08:00', '09:30', '11:00', '13:30', '15:00', '16:30', '18:00'
    ];

    /**
     * Lấy các khung giờ còn trống trong ngày
     * @param string $date Định dạng YYYY-MM-DD
     * @param int|null $serviceId Mã dịch vụ
     * @return array Danh sách giờ còn nhận khách
     */
    public function freeSlots(string $date, ?int $serviceId = null): array {
        $pdo = Database::getConnection();

        // Đếm số lịch đã nhận cho từng khung giờ trong ngày
        $stmt = $pdo->prepare('
            SELECT TIME_FORMAT(start_at, "%H:%i") as slot_time, COUNT(*) as booked_count
            FROM appointments
            WHERE DATE(start_at) = :date AND status NOT IN ("cancelled")
            GROUP BY slot_time
        ');
        $stmt->execute(['date' => $date]);
        $booked = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // ['09:30' => 1, '14:00' => 2]

        // Giả sử phòng khám có tối đa 3 nhân sự làm việc đồng thời cho mỗi khung giờ
        $maxCapacityPerSlot = 3;

        $available = [];
        foreach (self::ALL_SLOTS as $slot) {
            $currentBooked = $booked[$slot] ?? 0;
            if ($currentBooked < $maxCapacityPerSlot) {
                $available[] = [
                    'time' => $slot,
                    'available' => true,
                    'remaining' => $maxCapacityPerSlot - $currentBooked
                ];
            }
        }

        return $available;
    }
}
