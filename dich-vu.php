<?php
/**
 * PawNest - Trang Dịch vụ & Gói chăm sóc (Mục 2.2, FR-10, FR-11)
 * Hiển thị danh sách dịch vụ: tên, mô tả, thời lượng, giá, phụ thu theo cân nặng
 */

declare(strict_types=1);

$page_title = 'Dịch Vụ & Gói Chăm Sóc Thú Cưng | PawNest';
$page_desc = 'Danh sách dịch vụ khám chữa bệnh, tiêm chủng vaccine, spa và cắt tỉa lông chó mèo chuyên nghiệp tại PawNest.';
$active_menu = 'services';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/repository/ServiceRepository.php';

$serviceRepo = new ServiceRepository();
$servicesList = $serviceRepo->findActive();

// Helper gán biểu tượng và phân loại trực quan cho dịch vụ
function getServiceMeta(string $name, int|string $is_package): array {
    $n = mb_strtolower($name, 'UTF-8');
    if (str_contains($n, 'khám') || str_contains($n, 'chẩn đoán') || str_contains($n, 'điều trị')) {
        return ['icon' => '🩺', 'bg' => 'bg-emerald-100 text-[#1a3d1a]', 'badge' => 'Khám & Điều trị'];
    }
    if (str_contains($n, 'tiêm') || str_contains($n, 'vắc') || str_contains($n, 'vac') || str_contains($n, 'giun')) {
        return ['icon' => '💉', 'bg' => 'bg-amber-100 text-[#E86A10]', 'badge' => 'Tiêm chủng & Phòng ngừa'];
    }
    if (str_contains($n, 'tắm') || str_contains($n, 'spa') || str_contains($n, 'thơm')) {
        return ['icon' => '🛁', 'bg' => 'bg-blue-100 text-blue-700', 'badge' => 'Spa & Thư giãn'];
    }
    if (str_contains($n, 'cắt') || str_contains($n, 'tỉa') || str_contains($n, 'kiểu') || str_contains($n, 'groom')) {
        return ['icon' => '✂️', 'bg' => 'bg-pink-100 text-pink-700', 'badge' => 'Grooming Thẩm mỹ'];
    }
    if (str_contains($n, 'khách sạn') || str_contains($n, 'lưu trú') || str_contains($n, 'hotel')) {
        return ['icon' => '🏨', 'bg' => 'bg-purple-100 text-purple-700', 'badge' => 'Lưu trú Khách sạn'];
    }
    if (str_contains($n, 'cấp cứu') || str_contains($n, 'hồi sức')) {
        return ['icon' => '🚨', 'bg' => 'bg-red-100 text-red-600', 'badge' => 'Cấp cứu 24/7'];
    }
    if (!empty($is_package)) {
        return ['icon' => '⭐', 'bg' => 'bg-amber-100 text-amber-700', 'badge' => 'Gói trọn gói'];
    }
    return ['icon' => '🐾', 'bg' => 'bg-emerald-50 text-emerald-800', 'badge' => 'Dịch vụ thú y'];
}
?>

<main class="py-12 px-4 sm:px-6 max-w-6xl mx-auto">
  <!-- Tiêu đề trang -->
  <div class="text-center max-w-2xl mx-auto mb-12">
    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-semibold mb-3">
      <span>🐾 Dịch vụ Y Tế & Spa Chuẩn Quốc Tế</span>
    </div>
    <h1 class="font-serif-display text-3xl sm:text-4xl text-[#1a3d1a] tracking-tight">
      Chăm Sóc Toàn Diện Cho Bé Cưng
    </h1>
    <p class="text-xs sm:text-sm text-gray-600 mt-2">
      PawNest cung cấp quy trình chăm sóc chuyên sâu với đội ngũ bác sĩ thú y giàu kinh nghiệm và trang thiết bị hiện đại.
    </p>
  </div>

  <!-- Lưới dịch vụ động lấy từ Cơ sở Dữ liệu (MySQL) -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
    <?php if (!empty($servicesList)): ?>
      <?php foreach ($servicesList as $svc): 
        $meta = getServiceMeta($svc['name'], $svc['is_package'] ?? 0);
      ?>
        <div class="clay-card p-6 flex flex-col justify-between hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
          <div>
            <div class="flex items-center justify-between mb-4">
              <div class="w-12 h-12 rounded-2xl <?= $meta['bg'] ?> flex items-center justify-center text-2xl shadow-2xs">
                <?= $meta['icon'] ?>
              </div>
              <span class="px-2.5 py-1 rounded-full text-[10px] font-bold <?= !empty($svc['is_package']) ? 'bg-[#E86A10]/10 text-[#E86A10]' : 'bg-gray-100 text-gray-600' ?>">
                <?= $meta['badge'] ?>
              </span>
            </div>

            <h3 class="font-bold text-lg text-[#1a3d1a] leading-snug"><?= e($svc['name']) ?></h3>
            <p class="text-xs text-gray-600 mt-2 leading-relaxed">
              <?= e($svc['description'] ?: 'Quy trình kiểm tra và chăm sóc chuyên nghiệp theo chuẩn quốc tế tại PawNest.') ?>
            </p>

            <div class="mt-4 flex items-center justify-between text-xs text-gray-500 border-t border-gray-100 pt-3">
              <span>Thời lượng: <strong><?= (int)$svc['duration_min'] ?> phút</strong></span>
              <span class="text-emerald-700 font-extrabold text-sm"><?= number_format((float)$svc['price'], 0, ',', '.') ?> ₫</span>
            </div>
          </div>

          <div class="mt-5">
            <a href="/dat-lich.php?service=<?= urlencode($svc['name']) ?>" class="w-full clay-btn-orange py-2.5 text-xs inline-flex items-center justify-center gap-1.5 font-bold shadow-xs">
              <span>Đặt lịch ngay</span>
              <span>→</span>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>

    <!-- Card Cấp cứu 24/7 cố định -->
    <div class="clay-card p-6 flex flex-col justify-between border-2 border-red-200 bg-red-50/20">
      <div>
        <div class="flex items-center justify-between mb-4">
          <div class="w-12 h-12 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center text-2xl shadow-2xs">
            🚨
          </div>
          <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-700">Khẩn cấp</span>
        </div>
        <h3 class="font-bold text-lg text-red-800">Cấp Cứu Thú Y 24/7</h3>
        <p class="text-xs text-gray-600 mt-2 leading-relaxed">
          Trực cấp cứu xuyên đêm, trang bị lồng ấp oxy, máy thở, máy xét nghiệm sinh lý nhanh và phòng mổ vô trùng.
        </p>
        <div class="mt-4 flex items-center justify-between text-xs text-gray-500 border-t border-gray-100 pt-3">
          <span>Thời lượng: <strong>Khẩn cấp</strong></span>
          <span class="text-red-600 font-bold text-sm">Hotline: 0900 123 456</span>
        </div>
      </div>
      <div class="mt-5">
        <a href="tel:0900123456" class="w-full py-2.5 rounded-full bg-red-600 hover:bg-red-700 text-white font-bold text-xs inline-flex items-center justify-center gap-2 shadow-sm transition-all active:scale-98">
          <span>Gọi cấp cứu ngay</span>
        </a>
      </div>
    </div>
  </div>

  <!-- Quy định phụ thu cân nặng (Mục 2.2, FR-10) -->
  <div class="clay-card p-8 bg-[#FFF1E0] border border-amber-200">
    <h3 class="font-bold text-[#1a3d1a] text-lg mb-2">⚖️ Bảng Quy Định Phụ Thu Theo Cân Nặng</h3>
    <p class="text-xs text-gray-700 mb-4">
      Giá niêm yết áp dụng cho các bé có trọng lượng dưới 5kg. Với các bé lớn hơn, phụ thu tính như sau:
    </p>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
      <div class="bg-white/80 p-3 rounded-2xl border border-amber-200">
        <span class="block text-xs font-bold text-gray-600">Dưới 5 kg</span>
        <span class="text-emerald-700 font-extrabold text-sm">Giá gốc</span>
      </div>
      <div class="bg-white/80 p-3 rounded-2xl border border-amber-200">
        <span class="block text-xs font-bold text-gray-600">Từ 5 - 10 kg</span>
        <span class="text-[#E86A10] font-extrabold text-sm">+30.000 ₫</span>
      </div>
      <div class="bg-white/80 p-3 rounded-2xl border border-amber-200">
        <span class="block text-xs font-bold text-gray-600">Từ 10 - 20 kg</span>
        <span class="text-[#E86A10] font-extrabold text-sm">+60.000 ₫</span>
      </div>
      <div class="bg-white/80 p-3 rounded-2xl border border-amber-200">
        <span class="block text-xs font-bold text-gray-600">Trên 20 kg</span>
        <span class="text-[#E86A10] font-extrabold text-sm">+100.000 ₫</span>
      </div>
    </div>
  </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
