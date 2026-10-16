<?php
session_start();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username'] ?? '');
    $pass = trim($_POST['password'] ?? '');
    // Simple admin credentials (change as needed)
    if ($user === 'admin' && $pass === 'admin') {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user'] = $user;
        header('Location: admin.php'); exit;
    } else {
        $error = 'Sai tài khoản hoặc mật khẩu.';
    }
}
// Sau khi login, chuyen trang sang admin.php
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin.php'); exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Admin - Shop trà sữa</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .login-box { max-width: 400px; margin: 80px auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .login-box h2 { text-align: center; color: #ff8f6b; margin-bottom: 20px; }
        .login-box .form-group { margin-bottom: 15px; }
        .login-box label { display: block; margin-bottom: 5px; font-weight: bold; }
        .login-box input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        .login-box .btn { width: 100%; }
        .error-msg { background: #fee; color: #c33; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Đăng nhập Admin</h2>
        <?php if ($error): ?>
            <div class="error-msg"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="username">Tài khoản</label>
                <input type="text" name="username" id="username" placeholder="admin">
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" name="password" id="password" placeholder="admin">
            </div>
            <button type="submit" class="btn btn-primary">Đăng nhập</button>
        </form>
        <p style="text-align:center; margin-top:15px;"><a href="menu.php" style="color:#ff8f6b;">Quay lại trang chủ</a></p>
    </div>
</html>