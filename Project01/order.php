<?php
session_start();
$ordersFile = __DIR__ . '/orders.json';
$orders = file_exists($ordersFile) ? json_decode(file_get_contents($ordersFile), true) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $drink = trim($_POST['drink'] ?? '');
    $topping = trim($_POST['topping'] ?? '');
    $sugar = trim($_POST['sugar'] ?? '');
    $ice = trim($_POST['ice'] ?? '');
    $address = trim($_POST['address'] ?? '');

    $errors = [];
    if (!$name) $errors[] = 'Vui lòng nhập tên.';
    if (!$phone || !preg_match('/^[0-9]{10,11}$/', $phone)) $errors[] = 'Số điện thoại không hợp lệ.';
    if (!$drink) $errors[] = 'Vui lòng chọn đồ uống.';

    if (empty($errors)) {
        $order = [
            'id' => 'ORD' . time() . rand(100, 999),
            'name' => $name,
            'phone' => $phone,
            'drink' => $drink,
            'topping' => $topping,
            'sugar' => $sugar,
            'ice' => $ice,
            'address' => $address,
            'total' => 35000,
            'status' => 'Chờ xác nhận',
            'created_at' => date('Y-m-d H:i:s')
        ];
        $orders[] = $order;
        file_put_contents($ordersFile, json_encode($orders, JSON_UNESCAPED_UNICODE));
        $_SESSION['order_id'] = $order['id'];   
        header('Location: track.php?phone=' . urlencode($phone));
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="menu.php" class="nav-logo">Shop Trà sữa</a>
            <ul class="nav-menu">
                <li><a href="menu.php">Menu</a></li>
                <li><a href="order.php" class="active">Đặt hàng</a></li>
                <li><a href="track.php">Đơn hàng</a></li>
            </ul>
        </div>
    </nav>

    <section class="container">
        <h1 class="section-title">Đặt online</h1>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $e): ?>
                    <p><?php echo htmlspecialchars($e); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="order-form">
            <div class="form-group">
                <label for="name">Họ tên</label>
                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" placeholder="Nhập họ tên">
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại</label>
                <input type="tel" name="phone" id="phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>" placeholder="VD: 0123456789">
            </div>
            <div class="form-group">
                <label for="drink">Chọn đồ uống</label>
                <select name="drink" id="drink">
                    <option value="">-- Chọn đồ uống --</option>
                    <option value="Trà sữa classic">Trà sữa classic (35k)</option>
                    <option value="Dâu sữa">Dâu sữa (45k)</option>
                    <option value="Trà nho đen">Trà nho đen (50k)</option>
                    <option value="Trà xanh matcha">Trà xanh matcha (42k)</option>
                    <option value="Trà chanh">Trà chanh (38k)</option>
                    <option value="Sinh tố xoài">Sinh tố xoài (55k)</option>
                    <option value="Cà phê sữa đá">Cà phê sữa đá (30k)</option>
                    <option value="Sữa tươi nguyên kem">Sữa tươi nguyên kem (40k)</option>
                </select>
            </div>
            <div class="form-group">
                <label for="topping">Topping</label>
                <select name="topping" id="topping">
                    <option value="Không">Không</option>
                    <option value="Tapioca">Tapioca</option>
                    <option value="Pudding">Pudding</option>
                    <option value="Jelly">Jelly</option>
                    <option value="Cheese foam">Cheese foam</option>
                </select>
            </div>
            <div class="form-group">
                <label for="sugar">Đường</label>
                <select name="sugar" id="sugar">
                    <option value="50%">50%</option>
                    <option value="70%" selected>70%</option>
                    <option value="100%">100%</option>
                    <option value="Không">Không</option>
                </select>
            </div>
            <div class="form-group">
                <label for="ice">Lượng đá</label>
                <select name="ice" id="ice">
                    <option value="Ít đá">Ít đá</option>
                    <option value="Bình thường" selected>Bình thường</option>
                    <option value="Nhiều đá">Nhiều đá</option>
                    <option value="Không đá">Không đá</option>
                </select>
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ giao hàng</label>
                <textarea name="address" id="address" rows="2" placeholder="Địa chỉ giao hàng (nếu có)"></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Đặt hàng</button>
        </form>
    </section>
</body>
</html>