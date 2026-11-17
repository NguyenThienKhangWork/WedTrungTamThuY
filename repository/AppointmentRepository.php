<?php
/**
 * PawNest & CozyPaws - AppointmentRepository
 * Quản lý tạo lịch hẹn bằng Transaction, cập nhật trạng thái, tra cứu lịch
 */

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

class AppointmentRepository {
    private PDO $pdo;

    public function __construct(?PDO $pdo = null) {
        $this->pdo = $pdo ?? Database::getConnection();
    }

    /**
     * Tạo lịch hẹn mới với cơ chế Transaction an toàn
     */
    public function create(array $data): int {
        $this->pdo->beginTransaction();

        try {
            // 1. Tìm hoặc tạo khách hàng (dựa trên số điện thoại)
            $stmtCustomer = $this->pdo->prepare('SELECT id FROM customers WHERE phone = :phone LIMIT 1');
            $stmtCustomer->execute(['phone' => $data['phone']]);
            $customerId = $stmtCustomer->fetchColumn();

            if (!$customerId) {
                $insCustomer = $this->pdo->prepare('INSERT INTO customers (full_name, phone, consent_at) VALUES (:name, :phone, NOW())');
                $insCustomer->execute([
                    'name'  => $data['owner_name'],
                    'phone' => $data['phone']
                ]);
                $customerId = (int)$this->pdo->lastInsertId();
            }

            // 2. Tìm hoặc tạo thú cưng
            $stmtPet = $this->pdo->prepare('SELECT id FROM pets WHERE customer_id = :cid AND name = :pname LIMIT 1');
            $stmtPet->execute([
                'cid'   => $customerId,
                'pname' => $data['pet_name']
            ]);
            $petId = $stmtPet->fetchColumn();

            if (!$petId) {
                $insPet = $this->pdo->prepare('INSERT INTO pets (customer_id, name, species) VALUES (:cid, :name, :species)');
                $insPet->execute([
                    'cid'     => $customerId,
                    'name'    => $data['pet_name'],
                    'species' => $data['pet_type'] ?? 'Chó'
                ]);
                $petId = (int)$this->pdo->lastInsertId();
            }

            // 3. Phân công nhân sự khả dụng (staff)
            $serviceId = (int)($data['service_id'] ?? 1);
            $startAt = $data['start_at'];
            $endAt = date('Y-m-d H:i:s', strtotime($startAt . ' +60 minutes'));

            // Chọn 1 nhân sự chưa có lịch tại thời điểm này
            $stmtStaff = $this->pdo->prepare('
                SELECT s.id FROM staff s
                WHERE s.is_active = 1
                AND s.id NOT IN (
                    SELECT a.staff_id FROM appointments a
                    WHERE a.start_at = :start_at AND a.status NOT IN ("cancelled")
                )
                ORDER BY s.id ASC LIMIT 1
            ');
            $stmtStaff->execute(['start_at' => $startAt]);
            $staffId = $stmtStaff->fetchColumn();

            if (!$staffId) {
                $staffId = 1; // Mặc định bác sĩ trưởng nếu phân công tự động
            }

            // 4. Lưu lịch hẹn
            $paymentMethod = $data['payment_method'] ?? 'at_store';
            $stmtApp = $this->pdo->prepare('
                INSERT INTO appointments (customer_id, pet_id, service_id, staff_id, start_at, end_at, status, note, source, payment_method, owner_name_direct, phone_direct, pet_name_direct, service_name_direct)
                VALUES (:cid, :pid, :sid, :staff_id, :start, :end, "pending", :note, "web", :pay_method, :owner_name, :phone, :pet_name, :service_name)
            ');
            $stmtApp->execute([
                'cid'          => $customerId,
                'pid'          => $petId,
                'sid'          => $serviceId,
                'staff_id'     => $staffId,
                'start'        => $startAt,
                'end'          => $endAt,
                'note'         => $data['note'] ?? '',
                'pay_method'   => $paymentMethod,
                'owner_name'   => $data['owner_name'] ?? '',
                'phone'        => $data['phone'] ?? '',
                'pet_name'     => $data['pet_name'] ?? '',
                'service_name' => $data['service_name'] ?? '',
            ]);
            $appointmentId = (int)$this->pdo->lastInsertId();

            $this->pdo->commit();
            return $appointmentId;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    /**
     * Lấy danh sách lịch hẹn (cho trang quản trị)
     */
    public function findAll(?string $status = null): array {
        $sql = '
            SELECT a.id, a.start_at, a.end_at, a.status, a.note, a.created_at,
                   a.payment_method, a.payment_status,
                   c.full_name as customer_name, c.phone as customer_phone,
                   p.name as pet_name, p.species as pet_species,
                   s.name as service_name, s.price as service_price,
                   st.full_name as staff_name
            FROM appointments a
            JOIN customers c ON a.customer_id = c.id
            JOIN pets p ON a.pet_id = p.id
            JOIN services s ON a.service_id = s.id
            JOIN staff st ON a.staff_id = st.id
        ';
        $params = [];
        if ($status) {
            $sql .= ' WHERE a.status = :status';
            $params['status'] = $status;
        }
        $sql .= ' ORDER BY a.start_at DESC';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Cập nhật trạng thái lịch hẹn
     */
    public function updateStatus(int $id, string $status): bool {
        $stmt = $this->pdo->prepare('UPDATE appointments SET status = :status WHERE id = :id');
        return $stmt->execute(['status' => $status, 'id' => $id]);
    }
}
