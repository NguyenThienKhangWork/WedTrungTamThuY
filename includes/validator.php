<?php
/**
 * PawNest & CozyPaws - Lớp Kiểm tra Dữ liệu (Validator)
 * Kiểm tra các trường dữ liệu bắt buộc, định dạng số điện thoại, ngày hẹn, chống XSS
 */

declare(strict_types=1);

class Validator {
    /**
     * Kiểm tra trường bắt buộc không được rỗng
     */
    public static function required(?string $value): bool {
        return $value !== null && trim($value) !== '';
    }

    /**
     * Kiểm tra số điện thoại: đủ 10 số, bắt đầu bằng số 0 theo quy định Việt Nam
     */
    public static function phone(?string $value): bool {
        if ($value === null) return false;
        $clean = preg_replace('/\s+/', '', $value);
        return (bool)preg_match('/^0\d{9}$/', $clean);
    }

    /**
     * Kiểm tra ngày hẹn không được nằm trong quá khứ
     */
    public static function futureDate(?string $value): bool {
        if ($value === null) return false;
        $target = strtotime($value);
        if ($target === false) return false;
        $today = strtotime(date('Y-m-d'));
        return $target >= $today;
    }

    /**
     * Làm sạch chuỗi hiển thị chống XSS
     */
    public static function escape(?string $text): string {
        return htmlspecialchars($text ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
