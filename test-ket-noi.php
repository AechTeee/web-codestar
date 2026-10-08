<?php
$host     = "localhost";
$dbname   = "demo_php";
$username = "root";
$password = "";   // XAMPP: để trống. Cài riêng MySQL: điền mật khẩu root đã đặt

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Kết nối MySQL thành công!\n\n";

    $rows = $pdo->query("SELECT id, ho_ten, diem FROM sinh_vien")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        echo $row["id"] . ". " . $row["ho_ten"] . " - " . $row["diem"] . " điểm\n";
    }
} catch (PDOException $e) {
    echo "Lỗi kết nối: " . $e->getMessage() . "\n";
}