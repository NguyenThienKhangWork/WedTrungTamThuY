<?php
/**
 * API: api/customer_auth.php
 * Endpoint xác thực khách hàng (Đăng ký, Đăng nhập, Đăng xuất, Kiểm tra session)
 */

declare(strict_types=1);

require_once __DIR__ . '/../controllers/AuthController.php';

$controller = new AuthController();
$controller->handleCustomerApiRequest();
