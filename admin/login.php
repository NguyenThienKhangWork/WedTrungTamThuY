<?php
/**
 * PawNest & CozyPaws - Trang Đăng nhập Quản trị (Admin Login)
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/auth.php';

$message = '';
$error = '';

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    Auth::logout();
    $message = 'Bạn đã đăng xuất khỏi hệ thống thành công.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (Auth::login($username, $password)) {
        header('Location: /admin/dashboard.php');
        exit;
    } else {
        $error = 'Tài khoản hoặc mật khẩu không chính xác.';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng nhập Quản trị – PawNest & CozyPaws</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Nunito', sans-serif; background-color: #EFFDF0; }
    h1, h2, h3, .font-serif-display { font-family: 'Baloo 2', cursive, sans-serif; }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
  <div class="bg-white p-8 rounded-3xl shadow-xl w-full max-w-md border border-[#1a3d1a]/10">
    <div class="text-center mb-6">
      <h1 class="text-3xl font-serif-display text-[#1a3d1a]">PawNest Admin</h1>
      <p class="text-gray-500 text-xs mt-1">Đăng nhập hệ thống quản lý lịch hẹn và dịch vụ thú y</p>
    </div>

    <?php if ($message): ?>
      <div class="p-3 mb-4 rounded-xl bg-green-50 text-green-700 text-xs border border-green-200">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>

    <?php if ($error): ?>
      <div class="p-3 mb-4 rounded-xl bg-red-50 text-red-600 text-xs border border-red-200">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
      <div>
        <label class="block text-xs font-semibold text-gray-700 mb-1">Tài khoản</label>
        <input type="text" name="username" placeholder="admin" required
          class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#1a3d1a] focus:outline-none">
      </div>
      <div>
        <label class="block text-xs font-semibold text-gray-700 mb-1">Mật khẩu</label>
        <input type="password" name="password" placeholder="••••••••" required
          class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#1a3d1a] focus:outline-none">
      </div>
      <button type="submit"
        class="w-full py-3 rounded-xl bg-[#E86A10] hover:bg-[#d45e0d] text-white font-semibold text-sm shadow-md transition-colors">
        Đăng nhập
      </button>
    </form>
    <div class="mt-4 text-center">
      <a href="/lfpage.html" class="text-xs text-gray-500 hover:text-[#1a3d1a]">← Quay lại trang chủ</a>
    </div>
  </div>
</body>
</html>
