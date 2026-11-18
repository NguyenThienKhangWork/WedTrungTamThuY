<?php
/**
 * PawNest & CozyPaws - Quản lý Kho Hàng Hóa, Thuốc & Vật tư Tiêu hao (Admin Inventory)
 * Đáp ứng yêu cầu: Bán thức ăn, thuốc, vật tư; ghi nhận nhập xuất kho; cảnh báo tồn kho thấp
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../repository/ProductRepository.php';

Auth::requireRole(['admin', 'receptionist']);

$repo = new ProductRepository();
$currentUser = $_SESSION['username'] ?? 'Bác sĩ Khang';

$message = '';
$messageType = 'success';

// Xử lý các thao tác form POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    try {
        if ($action === 'adjust_stock') {
            $productId  = (int)($_POST['product_id'] ?? 0);
            $changeType = $_POST['change_type'] ?? 'import';
            $qty        = (int)($_POST['quantity'] ?? 0);
            $note       = trim($_POST['note'] ?? '');

            if ($productId <= 0 || $qty <= 0) {
                throw new InvalidArgumentException('Dữ liệu sản phẩm hoặc số lượng không hợp lệ.');
            }

            $repo->adjustStock($productId, $changeType, $qty, $note, $currentUser);
            $typeLabel = ($changeType === 'import') ? 'Nhập kho' : 'Xuất kho / Dùng điều trị';
            $message = "Thành công: Đã thực hiện {$typeLabel} ({$qty} sản phẩm).";
        } elseif ($action === 'create_product') {
            $data = [
                'sku'            => trim($_POST['sku'] ?? ''),
                'name'           => trim($_POST['name'] ?? ''),
                'category'       => $_POST['category'] ?? 'food',
                'price'          => (float)($_POST['price'] ?? 0),
                'cost_price'     => (float)($_POST['cost_price'] ?? 0),
                'stock_quantity' => (int)($_POST['stock_quantity'] ?? 0),
                'min_stock'      => (int)($_POST['min_stock'] ?? 5),
                'unit'           => trim($_POST['unit'] ?? 'Hộp'),
                'image'          => trim($_POST['image'] ?? ''),
                'description'    => trim($_POST['description'] ?? ''),
                'is_critical'    => isset($_POST['is_critical']) ? 1 : 0,
                'status'         => 'active'
            ];

            if ($data['name'] === '') {
                throw new InvalidArgumentException('Vui lòng nhập tên sản phẩm.');
            }

            $newId = $repo->create($data);
            $message = "Thành công: Đã thêm mới sản phẩm {$data['name']} vào kho.";
        } elseif ($action === 'delete_product') {
            $id = (int)($_POST['product_id'] ?? 0);
            if ($id > 0) {
                try {
                    $repo->delete($id);
                    $message = 'Đã xóa mặt hàng thành công khỏi kho.';
                } catch (Throwable $e) {
                    $repo->update($id, ['status' => 'inactive']);
                    $message = 'Mặt hàng đã có dữ liệu giao dịch liên quan, đã chuyển sang trạng thái Ẩn.';
                }
            }
        } elseif ($action === 'update_product') {
            $id = (int)($_POST['product_id'] ?? 0);
            if ($id <= 0) {
                throw new InvalidArgumentException('ID sản phẩm không hợp lệ.');
            }

            $data = [
                'sku'            => trim($_POST['sku'] ?? ''),
                'name'           => trim($_POST['name'] ?? ''),
                'category'       => $_POST['category'] ?? 'food',
                'price'          => (float)($_POST['price'] ?? 0),
                'cost_price'     => (float)($_POST['cost_price'] ?? 0),
                'min_stock'      => (int)($_POST['min_stock'] ?? 5),
                'unit'           => trim($_POST['unit'] ?? 'Hộp'),
                'image'          => trim($_POST['image'] ?? ''),
                'description'    => trim($_POST['description'] ?? ''),
                'is_critical'    => isset($_POST['is_critical']) ? 1 : 0,
                'status'         => $_POST['status'] ?? 'active'
            ];

            $repo->update($id, $data);
            $message = "Thành công: Đã cập nhật sản phẩm {$data['name']}.";
        }
    } catch (Throwable $e) {
        $message = 'Lỗi: ' . $e->getMessage();
        $messageType = 'error';
    }
}

// Lọc dữ liệu hiển thị
$selectedCat     = $_GET['category'] ?? null;
$lowStockFilter  = isset($_GET['low_stock']) && $_GET['low_stock'] === '1';
$searchQuery     = $_GET['q'] ?? null;
$activeTab       = $_GET['tab'] ?? 'products';

$products = $repo->findAll($selectedCat, $lowStockFilter, $searchQuery);
$criticalItems = $repo->findCriticalLowStock();
$stats = $repo->getStats();
$logs = ($activeTab === 'logs') ? $repo->getLogs(null, 100) : [];

function formatVND(float|int $n): string {
    return number_format($n, 0, ',', '.') . ' ₫';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý Kho & Thuốc – PawNest & CozyPaws Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    body { font-family: 'Nunito', sans-serif; background-color: #F8FAF7; }
    h1, h2, h3, .font-serif-display { font-family: 'Baloo 2', cursive, sans-serif; }
  </style>
</head>
<body class="min-h-screen text-gray-800 pb-16">
  <!-- Top Navigation -->
  <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between sticky top-0 z-30 shadow-2xs">
    <div class="flex items-center gap-3">
      <span class="text-2xl">📦</span>
      <div>
        <h1 class="text-lg font-bold text-[#1a3d1a]">Quản lý Kho, Thuốc & Vật tư Thú Y</h1>
        <p class="text-xs text-gray-500">Người trực kho: <strong><?= htmlspecialchars($currentUser) ?></strong> (<?= htmlspecialchars($_SESSION['role'] ?? 'Admin') ?>)</p>
      </div>
    </div>
    <div class="flex items-center gap-4 text-xs font-medium">
      <a href="/index.php" target="_blank" class="text-gray-600 hover:text-[#1a3d1a]">Xem Website</a>
      <a href="/cua-hang.php" target="_blank" class="text-emerald-700 font-bold hover:underline">🏪 Cửa hàng Online</a>
      <a href="/admin/dashboard.php" class="text-gray-600 hover:text-[#1a3d1a]">Dashboard</a>
      <a href="/admin/appointments.php" class="text-gray-600 hover:text-[#1a3d1a]">Lịch hẹn</a>
      <a href="/admin/inventory.php" class="text-[#1a3d1a] font-bold border-b-2 border-[#1a3d1a] pb-0.5">Kho hàng hóa</a>
      <a href="/admin/services.php" class="text-gray-600 hover:text-[#1a3d1a]">Dịch vụ</a>
      <a href="/admin/login.php?action=logout" class="text-red-600 hover:underline">Đăng xuất</a>
    </div>
  </header>

  <main class="max-w-7xl mx-auto p-6 space-y-6">

    <!-- Thông báo kết quả -->
    <?php if ($message): ?>
      <div class="p-4 rounded-2xl text-xs sm:text-sm font-semibold flex items-center gap-2 <?= $messageType === 'success' ? 'bg-green-50 text-green-800 border border-green-200' : 'bg-red-50 text-red-800 border border-red-200' ?>">
        <span><?= $messageType === 'success' ? '✅' : '⚠️' ?></span>
        <span><?= htmlspecialchars($message) ?></span>
      </div>
    <?php endif; ?>

    <!-- ======================================================== -->
    <!-- CẢNH BÁO KHẨN CẤP: THUỐC / VẮC XIN QUAN TRỌNG TỒN THẤP -->
    <!-- ======================================================== -->
    <?php if (!empty($criticalItems)): ?>
      <div class="bg-red-50 border-2 border-red-400 rounded-3xl p-5 shadow-sm">
        <div class="flex items-start gap-3">
          <div class="w-10 h-10 rounded-2xl bg-red-600 text-white flex items-center justify-center shrink-0 text-xl font-bold animate-pulse">
            🚨
          </div>
          <div class="flex-1">
            <div class="flex items-center justify-between">
              <h2 class="text-base font-bold text-red-900">
                CẢNH BÁO NGUY CẤP: <?= count($criticalItems) ?> loại Thuốc / Vắc xin thiết yếu dưới ngưỡng an toàn!
              </h2>
              <span class="px-2.5 py-1 rounded-full bg-red-200 text-red-900 text-[10px] font-extrabold uppercase">
                Ưu tiên nhập gấp
              </span>
            </div>
            <p class="text-xs text-red-700 mt-1 leading-relaxed">
              Các loại thuốc cấp cứu, vắc xin phòng bệnh và thuốc đặc trị dưới đây sắp hết. Vui lòng liên hệ nhà cung cấp dược thú y ngay để tránh gián đoạn tiêm phòng & cấp cứu cho thú cưng!
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mt-3">
              <?php foreach ($criticalItems as $crit): ?>
                <div class="bg-white rounded-xl p-3 border border-red-200 shadow-2xs flex items-center justify-between">
                  <div>
                    <h4 class="font-bold text-xs text-gray-900"><?= htmlspecialchars($crit['name']) ?></h4>
                    <span class="text-[11px] text-gray-500 font-mono"><?= htmlspecialchars($crit['sku']) ?></span>
                  </div>
                  <div class="text-right">
                    <span class="inline-block px-2 py-0.5 rounded-md bg-red-100 text-red-700 font-extrabold text-xs">
                      Còn: <?= $crit['stock_quantity'] ?> / Min: <?= $crit['min_stock'] ?> <?= htmlspecialchars($crit['unit']) ?>
                    </span>
                    <button 
                      onclick="openAdjustModal(<?= $crit['id'] ?>, '<?= htmlspecialchars(addslashes($crit['name'])) ?>', 'import')"
                      class="block mt-1 text-[11px] font-bold text-emerald-700 hover:underline">
                      + Nhập hàng ngay
                    </button>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <!-- KPI Cards Thống kê kho -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
        <span class="text-xs font-semibold text-gray-500 uppercase">Tổng mặt hàng quản lý</span>
        <div class="text-3xl font-extrabold text-[#1a3d1a] mt-1"><?= $stats['total_items'] ?> <span class="text-xs font-normal text-gray-400">SKUs</span></div>
        <p class="text-[11px] text-gray-500 mt-1">Tổng <?= number_format($stats['total_units']) ?> đơn vị sản phẩm</p>
      </div>

      <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
        <span class="text-xs font-semibold text-gray-500 uppercase">Giá trị tồn kho (giá vốn)</span>
        <div class="text-2xl sm:text-3xl font-extrabold text-[#E86A10] mt-1"><?= formatVND($stats['total_value']) ?></div>
        <p class="text-[11px] text-gray-500 mt-1">Vốn lưu động trong kho hàng</p>
      </div>

      <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
        <span class="text-xs font-semibold text-amber-600 uppercase">Tồn kho dưới ngưỡng (Min)</span>
        <div class="text-3xl font-extrabold text-amber-600 mt-1"><?= $stats['low_stock_count'] ?> <span class="text-xs font-normal text-gray-400">mặt hàng</span></div>
        <p class="text-[11px] text-amber-700 mt-1">Cần lập kế hoạch đặt thêm</p>
      </div>

      <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs <?= $stats['critical_low_count'] > 0 ? 'bg-red-50/70 border-red-200' : '' ?>">
        <span class="text-xs font-semibold text-red-600 uppercase">Thuốc / Vắc xin nguy cấp</span>
        <div class="text-3xl font-extrabold text-red-600 mt-1"><?= $stats['critical_low_count'] ?> <span class="text-xs font-normal text-gray-400">loại</span></div>
        <p class="text-[11px] text-red-700 mt-1">Tuyệt đối không để đứt hàng</p>
      </div>
    </div>

    <!-- Tabs & Action Bar -->
    <div class="bg-white rounded-3xl p-5 border border-gray-100 shadow-xs space-y-4">
      <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-gray-100 pb-4">
        <!-- Tabs -->
        <div class="flex items-center gap-2">
          <a href="?tab=products" class="px-4 py-2 rounded-xl text-xs font-bold transition-all <?= $activeTab === 'products' ? 'bg-[#1a3d1a] text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' ?>">
            📦 Danh mục Hàng hóa & Tồn kho
          </a>
          <a href="?tab=logs" class="px-4 py-2 rounded-xl text-xs font-bold transition-all <?= $activeTab === 'logs' ? 'bg-[#1a3d1a] text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' ?>">
            📋 Lịch sử Nhập / Xuất kho (Audit Logs)
          </a>
        </div>

        <!-- Buttons Thêm mới -->
        <?php if ($activeTab === 'products'): ?>
          <button onclick="openCreateModal()" class="px-4 py-2 rounded-xl bg-[#E86A10] hover:bg-[#d45e0d] text-white font-bold text-xs flex items-center gap-1.5 shadow-sm transition-all cursor-pointer">
            <span>+ Thêm mặt hàng mới</span>
          </button>
        <?php endif; ?>
      </div>

      <?php if ($activeTab === 'products'): ?>
        <!-- Bộ lọc danh mục & Tìm kiếm -->
        <form method="GET" class="flex flex-wrap items-center gap-3">
          <input type="hidden" name="tab" value="products">

          <div class="flex-1 min-w-[200px]">
            <input 
              type="text" 
              name="q" 
              value="<?= htmlspecialchars($searchQuery ?? '') ?>" 
              placeholder="Tìm theo tên thuốc, thức ăn hoặc mã SKU..." 
              class="w-full px-3.5 py-2 rounded-xl border border-gray-200 text-xs focus:ring-2 focus:ring-[#1a3d1a] focus:outline-none"
            />
          </div>

          <div class="flex flex-wrap items-center gap-2">
            <a href="?tab=products" class="px-3 py-1.5 rounded-lg text-xs font-semibold <?= empty($selectedCat) && !$lowStockFilter ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' ?>">
              Tất cả
            </a>
            <a href="?tab=products&category=medicine" class="px-3 py-1.5 rounded-lg text-xs font-semibold <?= $selectedCat === 'medicine' ? 'bg-red-700 text-white' : 'bg-red-50 text-red-700 hover:bg-red-100' ?>">
              💊 Thuốc & Vắc xin
            </a>
            <a href="?tab=products&category=food" class="px-3 py-1.5 rounded-lg text-xs font-semibold <?= $selectedCat === 'food' ? 'bg-amber-700 text-white' : 'bg-amber-50 text-amber-700 hover:bg-amber-100' ?>">
              🥣 Thức ăn dinh dưỡng
            </a>
            <a href="?tab=products&category=supply" class="px-3 py-1.5 rounded-lg text-xs font-semibold <?= $selectedCat === 'supply' ? 'bg-blue-700 text-white' : 'bg-blue-50 text-blue-700 hover:bg-blue-100' ?>">
              🩹 Vật tư tiêu hao
            </a>
            <a href="?tab=products&category=accessory" class="px-3 py-1.5 rounded-lg text-xs font-semibold <?= $selectedCat === 'accessory' ? 'bg-purple-700 text-white' : 'bg-purple-50 text-purple-700 hover:bg-purple-100' ?>">
              🏠 Phụ kiện CozyPaws
            </a>
            <a href="?tab=products&low_stock=1" class="px-3 py-1.5 rounded-lg text-xs font-bold flex items-center gap-1 <?= $lowStockFilter ? 'bg-red-600 text-white animate-pulse' : 'bg-red-100 text-red-800 hover:bg-red-200' ?>">
              <span>⚠️ Tồn kho thấp (Cảnh báo)</span>
            </a>
          </div>
        </form>

        <!-- BẢNG DANH SÁCH SẢN PHẨM & TỒN KHO -->
        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs">
            <thead class="text-gray-400 uppercase border-b border-gray-100 pb-2">
              <tr>
                <th class="py-3 px-2">Sản phẩm / SKU</th>
                <th>Phân loại</th>
                <th>Giá bán</th>
                <th>Giá vốn</th>
                <th class="text-center">Tồn kho</th>
                <th class="text-center">Mức an toàn (Min)</th>
                <th>Trạng thái kho</th>
                <th class="text-right px-2">Thao tác kho</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              <?php if (empty($products)): ?>
                <tr>
                  <td colspan="8" class="text-center py-8 text-gray-400">Không tìm thấy mặt hàng nào phù hợp điều kiện lọc.</td>
                </tr>
              <?php endif; ?>

              <?php foreach ($products as $p): 
                $isLow = $p['stock_quantity'] <= $p['min_stock'];
                $isCritical = (bool)$p['is_critical'];
              ?>
                <tr class="hover:bg-gray-50/70 transition-colors <?= ($isCritical && $isLow) ? 'bg-red-50/40' : '' ?>">
                  <td class="py-3 px-2">
                    <div class="flex items-center gap-2.5">
                      <div class="w-10 h-10 rounded-xl overflow-hidden bg-gray-100 shrink-0 border border-gray-200">
                        <img src="<?= htmlspecialchars($p['image'] ?: 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=100&q=80') ?>" alt="" class="w-full h-full object-cover">
                      </div>
                      <div>
                        <div class="font-bold text-gray-900 flex items-center gap-1.5">
                          <span><?= htmlspecialchars($p['name']) ?></span>
                          <?php if ($isCritical): ?>
                            <span class="px-1.5 py-0.5 rounded-md bg-red-100 text-red-700 text-[9px] font-extrabold uppercase" title="Thuốc thiết yếu">
                              Thiết yếu
                            </span>
                          <?php endif; ?>
                        </div>
                        <div class="text-gray-400 font-mono text-[11px]"><?= htmlspecialchars($p['sku']) ?> • ĐVT: <?= htmlspecialchars($p['unit']) ?></div>
                      </div>
                    </div>
                  </td>

                  <td>
                    <?php if ($p['category'] === 'medicine'): ?>
                      <span class="px-2 py-0.5 rounded-full bg-red-50 text-red-700 font-semibold text-[10px]">💊 Thuốc & Vắc xin</span>
                    <?php elseif ($p['category'] === 'food'): ?>
                      <span class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 font-semibold text-[10px]">🥣 Thức ăn</span>
                    <?php elseif ($p['category'] === 'supply'): ?>
                      <span class="px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 font-semibold text-[10px]">🩹 Vật tư y tế</span>
                    <?php else: ?>
                      <span class="px-2 py-0.5 rounded-full bg-purple-50 text-purple-700 font-semibold text-[10px]">🏠 Phụ kiện</span>
                    <?php endif; ?>
                  </td>

                  <td class="font-bold text-[#1a3d1a]"><?= formatVND((float)$p['price']) ?></td>
                  <td class="text-gray-500"><?= formatVND((float)$p['cost_price']) ?></td>

                  <!-- Số lượng tồn kho -->
                  <td class="text-center">
                    <span class="text-base font-extrabold <?= $isLow ? 'text-red-600' : 'text-gray-900' ?>">
                      <?= $p['stock_quantity'] ?>
                    </span>
                    <span class="text-gray-400 text-[10px] block"><?= htmlspecialchars($p['unit']) ?></span>
                  </td>

                  <!-- Mức an toàn -->
                  <td class="text-center text-gray-500 font-semibold">
                    <?= $p['min_stock'] ?> <?= htmlspecialchars($p['unit']) ?>
                  </td>

                  <!-- Trạng thái kho & Cảnh báo -->
                  <td>
                    <?php if ($p['stock_quantity'] <= 0): ?>
                      <span class="px-2 py-1 rounded-full bg-red-600 text-white font-extrabold text-[10px]">Hết hàng</span>
                    <?php elseif ($isCritical && $isLow): ?>
                      <span class="px-2.5 py-1 rounded-full bg-red-100 text-red-800 border border-red-300 font-extrabold text-[10px] inline-flex items-center gap-1 animate-pulse">
                        <span>🚨</span> Nguy cấp! Cần nhập
                      </span>
                    <?php elseif ($isLow): ?>
                      <span class="px-2 py-1 rounded-full bg-amber-100 text-amber-800 font-bold text-[10px]">
                        ⚠️ Tồn thấp
                      </span>
                    <?php else: ?>
                      <span class="px-2 py-1 rounded-full bg-green-50 text-green-700 font-semibold text-[10px]">
                        ✓ Đủ hàng
                      </span>
                    <?php endif; ?>
                  </td>

                  <!-- Thao tác nhập / xuất nhanh -->
                  <td class="text-right px-2 space-x-1">
                    <button 
                      onclick="openAdjustModal(<?= $p['id'] ?>, '<?= htmlspecialchars(addslashes($p['name'])) ?>', 'import')"
                      class="px-2.5 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold text-[11px] transition-colors cursor-pointer"
                      title="Nhập thêm hàng vào kho">
                      📥 Nhập
                    </button>
                    <button 
                      onclick="openAdjustModal(<?= $p['id'] ?>, '<?= htmlspecialchars(addslashes($p['name'])) ?>', 'export')"
                      class="px-2.5 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-[11px] transition-colors cursor-pointer"
                      title="Xuất kho / Dùng điều trị cho thú cưng">
                      📤 Xuất
                    </button>
                    <button 
                      onclick='openEditModal(<?= json_encode($p, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'
                      class="px-2.5 py-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-[11px] transition-colors cursor-pointer"
                      title="Sửa thông tin">
                      ✏️ Sửa
                    </button>
                    <form method="POST" action="/admin/inventory.php?tab=products" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa mặt hàng <?= htmlspecialchars(addslashes($p['name'])) ?> khỏi kho?');">
                      <input type="hidden" name="action" value="delete_product">
                      <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                      <button type="submit" class="px-2 py-1.5 rounded-lg bg-gray-100 hover:bg-red-100 text-gray-500 hover:text-red-700 font-semibold text-[11px] transition-colors cursor-pointer" title="Xóa mặt hàng">
                        🗑️
                      </button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

      <?php else: ?>
        <!-- ======================================================== -->
        <!-- TAB 2: LỊCH SỬ NHẬP / XUẤT KHO (AUDIT LOGS)                -->
        <!-- ======================================================== -->
        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs">
            <thead class="text-gray-400 uppercase border-b border-gray-100 pb-2">
              <tr>
                <th class="py-3 px-2">Thời gian</th>
                <th>Sản phẩm</th>
                <th>Loại giao dịch</th>
                <th class="text-center">Số lượng</th>
                <th class="text-center">Tồn trước $\rightarrow$ sau</th>
                <th>Lý do / Ghi chú</th>
                <th>Người thực hiện</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 font-mono text-[11px]">
              <?php if (empty($logs)): ?>
                <tr>
                  <td colspan="7" class="text-center py-8 text-gray-400 font-sans">Chưa có lịch sử nhập xuất kho.</td>
                </tr>
              <?php endif; ?>

              <?php foreach ($logs as $log): ?>
                <tr class="hover:bg-gray-50/70">
                  <td class="py-2.5 px-2 text-gray-500 font-sans">
                    <?= date('H:i:s d/m/Y', strtotime($log['created_at'])) ?>
                  </td>
                  <td class="font-sans">
                    <strong class="text-gray-900"><?= htmlspecialchars($log['product_name']) ?></strong>
                    <span class="text-gray-400 block text-[10px]"><?= htmlspecialchars($log['sku']) ?></span>
                  </td>
                  <td>
                    <?php if ($log['change_type'] === 'import'): ?>
                      <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-bold font-sans text-[10px]">📥 Nhập kho</span>
                    <?php elseif ($log['change_type'] === 'export'): ?>
                      <span class="px-2 py-0.5 rounded-full bg-rose-50 text-rose-700 font-bold font-sans text-[10px]">📤 Xuất dùng</span>
                    <?php elseif ($log['change_type'] === 'sale'): ?>
                      <span class="px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 font-bold font-sans text-[10px]">🛒 Bán lẻ</span>
                    <?php else: ?>
                      <span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-700 font-bold font-sans text-[10px]">Kiểm kê</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-center font-bold font-sans text-xs <?= $log['change_type'] === 'import' ? 'text-emerald-700' : 'text-rose-600' ?>">
                    <?= $log['change_type'] === 'import' ? '+' : '-' ?><?= $log['quantity'] ?> <?= htmlspecialchars($log['unit']) ?>
                  </td>
                  <td class="text-center text-gray-600">
                    <?= $log['stock_before'] ?> $\rightarrow$ <strong><?= $log['stock_after'] ?></strong>
                  </td>
                  <td class="font-sans text-gray-700 max-w-[240px] truncate" title="<?= htmlspecialchars($log['note'] ?? '') ?>">
                    <?= htmlspecialchars($log['note'] ?: '—') ?>
                  </td>
                  <td class="font-sans text-gray-600">
                    <?= htmlspecialchars($log['created_by']) ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </main>

  <!-- ======================================================== -->
  <!-- MODAL: NHẬP / XUẤT KHO NHANH                             -->
  <!-- ======================================================== -->
  <div id="modal-adjust" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs hidden">
    <div class="bg-white rounded-3xl w-full max-w-md p-6 shadow-2xl relative border border-gray-100">
      <button onclick="closeAdjustModal()" type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-lg font-bold">✕</button>

      <h3 id="adjust-modal-title" class="text-base font-bold text-[#1a3d1a] mb-1">Nhập / Xuất kho</h3>
      <p id="adjust-product-name" class="text-xs text-gray-500 mb-4 font-semibold">—</p>

      <form method="POST" class="space-y-4">
        <input type="hidden" name="action" value="adjust_stock">
        <input type="hidden" id="adjust-product-id" name="product_id" value="">
        <input type="hidden" id="adjust-change-type" name="change_type" value="import">

        <div>
          <label class="block text-xs font-semibold text-gray-700 mb-1">Số lượng điều chỉnh *</label>
          <input type="number" id="adjust-quantity" name="quantity" min="1" value="10" required class="w-full px-3.5 py-2 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#1a3d1a] focus:outline-none">
        </div>

        <div>
          <label class="block text-xs font-semibold text-gray-700 mb-1">Lý do / Ghi chú (VD: Lô vắc xin mới, Dùng cho ca khám bé Mochi...)</label>
          <textarea name="note" rows="2" placeholder="Ghi chú chi tiết nguồn nhập hoặc ca bệnh sử dụng..." class="w-full px-3.5 py-2 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#1a3d1a] focus:outline-none"></textarea>
        </div>

        <div class="flex gap-2 pt-2">
          <button type="button" onclick="closeAdjustModal()" class="flex-1 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-semibold text-xs hover:bg-gray-50">Hủy</button>
          <button id="adjust-submit-btn" type="submit" class="flex-1 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs shadow-md transition-all">
            Xác nhận
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- ======================================================== -->
  <!-- MODAL: THÊM MỚI SẢN PHẨM / THUỐC                        -->
  <!-- ======================================================== -->
  <div id="modal-create" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs hidden">
    <div class="bg-white rounded-3xl w-full max-w-lg p-6 shadow-2xl relative border border-gray-100 max-h-[90vh] overflow-y-auto">
      <button onclick="closeCreateModal()" type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-lg font-bold">✕</button>

      <h3 class="text-base font-bold text-[#1a3d1a] mb-1">Thêm mặt hàng mới vào kho</h3>
      <p class="text-xs text-gray-500 mb-4">Nhập thông tin thuốc thú y, thức ăn hoặc vật tư y tế</p>

      <form method="POST" action="/admin/inventory.php?tab=products" class="space-y-3.5">
        <input type="hidden" name="action" value="create_product">

        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Mã SKU (Tùy chọn)</label>
            <input type="text" name="sku" placeholder="Tự sinh nếu để trống" class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#1a3d1a] uppercase font-mono">
          </div>
          <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Danh mục *</label>
            <select name="category" class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#1a3d1a]">
              <option value="food">🥣 Thức ăn dinh dưỡng</option>
              <option value="medicine">💊 Thuốc & Vắc xin</option>
              <option value="supply">🩹 Vật tư tiêu hao</option>
              <option value="accessory">🏠 Phụ kiện CozyPaws</option>
            </select>
          </div>
        </div>

        <div>
          <label class="block text-xs font-semibold text-gray-700 mb-1">Tên sản phẩm *</label>
          <input type="text" name="name" required placeholder="Tên thuốc hoặc thức ăn thú cưng..." class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#1a3d1a]">
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Giá bán (VND) *</label>
            <input type="number" name="price" step="1000" min="0" value="100000" required class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#1a3d1a]">
          </div>
          <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Giá vốn (VND)</label>
            <input type="number" name="cost_price" step="1000" min="0" value="65000" class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#1a3d1a]">
          </div>
        </div>

        <div class="grid grid-cols-3 gap-3">
          <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Tồn kho ban đầu</label>
            <input type="number" name="stock_quantity" min="0" value="20" class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#1a3d1a]">
          </div>
          <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Mức Min an toàn *</label>
            <input type="number" name="min_stock" min="1" value="5" required class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#1a3d1a]" title="Hệ thống sẽ báo động khi số lượng tồn <= mức này">
          </div>
          <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Đơn vị tính</label>
            <input type="text" name="unit" value="Hộp" placeholder="Liều, Lọ, Gói..." class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#1a3d1a]">
          </div>
        </div>

        <div>
          <label class="block text-xs font-semibold text-gray-700 mb-1">Link hình ảnh (Tùy chọn)</label>
          <input type="text" name="image" placeholder="https://... hoặc để trống để dùng ảnh mẫu mặc định" class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#1a3d1a]">
        </div>

        <div>
          <label class="block text-xs font-semibold text-gray-700 mb-1">Mô tả công dụng / Thành phần</label>
          <textarea name="description" rows="2" placeholder="Chỉ định dùng, liều lượng hoặc hướng dẫn bảo quản..." class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#1a3d1a]"></textarea>
        </div>

        <!-- Đánh dấu thuốc thiết yếu -->
        <div class="p-3 rounded-xl bg-red-50 border border-red-200">
          <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_critical" value="1" class="w-4 h-4 text-red-600 rounded">
            <div>
              <span class="text-xs font-bold text-red-900 block">Đánh dấu Thuốc / Vắc xin thiết yếu (Ưu tiên cảnh báo)</span>
              <span class="text-[10px] text-red-700">Hệ thống sẽ đưa vào bảng cảnh báo đỏ khẩn cấp trên Dashboard khi tồn kho dưới mức Min.</span>
            </div>
          </label>
        </div>

        <div class="flex gap-2 pt-2">
          <button type="button" onclick="closeCreateModal()" class="flex-1 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-semibold text-xs hover:bg-gray-50">Hủy</button>
          <button type="submit" class="flex-1 py-2.5 rounded-xl bg-[#E86A10] hover:bg-[#d45e0d] text-white font-bold text-xs shadow-md transition-all">
            Lưu mặt hàng
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- ======================================================== -->
  <!-- MODAL: SỬA SẢN PHẨM                                      -->
  <!-- ======================================================== -->
  <div id="modal-edit" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs hidden">
    <div class="bg-white rounded-3xl w-full max-w-lg p-6 shadow-2xl relative border border-gray-100 max-h-[90vh] overflow-y-auto">
      <button onclick="closeEditModal()" type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-lg font-bold">✕</button>

      <h3 class="text-base font-bold text-[#1a3d1a] mb-1">Cập nhật thông tin hàng hóa</h3>
      <p class="text-xs text-gray-500 mb-4">Thay đổi giá bán, ngưỡng cảnh báo an toàn và phân loại</p>

      <form method="POST" action="/admin/inventory.php?tab=products" class="space-y-3.5">
        <input type="hidden" name="action" value="update_product">
        <input type="hidden" id="edit-id" name="product_id" value="">

        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Mã SKU *</label>
            <input type="text" id="edit-sku" name="sku" required class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#1a3d1a] uppercase font-mono">
          </div>
          <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Danh mục *</label>
            <select id="edit-category" name="category" class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#1a3d1a]">
              <option value="medicine">💊 Thuốc & Vắc xin</option>
              <option value="food">🥣 Thức ăn dinh dưỡng</option>
              <option value="supply">🩹 Vật tư tiêu hao</option>
              <option value="accessory">🏠 Phụ kiện CozyPaws</option>
            </select>
          </div>
        </div>

        <div>
          <label class="block text-xs font-semibold text-gray-700 mb-1">Tên sản phẩm *</label>
          <input type="text" id="edit-name" name="name" required class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#1a3d1a]">
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Giá bán (VND) *</label>
            <input type="number" id="edit-price" name="price" step="1000" min="0" required class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#1a3d1a]">
          </div>
          <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Giá vốn (VND)</label>
            <input type="number" id="edit-cost-price" name="cost_price" step="1000" min="0" class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#1a3d1a]">
          </div>
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Mức Min an toàn *</label>
            <input type="number" id="edit-min-stock" name="min_stock" min="1" required class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#1a3d1a]">
          </div>
          <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Đơn vị tính</label>
            <input type="text" id="edit-unit" name="unit" class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#1a3d1a]">
          </div>
        </div>

        <div>
          <label class="block text-xs font-semibold text-gray-700 mb-1">Link hình ảnh (URL hoặc đường dẫn)</label>
          <input type="text" id="edit-image" name="image" class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#1a3d1a]">
        </div>

        <div>
          <label class="block text-xs font-semibold text-gray-700 mb-1">Mô tả công dụng / Thành phần</label>
          <textarea id="edit-description" name="description" rows="2" class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#1a3d1a]"></textarea>
        </div>

        <div class="p-3 rounded-xl bg-red-50 border border-red-200">
          <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" id="edit-is-critical" name="is_critical" value="1" class="w-4 h-4 text-red-600 rounded">
            <div>
              <span class="text-xs font-bold text-red-900 block">Thuốc / Vắc xin thiết yếu (Ưu tiên cảnh báo đỏ)</span>
              <span class="text-[10px] text-red-700">Đánh dấu nếu đây là mặt hàng phục vụ điều trị khẩn cấp.</span>
            </div>
          </label>
        </div>

        <div class="flex gap-2 pt-2">
          <button type="button" onclick="closeEditModal()" class="flex-1 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-semibold text-xs hover:bg-gray-50">Hủy</button>
          <button type="submit" class="flex-1 py-2.5 rounded-xl bg-[#1a3d1a] hover:bg-[#2a5a2a] text-white font-bold text-xs shadow-md transition-all">
            Cập nhật
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Logic Modal Nhập / Xuất kho
    function openAdjustModal(id, name, type) {
      document.getElementById('adjust-product-id').value = id;
      document.getElementById('adjust-product-name').textContent = name;
      document.getElementById('adjust-change-type').value = type;

      const titleEl = document.getElementById('adjust-modal-title');
      const submitBtn = document.getElementById('adjust-submit-btn');

      if (type === 'import') {
        titleEl.textContent = '📥 Nhập kho hàng hóa';
        submitBtn.className = 'flex-1 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs shadow-md transition-all cursor-pointer';
        submitBtn.textContent = 'Xác nhận nhập kho';
      } else {
        titleEl.textContent = '📤 Xuất kho / Sử dụng điều trị';
        submitBtn.className = 'flex-1 py-2.5 rounded-xl bg-rose-700 hover:bg-rose-800 text-white font-bold text-xs shadow-md transition-all cursor-pointer';
        submitBtn.textContent = 'Xác nhận xuất kho';
      }

      document.getElementById('modal-adjust').classList.remove('hidden');
    }

    function closeAdjustModal() {
      document.getElementById('modal-adjust').classList.add('hidden');
    }

    // Logic Modal Thêm mới
    function openCreateModal() {
      document.getElementById('modal-create').classList.remove('hidden');
    }
    function closeCreateModal() {
      document.getElementById('modal-create').classList.add('hidden');
    }

    // Logic Modal Sửa
    function openEditModal(p) {
      document.getElementById('edit-id').value = p.id;
      document.getElementById('edit-sku').value = p.sku;
      document.getElementById('edit-name').value = p.name;
      document.getElementById('edit-category').value = p.category;
      document.getElementById('edit-price').value = p.price;
      document.getElementById('edit-cost-price').value = p.cost_price;
      document.getElementById('edit-min-stock').value = p.min_stock;
      document.getElementById('edit-unit').value = p.unit;
      document.getElementById('edit-image').value = p.image || '';
      document.getElementById('edit-description').value = p.description || '';
      document.getElementById('edit-is-critical').checked = (parseInt(p.is_critical) === 1);

      document.getElementById('modal-edit').classList.remove('hidden');
    }
    function closeEditModal() {
      document.getElementById('modal-edit').classList.add('hidden');
    }

    // Khởi tạo Lucide Icons nếu có
    if (typeof lucide !== 'undefined') lucide.createIcons();
  </script>
</body>
</html>
