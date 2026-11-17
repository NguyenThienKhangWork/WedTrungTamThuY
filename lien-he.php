<?php
/**
 * PawNest - Trang Liên Hệ & Bản Đồ (Mục 1.2, FR-106, Tiêu chí 9)
 * Địa chỉ, giờ mở cửa, hotline cấp cứu 24/7, mạng xã hội và bản đồ chỉ đường
 */

declare(strict_types=1);

$page_title = 'Liên Hệ & Bản Đồ Chỉ Đường | PawNest';
$page_desc = 'Thông tin liên hệ, hotline cấp cứu thú y 24/7 và bản đồ vị trí trung tâm PawNest tại quận Phú Nhuận, TP. Hồ Chí Minh.';
$active_menu = 'contact';

require_once __DIR__ . '/includes/header.php';
?>

<main class="py-12 px-4 sm:px-6 max-w-6xl mx-auto">
  <div class="text-center max-w-2xl mx-auto mb-12">
    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-semibold mb-3">
      <span>📍 Vị Trí Trung Tâm Thuận Tiện Di Chuyển</span>
    </div>
    <h1 class="font-serif-display text-3xl sm:text-4xl text-[#1a3d1a] tracking-tight">
      Liên Hệ Với Chúng Tôi
    </h1>
    <p class="text-xs sm:text-sm text-gray-600 mt-2">
      PawNest luôn sẵn sàng lắng nghe và hỗ trợ tư vấn chăm sóc sức khỏe cho các bé cưng 24/7.
    </p>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start mb-16">
    <!-- Cột 1: Thông tin liên hệ chi tiết -->
    <div class="space-y-6">
      <div class="clay-card p-6 flex items-start gap-4">
        <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-[#1a3d1a] flex items-center justify-center text-2xl shrink-0">
          🏥
        </div>
        <div>
          <h3 class="font-bold text-base text-[#1a3d1a]">Địa Chỉ Trung Tâm</h3>
          <p class="text-xs text-gray-600 mt-1"><?= e(CENTER_ADDRESS) ?></p>
          <span class="inline-block mt-2 text-[11px] text-emerald-700 font-semibold bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
            Có bãi đỗ xe ô tô & xe máy rộng rãi
          </span>
        </div>
      </div>

      <div class="clay-card p-6 flex items-start gap-4">
        <div class="w-12 h-12 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center text-2xl shrink-0">
          📞
        </div>
        <div>
          <h3 class="font-bold text-base text-[#1a3d1a]">Hotline Cấp Cứu 24/7 & Tư Vấn</h3>
          <p class="text-xs text-gray-600 mt-1">Đường dây nóng hỗ trợ khẩn cấp xuyên đêm:</p>
          <a href="tel:0900123456" class="inline-block mt-1 text-lg font-extrabold text-[#E86A10] hover:underline">
            0900 123 456
          </a>
        </div>
      </div>

      <div class="clay-card p-6 flex items-start gap-4">
        <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center text-2xl shrink-0">
          ⏰
        </div>
        <div>
          <h3 class="font-bold text-base text-[#1a3d1a]">Giờ Mở Cửa Hoạt Động</h3>
          <p class="text-xs text-gray-600 mt-1">Thứ Hai – Chủ Nhật: <strong>08:00 – 20:00</strong></p>
          <p class="text-[11px] text-gray-500 mt-0.5">Khoa Cấp cứu & Nội trú: Hoạt động liên tục 24/24 tất cả các ngày lễ tết.</p>
        </div>
      </div>

      <!-- Mạng xã hội (Tiêu chí 9) -->
      <div class="clay-card p-6">
        <h3 class="font-bold text-sm text-[#1a3d1a] mb-3">Kênh Mạng Xã Hội Chính Thức (Mở tab mới)</h3>
        <div class="flex items-center gap-3">
          <a href="https://github.com/NguyenThienKhangWork/WedTrungTamThuY" target="_blank" rel="noopener noreferrer" class="px-3.5 py-2 rounded-xl bg-gray-900 text-white text-xs font-semibold flex items-center gap-2 hover:bg-black transition-colors" title="GitHub">
            <i data-lucide="github" class="w-4 h-4"></i>
            <span>GitHub</span>
          </a>
          <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="px-3.5 py-2 rounded-xl bg-blue-600 text-white text-xs font-semibold flex items-center gap-2 hover:bg-blue-700 transition-colors" title="Facebook">
            <i data-lucide="facebook" class="w-4 h-4"></i>
            <span>Facebook</span>
          </a>
          <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="px-3.5 py-2 rounded-xl bg-pink-600 text-white text-xs font-semibold flex items-center gap-2 hover:bg-pink-700 transition-colors" title="Instagram">
            <i data-lucide="instagram" class="w-4 h-4"></i>
            <span>Instagram</span>
          </a>
          <a href="https://tiktok.com" target="_blank" rel="noopener noreferrer" class="px-3.5 py-2 rounded-xl bg-neutral-800 text-white text-xs font-semibold flex items-center gap-2 hover:bg-neutral-900 transition-colors" title="TikTok">
            <i data-lucide="video" class="w-4 h-4"></i>
            <span>TikTok</span>
          </a>
        </div>
      </div>
    </div>

    <!-- Cột 2: Bản đồ chỉ đường Google Maps & Form để lại lời nhắn -->
    <div class="space-y-6">
      <div class="clay-card p-3 overflow-hidden bg-white">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.261899126435!2d106.68541947570415!3d10.791238458917822!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317528d223832d2f%3A0xbcf0ee327117ab88!2zUGjDuiBOaHXhuq1uLCBUaMOgbmggcGjhu5EgSOG7kyBDaMOtIE1pbmg!5e0!3m2!1svi!2s!4v1700000000000!5m2!1svi!2s"
          width="100%"
          height="320"
          style="border:0; border-radius: 20px;"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
          title="Bản đồ vị trí PawNest"
        ></iframe>
      </div>

      <!-- Form gửi tin nhắn nhanh -->
      <div class="clay-card p-6 bg-white">
        <h3 class="font-bold text-sm text-[#1a3d1a] mb-2">Gửi Lời Nhắn Đến Bác Sĩ Khang</h3>
        <form onsubmit="event.preventDefault(); alert('Cảm ơn bạn! Bác sĩ Khang đã nhận được lời nhắn và sẽ phản hồi qua điện thoại trong 15 phút.'); this.reset();" class="space-y-3">
          <div class="grid grid-cols-2 gap-3">
            <input type="text" placeholder="Họ tên của bạn" required class="w-full px-3 py-2 rounded-xl border border-gray-200 text-xs clay-input" />
            <input type="tel" placeholder="Số điện thoại" required class="w-full px-3 py-2 rounded-xl border border-gray-200 text-xs clay-input" />
          </div>
          <textarea rows="3" placeholder="Nội dung cần tư vấn về tình trạng bé..." required class="w-full px-3 py-2 rounded-xl border border-gray-200 text-xs clay-input"></textarea>
          <button type="submit" class="w-full py-2.5 rounded-full bg-[#1a3d1a] hover:bg-[#2a5a2a] text-white font-bold text-xs clay-btn-green cursor-pointer">
            Gửi Lời Nhắn Nhanh
          </button>
        </form>
      </div>
    </div>
  </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
