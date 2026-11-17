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
require_once __DIR__ . '/includes/db.php';

// Lấy danh sách dịch vụ từ MySQL nếu có
$servicesList = [];
try {
    $stmt = $pdo->query("SELECT * FROM services WHERE is_active = 1 ORDER BY is_package ASC, id ASC");
    $servicesList = $stmt->fetchAll();
} catch (Exception $e) {
    // Fallback static
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

  <!-- Lưới dịch vụ chính (CSS Grid auto-fit) -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
    <!-- 1. Khám tổng quát & Chẩn đoán -->
    <div class="clay-card p-6 flex flex-col justify-between">
      <div>
        <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-[#1a3d1a] flex items-center justify-center text-2xl mb-4">
          🩺
        </div>
        <h3 class="font-bold text-lg text-[#1a3d1a]">Khám Tổng Quát & Chẩn Đoán</h3>
        <p class="text-xs text-gray-600 mt-2 leading-relaxed">
          Kiểm tra tai, mắt, mũi, họng, tim phổi, da lông và siêu âm/xét nghiệm máu khi có chỉ định bác sĩ.
        </p>
        <div class="mt-4 flex items-center justify-between text-xs text-gray-500 border-t border-gray-100 pt-3">
          <span>Thời lượng: <strong>30 - 45 phút</strong></span>
          <span class="text-emerald-700 font-bold text-sm">150.000 ₫</span>
        </div>
      </div>
      <div class="mt-5">
        <a href="/dat-lich.php?service=Khám tổng quát" class="w-full clay-btn-orange py-2.5 text-xs">
          Đặt lịch khám ngay
        </a>
      </div>
    </div>

    <!-- 2. Tiêm phòng Vaccine & Tẩy giun -->
    <div class="clay-card p-6 flex flex-col justify-between">
      <div>
        <div class="w-12 h-12 rounded-2xl bg-amber-100 text-[#E86A10] flex items-center justify-center text-2xl mb-4">
          💉
        </div>
        <h3 class="font-bold text-lg text-[#1a3d1a]">Tiêm Phòng Vaccine & Sổ Giun</h3>
        <p class="text-xs text-gray-600 mt-2 leading-relaxed">
          Vaccine 5 bệnh / 7 bệnh cho chó, 4 bệnh cho mèo nhập khẩu từ Pháp và Mỹ; theo dõi sổ sức khỏe điện tử.
        </p>
        <div class="mt-4 flex items-center justify-between text-xs text-gray-500 border-t border-gray-100 pt-3">
          <span>Thời lượng: <strong>20 - 30 phút</strong></span>
          <span class="text-emerald-700 font-bold text-sm">250.000 ₫</span>
        </div>
      </div>
      <div class="mt-5">
        <a href="/dat-lich.php?service=Tiêm phòng vaccine" class="w-full clay-btn-orange py-2.5 text-xs">
          Đặt lịch tiêm phòng
        </a>
      </div>
    </div>

    <!-- 3. Tắm Spa thảo mộc & sấy phồng -->
    <div class="clay-card p-6 flex flex-col justify-between">
      <div>
        <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center text-2xl mb-4">
          🛁
        </div>
        <h3 class="font-bold text-lg text-[#1a3d1a]">Tắm Spa Thảo Mộc & Sấy Phồng</h3>
        <p class="text-xs text-gray-600 mt-2 leading-relaxed">
          Ngâm bồn sục khí nano, dầu tắm thảo mộc dưỡng ẩm sâu, vắt tuyến hôi, vệ sinh tai và sấy chải mềm mượt.
        </p>
        <div class="mt-4 flex items-center justify-between text-xs text-gray-500 border-t border-gray-100 pt-3">
          <span>Thời lượng: <strong>60 - 90 phút</strong></span>
          <span class="text-emerald-700 font-bold text-sm">180.000 ₫</span>
        </div>
      </div>
      <div class="mt-5">
        <a href="/dat-lich.php?service=Tắm Spa thảo mộc" class="w-full clay-btn-orange py-2.5 text-xs">
          Đặt lịch tắm spa
        </a>
      </div>
    </div>

    <!-- 4. Cắt tỉa & Tạo kiểu lông nghệ thuật -->
    <div class="clay-card p-6 flex flex-col justify-between">
      <div>
        <div class="w-12 h-12 rounded-2xl bg-pink-100 text-pink-700 flex items-center justify-center text-2xl mb-4">
          ✂️
        </div>
        <h3 class="font-bold text-lg text-[#1a3d1a]">Cắt Tỉa & Tạo Kiểu Lông</h3>
        <p class="text-xs text-gray-600 mt-2 leading-relaxed">
          Tạo hình phong cách Hàn Quốc/Nhật Bản theo giống bé (Poodle, Phốc sóc, Bichon, Corgi) bởi Master Groomer.
        </p>
        <div class="mt-4 flex items-center justify-between text-xs text-gray-500 border-t border-gray-100 pt-3">
          <span>Thời lượng: <strong>90 - 120 phút</strong></span>
          <span class="text-emerald-700 font-bold text-sm">280.000 ₫</span>
        </div>
      </div>
      <div class="mt-5">
        <a href="/dat-lich.php?service=Cắt tỉa & tạo kiểu" class="w-full clay-btn-orange py-2.5 text-xs">
          Đặt lịch cắt tỉa
        </a>
      </div>
    </div>

    <!-- 5. Khách sạn thú cưng (Pet Hotel) -->
    <div class="clay-card p-6 flex flex-col justify-between">
      <div>
        <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-700 flex items-center justify-center text-2xl mb-4">
          🏨
        </div>
        <h3 class="font-bold text-lg text-[#1a3d1a]">Khách Sạn Lưu Trú Cao Cấp</h3>
        <p class="text-xs text-gray-600 mt-2 leading-relaxed">
          Phòng máy lạnh độc lập 24/24, camera trực tuyến cho chủ xem bé, chế độ ăn hạt cao cấp và dạo chơi mỗi ngày.
        </p>
        <div class="mt-4 flex items-center justify-between text-xs text-gray-500 border-t border-gray-100 pt-3">
          <span>Thời lượng: <strong>Theo ngày</strong></span>
          <span class="text-emerald-700 font-bold text-sm">200.000 ₫ / ngày</span>
        </div>
      </div>
      <div class="mt-5">
        <a href="/dat-lich.php?service=Khách sạn lưu trú" class="w-full clay-btn-orange py-2.5 text-xs">
          Đặt phòng lưu trú
        </a>
      </div>
    </div>

    <!-- 6. Cấp cứu 24/7 & Hồi sức -->
    <div class="clay-card p-6 flex flex-col justify-between border-2 border-red-200">
      <div>
        <div class="w-12 h-12 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center text-2xl mb-4">
          🚨
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
        <a href="tel:0900123456" class="w-full py-2.5 rounded-full bg-red-600 hover:bg-red-700 text-white font-bold text-xs inline-flex items-center justify-center gap-2">
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
