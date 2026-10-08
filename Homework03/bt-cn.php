<?php
// Cau hinh ket noi CSDL (dung chung voi Lesson09)
$dsn = 'mysql:host=localhost;port=3306;dbname=homework03;charset=utf8';

try {
    $pdo = new PDO($dsn, 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,      // nem loi thay vi can bao
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // select tra ve mang lien tuoc
    ]);
} catch (PDOException $e) {
    die('Loi ket noi CSDL: ' . $e->getMessage());
}

// Kieu soan bang products (neu chua co)
$pdo->exec("
    CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        description TEXT,
        price DECIMAL(10,2) DEFAULT 0,
        quantity INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB
");

// Chen du lieu demo neu bang rong
$count = (int)$pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
if ($count === 0) {
    $stmt = $pdo->prepare(
        'INSERT INTO products (name, description, price, quantity) VALUES (?,?,?,?)'
    );
    $demo = [
        ['Bánh mì', 'Bánh mì Hà Nội', 15000, 100],
        ['Sữa', 'Sữa tươm 2%, 1L', 24000, 50],
        ['Trứng', 'Trứng gà cúng đất', 35000, 30],
    ];
    foreach ($demo as $d) {
        $stmt->execute($d);
    }
}

// Xu ly hanh dong (Create / Update / Delete)
$loi = '';
$success = '';

$act = $_GET['act'] ?? ''; // edit, delete

// Khi form duoc gui = POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $desc = trim($_POST['desc'] ?? '');
    $price = $_POST['price'] ?? '';
    $qty = $_POST['qty'] ?? '';

    if ($name === '' || $price === '' || $qty === '') {
        $loi = 'Vui lòng nhập tên, giá và số lượng!';
    } elseif (!is_numeric($price) || !is_numeric($qty) || $price < 0 || $qty < 0) {
        $loi = 'Giá và số lượng phải là số không âm!';
    } else {
        $price = (float)$price;
        $qty = (int)$qty;

        if (isset($_POST['id']) && $_POST['id'] !== '') {
            // UPDATE
            $stmt = $pdo->prepare(
                'UPDATE products SET name=?, description=?, price=?, quantity=? WHERE id=?'
            );
            $stmt->execute([$name, $desc, $price, $qty, (int)$_POST['id']]);
            $success = 'Cập nhật sản phẩm thành công!';
        } else {
            // CREATE
            $stmt = $pdo->prepare(
                'INSERT INTO products (name, description, price, quantity) VALUES (?,?,?,?)'
            );
            $stmt->execute([$name, $desc, $price, $qty]);
            $success = 'Thêm sản phẩm thành công!';
        }
    }
}

// Xoa san pham (via GET ?act=delete&id=...)
if ($act === 'delete' && isset($_GET['id'])) {
    $stmt = $pdo->prepare('DELETE FROM products WHERE id=?');
    $stmt->execute([(int)$_GET['id']]);
    $success = 'Xóa sản phẩm thành công!';
    $act = ''; // tro ve trang danh sach binh thuong
}

// Lay tat ca san pham (VIEW) - luon lay ban ghi moi nhat nhat
$products = $pdo->query(
    'SELECT id, name, description, price, quantity, created_at FROM products ORDER BY id DESC'
)->fetchAll();

// Neu dang o che do sua, tai du lieu san pham do vao form
$editData = null;
if ($act === 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare(
        'SELECT id, name, description, price, quantity FROM products WHERE id=?'
    );
    $stmt->execute([(int)$_GET['id']]);
    $editData = $stmt->fetch();
    if (!$editData) {
        $act = ''; // khong tim thay -> quay ve danh sach
    }
}

// Dinh dang so tien: ngan cach phay, phan cach nghin la dau cham
function money($n) {
    return number_format((float)$n, 0, ',', '.');
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý sản phẩm - CRUD</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 860px;
            margin: 40px auto;
            padding: 0 16px;
        }
        h1 { color: #333; }
        .form, .list {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 24px;
        }
        label { display: block; margin: 8px 0 4px; font-weight: bold; }
        input, textarea {
            width: 100%; padding: 8px; box-sizing: border-box;
            border: 1px solid #aaa; border-radius: 4px;
        }
        .btn {
            display: inline-block; padding: 8px 16px; margin-top: 12px;
            background: #8892bf; color: #fff; border: none; border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover { background: #6b749d; }
        .danger { background: #e74c3c; }
        .danger:hover { background: #c0392b; }
        .info { background: #27ae60; }
        .info:hover { background: #219653; }
        .msg { padding: 8px; border-radius: 4px; margin-bottom: 12px; }
        .err { background: #fdecea; color: #c0392b; border: 1px solid #f5c6cb; }
        .ok { background: #e6f7ec; color: #219653; border: 1px solid #a5d6a7; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f5f5f5; }
        .actions a { margin-right: 6px; }
    </style>
</head>
<body>
    <h1>Quản lý sản phẩm (CRUD)</h1>

    <?php if ($loi !== ''): ?>
        <p class="msg err"><?= htmlspecialchars($loi) ?></p>
    <?php endif; ?>
    <?php if ($success !== ''): ?>
        <p class="msg ok"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <!-- Form: Create / Update -->
    <div class="form">
        <?php if ($editData): ?>
            <h2>Sửa sản phẩm</h2>
        <?php else: ?>
            <h2>Thêm sản phẩm</h2>
        <?php endif; ?>

        <form method="post" action="?act=<?= $act === 'edit' ? 'edit' : '' ?>">
            <!-- INPUT an de xac dinh la UPDATE ( co id ) -->
            <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">
            <label>Tên sản phẩm *</label>
            <input type="text" name="name" required value="<?= htmlspecialchars($editData['name'] ?? '') ?>">

            <label>Mô tả</label>
            <textarea name="desc" rows="2"><?= htmlspecialchars($editData['description'] ?? '') ?></textarea>

            <label>Đơn giá (VNĐ) *</label>
            <input type="text" name="price" required value="<?= htmlspecialchars($editData['price'] ?? '') ?>">

            <label>Số lượng *</label>
            <input type="number" name="qty" min="0" required value="<?= htmlspecialchars($editData['quantity'] ?? '') ?>">

            <?php if ($editData): ?>
                <button type="submit" class="info">Lưu thay đổi</button>
                <a href="?" class="btn">Hủy</a>
            <?php else: ?>
                <button type="submit" class="btn">Thêm mới</button>
            <?php endif; ?>
        </form>
    </div>

    <!-- VIEW: danh sach san pham -->
    <div class="list">
        <h2>Danh sách sản phẩm</h2>

        <?php if (empty($products)): ?>
            <p>Chưa có sản phẩm nào.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên</th>
                        <th>Mô tả</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $sp): ?>
                    <tr>
                        <td><?= $sp['id'] ?></td>
                        <td><?= htmlspecialchars($sp['name']) ?></td>
                        <td><?= nl2br(htmlspecialchars($sp['description'])) ?></td>
                        <td><?= money($sp['price']) ?> đ</td>
                        <td><?= (int)$sp['quantity'] ?></td>
                        <td><?= (new DateTime($sp['created_at']))->format('d/m/Y H:i') ?></td>
                        <td class="actions">
                            <a href="?act=edit&id=<?= $sp['id'] ?>" class="info">Sửa</a>
                            <a href="?act=delete&id=<?= $sp['id'] ?>"
                               class="danger"
                               onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">Xóa</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>