<?php
/**
 * PawNest & CozyPaws - Domain Model: Appointment
 * Đại diện thực thể lịch hẹn dịch vụ thú y
 */

declare(strict_types=1);

class Appointment {
    public ?int $id;
    public string $ownerName;
    public string $phone;
    public string $petName;
    public string $petType;
    public int $serviceId;
    public string $serviceName;
    public string $startAt;
    public string $endAt;
    public string $status;
    public string $note;
    public string $paymentMethod;
    public string $paymentStatus;
    public ?string $createdAt;

    public function __construct(array $data = []) {
        $this->id            = isset($data['id']) ? (int)$data['id'] : null;
        $this->ownerName     = trim($data['owner_name'] ?? $data['owner_name_direct'] ?? $data['customer_name'] ?? '');
        $this->phone         = trim($data['phone'] ?? $data['phone_direct'] ?? $data['customer_phone'] ?? '');
        $this->petName       = trim($data['pet_name'] ?? $data['pet_name_direct'] ?? '');
        $this->petType       = trim($data['pet_type'] ?? $data['pet_species'] ?? 'Chó');
        $this->serviceId     = (int)($data['service_id'] ?? 1);
        $this->serviceName   = trim($data['service_name'] ?? $data['service_name_direct'] ?? '');
        $this->startAt       = $data['start_at'] ?? '';
        $this->endAt         = $data['end_at'] ?? '';
        $this->status        = $data['status'] ?? 'pending';
        $this->note          = trim($data['note'] ?? '');
        $this->paymentMethod = $data['payment_method'] ?? 'at_store';
        $this->paymentStatus = $data['payment_status'] ?? 'pending';
        $this->createdAt     = $data['created_at'] ?? null;
    }

    /**
     * Kiểm tra tính hợp lệ của dữ liệu lịch hẹn
     */
    public function validate(): array {
        $errors = [];
        if (empty($this->ownerName)) {
            $errors['owner_name'] = 'Họ tên chủ nuôi không được để trống.';
        }
        if (!preg_match('/^0\d{9}$/', $this->phone)) {
            $errors['phone'] = 'Số điện thoại phải đủ 10 chữ số và bắt đầu bằng số 0.';
        }
        if (empty($this->petName)) {
            $errors['pet_name'] = 'Tên bé thú cưng không được để trống.';
        }
        if (empty($this->startAt)) {
            $errors['start_at'] = 'Vui lòng chọn ngày và giờ hẹn.';
        }
        return $errors;
    }

    public function isPaid(): bool {
        return $this->paymentStatus === 'paid';
    }

    public function toArray(): array {
        return [
            'id'             => $this->id,
            'owner_name'     => $this->ownerName,
            'phone'          => $this->phone,
            'pet_name'       => $this->petName,
            'pet_type'       => $this->petType,
            'service_id'     => $this->serviceId,
            'service_name'   => $this->serviceName,
            'start_at'       => $this->startAt,
            'end_at'         => $this->endAt,
            'status'         => $this->status,
            'note'           => $this->note,
            'payment_method' => $this->paymentMethod,
            'payment_status' => $this->paymentStatus,
            'created_at'     => $this->createdAt,
        ];
    }
}
