<?php
/**
 * PawNest & CozyPaws - File Cấu hình Hệ thống
 * Chứa thông số kết nối cơ sở dữ liệu MySQL và các hằng số ứng dụng
 */

declare(strict_types=1);

// Bật hiển thị lỗi khi phát triển (tắt khi triển khai production)
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Cấu hình múi giờ Việt Nam GMT+7 theo đặc tả
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Thiết lập mã hóa UTF-8 cho tất cả phản hồi HTTP
if (!headers_sent()) {
    header('Content-Type: text/html; charset=utf-8');
}

// Cấu hình Database MySQL (mặc định XAMPP / Laragon: root, không mật khẩu)
define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_PORT', getenv('DB_PORT') ?: '3306');
define('DB_NAME', getenv('DB_NAME') ?: 'pawnest_db');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');

// Thông tin trung tâm thú y (Tiêu chí 3 & 10)
define('CENTER_NAME', 'PawNest – Trung tâm thú y & spa thú cưng');
define('CENTER_DIRECTOR', 'Nguyễn Thiện Khang');
define('CENTER_ADDRESS', '123 Đường Hoa Cúc, Phường 7, Q. Phú Nhuận, TP. Hồ Chí Minh');
define('CENTER_PHONE', '0900 123 456');
define('CENTER_HOTLINE', '0900 123 456');
define('CENTER_EMAIL', 'thienkhang.pawnest@gmail.com');
define('CENTER_HOURS', 'Thứ 2 – Chủ nhật: 08:00 – 20:00 (Cấp cứu 24/7)');

// Nạp cấu hình bảo mật cục bộ nếu có (chứa API Key, được .gitignore bảo vệ)
$localConfig = __DIR__ . '/config.local.php';
if (file_exists($localConfig)) {
    require_once $localConfig;
}

// Cấu hình Trợ lý AI OpenRouter (PawBot Thú Y)
if (!defined('OPENROUTER_API_KEY')) {
    define('OPENROUTER_API_KEY', getenv('OPENROUTER_API_KEY') ?: '');
}
define('OPENROUTER_MODEL', 'deepseek/deepseek-chat');
define('OPENROUTER_FALLBACK_MODEL', 'meta-llama/llama-3.3-70b-instruct');

// Cấu hình bảo mật Session
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 86400 * 7,
        'path'     => '/',
        'domain'   => '',
        'secure'   => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}
