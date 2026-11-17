<?php
/**
 * PawNest & CozyPaws - Domain Model: Product
 * Đại diện cho sản phẩm, thức ăn, thuốc và vật tư y tế trong kho
 */

declare(strict_types=1);

class Product {
    public ?int $id;
    public string $sku;
    public string $name;
    public string $category;
    public float $price;
    public float $costPrice;
    public int $stockQuantity;
    public int $minStock;
    public string $unit;
    public string $image;
    public string $description;
    public bool $isCritical;
    public string $status;
    public ?string $createdAt;

    public function __construct(array $data = []) {
        $this->id            = isset($data['id']) ? (int)$data['id'] : null;
        $this->sku           = trim($data['sku'] ?? '');
        $this->name          = trim($data['name'] ?? '');
        $this->category      = $data['category'] ?? 'food';
        $this->price         = (float)($data['price'] ?? 0);
        $this->costPrice     = (float)($data['cost_price'] ?? 0);
        $this->stockQuantity = (int)($data['stock_quantity'] ?? 0);
        $this->minStock      = (int)($data['min_stock'] ?? 5);
        $this->unit          = trim($data['unit'] ?? 'Hộp');
        $this->image         = trim($data['image'] ?? '');
        $this->description   = trim($data['description'] ?? '');
        $this->isCritical    = !empty($data['is_critical']);
        $this->status        = $data['status'] ?? 'active';
        $this->createdAt     = $data['created_at'] ?? null;
    }

    /**
     * Kiểm tra có đang ở mức cảnh báo tồn kho thấp hay không
     */
    public function isLowStock(): bool {
        return $this->stockQuantity <= $this->minStock;
    }

    /**
     * Thuốc hoặc vắc xin quan trọng cần giám sát chặt chẽ
     */
    public function isCriticalDrug(): bool {
        return $this->isCritical && $this->category === 'medicine';
    }

    /**
     * Định dạng giá tiền VNĐ
     */
    public function formatPrice(): string {
        return number_format($this->price, 0, ',', '.') . ' ₫';
    }

    /**
     * Kiểm tra xem còn đủ tồn kho để đặt số lượng này không
     */
    public function canFulfill(int $quantity): bool {
        return $this->status === 'active' && $this->stockQuantity >= $quantity && $quantity > 0;
    }

    public function toArray(): array {
        return [
            'id'             => $this->id,
            'sku'            => $this->sku,
            'name'           => $this->name,
            'category'       => $this->category,
            'price'          => $this->price,
            'cost_price'     => $this->costPrice,
            'stock_quantity' => $this->stockQuantity,
            'min_stock'      => $this->minStock,
            'unit'           => $this->unit,
            'image'          => $this->image,
            'description'    => $this->description,
            'is_critical'    => $this->isCritical,
            'is_low_stock'   => $this->isLowStock(),
            'status'         => $this->status,
            'created_at'     => $this->createdAt,
        ];
    }
}
