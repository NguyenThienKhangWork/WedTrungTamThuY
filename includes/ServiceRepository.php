<?php
/**
 * PawNest & CozyPaws - ServiceRepository
 * Quản lý dữ liệu dịch vụ và bảng giá
 */

declare(strict_types=1);

require_once __DIR__ . '/db.php';

class ServiceRepository {
    /**
     * Lấy toàn bộ dịch vụ & gói đang hoạt động
     */
    public function findActive(): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->query('SELECT id, name, description, duration_min, price, is_package FROM services WHERE is_active = 1 ORDER BY is_package DESC, id ASC');
        return $stmt->fetchAll();
    }

    /**
     * Tìm dịch vụ theo ID
     */
    public function findById(int $id): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM services WHERE id = :id AND is_active = 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
}
