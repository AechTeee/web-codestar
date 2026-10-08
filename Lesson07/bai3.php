<?php
$products = [
    [
        "name" => "Bánh mì",
        "price" => 15000,
        "quantity" => 2
    ],
    [
        "name" => "Sữa",
        "price" => 30000,
        "quantity" => 1
    ],
    [
        "name" => "Trứng",
        "price" => 25000,
        "quantity" => 3
    ]
];

//duyet danh sach san pham bang foreach
foreach ($products as $sp) {
    echo "Tên: " . $sp["name"]
        . " - Số lượng: " . $sp["quantity"]
        . " - Đơn giá: " . number_format($sp["price"], 0, ",", ".")
        . "<\n>";
}