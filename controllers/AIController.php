<?php
/**
 * PawNest & CozyPaws - Controller: AIController
 * Điều phối trợ lý ảo Bác sĩ Thú y PawBot qua OpenRouter API
 */

declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';

class AIController {
    /**
     * Xử lý request trò chuyện AI (/api/ai_chat.php)
     */
    public function handleChatRequest(): void {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Phương thức không được hỗ trợ.'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $raw = file_get_contents('php://input');
        $input = json_decode($raw, true) ?: $_POST;

        $userMessage = trim($input['message'] ?? '');
        $history = $input['history'] ?? [];

        if ($userMessage === '') {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Vui lòng nhập câu hỏi của bạn.'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Giới hạn độ dài lịch sử hội thoại (6 tin gần nhất để tiết kiệm token)
        $recentHistory = [];
        if (is_array($history)) {
            $slice = array_slice($history, -6);
            foreach ($slice as $msg) {
                if (!empty($msg['role']) && !empty($msg['content']) && in_array($msg['role'], ['user', 'assistant'], true)) {
                    $recentHistory[] = [
                        'role' => $msg['role'],
                        'content' => (string)$msg['content']
                    ];
                }
            }
        }

        $systemPrompt = <<<PROMPT
Bạn là PawBot – Trợ lý AI Bác sĩ Thú Y thông minh và tận tâm của Trung tâm Thú Y & Spa Cao Cấp PawNest (phụ trách chuyên môn bởi Bác sĩ Thú y Nguyễn Thiện Khang, tốt nghiệp ĐH Nông Lâm TP.HCM, 5+ năm kinh nghiệm).

Thông tin trung tâm:
- Địa chỉ: 123 Đường Hoa Cúc, Phường 7, Q. Phú Nhuận, TP. Hồ Chí Minh.
- Giờ làm việc: 08:00 – 20:00 hằng ngày. Hotline cấp cứu 24/7: 0900 123 456.
- Website: Đặt lịch khám tại /dat-lich.php, mua thức ăn & thuốc tại /cua-hang.php.

Dịch vụ & Bảng giá tại phòng khám:
1. Gói Cơ bản (Tắm thảo mộc, sấy thơm, vệ sinh tai kẽ chân): 150.000 ₫
2. Gói Spa & cắt tỉa tạo kiểu nghệ thuật (Teddy, búp bê): 320.000 ₫ (bán chạy nhất)
3. Gói Toàn diện (Khám tổng quát + Tiêm phòng + Trọn gói Spa): 690.000 ₫
4. Khám lâm sàng & chẩn đoán: 200.000 ₫
5. Tiêm vắc xin 5 bệnh chó (Vanguard Plus): 250.000 ₫ / liều
6. Tiêm vắc xin 4 bệnh mèo (Felocell 4): 280.000 ₫ / liều
7. Thuốc trị ve rận NexGard Spectra: 320.000 ₫, Tẩy giun Drontal Plus: 45.000 ₫/viên
8. Thức ăn: Hạt Royal Canin Mini 1.5kg (295k), Hạt hữu cơ Catsrang 2kg (210k), Pate tươi PawNest cá hồi bí đỏ (38k/hộp).
9. Nhà cào móng nhung cam Cozy Cat House 2 tầng: 1.250.000 ₫ ($49.99).

Nhiệm vụ của bạn:
1. Tư vấn sức khỏe thú cưng chuẩn y khoa: triệu chứng sốt, nôn mửa, rụng lông, ve rận, tiêu chảy, lịch tiêm phòng, tẩy giun, chế độ ăn dặm.
2. Giới thiệu dịch vụ và báo giá minh bạch.
3. Nếu bé có dấu hiệu nguy kịch (co giật, khó thở, hôn mê, nôn máu, sốc nhiệt), BẮT BUỘC khuyên chủ nuôi gọi ngay Hotline cấp cứu 0900 123 456 hoặc đưa bé tới ngay phòng khám.
4. Giọng điệu: Thân thiện, ấm áp, yêu thương động vật, xưng "Em PawBot" hoặc "PawNest", gọi khách là "bạn" hoặc "ba mẹ của bé", sử dụng emoji thú cưng (🐾🐶🐱✨🩺). Trả lời ngắn gọn, rõ ràng, dễ hiểu.
PROMPT;

        $messages = [
            ['role' => 'system', 'content' => $systemPrompt]
        ];

        foreach ($recentHistory as $h) {
            $messages[] = $h;
        }
        $messages[] = ['role' => 'user', 'content' => $userMessage];

        // 1. Thử gọi mô hình chính (DeepSeek Chat)
        $reply = $this->callOpenRouter(OPENROUTER_MODEL, $messages, OPENROUTER_API_KEY);

        // 2. Dự phòng mô hình Meta Llama 3.3 70B
        if (!$reply) {
            $reply = $this->callOpenRouter(OPENROUTER_FALLBACK_MODEL, $messages, OPENROUTER_API_KEY);
        }

        // 3. Phản hồi kết quả
        if ($reply) {
            echo json_encode([
                'success' => true,
                'reply'   => $reply,
                'model'   => OPENROUTER_MODEL
            ], JSON_UNESCAPED_UNICODE);
        } else {
            $fallbackReply = "Dạ chào bạn! Hiện tại em PawBot đang bận kết nối hệ thống y khoa một chút. Bạn có thể gọi trực tiếp Hotline Bác sĩ Khang: **0900 123 456** hoặc bấm nút Đặt lịch trên web để phòng khám hỗ trợ bạn ngay nhé! 🐾";
            echo json_encode([
                'success'  => true,
                'reply'    => $fallbackReply,
                'fallback' => true
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    private function callOpenRouter(string $model, array $messages, string $apiKey): ?string {
        if (empty($apiKey)) {
            return null;
        }

        $url = 'https://openrouter.ai/api/v1/chat/completions';
        $payload = json_encode([
            'model'       => $model,
            'messages'    => $messages,
            'temperature' => 0.7,
            'max_tokens'  => 800
        ], JSON_UNESCAPED_UNICODE);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $payload,
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . $apiKey,
                'HTTP-Referer: http://localhost:8080/',
                'X-Title: PawNest Pet Clinic AI',
                'Content-Type: application/json; charset=utf-8'
            ],
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_SSL_VERIFYPEER => false
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response && $httpCode === 200) {
            $data = json_decode($response, true);
            if (!empty($data['choices'][0]['message']['content'])) {
                return trim($data['choices'][0]['message']['content']);
            }
        }

        return null;
    }
}
