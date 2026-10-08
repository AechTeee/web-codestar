<?php
$dsn = "mysql:host=127.0.0.1;port=3306;dbname=demo_sql;charset=utf8";

try {
    $pdo = new PDO($dsn, "root", "",[
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    $hoc_vien=$pdo->query("SELECT id, ho_ten, lop, diem  FROM sinhvien ORDER BY id")->fetchAll();
    echo json_encode($hoc_vien);
} catch (PDOException $e) {
    die("Lỗi kết nối CSDL: " . $e->getMessage()
        ."\nHãy kiểm tra: MySQL đã bật chưa? Đã chạy file database.sql chưa? Mật khẩu trong config.php đúng chưa?\n");
}