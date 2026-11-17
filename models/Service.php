<?php
/**
 * PawNest & CozyPaws - Domain Model: Service
 * Đại diện cho dịch vụ khám chữa bệnh và spa thú cưng
 */

declare(strict_types=1);

class Service {
    public ?int $id;
    public string $name;
    public string $description;
    public int $durationMin;
    public float $price;
    public bool $isPackage;
    public bool $isActive;

    public function __construct(array $data = []) {
        $this->id          = isset($data['id']) ? (int)$data['id'] : null;
        $this->name        = trim($data['name'] ?? '');
        $this->description = trim($data['description'] ?? '');
        $this->durationMin = (int)($data['duration_min'] ?? 45);
        $this->price       = (float)($data['price'] ?? 0);
        $this->isPackage   = !empty($data['is_package']);
        $this->isActive    = !empty($data['is_active']);
    }

    public function formatPrice(): string {
        return number_format($this->price, 0, ',', '.') . ' ₫';
    }
}
