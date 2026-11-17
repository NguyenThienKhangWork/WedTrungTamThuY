<?php
/**
 * PawNest - Các hàm tiện ích dùng chung (Helper Functions)
 * Tuân thủ yêu cầu bảo mật mục 5.5 và quy ước code sạch mục 5.6
 */

declare(strict_types=1);

require_once __DIR__ . '/config.php';

/**
 * Thoát ký tự đặc biệt HTML chống tấn công XSS
 *
 * @param mixed $value
 * @return string
 */
function e(mixed $value): string
{
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}

/**
 * Định dạng tiền tệ VND chuẩn Việt Nam (VD: 150.000 ₫)
 *
 * @param float|int|string $amount
 * @return string
 */
function format_currency(float|int|string $amount): string
{
    $val = (float)$amount;
    return number_format($val, 0, ',', '.') . ' ₫';
}

/**
 * Định dạng ngày theo chuẩn DD/MM/YYYY (mục 1.4)
 *
 * @param string $datetime
 * @return string
 */
function format_date(string $datetime): string
{
    if (empty($datetime)) return '';
    $timestamp = strtotime($datetime);
    return $timestamp ? date('d/m/Y', $timestamp) : $datetime;
}

/**
 * Định dạng ngày giờ theo chuẩn HH:ii DD/MM/YYYY
 *
 * @param string $datetime
 * @return string
 */
function format_datetime(string $datetime): string
{
    if (empty($datetime)) return '';
    $timestamp = strtotime($datetime);
    return $timestamp ? date('H:i d/m/Y', $timestamp) : $datetime;
}

/**
 * Tạo hoặc lấy token CSRF bảo vệ form POST
 *
 * @return string
 */
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Xác thực token CSRF gửi từ form
 *
 * @param string|null $token
 * @return bool
 */
function verify_csrf(?string $token): bool
{
    if (empty($token) || empty($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Trả về phản hồi JSON chuẩn cho API
 *
 * @param mixed $data
 * @param int $statusCode
 * @return void
 */
function json_response(mixed $data, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}
