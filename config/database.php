<?php
/**
 * PawNest & CozyPaws - Cấu hình & Kết nối Cơ sở Dữ liệu MySQL (Database Config)
 * Sử dụng PDO Prepared Statements để chống SQL Injection
 */

declare(strict_types=1);

require_once __DIR__ . '/app.php';

// Tham số kết nối MySQL (Đọc từ biến môi trường hoặc mặc định cục bộ)
if (!defined('DB_HOST')) define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
if (!defined('DB_PORT')) define('DB_PORT', getenv('DB_PORT') ?: '3306');
if (!defined('DB_NAME')) define('DB_NAME', getenv('DB_NAME') ?: 'pawnest_db');
if (!defined('DB_USER')) define('DB_USER', getenv('DB_USER') ?: 'root');
if (!defined('DB_PASS')) define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');

class Database {
    private static ?PDO $instance = null;

    private function __construct() {}
    private function __clone() {}

    /**
     * Lấy kết nối PDO duy nhất (Singleton Pattern)
     */
    public static function getConnection(): PDO {
        if (self::$instance === null) {
            $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', DB_HOST, DB_PORT, DB_NAME);
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
            ];

            try {
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
            } catch (PDOException $e) {
                // Trả thông báo lỗi an toàn, không lộ credentials
                http_response_code(500);
                if (str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json')) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Lỗi kết nối cơ sở dữ liệu MySQL: ' . $e->getMessage()
                    ], JSON_UNESCAPED_UNICODE);
                } else {
                    echo '<div style="font-family:sans-serif;padding:24px;background:#FEF2F2;border:1px solid #FCA5A5;color:#991B1B;border-radius:12px;margin:20px;">'
                       . '<h3>Lỗi kết nối cơ sở dữ liệu MySQL</h3>'
                       . '<p>' . htmlspecialchars($e->getMessage()) . '</p>'
                       . '</div>';
                }
                exit;
            }
        }

        return self::$instance;
    }
}

// Khởi tạo biến $pdo dùng chung
try {
    $pdo = Database::getConnection();
} catch (Throwable $e) {
    $pdo = null;
}
