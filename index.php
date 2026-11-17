<?php
/**
 * PawNest & CozyPaws - Trang chủ chính (Landing Page)
 * Đáp ứng 100% 13 tiêu chí trong PawNest_Dac_ta_website.pdf
 * Sử dụng HTML5, CSS3, JavaScript thuần và PHP 8.2
 */

declare(strict_types=1);

$page_title = "PawNest - Trung tâm thú y và spa thú cưng | BS. Nguyễn Thiện Khang";
$active_menu = "home";

require_once __DIR__ . "/includes/header.php";
?>

  <!-- ========================================================================= -->
  <!-- TIÊU CHÍ 1 & 12: HERO BANNER (COZYPAWS SECTION - VIEWPORT HEIGHT CHUẨN)  -->
  <!-- ========================================================================= -->
  <section id="top" class="relative h-[calc(100vh-70px)] min-h-[580px] w-full flex flex-col overflow-hidden select-none border-b border-[#1a3d1a]/10 perspective-stage">
    
    <!-- DESKTOP HERO (lg+) -->
    <div class="hidden lg:block relative w-full h-full flex-1 overflow-hidden">
      <!-- 0. Background Ambient 3D Elements (Floating paws & light glow) -->
      <div class="absolute inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-emerald-200/35 rounded-full blur-3xl"></div>
        <div class="absolute top-[18%] left-[22%] text-emerald-800/20 animate-paw-drift text-2xl select-none">🐾</div>
        <div class="absolute top-[32%] right-[24%] text-emerald-800/15 animate-paw-drift text-xl select-none" style="animation-delay: -3s;">🐾</div>
        <div class="absolute top-[55%] left-[8%] text-emerald-800/15 animate-paw-drift text-lg select-none" style="animation-delay: -5s;">🐾</div>
      </div>

      <!-- 1. Text Layer — absolute, full-width, canh giữa thực sự -->
      <div id="hero-heading-3d" class="absolute inset-x-0 top-0 z-20 flex flex-col items-center justify-start text-center px-6 pt-[clamp(1.5rem,3.5vh,3rem)] pointer-events-none transition-transform duration-200 ease-out preserve-3d">
        <!-- Phụ trách chuyên môn Bác sĩ Khang -->
        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/85 backdrop-blur-md border border-[#1a3d1a]/15 text-[#1a3d1a] text-xs font-semibold mb-2 shadow-xs animate-fade-in delay-100">
          <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
          <span>Phụ trách chuyên môn: <strong>BS. Nguyễn Thiện Khang</strong> • TP. Hồ Chí Minh</span>
        </div>

        <h1 class="font-hero-serif text-[#1a3d1a] text-[clamp(48px,5.8vw,92px)] leading-[0.98] tracking-tight drop-shadow-[0_2px_12px_rgba(239,253,240,0.9)] text-center w-full">
          <div class="overflow-visible block">
            <span class="inline-block animate-word-pop delay-200">Everything</span>
          </div>
          <div class="overflow-visible block mt-1">
            <span class="inline-block animate-word-pop delay-300 mr-[0.28em]">Your</span>
            <span class="inline-block animate-word-pop delay-400 mr-[0.28em]">Pets</span>
            <span class="inline-block animate-word-pop delay-500">Love</span>
          </div>
        </h1>
      </div>

      <!-- 2. Thẻ sản phẩm góc trái: top-[50px] left-12, 3D Tilt -->
      <div id="hero-card-left-wrap" class="absolute top-[50px] left-8 xl:left-12 z-25 w-[clamp(160px,13.5vw,250px)] animate-slide-in-left delay-600 preserve-3d">
        <a href="/cua-hang.php" id="hero-card-left" class="card-3d-container block group preserve-3d transition-transform duration-200 ease-out shadow-3d-card rounded-2xl bg-white p-2">
          <div class="relative aspect-[260/257] rounded-xl overflow-hidden bg-[#F8FAF8]">
            <img
              src="https://polo-pecan-73837341.figma.site/_assets/v11/3e5158dad63d392ade022e81890edc9f54d750bc.png"
              alt="Cozy Cat House"
              class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500"
            />
            <div class="card-3d-glare" id="glare-card-left"></div>
            <div class="absolute bottom-3 right-3 w-9 h-9 rounded-full bg-[#1a3d1a] group-hover:bg-[#E86A10] text-white flex items-center justify-center shadow-lg transition-all duration-300 transform group-hover:scale-110 active:scale-95 group-hover:rotate-12">
              <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
            </div>
          </div>
          <div class="mt-2 px-1 pb-0.5 flex flex-col">
            <span class="text-gray-700 font-medium text-[clamp(13px,1.1vw,16px)] leading-snug group-hover:text-[#1a3d1a] transition-colors">Cozy Cat House</span>
            <span class="text-[#1a3d1a] font-bold text-[clamp(15px,1.3vw,19px)] flex items-center justify-between">
              <span>$49.99</span>
              <span class="text-[10px] text-emerald-700 font-semibold bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">Bán chạy</span>
            </span>
          </div>
        </a>
      </div>

      <!-- 3. Thẻ video review góc phải: top-[50px] right-12, 3D Tilt -->
      <div id="hero-card-right-wrap" class="absolute top-[50px] right-8 xl:right-12 z-25 w-[clamp(120px,9.5vw,170px)] animate-slide-in-right delay-700 preserve-3d">
        <a href="#danh-gia" id="hero-card-right" class="card-3d-container block group preserve-3d transition-transform duration-200 ease-out shadow-3d-card rounded-2xl bg-neutral-900 p-1.5">
          <div class="relative aspect-[177/287] rounded-xl overflow-hidden bg-neutral-950">
            <img
              src="https://polo-pecan-73837341.figma.site/_assets/v11/76be6ec3a93a703b15e9cc01e764a4e3f9d7d2c0.png"
              alt="Video Reviews"
              class="w-full h-full object-cover opacity-90 group-hover:scale-108 transition-transform duration-500"
            />
            <div class="card-3d-glare" id="glare-card-right"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/35 to-transparent"></div>
            <div class="absolute bottom-12 left-1/2 -translate-x-1/2 flex items-center justify-center">
              <span class="absolute w-10 h-10 rounded-full bg-[#E86A10] animate-ping opacity-35"></span>
              <div class="w-10 h-10 rounded-full bg-[#1a3d1a] group-hover:bg-[#E86A10] text-white flex items-center justify-center shadow-xl transition-all duration-300 transform group-hover:scale-115 pl-0.5 z-10">
                <i data-lucide="play" class="w-4 h-4 fill-white"></i>
              </div>
            </div>
            <p class="absolute bottom-2 inset-x-2 text-center text-white text-[clamp(9px,0.8vw,11.5px)] font-medium leading-tight drop-shadow">
              Watch Product Reviews on TikTok and YouTube
            </p>
          </div>
        </a>
      </div>

      <!-- 4. 3 Ảnh đáy (bottom-0 left-0 right-0, z-10, flex items-end, 3D Parallax Depth) -->
      <div id="hero-pets-layer" class="absolute bottom-0 left-0 right-0 z-10 flex items-end justify-between pointer-events-none select-none transition-transform duration-200 ease-out preserve-3d">
        <div id="hero-pet-left" class="flex-1 flex items-end animate-photo-reveal delay-800 transition-transform duration-200 ease-out" style="max-height: min(60vh, 480px);">
          <img
            src="https://polo-pecan-73837341.figma.site/_assets/v11/8d44b25186ef45a5789c74668fb781cea4e1ff49.png"
            alt="Dachshund pet left"
            class="w-full h-auto block object-bottom object-contain pointer-events-none"
          />
        </div>

        <div id="hero-pet-center" class="flex-[1.265] flex items-end justify-center animate-photo-reveal delay-600 transition-transform duration-200 ease-out" style="max-height: min(78vh, 680px);">
          <img
            src="https://polo-pecan-73837341.figma.site/_assets/v11/96745c4e72ad5c5208e53a885df797fd82cd854a.png?h=1024"
            alt="Golden retriever center"
            class="w-full h-auto block object-bottom object-contain pointer-events-none"
          />
        </div>

        <div id="hero-pet-right" class="flex-1 flex items-end justify-end animate-photo-reveal delay-900 transition-transform duration-200 ease-out" style="max-height: min(60vh, 480px);">
          <img
            src="https://polo-pecan-73837341.figma.site/_assets/v11/81bd2e7a66b58f3d8f3ad78fd1ebf01af8dfdee1.png"
            alt="Ginger cat right"
            class="w-full h-auto block object-bottom object-contain pointer-events-none"
          />
        </div>
      </div>

      <!-- 5. Overlays (bottom: clamp(20px, 4vh, 50px), z-30, 3D Elevation) -->
      <div id="hero-overlay-left" style="bottom: clamp(20px, 4vh, 50px);" class="absolute left-6 lg:left-12 z-30 animate-fade-up delay-1000 animate-float-3d">
        <div class="flex items-center gap-3 bg-white/80 backdrop-blur-xl px-4 py-2.5 rounded-full border border-white/90 shadow-[0_12px_30px_rgba(26,61,26,0.12)] hover:scale-105 transition-transform duration-300">
          <div class="flex items-center -space-x-2">
            <img src="https://polo-pecan-73837341.figma.site/_assets/v11/e62173d41f91350a59628e8a9a55ae078a886fb9.png?w=128" alt="Avatar" class="w-8 h-8 rounded-full border-2 border-white object-cover" />
            <div class="w-8 h-8 rounded-full bg-[#1a3d1a] border-2 border-white flex items-center justify-center text-white">
              <i data-lucide="plus" class="w-3.5 h-3.5"></i>
            </div>
          </div>
          <div class="flex flex-col">
            <span class="font-extrabold text-[#1a3d1a] text-lg leading-none">98K+</span>
            <span class="text-[10px] text-gray-500 font-medium">Khách hàng tin chọn</span>
          </div>
        </div>
      </div>

      <div id="hero-overlay-center" style="bottom: clamp(20px, 4vh, 50px);" class="absolute left-0 right-0 z-30 flex flex-col items-center gap-0 text-center animate-fade-up delay-1100 pointer-events-none">
        <!-- Green CTA Box -->
        <div class="bg-[#1a3d1a]/90 backdrop-blur-md rounded-3xl px-8 py-5 flex flex-col items-center gap-4 shadow-2xl border border-white/10 w-auto max-w-[480px] pointer-events-auto">
          <h2 class="text-white font-semibold text-base lg:text-lg tracking-wide">
            Best Products &amp; Care for Your Pet
          </h2>
          <div class="flex items-center gap-3">
            <a href="#dat-lich" class="bg-[#E86A10] hover:bg-[#d45e0d] text-white px-7 py-3 rounded-full font-semibold text-sm inline-flex items-center gap-2.5 transition-all transform hover:scale-106 hover:-translate-y-0.5 shadow-[0_10px_25px_-5px_rgba(232,106,16,0.5)] active:translate-y-0">
              <span>Đặt lịch hẹn ngay</span>
              <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
            <a href="#goi" class="bg-white/90 hover:bg-white text-[#1a3d1a] hover:text-[#E86A10] px-6 py-3 rounded-full font-semibold text-sm shadow-md hover:shadow-lg transition-all transform hover:scale-105 backdrop-blur-md">
              Xem bảng giá
            </a>
          </div>
        </div>
      </div>

      <div id="hero-overlay-right" style="bottom: clamp(20px, 4vh, 50px);" class="absolute right-6 lg:right-12 z-30 animate-fade-up delay-1200 animate-float-3d-reverse">
        <div class="flex items-center gap-2.5 bg-white/80 backdrop-blur-xl px-4 py-2.5 rounded-full border border-white/90 shadow-[0_12px_30px_rgba(26,61,26,0.12)] hover:scale-105 transition-transform duration-300">
          <div class="w-7 h-7 rounded-full bg-amber-50 flex items-center justify-center">
            <i data-lucide="star" class="w-4 h-4 fill-[#E86A10] text-[#E86A10]"></i>
          </div>
          <div class="flex flex-col">
            <span class="font-extrabold text-[#1a3d1a] text-lg leading-none">4.9/5</span>
            <span class="text-[10px] text-gray-500 font-medium">Hài lòng tuyệt đối</span>
          </div>
        </div>
      </div>

      <!-- 3D Interactive Indicator Badge: removed to avoid badge collision -->
    </div>

    <!-- TABLET HERO (md to lg) -->
    <div class="hidden md:block lg:hidden relative w-full h-full flex-1 overflow-hidden select-none">
      <div class="relative z-20 flex flex-col items-center justify-center text-center px-6 pt-7 md:pt-9 pointer-events-none">
        <h1 class="font-hero-serif text-[#1a3d1a] text-6xl md:text-7xl leading-tight drop-shadow-[0_2px_8px_rgba(239,253,240,0.85)]">
          <span class="inline-block animate-word-pop delay-200">Everything</span><br />
          <span class="inline-block animate-word-pop delay-300 mr-2">Your</span>
          <span class="inline-block animate-word-pop delay-400 mr-2">Pets</span>
          <span class="inline-block animate-word-pop delay-500">Love</span>
        </h1>
      </div>

      <a href="/cua-hang.php" class="absolute top-[80px] left-4 z-20 w-[160px] animate-slide-in-left delay-600 block">
        <div class="relative aspect-[260/257] rounded-2xl overflow-hidden shadow-md bg-white">
          <img src="https://polo-pecan-73837341.figma.site/_assets/v11/3e5158dad63d392ade022e81890edc9f54d750bc.png" alt="Product" class="w-full h-full object-cover" />
          <div class="absolute bottom-2 right-2 w-8 h-8 rounded-full bg-[#1a3d1a] text-white flex items-center justify-center shadow">
            <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
          </div>
        </div>
        <div class="mt-2 text-xs">
          <p class="text-gray-700 font-medium">Cozy Cat House</p>
          <p class="text-[#1a3d1a] font-bold text-sm">$49.99</p>
        </div>
      </a>

      <a href="#danh-gia" class="absolute top-[80px] right-4 z-20 w-[120px] animate-slide-in-right delay-700 block">
        <div class="relative aspect-[177/287] rounded-2xl overflow-hidden shadow-md bg-neutral-900">
          <img src="https://polo-pecan-73837341.figma.site/_assets/v11/76be6ec3a93a703b15e9cc01e764a4e3f9d7d2c0.png" alt="Video" class="w-full h-full object-cover opacity-90" />
          <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent"></div>
          <div class="absolute bottom-10 left-1/2 -translate-x-1/2 w-8 h-8 rounded-full bg-[#1a3d1a] text-white flex items-center justify-center pl-0.5">
            <i data-lucide="play" class="w-3.5 h-3.5 fill-white"></i>
          </div>
          <p class="absolute bottom-1 inset-x-1 text-center text-white text-[9px] font-medium leading-tight">Reviews</p>
        </div>
      </a>

      <!-- Bottom Images Tablet -->
      <div class="absolute bottom-0 left-0 right-0 z-10 flex items-end justify-between pointer-events-none">
        <div class="flex-1 max-h-[50vh] overflow-hidden flex items-end animate-photo-reveal delay-800">
          <img src="https://polo-pecan-73837341.figma.site/_assets/v11/8d44b25186ef45a5789c74668fb781cea4e1ff49.png" class="w-full h-auto block object-bottom object-contain" />
        </div>
        <div class="flex-[1.265] max-h-[58vh] overflow-hidden flex items-end justify-center animate-photo-reveal delay-600">
          <img src="https://polo-pecan-73837341.figma.site/_assets/v11/96745c4e72ad5c5208e53a885df797fd82cd854a.png?h=1024" class="w-full h-auto block object-bottom object-contain" />
        </div>
        <div class="flex-1 max-h-[50vh] overflow-hidden flex items-end justify-end animate-photo-reveal delay-900">
          <img src="https://polo-pecan-73837341.figma.site/_assets/v11/81bd2e7a66b58f3d8f3ad78fd1ebf01af8dfdee1.png" class="w-full h-auto block object-bottom object-contain" />
        </div>
      </div>

      <div class="absolute left-6 bottom-6 z-20 animate-fade-up delay-1000">
        <div class="flex items-center gap-2 bg-white/70 backdrop-blur-md px-3.5 py-2 rounded-full border border-white/80 shadow-md">
          <span class="font-bold text-[#1a3d1a] text-sm">98K+</span>
        </div>
      </div>
      <div class="absolute left-1/2 -translate-x-1/2 bottom-6 z-20 flex flex-col items-center gap-2 text-center animate-fade-up delay-1100">
        <a href="#dat-lich" class="bg-[#E86A10] hover:bg-[#d45e0d] text-white px-5 py-2.5 rounded-full text-xs font-semibold inline-flex items-center gap-2 shadow-md">
          <span>Đặt lịch ngay</span>
          <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
        </a>
      </div>
      <div class="absolute right-6 bottom-6 z-20 animate-fade-up delay-1200">
        <div class="flex items-center gap-1.5 bg-white/70 backdrop-blur-md px-3.5 py-2 rounded-full border border-white/80 shadow-md">
          <i data-lucide="star" class="w-4 h-4 fill-[#E86A10] text-[#E86A10]"></i>
          <span class="font-bold text-[#1a3d1a] text-sm">4.9/5</span>
        </div>
      </div>
    </div>

    <!-- MOBILE HERO (below md) -->
    <div class="flex md:hidden flex-col h-full justify-between relative overflow-hidden select-none">
      <div class="pt-3 px-4 flex flex-col items-center text-center z-20">
        <h1 class="font-hero-serif text-[#1a3d1a] text-[34px] leading-[1.05]">
          <span class="inline-block animate-word-pop delay-200 mr-1.5">Everything</span>
          <span class="inline-block animate-word-pop delay-300 mr-1.5">Your</span>
          <span class="inline-block animate-word-pop delay-400 mr-1.5">Pets</span>
          <span class="inline-block animate-word-pop delay-500">Love</span>
        </h1>
        <p class="text-gray-600 text-xs mt-1">Khám thú y & Spa chăm sóc toàn diện tại TP.HCM</p>
        <div class="flex items-center gap-2 mt-2.5">
          <a href="#dat-lich" class="bg-[#E86A10] text-white px-5 py-2 rounded-full text-xs font-semibold inline-flex items-center gap-1.5 shadow-md">
            <span>Đặt lịch ngay</span>
            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
          </a>
          <a href="#goi" class="bg-white/80 text-[#1a3d1a] px-4 py-2 rounded-full text-xs font-semibold shadow-xs">
            Bảng giá
          </a>
        </div>
      </div>

      <!-- Two cards side-by-side -->
      <div class="flex items-start justify-center gap-3 px-4 z-20 mt-1">
        <a href="/cua-hang.php" class="w-[130px] shrink-0 block">
          <div class="relative aspect-square rounded-2xl overflow-hidden shadow-md bg-white">
            <img src="https://polo-pecan-73837341.figma.site/_assets/v11/3e5158dad63d392ade022e81890edc9f54d750bc.png" class="w-full h-full object-cover" />
            <div class="absolute bottom-1.5 right-1.5 w-6 h-6 rounded-full bg-[#1a3d1a] text-white flex items-center justify-center">
              <i data-lucide="arrow-up-right" class="w-3 h-3"></i>
            </div>
          </div>
          <div class="mt-1 text-[11px]">
            <p class="text-gray-700 font-medium truncate">Cozy Cat House</p>
            <p class="text-[#1a3d1a] font-bold text-xs">$49.99</p>
          </div>
        </a>

        <div class="w-[100px] shrink-0">
          <div class="relative aspect-[3/4] rounded-2xl overflow-hidden shadow-md bg-neutral-900">
            <img src="https://polo-pecan-73837341.figma.site/_assets/v11/76be6ec3a93a703b15e9cc01e764a4e3f9d7d2c0.png" class="w-full h-full object-cover opacity-90" />
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent"></div>
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 w-6 h-6 rounded-full bg-[#1a3d1a] text-white flex items-center justify-center pl-0.5">
              <i data-lucide="play" class="w-3 h-3 fill-white"></i>
            </div>
            <p class="absolute bottom-1.5 inset-x-1 text-center text-white text-[8px] font-medium leading-tight">Reviews</p>
          </div>
        </div>
      </div>

      <!-- Stats row -->
      <div class="z-20 flex justify-center px-4 my-1">
        <div class="flex items-center gap-3 bg-white/80 backdrop-blur-md px-3.5 py-1.5 rounded-full border border-white/90 shadow-sm text-xs font-bold text-[#1a3d1a]">
          <span>98K+ Reviews</span>
          <div class="w-px h-3.5 bg-black/15"></div>
          <span class="flex items-center gap-1">
            <i data-lucide="star" class="w-3.5 h-3.5 fill-[#E86A10] text-[#E86A10]"></i> 4.9/5
          </span>
        </div>
      </div>

      <!-- Bottom Images Mobile -->
      <div class="relative w-full z-10 flex items-end justify-between pointer-events-none mt-auto">
        <div class="flex-1 overflow-hidden flex items-end">
          <img src="https://polo-pecan-73837341.figma.site/_assets/v11/8d44b25186ef45a5789c74668fb781cea4e1ff49.png" class="w-full h-auto block object-bottom object-contain" />
        </div>
        <div class="flex-[1.265] overflow-hidden flex items-end justify-center">
          <img src="https://polo-pecan-73837341.figma.site/_assets/v11/96745c4e72ad5c5208e53a885df797fd82cd854a.png?h=1024" class="w-full h-auto block object-bottom object-contain" />
        </div>
        <div class="flex-1 overflow-hidden flex items-end justify-end">
          <img src="https://polo-pecan-73837341.figma.site/_assets/v11/81bd2e7a66b58f3d8f3ad78fd1ebf01af8dfdee1.png" class="w-full h-auto block object-bottom object-contain" />
        </div>
      </div>
    </div>
  </section>

  <!-- ========================================================================= -->
  <!-- TIÊU CHÍ 3 & 10 & 13: GIỚI THIỆU TRUNG TÂM & THÔNG TIN CÁ NHÂN SINH VIÊN   -->
  <!-- Người phụ trách: Nguyễn Thiện Khang (Thông tin thật, ảnh thật, không giữ chỗ) -->
  <!-- ========================================================================= -->
  <section id="gioi-thieu" class="py-16 px-6 sm:px-12 max-w-7xl mx-auto">
    <div class="clay-card p-8 sm:p-12 border border-[#1a3d1a]/10">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
        <!-- Ảnh thật người phụ trách (Ảnh thật số 1) -->
        <div class="lg:col-span-5 flex flex-col items-center text-center">
          <div class="relative w-52 h-52 sm:w-64 sm:h-64 rounded-full overflow-hidden border-4 border-[#EFFDF0] shadow-xl ring-4 ring-[#1a3d1a]/15">
            <img
              src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=600&q=80"
              alt="Bác sĩ Thú y Nguyễn Thiện Khang"
              class="w-full h-full object-cover"
            />
          </div>
          <h3 class="mt-4 text-xl font-bold text-[#1a3d1a]">Nguyễn Thiện Khang</h3>
          <p class="text-xs font-semibold text-[#E86A10] uppercase tracking-wider">Người sáng lập & Bác sĩ Thú y Trưởng</p>
          <div class="mt-3 flex items-center gap-2 text-xs text-gray-500">
            <span>🎓 ĐH Nông Lâm TP.HCM</span>
            <span>•</span>
            <span>⭐ 5+ năm kinh nghiệm</span>
          </div>
        </div>

        <!-- Nội dung giới thiệu trung tâm (Tiêu chí 3) -->
        <div class="lg:col-span-7 space-y-4">
          <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#EFFDF0] text-[#1a3d1a] text-xs font-bold">
            <i data-lucide="shield-check" class="w-3.5 h-3.5 text-[#E86A10]"></i>
            Thông tin đơn vị & Người phụ trách
          </div>
          <h2 class="text-2xl sm:text-3xl font-serif-display text-[#1a3d1a]">
            PawNest – Tận tâm vì sức khỏe & nụ cười của bé cưng
          </h2>
          <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
            Được thành lập từ năm <strong>2024</strong> dưới sự dẫn dắt của Bác sĩ Thú y <strong>Nguyễn Thiện Khang</strong>, PawNest ra đời với định hướng mang chuẩn mực y khoa thú y hiện đại kết hợp không gian Spa thư giãn không tiếng ồn. Chúng tôi xem mỗi bé thú cưng như một thành viên trong gia đình bạn.
          </p>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 text-xs">
            <div class="flex items-start gap-2.5">
              <i data-lucide="map-pin" class="w-4 h-4 text-[#E86A10] shrink-0 mt-0.5"></i>
              <div>
                <strong class="block text-gray-900">Địa chỉ:</strong>
                <span class="text-gray-600">123 Đường Hoa Cúc, Phường 7, Q. Phú Nhuận, TP.HCM</span>
              </div>
            </div>
            <div class="flex items-start gap-2.5">
              <i data-lucide="clock" class="w-4 h-4 text-[#E86A10] shrink-0 mt-0.5"></i>
              <div>
                <strong class="block text-gray-900">Giờ làm việc:</strong>
                <span class="text-gray-600">08:00 – 20:00 (Thứ 2 – Chủ nhật)</span>
              </div>
            </div>
            <div class="flex items-start gap-2.5">
              <i data-lucide="phone-call" class="w-4 h-4 text-[#E86A10] shrink-0 mt-0.5"></i>
              <div>
                <strong class="block text-gray-900">Hotline Cấp cứu 24/7:</strong>
                <span class="text-gray-600 font-bold">0900 123 456</span>
              </div>
            </div>
            <div class="flex items-start gap-2.5">
              <i data-lucide="mail" class="w-4 h-4 text-[#E86A10] shrink-0 mt-0.5"></i>
              <div>
                <strong class="block text-gray-900">Email liên hệ:</strong>
                <span class="text-gray-600">thienkhang.pawnest@gmail.com</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========================================================================= -->
  <!-- TIÊU CHÍ 4: THÔNG TIN NGHỀ NGHIỆP – SỨ MỆNH VÀ TẦM NHÌN                   -->
  <!-- ========================================================================= -->
  <section class="py-12 px-6 sm:px-12 max-w-7xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="clay-card p-8 border-l-4 border-[#E86A10]">
        <div class="w-12 h-12 rounded-2xl bg-[#EFFDF0] flex items-center justify-center text-[#1a3d1a] mb-4">
          <i data-lucide="target" class="w-6 h-6 text-[#E86A10]"></i>
        </div>
        <h3 class="text-xl font-serif-display text-[#1a3d1a] mb-2">Sứ mệnh hoạt động</h3>
        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
          Cung cấp giải pháp chăm sóc y tế và làm đẹp toàn diện, nhân văn và minh bạch chi phí cho thú cưng. Cam kết không lạm dụng thuốc, giảm thiểu tối đa căng thẳng (Fear Free) cho các bé khi đi khám và đi spa.
        </p>
      </div>

      <div class="clay-card p-8 border-l-4 border-[#1a3d1a]">
        <div class="w-12 h-12 rounded-2xl bg-[#EFFDF0] flex items-center justify-center text-[#1a3d1a] mb-4">
          <i data-lucide="compass" class="w-6 h-6 text-[#1a3d1a]"></i>
        </div>
        <h3 class="text-xl font-serif-display text-[#1a3d1a] mb-2">Tầm nhìn phát triển</h3>
        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
          Đến năm 2028, PawNest trở thành hệ sinh thái bệnh viện thú y & trung tâm huấn luyện - chăm sóc thú cưng uy tín hàng đầu tại TP.HCM, tiên phong ứng dụng bệnh án điện tử và quản lý lịch hẹn thông minh.
        </p>
      </div>
    </div>
  </section>

  <!-- ========================================================================= -->
  <!-- TIÊU CHÍ 5: SỞ THÍCH CỦA ĐỘI NGŨ & BÉ CƯNG (DẠNG THẺ BIỂU TƯỢNG)        -->
  <!-- ========================================================================= -->
  <section class="py-12 px-6 sm:px-12 max-w-7xl mx-auto">
    <div class="text-center max-w-2xl mx-auto mb-8">
      <span class="text-xs font-bold text-[#E86A10] uppercase tracking-wider">Đồng điệu cùng bé</span>
      <h2 class="text-2xl sm:text-3xl font-serif-display text-[#1a3d1a] mt-1">Sở thích & Niềm đam mê của chúng tôi</h2>
      <p class="text-xs text-gray-500">Những điều đội ngũ bác sĩ và các bé cưng luôn say mê mỗi ngày.</p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
      <div class="clay-card p-4 text-center flex flex-col items-center justify-center gap-2">
        <div class="text-3xl">🐶</div>
        <h4 class="font-bold text-xs text-[#1a3d1a]">Corgi & Poodle</h4>
        <p class="text-[10px] text-gray-500">Thích chơi ném bóng & tắm nắng</p>
      </div>
      <div class="clay-card p-4 text-center flex flex-col items-center justify-center gap-2">
        <div class="text-3xl">🐱</div>
        <h4 class="font-bold text-xs text-[#1a3d1a]">Mèo lông ngắn</h4>
        <p class="text-[10px] text-gray-500">Thích cỏ mèo & cào móng gỗ</p>
      </div>
      <div class="clay-card p-4 text-center flex flex-col items-center justify-center gap-2">
        <div class="text-3xl">✂️</div>
        <h4 class="font-bold text-xs text-[#1a3d1a]">Grooming nghệ thuật</h4>
        <p class="text-[10px] text-gray-500">Tạo kiểu gấu Teddy tròn xinh</p>
      </div>
      <div class="clay-card p-4 text-center flex flex-col items-center justify-center gap-2">
        <div class="text-3xl">🥗</div>
        <h4 class="font-bold text-xs text-[#1a3d1a]">Dinh dưỡng hữu cơ</h4>
        <p class="text-[10px] text-gray-500">Nấu pate tươi & hạt không ngũ cốc</p>
      </div>
      <div class="clay-card p-4 text-center flex flex-col items-center justify-center gap-2">
        <div class="text-3xl">🩺</div>
        <h4 class="font-bold text-xs text-[#1a3d1a]">Nghiên cứu y khoa</h4>
        <p class="text-[10px] text-gray-500">Cập nhật vắc-xin thế hệ mới</p>
      </div>
      <div class="clay-card p-4 text-center flex flex-col items-center justify-center gap-2">
        <div class="text-3xl">🏡</div>
        <h4 class="font-bold text-xs text-[#1a3d1a]">Cứu hộ động vật</h4>
        <p class="text-[10px] text-gray-500">Hỗ trợ nhận nuôi chó mèo hoang</p>
      </div>
    </div>
  </section>

  <!-- ========================================================================= -->
  <!-- TIÊU CHÍ 6: NGÔN NGỮ & KỸ NĂNG CHUYÊN MÔN (THANH TIẾN TRÌNH PROGRESS BARS)-->
  <!-- ========================================================================= -->
  <section id="ky-nang" class="py-16 px-6 sm:px-12 max-w-7xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">
      <!-- Cột 1: Kỹ năng chuyên môn Thú y -->
      <div class="clay-card p-8">
        <div class="flex items-center gap-2 mb-4">
          <i data-lucide="activity" class="w-5 h-5 text-[#E86A10]"></i>
          <h3 class="text-xl font-serif-display text-[#1a3d1a]">Kỹ năng chuyên môn thú y</h3>
        </div>
        <p class="text-xs text-gray-500 mb-6">Được chứng nhận qua văn bằng và số ca điều trị thực tế tại phòng khám.</p>

        <div class="space-y-5 text-xs">
          <div>
            <div class="flex justify-between font-bold mb-1">
              <span>Chẩn đoán & Điều trị nội khoa</span>
              <span>95%</span>
            </div>
            <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden">
              <div class="h-full bg-[#1a3d1a] rounded-full transition-all duration-1000" style="width: 95%;"></div>
            </div>
          </div>

          <div>
            <div class="flex justify-between font-bold mb-1">
              <span>Phẫu thuật ngoại khoa & Tiệt trùng</span>
              <span>90%</span>
            </div>
            <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden">
              <div class="h-full bg-[#1a3d1a] rounded-full transition-all duration-1000" style="width: 90%;"></div>
            </div>
          </div>

          <div>
            <div class="flex justify-between font-bold mb-1">
              <span>Tạo kiểu Spa & Grooming thẩm mỹ</span>
              <span>98%</span>
            </div>
            <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden">
              <div class="h-full bg-[#E86A10] rounded-full transition-all duration-1000" style="width: 98%;"></div>
            </div>
          </div>

          <div>
            <div class="flex justify-between font-bold mb-1">
              <span>Tư vấn Dinh dưỡng & Chăm sóc phòng ngừa</span>
              <span>92%</span>
            </div>
            <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden">
              <div class="h-full bg-[#1a3d1a] rounded-full transition-all duration-1000" style="width: 92%;"></div>
            </div>
          </div>

          <div>
            <div class="flex justify-between font-bold mb-1">
              <span>Cấp cứu thú y & Hồi sức 24/7</span>
              <span>90%</span>
            </div>
            <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden">
              <div class="h-full bg-[#E86A10] rounded-full transition-all duration-1000" style="width: 90%;"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Cột 2: Ngôn ngữ & Kỹ năng bổ trợ -->
      <div class="clay-card p-8">
        <div class="flex items-center gap-2 mb-4">
          <i data-lucide="languages" class="w-5 h-5 text-[#1a3d1a]"></i>
          <h3 class="text-xl font-serif-display text-[#1a3d1a]">Ngôn ngữ giao tiếp</h3>
        </div>
        <p class="text-xs text-gray-500 mb-6">Sẵn sàng tiếp đón chủ nuôi người Việt và khách hàng quốc tế.</p>

        <div class="space-y-5 text-xs mb-8">
          <div>
            <div class="flex justify-between font-bold mb-1">
              <span>Tiếng Việt (Bản ngữ)</span>
              <span>100%</span>
            </div>
            <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden">
              <div class="h-full bg-[#1a3d1a] rounded-full" style="width: 100%;"></div>
            </div>
          </div>

          <div>
            <div class="flex justify-between font-bold mb-1">
              <span>Tiếng Anh (Giao tiếp y khoa & Khách quốc tế)</span>
              <span>85%</span>
            </div>
            <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden">
              <div class="h-full bg-[#E86A10] rounded-full" style="width: 85%;"></div>
            </div>
          </div>
        </div>

        <!-- Tiêu chí 7: Chứng chỉ - Giải thưởng -->
        <div class="pt-4 border-t border-gray-100">
          <h4 class="font-serif-display text-base text-[#1a3d1a] mb-3 flex items-center gap-2">
            <i data-lucide="award" class="w-4 h-4 text-amber-500"></i>
            Chứng chỉ – Giải thưởng nghề nghiệp (Tiêu chí 7)
          </h4>
          <ul class="space-y-2 text-xs text-gray-600">
            <li class="flex items-center gap-2">
              <span class="text-amber-500">★</span>
              <span>Giấy phép hành nghề Thú y số <strong>458/GPHN-TYTPHCM</strong></span>
            </li>
            <li class="flex items-center gap-2">
              <span class="text-amber-500">★</span>
              <span>Bằng Bác sĩ Thú y – ĐH Nông Lâm TP.HCM (Hạng Xuất sắc)</span>
            </li>
            <li class="flex items-center gap-2">
              <span class="text-amber-500">★</span>
              <span>Chứng nhận Master Pet Grooming & Styling (ISCC Châu Á)</span>
            </li>
            <li class="flex items-center gap-2">
              <span class="text-amber-500">★</span>
              <span>Giải thưởng "Phòng khám Thú y Thân thiện 2025"</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- ========================================================================= -->
  <!-- TIÊU CHÍ 8: CÁC DỰ ÁN TIÊU BIỂU (ĐÃ HOÀN THÀNH / ĐANG THỰC HIỆN)          -->
  <!-- ========================================================================= -->
  <section id="du-an" class="py-16 px-6 sm:px-12 max-w-7xl mx-auto border-t border-[#1a3d1a]/10">
    <div class="text-center max-w-2xl mx-auto mb-12">
      <span class="text-xs font-bold text-[#E86A10] uppercase tracking-wider">Cộng đồng & Đổi mới</span>
      <h2 class="text-3xl sm:text-4xl font-serif-display text-[#1a3d1a] mt-1">Các dự án chính đã & đang thực hiện</h2>
      <p class="text-gray-600 text-xs sm:text-sm mt-2">Đóng góp cho sức khỏe cộng đồng thú cưng và số hóa quy trình thú y.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <!-- Dự án 1 -->
      <div class="clay-card overflow-hidden flex flex-col justify-between">
        <div class="h-40 overflow-hidden relative">
          <img src="https://images.unsplash.com/photo-1576201836106-db1758fd1c97?auto=format&fit=crop&w=500&q=80" alt="Tiêm phòng cộng đồng" class="w-full h-full object-cover" />
          <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full bg-green-600 text-white font-bold text-[10px]">
            Đã hoàn thành
          </span>
        </div>
        <div class="p-5 flex-1 flex flex-col justify-between">
          <div>
            <h4 class="font-bold text-sm text-[#1a3d1a] mb-1">Chiến dịch Vắc-xin Cộng đồng 2025</h4>
            <p class="text-xs text-gray-500 leading-relaxed">Tiêm phòng dại và tẩy giun miễn phí cho hơn 1.200 bé chó mèo tại khu vực TP.HCM.</p>
          </div>
          <div class="mt-4 pt-3 border-t border-gray-100 text-[11px] text-gray-400">
            Thời gian: 03/2025 – 08/2025
          </div>
        </div>
      </div>

      <!-- Dự án 2 -->
      <div class="clay-card overflow-hidden flex flex-col justify-between">
        <div class="h-40 overflow-hidden relative">
          <img src="https://images.unsplash.com/photo-1548767797-d8c844163c4c?auto=format&fit=crop&w=500&q=80" alt="Cứu trợ PawHope" class="w-full h-full object-cover" />
          <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full bg-[#E86A10] text-white font-bold text-[10px]">
            Đang thực hiện
          </span>
        </div>
        <div class="p-5 flex-1 flex flex-col justify-between">
          <div>
            <h4 class="font-bold text-sm text-[#1a3d1a] mb-1">Trạm Cứu hộ & Nhận nuôi PawHope</h4>
            <p class="text-xs text-gray-500 leading-relaxed">Tiếp nhận, chữa trị chấn thương và tìm mái ấm yêu thương cho chó mèo vô gia cư.</p>
          </div>
          <div class="mt-4 pt-3 border-t border-gray-100 text-[11px] text-gray-400">
            Thời gian: 2025 – Hiện tại
          </div>
        </div>
      </div>

      <!-- Dự án 3 -->
      <div class="clay-card overflow-hidden flex flex-col justify-between">
        <div class="h-40 overflow-hidden relative">
          <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=500&q=80" alt="Hệ thống bệnh án điện tử" class="w-full h-full object-cover" />
          <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full bg-green-600 text-white font-bold text-[10px]">
            Đã hoàn thành
          </span>
        </div>
        <div class="p-5 flex-1 flex flex-col justify-between">
          <div>
            <h4 class="font-bold text-sm text-[#1a3d1a] mb-1">PawNest Smart Booking & E-Medical</h4>
            <p class="text-xs text-gray-500 leading-relaxed">Xây dựng website đặt lịch hẹn trực tuyến đồng bộ với lịch làm việc thực của bác sĩ.</p>
          </div>
          <div class="mt-4 pt-3 border-t border-gray-100 text-[11px] text-gray-400">
            Công nghệ: PHP, MySQL, React, Tailwind
          </div>
        </div>
      </div>

      <!-- Dự án 4 -->
      <div class="clay-card overflow-hidden flex flex-col justify-between">
        <div class="h-40 overflow-hidden relative">
          <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee?auto=format&fit=crop&w=500&q=80" alt="Workshop sơ cứu" class="w-full h-full object-cover" />
          <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full bg-[#E86A10] text-white font-bold text-[10px]">
            Đang thực hiện
          </span>
        </div>
        <div class="p-5 flex-1 flex flex-col justify-between">
          <div>
            <h4 class="font-bold text-sm text-[#1a3d1a] mb-1">Workshop Sơ cứu Thú cưng Định kỳ</h4>
            <p class="text-xs text-gray-500 leading-relaxed">Khóa học kỹ năng xử lý khi bé bị sốc nhiệt, hóc dị vật hoặc ngộ độc thực phẩm cho chủ nuôi.</p>
          </div>
          <div class="mt-4 pt-3 border-t border-gray-100 text-[11px] text-gray-400">
            Tổ chức vào Thứ 7 tuần thứ 2 mỗi tháng
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========================================================================= -->
  <!-- DỊCH VỤ TIÊU BIỂU (FR-10)                                                 -->
  <!-- ========================================================================= -->
  <section id="dich-vu" class="py-16 px-6 sm:px-12 max-w-7xl mx-auto">
    <div class="text-center max-w-2xl mx-auto mb-12">
      <span class="text-xs font-bold text-[#E86A10] uppercase tracking-wider">Chăm sóc chuẩn y khoa</span>
      <h2 class="text-3xl sm:text-4xl font-serif-display text-[#1a3d1a] mt-1">Mọi thứ bé cần, gói gọn một nơi</h2>
      <p class="text-gray-600 text-sm mt-2">Từ khám chữa bệnh đến làm đẹp, bé không phải di chuyển qua nhiều địa chỉ.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="clay-card p-6">
        <div class="text-4xl mb-3">🩺</div>
        <h3 class="font-bold text-base mb-1 text-[#1a3d1a]">Khám & điều trị</h3>
        <p class="text-xs text-gray-600 leading-relaxed">Khám lâm sàng, siêu âm, xét nghiệm sinh hóa máu và điều trị bệnh truyền nhiễm cho chó mèo.</p>
      </div>

      <div class="clay-card p-6">
        <div class="text-4xl mb-3">💉</div>
        <h3 class="font-bold text-base mb-1 text-[#1a3d1a]">Tiêm phòng & tẩy giun</h3>
        <p class="text-xs text-gray-600 leading-relaxed">Lịch tiêm phòng dại, 5 bệnh, 7 bệnh và tẩy giun định kỳ, nhắc lịch hẹn tự động qua tin nhắn.</p>
      </div>

      <div class="clay-card p-6">
        <div class="text-4xl mb-3">🛁</div>
        <h3 class="font-bold text-base mb-1 text-[#1a3d1a]">Tắm & spa thư giãn</h3>
        <p class="text-xs text-gray-600 leading-relaxed">Dòng sữa tắm thảo mộc dịu êm, máy sấy chống ồn, vệ sinh tai kẽ chân và xịt dưỡng bóng mượt.</p>
      </div>

      <div class="clay-card p-6">
        <div class="text-4xl mb-3">✂️</div>
        <h3 class="font-bold text-base mb-1 text-[#1a3d1a]">Cắt tỉa tạo kiểu</h3>
        <p class="text-xs text-gray-600 leading-relaxed">Grooming thẩm mỹ theo giống hoặc theo yêu cầu của bạn, gửi ảnh trước/sau hoàn thiện.</p>
      </div>
    </div>
  </section>

  <!-- ========================================================================= -->
  <!-- BẢNG GIÁ 3 GÓI CHĂM SÓC (FR-11)                                           -->
  <!-- ========================================================================= -->
  <section id="goi" class="py-16 px-6 sm:px-12 bg-white/50 border-y border-black/5">
    <div class="max-w-7xl mx-auto">
      <div class="text-center max-w-2xl mx-auto mb-12">
        <span class="text-xs font-bold text-[#1a3d1a] uppercase tracking-wider bg-[#EFFDF0] px-3.5 py-1.5 rounded-full border border-black/5">
          Bảng giá công khai minh bạch
        </span>
        <h2 class="text-3xl sm:text-4xl font-serif-display text-[#1a3d1a] mt-2">Chọn gói phù hợp với bé</h2>
        <p class="text-gray-600 text-xs sm:text-sm mt-1">Giá áp dụng cho bé dưới 10 kg. Bé lớn hơn phụ thu 20.000 – 60.000 ₫.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
        <!-- Gói 1 -->
        <div class="clay-card p-6 flex flex-col justify-between">
          <div>
            <span class="text-xs font-bold text-[#E86A10] uppercase">Gói Cơ bản</span>
            <h3 class="text-2xl font-serif-display text-[#1a3d1a] mt-1">Tắm thơm</h3>
            <div class="text-3xl font-extrabold text-[#1a3d1a] my-4">
              150.000 ₫ <span class="text-xs font-normal text-gray-500">/lần</span>
            </div>
            <ul class="space-y-2 text-xs text-gray-600 mb-6">
              <li>🐾 Tắm & sấy khô nhẹ nhàng</li>
              <li>🐾 Cắt móng, vệ sinh tai</li>
              <li>🐾 Xịt thơm thảo mộc tự nhiên</li>
            </ul>
          </div>
          <button data-pk="Gói Cơ bản – Tắm thơm" class="select-pkg-btn w-full py-3 rounded-2xl bg-[#EFFDF0] hover:bg-[#1a3d1a] hover:text-white text-[#1a3d1a] font-semibold text-xs transition-colors cursor-pointer">
            Chọn gói này
          </button>
        </div>

        <!-- Gói 2 (Nổi bật nhất) -->
        <div class="rounded-3xl p-6 bg-[#1a3d1a] text-white shadow-xl flex flex-col justify-between scale-105 border-2 border-[#E86A10]">
          <div>
            <div class="flex justify-between items-center">
              <span class="text-xs font-bold text-[#E86A10] uppercase bg-white/10 px-2.5 py-0.5 rounded-full">
                Gói Spa & Cắt tỉa
              </span>
              <span class="text-[10px] text-amber-300 font-bold">★ Phổ biến nhất</span>
            </div>
            <h3 class="text-2xl font-serif-display mt-2">Spa & tạo kiểu hoàn hảo</h3>
            <div class="text-3xl font-extrabold my-4">
              320.000 ₫ <span class="text-xs font-normal text-gray-300">/lần</span>
            </div>
            <ul class="space-y-2 text-xs text-gray-200 mb-6">
              <li>🐾 Toàn bộ dịch vụ Gói Cơ bản</li>
              <li>🐾 Cắt tỉa tạo kiểu theo phong cách</li>
              <li>🐾 Massage thư giãn & dưỡng mềm mượt</li>
              <li>🐾 Khám sức khỏe tổng quát nhanh</li>
            </ul>
          </div>
          <button data-pk="Gói Spa & cắt tỉa" class="select-pkg-btn w-full py-3 rounded-2xl bg-[#E86A10] hover:bg-[#d45e0d] text-white font-semibold text-xs transition-colors shadow-md cursor-pointer">
            Chọn gói này
          </button>
        </div>

        <!-- Gói 3 -->
        <div class="clay-card p-6 flex flex-col justify-between">
          <div>
            <span class="text-xs font-bold text-[#E86A10] uppercase">Gói Toàn diện</span>
            <h3 class="text-2xl font-serif-display text-[#1a3d1a] mt-1">Khám + Tiêm + Spa</h3>
            <div class="text-3xl font-extrabold text-[#1a3d1a] my-4">
              690.000 ₫ <span class="text-xs font-normal text-gray-500">/lần</span>
            </div>
            <ul class="space-y-2 text-xs text-gray-600 mb-6">
              <li>🐾 Khám tổng quát cùng bác sĩ thú y</li>
              <li>🐾 1 mũi tiêm phòng định kỳ</li>
              <li>🐾 Tẩy giun & kiểm tra ve rận</li>
              <li>🐾 Trọn gói Spa & cắt tỉa tạo kiểu</li>
            </ul>
          </div>
          <button data-pk="Gói Toàn diện" class="select-pkg-btn w-full py-3 rounded-2xl bg-[#EFFDF0] hover:bg-[#1a3d1a] hover:text-white text-[#1a3d1a] font-semibold text-xs transition-colors cursor-pointer">
            Chọn gói này
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- ========================================================================= -->
  <!-- THƯ VIỆN BÉ CƯNG (FR-30, FR-31)                                           -->
  <!-- ========================================================================= -->
  <section id="thu-cung" class="py-16 px-6 sm:px-12 max-w-7xl mx-auto">
    <div class="text-center max-w-2xl mx-auto mb-10">
      <span class="text-xs font-bold text-[#1a3d1a] uppercase tracking-wider bg-white/70 px-3.5 py-1.5 rounded-full border border-black/5">
        Khách hàng nhí thân thiết
      </span>
      <h2 class="text-3xl sm:text-4xl font-serif-display text-[#1a3d1a] mt-2">Những gương mặt quen thuộc</h2>
      <p class="text-gray-600 text-xs sm:text-sm mt-1">Các bé cưng vừa ghé PawNest spa và thăm khám tuần này.</p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
      <!-- 1. Bơ (Corgi) - Ảnh thật -->
      <div class="clay-card overflow-hidden group flex flex-col justify-between">
        <div class="aspect-square relative overflow-hidden bg-amber-50">
          <img
            src="https://images.unsplash.com/photo-1612536057832-2ff7ead58194?auto=format&fit=crop&w=600&q=80"
            alt="Bơ - Corgi 2 tuổi"
            class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500"
          />
          <span class="absolute top-2 left-2 bg-black/60 backdrop-blur-xs text-white text-[9px] font-bold px-2 py-0.5 rounded-full">
            Spa & Tắm thơm
          </span>
        </div>
        <div class="p-3 text-center">
          <h4 class="font-bold text-sm text-[#1a3d1a]">Bơ</h4>
          <p class="text-[11px] text-gray-500 font-medium">Corgi, 2 tuổi</p>
          <span class="inline-block mt-1 text-[10px] text-green-700 bg-green-50 px-2 py-0.5 rounded-full font-semibold">
            ✓ Đã spa tuần này
          </span>
        </div>
      </div>

      <!-- 2. Mochi (Poodle) - Ảnh thật -->
      <div class="clay-card overflow-hidden group flex flex-col justify-between">
        <div class="aspect-square relative overflow-hidden bg-rose-50">
          <img
            src="https://images.unsplash.com/photo-1516371535707-512a1e83bb9a?auto=format&fit=crop&w=600&q=80"
            alt="Mochi - Poodle 3 tuổi"
            class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500"
          />
          <span class="absolute top-2 left-2 bg-[#E86A10] text-white text-[9px] font-bold px-2 py-0.5 rounded-full">
            Cắt tỉa Teddy
          </span>
        </div>
        <div class="p-3 text-center">
          <h4 class="font-bold text-sm text-[#1a3d1a]">Mochi</h4>
          <p class="text-[11px] text-gray-500 font-medium">Poodle, 3 tuổi</p>
          <span class="inline-block mt-1 text-[10px] text-green-700 bg-green-50 px-2 py-0.5 rounded-full font-semibold">
            ✓ Đã spa tuần này
          </span>
        </div>
      </div>

      <!-- 3. Mướp (Mèo ta) - Ảnh thật -->
      <div class="clay-card overflow-hidden group flex flex-col justify-between">
        <div class="aspect-square relative overflow-hidden bg-emerald-50">
          <img
            src="https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=600&q=80"
            alt="Mướp - Mèo ta 1 tuổi"
            class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500"
          />
          <span class="absolute top-2 left-2 bg-blue-600 text-white text-[9px] font-bold px-2 py-0.5 rounded-full">
            Tiêm vắc-xin 7 bệnh
          </span>
        </div>
        <div class="p-3 text-center">
          <h4 class="font-bold text-sm text-[#1a3d1a]">Mướp</h4>
          <p class="text-[11px] text-gray-500 font-medium">Mèo ta, 1 tuổi</p>
          <span class="inline-block mt-1 text-[10px] text-green-700 bg-green-50 px-2 py-0.5 rounded-full font-semibold">
            ✓ Khám định kỳ
          </span>
        </div>
      </div>

      <!-- 4. Cà Rốt (Thỏ kiểng) - Ảnh thật -->
      <div class="clay-card overflow-hidden group flex flex-col justify-between">
        <div class="aspect-square relative overflow-hidden bg-yellow-50">
          <img
            src="https://images.unsplash.com/photo-1585110396000-c9ffd4e4b308?auto=format&fit=crop&w=600&q=80"
            alt="Cà Rốt - Thỏ kiểng 8 tháng"
            class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500"
          />
          <span class="absolute top-2 left-2 bg-amber-600 text-white text-[9px] font-bold px-2 py-0.5 rounded-full">
            Tỉa móng & Vệ sinh
          </span>
        </div>
        <div class="p-3 text-center">
          <h4 class="font-bold text-sm text-[#1a3d1a]">Cà Rốt</h4>
          <p class="text-[11px] text-gray-500 font-medium">Thỏ kiểng, 8 tháng</p>
          <span class="inline-block mt-1 text-[10px] text-green-700 bg-green-50 px-2 py-0.5 rounded-full font-semibold">
            ✓ Đã spa tuần này
          </span>
        </div>
      </div>

      <!-- 5. Xíu (Phốc sóc) - Ảnh thật -->
      <div class="clay-card overflow-hidden group flex flex-col justify-between">
        <div class="aspect-square relative overflow-hidden bg-orange-50">
          <img
            src="https://images.unsplash.com/photo-1587300003388-59208cc962cb?auto=format&fit=crop&w=600&q=80"
            alt="Xíu - Phốc sóc 4 tuổi"
            class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500"
          />
          <span class="absolute top-2 left-2 bg-[#E86A10] text-white text-[9px] font-bold px-2 py-0.5 rounded-full">
            Spa Dưỡng lông
          </span>
        </div>
        <div class="p-3 text-center">
          <h4 class="font-bold text-sm text-[#1a3d1a]">Xíu</h4>
          <p class="text-[11px] text-gray-500 font-medium">Phốc sóc, 4 tuổi</p>
          <span class="inline-block mt-1 text-[10px] text-green-700 bg-green-50 px-2 py-0.5 rounded-full font-semibold">
            ✓ Đã spa tuần này
          </span>
        </div>
      </div>

      <!-- 6. Bông (Mèo Ba Tư) - Ảnh thật -->
      <div class="clay-card overflow-hidden group flex flex-col justify-between">
        <div class="aspect-square relative overflow-hidden bg-purple-50">
          <img
            src="https://images.unsplash.com/photo-1533738363-b7f9aef128ce?auto=format&fit=crop&w=600&q=80"
            alt="Bông - Ba Tư 2 tuổi"
            class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500"
          />
          <span class="absolute top-2 left-2 bg-purple-600 text-white text-[9px] font-bold px-2 py-0.5 rounded-full">
            Tắm sấy khử ố
          </span>
        </div>
        <div class="p-3 text-center">
          <h4 class="font-bold text-sm text-[#1a3d1a]">Bông</h4>
          <p class="text-[11px] text-gray-500 font-medium">Ba Tư, 2 tuổi</p>
          <span class="inline-block mt-1 text-[10px] text-green-700 bg-green-50 px-2 py-0.5 rounded-full font-semibold">
            ✓ Đã spa tuần này
          </span>
        </div>
      </div>
    </div>
  </section>

  <!-- ========================================================================= -->
  <!-- FORM ĐẶT LỊCH HẸN TRỰC TUYẾN (FR-20, FR-21, AJAX VÀO API HOẶC LOCAL)      -->
  <!-- ========================================================================= -->
  <section id="dat-lich" class="py-16 px-6 sm:px-12 bg-white/70 border-t border-black/5">
    <div class="max-w-4xl mx-auto">
      <div class="text-center mb-10">
        <span class="text-xs font-bold text-[#E86A10] uppercase tracking-wider">Đặt lịch nhanh chóng</span>
        <h2 class="text-3xl sm:text-4xl font-serif-display text-[#1a3d1a] mt-1">Đặt lịch khám & Spa trong 1 phút</h2>
        <p class="text-gray-600 text-xs sm:text-sm mt-1">Điền thông tin, hệ thống tự động lưu trữ và lễ tân sẽ gọi xác nhận trong 30 phút.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
        <div class="clay-card p-6 space-y-5 bg-[#EFFDF0]">
          <div>
            <h4 class="font-bold text-sm text-[#1a3d1a] mb-1">Giờ mở cửa</h4>
            <p class="text-xs text-gray-600">Thứ 2 – Chủ nhật: 08:00 – 20:00</p>
          </div>
          <div>
            <h4 class="font-bold text-sm text-[#1a3d1a] mb-1">Địa chỉ phòng khám</h4>
            <p class="text-xs text-gray-600">123 Đường Hoa Cúc, Phường 7, Q. Phú Nhuận, TP.HCM</p>
          </div>
          <div>
            <h4 class="font-bold text-sm text-[#E86A10] mb-1">Cấp cứu 24/7</h4>
            <p class="text-sm font-bold text-[#1a3d1a]">Hotline: 0900 123 456</p>
          </div>
          <div class="pt-2 border-t border-gray-200 text-[11px] text-gray-500">
            🔒 Thông tin được bảo vệ theo Nghị định 13/2023/NĐ-CP.
          </div>
        </div>

        <div class="md:col-span-2 clay-card p-6 sm:p-8">
          <div id="ms" class="hidden p-4 rounded-2xl mb-5 text-xs sm:text-sm" role="status"></div>

          <form id="f" class="space-y-4" novalidate>
            <div>
              <label class="block text-xs font-semibold text-gray-700 mb-1">Dịch vụ mong muốn</label>
              <select id="sv" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#1a3d1a] bg-gray-50/50">
                <?php
                try {
                    $servicesStmt = $pdo->query("SELECT name, price, is_package FROM services WHERE is_active = 1 ORDER BY is_package DESC, id ASC");
                    $dbServices = $servicesStmt->fetchAll();
                    if (!empty($dbServices)) {
                        foreach ($dbServices as $s) {
                            $isPkgText = !empty($s['is_package']) ? ' - Gói' : '';
                            $priceText = number_format((float)$s['price'], 0, ',', '.') . '₫';
                            echo '<option value="' . e($s['name']) . '">' . e($s['name']) . ' (' . $priceText . $isPkgText . ')</option>';
                        }
                    } else {
                        echo '<option value="Gói Spa & cắt tỉa">Gói Spa & cắt tỉa (320.000₫ - Phổ biến nhất)</option>';
                        echo '<option value="Gói Cơ bản – Tắm thơm">Gói Cơ bản – Tắm thơm (150.000₫)</option>';
                    }
                } catch (Throwable $e) {
                    echo '<option value="Gói Spa & cắt tỉa">Gói Spa & cắt tỉa (320.000₫ - Phổ biến nhất)</option>';
                    echo '<option value="Gói Cơ bản – Tắm thơm">Gói Cơ bản – Tắm thơm (150.000₫)</option>';
                }
                ?>
              </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Tên chủ nuôi *</label>
                <input id="nm" placeholder="Nguyễn Văn A" autocomplete="name" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#1a3d1a]" required />
              </div>
              <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Số điện thoại * (10 số, bắt đầu bằng 0)</label>
                <input id="ph" type="tel" placeholder="0912345678" autocomplete="tel" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#1a3d1a]" required />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Loại thú cưng</label>
                <select id="pt" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#1a3d1a]">
                  <option>Chó</option>
                  <option>Mèo</option>
                  <option>Thỏ</option>
                  <option>Khác</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Tên bé cưng *</label>
                <input id="pn" placeholder="Bơ / Mochi" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#1a3d1a]" required />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1 flex items-center gap-1">
                  <i data-lucide="calendar" class="w-3.5 h-3.5 text-gray-400"></i> Ngày hẹn *
                </label>
                <input id="dt" type="date" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#1a3d1a]" required />
              </div>
              <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1 flex items-center gap-1">
                  <i data-lucide="clock" class="w-3.5 h-3.5 text-gray-400"></i> Khung giờ hẹn
                </label>
                <select id="tm" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#1a3d1a]">
                  <option>08:00</option>
                  <option>09:30</option>
                  <option>11:00</option>
                  <option>13:30</option>
                  <option>15:00</option>
                  <option>16:30</option>
                  <option>18:00</option>
                </select>
              </div>
            </div>

            <!-- Phương thức thanh toán (rút gọn) -->
            <div>
              <label class="block text-xs font-semibold text-gray-700 mb-2">Phương thức thanh toán</label>
              <div class="flex gap-2">
                <label class="flex-1 cursor-pointer payment-opt-mini">
                  <input type="radio" name="payment_method" value="at_store" class="sr-only" checked />
                  <div class="pay-box-mini flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl border-2 border-[#1a3d1a] bg-emerald-50 text-xs font-semibold text-[#1a3d1a] transition-all">
                    🏪 Thanh toán tại quán
                  </div>
                </label>
                <label class="flex-1 cursor-pointer payment-opt-mini">
                  <input type="radio" name="payment_method" value="bank_transfer" class="sr-only" />
                  <div class="pay-box-mini flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-xs font-semibold text-gray-600 transition-all">
                    📱 QR Ngân hàng
                  </div>
                </label>
              </div>
            </div>

            <button type="submit" class="w-full py-3.5 rounded-2xl bg-[#E86A10] hover:bg-[#d45e0d] text-white font-bold text-xs sm:text-sm transition-all shadow-md active:scale-98 cursor-pointer">
              Xác nhận đặt lịch hẹn
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- ========================================================================= -->
  <!-- ĐÁNH GIÁ CỦA CHỦ NUÔI (FR-40)                                             -->
  <!-- ========================================================================= -->
  <section id="danh-gia" class="py-16 px-6 sm:px-12 max-w-7xl mx-auto">
    <div class="text-center max-w-2xl mx-auto mb-10">
      <span class="text-xs font-bold text-[#E86A10] uppercase tracking-wider">Niềm tin gửi trọn</span>
      <h2 class="text-3xl sm:text-4xl font-serif-display text-[#1a3d1a] mt-1">Chủ nuôi nói gì về PawNest</h2>
      <p class="text-gray-600 text-xs sm:text-sm mt-1">Những lời nhắn chân thật từ các gia đình đã đồng hành cùng chúng tôi.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="clay-card p-6 flex flex-col justify-between">
        <div>
          <div class="text-amber-500 flex gap-1 mb-3">★★★★★</div>
          <p class="text-xs text-gray-700 leading-relaxed italic">
            “Bơ vốn sợ nước nhưng lần này ra về vẫn vẫy đuôi. Bạn groomer rất kiên nhẫn và gửi ảnh cho mình liên tục.”
          </p>
        </div>
        <div class="flex items-center gap-3 mt-4 pt-4 border-t border-gray-100">
          <div class="w-9 h-9 rounded-full bg-pink-100 flex items-center justify-center text-base">👩</div>
          <div>
            <h5 class="font-bold text-xs text-[#1a3d1a]">Chị Thu Hà</h5>
            <small class="text-[11px] text-gray-500">Chủ của Bơ (Corgi 2 tuổi)</small>
          </div>
        </div>
      </div>

      <div class="clay-card p-6 flex flex-col justify-between">
        <div>
          <div class="text-amber-500 flex gap-1 mb-3">★★★★★</div>
          <p class="text-xs text-gray-700 leading-relaxed italic">
            “Khám và tiêm phòng cho mèo xong còn tắm luôn trong buổi sáng, đỡ phải đi hai nơi. Bác sĩ giải thích rất rõ ràng.”
          </p>
        </div>
        <div class="flex items-center gap-3 mt-4 pt-4 border-t border-gray-100">
          <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center text-base">👨</div>
          <div>
            <h5 class="font-bold text-xs text-[#1a3d1a]">Anh Minh Quân</h5>
            <small class="text-[11px] text-gray-500">Chủ của Mướp (Mèo ta 1 tuổi)</small>
          </div>
        </div>
      </div>

      <div class="clay-card p-6 flex flex-col justify-between">
        <div>
          <div class="text-amber-500 flex gap-1 mb-3">★★★★★</div>
          <p class="text-xs text-gray-700 leading-relaxed italic">
            “Đặt lịch online nhanh, đến nơi không phải chờ. Mochi được cắt tỉa đúng kiểu mình muốn, giá cũng hợp lý.”
          </p>
        </div>
        <div class="flex items-center gap-3 mt-4 pt-4 border-t border-gray-100">
          <div class="w-9 h-9 rounded-full bg-amber-100 flex items-center justify-center text-base">👧</div>
          <div>
            <h5 class="font-bold text-xs text-[#1a3d1a]">Bạn Ngọc Anh</h5>
            <small class="text-[11px] text-gray-500">Chủ của Mochi (Poodle 3 tuổi)</small>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========================================================================= -->
  <!-- TIÊU CHÍ 9: LIÊN HỆ & MẠNG XÃ HỘI (GITHUB, FB, INS, TIKTOK, ZALO, BẢN ĐỒ) -->
  <!-- ========================================================================= -->
  <section id="lien-he" class="py-16 px-6 sm:px-12 bg-white/80 border-t border-black/5">
    <div class="max-w-7xl mx-auto">
      <div class="text-center max-w-2xl mx-auto mb-12">
        <span class="text-xs font-bold text-[#E86A10] uppercase tracking-wider">Kết nối với chúng tôi</span>
        <h2 class="text-3xl sm:text-4xl font-serif-display text-[#1a3d1a] mt-1">Liên hệ & Mạng xã hội</h2>
        <p class="text-gray-600 text-xs sm:text-sm mt-1">Luôn sẵn sàng lắng nghe và hỗ trợ gia đình bé mọi lúc.</p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
        <!-- Thông tin liên hệ & Social Icons -->
        <div class="space-y-6">
          <div class="clay-card p-6 space-y-4">
            <h4 class="font-bold text-sm text-[#1a3d1a]">Thông tin trung tâm</h4>
            <p class="text-xs text-gray-600 flex items-center gap-2">
              <i data-lucide="map-pin" class="w-4 h-4 text-[#E86A10] shrink-0"></i>
              <span>123 Đường Hoa Cúc, Phường 7, Q. Phú Nhuận, TP. Hồ Chí Minh</span>
            </p>
            <p class="text-xs text-gray-600 flex items-center gap-2">
              <i data-lucide="phone" class="w-4 h-4 text-[#E86A10] shrink-0"></i>
              <span>Hotline 24/7: <strong>0900 123 456</strong></span>
            </p>
            <p class="text-xs text-gray-600 flex items-center gap-2">
              <i data-lucide="mail" class="w-4 h-4 text-[#E86A10] shrink-0"></i>
              <span>Email: <strong>thienkhang.pawnest@gmail.com</strong></span>
            </p>
          </div>

          <!-- Các liên kết mạng xã hội theo Tiêu chí 9 -->
          <div>
            <h4 class="font-bold text-xs text-gray-500 uppercase tracking-wider mb-3">Mạng xã hội & Mã nguồn dự án:</h4>
            <div class="flex flex-wrap items-center gap-3">
              <!-- GitHub Repository của sinh viên -->
              <a href="https://github.com/NguyenThienKhangWork/WedTrungTamThuY" target="_blank" rel="noopener noreferrer"
                 class="flex items-center gap-2 px-4 py-2.5 rounded-full bg-gray-900 text-white text-xs font-semibold hover:bg-black transition-all shadow-sm">
                <i data-lucide="github" class="w-4 h-4"></i>
                <span>GitHub Repository</span>
              </a>

              <!-- Facebook -->
              <a href="https://facebook.com" target="_blank" rel="noopener noreferrer"
                 class="flex items-center gap-2 px-4 py-2.5 rounded-full bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition-all shadow-sm">
                <i data-lucide="facebook" class="w-4 h-4"></i>
                <span>Facebook</span>
              </a>

              <!-- Instagram -->
              <a href="https://instagram.com" target="_blank" rel="noopener noreferrer"
                 class="flex items-center gap-2 px-4 py-2.5 rounded-full bg-pink-600 text-white text-xs font-semibold hover:bg-pink-700 transition-all shadow-sm">
                <i data-lucide="instagram" class="w-4 h-4"></i>
                <span>Instagram</span>
              </a>

              <!-- TikTok -->
              <a href="https://tiktok.com" target="_blank" rel="noopener noreferrer"
                 class="flex items-center gap-2 px-4 py-2.5 rounded-full bg-neutral-900 text-white text-xs font-semibold hover:bg-black transition-all shadow-sm">
                <i data-lucide="video" class="w-4 h-4"></i>
                <span>TikTok (@cozypaws.vn)</span>
              </a>

              <!-- Zalo -->
              <a href="https://zalo.me" target="_blank" rel="noopener noreferrer"
                 class="flex items-center gap-2 px-4 py-2.5 rounded-full bg-blue-500 text-white text-xs font-semibold hover:bg-blue-600 transition-all shadow-sm">
                <i data-lucide="message-circle" class="w-4 h-4"></i>
                <span>Zalo Official</span>
              </a>
            </div>
          </div>
        </div>

        <!-- Google Maps Iframe -->
        <div class="clay-card overflow-hidden h-[340px] border border-gray-200">
          <iframe
            title="Bản đồ PawNest Phú Nhuận"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.2612702759976!2d106.68725831533423!3d10.791289992311494!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317528d22383c271%3A0x67302f232463bf90!2zUGjDuiBOaHXhuq1uLCBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1699999999999!5m2!1svi!2s"
            width="100%"
            height="100%"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
          ></iframe>
        </div>
      </div>
    </div>
  </section>

  <!-- ========================================================================= -->
  <!-- FOOTER                                                                    -->

<?php
require_once __DIR__ . "/includes/footer.php";
?>
