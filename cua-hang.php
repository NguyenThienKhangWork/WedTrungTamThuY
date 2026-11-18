<?php
/**
 * PawNest & CozyPaws - Cửa hàng Thú Cưng Online (Shop)
 * Cung cấp Thức ăn dinh dưỡng, Thuốc & Vắc xin thú y, Vật tư tiêu hao và Phụ kiện
 */

declare(strict_types=1);

$page_title = "Cửa hàng Thức ăn, Thuốc & Vật tư Thú Cưng | PawNest & CozyPaws";
$active_menu = "shop";

require_once __DIR__ . "/includes/header.php";
require_once __DIR__ . "/repository/ProductRepository.php";

$repo = new ProductRepository();
$category = $_GET['cat'] ?? null;
$search = $_GET['q'] ?? null;

$products = $repo->findAll($category, false, $search, true);

function formatShopPrice(float|int $p): string {
    return number_format($p, 0, ',', '.') . ' ₫';
}
?>

  <!-- HERO BANNER CỬA HÀNG -->
  <section class="py-12 px-6 sm:px-12 bg-gradient-to-b from-[#EFFDF0] to-white border-b border-[#1a3d1a]/10">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-8">
      <div class="space-y-4 max-w-2xl">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-100/80 text-emerald-800 text-xs font-bold shadow-2xs">
          <span>🐾</span>
          <span>Dược Thú Y & Dinh Dưỡng Chuẩn Y Khoa</span>
        </div>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-serif-display text-[#1a3d1a] leading-tight">
          Thức ăn, Thuốc & Vật tư Y tế cho Bé Cưng
        </h1>
        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
          Cam kết 100% vắc xin & thuốc đặc trị chính hãng, lưu trữ chuẩn nhiệt độ 2-8°C. Thức ăn hạt cao cấp và pate tươi chế biến trong ngày không chất phụ gia.
        </p>

        <!-- Tiêu chí bảo đảm y khoa -->
        <div class="flex flex-wrap gap-4 pt-2 text-xs font-semibold text-[#1a3d1a]">
          <span class="flex items-center gap-1.5 bg-white px-3 py-1.5 rounded-full border border-gray-200 shadow-2xs">
            <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i> Dược sĩ thú y kiểm duyệt
          </span>
          <span class="flex items-center gap-1.5 bg-white px-3 py-1.5 rounded-full border border-gray-200 shadow-2xs">
            <i data-lucide="thermometer-snowflake" class="w-4 h-4 text-blue-600"></i> Chuỗi cung ứng lạnh 2-8°C
          </span>
          <span class="flex items-center gap-1.5 bg-white px-3 py-1.5 rounded-full border border-gray-200 shadow-2xs">
            <i data-lucide="shield-check" class="w-4 h-4 text-[#E86A10]"></i> Đổi trả trong 48h
          </span>
        </div>
      </div>

      <!-- Card nổi bật Cozy Cat House -->
      <div class="w-full max-w-[280px] shrink-0">
        <div class="clay-card p-4 rounded-3xl bg-white border border-[#1a3d1a]/10 shadow-lg text-center">
          <div class="relative aspect-square rounded-2xl overflow-hidden bg-amber-50 mb-3">
            <img 
              src="https://polo-pecan-73837341.figma.site/_assets/v11/3e5158dad63d392ade022e81890edc9f54d750bc.png" 
              alt="Cozy Cat House" 
              class="w-full h-full object-cover hover:scale-108 transition-transform duration-500"
            />
            <span class="absolute top-2.5 right-2.5 px-2 py-0.5 rounded-full bg-[#E86A10] text-white text-[10px] font-extrabold uppercase">
              Hot Deal
            </span>
          </div>
          <h3 class="font-bold text-sm text-[#1a3d1a]">Cozy Cat House 2 Tầng</h3>
          <p class="text-xs text-gray-500 mt-0.5">Nhà cào móng nhung cam</p>
          <div class="text-base font-extrabold text-[#E86A10] my-2">1.250.000 ₫ ($49.99)</div>
          <button 
            onclick="openOrderModal(13, 'Nhà cây cho mèo Cozy Cat House 2 tầng', 1250000, 'Bộ', 7)"
            class="w-full py-2 rounded-xl bg-[#1a3d1a] hover:bg-[#2a5a2a] text-white font-bold text-xs shadow-md transition-all cursor-pointer">
            Đặt giữ hàng ngay
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- DANH MỤC & LƯỚI SẢN PHẨM -->
  <section class="py-12 px-6 sm:px-12 max-w-7xl mx-auto">
    <!-- Thanh lọc & tìm kiếm -->
    <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4 mb-8">
      <!-- Tabs danh mục -->
      <div class="flex flex-wrap items-center gap-2">
        <a href="/cua-hang.php" class="px-4 py-2 rounded-full text-xs font-bold transition-all <?= empty($category) ? 'bg-[#1a3d1a] text-white shadow-sm' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' ?>">
          Tất cả sản phẩm
        </a>
        <a href="/cua-hang.php?cat=medicine" class="px-4 py-2 rounded-full text-xs font-bold transition-all <?= $category === 'medicine' ? 'bg-red-700 text-white shadow-sm' : 'bg-white text-red-700 hover:bg-red-50 border border-red-200' ?>">
          💊 Thuốc & Vắc xin
        </a>
        <a href="/cua-hang.php?cat=food" class="px-4 py-2 rounded-full text-xs font-bold transition-all <?= $category === 'food' ? 'bg-amber-700 text-white shadow-sm' : 'bg-white text-amber-700 hover:bg-amber-50 border border-amber-200' ?>">
          🥣 Thức ăn dinh dưỡng
        </a>
        <a href="/cua-hang.php?cat=supply" class="px-4 py-2 rounded-full text-xs font-bold transition-all <?= $category === 'supply' ? 'bg-blue-700 text-white shadow-sm' : 'bg-white text-blue-700 hover:bg-blue-50 border border-blue-200' ?>">
          🩹 Vật tư tiêu hao
        </a>
        <a href="/cua-hang.php?cat=accessory" class="px-4 py-2 rounded-full text-xs font-bold transition-all <?= $category === 'accessory' ? 'bg-purple-700 text-white shadow-sm' : 'bg-white text-purple-700 hover:bg-purple-50 border border-purple-200' ?>">
          🏠 Phụ kiện CozyPaws
        </a>
      </div>

      <!-- Ô tìm kiếm -->
      <form method="GET" class="relative max-w-xs w-full">
        <?php if ($category): ?>
          <input type="hidden" name="cat" value="<?= htmlspecialchars($category) ?>">
        <?php endif; ?>
        <input 
          type="text" 
          name="q" 
          value="<?= htmlspecialchars($search ?? '') ?>" 
          placeholder="Tìm tên thuốc, thức ăn..." 
          class="w-full pl-9 pr-4 py-2 rounded-full border border-gray-300 text-xs bg-white focus:outline-none focus:ring-2 focus:ring-[#1a3d1a]"
        />
        <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-2.5"></i>
      </form>
    </div>

    <!-- Grid danh sách sản phẩm -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <?php if (empty($products)): ?>
        <div class="col-span-full py-16 text-center text-gray-400">
          <div class="text-4xl mb-2">🔍</div>
          <p class="text-sm font-semibold">Không tìm thấy sản phẩm nào phù hợp.</p>
          <a href="/cua-hang.php" class="text-xs text-[#E86A10] font-bold mt-2 inline-block hover:underline">Xem tất cả sản phẩm →</a>
        </div>
      <?php endif; ?>

      <?php foreach ($products as $item): 
        $inStock = $item['stock_quantity'] > 0;
        $isCritical = (bool)$item['is_critical'];
      ?>
        <div class="clay-card rounded-3xl overflow-hidden group flex flex-col justify-between bg-white border border-[#1a3d1a]/10 hover:shadow-xl transition-all duration-300">
          <div>
            <!-- Ảnh sản phẩm -->
            <div class="aspect-[4/3] relative overflow-hidden bg-gray-50">
              <img 
                src="<?= htmlspecialchars($item['image'] ?: 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=500&q=80') ?>" 
                alt="<?= htmlspecialchars($item['name']) ?>" 
                class="w-full h-full object-cover group-hover:scale-106 transition-transform duration-500"
              />
              
              <!-- Badges -->
              <div class="absolute top-2.5 left-2.5 flex flex-col gap-1 items-start">
                <?php if ($item['category'] === 'medicine'): ?>
                  <span class="px-2 py-0.5 rounded-full bg-red-600 text-white font-bold text-[9px] shadow-xs">
                    💊 Y tế & Vắc xin
                  </span>
                <?php elseif ($item['category'] === 'food'): ?>
                  <span class="px-2 py-0.5 rounded-full bg-amber-600 text-white font-bold text-[9px] shadow-xs">
                    🥣 Thức ăn
                  </span>
                <?php elseif ($item['category'] === 'supply'): ?>
                  <span class="px-2 py-0.5 rounded-full bg-blue-600 text-white font-bold text-[9px] shadow-xs">
                    🩹 Vật tư
                  </span>
                <?php else: ?>
                  <span class="px-2 py-0.5 rounded-full bg-purple-600 text-white font-bold text-[9px] shadow-xs">
                    🏠 Phụ kiện
                  </span>
                <?php endif; ?>

                <?php if ($isCritical): ?>
                  <span class="px-2 py-0.5 rounded-full bg-black/70 backdrop-blur-xs text-amber-300 font-extrabold text-[9px]">
                    ⭐ Thuốc thiết yếu
                  </span>
                <?php endif; ?>
              </div>

              <!-- Tình trạng kho -->
              <div class="absolute bottom-2.5 right-2.5">
                <?php if ($inStock): ?>
                  <span class="px-2 py-0.5 rounded-full bg-green-500/90 backdrop-blur-xs text-white font-bold text-[9px]">
                    ✓ Còn hàng
                  </span>
                <?php else: ?>
                  <span class="px-2 py-0.5 rounded-full bg-red-600/90 backdrop-blur-xs text-white font-bold text-[9px]">
                    Tạm hết
                  </span>
                <?php endif; ?>
              </div>
            </div>

            <!-- Nội dung chi tiết -->
            <div class="p-4 space-y-2">
              <span class="text-[10px] text-gray-400 font-mono uppercase"><?= htmlspecialchars($item['sku']) ?></span>
              <h3 class="font-bold text-sm text-[#1a3d1a] line-clamp-2 leading-snug group-hover:text-[#E86A10] transition-colors" title="<?= htmlspecialchars($item['name']) ?>">
                <?= htmlspecialchars($item['name']) ?>
              </h3>
              <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">
                <?= htmlspecialchars($item['description'] ?: 'Sản phẩm chính hãng phân phối tại trạm y tế thú cưng PawNest.') ?>
              </p>
            </div>
          </div>

          <!-- Giá & Nút mua -->
          <div class="p-4 pt-0">
            <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
              <div>
                <span class="text-[10px] text-gray-400 block">Giá niêm yết</span>
                <span class="text-base font-extrabold text-[#1a3d1a]"><?= formatShopPrice((float)$item['price']) ?></span>
                <span class="text-[10px] text-gray-500">/ <?= htmlspecialchars($item['unit']) ?></span>
              </div>

              <?php if ($inStock): ?>
                <button 
                  onclick="openOrderModal(<?= $item['id'] ?>, '<?= htmlspecialchars(addslashes($item['name'])) ?>', <?= (float)$item['price'] ?>, '<?= htmlspecialchars(addslashes($item['unit'])) ?>', <?= (int)$item['stock_quantity'] ?>)"
                  class="px-3.5 py-2 rounded-xl bg-[#E86A10] hover:bg-[#d45e0d] text-white font-bold text-xs shadow-md transition-all active:scale-95 cursor-pointer flex items-center gap-1.5">
                  <i data-lucide="shopping-bag" class="w-3.5 h-3.5"></i>
                  <span>Mua ngay</span>
                </button>
              <?php else: ?>
                <button disabled class="px-3.5 py-2 rounded-xl bg-gray-200 text-gray-400 font-bold text-xs cursor-not-allowed">
                  Tạm hết
                </button>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- ======================================================== -->
  <!-- MODAL ĐẶT MUA / THANH TOÁN SẢN PHẨM                      -->
  <!-- ======================================================== -->
  <div id="modal-order" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs hidden" role="dialog">
    <div class="bg-white rounded-3xl w-full max-w-md p-6 shadow-2xl relative border border-gray-100 max-h-[92vh] overflow-y-auto">
      <button onclick="closeOrderModal()" type="button" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 flex items-center justify-center font-bold">✕</button>

      <div class="flex items-center gap-2 mb-2">
        <span class="text-2xl">🛍️</span>
        <h3 class="text-lg font-bold text-[#1a3d1a]">Đặt Mua Sản Phẩm</h3>
      </div>
      <p class="text-xs text-gray-500 mb-4">Điền thông tin người nhận để giữ hàng và nhận tư vấn liều dùng từ bác sĩ.</p>

      <div id="order-alert" class="hidden p-3 rounded-xl mb-4 text-xs font-semibold"></div>

      <!-- Tóm tắt sản phẩm đang chọn -->
      <div class="bg-emerald-50/70 rounded-2xl p-3.5 border border-emerald-100 mb-4 space-y-1">
        <h4 id="order-prod-name" class="font-bold text-xs text-[#1a3d1a] leading-snug">—</h4>
        <div class="flex justify-between items-center text-xs pt-1">
          <span class="text-gray-500">Đơn giá: <strong id="order-prod-price" class="text-gray-900">—</strong></span>
          <span class="text-gray-500">Tồn kho: <span id="order-prod-stock" class="font-bold text-emerald-800">—</span></span>
        </div>
      </div>

      <form id="form-order" class="space-y-3.5">
        <input type="hidden" id="order-prod-id" name="product_id" value="">
        <input type="hidden" id="order-raw-price" value="0">

        <!-- Chọn số lượng -->
        <div>
          <label class="block text-xs font-semibold text-gray-700 mb-1">Số lượng mua</label>
          <div class="flex items-center gap-3">
            <button type="button" onclick="changeQty(-1)" class="w-9 h-9 rounded-xl border border-gray-300 font-bold text-gray-700 hover:bg-gray-100 text-base flex items-center justify-center cursor-pointer">-</button>
            <input type="number" id="order-qty" name="quantity" min="1" max="100" value="1" class="w-16 text-center py-1.5 rounded-xl border border-gray-300 font-bold text-sm focus:ring-2 focus:ring-[#1a3d1a] focus:outline-none" readonly>
            <button type="button" onclick="changeQty(1)" class="w-9 h-9 rounded-xl border border-gray-300 font-bold text-gray-700 hover:bg-gray-100 text-base flex items-center justify-center cursor-pointer">+</button>
            <div class="text-xs text-gray-500">
              Tổng tiền: <strong id="order-total-display" class="text-[#E86A10] text-sm font-extrabold">—</strong>
            </div>
          </div>
        </div>

        <div>
          <label class="block text-xs font-semibold text-gray-700 mb-1">Họ và tên người nhận *</label>
          <input type="text" id="order-name" name="customer_name" required placeholder="Nguyễn Văn A" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-xs sm:text-sm focus:ring-2 focus:ring-[#1a3d1a] focus:outline-none">
        </div>

        <div>
          <label class="block text-xs font-semibold text-gray-700 mb-1">Số điện thoại liên hệ * (10 số)</label>
          <input type="tel" id="order-phone" name="customer_phone" required placeholder="0912345678" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-xs sm:text-sm focus:ring-2 focus:ring-[#1a3d1a] focus:outline-none">
        </div>

        <div>
          <label class="block text-xs font-semibold text-gray-700 mb-1">Địa chỉ nhận hàng (hoặc ghi 'Nhận tại quầy')</label>
          <input type="text" id="order-address" name="customer_address" value="Nhận tại quầy PawNest Phú Nhuận" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-xs sm:text-sm focus:ring-2 focus:ring-[#1a3d1a] focus:outline-none">
        </div>

        <!-- Phương thức thanh toán -->
        <div>
          <label class="block text-xs font-semibold text-gray-700 mb-1.5">Phương thức thanh toán</label>
          <div class="flex gap-2">
            <label class="flex-1 cursor-pointer payment-opt-mini">
              <input type="radio" name="order_payment_method" value="at_store" class="sr-only" checked />
              <div class="pay-box-mini flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl border-2 border-[#1a3d1a] bg-emerald-50 text-xs font-semibold text-[#1a3d1a] transition-all">
                🏪 Tại quán / Nhận hàng
              </div>
            </label>
            <label class="flex-1 cursor-pointer payment-opt-mini">
              <input type="radio" name="order_payment_method" value="bank_transfer" class="sr-only" />
              <div class="pay-box-mini flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-xs font-semibold text-gray-600 transition-all">
                📱 QR Ngân hàng (VCB)
              </div>
            </label>
          </div>
        </div>

        <div>
          <label class="block text-xs font-semibold text-gray-700 mb-1">Ghi chú cho bác sĩ (tùy chọn)</label>
          <textarea id="order-notes" name="notes" rows="2" placeholder="Ví dụ: Bé nặng 3.5kg, cần hướng dẫn uống thuốc..." class="w-full px-3.5 py-2 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#1a3d1a] focus:outline-none"></textarea>
        </div>

        <button type="submit" id="order-submit-btn" class="w-full py-3 rounded-2xl bg-[#E86A10] hover:bg-[#d45e0d] text-white font-bold text-xs sm:text-sm shadow-md transition-all active:scale-98 cursor-pointer">
          Xác nhận đặt mua
        </button>
      </form>
    </div>
  </div>

  <script>
    let currentProduct = null;
    let maxStock = 1;

    function formatVND(n) {
      return new Intl.NumberFormat('vi-VN', {style:'currency', currency:'VND'}).format(n);
    }

    function openOrderModal(id, name, price, unit, stock) {
      currentProduct = { id, name, price, unit, stock };
      maxStock = stock;

      document.getElementById('order-prod-id').value = id;
      document.getElementById('order-raw-price').value = price;
      document.getElementById('order-prod-name').textContent = name;
      document.getElementById('order-prod-price').textContent = formatVND(price) + ' / ' + unit;
      document.getElementById('order-prod-stock').textContent = stock + ' ' + unit;
      
      const qtyInput = document.getElementById('order-qty');
      qtyInput.value = 1;
      updateTotalDisplay();

      // Điền sẵn thông tin khách đã đăng nhập
      const savedUser = JSON.parse(localStorage.getItem('pawnest_customer') || 'null');
      if (savedUser) {
        if (savedUser.name) document.getElementById('order-name').value = savedUser.name;
        if (savedUser.phone) document.getElementById('order-phone').value = savedUser.phone;
      }

      document.getElementById('order-alert').classList.add('hidden');
      document.getElementById('modal-order').classList.remove('hidden');
    }

    function closeOrderModal() {
      document.getElementById('modal-order').classList.add('hidden');
    }

    function changeQty(delta) {
      const input = document.getElementById('order-qty');
      let val = parseInt(input.value || '1') + delta;
      if (val < 1) val = 1;
      if (val > maxStock) {
        alert('Kho hiện chỉ còn tối đa ' + maxStock + ' sản phẩm.');
        val = maxStock;
      }
      input.value = val;
      updateTotalDisplay();
    }

    function updateTotalDisplay() {
      const price = parseFloat(document.getElementById('order-raw-price').value || '0');
      const qty = parseInt(document.getElementById('order-qty').value || '1');
      document.getElementById('order-total-display').textContent = formatVND(price * qty);
    }

    // Xử lý gửi đơn đặt hàng
    const formOrder = document.getElementById('form-order');
    if (formOrder) {
      formOrder.onsubmit = async (e) => {
        e.preventDefault();
        const submitBtn = document.getElementById('order-submit-btn');
        const alertBox = document.getElementById('order-alert');

        submitBtn.disabled = true;
        submitBtn.textContent = 'Đang xử lý đơn...';

        const payload = {
          product_id: parseInt(document.getElementById('order-prod-id').value),
          quantity: parseInt(document.getElementById('order-qty').value),
          customer_name: document.getElementById('order-name').value.trim(),
          customer_phone: document.getElementById('order-phone').value.trim(),
          customer_address: document.getElementById('order-address').value.trim(),
          payment_method: document.querySelector('input[name="order_payment_method"]:checked')?.value || 'at_store',
          notes: document.getElementById('order-notes').value.trim()
        };

        try {
          const res = await fetch('/api/shop_order.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
          });
          const data = await res.json();

          if (data.success) {
            alertBox.className = 'p-3 rounded-xl mb-4 text-xs font-semibold bg-green-50 text-green-800 border border-green-200';
            alertBox.textContent = data.message;
            alertBox.classList.remove('hidden');

            // Nếu khách chọn thanh toán QR -> Mở modal VietQR
            if (payload.payment_method === 'bank_transfer') {
              closeOrderModal();
              if (typeof openQrModal === 'function') {
                openQrModal('Don' + data.order_code, currentProduct.name, data.order_code);
                // Ghi đè số tiền thực của đơn
                setTimeout(() => {
                  const amtEl = document.getElementById('qr-g-amount');
                  const descEl = document.getElementById('qr-g-desc');
                  const imgEl = document.getElementById('qr-global-img');
                  if (amtEl) amtEl.textContent = formatVND(data.total_amount);
                  if (descEl) descEl.textContent = 'PawNest DH ' + data.order_code;
                  if (imgEl) {
                    const newQr = `https://img.vietqr.io/image/VCB-1051374267-compact2.png?amount=${data.total_amount}&addInfo=${encodeURIComponent('PawNest DH ' + data.order_code)}&accountName=${encodeURIComponent('NGUYEN THIEN KHANG')}`;
                    imgEl.src = newQr;
                  }
                }, 300);
              }
            } else {
              setTimeout(() => {
                alert('Đặt mua thành công mã đơn ' + data.order_code + '! PawNest sẽ liên hệ xác nhận giao hàng.');
                location.reload();
              }, 1200);
            }
          } else {
            alertBox.className = 'p-3 rounded-xl mb-4 text-xs font-semibold bg-red-50 text-red-800 border border-red-200';
            alertBox.textContent = data.message || 'Lỗi đặt mua.';
            alertBox.classList.remove('hidden');
          }
        } catch (err) {
          alertBox.className = 'p-3 rounded-xl mb-4 text-xs font-semibold bg-red-50 text-red-800 border border-red-200';
          alertBox.textContent = 'Lỗi kết nối máy chủ. Vui lòng thử lại sau.';
          alertBox.classList.remove('hidden');
        } finally {
          submitBtn.disabled = false;
          submitBtn.textContent = 'Xác nhận đặt mua';
        }
      };
    }
  </script>

<?php
require_once __DIR__ . "/includes/footer.php";
?>
