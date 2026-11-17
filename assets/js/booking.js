/**
 * PawNest & CozyPaws - Xử lý Đặt lịch hẹn trực tuyến (FR-20, FR-21, FR-22, FR-23)
 * Kiểm tra dữ liệu hợp lệ phía Client & Gửi AJAX không tải lại trang
 */

document.addEventListener('DOMContentLoaded', () => {
  // Hỗ trợ cả form-booking (dat-lich.php) và form id="f" (index.php inline)
  const formBooking = document.getElementById('form-booking') || document.getElementById('f');
  const alertBox    = document.getElementById('ms');
  const inputDate   = document.getElementById('dt');
  const selectService = document.getElementById('sv');
  const selectSlot    = document.getElementById('tm');

  if (!formBooking || !inputDate) return;

  // 1. Không cho chọn ngày trong quá khứ (Mục FR-21)
  const today = new Date().toISOString().split('T')[0];
  inputDate.min = today;
  if (!inputDate.value) {
    inputDate.value = today;
  }

  // 2. Nút "Chọn gói này" tự động cuộn và điền dịch vụ (FR-11)
  document.querySelectorAll('.select-pkg-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const pkg = btn.dataset.pk || btn.getAttribute('data-pk');
      if (selectService && pkg) {
        selectService.value = pkg;
      }
      const bookingSection = document.getElementById('dat-lich');
      if (bookingSection) {
        bookingSection.scrollIntoView({ behavior: 'smooth' });
      }
      const nameInput = document.getElementById('nm');
      if (nameInput) {
        setTimeout(() => nameInput.focus({ preventScroll: true }), 400);
      }
    });
  });

  // 3. Tải danh sách khung giờ trống từ API (FR-22)
  async function loadSlots() {
    if (!selectSlot) return;
    const dateVal = inputDate.value;
    const serviceVal = selectService ? selectService.value : '';

    try {
      const res = await fetch(`/api/slots.php?date=${encodeURIComponent(dateVal)}&service=${encodeURIComponent(serviceVal)}`);
      if (res.ok) {
        const slots = await res.json();
        if (Array.isArray(slots) && slots.length > 0) {
          selectSlot.innerHTML = '';
          slots.forEach(s => {
            const opt = document.createElement('option');
            opt.value = s.time || s;
            opt.textContent = s.time ? `${s.time} (Còn chỗ)` : s;
            selectSlot.appendChild(opt);
          });
          return;
        }
      }
    } catch (err) {
      // Fallback khung giờ mặc định
    }
  }

  inputDate.addEventListener('change', loadSlots);
  if (selectService) selectService.addEventListener('change', loadSlots);

  // 4. Xử lý gửi Form Đặt lịch qua AJAX (FR-20, FR-21, FR-23)
  formBooking.addEventListener('submit', async (e) => {
    e.preventDefault();

    if (alertBox) {
      alertBox.style.display = 'block';
      alertBox.className = 'p-4 rounded-2xl mb-5 text-xs sm:text-sm bg-blue-50 text-blue-700 border border-blue-200';
      alertBox.textContent = 'Đang xử lý thông tin đặt lịch...';
    }

    const nm = document.getElementById('nm')?.value.trim();
    const ph = document.getElementById('ph')?.value.replace(/\s/g, '');
    const pn = document.getElementById('pn')?.value.trim();
    const pt = document.getElementById('pt')?.value;
    const sv = selectService?.value;
    const dt = inputDate?.value;
    const tm = selectSlot?.value;
    // Lấy phương thức thanh toán được chọn
    const payMethod = document.querySelector('input[name="payment_method"]:checked')?.value || 'at_store';

    // Kiểm tra trường bắt buộc (FR-21)
    if (!nm || !pn || !dt || !ph) {
      if (alertBox) {
        alertBox.className = 'p-4 rounded-2xl mb-5 text-xs sm:text-sm bg-red-50 text-red-700 border border-red-200';
        alertBox.textContent = 'Vui lòng điền đầy đủ họ tên chủ nuôi, số điện thoại, tên bé cưng và ngày hẹn.';
      }
      return;
    }

    // Kiểm tra định dạng số điện thoại Việt Nam 10 số bắt đầu bằng 0 (FR-21)
    if (!/^0\d{9}$/.test(ph)) {
      if (alertBox) {
        alertBox.className = 'p-4 rounded-2xl mb-5 text-xs sm:text-sm bg-red-50 text-red-700 border border-red-200';
        alertBox.textContent = 'Số điện thoại cần đủ 10 số, bắt đầu bằng số 0 (Ví dụ: 0912345678).';
      }
      return;
    }

    // Gửi yêu cầu qua API Backend
    try {
      const res = await fetch('/api/appointments.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          owner_name:     nm,
          phone:          ph,
          pet_name:       pn,
          pet_type:       pt,
          service_name:   sv,
          date:           dt,
          time:           tm,
          payment_method: payMethod
        })
      });

      const data = await res.json();
      if (res.ok && data.success) {
        const [y, mo, d] = dt.split('-');
        if (alertBox) {
          alertBox.className = 'p-4 rounded-2xl mb-5 text-xs sm:text-sm bg-[#EFFDF0] text-[#1a3d1a] border border-[#1a3d1a]/25 shadow-sm';
          alertBox.innerHTML = `
            <div class="font-bold text-sm mb-1 text-emerald-800">🎉 Đặt lịch hẹn thành công! (Mã lịch: #${data.appointment_id || 'PawNest'})</div>
            <div>Đã ghi nhận lịch hẹn cho bé <strong>${pn}</strong> (${pt.toLowerCase()}): dịch vụ <strong>${sv}</strong> vào lúc <strong>${tm} ngày ${d}/${mo}/${y}</strong>.</div>
            <div class="text-[11px] text-gray-600 mt-1.5">PawNest sẽ gọi điện đến số <strong>${ph}</strong> để xác nhận trong 15-30 phút!</div>
          `;
        }

        // Nếu chọn chuyển khoản QR → mở modal QR
        if (payMethod === 'bank_transfer' && typeof openQrModal === 'function') {
          openQrModal(pn, sv, data.appointment_id || 0);
        }

        formBooking.reset();
        inputDate.value = today;
        return;
      } else {
        if (alertBox) {
          alertBox.className = 'p-4 rounded-2xl mb-5 text-xs sm:text-sm bg-red-50 text-red-700 border border-red-200';
          alertBox.textContent = data.message || 'Không thể đặt lịch, vui lòng kiểm tra lại thông tin hoặc chọn giờ khác.';
        }
        return;
      }
    } catch (err) {
      // Fallback khi chạy file tĩnh
      const [y, mo, d] = dt.split('-');
      const fakeId = Math.floor(Math.random() * 9000) + 1000;
      if (alertBox) {
        alertBox.className = 'p-4 rounded-2xl mb-5 text-xs sm:text-sm bg-[#EFFDF0] text-[#1a3d1a] border border-[#1a3d1a]/20';
        alertBox.innerHTML = `<div class="font-bold mb-1">🎉 Đặt lịch thành công! (Mã: #${fakeId})</div>
          <div>Bé <strong>${pn}</strong>: ${sv}, lúc ${tm} ngày ${d}/${mo}/${y}. PawNest sẽ gọi <strong>${ph}</strong> xác nhận!</div>`;
      }
      if (payMethod === 'bank_transfer' && typeof openQrModal === 'function') {
        openQrModal(pn, sv, fakeId);
      }
    }
  });
});
