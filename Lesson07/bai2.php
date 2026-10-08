<?php
$name="Nguyen Van An";
$score="1";

$ketqua="Bạn đã đạt";

if($score >= 8) {
    echo "Sinh viên $name đạt loại Giỏi";
} elseif($score >= 6.5) {
    echo "Sinh viên $name đạt loại Khá";
} elseif($score >= 5) {
    echo "Sinh viên $name đạt loại Trung bình";
} else {
    echo "Sinh viên $name đạt loại Không đạt";
}
