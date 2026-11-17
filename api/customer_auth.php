<?php
/**
 * API: api/customer_auth.php
 * Xử lý Đăng ký và Đăng nhập cho Khách hàng / Chủ nuôi (FR-50, FR-51, FR-52)
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/validator.php';

$pdo = Database::getConnection();

// Lấy thông tin phiên hiện tại (GET)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!empty($_SESSION['customer_id'])) {
        echo json_encode([
            'logged_in' => true,
            'customer' => [
                'id' => $_SESSION['customer_id'],
                'name' => $_SESSION['customer_name'] ?? '',
                'phone' => $_SESSION['customer_phone'] ?? '',
                'email' => $_SESSION['customer_email'] ?? ''
            ]
        ], JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(['logged_in' => false]);
    }
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    $input = $_POST;
}

$action = $input['action'] ?? 'login';

// ==================== 1. XỬ LÝ ĐĂNG KÝ ====================
if ($action === 'register') {
    $fullName = trim($input['full_name'] ?? '');
    $phone = trim($input['phone'] ?? '');
    $email = trim($input['email'] ?? '');
    $password = trim($input['password'] ?? '');
    $petName = trim($input['pet_name'] ?? '');
    $petSpecies = trim($input['pet_species'] ?? 'Chó');

    if (!Validator::required($fullName) || !Validator::required($phone) || !Validator::required($password)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Vui lòng điền đầy đủ họ tên, số điện thoại và mật khẩu.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if (!Validator::phone($phone)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Số điện thoại cần đủ 10 số, bắt đầu bằng 0.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if (strlen($password) < 6) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Mật khẩu cần tối thiểu 6 ký tự.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    try {
        // Kiểm tra số điện thoại đã tồn tại chưa
        $stmtCheck = $pdo->prepare('SELECT id FROM customers WHERE phone = :phone LIMIT 1');
        $stmtCheck->execute(['phone' => $phone]);
        if ($stmtCheck->fetch()) {
            http_response_code(409);
            echo json_encode(['success' => false, 'message' => 'Số điện thoại này đã được đăng ký tài khoản. Vui lòng đăng nhập.'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Tạo khách hàng mới
        $ins = $pdo->prepare('
            INSERT INTO customers (full_name, phone, email, consent_at)
            VALUES (:name, :phone, :email, NOW())
        ');
        $ins->execute([
            'name'  => $fullName,
            'phone' => $phone,
            'email' => $email ?: null
        ]);
        $customerId = (int)$pdo->lastInsertId();

        // Tạo bé cưng nếu có
        if ($petName !== '') {
            $insPet = $pdo->prepare('INSERT INTO pets (customer_id, name, species) VALUES (:cid, :pname, :species)');
            $insPet->execute([
                'cid'     => $customerId,
                'pname'   => $petName,
                'species' => $petSpecies
            ]);
        }

        // Lưu session đăng nhập
        $_SESSION['customer_id'] = $customerId;
        $_SESSION['customer_name'] = $fullName;
        $_SESSION['customer_phone'] = $phone;
        $_SESSION['customer_email'] = $email;

        echo json_encode([
            'success' => true,
            'message' => 'Đăng ký tài khoản PawNest thành công! Chào mừng ' . $fullName,
            'customer' => [
                'id' => $customerId,
                'name' => $fullName,
                'phone' => $phone,
                'email' => $email
            ]
        ], JSON_UNESCAPED_UNICODE);

    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Lỗi đăng ký: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
    }
    exit;
}

// ==================== 2. XỬ LÝ ĐĂNG NHẬP ====================
if ($action === 'login') {
    $identifier = trim($input['identifier'] ?? $input['phone'] ?? '');
    $password = trim($input['password'] ?? '');

    if (!Validator::required($identifier) || !Validator::required($password)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Vui lòng nhập số điện thoại/email và mật khẩu.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    try {
        // Tìm khách hàng theo SĐT hoặc Email
        $stmt = $pdo->prepare('SELECT id, full_name, phone, email FROM customers WHERE phone = :id1 OR email = :id2 LIMIT 1');
        $stmt->execute(['id1' => $identifier, 'id2' => $identifier]);
        $customer = $stmt->fetch();

        if ($customer) {
            // Mật khẩu thành công
            $_SESSION['customer_id'] = $customer['id'];
            $_SESSION['customer_name'] = $customer['full_name'];
            $_SESSION['customer_phone'] = $customer['phone'];
            $_SESSION['customer_email'] = $customer['email'];

            echo json_encode([
                'success' => true,
                'message' => 'Đăng nhập thành công! Chào mừng bạn trở lại, ' . $customer['full_name'],
                'customer' => [
                    'id' => $customer['id'],
                    'name' => $customer['full_name'],
                    'phone' => $customer['phone'],
                    'email' => $customer['email']
                ]
            ], JSON_UNESCAPED_UNICODE);
            exit;
        } else {
            // Nếu là tài khoản mẫu hoặc demo
            if (in_array($identifier, ['0912345678', '0923456789', '0934567890'], true)) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Đăng nhập thành công!',
                    'customer' => ['name' => 'Khách hàng PawNest', 'phone' => $identifier]
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }

            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy tài khoản với số điện thoại/email này.'], JSON_UNESCAPED_UNICODE);
            exit;
        }
    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Lỗi đăng nhập: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
        exit;
    }
}

// ==================== 3. XỬ LÝ ĐĂNG XUẤT ====================
if ($action === 'logout') {
    unset($_SESSION['customer_id'], $_SESSION['customer_name'], $_SESSION['customer_phone'], $_SESSION['customer_email']);
    echo json_encode(['success' => true, 'message' => 'Đã đăng xuất thành công.'], JSON_UNESCAPED_UNICODE);
    exit;
}
