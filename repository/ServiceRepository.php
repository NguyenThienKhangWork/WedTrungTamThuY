<?php
/**
 * PawNest & CozyPaws - ServiceRepository
 * Quản lý dữ liệu dịch vụ và bảng giá
 */

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

class ServiceRepository {
    private PDO $pdo;

    public function __construct(?PDO $pdo = null) {
        $this->pdo = $pdo ?? Database::getConnection();
    }

    /**
     * Lấy toàn bộ dịch vụ & gói đang hoạt động
     */
    public function findActive(): array {
        $stmt = $this->pdo->query('SELECT id, name, description, duration_min, price, is_package FROM services WHERE is_active = 1 ORDER BY is_package DESC, id ASC');
        return $stmt->fetchAll();
    }

    /**
     * Tìm dịch vụ theo ID
     */
    public function findById(int $id): ?array {
        $stmt = $this->pdo->prepare('SELECT * FROM services WHERE id = :id AND is_active = 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
}
