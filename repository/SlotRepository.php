<?php
/**
 * PawNest & CozyPaws - SlotRepository
 * Tính toán khung giờ còn trống (free slots) cho ngày đã chọn
 */

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

class SlotRepository {
    private PDO $pdo;

    public function __construct(?PDO $pdo = null) {
        $this->pdo = $pdo ?? Database::getConnection();
    }

    /**
     * Danh sách tất cả khung giờ hoạt động chuẩn trong ngày (08:00 - 18:00)
     */
    private const ALL_SLOTS = [
        '08:00', '09:30', '11:00', '13:30', '15:00', '16:30', '18:00'
    ];

    /**
     * Lấy các khung giờ còn trống trong ngày
     */
    public function freeSlots(string $date, ?int $serviceId = null): array {
        $stmt = $this->pdo->prepare('
            SELECT TIME_FORMAT(start_at, "%H:%i") as slot_time, COUNT(*) as booked_count
            FROM appointments
            WHERE DATE(start_at) = :date AND status NOT IN ("cancelled")
            GROUP BY slot_time
        ');
        $stmt->execute(['date' => $date]);
        $booked = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

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
