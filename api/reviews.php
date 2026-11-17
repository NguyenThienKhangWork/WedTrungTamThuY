<?php
/**
 * API: api/reviews.php
 * Trả về danh sách đánh giá từ chủ nuôi đã được phê duyệt (JSON)
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../includes/ReviewRepository.php';

try {
    $repo = new ReviewRepository();
    $reviews = $repo->findApproved();

    echo json_encode([
        'success' => true,
        'data' => $reviews
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Lỗi hệ thống: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
