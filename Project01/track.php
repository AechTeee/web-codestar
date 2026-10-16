<?php
$ordersFile = __DIR__ . '/orders.json';
$orders = file_exists($ordersFile) ? json_decode(file_get_contents($ordersFile), true) : [];
$phone = trim($_GET['phone'] ?? '');
$result = [];
if ($phone) {
    foreach ($orders as $o) {
        if ($o['phone'] === $phone) {
            $result[] = $o;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tra cứu đơn hàng</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="menu.php" class="nav-logo">Shop Trà sữa</a>
            <ul class="nav-menu">
                <li><a href="menu.php">Menu</a></li>
                <li><a href="order.php">Đặt hàng</a></li>
                <li><a href="track.php" class="active">Đơn hàng</a></li>
            </ul>
        </div>
    </nav>

    <section class="container">
        <h1 class="section-title">Tra cứu đơn hàng</h1>
        <form method="GET" class="track-form">
            <div class="form-group">
                <label for="phone">Số điện thoại</label>
                <input type="tel" name="phone" id="phone" value="<?php echo htmlspecialchars($phone); ?>" placeholder="Nhập SĐT đã đặt hàng">
            </div>
            <button type="submit" class="btn btn-primary">Tra cứu</button>
        </form>

        <?php if ($phone && empty($result)): ?>
            <div class="alert alert-error">Không tìm thấy đơn hàng nào với số điện thoại "<?php echo htmlspecialchars($phone); ?>".</div>
        <?php endif; ?>

        <?php if (!empty($result)): ?>
            <div class="order-list">
                <?php foreach ($result as $o): ?>
                    <div class="order-card">
                        <div class="order-header">
                            <span class="order-id"><?php echo htmlspecialchars($o['id']); ?></span>
                            <span class="order-status status-waiting"><?php echo htmlspecialchars($o['status']); ?></span>
                        </div>
                        <div class="order-detail">
                            <p><strong>Khách hàng:</strong> <?php echo htmlspecialchars($o['name']); ?></p>
                            <p><strong>Đồ uống:</strong> <?php echo htmlspecialchars($o['drink']); ?></p>
                            <p><strong>Topping:</strong> <?php echo htmlspecialchars($o['topping']); ?></p>
                            <p><strong>Đường:</strong> <?php echo htmlspecialchars($o['sugar']); ?> | <strong>Đá:</strong> <?php echo htmlspecialchars($o['ice']); ?></p>
                            <p><strong>Tổng tiền:</strong> <?php echo number_format($o['total']) . 'đ'; ?></p>
                            <p><strong>Thời gian:</strong> <?php echo htmlspecialchars($o['created_at']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</body>
</html>