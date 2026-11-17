<?php
/**
 * PawNest & CozyPaws - Cấu hình Hệ thống (System Application Config)
 * Chứa các thông số cấu hình chung, thông tin phòng khám, bảo mật session
 */

declare(strict_types=1);

// Hiển thị lỗi phục vụ môi trường phát triển
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Cấu hình múi giờ Việt Nam GMT+7 theo đặc tả
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Thiết lập mã hóa UTF-8 cho tất cả phản hồi HTTP
if (!headers_sent()) {
    header('Content-Type: text/html; charset=utf-8');
}

// Thông tin trung tâm thú y (Tiêu chí 3 & 10)
if (!defined('CENTER_NAME')) define('CENTER_NAME', 'PawNest – Trung tâm thú y & spa thú cưng');
if (!defined('CENTER_DIRECTOR')) define('CENTER_DIRECTOR', 'Nguyễn Thiện Khang');
if (!defined('CENTER_ADDRESS')) define('CENTER_ADDRESS', '123 Đường Hoa Cúc, Phường 7, Q. Phú Nhuận, TP. Hồ Chí Minh');
if (!defined('CENTER_PHONE')) define('CENTER_PHONE', '0900 123 456');
if (!defined('CENTER_HOTLINE')) define('CENTER_HOTLINE', '0900 123 456');
if (!defined('CENTER_EMAIL')) define('CENTER_EMAIL', 'thienkhang.pawnest@gmail.com');
if (!defined('CENTER_HOURS')) define('CENTER_HOURS', 'Thứ 2 – Chủ nhật: 08:00 – 20:00 (Cấp cứu 24/7)');

// Nạp cấu hình bảo mật cục bộ nếu có (chứa API Key OpenRouter, được .gitignore bảo vệ)
$localConfig = __DIR__ . '/config.local.php';
if (file_exists($localConfig)) {
    require_once $localConfig;
}

// Cấu hình Trợ lý AI OpenRouter (PawBot Thú Y)
if (!defined('OPENROUTER_API_KEY')) {
    define('OPENROUTER_API_KEY', getenv('OPENROUTER_API_KEY') ?: '');
}
if (!defined('OPENROUTER_MODEL')) define('OPENROUTER_MODEL', 'deepseek/deepseek-chat');
if (!defined('OPENROUTER_FALLBACK_MODEL')) define('OPENROUTER_FALLBACK_MODEL', 'meta-llama/llama-3.3-70b-instruct');

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
