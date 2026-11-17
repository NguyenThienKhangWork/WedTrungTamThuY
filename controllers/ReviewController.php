<?php
/**
 * PawNest & CozyPaws - Controller: ReviewController
 * Điều phối dữ liệu đánh giá và cảm nhận của khách hàng
 */

declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../repository/ReviewRepository.php';

class ReviewController {
    private ReviewRepository $reviewRepo;

    public function __construct() {
        $this->reviewRepo = new ReviewRepository();
    }

    /**
     * Xử lý request API đánh giá (/api/reviews.php)
     */
    public function handleApiRequest(): void {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');

        $reviews = $this->reviewRepo->findApproved();
        echo json_encode([
            'success' => true,
            'reviews' => $reviews
        ], JSON_UNESCAPED_UNICODE);
    }

    public function getApprovedReviews(): array {
        return $this->reviewRepo->findApproved();
    }
}
