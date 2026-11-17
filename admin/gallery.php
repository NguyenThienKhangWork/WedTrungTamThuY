<?php
/**
 * PawNest - Quản lý Thư viện ảnh bé cưng (Mục 2.10, FR-32, FR-92)
 * Kiểm duyệt ảnh trước/sau và xác nhận sự đồng ý của chủ nuôi
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/auth.php';
Auth::requireRole(['admin', 'receptionist']);

$pdo = Database::getConnection();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = (int)($_POST['id'] ?? 0);
    
    if ($action === 'toggle_visible') {
        $stmt = $pdo->prepare('UPDATE gallery SET is_visible = NOT is_visible WHERE id = ?');
        $stmt->execute([$id]);
        $message = 'Đã cập nhật trạng thái hiển thị của ảnh!';
    }
}

// Lấy danh sách ảnh trong gallery
$galleryItems = $pdo->query('
    SELECT g.*, p.name as pet_name, p.species, c.full_name as owner_name 
    FROM gallery g
    JOIN pets p ON g.pet_id = p.id
    JOIN customers c ON p.customer_id = c.id
    ORDER BY g.id DESC
')->fetchAll();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý Thư viện ảnh – PawNest Admin</title>
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
      <span class="text-2xl">📸</span>
      <div>
        <h1 class="text-lg font-bold text-[#1a3d1a]">PawNest Admin – Thư Viện Bé Cưng</h1>
        <p class="text-xs text-gray-500">Người dùng: <strong><?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></strong></p>
      </div>
    </div>
    <div class="flex items-center gap-4 text-xs font-semibold">
      <a href="/admin/dashboard.php" class="text-gray-600 hover:text-[#1a3d1a]">← Bảng điều khiển</a>
      <a href="/admin/inventory.php" class="text-amber-700 font-bold hover:underline">📦 Kho & Thuốc</a>
      <a href="/admin/appointments.php" class="text-gray-600 hover:text-[#1a3d1a]">Lịch hẹn</a>
      <a href="/admin/services.php" class="text-gray-600 hover:text-[#1a3d1a]">Dịch vụ & Giá</a>
      <a href="/admin/reviews.php" class="text-gray-600 hover:text-[#1a3d1a]">Đánh giá</a>
      <a href="/thu-vien.php" target="_blank" class="text-emerald-700 hover:underline">Xem Thư viện web</a>
    </div>
  </header>

  <main class="max-w-6xl mx-auto p-6 space-y-6">
    <?php if ($message): ?>
      <div class="p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-xs font-semibold">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6">
      <h3 class="font-bold text-sm text-[#1a3d1a] mb-2">Ảnh Bé Cưng Có Đồng Ý Của Chủ Nuôi (FR-32)</h3>
      <p class="text-xs text-gray-500 mb-6">Tuân thủ Nghị định 13/2023/NĐ-CP: Chỉ hiển thị ảnh khi có xác nhận văn bản hoặc tin nhắn của chủ nuôi.</p>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (empty($galleryItems)): ?>
          <!-- Demo items nếu chưa có trong DB -->
          <div class="border border-gray-200 rounded-2xl p-4 space-y-3">
            <div class="aspect-square rounded-xl overflow-hidden bg-gray-100">
              <img src="https://images.unsplash.com/photo-1612536057832-2ff7ead58194?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover" />
            </div>
            <div class="flex items-center justify-between">
              <span class="font-bold text-sm text-[#1a3d1a]">Bé Bơ (Corgi)</span>
              <span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-bold">Đã đồng ý</span>
            </div>
            <p class="text-[11px] text-gray-500">Chủ nuôi: Chị Thu Hà • 0912345678</p>
            <span class="inline-block px-2.5 py-1 rounded bg-emerald-50 text-emerald-800 text-[10px] font-semibold">Đang hiển thị trên website</span>
          </div>

          <div class="border border-gray-200 rounded-2xl p-4 space-y-3">
            <div class="aspect-square rounded-xl overflow-hidden bg-gray-100">
              <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover" />
            </div>
            <div class="flex items-center justify-between">
              <span class="font-bold text-sm text-[#1a3d1a]">Bé Mochi (Poodle)</span>
              <span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-bold">Đã đồng ý</span>
            </div>
            <p class="text-[11px] text-gray-500">Chủ nuôi: Bạn Ngọc Anh • 0934567890</p>
            <span class="inline-block px-2.5 py-1 rounded bg-emerald-50 text-emerald-800 text-[10px] font-semibold">Đang hiển thị trên website</span>
          </div>

          <div class="border border-gray-200 rounded-2xl p-4 space-y-3">
            <div class="aspect-square rounded-xl overflow-hidden bg-gray-100">
              <img src="https://images.unsplash.com/photo-1533738363-b7f9aef128ce?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover" />
            </div>
            <div class="flex items-center justify-between">
              <span class="font-bold text-sm text-[#1a3d1a]">Bé Mướp (Mèo ta)</span>
              <span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-bold">Đã đồng ý</span>
            </div>
            <p class="text-[11px] text-gray-500">Chủ nuôi: Anh Minh Quân • 0923456789</p>
            <span class="inline-block px-2.5 py-1 rounded bg-emerald-50 text-emerald-800 text-[10px] font-semibold">Đang hiển thị trên website</span>
          </div>
        <?php else: ?>
          <?php foreach ($galleryItems as $item): ?>
            <div class="border border-gray-200 rounded-2xl p-4 space-y-3">
              <div class="aspect-square rounded-xl overflow-hidden bg-gray-100">
                <img src="<?= htmlspecialchars($item['image_after'] ?: $item['image_before']) ?>" class="w-full h-full object-cover" />
              </div>
              <div class="flex items-center justify-between">
                <span class="font-bold text-sm text-[#1a3d1a]"><?= htmlspecialchars($item['pet_name']) ?> (<?= htmlspecialchars($item['species']) ?>)</span>
                <span class="text-[10px] <?= $item['has_consent'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?> px-2 py-0.5 rounded-full font-bold">
                  <?= $item['has_consent'] ? 'Đã đồng ý' : 'Chưa có' ?>
                </span>
              </div>
              <p class="text-[11px] text-gray-500">Chủ nuôi: <?= htmlspecialchars($item['owner_name']) ?></p>
              <form method="POST">
                <input type="hidden" name="action" value="toggle_visible" />
                <input type="hidden" name="id" value="<?= $item['id'] ?>" />
                <button type="submit" class="w-full py-1.5 rounded-lg text-xs font-semibold <?= $item['is_visible'] ? 'bg-red-50 text-red-600 hover:bg-red-100' : 'bg-green-50 text-green-700 hover:bg-green-100' ?>">
                  <?= $item['is_visible'] ? 'Ẩn khỏi thư viện' : 'Duyệt hiển thị' ?>
                </button>
              </form>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </main>
</body>
</html>
