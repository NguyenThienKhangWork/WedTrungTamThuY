<?php
/**
 * PawNest & CozyPaws - Lớp Kết nối Cơ sở Dữ liệu PDO (Database)
 * Thực hiện theo mô hình Singleton, sử dụng PDO prepared statements để chống SQL Injection
 */

declare(strict_types=1);

require_once __DIR__ . '/config.php';

class Database {
    private static ?PDO $instance = null;

    private function __construct() {}
    private function __clone() {}

    /**
     * Lấy kết nối PDO duy nhất
     * @return PDO
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
                // Trả thông báo lỗi thân thiện, không lộ thông tin đăng nhập
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Lỗi kết nối cơ sở dữ liệu MySQL: ' . $e->getMessage()
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }
        }

        return self::$instance;
    }
}

// Tạo biến $pdo toàn cục để dùng trực tiếp trong các file PHP
// (thay vì phải gọi Database::getConnection() ở mọi nơi)
try {
    $pdo = Database::getConnection();
} catch (Throwable $e) {
    $pdo = null;
}
