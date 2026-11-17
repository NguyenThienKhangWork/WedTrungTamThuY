<?php
/**
 * PawNest & CozyPaws - Controller: AuthController
 * Xử lý xác thực đăng ký / đăng nhập / đăng xuất cho cả Khách hàng và Quản trị viên
 */

declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/validator.php';

class AuthController {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    /**
     * Xử lý API khách hàng (/api/customer_auth.php)
     */
    public function handleCustomerApiRequest(): void {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        // Lấy thông tin phiên hiện tại (GET)
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (!empty($_SESSION['customer_id'])) {
                echo json_encode([
                    'logged_in' => true,
                    'customer' => [
                        'id'    => $_SESSION['customer_id'],
                        'name'  => $_SESSION['customer_name'] ?? '',
                        'phone' => $_SESSION['customer_phone'] ?? '',
                        'email' => $_SESSION['customer_email'] ?? ''
                    ]
                ], JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(['logged_in' => false]);
            }
            exit;
        }

        $raw = file_get_contents('php://input') ?: '';
        // Loại bỏ UTF-8 BOM và khoảng trắng thừa nếu có
        $rawClean = preg_replace('/^\xEF\xBB\xBF/', '', trim($raw));
        $input = json_decode($rawClean, true);
        if (!is_array($input)) {
            $input = $_POST;
        }

        $action = $input['action'] ?? 'login';

        // 1. Đăng ký khách hàng
        if ($action === 'register') {
            $this->customerRegister($input);
            return;
        }

        // 2. Đăng xuất
        if ($action === 'logout') {
            unset($_SESSION['customer_id'], $_SESSION['customer_name'], $_SESSION['customer_phone'], $_SESSION['customer_email']);
            echo json_encode(['success' => true, 'message' => 'Đã đăng xuất thành công.']);
            return;
        }

        // 3. Đăng nhập
        $this->customerLogin($input);
    }

    private function customerRegister(array $input): void {
        $fullName = trim($input['full_name'] ?? '');
        $phone = trim($input['phone'] ?? '');
        $email = trim($input['email'] ?? '');
        $password = trim($input['password'] ?? '');
        $petName = trim($input['pet_name'] ?? '');
        $petSpecies = trim($input['pet_species'] ?? 'Chó');

        $phone = preg_replace('/\s+/', '', $phone);
        if (str_starts_with($phone, '+84')) {
            $phone = '0' . substr($phone, 3);
        }

        if (!Validator::required($fullName) || !Validator::required($phone) || !Validator::required($password)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Vui lòng điền đầy đủ họ tên, số điện thoại và mật khẩu.'], JSON_UNESCAPED_UNICODE);
            return;
        }

        if (!Validator::phone($phone)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Số điện thoại không hợp lệ (cần 10 số, bắt đầu bằng 0).'], JSON_UNESCAPED_UNICODE);
            return;
        }

        if (strlen($password) < 6) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Mật khẩu cần tối thiểu 6 ký tự.'], JSON_UNESCAPED_UNICODE);
            return;
        }

        try {
            // Kiểm tra số điện thoại đã tồn tại
            $checkStmt = $this->pdo->prepare('SELECT id FROM customers WHERE phone = :phone LIMIT 1');
            $checkStmt->execute(['phone' => $phone]);
            if ($checkStmt->fetch()) {
                http_response_code(409);
                echo json_encode(['success' => false, 'message' => 'Số điện thoại này đã được đăng ký trên hệ thống. Vui lòng đăng nhập.'], JSON_UNESCAPED_UNICODE);
                return;
            }

            $hash = password_hash($password, PASSWORD_BCRYPT);
            $ins = $this->pdo->prepare('
                INSERT INTO customers (full_name, phone, email, password_hash, consent_at)
                VALUES (:name, :phone, :email, :hash, NOW())
            ');
            $ins->execute([
                'name'  => $fullName,
                'phone' => $phone,
                'email' => $email ?: null,
                'hash'  => $hash
            ]);
            $newId = (int)$this->pdo->lastInsertId();

            // Tạo hồ sơ thú cưng nếu có
            if ($petName !== '') {
                $insPet = $this->pdo->prepare('INSERT INTO pets (customer_id, name, species) VALUES (:cid, :pname, :species)');
                $insPet->execute(['cid' => $newId, 'pname' => $petName, 'species' => $petSpecies]);
            }

            // Thiết lập Session
            $_SESSION['customer_id'] = $newId;
            $_SESSION['customer_name'] = $fullName;
            $_SESSION['customer_phone'] = $phone;
            $_SESSION['customer_email'] = $email;

            echo json_encode([
                'success' => true,
                'message' => 'Đăng ký tài khoản thành viên thành công! Chào mừng ' . $fullName . ' đến với PawNest.',
                'customer' => ['id' => $newId, 'name' => $fullName, 'phone' => $phone, 'email' => $email]
            ], JSON_UNESCAPED_UNICODE);
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Lỗi máy chủ khi đăng ký: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
        }
    }

    private function customerLogin(array $input): void {
        $identifier = trim($input['identifier'] ?? $input['phone'] ?? $input['email'] ?? '');
        $password = trim($input['password'] ?? '');

        if (!$identifier || !$password) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Vui lòng nhập số điện thoại hoặc email và mật khẩu.'], JSON_UNESCAPED_UNICODE);
            return;
        }

        // Chuẩn hóa nếu là số điện thoại
        $cleanPhone = preg_replace('/\s+/', '', $identifier);
        if (str_starts_with($cleanPhone, '+84')) {
            $cleanPhone = '0' . substr($cleanPhone, 3);
        }

        try {
            $stmt = $this->pdo->prepare('SELECT id, full_name, phone, email, password_hash FROM customers WHERE phone = :id1 OR phone = :id2 OR email = :id3 LIMIT 1');
            $stmt->execute(['id1' => $identifier, 'id2' => $cleanPhone, 'id3' => $identifier]);
            $customer = $stmt->fetch();

            // Hỗ trợ đăng nhập tài khoản mẫu demo nếu chưa có trong DB
            if (!$customer && in_array($cleanPhone, ['0912345678', '0923456789', '0934567890'], true)) {
                $demoNames = [
                    '0912345678' => 'Chị Thu Hà',
                    '0923456789' => 'Anh Minh Quân',
                    '0934567890' => 'Bạn Ngọc Anh'
                ];
                $name = $demoNames[$cleanPhone] ?? 'Khách hàng PawNest';
                $hash = password_hash($password, PASSWORD_BCRYPT);
                $ins = $this->pdo->prepare('INSERT INTO customers (full_name, phone, password_hash, consent_at) VALUES (:name, :phone, :hash, NOW())');
                $ins->execute(['name' => $name, 'phone' => $cleanPhone, 'hash' => $hash]);
                $cid = (int)$this->pdo->lastInsertId();
                $customer = ['id' => $cid, 'full_name' => $name, 'phone' => $cleanPhone, 'email' => '', 'password_hash' => $hash];
            }

            if (!$customer) {
                http_response_code(401);
                echo json_encode(['success' => false, 'message' => 'Không tìm thấy tài khoản với số điện thoại hoặc email này.'], JSON_UNESCAPED_UNICODE);
                return;
            }

            // Kiểm tra mật khẩu (nếu chưa có mật khẩu từ trước, gán mật khẩu vừa nhập)
            $valid = false;
            if (!empty($customer['password_hash'])) {
                $valid = password_verify($password, $customer['password_hash']);
            } else {
                $hash = password_hash($password, PASSWORD_BCRYPT);
                $upd = $this->pdo->prepare('UPDATE customers SET password_hash = :hash WHERE id = :id');
                $upd->execute(['hash' => $hash, 'id' => $customer['id']]);
                $valid = true;
            }

            if (!$valid) {
                http_response_code(401);
                echo json_encode(['success' => false, 'message' => 'Mật khẩu không chính xác.'], JSON_UNESCAPED_UNICODE);
                return;
            }

            $_SESSION['customer_id'] = (int)$customer['id'];
            $_SESSION['customer_name'] = $customer['full_name'];
            $_SESSION['customer_phone'] = $customer['phone'];
            $_SESSION['customer_email'] = $customer['email'] ?? '';

            echo json_encode([
                'success' => true,
                'message' => 'Đăng nhập thành công! Chào mừng ' . $customer['full_name'],
                'customer' => [
                    'id'    => (int)$customer['id'],
                    'name'  => $customer['full_name'],
                    'phone' => $customer['phone'],
                    'email' => $customer['email'] ?? ''
                ]
            ], JSON_UNESCAPED_UNICODE);

        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Xác thực đăng nhập trang quản trị (Admin / Lễ tân)
     */
    public function adminLogin(string $username, string $password): ?array {
        $stmt = $this->pdo->prepare('
            SELECT u.id, u.username, u.password_hash, u.role, u.is_active, s.full_name
            FROM users u
            LEFT JOIN staff s ON u.staff_id = s.id
            WHERE u.username = :uname AND u.is_active = 1
            LIMIT 1
        ');
        $stmt->execute(['uname' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = (int)$user['id'];
            $_SESSION['user_name'] = $user['username'];
            $_SESSION['user_fullname'] = $user['full_name'] ?? $user['username'];
            $_SESSION['user_role'] = $user['role'];
            return $user;
        }

        return null;
    }

    /**
     * Đăng xuất trang quản trị
     */
    public function adminLogout(): void {
        unset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_fullname'], $_SESSION['user_role']);
    }
}
