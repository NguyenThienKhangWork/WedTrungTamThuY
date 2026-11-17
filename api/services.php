<?php
/**
 * API: api/services.php
 * Trả về danh sách dịch vụ và gói chăm sóc đang hoạt động (JSON)
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../includes/ServiceRepository.php';

try {
    $repo = new ServiceRepository();
    $services = $repo->findActive();

    echo json_encode([
        'success' => true,
        'data' => $services
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Lỗi hệ thống: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
