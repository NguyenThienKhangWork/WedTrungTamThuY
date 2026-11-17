<?php
/**
 * API: api/reviews.php
 * Trả về danh sách cảm nhận và đánh giá của khách hàng
 */

declare(strict_types=1);

require_once __DIR__ . '/../controllers/ReviewController.php';

$controller = new ReviewController();
$controller->handleApiRequest();
