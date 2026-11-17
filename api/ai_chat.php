<?php
/**
 * API: api/ai_chat.php
 * Endpoint Trợ lý AI Bác sĩ Thú y PawBot kết nối OpenRouter API
 */

declare(strict_types=1);

require_once __DIR__ . '/../controllers/AIController.php';

$controller = new AIController();
$controller->handleChatRequest();
