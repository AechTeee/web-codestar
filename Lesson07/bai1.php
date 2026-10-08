<?php
// Hằng số thuế suất VAT
const VAT = 0.10;

$tinhTongTien = false;
$loi = "";

$tenSP = "banh mi";
$donGia = "15000";
$soLuong = "2";

$thanhTien = 0; //đơn giá × số lượng
$tiềnVAT = 0;  //thuế VAT
$tongTien = 0;  //tổng tiền phải trả

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // trim(): bỏ khoảng trắng thừa ở hai đầu chuỗi
    $tenSP = trim($_POST["ten_sp"] ?? "");
    $donGia = trim($_POST["don_gia"] ?? "");
    $soLuong = trim($_POST["so_luong"] ?? "");

    if ($tenSP === "" || $donGia === "" || $soLuong === "") {
        $loi = "Vui lòng nhập đầy đủ thông tin!";
    } elseif (!is_numeric($donGia) || !is_numeric($soLuong)) {
        $loi = "Đơn giá và số lượng phải là số!";
    } elseif ($donGia < 0 || $soLuong <= 0) {
        $loi = "Đơn giá phải >= 0 và số lượng phải > 0!";
    } else {
        // (float): ép kiểu chuỗi -> số trước khi tính
        $d = (float)$donGia;
        $s = (float)$soLuong;

        $thanhTien = $d * $s;          //1. thành tiền
        $tiềnVAT = $thanhTien * VAT;   //2. tiền VAT 10%
        $tongTien = $thanhTien + $tiềnVAT; //3. tổng tiền phải trả

        $tinhTongTien = true;
    }
}

// number_format(): định dạng tiền có dấu phân cách nghìn, ví dụ 1.000.000
function hienThiTien($so) {
    return number_format((float)$so, 0, ",", ".");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 1 - Tính tiền &amp; VAT</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 420px; margin: 40px auto; padding: 0 16px; }
        form { border: 1px solid #ccc; padding: 20px; border-radius: 8px; }
        label { display: block; margin-top: 10px; }
        input, button { width: 100%; padding: 8px; margin-top: 4px; box-sizing: border-box; }
        button { margin-top: 16px; background: #8892bf; color: #fff; border: none; cursor: pointer; }
        .loi { color: #e74c3c; }
        .ket-qua { border: 1px solid #27ae60; border-radius: 8px; padding: 12px; }
        .ket-qua p { margin: 6px 0; }
        .tong { font-weight: bold; font-size: 18px; color: #27ae60; }
    </style>
</head>
<body>
    <h1>Tính tiền + VAT 10%</h1>

    <form method="post" action="">
        <label>Tên sản phẩm:
            <!-- htmlspecialchars(): chống chèn mã HTML/JS độc hại khi in dữ liệu người dùng nhập -->
            <input type="text" name="ten_sp" value="<?= htmlspecialchars($tenSP) ?>">
        </label>

        <label>Đơn giá (VNĐ):
            <input type="text" name="don_gia" value="<?= htmlspecialchars($donGia) ?>">
        </label>

        <label>Số lượng:
            <input type="text" name="so_luong" value="<?= htmlspecialchars($soLuong) ?>">
        </label>

        <button type="submit">Tính tổng tiền</button>
    </form>

    <?php if ($loi !== ""): ?>
        <p class="loi"><?= $loi ?></p>
    <?php elseif ($tinhTongTien): ?>
        <div class="ket-qua">
            <p>Sản phẩm: <b><?= htmlspecialchars($tenSP) ?></b></p>
            <p>Thành tiền: <?= hienThiTien($thanhTien) ?> đ</p>
            <p>VAT (<?= rtrim(rtrim(number_format(VAT * 100, 2, ",", "."), "0"), ",") ?>%):
                <?= hienThiTien($tiềnVAT) ?> đ</p>
            <p class="tong">Tổng phải trả: <?= hienThiTien($tongTien) ?> đ</p>
        </div>
    <?php endif; ?>
</body>
</html>