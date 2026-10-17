<?php
header("X-author=Hung Truong");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="menu.php" class="nav-logo"> Shop Trà sữa</a>
            <ul class="nav-menu">
                <li><a href="order.php">Đặt hàng</a></li>
                <li><a href="track.php">Đơn hàng</a></li>
            </ul>
        </div>
    </nav>

    <section class="container">
        <h1 class="section-title">Menu đồ uống</h1>
        <div class="menu-grid">
            <div class="menu-card">
                <h3>Trà sữa classic</h3>
                <div class="menu-desc">Trà đen truyền thống, sữa tươi, tapioca</div>
                <div class="menu-price">35.000đ</div>
            </div>
            <div class="menu-card">
                <h3>Dâu sữa</h3>
                <div class="menu-desc">Trà dâu tươi, sữa tươi, kem cheese</div>
                <div class="menu-price">45.000đ</div>
            </div>
            <div class="menu-card">
                <h3>Trà nho đen</h3>
                <div class="menu-desc">Nho đen, jasmine tea, jelly</div>
                <div class="menu-price">50.000đ</div>
            </div>
            <div class="menu-card">
                <h3>Trà xanh matcha</h3>
                <div class="menu-desc">Matcha cao cấp, sữa tươi, foam</div>
                <div class="menu-price">42.000đ</div>
            </div>
            <div class="menu-card">
                <h3>Trà chanh</h3>
                <div class="menu-desc">Chanh tươi, jasmine tea, đường</div>
                <div class="menu-price">38.000đ</div>
            </div>
            <div class="menu-card">
                <h3>Sinh tố xoài</h3>
                <div class="menu-desc">Xoài tươi, sữa đặc, đá xay</div>
                <div class="menu-price">55.000đ</div>
            </div>
            <div class="menu-card">
                <h3>Cà phê sữa đá</h3>
                <div class="menu-desc">Cà phê phin truyền thống</div>
                <div class="menu-price">30.000đ</div>
            </div>
            <div class="menu-card">
                <h3>Sữa tươi nguyên kem</h3>
                <div class="menu-desc">Sữa tươi nguyên kem, đường</div>
                <div class="menu-price">40.000đ</div>
            </div>
        </div>
        <div class="text-dathangr">
            <a href="order.php" class="btn btn-primary">Đặt hàng ngay</a>
        </div>
    </section>
</body>
</html>