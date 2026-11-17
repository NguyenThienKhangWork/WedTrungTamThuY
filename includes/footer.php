<?php
/**
 * PawNest & CozyPaws - Footer dùng chung (Mục 5.2, Tiêu chí 9, Tiêu chí 10)
 * Thông tin liên hệ, hotline cấp cứu 24/7, mạng xã hội & Auth Modal
 */

declare(strict_types=1);
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
?>
  <!-- ========================================================================= -->
  <!-- TIÊU CHÍ 9 & 10: CHÂN TRANG (FOOTER) & THÔNG TIN DOANH NGHIỆP             -->
  <!-- ========================================================================= -->
  <footer class="bg-[#1a3d1a] text-white pt-16 pb-12 border-t border-[#2a5a2a]">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-white/10">
        <!-- Cột 1: Thông tin thương hiệu -->
        <div class="space-y-4 md:col-span-1">
          <div class="flex items-center gap-2">
            <span class="text-2xl">🐾</span>
            <span class="font-serif-display text-2xl font-bold tracking-tight text-white">PawNest</span>
          </div>
          <p class="text-xs text-gray-300 leading-relaxed">
            Trung tâm Thú Y & Spa Thú Cưng chuyên nghiệp, tận tâm và hiện đại hàng đầu tại TP. Hồ Chí Minh.
          </p>
          <div class="pt-2">
            <span class="inline-block px-3 py-1 rounded-full bg-emerald-900/60 border border-emerald-500/30 text-emerald-300 text-[11px] font-semibold">
              Giấy phép số: 079/TY-HCM • Cấp năm 2024
            </span>
          </div>
        </div>

        <!-- Cột 2: Lối tắt dịch vụ -->
        <div class="space-y-3">
          <h4 class="text-sm font-bold tracking-wider uppercase text-emerald-300">Dịch vụ chính</h4>
          <ul class="space-y-2 text-xs text-gray-300">
            <li><a href="/dich-vu.php" class="hover:text-white transition-colors">Khám & Điều trị thú y</a></li>
            <li><a href="/dich-vu.php" class="hover:text-white transition-colors">Tiêm phòng vaccine & Tẩy giun</a></li>
            <li><a href="/dich-vu.php" class="hover:text-white transition-colors">Tắm thảo mộc & Spa sấy thơm</a></li>
            <li><a href="/dich-vu.php" class="hover:text-white transition-colors">Cắt tỉa & Tạo kiểu lông</a></li>
            <li><a href="/bang-gia.php" class="hover:text-white transition-colors">Bảng giá 3 gói chăm sóc</a></li>
            <li><a href="/cua-hang.php" class="text-amber-300 font-bold hover:underline">🏪 Cửa hàng Thức ăn & Thuốc Thú Y</a></li>
          </ul>
        </div>

        <!-- Cột 3: Thông tin Bác sĩ phụ trách & Giờ làm việc -->
        <div class="space-y-3">
          <h4 class="text-sm font-bold tracking-wider uppercase text-emerald-300">Phụ trách chuyên môn</h4>
          <div class="text-xs text-gray-300 space-y-1.5">
            <p>Bác sĩ trưởng: <strong class="text-white"><?= e(CENTER_DIRECTOR) ?></strong></p>
            <p>Địa chỉ: <strong><?= e(CENTER_ADDRESS) ?></strong></p>
            <p>Hotline: <strong class="text-[#FFC94D]"><?= e(CENTER_HOTLINE) ?></strong></p>
            <p>Email: <a href="mailto:<?= e(CENTER_EMAIL) ?>" class="hover:underline"><?= e(CENTER_EMAIL) ?></a></p>
            <p class="text-[11px] text-emerald-400 font-semibold pt-1">Giờ mở cửa: 08:00 – 20:00 (Cấp cứu 24/7)</p>
          </div>
        </div>

        <!-- Cột 4: Mạng xã hội & Kênh liên hệ (Tiêu chí 9) -->
        <div class="space-y-3">
          <h4 class="text-sm font-bold tracking-wider uppercase text-emerald-300">Kết nối với chúng tôi</h4>
          <p class="text-xs text-gray-300">Theo dõi câu chuyện và hình ảnh dễ thương của các bé cưng:</p>
          <div class="flex items-center gap-3 pt-1">
            <a href="https://github.com/NguyenThienKhangWork/WedTrungTamThuY" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full bg-white/10 hover:bg-[#E86A10] flex items-center justify-center transition-colors text-white" title="GitHub Repository">
              <i data-lucide="github" class="w-4 h-4"></i>
            </a>
            <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full bg-white/10 hover:bg-[#E86A10] flex items-center justify-center transition-colors text-white" title="Facebook Page">
              <i data-lucide="facebook" class="w-4 h-4"></i>
            </a>
            <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full bg-white/10 hover:bg-[#E86A10] flex items-center justify-center transition-colors text-white" title="Instagram">
              <i data-lucide="instagram" class="w-4 h-4"></i>
            </a>
            <a href="https://tiktok.com" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full bg-white/10 hover:bg-[#E86A10] flex items-center justify-center transition-colors text-white" title="TikTok Video Reviews">
              <i data-lucide="video" class="w-4 h-4"></i>
            </a>
          </div>
          <div class="pt-3">
            <a href="tel:0900123456" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-600 hover:bg-red-700 text-white text-xs font-bold shadow-md transition-all">
              <i data-lucide="phone-call" class="w-3.5 h-3.5 animate-bounce"></i>
              <span>Cấp cứu 24/7: 0900 123 456</span>
            </a>
          </div>
        </div>
      </div>

      <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-400 gap-4">
        <p>© 2026 PawNest & CozyPaws • Dự án Lập Trình Web PHP & MySQL • Thực hiện bởi sinh viên: <strong>Nguyễn Thiện Khang</strong></p>
        <div class="flex items-center gap-4">
          <a href="javascript:void(0)" onclick="alert('Tuân thủ Nghị định 13/2023/NĐ-CP về bảo vệ dữ liệu cá nhân khách hàng.');" class="hover:text-white">Quyền riêng tư</a>
          <span>•</span>
          <a href="javascript:void(0)" onclick="alert('Điều khoản dịch vụ và chính sách đặt lịch hẹn trung tâm.');" class="hover:text-white">Điều khoản</a>
          <span>•</span>
          <a href="/admin/login.php" class="hover:text-[#FFC94D]">Quản trị viên</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- ========================================================================= -->
  <!-- MODAL ĐĂNG NHẬP / ĐĂNG KÝ TÀI KHOẢN KHÁCH HÀNG (FR-50, FR-51)              -->
  <!-- ========================================================================= -->
  <div id="auth-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm animate-fade-in">
    <div class="bg-white rounded-3xl w-full max-w-md p-6 sm:p-8 shadow-2xl relative border border-[#1a3d1a]/10 max-h-[90vh] overflow-y-auto">
      <button id="close-auth-modal" type="button" class="absolute top-5 right-5 w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 flex items-center justify-center transition-colors cursor-pointer">
        ✕
      </button>

      <!-- User Logged In Box -->
      <div id="user-profile-box" class="hidden text-center space-y-4 py-4">
        <div class="w-16 h-16 rounded-full bg-[#EFFDF0] border-2 border-[#1a3d1a] flex items-center justify-center mx-auto text-2xl text-[#1a3d1a]">
          🐾
        </div>
        <div>
          <h3 class="text-xl font-bold text-[#1a3d1a]" id="profile-name">Khách hàng PawNest</h3>
          <p class="text-xs text-gray-500" id="profile-phone">0912345678</p>
          <span class="inline-block mt-1 px-3 py-0.5 rounded-full bg-green-50 text-green-700 text-[11px] font-semibold">Tài khoản khách hàng thân thiết</span>
        </div>
        <div class="pt-4 border-t border-gray-100 flex flex-col gap-2">
          <a href="/dat-lich.php" class="w-full py-2.5 rounded-xl bg-[#E86A10] hover:bg-[#d45e0d] text-white text-xs font-semibold text-center block">
            Đặt lịch chăm sóc bé mới
          </a>
          <button id="btn-logout" type="button" class="w-full py-2.5 rounded-xl border border-gray-200 hover:bg-red-50 text-red-600 text-xs font-semibold cursor-pointer">
            Đăng xuất
          </button>
        </div>
      </div>

      <!-- Auth Forms -->
      <div id="auth-forms-container">
        <div class="flex border-b border-gray-100 pb-3 mb-5 gap-3">
          <button id="tab-login" type="button" class="flex-1 pb-2 font-bold text-sm border-b-2 border-[#1a3d1a] text-[#1a3d1a] transition-all cursor-pointer">
            Đăng nhập
          </button>
          <button id="tab-register" type="button" class="flex-1 pb-2 font-semibold text-sm border-b-2 border-transparent text-gray-400 hover:text-gray-700 transition-all cursor-pointer">
            Đăng ký tài khoản
          </button>
        </div>

        <div id="auth-alert" class="hidden p-3 rounded-xl mb-4 text-xs font-medium"></div>

        <!-- 1. Form Đăng nhập -->
        <form id="form-customer-login" class="space-y-4">
          <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Số điện thoại hoặc Email</label>
            <input id="login-identifier" type="text" placeholder="0912345678" required class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-xs sm:text-sm focus:ring-2 focus:ring-[#1a3d1a] focus:outline-none clay-input" />
          </div>
          <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Mật khẩu</label>
            <input id="login-password" type="password" placeholder="••••••••" required class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-xs sm:text-sm focus:ring-2 focus:ring-[#1a3d1a] focus:outline-none clay-input" />
          </div>
          <button type="submit" class="w-full py-3 rounded-2xl bg-[#E86A10] hover:bg-[#d45e0d] text-white font-bold text-xs sm:text-sm shadow-md transition-all active:scale-98 cursor-pointer clay-btn-orange">
            Đăng nhập ngay
          </button>
          <div class="mt-4 pt-3 border-t border-gray-100 text-center space-y-2">
            <p class="text-[11px] text-gray-400">Tài khoản khách mẫu: <strong>0912345678</strong> (Mật khẩu: bất kỳ)</p>
            <a href="/admin/login.php" class="text-[11px] font-semibold text-[#1a3d1a] hover:underline block">
              🛡️ Đăng nhập tài khoản Quản trị viên (Admin) →
            </a>
          </div>
        </form>

        <!-- 2. Form Đăng ký -->
        <form id="form-customer-register" class="space-y-3.5 hidden">
          <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Họ và tên chủ nuôi *</label>
            <input id="reg-name" type="text" placeholder="Nguyễn Văn A" required class="w-full px-3.5 py-2 rounded-xl border border-gray-300 text-xs sm:text-sm focus:ring-2 focus:ring-[#1a3d1a] focus:outline-none clay-input" />
          </div>
          <div class="grid grid-cols-2 gap-2.5">
            <div>
              <label class="block text-xs font-semibold text-gray-700 mb-1">Số điện thoại *</label>
              <input id="reg-phone" type="tel" placeholder="0912345678" required class="w-full px-3.5 py-2 rounded-xl border border-gray-300 text-xs sm:text-sm focus:ring-2 focus:ring-[#1a3d1a] focus:outline-none clay-input" />
            </div>
            <div>
              <label class="block text-xs font-semibold text-gray-700 mb-1">Email</label>
              <input id="reg-email" type="email" placeholder="email@gmail.com" class="w-full px-3.5 py-2 rounded-xl border border-gray-300 text-xs sm:text-sm focus:ring-2 focus:ring-[#1a3d1a] focus:outline-none clay-input" />
            </div>
          </div>
          <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Mật khẩu *</label>
            <input id="reg-pass" type="password" placeholder="Tối thiểu 6 ký tự" required class="w-full px-3.5 py-2 rounded-xl border border-gray-300 text-xs sm:text-sm focus:ring-2 focus:ring-[#1a3d1a] focus:outline-none clay-input" />
          </div>
          <div class="grid grid-cols-2 gap-2.5">
            <div>
              <label class="block text-xs font-semibold text-gray-700 mb-1">Tên bé cưng *</label>
              <input id="reg-pet-name" type="text" placeholder="Mochi, Bơ..." required class="w-full px-3.5 py-2 rounded-xl border border-gray-300 text-xs sm:text-sm focus:ring-2 focus:ring-[#1a3d1a] focus:outline-none clay-input" />
            </div>
            <div>
              <label class="block text-xs font-semibold text-gray-700 mb-1">Loài *</label>
              <select id="reg-pet-species" class="w-full px-3.5 py-2 rounded-xl border border-gray-300 text-xs sm:text-sm focus:ring-2 focus:ring-[#1a3d1a] focus:outline-none clay-input">
                <option value="Chó">Chó</option>
                <option value="Mèo">Mèo</option>
                <option value="Thỏ">Thỏ</option>
                <option value="Khác">Khác</option>
              </select>
            </div>
          </div>
          <button type="submit" class="w-full py-2.5 rounded-2xl bg-[#1a3d1a] hover:bg-[#2a5a2a] text-white font-bold text-xs sm:text-sm shadow-md transition-all active:scale-98 cursor-pointer clay-btn-green">
            Tạo tài khoản mới
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Nút gọi nhanh hotline và Zalo trên di động (FR-05) -->
  <div class="fixed bottom-4 left-4 z-40 flex items-center gap-2 sm:hidden">
    <a href="tel:0900123456" class="w-12 h-12 rounded-full bg-red-600 text-white flex items-center justify-center shadow-lg active:scale-95" title="Gọi cấp cứu">
      <i data-lucide="phone" class="w-6 h-6"></i>
    </a>
    <a href="https://zalo.me/0900123456" target="_blank" rel="noopener noreferrer" class="w-12 h-12 rounded-full bg-blue-500 text-white flex items-center justify-center shadow-lg active:scale-95 font-bold text-xs" title="Chat Zalo">
      Zalo
    </a>
  </div>

  <!-- JavaScript Tương tác chính & Đặt lịch (Mục 5.1) -->
  <script src="/assets/js/main.js"></script>
  <script src="/assets/js/booking.js"></script>

  <!-- ============================================================ -->
  <!-- QR THANH TOÁN VIETQR — dùng chung cho index.php & dat-lich.php -->
  <!-- ============================================================ -->
  <div id="qr-modal-global" class="fixed inset-0 z-[999] flex items-center justify-center p-4 hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-black/55 backdrop-blur-sm" onclick="closeQrModal()"></div>
    <div class="relative w-full max-w-sm bg-white rounded-3xl shadow-2xl overflow-hidden">
      <div class="bg-gradient-to-r from-[#1a3d1a] to-[#2a5a2a] px-6 py-5 text-white text-center">
        <div class="text-3xl mb-1">📱</div>
        <h2 class="font-bold text-lg">Quét QR Thanh Toán</h2>
        <p class="text-emerald-200 text-xs mt-0.5">Dùng app ngân hàng bất kỳ — Vietcombank, MB, TPBank, VPBank...</p>
      </div>
      <div class="px-6 py-5 flex flex-col items-center gap-4">
        <div id="qr-global-loading" class="w-52 h-52 flex items-center justify-center">
          <div class="w-10 h-10 border-4 border-[#1a3d1a]/20 border-t-[#1a3d1a] rounded-full animate-spin"></div>
        </div>
        <img id="qr-global-img" src="" alt="QR VietQR" class="hidden w-52 h-52 rounded-xl border border-gray-100 shadow-md" />
        <div class="w-full bg-emerald-50 rounded-2xl p-4 border border-emerald-100 text-center">
          <p class="text-xs text-gray-500 mb-0.5">Chuyển khoản đến</p>
          <p class="font-bold text-[#1a3d1a]">NGUYEN THIEN KHANG</p>
          <p class="text-sm text-gray-600">Vietcombank · <span class="font-mono font-bold">1051374267</span></p>
          <div class="mt-3 pt-3 border-t border-emerald-200 space-y-1">
            <div class="flex justify-between text-xs"><span class="text-gray-500">Số tiền:</span> <span id="qr-g-amount" class="font-bold text-[#E86A10]">—</span></div>
            <div class="flex justify-between text-xs"><span class="text-gray-500">Nội dung:</span> <span id="qr-g-desc" class="font-semibold text-gray-700 max-w-[180px] truncate">—</span></div>
          </div>
        </div>
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-green-50 border border-green-200 text-green-700 text-xs font-semibold">
          <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
          Đang chờ xác nhận... PawNest sẽ gọi lại trong 15 phút
        </div>
        <p class="text-[11px] text-gray-400 text-center leading-snug">Giữ màn hình này nếu cần đối chiếu khi hỗ trợ.</p>
      </div>
      <div class="px-6 pb-6 flex gap-3">
        <button onclick="closeQrModal()" class="flex-1 py-3 rounded-full border-2 border-gray-200 text-gray-700 font-semibold text-sm hover:bg-gray-50 transition-all">Đóng</button>
        <a id="qr-g-download" href="#" download="PawNest-QR.png" class="flex-1 py-3 rounded-full bg-[#1a3d1a] hover:bg-[#2a5a2a] text-white font-semibold text-sm text-center transition-all">Lưu QR</a>
      </div>
    </div>
  </div>

  <style>
    /* Payment radio toggle: selected state */
    .payment-opt-mini input:checked  ~ .pay-box-mini { border-color:#1a3d1a; background:#f0fdf4; color:#1a3d1a; }
    .payment-opt-mini input:not(:checked) ~ .pay-box-mini { border-color:#e5e7eb; background:#fff; color:#4b5563; }
    /* dat-lich.php full payment options */
    .payment-opt input:checked ~ .payment-opt-box { border-color:#1a3d1a; background:#f0fdf4; }
    .payment-opt input:not(:checked) ~ .payment-opt-box { border-color:#e5e7eb; background:#fff; }
    .payment-opt input:checked ~ .payment-opt-box .pay-dot { background:#1a3d1a; }
    .payment-opt input:not(:checked) ~ .payment-opt-box .pay-dot { background:transparent; }
  </style>

  <script>
    // ===== VietQR Config — thay bằng thông tin ngân hàng thật =====
    const VIETQR_BANK    = 'VCB';           // Vietcombank
    const VIETQR_ACCOUNT = '1051374267';    // Số tài khoản
    const VIETQR_NAME    = 'NGUYEN THIEN KHANG';
    const SERVICE_PRICE_MAP = {
      'Gói Spa & cắt tỉa': 350000, 'Gói Cơ bản – Tắm thơm': 150000,
      'Gói Toàn diện': 580000, 'Khám & điều trị thú y': 200000,
      'Tiêm phòng & tẩy giun': 250000, 'Khám tổng quát': 200000,
      'Tiêm phòng vaccine': 250000, 'Tắm Spa thảo mộc': 320000,
      'Cắt tỉa & tạo kiểu': 180000, 'Khách sạn lưu trú': 400000,
      'Gói Cơ bản': 150000, 'Cozy Cat House ($49.99)': 1250000,
    };

    function formatVND(n) {
      return new Intl.NumberFormat('vi-VN', {style:'currency', currency:'VND'}).format(n);
    }

    function openQrModal(petName, serviceName, appointmentId) {
      const amount = SERVICE_PRICE_MAP[serviceName] || 200000;
      const desc   = `PawNest DL${appointmentId} ${petName}`.substring(0, 25);
      const qrUrl  = `https://img.vietqr.io/image/${VIETQR_BANK}-${VIETQR_ACCOUNT}-compact2.png?amount=${amount}&addInfo=${encodeURIComponent(desc)}&accountName=${encodeURIComponent(VIETQR_NAME)}`;

      const modal = document.getElementById('qr-modal-global');
      modal.classList.remove('hidden');
      document.body.style.overflow = 'hidden';

      const loading = document.getElementById('qr-global-loading');
      const imgEl   = document.getElementById('qr-global-img');
      loading.classList.remove('hidden');
      imgEl.classList.add('hidden');
      document.getElementById('qr-g-amount').textContent = formatVND(amount);
      document.getElementById('qr-g-desc').textContent   = desc;

      imgEl.onload = () => {
        loading.classList.add('hidden');
        imgEl.classList.remove('hidden');
        document.getElementById('qr-g-download').href = qrUrl;
      };
      imgEl.onerror = () => {
        loading.innerHTML = '<p class="text-xs text-red-500 text-center px-4">Không tải được QR.<br>Vui lòng chuyển khoản thủ công theo thông tin trên.</p>';
      };
      imgEl.src = qrUrl;
    }

    function closeQrModal() {
      document.getElementById('qr-modal-global').classList.add('hidden');
      document.body.style.overflow = '';
    }
    document.addEventListener('keydown', e => { if(e.key === 'Escape') closeQrModal(); });
  </script>

  <!-- ============================================================ -->
  <!-- TRỢ LÝ AI THÚ Y PAWBOT (Tích hợp OpenRouter AI)               -->
  <!-- ============================================================ -->
  <div id="ai-chat-widget" class="fixed bottom-6 right-4 sm:right-6 z-50 flex flex-col items-end select-none">
    
    <!-- Cửa sổ Chat AI -->
    <div id="ai-chat-window" class="hidden mb-3 w-[360px] sm:w-[390px] h-[540px] max-h-[82vh] bg-white rounded-3xl shadow-2xl border border-[#1a3d1a]/15 flex flex-col overflow-hidden transition-all duration-300 transform origin-bottom-right animate-fade-up">
      <!-- Header Chat -->
      <div class="bg-gradient-to-r from-[#1a3d1a] via-[#245224] to-[#E86A10] px-4 py-3.5 text-white flex items-center justify-between shadow-xs">
        <div class="flex items-center gap-2.5">
          <div class="relative w-9 h-9 rounded-full bg-white/20 backdrop-blur-xs flex items-center justify-center text-lg border border-white/30">
            🐾
            <span class="absolute bottom-0 right-0 w-2.5 h-2.5 rounded-full bg-emerald-400 border-2 border-[#1a3d1a]"></span>
          </div>
          <div>
            <div class="flex items-center gap-1.5">
              <h3 class="font-bold text-xs sm:text-sm tracking-wide">PawBot Thú Y AI</h3>
              <span class="px-1.5 py-0.2 rounded-md bg-emerald-500/30 border border-emerald-300/40 text-[9px] font-extrabold uppercase">OpenRouter</span>
            </div>
            <p class="text-[10px] text-emerald-100 flex items-center gap-1">
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-ping"></span>
              Phòng khám BS. Khang • Trực tuyến 24/7
            </p>
          </div>
        </div>
        <button id="ai-chat-close" type="button" class="w-7 h-7 rounded-full bg-white/15 hover:bg-white/30 text-white flex items-center justify-center text-xs transition-colors cursor-pointer" title="Đóng cửa sổ">
          ✕
        </button>
      </div>

      <!-- Quick Prompt Chips -->
      <div class="px-3 py-2 bg-emerald-50/60 border-b border-emerald-100/60 flex items-center gap-1.5 overflow-x-auto no-scrollbar text-[11px]">
        <button onclick="sendQuickPrompt('Giá các gói Spa & Bảng giá tiêm phòng bao nhiêu?')" class="shrink-0 px-2.5 py-1 rounded-full bg-white hover:bg-emerald-100 border border-emerald-200 text-[#1a3d1a] font-medium transition-colors shadow-2xs">
          🏷️ Bảng giá dịch vụ
        </button>
        <button onclick="sendQuickPrompt('Lịch tiêm vắc xin cho chó mèo con cần những gì?')" class="shrink-0 px-2.5 py-1 rounded-full bg-white hover:bg-emerald-100 border border-emerald-200 text-[#1a3d1a] font-medium transition-colors shadow-2xs">
          💉 Lịch tiêm phòng
        </button>
        <button onclick="sendQuickPrompt('Bé cưng bị nôn mửa hoặc bỏ ăn phải xử lý thế nào?')" class="shrink-0 px-2.5 py-1 rounded-full bg-white hover:bg-rose-100 border border-rose-200 text-rose-800 font-medium transition-colors shadow-2xs">
          🚨 Cấp cứu nôn mửa
        </button>
        <button onclick="sendQuickPrompt('Nhà cào móng Cozy Cat House giá bao nhiêu và có ship không?')" class="shrink-0 px-2.5 py-1 rounded-full bg-white hover:bg-amber-100 border border-amber-200 text-amber-800 font-medium transition-colors shadow-2xs">
          🏠 Cozy Cat House
        </button>
      </div>

      <!-- Hộp tin nhắn cuộn -->
      <div id="ai-chat-messages" class="flex-1 p-3.5 space-y-3 overflow-y-auto bg-[#F8FAF8] text-xs leading-relaxed">
        <!-- Tin nhắn mở đầu của PawBot -->
        <div class="flex items-start gap-2 animate-fade-in">
          <div class="w-7 h-7 rounded-full bg-[#1a3d1a] text-white flex items-center justify-center text-xs shrink-0 shadow-2xs">
            🐾
          </div>
          <div class="max-w-[85%] bg-white p-3 rounded-2xl rounded-tl-xs border border-gray-200 text-gray-800 shadow-2xs">
            <p class="font-bold text-[#1a3d1a] mb-1">Dạ chào ba mẹ của bé! ✨</p>
            <p>Em là <strong>PawBot</strong>, trợ lý AI của Bác sĩ Thú Y Nguyễn Thiện Khang tại PawNest. Em có thể tư vấn sức khỏe, lịch tiêm phòng, dịch vụ spa hoặc đặt lịch cho bé cưng.</p>
            <p class="mt-1.5 text-[11px] text-gray-500">Ba mẹ có thể chọn các câu hỏi nhanh phía trên hoặc nhắn tin cho em nhé! 🐶🐱</p>
          </div>
        </div>
      </div>

      <!-- Typing Indicator (Ẩn mặc định) -->
      <div id="ai-typing" class="hidden px-4 py-2 bg-[#F8FAF8] flex items-center gap-2 text-[11px] text-gray-500">
        <div class="w-5 h-5 rounded-full bg-[#1a3d1a] text-white flex items-center justify-center text-[10px]">🐾</div>
        <div class="flex items-center gap-1 bg-white px-3 py-1.5 rounded-full border border-gray-200 shadow-2xs">
          <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-bounce"></span>
          <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-bounce" style="animation-delay: 150ms;"></span>
          <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-bounce" style="animation-delay: 300ms;"></span>
          <span class="ml-1 text-[10px] text-gray-400">PawBot đang suy nghĩ...</span>
        </div>
      </div>

      <!-- Form nhập tin nhắn -->
      <form id="ai-chat-form" class="p-2.5 bg-white border-t border-gray-100 flex items-center gap-2">
        <input 
          id="ai-user-input" 
          type="text" 
          placeholder="Hỏi về sức khỏe, dịch vụ hoặc bảng giá..." 
          autocomplete="off"
          class="flex-1 px-3.5 py-2.5 rounded-2xl border border-gray-200 text-xs focus:outline-none focus:ring-2 focus:ring-[#1a3d1a] bg-gray-50/70"
        />
        <button 
          type="submit" 
          id="ai-btn-send"
          class="w-9 h-9 rounded-2xl bg-[#E86A10] hover:bg-[#d45e0d] text-white flex items-center justify-center shadow-md transition-all active:scale-95 shrink-0 cursor-pointer"
          title="Gửi câu hỏi">
          <i data-lucide="send" class="w-4 h-4"></i>
        </button>
      </form>
    </div>

    <!-- Nút Bật/Tắt Chat AI nổi góc màn hình -->
    <button 
      id="btn-toggle-ai-chat" 
      type="button" 
      class="group relative flex items-center gap-2.5 px-4 py-3 rounded-full bg-gradient-to-r from-[#1a3d1a] to-[#E86A10] text-white shadow-[0_10px_25px_-5px_rgba(26,61,26,0.5)] hover:scale-106 active:scale-95 transition-all cursor-pointer border-2 border-white/40"
      title="Chat với Bác sĩ Thú Y AI 24/7">
      <span class="relative flex h-3 w-3">
        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-300 opacity-75"></span>
        <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-400"></span>
      </span>
      <span class="text-lg">🐾</span>
      <div class="text-left hidden sm:block">
        <span class="block text-xs font-bold leading-tight">Hỏi Bác Sĩ AI</span>
        <span class="block text-[9px] text-emerald-200 leading-tight">Trực tuyến 24/7</span>
      </div>
    </button>
  </div>

  <script>
    // ===== LOGIC CHAT WIDGET VỚI OPENROUTER AI =====
    (function initPawBotAIChat() {
      const toggleBtn = document.getElementById('btn-toggle-ai-chat');
      const closeBtn = document.getElementById('ai-chat-close');
      const chatWindow = document.getElementById('ai-chat-window');
      const chatForm = document.getElementById('ai-chat-form');
      const userInput = document.getElementById('ai-user-input');
      const messagesContainer = document.getElementById('ai-chat-messages');
      const typingIndicator = document.getElementById('ai-typing');
      const sendBtn = document.getElementById('ai-btn-send');

      if (!toggleBtn || !chatWindow) return;

      let chatHistory = [];

      toggleBtn.onclick = () => {
        chatWindow.classList.toggle('hidden');
        if (!chatWindow.classList.contains('hidden')) {
          userInput?.focus();
          scrollToBottom();
        }
      };

      closeBtn.onclick = () => {
        chatWindow.classList.add('hidden');
      };

      function scrollToBottom() {
        if (messagesContainer) {
          messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
      }

      function formatReplyText(text) {
        // Chuyển markdown cơ bản (**in đậm**, - danh sách, dòng mới) thành HTML an toàn
        let safe = text
          .replace(/&/g, '&amp;')
          .replace(/</g, '&lt;')
          .replace(/>/g, '&gt;');
        
        safe = safe.replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>');
        safe = safe.replace(/\*([^*]+)\*/g, '<em>$1</em>');
        safe = safe.replace(/\n/g, '<br>');
        return safe;
      }

      function appendMessage(role, text) {
        if (!messagesContainer) return;
        const msgDiv = document.createElement('div');

        if (role === 'user') {
          msgDiv.className = 'flex justify-end animate-fade-in';
          msgDiv.innerHTML = `
            <div class="max-w-[85%] bg-[#1a3d1a] text-white p-3 rounded-2xl rounded-tr-xs shadow-2xs">
              <p>${text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/\n/g, '<br>')}</p>
            </div>
          `;
        } else {
          msgDiv.className = 'flex items-start gap-2 animate-fade-in';
          msgDiv.innerHTML = `
            <div class="w-7 h-7 rounded-full bg-[#1a3d1a] text-white flex items-center justify-center text-xs shrink-0 shadow-2xs">
              🐾
            </div>
            <div class="max-w-[85%] bg-white p-3 rounded-2xl rounded-tl-xs border border-gray-200 text-gray-800 shadow-2xs space-y-1">
              ${formatReplyText(text)}
            </div>
          `;
        }

        messagesContainer.appendChild(msgDiv);
        scrollToBottom();
      }

      async function sendMessage(text) {
        if (!text || text.trim() === '') return;
        appendMessage('user', text);
        chatHistory.push({ role: 'user', content: text });

        if (userInput) userInput.value = '';
        if (typingIndicator) typingIndicator.classList.remove('hidden');
        if (sendBtn) sendBtn.disabled = true;
        scrollToBottom();

        try {
          const res = await fetch('/api/ai_chat.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
              message: text,
              history: chatHistory
            })
          });

          const data = await res.json();
          if (typingIndicator) typingIndicator.classList.add('hidden');
          if (sendBtn) sendBtn.disabled = false;

          if (data.success && data.reply) {
            appendMessage('assistant', data.reply);
            chatHistory.push({ role: 'assistant', content: data.reply });
          } else {
            appendMessage('assistant', data.message || 'Dạ PawBot đang mất tín hiệu một chút, ba mẹ thử lại sau ít giây nhé! 🐾');
          }
        } catch (err) {
          if (typingIndicator) typingIndicator.classList.add('hidden');
          if (sendBtn) sendBtn.disabled = false;
          appendMessage('assistant', 'Dạ hiện tại đường truyền đang chập chờn. Ba mẹ có thể gọi thẳng Hotline 0900 123 456 để gặp Bác sĩ Khang hỗ trợ ngay ạ! 🩺');
        }
      }

      if (chatForm) {
        chatForm.onsubmit = (e) => {
          e.preventDefault();
          const q = userInput?.value?.trim();
          if (q) sendMessage(q);
        };
      }

      // Hàm gọi từ Quick Prompt Chips
      window.sendQuickPrompt = (promptText) => {
        if (chatWindow.classList.contains('hidden')) {
          chatWindow.classList.remove('hidden');
        }
        sendMessage(promptText);
      };
    })();
  </script>
</body>
</html>
