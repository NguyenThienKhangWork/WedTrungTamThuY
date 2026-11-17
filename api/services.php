<?php
/**
 * API: api/services.php
 * Trả về danh sách dịch vụ và bảng giá phòng khám
 */

declare(strict_types=1);

require_once __DIR__ . '/../controllers/ServiceController.php';

$controller = new ServiceController();
$controller->handleApiRequest();
