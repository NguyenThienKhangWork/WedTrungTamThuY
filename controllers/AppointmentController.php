<?php
/**
 * PawNest & CozyPaws - Controller: AppointmentController
 * Điều phối nghiệp vụ đặt lịch hẹn, kiểm tra trùng slot, thanh toán VietQR và cập nhật trạng thái
 */

declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../repository/AppointmentRepository.php';
require_once __DIR__ . '/../repository/SlotRepository.php';
require_once __DIR__ . '/../models/Appointment.php';
require_once __DIR__ . '/../includes/validator.php';

class AppointmentController {
    private AppointmentRepository $appointmentRepo;
    private SlotRepository $slotRepo;

    public function __construct() {
        $this->appointmentRepo = new AppointmentRepository();
        $this->slotRepo = new SlotRepository();
    }

    /**
     * Xử lý request API đặt lịch hẹn (/api/appointments.php)
     */
    public function handleApiRequest(): void {
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
            echo json_encode(['success' => false, 'message' => 'Phương thức không được hỗ trợ.']);
            exit;
        }

        $raw = file_get_contents('php://input');
        $input = json_decode($raw, true) ?: $_POST;

        $ownerName   = trim($input['owner_name'] ?? $input['nm'] ?? '');
        $phone       = trim($input['phone'] ?? $input['ph'] ?? '');
        $petName     = trim($input['pet_name'] ?? $input['pn'] ?? '');
        $petType     = trim($input['pet_type'] ?? $input['pt'] ?? 'Chó');
        $serviceId   = (int)($input['service_id'] ?? 1);
        $serviceName = trim($input['service_name'] ?? $input['sv'] ?? 'Gói Spa & cắt tỉa');
        $date        = trim($input['date'] ?? $input['dt'] ?? '');
        $time        = trim($input['time'] ?? $input['tm'] ?? '09:30');
        $note        = trim($input['note'] ?? '');
        $paymentMethod = in_array($input['payment_method'] ?? '', ['at_store', 'bank_transfer'], true)
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

        // 2. Kiểm tra số điện thoại 10 số bắt đầu bằng 0
        if (!Validator::phone($phone)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Số điện thoại không hợp lệ (cần 10 số, bắt đầu bằng 0).'
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // 3. Kiểm tra ngày không được ở quá khứ
        $today = date('Y-m-d');
        if ($date < $today) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Ngày hẹn không thể ở quá khứ.'
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // 4. Ghép start_at và lưu qua Repository
        $startAt = sprintf('%s %s:00', $date, $time);

        try {
            $appointmentId = $this->appointmentRepo->create([
                'owner_name'     => $ownerName,
                'phone'          => $phone,
                'pet_name'       => $petName,
                'pet_type'       => $petType,
                'service_id'     => $serviceId,
                'service_name'   => $serviceName,
                'start_at'       => $startAt,
                'note'           => $note,
                'payment_method' => $paymentMethod
            ]);

            // Sinh dữ liệu thanh toán VietQR nếu chọn chuyển khoản
            $vietqrData = null;
            if ($paymentMethod === 'bank_transfer') {
                $servicePrices = [1 => 150000, 2 => 320000, 3 => 690000];
                $amount = $servicePrices[$serviceId] ?? 320000;
                $memo = 'PAWNEST ' . $appointmentId . ' ' . preg_replace('/[^0-9]/', '', $phone);
                $qrUrl = sprintf(
                    'https://img.vietqr.io/image/970436-1051374267-compact2.png?amount=%d&addInfo=%s&accountName=%s',
                    $amount,
                    urlencode($memo),
                    urlencode('NGUYEN THIEN KHANG')
                );

                $vietqrData = [
                    'bank_id'        => '970436',
                    'bank_name'      => 'Vietcombank',
                    'account_number' => '1051374267',
                    'account_holder' => 'NGUYEN THIEN KHANG',
                    'amount'         => $amount,
                    'memo'           => $memo,
                    'qr_url'         => $qrUrl
                ];
            }

            http_response_code(201);
            echo json_encode([
                'success'        => true,
                'message'        => "Đặt lịch thành công! Mã cuộc hẹn #{$appointmentId}. PawNest sẽ gọi xác nhận qua số {$phone}.",
                'appointment_id' => $appointmentId,
                'vietqr'         => $vietqrData
            ], JSON_UNESCAPED_UNICODE);

        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Lỗi hệ thống khi lưu lịch hẹn: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Lấy các khung giờ trống (/api/slots.php)
     */
    public function handleSlotsRequest(): void {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');

        $date = $_GET['date'] ?? date('Y-m-d');
        $serviceId = isset($_GET['service_id']) ? (int)$_GET['service_id'] : null;

        $slots = $this->slotRepo->freeSlots($date, $serviceId);
        echo json_encode([
            'success' => true,
            'date'    => $date,
            'slots'   => $slots
        ], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Lấy danh sách lịch hẹn cho trang quản trị
     */
    public function listAppointments(?string $status = null): array {
        return $this->appointmentRepo->findAll($status);
    }

    /**
     * Cập nhật trạng thái cuộc hẹn
     */
    public function updateStatus(int $id, string $status): bool {
        return $this->appointmentRepo->updateStatus($id, $status);
    }
}
