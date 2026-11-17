<?php
/**
 * API: api/appointments.php
 * Tiếp nhận yêu cầu đặt lịch hẹn, kiểm tra tính hợp lệ dữ liệu, ghi cơ sở dữ liệu
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
    echo json_encode(['success' => false, 'message' => 'Phương thức không được hỗ trợ']);
    exit;
}

require_once __DIR__ . '/../includes/AppointmentRepository.php';
require_once __DIR__ . '/../includes/validator.php';

// Đọc payload JSON hoặc POST form-data
$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    $input = $_POST;
}

$ownerName = trim($input['owner_name'] ?? $input['nm'] ?? '');
$phone     = trim($input['phone'] ?? $input['ph'] ?? '');
$petName   = trim($input['pet_name'] ?? $input['pn'] ?? '');
$petType   = trim($input['pet_type'] ?? $input['pt'] ?? 'Chó');
$serviceId = (int)($input['service_id'] ?? 1);
$serviceName = trim($input['service_name'] ?? $input['sv'] ?? 'Gói Spa & cắt tỉa');
$date      = trim($input['date'] ?? $input['dt'] ?? '');
$time      = trim($input['time'] ?? $input['tm'] ?? '09:30');
$note      = trim($input['note'] ?? '');
$paymentMethod = in_array($input['payment_method'] ?? '', ['at_store','bank_transfer'])
    ? $input['payment_method']
    : 'at_store';

// 1. Kiểm tra trường bắt buộc
if (!Validator::required($ownerName) || !Validator::required($petName) || !Validator::required($date)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Vui lòng điền đầy đủ tên chủ nuôi, tên bé và chọn ngày hẹn.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// 2. Kiểm tra số điện thoại 10 số bắt đầu bằng số 0
if (!Validator::phone($phone)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Số điện thoại cần đủ 10 số, bắt đầu bằng số 0.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// 3. Kiểm tra ngày trong tương lai
if (!Validator::futureDate($date)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Ngày hẹn không được chọn trong quá khứ.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $startAt = sprintf('%s %s:00', $date, $time);

    $repo = new AppointmentRepository();
    $appointmentId = $repo->create([
        'owner_name'      => $ownerName,
        'phone'           => $phone,
        'pet_name'        => $petName,
        'pet_type'        => $petType,
        'service_id'      => $serviceId,
        'start_at'        => $startAt,
        'note'            => $note,
        'payment_method'  => $paymentMethod,
    ]);

    // Định dạng ngày theo chuẩn Việt Nam DD/MM/YYYY
    $formattedDate = date('d/m/Y', strtotime($date));

    $baseMsg = sprintf(
        'Đã đặt lịch cho bé %s (%s): %s, lúc %s ngày %s. PawNest sẽ gọi %s để xác nhận trong 15-30 phút.',
        Validator::escape($petName),
        strtolower(Validator::escape($petType)),
        Validator::escape($serviceName),
        $time,
        $formattedDate,
        Validator::escape($phone)
    );

    echo json_encode([
        'success'          => true,
        'appointment_id'   => $appointmentId,
        'payment_method'   => $paymentMethod,
        'message'          => $baseMsg,
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Không thể đặt lịch: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
