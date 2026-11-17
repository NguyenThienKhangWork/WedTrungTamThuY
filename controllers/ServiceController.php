<?php
/**
 * PawNest & CozyPaws - Controller: ServiceController
 * Điều phối dữ liệu danh sách dịch vụ và bảng giá
 */

declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../repository/ServiceRepository.php';

class ServiceController {
    private ServiceRepository $serviceRepo;

    public function __construct() {
        $this->serviceRepo = new ServiceRepository();
    }

    /**
     * Xử lý request API dịch vụ (/api/services.php)
     */
    public function handleApiRequest(): void {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');

        $services = $this->serviceRepo->findActive();
        echo json_encode([
            'success'  => true,
            'services' => $services
        ], JSON_UNESCAPED_UNICODE);
    }

    public function getAllActive(): array {
        return $this->serviceRepo->findActive();
    }
}
