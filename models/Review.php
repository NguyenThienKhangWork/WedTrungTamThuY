<?php
/**
 * PawNest & CozyPaws - Domain Model: Review
 * Đại diện cho đánh giá của khách hàng / chủ nuôi
 */

declare(strict_types=1);

class Review {
    public ?int $id;
    public int $appointmentId;
    public int $rating;
    public string $content;
    public string $status;
    public string $customerName;
    public string $petName;
    public ?string $createdAt;

    public function __construct(array $data = []) {
        $this->id            = isset($data['id']) ? (int)$data['id'] : null;
        $this->appointmentId = (int)($data['appointment_id'] ?? 0);
        $this->rating        = max(1, min(5, (int)($data['rating'] ?? 5)));
        $this->content       = trim($data['content'] ?? '');
        $this->status        = $data['status'] ?? 'pending';
        $this->customerName  = trim($data['customer_name'] ?? '');
        $this->petName       = trim($data['pet_name'] ?? '');
        $this->createdAt     = $data['created_at'] ?? null;
    }

    public function getStarsHtml(): string {
        $html = '';
        for ($i = 1; $i <= 5; $i++) {
            $html .= ($i <= $this->rating) ? '★' : '☆';
        }
        return $html;
    }
}
