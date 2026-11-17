<?php
/**
 * API: api/appointments.php
 * Endpoint tiếp nhận yêu cầu đặt lịch hẹn, kiểm tra dữ liệu và sinh mã thanh toán VietQR
 */

declare(strict_types=1);

require_once __DIR__ . '/../controllers/AppointmentController.php';

$controller = new AppointmentController();
$controller->handleApiRequest();
