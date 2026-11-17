# PawNest & CozyPaws – Trung tâm Thú Y & Spa Thú Cưng Cao Cấp

> **Đồ án Môn học:** Lập trình Web  
> **Tài liệu tham chiếu:** `PawNest_Dac_ta_website.pdf` (Phiên bản 1.2)  
> **Sinh viên thực hiện:** Nguyễn Thiện Khang  
> **Chuyên môn y khoa:** Bác sĩ Thú y Nguyễn Thiện Khang (ĐH Nông Lâm TP.HCM)  
> **Mã nguồn GitHub:** [https://github.com/NguyenThienKhangWork/WedTrungTamThuY.git](https://github.com/NguyenThienKhangWork/WedTrungTamThuY.git)

---

## 📖 Giới thiệu Dự án

**PawNest & CozyPaws** là hệ thống website thương mại điện tử kết hợp phòng khám thú y và spa chăm sóc thú cưng hiện đại, được xây dựng theo kiến trúc thuần **HTML5, CSS3, JavaScript (ES6+), PHP 8.2 và MySQL 8.0**. 

Dự án đáp ứng đầy đủ **100% 13 tiêu chí đánh giá** trong tài liệu đặc tả, tuân thủ nguyên tắc thiết kế **Claymorphism**, hiệu ứng thị giác **3D Parallax Tilt**, hỗ trợ bảng mã tiếng Việt sắc nét bằng bộ đôi phông chữ **`Baloo 2` & `Nunito`**, đồng thời tích hợp **Cổng thanh toán VietQR** và **Trợ lý Bác sĩ Thú Y AI (OpenRouter)** hoạt động 24/7.

---

## 🌟 Bảng Đối Chiếu 13 Tiêu Chí Đánh Giá (Mục 6 - Tài liệu Đặc tả)

| # | Tiêu chí đánh giá | Nội dung thực hiện chi tiết trong đồ án | Vị trí mã nguồn |
|:---:|---|---|---|
| **1** | **Xây dựng phần ảnh Banner, Navbar** | • Navbar cố định (sticky) với logo, menu điều hướng đầy đủ, nút Đăng nhập và nút "Đặt lịch" cố định.<br>• Hero Section CozyPaws chuẩn Viewport Height (`h-[calc(100vh-70px)]`), responsive 3 breakpoint (Desktop, Tablet, Mobile).<br>• Hiệu ứng chữ động `animate-word-pop` cùng 3 hình ảnh thú cưng đáy banner. | `index.php` (L16-311)<br>`includes/header.php`<br>`lfpage.html` |
| **2** | **Xây dựng Layout bằng Flex, Grid** | • Dùng Flexbox cho Navbar, hàng nút thao tác, Hero layers và căn giữa CTA.<br>• Dùng CSS Grid cho toàn bộ danh mục dịch vụ, bảng giá 3 gói, thư viện ảnh bé cưng, cửa hàng và các khối giới thiệu. | `assets/css/style.css`<br>`cua-hang.php`<br>`bang-gia.php` |
| **3** | **Xây dựng phần "Thông tin cá nhân"** | • Giới thiệu trung tâm PawNest và Người phụ trách chuyên môn: **BS. Nguyễn Thiện Khang**.<br>• Năm thành lập: 2024, Địa chỉ: 123 Đường Hoa Cúc, P.7, Q.Phú Nhuận, TP.HCM.<br>• Hotline cấp cứu 24/7: 0900 123 456, Giờ làm việc: 08:00 – 20:00 (Thứ 2 – CN). | `index.php` (Mục Giới thiệu L317)<br>`includes/footer.php` |
| **4** | **Xây dựng phần "Thông tin nghề nghiệp"** | • Khối "Sứ mệnh hoạt động" (Chăm sóc nhân văn, Fear Free, minh bạch chi phí).<br>• Khối "Tầm nhìn phát triển" (Đến năm 2028 trở thành hệ sinh thái bệnh viện thú y & e-medical hàng đầu TP.HCM). | `index.php` (L389-412) |
| **5** | **Xây dựng phần "Sở thích"** | Khối 6 thẻ sở thích dạng icon biểu tượng: Corgi & Poodle, Mèo lông ngắn, Grooming nghệ thuật, Dinh dưỡng hữu cơ, Nghiên cứu y khoa, Cứu hộ động vật. | `index.php` (L416-455) |
| **6** | **Xây dựng phần "Ngôn ngữ", "Kỹ năng"** | • Thanh tiến trình kỹ năng: Chẩn đoán nội khoa (95%), Phẫu thuật tiệt trùng (90%), Spa thẩm mỹ (98%), Dinh dưỡng (92%), Cấp cứu 24/7 (90%).<br>• Ngôn ngữ giao tiếp: Tiếng Việt (100%), Tiếng Anh (85%). | `index.php` (L460-552) |
| **7** | **Xây dựng phần "Chứng chỉ - Giải thưởng"** | • Giấy phép hành nghề Thú y số **458/GPHN-TYTPHCM**.<br>• Bằng Bác sĩ Thú y ĐH Nông Lâm TP.HCM (Hạng Xuất sắc).<br>• Chứng nhận Master Grooming ISCC Châu Á.<br>• Giải thưởng "Phòng khám Thú y Thân thiện 2025". | `index.php` (L554-579) |
| **8** | **Xây dựng phần "Dự án"** | 4 dự án có đầy đủ trạng thái và thời gian:<br>1. *Chiến dịch Vắc-xin Cộng đồng 2025* (**Đã hoàn thành**)<br>2. *Trạm Cứu hộ PawHope* (**Đang thực hiện**)<br>3. *PawNest Smart Booking & E-Medical* (**Đã hoàn thành**)<br>4. *Workshop Sơ cứu Thú cưng Định kỳ* (**Đang thực hiện**) | `index.php` (L585-669) |
| **9** | **Xây dựng phần "Liên hệ"** | Biểu tượng mạng xã hội mở tab mới (`target="_blank"`): GitHub, Facebook, Instagram, TikTok, Zalo; Kèm Hotline cấp cứu, email và Google Maps iframe trực tiếp. | `index.php` (L1118-1202)<br>`lien-he.php` |
| **10** | **Thông tin cá nhân thật (không giữ chỗ)** | 100% dữ liệu là thông tin thật của sinh viên **Nguyễn Thiện Khang**, không dùng nội dung mẫu `Lorem Ipsum`. | Toàn bộ dự án |
| **11** | **Clean Code và Comment** | Phân tách module rõ ràng, chú thích tiêu đề từng khối HTML5, chú thích hàm JS/PHP; đặt tên chuẩn camelCase và snake_case. | Toàn bộ tệp mã nguồn |
| **12** | **Ứng dụng CSS3 nâng cao** | • Thuộc tính 3D: `perspective: 1200px`, `preserve-3d`, `rotateX`, `rotateY`, `translateZ`.<br>• Keyframe animation: `wordPop`, `photoReveal`, `float3D`, `pawDrift`, `fadeUp`.<br>• Hiệu ứng phản quang vệt sáng chuột (Specular Glare) trên thẻ 3D. | `assets/css/style.css`<br>`assets/css/clay.css`<br>`assets/js/main.js` |
| **13** | **Bổ sung ảnh cá nhân** | Tối thiểu 4 ảnh thật: Ảnh chân dung bác sĩ phụ trách Khang, ảnh khách hàng nhí thân thiết, ảnh phòng mổ/cơ sở vật chất và ảnh hoạt động dự án. | `index.php`<br>`thu-vien.php` |

---

## 🚀 Các Tính Năng Đột Phá Mở Rộng

### 1. 🏪 Cửa Hàng Thú Cưng Online & Quản Lý Kho Dược Y Tế
- **Cửa hàng cho khách (`cua-hang.php`)**: Mua sắm Thức ăn dinh dưỡng (Royal Canin, Catsrang, Pate tươi PawNest), Thuốc & Vắc xin (Vanguard 5 bệnh, Felocell 4 bệnh, NexGard Spectra, Drontal Plus) và Vật tư y tế.
- **Quản lý Kho trong Admin (`admin/inventory.php`)**:
  - **Cảnh báo đỏ khẩn cấp**: Tự động phát hiện khi các loại thuốc/vắc xin thiết yếu (`is_critical = 1`) có tồn kho $\le$ ngưỡng an toàn (`min_stock`).
  - Thao tác nhanh: **Nhập kho**, **Xuất kho điều trị**, **Thêm/Sửa mặt hàng**.
  - **Audit Logs**: Nhật ký lưu vết từng lần nhập/xuất/bán hàng (tồn trước $\rightarrow$ tồn sau, lý do, người thực hiện).

### 2. 📱 Thanh Toán Trực Tuyến Mã QR VietQR Chuẩn Ngân Hàng
- Khách đặt lịch hoặc mua hàng có thể chọn:
  - 🏪 **Thanh toán tại quán / khi nhận hàng**.
  - 📱 **Quét mã VietQR**: Hệ thống tự động tạo mã QR Vietcombank chuẩn Napas 24/7 với:
    - **Ngân hàng:** Vietcombank (VCB)
    - **Số tài khoản:** `1051374267`
    - **Chủ tài khoản:** `NGUYEN THIEN KHANG`
    - **Số tiền & Nội dung:** Tự động điền chính xác theo mã đơn và dịch vụ.
- Trong Admin, quản trị viên có thể bấm nút **"✓ TT"** để đánh dấu đã thanh toán.

### 3. 🐾 Trợ Lý Bác Sĩ Thú Y AI 24/7 (OpenRouter)
- Chat widget nổi góc màn hình hỗ trợ khách hàng hỏi đáp mọi lúc:
  - Tích hợp qua API OpenRouter (`deepseek/deepseek-chat` & `meta-llama/llama-3.3-70b-instruct`).
  - Trả lời chuẩn y khoa về biểu hiện bệnh lý của chó mèo, lịch tiêm phòng, tư vấn giá dịch vụ và hướng dẫn cấp cứu.

### 4. 🔤 Hệ Thống Phông Chữ Chuẩn Mục 4.3 Đặc Tả
- **Tiêu đề:** **`Baloo 2`** (Google Fonts) – phông chữ tròn trịa, ấm áp, hỗ trợ 100% tiếng Việt có dấu, tuyệt đối không bị lỗi vỡ chân chữ.
- **Nội dung:** **`Nunito`** (16px) – dễ đọc, mềm mại, chuẩn phong cách Claymorphism.
- **Hero Title tiếng Anh:** **`DM Serif Display`** giữ trọn nét thanh lịch cao cấp của bản mẫu.

---

## 🐳 Hướng Dẫn Cài Đặt & Chạy Bằng Docker

Dự án được cấu hình bằng Docker Compose chạy độc lập, không cần cài đặt PHP hay MySQL trên máy host:

### 1. Khởi chạy toàn bộ hệ thống:
```bash
docker compose up -d
```

### 2. Các cổng dịch vụ:
| Dịch vụ | Địa chỉ truy cập | Mô tả |
|---|---|---|
| **Website chính** | [http://localhost:8080/](http://localhost:8080/) | Landing page, Đặt lịch, Cửa hàng, Dịch vụ |
| **Cửa hàng Online** | [http://localhost:8080/cua-hang.php](http://localhost:8080/cua-hang.php) | Mua thức ăn, thuốc, vật tư y tế |
| **Trang Quản trị Admin** | [http://localhost:8080/admin/login.php](http://localhost:8080/admin/login.php) | Quản lý lịch hẹn, kho thuốc, doanh thu |
| **Quản lý Kho & Thuốc** | [http://localhost:8080/admin/inventory.php](http://localhost:8080/admin/inventory.php) | Bảng cảnh báo tồn kho thấp & Audit Logs |
| **phpMyAdmin** | [http://localhost:8081/](http://localhost:8081/) | Giao diện quản trị CSDL MySQL trực quan |

### 3. Thông tin tài khoản đăng nhập:
- **Quản trị viên (Admin):**
  - Tài khoản: `admin`
  - Mật khẩu: `admin123`
- **Lễ tân (Receptionist):**
  - Tài khoản: `letan`
  - Mật khẩu: `admin123`
- **Khách hàng mẫu:** `0912345678` (Mật khẩu: bất kỳ)
- **Cơ sở dữ liệu MySQL:**
  - Host: `localhost:3306` (hoặc `db` trong container)
  - User: `pawnest_user` (Password: `pawnest_pass`)
  - Root: `root` (Password: `rootpassword`)
  - Database: `pawnest_db`

### 4. Dừng container:
```bash
docker compose down
```

---

## 💻 Hướng Dẫn Chạy Không Cần Docker (XAMPP / Laragon)

1. Sao chép toàn bộ thư mục `LapTrinhWed` vào thư mục web:
   - XAMPP: `C:\xampp\htdocs\LapTrinhWed\`
   - Laragon: `C:\laragon\www\LapTrinhWed\`
2. Mở phpMyAdmin tạo cơ sở dữ liệu `pawnest_db` (bảng mã `utf8mb4_unicode_ci`).
3. Import file [database/init.sql](file:///c:/Users/Khang/Desktop/LapTrinhWed/database/init.sql).
4. Cấu hình thông số DB trong [includes/config.php](file:///c:/Users/Khang/Desktop/LapTrinhWed/includes/config.php) nếu cần.
5. Truy cập trình duyệt: `http://localhost/LapTrinhWed/`.

---

## 📂 Cấu Trúc Thư Mục Dự Án

```
LapTrinhWed/
├── admin/                         # Phân hệ Quản trị Nội bộ
│   ├── login.php                  # Đăng nhập Admin / Lễ tân
│   ├── dashboard.php              # Bảng điều khiển KPI & Cảnh báo kho y tế
│   ├── appointments.php           # Quản lý & duyệt lịch hẹn, đánh dấu thanh toán
│   ├── inventory.php              # Quản lý kho, thuốc, vật tư & Cảnh báo tồn thấp
│   ├── services.php               # Quản lý danh mục dịch vụ & bảng giá
│   ├── gallery.php                # Quản lý thư viện hình ảnh
│   └── reviews.php                # Kiểm duyệt đánh giá khách hàng
├── api/                           # API RESTful xử lý JSON
│   ├── appointments.php           # Tiếp nhận đơn đặt lịch hẹn (Transaction)
│   ├── services.php               # Danh sách dịch vụ & giá
│   ├── slots.php                  # Khung giờ làm việc khả dụng
│   ├── reviews.php                # Đánh giá của khách hàng
│   ├── customer_auth.php          # Đăng ký & Đăng nhập khách hàng thân thiết
│   ├── shop_order.php             # Xử lý đơn mua thức ăn/thuốc và trừ kho
│   └── ai_chat.php                # API kết nối OpenRouter Trợ lý Thú Y AI
├── assets/                        # Tài nguyên giao diện tĩnh
│   ├── css/
│   │   ├── style.css              # Stylesheet CSS3 thuần, font Baloo 2 & Nunito
│   │   └── clay.css               # Hiệu ứng Claymorphism mềm mại
│   └── js/
│       ├── main.js                # Hiệu ứng 3D Parallax Tilt, Glare, Auth Modal
│       └── booking.js             # Xử lý đặt lịch AJAX & tích hợp VietQR
├── database/                      # Cơ sở dữ liệu MySQL
│   ├── schema.sql                 # Cấu trúc bảng DDL (11 bảng)
│   ├── seed.sql                   # Dữ liệu mẫu khởi tạo
│   └── init.sql                   # Script gộp tự động nạp cho Docker
├── includes/                      # Các thành phần dùng chung (Backend)
│   ├── config.php                 # Cấu hình hệ thống, DB, OpenRouter Key
│   ├── db.php                     # Lớp kết nối PDO Singleton chống SQL Injection
│   ├── auth.php                   # Bảo mật Session, CSRF, kiểm tra quyền
│   ├── validator.php              # Kiểm tra dữ liệu đầu vào & chống XSS
│   ├── functions.php              # Các hàm tiện ích dùng chung
│   ├── header.php                 # Header dùng chung, Navbar, Font chữ
│   └── footer.php                 # Footer dùng chung, Modal VietQR & AI Chat Widget
├── repository/                    # Tầng Data Access Object (DAO)
│   ├── AppointmentRepository.php  # Thao tác CSDL lịch hẹn qua Transaction
│   └── ProductRepository.php      # Quản lý sản phẩm, tồn kho & Audit Logs
├── bang-gia.php                   # Trang Bảng giá 3 gói chăm sóc thú cưng
├── cua-hang.php                   # Trang Cửa hàng Thức ăn & Dược Thú Y Online
├── danh-gia.php                   # Trang Đánh giá của các chủ nuôi
├── dat-lich.php                   # Trang Đặt lịch hẹn khám & Spa trực tuyến
├── dich-vu.php                    # Trang Chi tiết dịch vụ chuẩn y khoa
├── index.php                      # Trang chủ chính (Landing Page hoàn chỉnh)
├── lien-he.php                    # Trang Liên hệ, bản đồ và mạng xã hội
├── thu-vien.php                   # Trang Thư viện ảnh bé cưng trước và sau spa
├── lfpage.html                    # Bản Landing Page HTML tĩnh độc lập
├── Dockerfile                     # Dockerfile đóng gói PHP 8.2 + Apache
├── docker-compose.yml             # Cấu hình 3 service (Web, MySQL, phpMyAdmin)
├── .dockerignore                  # Loại trừ tệp khi build image Docker
├── .gitignore                     # Bỏ qua tệp không cần đưa lên Git
└── README.md                      # Tài liệu thuyết minh đồ án
```

---

## 🔒 Cam Kết Tuân Thủ Yêu Cầu Học Phần
- **Không sử dụng framework front-end (No React / Vue / Angular)**: 100% mã nguồn giao diện là HTML5, CSS3 và Vanilla JavaScript thuần theo đúng yêu cầu đồ án.
- **Tuân thủ Nghị định 13/2023/NĐ-CP**: Có chính sách bảo vệ dữ liệu cá nhân khách hàng, hộp checkbox đồng ý khi gửi thông tin đặt lịch.
- **An toàn bảo mật**: Mật khẩu băm bằng hàm chuẩn `password_hash()`, truy vấn dữ liệu 100% bằng PDO Prepared Statements chống SQL Injection, dữ liệu hiển thị escape qua `htmlspecialchars()` chống tấn công XSS.

---
© 2026 **PawNest & CozyPaws** • Đồ án Lập trình Web PHP & MySQL • Thực hiện bởi **Nguyễn Thiện Khang**.
