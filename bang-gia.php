<?php
/**
 * PawNest - Trang Bảng Giá & Gói Chăm Sóc (Mục 2.2, FR-10, FR-11)
 * 3 gói chăm sóc: Cơ bản, Spa & cắt tỉa, Toàn diện
 */

declare(strict_types=1);

$page_title = 'Bảng Giá 3 Gói Chăm Sóc Thú Cưng | PawNest';
$page_desc = 'Bảng giá công khai minh bạch 3 gói chăm sóc thú cưng tại PawNest: Gói Cơ bản, Spa & Cắt tỉa, và Gói Toàn diện.';
$active_menu = 'pricing';

require_once __DIR__ . '/includes/header.php';
?>

<main class="py-12 px-4 sm:px-6 max-w-6xl mx-auto">
  <div class="text-center max-w-2xl mx-auto mb-12">
    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-semibold mb-3">
      <span>💰 Công Khai • Minh Bạch • Không Phát Sinh</span>
    </div>
    <h1 class="font-serif-display text-3xl sm:text-4xl text-[#1a3d1a] tracking-tight">
      Bảng Giá 3 Gói Chăm Sóc Thú Cưng
    </h1>
    <p class="text-xs sm:text-sm text-gray-600 mt-2">
      Chọn gói dịch vụ phù hợp nhất cho bé cưng. Đặt lịch online nhận ngay ưu đãi giảm 10% cho lần hẹn đầu tiên!
    </p>
  </div>

  <!-- 3 Gói Chăm Sóc (Tiêu chuẩn Claymorphism) -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch mb-16">
    <!-- GÓI 1: CƠ BẢN -->
    <div class="clay-card p-7 flex flex-col justify-between border border-gray-100">
      <div>
        <div class="flex items-center justify-between mb-4">
          <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tiết kiệm</span>
          <span class="px-2.5 py-1 rounded-full bg-gray-100 text-gray-700 text-[10px] font-bold">45 - 60 phút</span>
        </div>
        <h3 class="font-bold text-2xl text-[#1a3d1a]">Gói Cơ Bản</h3>
        <p class="text-xs text-gray-500 mt-1">Tắm sạch, vệ sinh tai móng định kỳ hàng tuần</p>
        <div class="my-6">
          <span class="text-3xl font-extrabold text-[#1a3d1a]">150.000 ₫</span>
          <span class="text-xs text-gray-400"> / lượt (bé <5kg)</span>
        </div>
        <ul class="space-y-3 text-xs text-gray-600">
          <li class="flex items-center gap-2.5"><span class="text-emerald-600 font-bold">✓</span> Tắm xà phòng thảo mộc dịu nhẹ</li>
          <li class="flex items-center gap-2.5"><span class="text-emerald-600 font-bold">✓</span> Vệ sinh tai & nhổ lông tai</li>
          <li class="flex items-center gap-2.5"><span class="text-emerald-600 font-bold">✓</span> Cắt bấm và mài dũa móng</li>
          <li class="flex items-center gap-2.5"><span class="text-emerald-600 font-bold">✓</span> Vắt tuyến hôi chuẩn kỹ thuật</li>
          <li class="flex items-center gap-2.5 text-gray-300"><span>✕</span> Cắt tỉa và tạo kiểu lông</li>
        </ul>
      </div>
      <div class="mt-8">
        <a href="/dat-lich.php?service=Gói Cơ bản" class="w-full clay-btn-green py-3 text-xs">
          Chọn Gói Cơ Bản
        </a>
      </div>
    </div>

    <!-- GÓI 2: SPA & CẮT TỈA (NỔI BẬT) -->
    <div class="clay-card p-8 flex flex-col justify-between border-2 border-[#E86A10] relative shadow-xl transform md:-translate-y-2 bg-gradient-to-b from-white to-amber-50/30">
      <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-[#E86A10] text-white px-4 py-1 rounded-full text-[11px] font-extrabold tracking-wide uppercase shadow">
        ⭐ Phổ biến nhất
      </div>
      <div>
        <div class="flex items-center justify-between mb-4 mt-1">
          <span class="text-xs font-bold text-[#E86A10] uppercase tracking-wider">Được chọn 68%</span>
          <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 text-[10px] font-bold">90 - 120 phút</span>
        </div>
        <h3 class="font-bold text-2xl text-[#1a3d1a]">Gói Spa & Cắt Tỉa</h3>
        <p class="text-xs text-gray-500 mt-1">Lột xác diện mạo, thơm tho sạch sẽ toàn diện</p>
        <div class="my-6">
          <span class="text-3xl font-extrabold text-[#E86A10]">280.000 ₫</span>
          <span class="text-xs text-gray-400"> / lượt (bé <5kg)</span>
        </div>
        <ul class="space-y-3 text-xs text-gray-700">
          <li class="flex items-center gap-2.5"><span class="text-emerald-600 font-bold">✓</span> Toàn bộ các bước của Gói Cơ Bản</li>
          <li class="flex items-center gap-2.5"><span class="text-emerald-600 font-bold">✓</span> Sấy phồng, chải gỡ rối lông xơ</li>
          <li class="flex items-center gap-2.5"><span class="text-emerald-600 font-bold">✓</span> Cắt tỉa tạo dáng lông theo yêu cầu</li>
          <li class="flex items-center gap-2.5"><span class="text-emerald-600 font-bold">✓</span> Cắt lông bàn chân, bụng, hậu môn</li>
          <li class="flex items-center gap-2.5"><span class="text-emerald-600 font-bold">✓</span> Xịt dưỡng tinh dầu thơm giữ mùi 7 ngày</li>
        </ul>
      </div>
      <div class="mt-8">
        <a href="/dat-lich.php?service=Gói Spa & cắt tỉa" class="w-full clay-btn-orange py-3.5 text-xs">
          Chọn Gói Spa & Cắt Tỉa
        </a>
      </div>
    </div>

    <!-- GÓI 3: TOÀN DIỆN -->
    <div class="clay-card p-7 flex flex-col justify-between border border-gray-100">
      <div>
        <div class="flex items-center justify-between mb-4">
          <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider">VIP Care</span>
          <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">120 - 150 phút</span>
        </div>
        <h3 class="font-bold text-2xl text-[#1a3d1a]">Gói Toàn Diện</h3>
        <p class="text-xs text-gray-500 mt-1">Spa thư giãn kết hợp khám tổng quát bởi Bác sĩ Khang</p>
        <div class="my-6">
          <span class="text-3xl font-extrabold text-[#1a3d1a]">450.000 ₫</span>
          <span class="text-xs text-gray-400"> / lượt (bé <5kg)</span>
        </div>
        <ul class="space-y-3 text-xs text-gray-600">
          <li class="flex items-center gap-2.5"><span class="text-emerald-600 font-bold">✓</span> Toàn bộ quy trình Gói Spa & Cắt Tỉa</li>
          <li class="flex items-center gap-2.5"><span class="text-emerald-600 font-bold">✓</span> Ngâm bồn sục khí Nano Collagen</li>
          <li class="flex items-center gap-2.5"><span class="text-emerald-600 font-bold">✓</span> Khám tổng quát & tư vấn dinh dưỡng</li>
          <li class="flex items-center gap-2.5"><span class="text-emerald-600 font-bold">✓</span> Lấy cao răng bằng sóng siêu âm</li>
          <li class="flex items-center gap-2.5"><span class="text-emerald-600 font-bold">✓</span> Tặng 01 phần pate / snack thưởng</li>
        </ul>
      </div>
      <div class="mt-8">
        <a href="/dat-lich.php?service=Gói Toàn diện" class="w-full clay-btn-green py-3 text-xs">
          Chọn Gói Toàn Diện
        </a>
      </div>
    </div>
  </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
