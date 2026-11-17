<?php
/**
 * PawNest - Trang Đánh Giá & Cảm Nhận Của Chủ Nuôi (Mục 2.5, FR-40, FR-41, FR-42)
 * Hiển thị đánh giá số sao, tên chủ nuôi, tên bé và form gửi đánh giá
 */

declare(strict_types=1);

$page_title = 'Đánh Giá Của Khách Hàng | PawNest';
$page_desc = 'Hơn 98.000+ chủ nuôi đã tin tưởng và đánh giá 4.9/5 sao cho dịch vụ khám chữa bệnh và spa thú cưng tại PawNest.';
$active_menu = 'reviews';

require_once __DIR__ . '/includes/header.php';

// Danh sách đánh giá mẫu đã kiểm duyệt
$reviews = [
    [
        'stars' => 5,
        'author' => 'Chị Thu Hà',
        'pet' => 'Bé Corgi "Bơ"',
        'service' => 'Gói Spa & Cắt tỉa',
        'date' => '14/11/2026',
        'content' => 'Bác sĩ Khang và các bạn nhân viên cực kỳ nhẹ nhàng với bé Bơ! Bơ nhà mình nhát người lạ lắm nhưng tới đây được dỗ dành nên nằm ngoan re. Cắt mông trái tim cưng xỉu, về nhà ai cũng khen!'
    ],
    [
        'stars' => 5,
        'author' => 'Anh Minh Quân',
        'pet' => 'Bé Mèo "Mướp"',
        'service' => 'Khám tổng quát & Tiêm phòng',
        'date' => '12/11/2026',
        'content' => 'Phòng khám vô trùng, sạch sẽ và không hề có mùi hôi. Bác sĩ tư vấn rất kỹ về chế độ dinh dưỡng chống sỏi thận cho mèo đực. Giá cả niêm yết rõ ràng, không vẽ thêm dịch vụ linh tinh.'
    ],
    [
        'stars' => 5,
        'author' => 'Bạn Ngọc Anh',
        'pet' => 'Bé Poodle "Mochi"',
        'service' => 'Gói Toàn diện',
        'date' => '10/11/2026',
        'content' => 'Dịch vụ tắm sấy và vệ sinh tai móng 10/10! Có khu vực ngồi chờ kính trong suốt nhìn trực tiếp các bạn làm cho bé nên rất yên tâm. Sẽ ủng hộ PawNest dài lâu!'
    ],
    [
        'stars' => 5,
        'author' => 'Cô Hoàng Yến',
        'pet' => 'Bé Ba Tư "Bông"',
        'service' => 'Điều trị nấm da & Tắm thảo mộc',
        'date' => '05/11/2026',
        'content' => 'Bé Bông bị viêm da dị ứng chữa nhiều nơi không khỏi, qua Bác sĩ Khang cho phác đồ tắm thảo dược 2 tuần là da bé khô ráo, lông mọc lại mịn màng. Cảm ơn đội ngũ rất nhiều!'
    ],
    [
        'stars' => 4,
        'author' => 'Bạn Thảo Vy',
        'pet' => 'Bé Thỏ "Cà Rốt"',
        'service' => 'Cắt móng & Vệ sinh tai',
        'date' => '02/11/2026',
        'content' => 'Rất hiếm trung tâm thú y nhận chăm sóc thỏ kiểng chuyên nghiệp như PawNest. Bác sĩ bế thỏ chuẩn động tác, không làm bé hoảng sợ.'
    ],
    [
        'stars' => 5,
        'author' => 'Chị Phương Linh',
        'pet' => 'Bé Phốc sóc "Xíu"',
        'service' => 'Cắt tỉa & Nhuộm tai Organic',
        'date' => '28/10/2026',
        'content' => 'Groomer tay nghề cực đỉnh, tạo hình tròn vo như cục bông gòn. Nước hoa dưỡng lông giữ mùi thơm tự nhiên suốt cả tuần!'
    ]
];
?>

<main class="py-12 px-4 sm:px-6 max-w-6xl mx-auto">
  <div class="text-center max-w-2xl mx-auto mb-12">
    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-amber-100 text-[#E86A10] text-xs font-semibold mb-3">
      <span>⭐ 4.9/5 Điểm Hài Lòng Tuyệt Đối</span>
    </div>
    <h1 class="font-serif-display text-3xl sm:text-4xl text-[#1a3d1a] tracking-tight">
      Đánh Giá Từ Khách Hàng Thân Thiết
    </h1>
    <p class="text-xs sm:text-sm text-gray-600 mt-2">
      Những chia sẻ và cảm nhận chân thật nhất từ các ba mẹ đã trao gửi niềm tin cho PawNest.
    </p>
  </div>

  <!-- Thống kê điểm số tổng quan -->
  <div class="clay-card p-8 mb-12 bg-[#EFFDF0] border border-[#1a3d1a]/15 flex flex-col md:flex-row items-center justify-around gap-6 text-center md:text-left">
    <div class="flex items-center gap-4">
      <span class="text-5xl font-extrabold text-[#1a3d1a]">4.9</span>
      <div>
        <div class="flex items-center gap-1 text-[#E86A10] text-xl">
          ★★★★★
        </div>
        <p class="text-xs text-gray-500 mt-1">Dựa trên hơn <strong>98.000+ lượt đánh giá</strong></p>
      </div>
    </div>
    <div class="h-10 w-px bg-gray-300 hidden md:block"></div>
    <div class="flex items-center gap-6 text-xs text-gray-600">
      <div>
        <span class="block text-2xl font-bold text-[#1a3d1a]">99.2%</span>
        <span>Sẽ quay lại lần sau</span>
      </div>
      <div>
        <span class="block text-2xl font-bold text-[#1a3d1a]">98.7%</span>
        <span>Hài lòng về tay nghề</span>
      </div>
      <div>
        <span class="block text-2xl font-bold text-[#1a3d1a]">100%</span>
        <span>Minh bạch bảng giá</span>
      </div>
    </div>
  </div>

  <!-- Lưới danh sách đánh giá -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
    <?php foreach ($reviews as $rev): ?>
      <div class="clay-card p-6 flex flex-col justify-between">
        <div>
          <div class="flex items-center justify-between mb-3">
            <div class="text-[#E86A10] text-base">
              <?= str_repeat('★', $rev['stars']) . str_repeat('☆', 5 - $rev['stars']) ?>
            </div>
            <span class="text-[10px] text-gray-400"><?= e($rev['date']) ?></span>
          </div>
          <p class="text-xs text-gray-700 leading-relaxed italic mb-4">
            "<?= e($rev['content']) ?>"
          </p>
        </div>
        <div class="pt-3 border-t border-gray-100 flex items-center gap-3">
          <div class="w-9 h-9 rounded-full bg-emerald-100 text-[#1a3d1a] font-bold flex items-center justify-center text-xs shrink-0">
            <?= mb_substr($rev['author'], 0, 1, 'UTF-8') ?>
          </div>
          <div class="text-xs">
            <h4 class="font-bold text-[#1a3d1a]"><?= e($rev['author']) ?></h4>
            <p class="text-[11px] text-gray-500"><?= e($rev['pet']) ?> • <span class="text-emerald-700 font-semibold"><?= e($rev['service']) ?></span></p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Form Gửi Đánh Giá Mới (FR-41) -->
  <div class="clay-card p-8 max-w-xl mx-auto bg-white border border-gray-100">
    <h3 class="font-bold text-lg text-[#1a3d1a] mb-2 text-center">Gửi Đánh Giá Trải Nghiệm Của Bạn</h3>
    <p class="text-xs text-gray-500 mb-6 text-center">Đánh giá của bạn giúp PawNest không ngừng hoàn thiện chất lượng dịch vụ.</p>
    
    <form onsubmit="event.preventDefault(); alert('Cảm ơn bạn đã gửi đánh giá! Ban quản trị PawNest sẽ duyệt và hiển thị trong 24 giờ.'); this.reset();" class="space-y-4">
      <div>
        <label class="block text-xs font-semibold text-gray-700 mb-1">Mức độ hài lòng *</label>
        <select class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs clay-input">
          <option value="5">⭐⭐⭐⭐⭐ - Tuyệt vời (5 sao)</option>
          <option value="4">⭐⭐⭐⭐ - Rất tốt (4 sao)</option>
          <option value="3">⭐⭐⭐ - Bình thường (3 sao)</option>
          <option value="2">⭐⭐ - Cần cải thiện (2 sao)</option>
          <option value="1">⭐ - Không hài lòng (1 sao)</option>
        </select>
      </div>
      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-semibold text-gray-700 mb-1">Tên chủ nuôi *</label>
          <input type="text" placeholder="Chị Lan" required class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs clay-input" />
        </div>
        <div>
          <label class="block text-xs font-semibold text-gray-700 mb-1">Tên bé cưng *</label>
          <input type="text" placeholder="Bé Lu" required class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs clay-input" />
        </div>
      </div>
      <div>
        <label class="block text-xs font-semibold text-gray-700 mb-1">Nội dung nhận xét *</label>
        <textarea rows="3" placeholder="Chia sẻ cảm nhận của bạn về bác sĩ, cơ sở vật chất, sự chăm sóc..." required class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs clay-input"></textarea>
      </div>
      <button type="submit" class="w-full py-3 rounded-full bg-[#1a3d1a] hover:bg-[#2a5a2a] text-white font-bold text-xs clay-btn-green cursor-pointer">
        Gửi Đánh Giá Của Bạn
      </button>
    </form>
  </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
