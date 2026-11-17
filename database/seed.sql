-- ==========================================================
-- PawNest & CozyPaws Seed Data
-- Dữ liệu mẫu chuẩn cho hệ thống theo đặc tả
-- ==========================================================

SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;
SET character_set_client = utf8mb4;
SET character_set_connection = utf8mb4;
SET character_set_results = utf8mb4;

USE pawnest_db;

-- 1. Thêm nhân sự
INSERT INTO staff (id, full_name, role, specialty, photo, is_active) VALUES
(1, 'Nguyễn Thiện Khang', 'doctor', 'Bác sĩ Thú y Trưởng - Chẩn đoán & Phẫu thuật', 'assets/img/staff_khang.jpg', 1),
(2, 'Trần Thị Mai', 'doctor', 'Bác sĩ Thú y - Tiêm phòng & Dinh dưỡng', 'assets/img/staff_mai.jpg', 1),
(3, 'Lê Hoàng Nam', 'groomer', 'Master Groomer - Chuyên tạo kiểu & Massage', 'assets/img/staff_nam.jpg', 1),
(4, 'Phạm Ngọc Trâm', 'receptionist', 'Lễ tân & Điều phối lịch hẹn', 'assets/img/staff_tram.jpg', 1)
ON DUPLICATE KEY UPDATE full_name = VALUES(full_name);

-- 2. Thêm dịch vụ & gói chăm sóc
INSERT INTO services (id, name, description, duration_min, price, is_package, is_active) VALUES
(1, 'Gói Cơ bản – Tắm thơm', 'Tắm & sấy khô dịu êm, cắt móng, vệ sinh tai, xịt thơm thảo mộc tự nhiên.', 45, 150000, 1, 1),
(2, 'Gói Spa & cắt tỉa', 'Toàn bộ gói cơ bản, cắt tỉa tạo kiểu theo phong cách, massage thư giãn, khám sức khỏe tổng quát nhanh.', 90, 320000, 1, 1),
(3, 'Gói Toàn diện', 'Khám tổng quát cùng bác sĩ thú y, 1 mũi tiêm phòng định kỳ, tẩy giun và trọn gói spa cắt tỉa.', 120, 690000, 1, 1),
(4, 'Khám & điều trị thú y', 'Khám lâm sàng, siêu âm, xét nghiệm máu và phác đồ điều trị chuyên khoa.', 45, 200000, 0, 1),
(5, 'Tiêm phòng vắc-xin & tẩy giun', 'Tiêm vắc-xin 5 bệnh/7 bệnh, tiêm phòng dại và tẩy giun định kỳ.', 30, 250000, 0, 1)
ON DUPLICATE KEY UPDATE name = VALUES(name), description = VALUES(description);

-- 3. Thêm tài khoản quản trị (Mật khẩu: admin123)
INSERT INTO users (id, staff_id, username, password_hash, role) VALUES
(1, 1, 'admin', '$2y$10$1/XeZkbPJ3GZmA/Tef/eluRQUYBECeXTuCgWXM5.kfN7HM7yGgu4q', 'admin'),
(2, 4, 'letan', '$2y$10$1/XeZkbPJ3GZmA/Tef/eluRQUYBECeXTuCgWXM5.kfN7HM7yGgu4q', 'receptionist')
ON DUPLICATE KEY UPDATE username = VALUES(username);

-- 4. Thêm khách hàng mẫu
INSERT INTO customers (id, full_name, phone, email, address, consent_at) VALUES
(1, 'Chị Thu Hà', '0912345678', 'thuha@gmail.com', '123 Phan Xích Long, Q. Phú Nhuận', NOW()),
(2, 'Anh Minh Quân', '0923456789', 'minhquan@gmail.com', '45 Lê Văn Sỹ, Q. 3', NOW()),
(3, 'Bạn Ngọc Anh', '0934567890', 'ngocanh@gmail.com', '78 Hoàng Văn Thụ, Q. Tân Bình', NOW())
ON DUPLICATE KEY UPDATE full_name = VALUES(full_name);

-- 5. Thêm thú cưng
INSERT INTO pets (id, customer_id, name, species, breed, birth_date, weight_kg, note) VALUES
(1, 1, 'Bơ', 'Chó', 'Corgi', '2024-05-10', 9.5, 'Sợ sấy lông mạnh, thích xoa đầu'),
(2, 2, 'Mướp', 'Mèo', 'Mèo ta', '2025-02-15', 3.8, 'Ngoan, sợ người lạ'),
(3, 3, 'Mochi', 'Chó', 'Poodle', '2023-11-20', 4.2, 'Cắt kiểu Teddy Bear tròn xoe')
ON DUPLICATE KEY UPDATE name = VALUES(name);

-- 6. Thêm lịch hẹn mẫu
INSERT INTO appointments (id, customer_id, pet_id, service_id, staff_id, start_at, end_at, status, note, source) VALUES
(1, 1, 1, 2, 3, '2026-11-16 09:30:00', '2026-11-16 11:00:00', 'confirmed', 'Cắt tỉa mông trái tim cho Bơ', 'web'),
(2, 2, 2, 3, 1, '2026-11-16 14:00:00', '2026-11-16 16:00:00', 'confirmed', 'Khám định kỳ và tiêm mũi 7 bệnh', 'web'),
(3, 3, 3, 1, 3, '2026-11-17 10:00:00', '2026-11-17 10:45:00', 'pending', 'Tắm thơm chuẩn bị đi tiệc', 'web')
ON DUPLICATE KEY UPDATE status = VALUES(status);

-- 7. Thêm đánh giá khách hàng
INSERT INTO reviews (id, appointment_id, rating, content, status) VALUES
(1, 1, 5, 'Bơ vốn sợ nước nhưng lần này ra về vẫn vẫy đuôi. Bạn groomer rất kiên nhẫn và gửi ảnh cho mình liên tục.', 'approved'),
(2, 2, 5, 'Khám và tiêm phòng cho mèo xong còn tắm luôn trong buổi sáng, đỡ phải đi hai nơi. Bác sĩ giải thích rất rõ ràng.', 'approved')
ON DUPLICATE KEY UPDATE content = VALUES(content);

-- 8. Thêm hàng hóa, thuốc, thức ăn & vật tư thú y
INSERT INTO products (sku, name, category, price, cost_price, stock_quantity, min_stock, unit, image, description, is_critical, status) VALUES
('MED-VAC-01', 'Vaccine Vanguard Plus 5/L (Phòng 5 bệnh chó)', 'medicine', 250000, 150000, 12, 10, 'Liều', 'https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?auto=format&fit=crop&w=600&q=80', 'Vắc xin phòng 5 bệnh nguy hiểm: Parvovirus, Care, Viêm gan, Ho cũi chó, Phó cúm. Cần trữ lạnh 2-8°C.', 1, 'active'),
('MED-VAC-02', 'Vaccine Felocell 4 (Phòng 4 bệnh cho Mèo)', 'medicine', 280000, 170000, 15, 10, 'Liều', 'https://images.unsplash.com/photo-1631815589968-fdb09a223b1e?auto=format&fit=crop&w=600&q=80', 'Phòng bệnh Giảm bạch cầu (FPV), Viêm mũi khí quản, Calicivirus và Chlamydia ở mèo.', 1, 'active'),
('MED-PAR-01', 'Thuốc trị ve rận & ghẻ NexGard Spectra (15-30kg)', 'medicine', 320000, 230000, 3, 8, 'Hộp 3 viên', 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=600&q=80', 'Viên nhai thơm ngon phòng và trị ngoại ký sinh trùng, ve rận, giun tim, ghẻ tai demodex.', 1, 'active'),
('MED-DRON-01', 'Thuốc tẩy giun Drontal Plus Bayer (Chó lớn)', 'medicine', 45000, 28000, 4, 15, 'Viên', 'https://images.unsplash.com/photo-1471864190281-a93a3070b6de?auto=format&fit=crop&w=600&q=80', 'Tẩy sạch giun đũa, giun móc, giun tóc và sán dây. Liều dùng 1 viên / 10kg thể trọng.', 1, 'active'),
('MED-AMOX-01', 'Kháng sinh bột tiêm Amoxicillin Thú Y 100ml', 'medicine', 185000, 120000, 8, 5, 'Lọ', 'https://images.unsplash.com/photo-1587854692152-cbe660dbde88?auto=format&fit=crop&w=600&q=80', 'Kháng sinh phổ rộng điều trị nhiễm khuẩn hô hấp, tiêu hóa, vết thương sau phẫu thuật.', 1, 'active'),
('MED-PRO-01', 'Men vi sinh Pro-Enteric Triplex cho chó mèo', 'medicine', 210000, 140000, 18, 5, 'Tuýp 15ml', 'https://images.unsplash.com/photo-1550572017-ed261e5b1fd9?auto=format&fit=crop&w=600&q=80', 'Hỗ trợ rối loạn tiêu hóa, tiêu chảy cấp, phục hồi hệ vi sinh đường ruột sau kháng sinh.', 0, 'active'),
('FOOD-RC-01', 'Hạt Royal Canin Mini Indoor Adult 1.5kg', 'food', 295000, 220000, 25, 6, 'Gói', 'https://images.unsplash.com/photo-1589924691995-400dc9ecc119?auto=format&fit=crop&w=600&q=80', 'Thức ăn hạt cao cấp cho chó nhỏ nuôi trong nhà, giảm mùi hôi chất thải, đẹp lông.', 0, 'active'),
('FOOD-PATE-01', 'Pate tươi PawNest Tự Nhiên - Cá hồi & Rau củ 150g', 'food', 38000, 22000, 45, 12, 'Hộp', 'https://images.unsplash.com/photo-1548767797-d8c844163c4c?auto=format&fit=crop&w=600&q=80', 'Pate nấu chậm không chất bảo quản, bổ sung Omega-3, Taurine tự nhiên cho chó mèo.', 0, 'active'),
('FOOD-CAT-01', 'Hạt hữu cơ Catsrang All Life Stages 2kg', 'food', 210000, 155000, 14, 5, 'Gói', 'https://images.unsplash.com/photo-1535294435445-d7249524ef2e?auto=format&fit=crop&w=600&q=80', 'Hạt nhập khẩu Hàn Quốc ngăn ngừa búi lông, bảo vệ đường tiết niệu của mèo.', 0, 'active'),
('SUP-GAC-01', 'Gạc y tế tiệt trùng thú y 10x10cm (Bịch 50 miếng)', 'supply', 55000, 32000, 5, 15, 'Bịch', 'https://images.unsplash.com/photo-1583947215259-38e31be8751f?auto=format&fit=crop&w=600&q=80', 'Gạc thấm hút cao vô trùng dùng trong phẫu thuật, rửa vết thương và băng bó.', 1, 'active'),
('SUP-TA-01', 'Tã bỉm lót chuồng kháng khuẩn siêu thấm (Size M - 50 miếng)', 'supply', 165000, 110000, 22, 8, 'Bịch', 'https://images.unsplash.com/photo-1583337130417-3346a1be7dee?auto=format&fit=crop&w=600&q=80', 'Khóa mùi 24h, bề mặt khô thoáng cho thú cưng nằm viện hoặc sau phẫu thuật.', 0, 'active'),
('SUP-ELIZ-01', 'Loa chống liếm Elizabeth đệm vải êm ái (Size 2)', 'supply', 75000, 40000, 9, 6, 'Cái', 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=600&q=80', 'Chống thú cưng gãi tai, liếm vết mổ hoặc vết nấm da, viền bọc vải mềm không đau cổ.', 0, 'active'),
('ACC-CAT-01', 'Nhà cây cho mèo Cozy Cat House 2 tầng', 'accessory', 1250000, 850000, 7, 3, 'Bộ', 'https://polo-pecan-73837341.figma.site/_assets/v11/3e5158dad63d392ade022e81890edc9f54d750bc.png', 'Nhà cào móng nhung cam CozyPaws thiết kế công thái học, trụ quấn dây thừng tự nhiên.', 0, 'active')
ON DUPLICATE KEY UPDATE name = VALUES(name);

INSERT INTO inventory_logs (product_id, change_type, quantity, stock_before, stock_after, note, created_by)
SELECT id, 'import', stock_quantity, 0, stock_quantity, 'Nhập kho ban đầu khai trương cơ sở', 'Hệ thống'
FROM products
WHERE NOT EXISTS (SELECT 1 FROM inventory_logs WHERE inventory_logs.product_id = products.id);
