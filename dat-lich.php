<?php
/**
 * PawNest - Trang Đặt Lịch Hẹn Trực Tuyến (Mục 2.3, FR-20 đến FR-23)
 * Giao diện đặt lịch nhanh dưới 1 phút, kiểm tra dữ liệu hợp lệ
 */

declare(strict_types=1);

$page_title = 'Đặt Lịch Hẹn Chăm Sóc & Khám Thú Y | PawNest';
$page_desc = 'Đặt lịch hẹn khám chữa bệnh, tiêm phòng và spa cho thú cưng tại PawNest trong vòng 1 phút. Nhắc lịch tự động qua điện thoại.';
$active_menu = 'booking';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/repository/ServiceRepository.php';

$serviceRepo = new ServiceRepository();
$allServices = $serviceRepo->findActive();

$preset_service = $_GET['service'] ?? '';
$preset_pet = $_GET['pet'] ?? '';
?>

<main class="py-12 px-4 sm:px-6 max-w-4xl mx-auto" id="dat-lich">
  <div class="text-center max-w-xl mx-auto mb-10">
    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-semibold mb-3">
      <span>⚡ Đặt Lịch Nhanh Dưới 1 Phút • Không Cần Tạo Tài Khoản</span>
    </div>
    <h1 class="font-serif-display text-3xl sm:text-4xl text-[#1a3d1a] tracking-tight">
      Đặt Lịch Hẹn Khám & Spa Thú Cưng
    </h1>
    <p class="text-xs sm:text-sm text-gray-600 mt-2">
      Điền thông tin bé cưng và chọn khung giờ thuận tiện. Đội ngũ bác sĩ và chuyên viên PawNest sẽ chuẩn bị đón tiếp chu đáo nhất!
    </p>
  </div>

  <div class="clay-card p-6 sm:p-10 bg-white">
    <!-- Hộp thông báo phản hồi (Success / Error) -->
    <div id="ms" style="display: none;" class="p-4 rounded-2xl mb-6 text-xs sm:text-sm"></div>

    <form id="form-booking" class="space-y-6">
      <!-- 1. Dịch vụ & Loại thú cưng -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
          <label class="block text-xs font-bold text-gray-700 mb-1.5">
            Dịch vụ hoặc Gói chăm sóc <span class="text-red-500">*</span>
          </label>
          <select id="sv" class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-xs sm:text-sm focus:ring-2 focus:ring-[#1a3d1a] focus:outline-none clay-input">
            <?php if (!empty($allServices)): ?>
              <?php foreach ($allServices as $s): ?>
                <option value="<?= e($s['name']) ?>" <?= ($preset_service === $s['name']) ? 'selected' : '' ?>>
                  <?= e($s['name']) ?> (<?= number_format((float)$s['price'], 0, ',', '.') ?> ₫<?= !empty($s['is_package']) ? ' - Gói' : '' ?>)
                </option>
              <?php endforeach; ?>
            <?php else: ?>
              <option value="Gói Spa & cắt tỉa" <?= $preset_service === 'Gói Spa & cắt tỉa' ? 'selected' : '' ?>>Gói Spa & cắt tỉa (Phổ biến nhất)</option>
              <option value="Gói Cơ bản" <?= $preset_service === 'Gói Cơ bản' ? 'selected' : '' ?>>Gói Cơ bản (Tắm & Vệ sinh)</option>
              <option value="Gói Toàn diện" <?= $preset_service === 'Gói Toàn diện' ? 'selected' : '' ?>>Gói Toàn diện (VIP Care + Khám)</option>
              <option value="Khám tổng quát" <?= $preset_service === 'Khám tổng quát' ? 'selected' : '' ?>>Khám tổng quát & Chẩn đoán</option>
              <option value="Tiêm phòng vaccine" <?= $preset_service === 'Tiêm phòng vaccine' ? 'selected' : '' ?>>Tiêm phòng vaccine & Tẩy giun</option>
            <?php endif; ?>
          </select>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-700 mb-1.5">
            Loài thú cưng <span class="text-red-500">*</span>
          </label>
          <select id="pt" class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-xs sm:text-sm focus:ring-2 focus:ring-[#1a3d1a] focus:outline-none clay-input">
            <option value="Chó">Chó cưng 🐶</option>
            <option value="Mèo">Mèo cưng 🐱</option>
            <option value="Thỏ">Thỏ kiểng 🐰</option>
            <option value="Khác">Thú cưng khác 🐾</option>
          </select>
        </div>
      </div>

      <!-- 2. Thông tin bé & Thông tin chủ nuôi -->
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div>
          <label class="block text-xs font-bold text-gray-700 mb-1.5">
            Tên bé cưng <span class="text-red-500">*</span>
          </label>
          <input
            id="pn"
            type="text"
            placeholder="Ví dụ: Mochi, Bơ..."
            value="<?= e($preset_pet) ?>"
            required
            class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-xs sm:text-sm focus:ring-2 focus:ring-[#1a3d1a] focus:outline-none clay-input"
          />
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-700 mb-1.5">
            Họ và tên chủ nuôi <span class="text-red-500">*</span>
          </label>
          <input
            id="nm"
            type="text"
            placeholder="Nguyễn Văn A"
            required
            class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-xs sm:text-sm focus:ring-2 focus:ring-[#1a3d1a] focus:outline-none clay-input"
          />
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-700 mb-1.5">
            Số điện thoại nhận tin <span class="text-red-500">*</span>
          </label>
          <input
            id="ph"
            type="tel"
            placeholder="0912345678"
            required
            class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-xs sm:text-sm focus:ring-2 focus:ring-[#1a3d1a] focus:outline-none clay-input"
          />
          <span class="text-[10px] text-gray-400 mt-0.5 block">Đủ 10 số, bắt đầu bằng số 0</span>
        </div>
      </div>

      <!-- 3. Ngày hẹn & Khung giờ -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
          <label class="block text-xs font-bold text-gray-700 mb-1.5">
            Ngày hẹn khám / spa <span class="text-red-500">*</span>
          </label>
          <input
            id="dt"
            type="date"
            required
            class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-xs sm:text-sm focus:ring-2 focus:ring-[#1a3d1a] focus:outline-none clay-input"
          />
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-700 mb-1.5">
            Khung giờ mong muốn <span class="text-red-500">*</span>
          </label>
          <select id="tm" class="w-full px-4 py-3 rounded-2xl border border-gray-200 text-xs sm:text-sm focus:ring-2 focus:ring-[#1a3d1a] focus:outline-none clay-input">
            <option value="08:30">08:30 sáng</option>
            <option value="09:30" selected>09:30 sáng</option>
            <option value="10:30">10:30 sáng</option>
            <option value="11:30">11:30 trưa</option>
            <option value="14:00">14:00 chiều</option>
            <option value="15:30">15:30 chiều</option>
            <option value="17:00">17:00 chiều</option>
            <option value="18:30">18:30 tối</option>
          </select>
        </div>
      </div>

      <!-- 4. Phương thức thanh toán -->
      <div>
        <label class="block text-xs font-bold text-gray-700 mb-3">
          Phương thức thanh toán <span class="text-red-500">*</span>
        </label>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="payment-options">
          <!-- Thanh toán tại quán -->
          <label for="pay-store" class="payment-opt cursor-pointer">
            <input type="radio" id="pay-store" name="payment_method" value="at_store" class="sr-only" checked />
            <div class="payment-opt-box flex items-center gap-3 p-4 rounded-2xl border-2 border-[#1a3d1a] bg-emerald-50 transition-all">
              <div class="w-10 h-10 rounded-full bg-[#1a3d1a] text-white flex items-center justify-center shrink-0 text-lg">🏪</div>
              <div>
                <p class="font-bold text-[#1a3d1a] text-sm">Thanh toán tại quán</p>
                <p class="text-xs text-gray-500 mt-0.5">Trả tiền mặt hoặc thẻ khi đến cơ sở</p>
              </div>
              <div class="ml-auto w-5 h-5 rounded-full border-2 border-[#1a3d1a] flex items-center justify-center shrink-0">
                <div class="pay-dot w-2.5 h-2.5 rounded-full bg-[#1a3d1a]"></div>
              </div>
            </div>
          </label>

          <!-- Thanh toán chuyển khoản QR -->
          <label for="pay-qr" class="payment-opt cursor-pointer">
            <input type="radio" id="pay-qr" name="payment_method" value="bank_transfer" class="sr-only" />
            <div class="payment-opt-box flex items-center gap-3 p-4 rounded-2xl border-2 border-gray-200 bg-white transition-all">
              <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center shrink-0 text-lg">📱</div>
              <div>
                <p class="font-bold text-gray-800 text-sm">Chuyển khoản QR Code</p>
                <p class="text-xs text-gray-500 mt-0.5">Quét mã VietQR — xác nhận ngay tức thì</p>
              </div>
              <div class="ml-auto w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center shrink-0">
                <div class="pay-dot w-2.5 h-2.5 rounded-full bg-transparent"></div>
              </div>
            </div>
          </label>
        </div>
      </div>

      <!-- Điều khoản đồng ý dữ liệu cá nhân (Nghị định 13/2023/NĐ-CP) -->
      <div class="flex items-start gap-2.5 pt-2">
        <input type="checkbox" id="consent" checked required class="mt-1 rounded text-[#E86A10] focus:ring-[#E86A10]" />
        <label for="consent" class="text-xs text-gray-500 leading-snug">
          Tôi đồng ý cho PawNest liên hệ qua số điện thoại để xác nhận lịch hẹn và lưu trữ thông tin chăm sóc bé cưng theo chính sách bảo vệ dữ liệu cá nhân.
        </label>
      </div>

      <!-- Nút Gửi Form -->
      <div class="pt-4">
        <button
          type="submit"
          class="w-full py-4 rounded-full bg-[#E86A10] hover:bg-[#d45e0d] text-white font-bold text-sm tracking-wide shadow-lg transition-all active:scale-98 clay-btn-orange cursor-pointer"
        >
          Xác Nhận Đặt Lịch Hẹn Ngay
        </button>
      </div>
    </form>
  </div>

  <style>
    /* Payment option toggle styles — dùng chung với footer global */
    .payment-opt input:checked ~ .payment-opt-box { border-color: #1a3d1a; background-color: #f0fdf4; }
    .payment-opt input:not(:checked) ~ .payment-opt-box { border-color: #e5e7eb; background-color: #fff; }
    .payment-opt input:checked ~ .payment-opt-box .pay-dot { background-color: #1a3d1a; }
    .payment-opt input:not(:checked) ~ .payment-opt-box .pay-dot { background-color: transparent; }
  </style>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
