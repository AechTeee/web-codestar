<?php
session_start();
// === Kết nối SQL ===
$host = 'localhost';
$dbname = 'menu_db';
$username = 'root';
$password = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Kết nối thất bại: ' . htmlspecialchars($e->getMessage()));
}

// ---- Ensure orders table exists ----
$pdo->exec("CREATE TABLE IF NOT EXISTS orders (
    id VARCHAR(20) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    drink VARCHAR(100) NOT NULL,
    topping VARCHAR(50),
    sugar VARCHAR(20),
    ice VARCHAR(20),
    address TEXT,
    total DECIMAL(10,2),
    status VARCHAR(50) DEFAULT 'Chờ xác nhận',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

// ---- Handle actions ----
$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'add_menu' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO menu_items (name, description, price, category) VALUES (?,?,?,?)");
    $stmt->execute([$_POST['name'], $_POST['description'], $_POST['price'], $_POST['category']]);
    header('Location: admin.php?tab=menu&msg=them_ok'); exit;
}
if ($action === 'edit_menu' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE menu_items SET name=?, description=?, price=?, category=? WHERE id=?");
    $stmt->execute([$_POST['name'], $_POST['description'], $_POST['price'], $_POST['category'], $_POST['id']]);
    header('Location: admin.php?tab=menu&msg=sua_ok'); exit;
}
if ($action === 'delete_menu') {
    $id = intval($_GET['id'] ?? 0);
    $stmt = $pdo->prepare("DELETE FROM menu_items WHERE id=?");
    $stmt->execute([$id]);
    header('Location: admin.php?tab=menu&msg=xoa_ok'); exit;
}
if ($action === 'update_status' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE orders SET status=? WHERE id=?");
    $stmt->execute([$_POST['status'], $_POST['order_id']]);
    header('Location: admin.php?tab=orders&msg=cap_nhat_ok'); exit;
}

$tab = $_GET['tab'] ?? 'menu';
$menuItems = $pdo->query("SELECT * FROM menu_items ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
$orders = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Shop trà sữa</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { background: #f0f2f5; }
        .tab-nav { display: flex; gap: 0; margin-bottom: 20px; }
        .tab-nav a { padding: 12px 25px; background: #ddd; text-decoration: none; color: #333; font-weight: bold; border-radius: 6px 6px 0 0; }
        .tab-nav a.active { background: #ff8f6b; color: #fff; }
        .card { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .form-row { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; margin-bottom: 10px; }
        .form-row input, .form-row select, .form-row textarea { padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { padding: 10px; border: 1px solid #eee; text-align: left; vertical-align: middle; }
        th { background: #ff8f6b; color: #fff; }
        .btn-sm { padding: 6px 12px; font-size: 14px; border: none; border-radius: 4px; cursor: pointer; color: #fff; }
        .btn-edit { background: #4CAF50; } .btn-del { background: #f44336; } .btn-save { background: #2196F3; }
        .alert { padding: 12px; background: #d4edda; border: 1px solid #c3e6cb; color: #155724; border-radius: 6px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="admin.php" class="nav-logo">Admin - Shop trà sữa</a>
            <ul class="nav-menu">
                <li><a href="menu.php">Trang chủ</a></li>
                <li><a href="admin.php?tab=menu" class="<?php echo $tab==='menu'?'active':''; ?>">Quản lý menu</a></li>
                <li><a href="admin.php?tab=orders" class="<?php echo $tab==='orders'?'active':''; ?>">Quản lý đơn hàng</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert">Thao tác thành công.</div>
        <?php endif; ?>

        <div class="tab-nav">
            <a href="admin.php?tab=menu" class="<?php echo $tab==='menu'?'active':''; ?>">Menu</a>
            <a href="admin.php?tab=orders" class="<?php echo $tab==='orders'?'active':''; ?>">Đơn hàng</a>
        </div>

        <?php if ($tab === 'menu'): ?>
            <div class="card">
                <h2>Thêm / Sửa món</h2>
                <?php
                $editItem = null;
                if (isset($_GET['edit'])) {
                    foreach ($menuItems as $m) if ($m['id'] == $_GET['edit']) { $editItem = $m; break; }
                }
                ?>
                <form method="POST" action="admin.php?tab=menu">
                    <input type="hidden" name="action" value="<?php echo $editItem ? 'edit_menu' : 'add_menu'; ?>">
                    <?php if ($editItem): ?>
                        <input type="hidden" name="id" value="<?php echo $editItem['id']; ?>">
                    <?php endif; ?>
                    <div class="form-row">
                        <input type="text" name="name" placeholder="Tên món" value="<?php echo htmlspecialchars($editItem['name'] ?? ''); ?>" required>
                        <input type="number" name="price" placeholder="Giá" value="<?php echo $editItem['price'] ?? ''; ?>" step="1000" required>
                        <input type="text" name="category" placeholder="Danh mục" value="<?php echo htmlspecialchars($editItem['category'] ?? ''); ?>">
                        <textarea name="description" placeholder="Mô tả" rows="2"><?php echo htmlspecialchars($editItem['description'] ?? ''); ?></textarea>
                        <button type="submit" class="btn btn-primary"><?php echo $editItem ? 'Cập nhật' : 'Thêm món'; ?></button>
                        <?php if ($editItem): ?>
                            <a href="admin.php?tab=menu" class="btn btn-secondary">Hủy</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <div class="card">
                <h2>Danh sách menu</h2>
                <table>
                    <thead>
                        <tr><th>ID</th><th>Tên</th><th>Mô tả</th><th>Giá</th><th>Danh mục</th><th>Thao tác</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($menuItems as $m): ?>
                            <tr>
                                <td><?php echo $m['id']; ?></td>
                                <td><?php echo htmlspecialchars($m['name']); ?></td>
                                <td><?php echo htmlspecialchars($m['description']); ?></td>
                                <td><?php echo number_format($m['price']); ?>đ</td>
                                <td><?php echo htmlspecialchars($m['category']); ?></td>
                                <td>
                                    <a href="admin.php?tab=menu&edit=<?php echo $m['id']; ?>" class="btn-sm btn-edit">Sửa</a>
                                    <a href="admin.php?action=delete_menu&tab=menu&id=<?php echo $m['id']; ?>" class="btn-sm btn-del" onclick="return confirm('Xóa món này?');">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php elseif ($tab === 'orders'): ?>
            <div class="card">
                <h2>Lịch sử đơn hàng</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>SĐT</th>
                            <th>Món</th>
                            <th>Topping</th>
                            <th>Đường/Đá</th>
                            <th>Tổng</th>
                            <th>Trạng thái</th>
                            <th>Thời gian</th>
                            <th>Cập nhật</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $o): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($o['id']); ?></td>
                                <td><?php echo htmlspecialchars($o['name']); ?></td>
                                <td><?php echo htmlspecialchars($o['phone']); ?></td>
                                <td><?php echo htmlspecialchars($o['drink']); ?></td>
                                <td><?php echo htmlspecialchars($o['topping']); ?></td>
                                <td><?php echo htmlspecialchars($o['sugar']); ?> / <?php echo htmlspecialchars($o['ice']); ?></td>
                                <td><?php echo number_format($o['total']); ?>đ</td>
                                <td><?php echo htmlspecialchars($o['status']); ?></td>
                                <td><?php echo htmlspecialchars($o['created_at']); ?></td>
                                <td>
                                    <form method="POST" action="admin.php?tab=orders" style="display:inline;">
                                        <input type="hidden" name="action" value="update_status">
                                        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($o['id']); ?>">
                                        <select name="status">
                                            <?php foreach (['Chờ xác nhận','Đang làm','Đang giao','Hoàn thành','Đã hủy'] as $s): ?>
                                                <option value="<?php echo $s; ?>" <?php echo $o['status']===$s?'selected':''; ?>><?php echo $s; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" class="btn-sm btn-save">Lưu</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>