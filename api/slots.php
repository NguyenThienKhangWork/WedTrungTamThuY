<?php
/**
 * API: api/slots.php
 * Trả về danh sách khung giờ còn trống trong ngày
 */

declare(strict_types=1);

require_once __DIR__ . '/../controllers/AppointmentController.php';

$controller = new AppointmentController();
$controller->handleSlotsRequest();
