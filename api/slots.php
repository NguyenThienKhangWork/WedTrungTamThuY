<?php
/**
 * API: api/slots.php?date=YYYY-MM-DD
 * Trả về các khung giờ còn trống trong ngày đã chọn (JSON)
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../includes/SlotRepository.php';
require_once __DIR__ . '/../includes/validator.php';

$date = $_GET['date'] ?? date('Y-m-d');
$serviceId = isset($_GET['service_id']) ? (int)$_GET['service_id'] : null;

if (!Validator::futureDate($date)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Không thể chọn ngày trong quá khứ'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $repo = new SlotRepository();
    $slots = $repo->freeSlots($date, $serviceId);

    echo json_encode([
        'success' => true,
        'date' => $date,
        'data' => $slots
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Lỗi hệ thống: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
