<?php
/**
 * PawNest & CozyPaws - Controller: ShopController
 * Điều phối nghiệp vụ bán hàng, tạo đơn hàng, quản lý xuất nhập tồn kho và cảnh báo thuốc thiết yếu
 */

declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../repository/ProductRepository.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../includes/validator.php';

class ShopController {
    private ProductRepository $productRepo;

    public function __construct() {
        $this->productRepo = new ProductRepository();
    }

    /**
     * Xử lý đặt mua sản phẩm online qua API (/api/shop_order.php)
     */
    public function handleOrderApiRequest(): void {
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

        $raw = file_get_contents('php://input');
        $input = json_decode($raw, true) ?: $_POST;

        $productId       = (int)($input['product_id'] ?? 0);
        $quantity        = (int)($input['quantity'] ?? 1);
        $customerName    = trim($input['customer_name'] ?? '');
        $customerPhone   = trim($input['customer_phone'] ?? '');
        $customerAddress = trim($input['customer_address'] ?? 'Nhận tại quầy PawNest');
        $paymentMethod   = $input['payment_method'] ?? 'at_store';
        $notes           = trim($input['notes'] ?? '');

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
            echo json_encode(['success' => false, 'message' => 'Số điện thoại cần đủ 10 chữ số và bắt đầu bằng số 0.'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $product = $this->productRepo->findById($productId);
        if (!$product) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại.'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $stock = (int)$product['stock_quantity'];
        if ($stock < $quantity) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => "Rất tiếc! Mặt hàng '{$product['name']}' hiện chỉ còn {$stock} {$product['unit']} trong kho, không đủ số lượng {$quantity} bạn yêu cầu."
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        try {
            // Trừ kho tự động và ghi nhật ký
            $orderCode = 'ORDER-' . strtoupper(substr(uniqid(), -6));
            $this->productRepo->adjustStock(
                $productId,
                'sale',
                $quantity,
                "Khách đặt online {$orderCode}: {$customerName} ({$customerPhone})",
                'Khách mua online'
            );

            $totalAmount = (float)$product['price'] * $quantity;

            // Sinh dữ liệu thanh toán VietQR nếu chọn chuyển khoản
            $vietqrData = null;
            if ($paymentMethod === 'bank_transfer') {
                $memo = $orderCode . ' ' . preg_replace('/[^0-9]/', '', $customerPhone);
                $qrUrl = sprintf(
                    'https://img.vietqr.io/image/970436-1051374267-compact2.png?amount=%d&addInfo=%s&accountName=%s',
                    $totalAmount,
                    urlencode($memo),
                    urlencode('NGUYEN THIEN KHANG')
                );

                $vietqrData = [
                    'bank_id'        => '970436',
                    'bank_name'      => 'Vietcombank',
                    'account_number' => '1051374267',
                    'account_holder' => 'NGUYEN THIEN KHANG',
                    'amount'         => $totalAmount,
                    'memo'           => $memo,
                    'qr_url'         => $qrUrl
                ];
            }

            echo json_encode([
                'success'      => true,
                'message'      => "Đặt hàng thành công! Mã đơn: {$orderCode}. PawNest sẽ liên hệ giao hàng sớm nhất.",
                'order_code'   => $orderCode,
                'product_name' => $product['name'],
                'quantity'     => $quantity,
                'total_amount' => $totalAmount,
                'vietqr'       => $vietqrData
            ], JSON_UNESCAPED_UNICODE);

        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Lỗi khi xử lý đơn hàng: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Lấy danh sách sản phẩm
     */
    public function getProducts(?string $category = null, bool $lowStockOnly = false, ?string $search = null): array {
        return $this->productRepo->findAll($category, $lowStockOnly, $search);
    }

    /**
     * Lấy danh sách cảnh báo thuốc/vắc xin sắp hết
     */
    public function getCriticalAlerts(): array {
        return $this->productRepo->findCriticalLowStock();
    }

    /**
     * Thống kê kho hàng
     */
    public function getStats(): array {
        return $this->productRepo->getStats();
    }
}
