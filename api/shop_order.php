<?php
/**
 * API: api/shop_order.php
 * Xử lý đơn đặt mua thức ăn, thuốc và vật tư thú cưng (Frontend Store Order)
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Phương thức không được hỗ trợ.'], JSON_UNESCAPED_UNICODE);
    exit;
}

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/validator.php';
require_once __DIR__ . '/../includes/ProductRepository.php';

$raw = file_get_contents('php://input');
$input = json_decode($raw, true) ?: $_POST;

$productId      = (int)($input['product_id'] ?? 0);
$quantity       = (int)($input['quantity'] ?? 1);
$customerName   = trim($input['customer_name'] ?? '');
$customerPhone  = trim($input['customer_phone'] ?? '');
$customerAddress= trim($input['customer_address'] ?? 'Nhận tại quầy PawNest');
$paymentMethod  = $input['payment_method'] ?? 'at_store';
$notes          = trim($input['notes'] ?? '');

if ($productId <= 0 || $quantity <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Sản phẩm hoặc số lượng không hợp lệ.'], JSON_UNESCAPED_UNICODE);
    exit;
}

if (!Validator::required($customerName) || !Validator::required($customerPhone)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Vui lòng cung cấp họ tên và số điện thoại.'], JSON_UNESCAPED_UNICODE);
    exit;
}

if (!Validator::phone($customerPhone)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Số điện thoại không hợp lệ (cần 10 số, bắt đầu bằng 0).'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $repo = new ProductRepository();
    $product = $repo->findById($productId);

    if (!$product) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Không tìm thấy sản phẩm này trong kho.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($product['stock_quantity'] < $quantity) {
        http_response_code(400);
        echo json_encode([
            'success' => false, 
            'message' => "Rất tiếc, sản phẩm '{$product['name']}' hiện chỉ còn {$product['stock_quantity']} {$product['unit']} trong kho."
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Trừ kho và ghi nhận lịch sử xuất bán
    $noteLog = "Khách đặt mua online: {$customerName} ({$customerPhone}) - Đ/c: {$customerAddress}";
    if ($notes !== '') {
        $noteLog .= " - Ghi chú: {$notes}";
    }
    $repo->adjustStock($productId, 'sale', $quantity, $noteLog, 'Khách đặt online');

    $totalAmount = (float)$product['price'] * $quantity;
    $orderCode = 'PN' . date('ymd') . rand(100, 999);

    echo json_encode([
        'success'        => true,
        'message'        => "Đặt mua thành công {$quantity} {$product['unit']} {$product['name']}!",
        'order_code'     => $orderCode,
        'product_name'   => $product['name'],
        'quantity'       => $quantity,
        'unit'           => $product['unit'],
        'total_amount'   => $totalAmount,
        'payment_method' => $paymentMethod,
        'customer_name'  => $customerName,
        'customer_phone' => $customerPhone,
        'qr_account'     => '1051374267',
        'qr_bank'        => 'VCB',
        'qr_name'        => 'NGUYEN THIEN KHANG'
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Lỗi xử lý đơn hàng: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
