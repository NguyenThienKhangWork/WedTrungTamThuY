<?php
/**
 * PawNest & CozyPaws - Header dùng chung (Mục 5.2)
 * Chứa thẻ ngữ nghĩa HTML5, Meta Open Graph, Navbar cố định, nút Đặt lịch & Đăng nhập
 */

declare(strict_types=1);
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

// Đảm bảo encoding UTF-8 cho toàn bộ response HTML
if (!headers_sent()) {
    header('Content-Type: text/html; charset=utf-8');
}
mb_internal_encoding('UTF-8');

$page_title = $page_title ?? 'PawNest – Trung tâm thú y & spa thú cưng | BS. Nguyễn Thiện Khang';
$page_desc = $page_desc ?? 'Trung tâm khám chữa bệnh, tiêm phòng và spa thú cưng cao cấp hàng đầu tại TP. Hồ Chí Minh. Đặt lịch hẹn trực tuyến nhanh chóng.';
$active_menu = $active_menu ?? 'home';
?>
<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= e($page_title) ?></title>
  
  <!-- Meta SEO & Open Graph (Mục 3 & 5.1) -->
  <meta name="description" content="<?= e($page_desc) ?>" />
  <meta name="keywords" content="thú y, spa thú cưng, khám chó mèo, tiêm phòng thú cưng, PawNest, CozyPaws, Nguyễn Thiện Khang" />
  <meta name="author" content="Nguyễn Thiện Khang" />
  
  <meta property="og:type" content="website" />
  <meta property="og:title" content="<?= e($page_title) ?>" />
  <meta property="og:description" content="<?= e($page_desc) ?>" />
  <meta property="og:image" content="https://polo-pecan-73837341.figma.site/_assets/v11/0ae29d6d9628bede667f90d57bebe81b8f1ec2bf.svg" />
  <meta property="og:locale" content="vi_VN" />
  
  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="https://polo-pecan-73837341.figma.site/_assets/v11/0ae29d6d9628bede667f90d57bebe81b8f1ec2bf.svg" />

  <!-- Google Fonts: Baloo 2 cho tiêu đề, Nunito cho nội dung (Mục 4.3 Đặc tả) -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Nunito:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=DM+Serif+Display&display=swap" rel="stylesheet" />

  <!-- Tailwind CSS CDN cho các class tiện ích -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Nunito', 'sans-serif'],
            display: ['"Baloo 2"', 'cursive', 'sans-serif'],
            serif: ['"DM Serif Display"', 'Georgia', 'serif'],
          },
          colors: {
            brand: {
              bg: '#EFFDF0',
              cream: '#FFF1E0',
              dark: '#1a3d1a',
              hover: '#2a5a2a',
              orange: '#E86A10',
              coral: '#FF7F66',
              yellow: '#FFC94D',
              mint: '#6FD1BC'
            }
          }
        }
      }
    }
  </script>

  <!-- Lucide Icons (Biểu tượng SVG nhẹ) -->
  <script src="https://unpkg.com/lucide@latest"></script>

  <!-- CSS Thiết kế Claymorphism & Animation 3D (Mục 4.1, 4.6) -->
  <link rel="stylesheet" href="/assets/css/style.css" />
  <link rel="stylesheet" href="/assets/css/clay.css" />
</head>
<body class="bg-[#EFFDF0] text-[#1a3d1a] antialiased overflow-x-hidden m-0 p-0 selection:bg-[#E86A10] selection:text-white">

  <!-- ========================================================================= -->
  <!-- TIÊU CHÍ 1: NAVBAR CỐ ĐỊNH, LOGO, MENU ĐIỀU HƯỚNG & NÚT ĐẶT LỊCH HẸN     -->
  <!-- ========================================================================= -->
  <header class="w-full px-4 sm:px-6 md:px-8 lg:px-12 py-3.5 sticky top-0 z-40 bg-[#EFFDF0]/90 backdrop-blur-md border-b border-[#1a3d1a]/10 flex items-center justify-between">
    <!-- Logo PawNest & CozyPaws -->
    <div class="flex items-center gap-3">
      <a href="/index.php" class="block transition-transform hover:scale-102">
        <img
          src="https://polo-pecan-73837341.figma.site/_assets/v11/0ae29d6d9628bede667f90d57bebe81b8f1ec2bf.svg"
          alt="PawNest & CozyPaws"
          class="w-[125px] h-[32px] md:w-[190px] md:h-[48px] object-contain"
        />
      </a>
      <span class="hidden xl:inline-block text-[11px] font-semibold text-gray-500 border-l border-gray-300 pl-3">
        Trung tâm Thú Y & Spa Cao Cấp
      </span>
    </div>

    <!-- Center Navigation Links -->
    <nav class="hidden lg:flex items-center gap-6 xl:gap-7 text-xs font-semibold tracking-wide">
      <a href="/index.php" class="<?= $active_menu === 'home' ? 'text-[#1a3d1a] font-bold border-b-2 border-[#1a3d1a] pb-0.5' : 'text-gray-600 hover:text-[#1a3d1a]' ?> transition-colors">Trang chủ</a>
      <a href="/index.php#gioi-thieu" class="text-gray-600 hover:text-[#1a3d1a] transition-colors">Giới thiệu</a>
      <a href="/dich-vu.php" class="<?= $active_menu === 'services' ? 'text-[#1a3d1a] font-bold border-b-2 border-[#1a3d1a] pb-0.5' : 'text-gray-600 hover:text-[#1a3d1a]' ?> transition-colors">Dịch vụ</a>
      <a href="/bang-gia.php" class="<?= $active_menu === 'pricing' ? 'text-[#1a3d1a] font-bold border-b-2 border-[#1a3d1a] pb-0.5' : 'text-gray-600 hover:text-[#1a3d1a]' ?> transition-colors">Bảng giá</a>
      <a href="/cua-hang.php" class="<?= $active_menu === 'shop' ? 'text-[#1a3d1a] font-bold border-b-2 border-[#1a3d1a] pb-0.5' : 'text-emerald-800 font-bold hover:text-[#1a3d1a]' ?> transition-colors">🏪 Cửa hàng</a>
      <a href="/index.php#ky-nang" class="<?= $active_menu === 'skills' ? 'text-[#1a3d1a] font-bold border-b-2 border-[#1a3d1a] pb-0.5' : 'text-gray-600 hover:text-[#1a3d1a]' ?> transition-colors">Kỹ năng</a>
      <a href="/thu-vien.php" class="<?= $active_menu === 'gallery' ? 'text-[#1a3d1a] font-bold border-b-2 border-[#1a3d1a] pb-0.5' : 'text-gray-600 hover:text-[#1a3d1a]' ?> transition-colors">Bé cưng</a>
      <a href="/danh-gia.php" class="<?= $active_menu === 'reviews' ? 'text-[#1a3d1a] font-bold border-b-2 border-[#1a3d1a] pb-0.5' : 'text-gray-600 hover:text-[#1a3d1a]' ?> transition-colors">Đánh giá</a>
      <a href="/lien-he.php" class="<?= $active_menu === 'contact' ? 'text-[#1a3d1a] font-bold border-b-2 border-[#1a3d1a] pb-0.5' : 'text-gray-600 hover:text-[#1a3d1a]' ?> transition-colors">Liên hệ</a>
    </nav>

    <!-- Right Actions -->
    <div class="flex items-center gap-2 sm:gap-3">
      <!-- Nút Đăng nhập / Tài khoản Khách hàng -->
      <button
        id="btn-auth-modal"
        type="button"
        class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold text-[#1a3d1a] bg-white/80 hover:bg-white border border-[#1a3d1a]/15 shadow-2xs transition-all cursor-pointer"
        title="Tài khoản khách hàng"
      >
        <i data-lucide="user" class="w-3.5 h-3.5"></i>
        <span id="nav-user-label">Đăng nhập</span>
      </button>

      <!-- Nút Đặt lịch hẹn cố định (FR-02) -->
      <a
        href="/dat-lich.php"
        class="bg-[#E86A10] hover:bg-[#d45e0d] text-white px-3.5 sm:px-4 py-1.5 sm:py-2 rounded-full text-xs font-bold shadow-sm hover:shadow transition-all flex items-center gap-1.5"
      >
        <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
        <span>Đặt lịch</span>
      </a>

      <!-- Favorites button (badge 4) -->
      <a href="/thu-vien.php" class="relative w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-[#E86A10] shadow-2xs" title="4 bé cưng yêu thích">
        <i data-lucide="heart" class="w-3.5 h-3.5 fill-[#E86A10]"></i>
        <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-[#E86A10] text-white text-[9px] font-bold flex items-center justify-center">4</span>
      </a>

      <!-- Admin dashboard link -->
      <a href="/admin/dashboard.php" class="text-gray-500 hover:text-[#1a3d1a] p-1.5 rounded-full hover:bg-white transition-colors" title="Trang Quản trị Nội bộ">
        <i data-lucide="shield-check" class="w-4 h-4"></i>
      </a>

      <!-- Avatar Bác sĩ phụ trách Nguyễn Thiện Khang -->
      <div class="w-8 h-8 rounded-full overflow-hidden border border-[#1a3d1a]/20 bg-amber-100 shrink-0" title="Bác sĩ Phụ trách: Nguyễn Thiện Khang">
        <img
          src="https://polo-pecan-73837341.figma.site/_assets/v11/e62173d41f91350a59628e8a9a55ae078a886fb9.png?w=128"
          alt="Nguyễn Thiện Khang"
          class="w-full h-full object-cover"
        />
      </div>
    </div>
  </header>
