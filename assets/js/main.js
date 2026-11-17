/**
 * PawNest & CozyPaws - JavaScript Tương tác chính (ES6+ thuần)
 * Tuân thủ mục 5.1 (không framework) & 4.6 (chuyển động có chủ đích)
 */

document.addEventListener('DOMContentLoaded', () => {
  // 1. Khởi tạo biểu tượng Lucide nếu có
  if (typeof lucide !== 'undefined' && lucide.createIcons) {
    lucide.createIcons();
  }

  // 2. ================= HIỆU ỨNG TƯƠNG TÁC 3D PARALLAX & TILT =================
  (function init3DHeroParallax() {
    const heroSection = document.getElementById('top');
    const heading = document.getElementById('hero-heading-3d');
    const cardLeft = document.getElementById('hero-card-left');
    const cardRight = document.getElementById('hero-card-right');
    const glareLeft = document.getElementById('glare-card-left');
    const glareRight = document.getElementById('glare-card-right');
    const petCenter = document.getElementById('hero-pet-center');
    const petLeft = document.getElementById('hero-pet-left');
    const petRight = document.getElementById('hero-pet-right');
    const overlayCenter = document.getElementById('hero-overlay-center');

    if (!heroSection || !cardLeft) return;

    let targetX = 0, targetY = 0;
    let currentX = 0, currentY = 0;
    let isHovering = false;
    let rafId = null;

    heroSection.addEventListener('mousemove', (e) => {
      const rect = heroSection.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      targetX = ((x / rect.width) * 2) - 1;
      targetY = ((y / rect.height) * 2) - 1;
      isHovering = true;

      // Phản chiếu tia sáng theo vị trí chuột (Glare)
      if (cardLeft && glareLeft) {
        const cRect = cardLeft.getBoundingClientRect();
        const gx = Math.max(0, Math.min(100, ((e.clientX - cRect.left) / cRect.width) * 100));
        const gy = Math.max(0, Math.min(100, ((e.clientY - cRect.top) / cRect.height) * 100));
        glareLeft.style.background = `radial-gradient(circle at ${gx}% ${gy}%, rgba(255,255,255,0.45) 0%, rgba(255,255,255,0) 65%)`;
      }
      if (cardRight && glareRight) {
        const cRect = cardRight.getBoundingClientRect();
        const gx = Math.max(0, Math.min(100, ((e.clientX - cRect.left) / cRect.width) * 100));
        const gy = Math.max(0, Math.min(100, ((e.clientY - cRect.top) / cRect.height) * 100));
        glareRight.style.background = `radial-gradient(circle at ${gx}% ${gy}%, rgba(255,255,255,0.45) 0%, rgba(255,255,255,0) 65%)`;
      }

      if (!rafId) {
        rafId = requestAnimationFrame(updatePhysics);
      }
    });

    heroSection.addEventListener('mouseleave', () => {
      targetX = 0;
      targetY = 0;
      isHovering = false;
    });

    function updatePhysics() {
      // Nội suy lerp mượt mà 0.08
      currentX += (targetX - currentX) * 0.08;
      currentY += (targetY - currentY) * 0.08;

      if (cardLeft) {
        const rotX = currentY * -16;
        const rotY = currentX * 16;
        cardLeft.style.transform = `perspective(1000px) rotateX(${rotX.toFixed(2)}deg) rotateY(${rotY.toFixed(2)}deg) translateZ(30px)`;
      }

      if (cardRight) {
        const rotX = currentY * -16;
        const rotY = currentX * 16;
        cardRight.style.transform = `perspective(1000px) rotateX(${rotX.toFixed(2)}deg) rotateY(${rotY.toFixed(2)}deg) translateZ(30px)`;
      }

      if (heading) {
        const tx = currentX * 10;
        const ty = currentY * 6;
        heading.style.transform = `perspective(1000px) translate3d(${tx.toFixed(2)}px, ${ty.toFixed(2)}px, 35px)`;
      }

      if (petCenter) {
        const tx = currentX * 14;
        const ty = currentY * 8;
        petCenter.style.transform = `perspective(1000px) translate3d(${tx.toFixed(2)}px, ${ty.toFixed(2)}px, 20px)`;
      }

      if (petLeft) {
        const tx = currentX * 7;
        const ty = currentY * 4;
        petLeft.style.transform = `perspective(1000px) translate3d(${tx.toFixed(2)}px, ${ty.toFixed(2)}px, 10px)`;
      }
      if (petRight) {
        const tx = currentX * 7;
        const ty = currentY * 4;
        petRight.style.transform = `perspective(1000px) translate3d(${tx.toFixed(2)}px, ${ty.toFixed(2)}px, 10px)`;
      }

      if (overlayCenter) {
        const tx = currentX * 6;
        overlayCenter.style.transform = `translate3d(${tx.toFixed(2)}px, 0, 45px)`;
      }

      if (Math.abs(targetX - currentX) > 0.001 || Math.abs(targetY - currentY) > 0.001 || isHovering) {
        rafId = requestAnimationFrame(updatePhysics);
      } else {
        rafId = null;
      }
    }
  })();

  // 3. ================= XỬ LÝ MODAL ĐĂNG NHẬP / ĐĂNG KÝ =================
  (function initCustomerAuth() {
    const authModal = document.getElementById('auth-modal');
    const btnOpenAuth = document.getElementById('btn-auth-modal');
    const btnCloseAuth = document.getElementById('close-auth-modal');
    const tabLogin = document.getElementById('tab-login');
    const tabRegister = document.getElementById('tab-register');
    const formLogin = document.getElementById('form-customer-login');
    const formRegister = document.getElementById('form-customer-register');
    const authAlert = document.getElementById('auth-alert');
    const authFormsContainer = document.getElementById('auth-forms-container');
    const userProfileBox = document.getElementById('user-profile-box');
    const navUserLabel = document.getElementById('nav-user-label');
    const btnLogout = document.getElementById('btn-logout');

    if (!authModal || !btnOpenAuth) return;

    // Kiểm tra trạng thái đăng nhập từ localStorage
    const savedUser = JSON.parse(localStorage.getItem('pawnest_customer') || 'null');
    if (savedUser && savedUser.name && navUserLabel) {
      navUserLabel.textContent = savedUser.name;
    }

    btnOpenAuth.onclick = () => {
      authModal.classList.remove('hidden');
      const currentUser = JSON.parse(localStorage.getItem('pawnest_customer') || 'null');
      if (currentUser && currentUser.name && userProfileBox && authFormsContainer) {
        authFormsContainer.classList.add('hidden');
        userProfileBox.classList.remove('hidden');
        const pName = document.getElementById('profile-name');
        const pPhone = document.getElementById('profile-phone');
        if (pName) pName.textContent = currentUser.name;
        if (pPhone) pPhone.textContent = currentUser.phone || '';
      } else if (authFormsContainer && userProfileBox) {
        authFormsContainer.classList.remove('hidden');
        userProfileBox.classList.add('hidden');
      }
    };

    if (btnCloseAuth) {
      btnCloseAuth.onclick = () => authModal.classList.add('hidden');
    }

    authModal.onclick = (e) => {
      if (e.target === authModal) authModal.classList.add('hidden');
    };

    if (tabLogin && tabRegister && formLogin && formRegister) {
      tabLogin.onclick = () => {
        tabLogin.className = 'flex-1 pb-2 font-bold text-sm border-b-2 border-[#1a3d1a] text-[#1a3d1a] cursor-pointer';
        tabRegister.className = 'flex-1 pb-2 font-semibold text-sm border-b-2 border-transparent text-gray-400 hover:text-gray-700 cursor-pointer';
        formLogin.classList.remove('hidden');
        formRegister.classList.add('hidden');
        if (authAlert) authAlert.classList.add('hidden');
      };

      tabRegister.onclick = () => {
        tabRegister.className = 'flex-1 pb-2 font-bold text-sm border-b-2 border-[#1a3d1a] text-[#1a3d1a] cursor-pointer';
        tabLogin.className = 'flex-1 pb-2 font-semibold text-sm border-b-2 border-transparent text-gray-400 hover:text-gray-700 cursor-pointer';
        formRegister.classList.remove('hidden');
        formLogin.classList.add('hidden');
        if (authAlert) authAlert.classList.add('hidden');
      };
    }

    // Gửi form đăng ký
    if (formRegister) {
      formRegister.onsubmit = async (e) => {
        e.preventDefault();
        const fullName = document.getElementById('reg-name')?.value.trim();
        const phone    = document.getElementById('reg-phone')?.value.trim();
        const email    = document.getElementById('reg-email')?.value.trim();
        const password = document.getElementById('reg-pass')?.value.trim();
        const petName  = document.getElementById('reg-pet-name')?.value.trim();
        const petSpec  = document.getElementById('reg-pet-species')?.value;

        try {
          const res = await fetch('/api/customer_auth.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'register', full_name: fullName, phone, email, password, pet_name: petName, pet_species: petSpec })
          });
          const data = await res.json();
          if (authAlert) {
            authAlert.classList.remove('hidden');
            if (data.success) {
              authAlert.className = 'p-3 rounded-xl mb-4 text-xs font-semibold bg-green-50 text-green-700 border border-green-200';
              authAlert.textContent = data.message || 'Đăng ký thành công!';
              const userObj = data.customer || { name: fullName, phone };
              localStorage.setItem('pawnest_customer', JSON.stringify(userObj));
              if (navUserLabel) navUserLabel.textContent = userObj.name;
              setTimeout(() => authModal.classList.add('hidden'), 1200);
            } else {
              authAlert.className = 'p-3 rounded-xl mb-4 text-xs font-semibold bg-red-50 text-red-700 border border-red-200';
              authAlert.textContent = data.message || 'Đăng ký thất bại.';
            }
          }
        } catch (err) {
          // Fallback demo
          const userObj = { name: fullName || 'Khách hàng mới', phone };
          localStorage.setItem('pawnest_customer', JSON.stringify(userObj));
          if (navUserLabel) navUserLabel.textContent = userObj.name;
          setTimeout(() => authModal.classList.add('hidden'), 800);
        }
      };
    }

    // Gửi form đăng nhập
    if (formLogin) {
      formLogin.onsubmit = async (e) => {
        e.preventDefault();
        const identifier = document.getElementById('login-identifier')?.value.trim();
        const password = document.getElementById('login-password')?.value.trim();

        try {
          const res = await fetch('/api/customer_auth.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'login', identifier, password })
          });
          const data = await res.json();
          if (data.success) {
            const userObj = data.customer || { name: identifier, phone: identifier };
            localStorage.setItem('pawnest_customer', JSON.stringify(userObj));
            if (navUserLabel) navUserLabel.textContent = userObj.name;
            if (authAlert) {
              authAlert.className = 'p-3 rounded-xl mb-4 text-xs font-semibold bg-green-50 text-green-700 border border-green-200';
              authAlert.textContent = data.message || 'Đăng nhập thành công!';
              authAlert.classList.remove('hidden');
            }
            setTimeout(() => authModal.classList.add('hidden'), 900);
          } else {
            if (authAlert) {
              authAlert.className = 'p-3 rounded-xl mb-4 text-xs font-semibold bg-red-50 text-red-700 border border-red-200';
              authAlert.textContent = data.message || 'Sai thông tin đăng nhập.';
              authAlert.classList.remove('hidden');
            }
          }
        } catch (err) {
          // Fallback demo
          const userObj = { name: 'Chị Thu Hà', phone: identifier };
          localStorage.setItem('pawnest_customer', JSON.stringify(userObj));
          if (navUserLabel) navUserLabel.textContent = userObj.name;
          setTimeout(() => authModal.classList.add('hidden'), 800);
        }
      };
    }

    // Đăng xuất
    if (btnLogout) {
      btnLogout.onclick = () => {
        localStorage.removeItem('pawnest_customer');
        if (navUserLabel) navUserLabel.textContent = 'Đăng nhập';
        authModal.classList.add('hidden');
      };
    }
  })();
});
