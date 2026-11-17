<?php
/**
 * PawNest & CozyPaws - Product & Inventory Repository
 * Quản lý hàng hóa, thuốc, thức ăn, vật tư tiêu hao và lịch sử nhập xuất kho
 */

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

class ProductRepository
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? Database::getConnection();
    }

    /**
     * Lấy danh sách sản phẩm có lọc theo danh mục hoặc chỉ lấy tồn kho thấp
     */
    public function findAll(?string $category = null, bool $lowStockOnly = false, ?string $search = null): array
    {
        $sql = 'SELECT * FROM products WHERE 1=1';
        $params = [];

        if ($category && in_array($category, ['medicine', 'food', 'supply', 'accessory'], true)) {
            $sql .= ' AND category = :category';
            $params['category'] = $category;
        }

        if ($lowStockOnly) {
            $sql .= ' AND stock_quantity <= min_stock';
        }

        if ($search && trim($search) !== '') {
            $sql .= ' AND (name LIKE :s1 OR sku LIKE :s2)';
            $params['s1'] = '%' . trim($search) . '%';
            $params['s2'] = '%' . trim($search) . '%';
        }

        // Ưu tiên thuốc quan trọng và tồn kho thấp lên trước
        $sql .= ' ORDER BY is_critical DESC, (stock_quantity <= min_stock) DESC, id DESC';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Lấy các loại thuốc/vắc xin quan trọng đang bị cảnh báo tồn kho thấp
     */
    public function findCriticalLowStock(): array
    {
        $stmt = $this->pdo->query('
            SELECT * FROM products 
            WHERE is_critical = 1 AND stock_quantity <= min_stock AND status = "active"
            ORDER BY stock_quantity ASC
        ');
        return $stmt->fetchAll();
    }

    /**
     * Tìm sản phẩm theo ID
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM products WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /**
     * Tạo sản phẩm mới
     */
    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO products (sku, name, category, price, cost_price, stock_quantity, min_stock, unit, image, description, is_critical, status)
            VALUES (:sku, :name, :category, :price, :cost_price, :stock_quantity, :min_stock, :unit, :image, :description, :is_critical, :status)
        ');

        $stmt->execute([
            'sku'            => strtoupper(trim($data['sku'] ?? 'SP-' . time())),
            'name'           => trim($data['name'] ?? ''),
            'category'       => $data['category'] ?? 'food',
            'price'          => (float)($data['price'] ?? 0),
            'cost_price'     => (float)($data['cost_price'] ?? 0),
            'stock_quantity' => (int)($data['stock_quantity'] ?? 0),
            'min_stock'      => (int)($data['min_stock'] ?? 5),
            'unit'           => trim($data['unit'] ?? 'Hộp'),
            'image'          => trim($data['image'] ?? ''),
            'description'    => trim($data['description'] ?? ''),
            'is_critical'    => !empty($data['is_critical']) ? 1 : 0,
            'status'         => $data['status'] ?? 'active'
        ]);

        $newId = (int)$this->pdo->lastInsertId();

        // Ghi log nhập đầu vào nếu có số lượng tồn kho ban đầu > 0
        if (!empty($data['stock_quantity']) && (int)$data['stock_quantity'] > 0) {
            $this->logTransaction($newId, 'import', (int)$data['stock_quantity'], 0, (int)$data['stock_quantity'], 'Khởi tạo mặt hàng mới');
        }

        return $newId;
    }

    /**
     * Cập nhật thông tin sản phẩm
     */
    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare('
            UPDATE products SET
                sku = :sku,
                name = :name,
                category = :category,
                price = :price,
                cost_price = :cost_price,
                min_stock = :min_stock,
                unit = :unit,
                image = :image,
                description = :description,
                is_critical = :is_critical,
                status = :status
            WHERE id = :id
        ');

        return $stmt->execute([
            'id'          => $id,
            'sku'         => strtoupper(trim($data['sku'] ?? '')),
            'name'        => trim($data['name'] ?? ''),
            'category'    => $data['category'] ?? 'food',
            'price'       => (float)($data['price'] ?? 0),
            'cost_price'  => (float)($data['cost_price'] ?? 0),
            'min_stock'   => (int)($data['min_stock'] ?? 5),
            'unit'        => trim($data['unit'] ?? 'Hộp'),
            'image'       => trim($data['image'] ?? ''),
            'description' => trim($data['description'] ?? ''),
            'is_critical' => !empty($data['is_critical']) ? 1 : 0,
            'status'      => $data['status'] ?? 'active'
        ]);
    }

    /**
     * Điều chỉnh kho (Nhập hàng, Xuất dùng, Bán lẻ, Kiểm kê)
     * Đảm bảo tính nhất quán qua Database Transaction
     */
    public function adjustStock(int $productId, string $changeType, int $qty, string $note = '', string $createdBy = 'Bác sĩ Khang'): bool
    {
        if ($qty <= 0) {
            throw new InvalidArgumentException('Số lượng phải lớn hơn 0.');
        }

        $this->pdo->beginTransaction();
        try {
            // Khóa dòng sản phẩm để đọc tồn kho chính xác
            $stmt = $this->pdo->prepare('SELECT stock_quantity, name FROM products WHERE id = :id FOR UPDATE');
            $stmt->execute(['id' => $productId]);
            $product = $stmt->fetch();

            if (!$product) {
                throw new RuntimeException('Không tìm thấy sản phẩm.');
            }

            $currentStock = (int)$product['stock_quantity'];
            $newStock = $currentStock;

            if ($changeType === 'import') {
                $newStock = $currentStock + $qty;
            } elseif (in_array($changeType, ['export', 'sale'], true)) {
                if ($currentStock < $qty) {
                    throw new RuntimeException("Số lượng tồn kho không đủ để xuất (Hiện còn: {$currentStock}, yêu cầu: {$qty}).");
                }
                $newStock = $currentStock - $qty;
            } elseif ($changeType === 'adjustment') {
                $newStock = $qty; // Điều chỉnh thẳng số lượng tồn
            }

            // Cập nhật tồn kho mới
            $updateStmt = $this->pdo->prepare('UPDATE products SET stock_quantity = :stock WHERE id = :id');
            $updateStmt->execute(['stock' => $newStock, 'id' => $productId]);

            // Ghi nhật ký vào inventory_logs
            $this->logTransaction($productId, $changeType, $qty, $currentStock, $newStock, $note, $createdBy);

            $this->pdo->commit();
            return true;
        } catch (Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    /**
     * Ghi nhật ký lịch sử nhập xuất
     */
    private function logTransaction(int $productId, string $type, int $qty, int $before, int $after, string $note = '', string $createdBy = 'Hệ thống'): void
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO inventory_logs (product_id, change_type, quantity, stock_before, stock_after, note, created_by)
            VALUES (:pid, :type, :qty, :before, :after, :note, :by)
        ');
        $stmt->execute([
            'pid'    => $productId,
            'type'   => $type,
            'qty'    => $qty,
            'before' => $before,
            'after'  => $after,
            'note'   => $note,
            'by'     => $createdBy
        ]);
    }

    /**
     * Lấy nhật ký nhập xuất kho gần đây
     */
    public function getLogs(?int $productId = null, int $limit = 50): array
    {
        $sql = '
            SELECT l.*, p.name as product_name, p.sku, p.unit, p.category, p.is_critical
            FROM inventory_logs l
            JOIN products p ON l.product_id = p.id
        ';
        $params = [];

        if ($productId !== null) {
            $sql .= ' WHERE l.product_id = :pid';
            $params['pid'] = $productId;
        }

        $sql .= ' ORDER BY l.id DESC LIMIT ' . (int)$limit;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Thống kê tổng hợp kho hàng
     */
    public function getStats(): array
    {
        $totalItems = (int)$this->pdo->query('SELECT COUNT(*) FROM products WHERE status = "active"')->fetchColumn();
        $totalUnits = (int)$this->pdo->query('SELECT COALESCE(SUM(stock_quantity), 0) FROM products WHERE status = "active"')->fetchColumn();
        $totalValue = (float)$this->pdo->query('SELECT COALESCE(SUM(stock_quantity * cost_price), 0) FROM products WHERE status = "active"')->fetchColumn();
        $lowStockCount = (int)$this->pdo->query('SELECT COUNT(*) FROM products WHERE stock_quantity <= min_stock AND status = "active"')->fetchColumn();
        $criticalLowCount = (int)$this->pdo->query('SELECT COUNT(*) FROM products WHERE is_critical = 1 AND stock_quantity <= min_stock AND status = "active"')->fetchColumn();

        return [
            'total_items'       => $totalItems,
            'total_units'       => $totalUnits,
            'total_value'       => $totalValue,
            'low_stock_count'   => $lowStockCount,
            'critical_low_count'=> $criticalLowCount
        ];
    }
}
