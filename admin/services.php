<?php
/**
 * PawNest - Quản lý Dịch vụ & Giá (Mục 2.10, FR-12, FR-92)
 * Thêm, sửa giá, ẩn/hiện dịch vụ mà không cần lập trình
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/auth.php';
Auth::requireRole(['admin']);

$pdo = Database::getConnection();
$message = '';

// Xử lý cập nhật giá hoặc trạng thái
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'toggle_active') {
        $id = (int)($_POST['id'] ?? 0);
        $current = (int)($_POST['current'] ?? 1);
        $newStatus = $current === 1 ? 0 : 1;
        $stmt = $pdo->prepare('UPDATE services SET is_active = ? WHERE id = ?');
        $stmt->execute([$newStatus, $id]);
        $message = 'Đã cập nhật trạng thái hiển thị dịch vụ!';
    } elseif ($action === 'update_price') {
        $id = (int)($_POST['id'] ?? 0);
        $price = (float)($_POST['price'] ?? 0);
        if ($price > 0) {
            $stmt = $pdo->prepare('UPDATE services SET price = ? WHERE id = ?');
            $stmt->execute([$price, $id]);
            $message = 'Đã cập nhật giá dịch vụ thành công!';
        }
    } elseif ($action === 'add_service') {
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $duration = (int)($_POST['duration_min'] ?? 60);
        $price = (float)($_POST['price'] ?? 0);
        $is_package = isset($_POST['is_package']) ? 1 : 0;
        
        if ($name && $price > 0) {
            $stmt = $pdo->prepare('INSERT INTO services (name, description, duration_min, price, is_package, is_active) VALUES (?, ?, ?, ?, ?, 1)');
            $stmt->execute([$name, $description, $duration, $price, $is_package]);
            $message = 'Đã thêm dịch vụ mới thành công!';
        }
    }
}

$services = $pdo->query('SELECT * FROM services ORDER BY is_package ASC, id ASC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý Dịch vụ & Bảng giá – PawNest Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Nunito', sans-serif; }
    h1, h2, h3 { font-family: 'Baloo 2', cursive, sans-serif; }
  </style>
</head>
<body class="bg-[#F8FAF7] text-gray-800 min-h-screen">
  <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between sticky top-0 z-30">
    <div class="flex items-center gap-3">
      <span class="text-2xl">🐾</span>
      <div>
        <h1 class="text-lg font-bold text-[#1a3d1a]">PawNest Admin – Dịch vụ & Giá</h1>
        <p class="text-xs text-gray-500">Người dùng: <strong><?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></strong></p>
      </div>
    </div>
    <div class="flex items-center gap-4 text-xs font-semibold">
      <a href="/admin/dashboard.php" class="text-gray-600 hover:text-[#1a3d1a]">← Bảng điều khiển</a>
      <a href="/admin/inventory.php" class="text-amber-700 font-bold hover:underline">📦 Kho & Thuốc</a>
      <a href="/admin/appointments.php" class="text-gray-600 hover:text-[#1a3d1a]">Lịch hẹn</a>
      <a href="/admin/gallery.php" class="text-gray-600 hover:text-[#1a3d1a]">Thư viện</a>
      <a href="/admin/reviews.php" class="text-gray-600 hover:text-[#1a3d1a]">Đánh giá</a>
      <a href="/index.php" target="_blank" class="text-emerald-700 hover:underline">Xem Trang chủ</a>
    </div>
  </header>

  <main class="max-w-6xl mx-auto p-6 space-y-6">
    <?php if ($message): ?>
      <div class="p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-xs font-semibold">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>

    <!-- Form thêm dịch vụ mới (FR-12) -->
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-xs">
      <h3 class="font-bold text-sm text-[#1a3d1a] mb-4">➕ Thêm Dịch Vụ Mới</h3>
      <form method="POST" class="grid grid-cols-1 sm:grid-cols-5 gap-3 items-end text-xs">
        <input type="hidden" name="action" value="add_service" />
        <div class="sm:col-span-2">
          <label class="block font-semibold text-gray-600 mb-1">Tên dịch vụ *</label>
          <input type="text" name="name" placeholder="Ví dụ: Tẩy uế chuồng trại..." required class="w-full px-3 py-2 rounded-xl border border-gray-200" />
        </div>
        <div>
          <label class="block font-semibold text-gray-600 mb-1">Giá (VNĐ) *</label>
          <input type="number" name="price" placeholder="150000" required class="w-full px-3 py-2 rounded-xl border border-gray-200" />
        </div>
        <div>
          <label class="block font-semibold text-gray-600 mb-1">Thời lượng (phút)</label>
          <input type="number" name="duration_min" value="60" class="w-full px-3 py-2 rounded-xl border border-gray-200" />
        </div>
        <div>
          <button type="submit" class="w-full py-2 bg-[#1a3d1a] hover:bg-[#2a5a2a] text-white font-bold rounded-xl cursor-pointer">
            Lưu dịch vụ
          </button>
        </div>
      </form>
    </div>

    <!-- Danh sách dịch vụ hiện có -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
      <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-bold text-sm text-[#1a3d1a]">Danh Sách Dịch Vụ Đang Quản Lý (<?= count($services) ?>)</h3>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-xs text-left">
          <thead class="bg-gray-50 text-gray-500 font-semibold uppercase text-[10px] border-b border-gray-100">
            <tr>
              <th class="px-6 py-3">ID</th>
              <th class="px-6 py-3">Tên Dịch Vụ</th>
              <th class="px-6 py-3">Loại</th>
              <th class="px-6 py-3">Thời lượng</th>
              <th class="px-6 py-3">Giá Hiện Tại</th>
              <th class="px-6 py-3">Trạng thái</th>
              <th class="px-6 py-3 text-right">Thao tác</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <?php foreach ($services as $s): ?>
              <tr class="hover:bg-gray-50/50">
                <td class="px-6 py-3 font-mono text-gray-400">#<?= $s['id'] ?></td>
                <td class="px-6 py-3 font-bold text-[#1a3d1a]"><?= htmlspecialchars($s['name']) ?></td>
                <td class="px-6 py-3">
                  <span class="px-2 py-0.5 rounded-full text-[10px] font-bold <?= $s['is_package'] ? 'bg-amber-100 text-amber-800' : 'bg-blue-50 text-blue-700' ?>">
                    <?= $s['is_package'] ? 'Gói trọn gói' : 'Dịch vụ lẻ' ?>
                  </span>
                </td>
                <td class="px-6 py-3 text-gray-500"><?= $s['duration_min'] ?> phút</td>
                <td class="px-6 py-3">
                  <form method="POST" class="flex items-center gap-2">
                    <input type="hidden" name="action" value="update_price" />
                    <input type="hidden" name="id" value="<?= $s['id'] ?>" />
                    <input type="number" name="price" value="<?= $s['price'] ?>" class="w-24 px-2 py-1 rounded border border-gray-200 text-xs font-bold text-emerald-800" />
                    <button type="submit" class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-[10px] font-semibold rounded cursor-pointer">Sửa</button>
                  </form>
                </td>
                <td class="px-6 py-3">
                  <span class="px-2 py-0.5 rounded-full text-[10px] font-bold <?= $s['is_active'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' ?>">
                    <?= $s['is_active'] ? 'Đang hiển thị' : 'Đã ẩn' ?>
                  </span>
                </td>
                <td class="px-6 py-3 text-right">
                  <form method="POST" class="inline">
                    <input type="hidden" name="action" value="toggle_active" />
                    <input type="hidden" name="id" value="<?= $s['id'] ?>" />
                    <input type="hidden" name="current" value="<?= $s['is_active'] ?>" />
                    <button type="submit" class="px-3 py-1 rounded text-[11px] font-semibold cursor-pointer <?= $s['is_active'] ? 'bg-red-50 text-red-600 hover:bg-red-100' : 'bg-green-50 text-green-700 hover:bg-green-100' ?>">
                      <?= $s['is_active'] ? 'Ẩn dịch vụ' : 'Bật hiển thị' ?>
                    </button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</body>
</html>
