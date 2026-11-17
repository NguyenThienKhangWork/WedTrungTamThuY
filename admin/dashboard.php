<?php
/**
 * PawNest & CozyPaws - Bảng điều khiển Quản trị (Admin Dashboard)
 * Thống kê số lượng lịch hẹn, doanh thu, dịch vụ phổ biến nhất (FR-90, FR-91, FR-93)
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/AppointmentRepository.php';
require_once __DIR__ . '/../includes/ProductRepository.php';

Auth::requireRole(['admin', 'receptionist']);

$pdo = Database::getConnection();
$prodRepo = new ProductRepository($pdo);
$criticalLowStock = $prodRepo->findCriticalLowStock();
$inventoryStats = $prodRepo->getStats();

// Thống kê số lượng theo trạng thái
$stmtStats = $pdo->query('
    SELECT status, COUNT(*) as count 
    FROM appointments 
    GROUP BY status
');
$stats = $stmtStats->fetchAll(PDO::FETCH_KEY_PAIR);

$totalAppointments = array_sum($stats);
$pendingCount = $stats['pending'] ?? 0;
$confirmedCount = $stats['confirmed'] ?? 0;
$doneCount = $stats['done'] ?? 0;
$cancelledCount = $stats['cancelled'] ?? 0;

// Thống kê dịch vụ phổ biến
$topServices = $pdo->query('
    SELECT s.name, COUNT(a.id) as total_booked
    FROM services s
    LEFT JOIN appointments a ON s.id = a.service_id
    GROUP BY s.id
    ORDER BY total_booked DESC
    LIMIT 5
')->fetchAll();

// 5 Lịch hẹn mới nhất
$appRepo = new AppointmentRepository();
$recentAppointments = array_slice($appRepo->findAll(), 0, 5);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bảng điều khiển Quản trị – PawNest & CozyPaws</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Nunito', sans-serif; background-color: #F8FAF7; }
    h1, h2, h3, .font-serif-display { font-family: 'Baloo 2', cursive, sans-serif; }
  </style>
</head>
<body class="min-h-screen text-gray-800">
  <!-- Top Navigation -->
  <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between sticky top-0 z-30">
    <div class="flex items-center gap-3">
      <span class="text-2xl">🐾</span>
      <div>
        <h1 class="text-lg font-bold text-[#1a3d1a]">PawNest Admin Dashboard</h1>
        <p class="text-xs text-gray-500">Xin chào, <strong><?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></strong> (<?= htmlspecialchars($_SESSION['role'] ?? '') ?>)</p>
      </div>
    </div>
    <div class="flex items-center gap-4 text-xs font-medium">
      <a href="/index.php" target="_blank" class="text-gray-600 hover:text-[#1a3d1a]">Xem Website</a>
      <a href="/cua-hang.php" target="_blank" class="text-emerald-700 font-bold hover:underline">🏪 Cửa hàng Online</a>
      <a href="/admin/appointments.php" class="text-gray-600 hover:text-[#1a3d1a]">Quản lý Lịch hẹn</a>
      <a href="/admin/inventory.php" class="text-amber-700 font-bold hover:underline">📦 Kho & Thuốc <?= $inventoryStats['critical_low_count'] > 0 ? "({$inventoryStats['critical_low_count']} 🚨)" : '' ?></a>
      <a href="/admin/services.php" class="text-gray-600 hover:text-[#1a3d1a]">Dịch vụ & Giá</a>
      <a href="/admin/gallery.php" class="text-gray-600 hover:text-[#1a3d1a]">Thư viện ảnh</a>
      <a href="/admin/reviews.php" class="text-gray-600 hover:text-[#1a3d1a]">Đánh giá</a>
      <a href="/admin/login.php?action=logout" class="text-red-600 hover:underline">Đăng xuất</a>
    </div>
  </header>

  <!-- Main Content -->
  <main class="max-w-7xl mx-auto p-6 space-y-6">

    <!-- CẢNH BÁO TỒN KHO THẤP DÀNH CHO BÁC SĨ / ADMIN -->
    <?php if (!empty($criticalLowStock)): ?>
      <div class="bg-red-50 border-2 border-red-300 rounded-3xl p-5 shadow-xs">
        <div class="flex items-start justify-between gap-4">
          <div class="flex items-start gap-3">
            <span class="text-2xl animate-bounce">🚨</span>
            <div>
              <h2 class="text-sm sm:text-base font-bold text-red-900">
                Cảnh báo kho y tế: Có <?= count($criticalLowStock) ?> loại Thuốc / Vắc xin quan trọng sắp hết hàng!
              </h2>
              <p class="text-xs text-red-700 mt-0.5">
                Các loại vắc xin và thuốc điều trị bên dưới đang ở mức tồn kho nguy hiểm. Bác sĩ hoặc lễ tân cần liên hệ nhập thêm ngay:
              </p>
              <div class="flex flex-wrap gap-2 mt-2.5">
                <?php foreach ($criticalLowStock as $crit): ?>
                  <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-white border border-red-200 text-xs font-bold text-red-900 shadow-2xs">
                    <span>💊 <?= htmlspecialchars($crit['name']) ?></span>
                    <span class="text-red-600 bg-red-100 px-1.5 py-0.2 rounded font-mono">Còn: <?= $crit['stock_quantity'] ?> <?= htmlspecialchars($crit['unit']) ?></span>
                  </span>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
          <a href="/admin/inventory.php" class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shrink-0 shadow-sm transition-all">
            Vào Quản lý Kho →
          </a>
        </div>
      </div>
    <?php endif; ?>
    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
        <span class="text-xs font-semibold text-gray-500 uppercase">Tổng lịch hẹn</span>
        <div class="text-3xl font-extrabold text-[#1a3d1a] mt-2"><?= $totalAppointments ?></div>
        <p class="text-[11px] text-gray-400 mt-1">Từ website và đặt trực tiếp</p>
      </div>
      <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
        <span class="text-xs font-semibold text-amber-600 uppercase">Chờ xác nhận</span>
        <div class="text-3xl font-extrabold text-amber-600 mt-2"><?= $pendingCount ?></div>
        <p class="text-[11px] text-amber-700 mt-1">Cần lễ tân gọi xác nhận</p>
      </div>
      <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
        <span class="text-xs font-semibold text-green-600 uppercase">Đã xác nhận</span>
        <div class="text-3xl font-extrabold text-green-700 mt-2"><?= $confirmedCount ?></div>
        <p class="text-[11px] text-green-600 mt-1">Sẵn sàng phục vụ</p>
      </div>
      <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
        <span class="text-xs font-semibold text-gray-500 uppercase">Đã hoàn thành</span>
        <div class="text-3xl font-extrabold text-[#1a3d1a] mt-2"><?= $doneCount ?></div>
        <p class="text-[11px] text-gray-400 mt-1">Đã spa / khám xong</p>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Recent Appointments -->
      <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-gray-100 shadow-xs">
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-base font-bold text-[#1a3d1a]">Lịch hẹn mới nhất</h2>
          <a href="/admin/appointments.php" class="text-xs text-[#E86A10] font-semibold hover:underline">Xem tất cả →</a>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs">
            <thead class="text-gray-400 uppercase border-b border-gray-100 pb-2">
              <tr>
                <th class="py-2">Khách / Bé</th>
                <th>Dịch vụ</th>
                <th>Giờ hẹn</th>
                <th>Trạng thái</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
              <?php foreach ($recentAppointments as $app): ?>
                <tr class="hover:bg-gray-50/50">
                  <td class="py-3">
                    <div class="font-semibold text-gray-900"><?= htmlspecialchars($app['customer_name']) ?></div>
                    <div class="text-gray-400"><?= htmlspecialchars($app['pet_name']) ?> (<?= htmlspecialchars($app['pet_species']) ?>) • <?= htmlspecialchars($app['customer_phone']) ?></div>
                  </td>
                  <td><?= htmlspecialchars($app['service_name']) ?></td>
                  <td><?= date('H:i d/m/Y', strtotime($app['start_at'])) ?></td>
                  <td>
                    <?php if ($app['status'] === 'pending'): ?>
                      <span class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 font-semibold text-[10px]">Chờ duyệt</span>
                    <?php elseif ($app['status'] === 'confirmed'): ?>
                      <span class="px-2 py-0.5 rounded-full bg-green-50 text-green-700 font-semibold text-[10px]">Đã duyệt</span>
                    <?php else: ?>
                      <span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 font-semibold text-[10px]"><?= $app['status'] ?></span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Top Services -->
      <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-xs">
        <h2 class="text-base font-bold text-[#1a3d1a] mb-4">Dịch vụ được chọn nhiều nhất</h2>
        <div class="space-y-3 text-xs">
          <?php foreach ($topServices as $idx => $svc): ?>
            <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
              <span class="font-medium text-gray-800"><?= ($idx + 1) ?>. <?= htmlspecialchars($svc['name']) ?></span>
              <span class="font-bold text-[#1a3d1a]"><?= $svc['total_booked'] ?> lượt</span>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </main>
</body>
</html>
