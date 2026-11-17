<?php
/**
 * API: api/shop_order.php
 * Endpoint tiếp nhận đơn đặt mua thuốc, thức ăn và vật tư online
 */

declare(strict_types=1);

require_once __DIR__ . '/../controllers/ShopController.php';

$controller = new ShopController();
$controller->handleOrderApiRequest();
