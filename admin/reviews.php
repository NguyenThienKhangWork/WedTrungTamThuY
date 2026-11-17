<?php
/**
 * PawNest - Quản lý & Kiểm duyệt Đánh giá (Mục 2.5, FR-42, FR-92)
 * Kiểm duyệt đánh giá của khách hàng (duyệt hiển thị hoặc ẩn, không chỉnh sửa nội dung)
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/auth.php';
Auth::requireRole(['admin', 'receptionist']);

$pdo = Database::getConnection();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = (int)($_POST['id'] ?? 0);
    
    if ($action === 'set_status') {
        $status = $_POST['status'] ?? 'approved';
        if (in_array($status, ['approved', 'hidden', 'pending'], true)) {
            $stmt = $pdo->prepare('UPDATE reviews SET status = ? WHERE id = ?');
            $stmt->execute([$status, $id]);
            $message = 'Đã cập nhật trạng thái kiểm duyệt đánh giá!';
        }
    }
}

// Lấy danh sách đánh giá từ DB
$reviews = $pdo->query('
    SELECT r.*, a.start_at, c.full_name as customer_name, p.name as pet_name, s.name as service_name
    FROM reviews r
    JOIN appointments a ON r.appointment_id = a.id
    JOIN customers c ON a.customer_id = c.id
    JOIN pets p ON a.pet_id = p.id
    JOIN services s ON a.service_id = s.id
    ORDER BY r.id DESC
')->fetchAll();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kiểm duyệt Đánh giá – PawNest Admin</title>
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
      <span class="text-2xl">⭐</span>
      <div>
        <h1 class="text-lg font-bold text-[#1a3d1a]">PawNest Admin – Kiểm Duyệt Đánh Giá</h1>
        <p class="text-xs text-gray-500">Người dùng: <strong><?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></strong></p>
      </div>
    </div>
    <div class="flex items-center gap-4 text-xs font-semibold">
      <a href="/admin/dashboard.php" class="text-gray-600 hover:text-[#1a3d1a]">← Bảng điều khiển</a>
      <a href="/admin/inventory.php" class="text-amber-700 font-bold hover:underline">📦 Kho & Thuốc</a>
      <a href="/admin/appointments.php" class="text-gray-600 hover:text-[#1a3d1a]">Lịch hẹn</a>
      <a href="/admin/services.php" class="text-gray-600 hover:text-[#1a3d1a]">Dịch vụ & Giá</a>
      <a href="/admin/gallery.php" class="text-gray-600 hover:text-[#1a3d1a]">Thư viện</a>
      <a href="/danh-gia.php" target="_blank" class="text-emerald-700 hover:underline">Xem Đánh giá web</a>
    </div>
  </header>

  <main class="max-w-6xl mx-auto p-6 space-y-6">
    <?php if ($message): ?>
      <div class="p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-xs font-semibold">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
      <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <div>
          <h3 class="font-bold text-sm text-[#1a3d1a]">Danh Sách Đánh Giá Khách Hàng (Mục FR-42)</h3>
          <p class="text-[11px] text-gray-500">Nguyên tắc: Không sửa nội dung khách viết, chỉ duyệt hiển thị hoặc ẩn.</p>
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-xs text-left">
          <thead class="bg-gray-50 text-gray-500 font-semibold uppercase text-[10px] border-b border-gray-100">
            <tr>
              <th class="px-6 py-3">ID</th>
              <th class="px-6 py-3">Khách & Bé</th>
              <th class="px-6 py-3">Dịch vụ</th>
              <th class="px-6 py-3">Số sao</th>
              <th class="px-6 py-3">Nội dung nhận xét</th>
              <th class="px-6 py-3">Trạng thái</th>
              <th class="px-6 py-3 text-right">Hành động</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <?php if (empty($reviews)): ?>
              <tr>
                <td colspan="7" class="px-6 py-8 text-center text-gray-400">Chưa có đánh giá nào cần kiểm duyệt trong cơ sở dữ liệu.</td>
              </tr>
            <?php else: ?>
              <?php foreach ($reviews as $r): ?>
                <tr class="hover:bg-gray-50/50">
                  <td class="px-6 py-3 font-mono text-gray-400">#<?= $r['id'] ?></td>
                  <td class="px-6 py-3">
                    <span class="font-bold text-[#1a3d1a] block"><?= htmlspecialchars($r['customer_name']) ?></span>
                    <span class="text-gray-400 text-[11px]">Bé: <?= htmlspecialchars($r['pet_name']) ?></span>
                  </td>
                  <td class="px-6 py-3 text-gray-600"><?= htmlspecialchars($r['service_name']) ?></td>
                  <td class="px-6 py-3 font-bold text-amber-500 text-sm">
                    <?= str_repeat('★', (int)$r['rating']) ?>
                  </td>
                  <td class="px-6 py-3 max-w-xs text-gray-700 italic">
                    "<?= htmlspecialchars($r['content'] ?? '') ?>"
                  </td>
                  <td class="px-6 py-3">
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold <?= $r['status'] === 'approved' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' ?>">
                      <?= $r['status'] === 'approved' ? 'Đã hiển thị' : 'Đã ẩn' ?>
                    </span>
                  </td>
                  <td class="px-6 py-3 text-right">
                    <form method="POST" class="inline">
                      <input type="hidden" name="action" value="set_status" />
                      <input type="hidden" name="id" value="<?= $r['id'] ?>" />
                      <?php if ($r['status'] === 'approved'): ?>
                        <input type="hidden" name="status" value="hidden" />
                        <button type="submit" class="px-3 py-1 bg-red-50 hover:bg-red-100 text-red-600 rounded text-[11px] font-semibold cursor-pointer">
                          Ẩn đánh giá
                        </button>
                      <?php else: ?>
                        <input type="hidden" name="status" value="approved" />
                        <button type="submit" class="px-3 py-1 bg-green-50 hover:bg-green-100 text-green-700 rounded text-[11px] font-semibold cursor-pointer">
                          Duyệt hiển thị
                        </button>
                      <?php endif; ?>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</body>
</html>
