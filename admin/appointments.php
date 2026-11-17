<?php
/**
 * PawNest & CozyPaws - Quản lý Chi tiết Lịch hẹn (Admin Appointments)
 * Xem danh sách, lọc theo trạng thái, duyệt lịch, đổi trạng thái
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/AppointmentRepository.php';

Auth::requireRole(['admin', 'receptionist']);

$repo = new AppointmentRepository();
$message = '';

// Xử lý đổi trạng thái
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $appId = (int)($_POST['appointment_id'] ?? 0);
    $newStatus = $_POST['status'] ?? '';
    $pdo = Database::getConnection();

    // Xác nhận thanh toán QR
    if ($appId > 0 && isset($_POST['mark_paid'])) {
        $pdo->prepare('UPDATE appointments SET payment_status = "paid" WHERE id = :id')
            ->execute(['id' => $appId]);
        $message = 'Đã xác nhận thanh toán cho lịch hẹn #' . $appId . '!';
    } elseif ($appId > 0 && in_array($newStatus, ['pending', 'confirmed', 'done', 'cancelled', 'no_show'], true)) {
        if ($repo->updateStatus($appId, $newStatus)) {
            $message = 'Cập nhật trạng thái lịch hẹn #' . $appId . ' thành công!';
        }
    }
}

$statusFilter = $_GET['status'] ?? null;
if ($statusFilter === 'all') $statusFilter = null;

$appointments = $repo->findAll($statusFilter);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý Lịch hẹn – PawNest Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Nunito', sans-serif; background-color: #F8FAF7; }
    h1, h2, h3, .font-serif-display { font-family: 'Baloo 2', cursive, sans-serif; }
  </style>
</head>
<body class="min-h-screen text-gray-800">
  <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between sticky top-0 z-30">
    <div class="flex items-center gap-3">
      <span class="text-2xl">🐾</span>
      <div>
        <h1 class="text-lg font-bold text-[#1a3d1a]">Quản lý Lịch hẹn Khám & Spa</h1>
        <p class="text-xs text-gray-500">Xem và xác nhận lịch hẹn của khách hàng</p>
      </div>
    </div>
    <div class="flex items-center gap-4 text-xs font-semibold">
      <a href="/admin/dashboard.php" class="text-gray-600 hover:text-[#1a3d1a]">← Bảng điều khiển</a>
      <a href="/admin/inventory.php" class="text-amber-700 font-bold hover:underline">📦 Kho & Thuốc</a>
      <a href="/admin/services.php" class="text-gray-600 hover:text-[#1a3d1a]">Dịch vụ & Giá</a>
      <a href="/admin/gallery.php" class="text-gray-600 hover:text-[#1a3d1a]">Thư viện</a>
      <a href="/admin/reviews.php" class="text-gray-600 hover:text-[#1a3d1a]">Đánh giá</a>
      <a href="/admin/login.php?action=logout" class="text-red-600 hover:underline">Đăng xuất</a>
    </div>
  </header>

  <main class="max-w-7xl mx-auto p-6 space-y-4">
    <?php if ($message): ?>
      <div class="p-3 rounded-xl bg-green-50 text-green-700 text-xs border border-green-200">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>

    <!-- Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-gray-100 flex items-center justify-between flex-wrap gap-3">
      <div class="flex items-center gap-2 text-xs">
        <span class="text-gray-500 font-medium">Lọc theo trạng thái:</span>
        <a href="?status=all" class="px-3 py-1.5 rounded-lg <?= !$statusFilter ? 'bg-[#1a3d1a] text-white' : 'bg-gray-100 text-gray-700' ?>">Tất cả</a>
        <a href="?status=pending" class="px-3 py-1.5 rounded-lg <?= $statusFilter === 'pending' ? 'bg-amber-600 text-white' : 'bg-gray-100 text-gray-700' ?>">Chờ duyệt</a>
        <a href="?status=confirmed" class="px-3 py-1.5 rounded-lg <?= $statusFilter === 'confirmed' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700' ?>">Đã duyệt</a>
        <a href="?status=done" class="px-3 py-1.5 rounded-lg <?= $statusFilter === 'done' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700' ?>">Hoàn thành</a>
        <a href="?status=cancelled" class="px-3 py-1.5 rounded-lg <?= $statusFilter === 'cancelled' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700' ?>">Đã hủy</a>
      </div>
      <div class="text-xs text-gray-500">
        Tìm thấy <strong><?= count($appointments) ?></strong> lịch hẹn
      </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-xs">
      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
          <thead class="bg-gray-50 text-gray-500 uppercase text-[11px] border-b border-gray-100">
            <tr>
              <th class="p-4">Mã</th>
              <th>Khách hàng & Bé cưng</th>
              <th>Dịch vụ & Giá</th>
              <th>Thời gian hẹn</th>
              <th>Nhân sự phụ trách</th>
              <th>Thanh toán</th>
              <th>Trạng thái</th>
              <th class="p-4 text-right">Thao tác</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <?php if (empty($appointments)): ?>
              <tr>
                <td colspan="7" class="p-8 text-center text-gray-400">Không có lịch hẹn nào.</td>
              </tr>
            <?php else: ?>
              <?php foreach ($appointments as $app): ?>
                <tr class="hover:bg-gray-50/50">
                  <td class="p-4 font-bold text-gray-700">#<?= $app['id'] ?></td>
                  <td>
                    <div class="font-semibold text-gray-900"><?= htmlspecialchars($app['customer_name']) ?></div>
                    <div class="text-gray-500"><?= htmlspecialchars($app['pet_name']) ?> (<?= htmlspecialchars($app['pet_species']) ?>) • <?= htmlspecialchars($app['customer_phone']) ?></div>
                    <?php if (!empty($app['note'])): ?>
                      <div class="text-[10px] text-gray-400 italic">Ghi chú: <?= htmlspecialchars($app['note']) ?></div>
                    <?php endif; ?>
                  </td>
                  <td>
                    <div class="font-medium text-gray-800"><?= htmlspecialchars($app['service_name']) ?></div>
                    <div class="text-gray-400 font-semibold"><?= number_format((float)$app['service_price'], 0, ',', '.') ?> ₫</div>
                  </td>
                  <td>
                    <div class="font-semibold text-[#1a3d1a]"><?= date('H:i', strtotime($app['start_at'])) ?></div>
                    <div class="text-gray-500 text-[11px]"><?= date('d/m/Y', strtotime($app['start_at'])) ?></div>
                  </td>
                  <td class="text-gray-600 font-medium">
                    <?= htmlspecialchars($app['staff_name']) ?>
                  </td>
                  <td>
                    <?php
                      $pm = $app['payment_method'] ?? 'at_store';
                      $ps = $app['payment_status'] ?? 'pending';
                    ?>
                    <?php if ($pm === 'bank_transfer'): ?>
                      <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 font-semibold text-[10px]">
                        📱 QR Ngân hàng
                      </span>
                      <?php if ($ps === 'paid'): ?>
                        <span class="block mt-0.5 text-[10px] text-green-600 font-bold">✓ Đã thanh toán</span>
                      <?php else: ?>
                        <span class="block mt-0.5 text-[10px] text-amber-600">Chưa xác nhận</span>
                      <?php endif; ?>
                    <?php else: ?>
                      <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 font-semibold text-[10px]">
                        🏪 Tại quán
                      </span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if ($app['status'] === 'pending'): ?>
                      <span class="px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 font-bold text-[10px]">Chờ xác nhận</span>
                    <?php elseif ($app['status'] === 'confirmed'): ?>
                      <span class="px-2.5 py-1 rounded-full bg-green-50 text-green-700 font-bold text-[10px]">Đã xác nhận</span>
                    <?php elseif ($app['status'] === 'done'): ?>
                      <span class="px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 font-bold text-[10px]">Đã hoàn thành</span>
                    <?php else: ?>
                      <span class="px-2.5 py-1 rounded-full bg-gray-100 text-gray-600 font-bold text-[10px]"><?= $app['status'] ?></span>
                    <?php endif; ?>
                  </td>
                  <td class="p-4 text-right">
                    <form method="POST" class="inline-flex gap-1.5 items-center">
                      <input type="hidden" name="appointment_id" value="<?= $app['id'] ?>">
                      <?php if ($app['status'] === 'pending'): ?>
                        <button type="submit" name="status" value="confirmed" class="px-2.5 py-1 bg-green-600 hover:bg-green-700 text-white rounded-lg text-[10px] font-bold cursor-pointer">
                          Duyệt
                        </button>
                      <?php endif; ?>
                      <?php if ($app['status'] === 'confirmed'): ?>
                        <button type="submit" name="status" value="done" class="px-2.5 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-[10px] font-bold cursor-pointer">
                          Xong
                        </button>
                      <?php endif; ?>
                      <?php if (($app['payment_method'] ?? '') === 'bank_transfer' && ($app['payment_status'] ?? '') !== 'paid'): ?>
                        <button type="submit" name="mark_paid" value="1" class="px-2.5 py-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-[10px] font-bold cursor-pointer">
                          ✓ TT
                        </button>
                      <?php endif; ?>
                      <?php if ($app['status'] !== 'cancelled'): ?>
                        <button type="submit" name="status" value="cancelled" class="px-2.5 py-1 bg-gray-100 hover:bg-red-50 text-red-600 rounded-lg text-[10px] font-medium cursor-pointer">
                          Hủy
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
