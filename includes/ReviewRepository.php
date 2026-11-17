<?php
/**
 * PawNest & CozyPaws - ReviewRepository
 * Quản lý đánh giá và lời chứng thực từ chủ nuôi
 */

declare(strict_types=1);

require_once __DIR__ . '/db.php';

class ReviewRepository {
    /**
     * Lấy các đánh giá đã được duyệt hiển thị công khai
     */
    public function findApproved(): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->query('
            SELECT r.id, r.rating, r.content, r.created_at,
                   c.full_name as customer_name,
                   p.name as pet_name, p.breed as pet_breed
            FROM reviews r
            JOIN appointments a ON r.appointment_id = a.id
            JOIN customers c ON a.customer_id = c.id
            JOIN pets p ON a.pet_id = p.id
            WHERE r.status = "approved"
            ORDER BY r.created_at DESC
        ');
        return $stmt->fetchAll();
    }
}
