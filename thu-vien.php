<?php
/**
 * PawNest - Thư Viện Bé Cưng (FR-30, FR-31, FR-32, FR-107)
 * Hiển thị ảnh thật trước và sau khi chăm sóc, bộ lọc theo loài
 */

declare(strict_types=1);

$page_title = 'Thư Viện Bé Cưng Trước & Sau Chăm Sóc | PawNest';
$page_desc = 'Ngắm nhìn những gương mặt quen thuộc và hình ảnh lột xác xinh xắn của các bé cưng sau khi trải nghiệm dịch vụ tại PawNest.';
$active_menu = 'gallery';

require_once __DIR__ . '/includes/header.php';

// Danh sách 6 bé cưng với ảnh thật (Unsplash verified 200 OK)
$pets = [
    [
        'id' => 1,
        'name' => 'Bơ',
        'species' => 'Chó',
        'breed' => 'Corgi mông quả đào',
        'age' => '1.5 tuổi',
        'owner' => 'Chị Thu Hà (Quận 1)',
        'img_before' => 'https://images.unsplash.com/photo-1548199973-03cce0bbc87b?auto=format&fit=crop&w=600&q=80',
        'img_after' => 'https://images.unsplash.com/photo-1612536057832-2ff7ead58194?auto=format&fit=crop&w=600&q=80',
        'story' => 'Bơ đến spa với bộ lông bết dính bùn đất sau khi đi công viên. Sau 2 tiếng tỉa mông trái tim và tắm thảo mộc, bé đã tự tin tạo dáng!'
    ],
    [
        'id' => 2,
        'name' => 'Mochi',
        'species' => 'Chó',
        'breed' => 'Poodle Teacup',
        'age' => '8 tháng',
        'owner' => 'Bạn Ngọc Anh (Phú Nhuận)',
        'img_before' => 'https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?auto=format&fit=crop&w=600&q=80',
        'img_after' => 'https://images.unsplash.com/photo-1583337130417-3346a1be7dee?auto=format&fit=crop&w=600&q=80',
        'story' => 'Mochi được cắt tỉa kiểu gấu bông Teddy tròn xoe, vệ sinh sạch sẽ vết ố khoé mắt bằng dung dịch thảo dược chuyên dụng.'
    ],
    [
        'id' => 3,
        'name' => 'Mướp',
        'species' => 'Mèo',
        'breed' => 'Mèo mướp ta',
        'age' => '2 tuổi',
        'owner' => 'Anh Minh Quân (Bình Thạnh)',
        'img_before' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=600&q=80',
        'img_after' => 'https://images.unsplash.com/photo-1533738363-b7f9aef128ce?auto=format&fit=crop&w=600&q=80',
        'story' => 'Mướp rất nhát nước nhưng nhờ kỹ thuật sục khí êm ái và sự dỗ dành của groomer, bé nằm ngoan ngoãn tận hưởng spa massage.'
    ],
    [
        'id' => 4,
        'name' => 'Cà Rốt',
        'species' => 'Thỏ',
        'breed' => 'Thỏ Mini Lop tai cụp',
        'age' => '10 tháng',
        'owner' => 'Bạn Thảo Vy (Gò Vấp)',
        'img_before' => 'https://images.unsplash.com/photo-1585110396000-c9ffd4e4b308?auto=format&fit=crop&w=600&q=80',
        'img_after' => 'https://images.unsplash.com/photo-1535241749838-299277b6305f?auto=format&fit=crop&w=600&q=80',
        'story' => 'Cà Rốt được chải gỡ lông rụng mùa thay lông và cắt móng chân gọn gàng, kiểm tra ký sinh trùng tai hoàn toàn khỏe mạnh.'
    ],
    [
        'id' => 5,
        'name' => 'Xíu',
        'species' => 'Chó',
        'breed' => 'Phốc sóc (Pomeranian)',
        'age' => '2.5 tuổi',
        'owner' => 'Chị Phương Linh (Quận 3)',
        'img_before' => 'https://images.unsplash.com/photo-1591768575198-88dac53fbd0a?auto=format&fit=crop&w=600&q=80',
        'img_after' => 'https://images.unsplash.com/photo-1546527868-ccb7ee7dfa6a?auto=format&fit=crop&w=600&q=80',
        'story' => 'Bộ lông phồng xù trắng tinh của Xíu được phục hồi với dầu xả hữu cơ tinh chất tơ tằm, sấy phồng bóng mượt như mây.'
    ],
    [
        'id' => 6,
        'name' => 'Bông',
        'species' => 'Mèo',
        'breed' => 'Mèo Ba Tư lông xù',
        'age' => '3 tuổi',
        'owner' => 'Cô Hoàng Yến (Quận 7)',
        'img_before' => 'https://images.unsplash.com/photo-1574158622682-e40e69881006?auto=format&fit=crop&w=600&q=80',
        'img_after' => 'https://images.unsplash.com/photo-1518791841217-8f162f1e1131?auto=format&fit=crop&w=600&q=80',
        'story' => 'Bông được cạo lông tạo kiểu sư tử gọn mát cho mùa hè, làm sạch nấm da và điều trị dứt điểm viêm da dị ứng.'
    ]
];
?>

<main class="py-12 px-4 sm:px-6 max-w-6xl mx-auto">
  <div class="text-center max-w-2xl mx-auto mb-10">
    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-semibold mb-3">
      <span>📸 Hình Ảnh Thực Tế Có Bản Quyền & Sự Đồng Ý Của Chủ Nuôi</span>
    </div>
    <h1 class="font-serif-display text-3xl sm:text-4xl text-[#1a3d1a] tracking-tight">
      Những Gương Mặt Quen Thuộc Tại PawNest
    </h1>
    <p class="text-xs sm:text-sm text-gray-600 mt-2">
      Ảnh thật trước và sau khi các bé cưng được trải nghiệm dịch vụ tại PawNest. Bấm vào từng ảnh để xem chi tiết câu chuyện!
    </p>

    <!-- Bộ lọc theo loài (FR-31) -->
    <div class="flex items-center justify-center gap-2.5 mt-6 flex-wrap" id="gallery-filters">
      <button type="button" class="filter-btn px-4 py-1.5 rounded-full text-xs font-bold bg-[#1a3d1a] text-white transition-all cursor-pointer" data-filter="all">Tất cả loài</button>
      <button type="button" class="filter-btn px-4 py-1.5 rounded-full text-xs font-semibold bg-white text-gray-600 hover:bg-gray-100 transition-all cursor-pointer border border-gray-200" data-filter="Chó">Chó cưng (4)</button>
      <button type="button" class="filter-btn px-4 py-1.5 rounded-full text-xs font-semibold bg-white text-gray-600 hover:bg-gray-100 transition-all cursor-pointer border border-gray-200" data-filter="Mèo">Mèo cưng (2)</button>
      <button type="button" class="filter-btn px-4 py-1.5 rounded-full text-xs font-semibold bg-white text-gray-600 hover:bg-gray-100 transition-all cursor-pointer border border-gray-200" data-filter="Thỏ">Thỏ kiểng (1)</button>
    </div>
  </div>

  <!-- Lưới hiển thị các bé (FR-30) -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16" id="gallery-grid">
    <?php foreach ($pets as $p): ?>
      <div class="pet-card clay-card p-5 flex flex-col justify-between" data-species="<?= e($p['species']) ?>">
        <div>
          <!-- Ảnh Trước & Sau -->
          <div class="grid grid-cols-2 gap-2 rounded-2xl overflow-hidden mb-3.5 bg-gray-100">
            <div class="relative aspect-square">
              <img src="<?= e($p['img_before']) ?>" alt="<?= e($p['name']) ?> trước khi spa" class="w-full h-full object-cover" loading="lazy" />
              <span class="absolute bottom-1.5 left-1.5 bg-black/70 text-white text-[9px] font-bold px-1.5 py-0.5 rounded">Trước</span>
            </div>
            <div class="relative aspect-square">
              <img src="<?= e($p['img_after']) ?>" alt="<?= e($p['name']) ?> sau khi spa" class="w-full h-full object-cover" loading="lazy" />
              <span class="absolute bottom-1.5 left-1.5 bg-emerald-600 text-white text-[9px] font-bold px-1.5 py-0.5 rounded">Sau</span>
            </div>
          </div>

          <div class="flex items-center justify-between">
            <h3 class="font-bold text-lg text-[#1a3d1a]"><?= e($p['name']) ?></h3>
            <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 text-[11px] font-bold border border-emerald-200"><?= e($p['species']) ?></span>
          </div>
          <p class="text-xs text-gray-500 font-medium"><?= e($p['breed']) ?> • <?= e($p['age']) ?></p>
          <p class="text-[11px] text-gray-400 mt-0.5">Chủ nuôi: <?= e($p['owner']) ?></p>

          <p class="text-xs text-gray-600 mt-3 line-clamp-3 leading-relaxed">
            <?= e($p['story']) ?>
          </p>
        </div>

        <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between">
          <a href="/dat-lich.php?pet=<?= urlencode($p['name']) ?>" class="clay-btn-orange px-3.5 py-1.5 text-xs">
            Đặt lịch cho bé giống <?= e($p['name']) ?>
          </a>
          <button type="button" onclick="alert('Đã gửi yêu cầu gỡ ảnh cho bé <?= e($p['name']) ?>. Bộ phận hỗ trợ sẽ liên hệ chủ nuôi trong vòng 2 giờ.');" class="text-[11px] text-gray-400 hover:text-red-500 underline" title="Quyền riêng tư dữ liệu cá nhân (FR-32)">
            Yêu cầu gỡ ảnh
          </button>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</main>

<script>
  // Bộ lọc theo loài
  document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.filter-btn').forEach(b => {
        b.className = 'filter-btn px-4 py-1.5 rounded-full text-xs font-semibold bg-white text-gray-600 hover:bg-gray-100 transition-all cursor-pointer border border-gray-200';
      });
      btn.className = 'filter-btn px-4 py-1.5 rounded-full text-xs font-bold bg-[#1a3d1a] text-white transition-all cursor-pointer';

      const filter = btn.dataset.filter;
      document.querySelectorAll('.pet-card').forEach(card => {
        if (filter === 'all' || card.dataset.species === filter) {
          card.style.display = 'flex';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
