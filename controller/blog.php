<?php
$dmtintuc = dmuc_all(); // Lấy tất cả danh mục tin tức
$kyw = ""; // Từ khóa tìm kiếm mặc định
$titlepage = ""; // Tiêu đề trang mặc định

// Kiểm tra xem có tham số idloai trong URL không
$idloai = isset($_GET['idloai']) ? (int)$_GET['idloai'] : 0;

// Lấy tên danh mục nếu idloai tồn tại
if ($idloai > 0) {
    $titlepage = get_name_dmuc($idloai);
}

// Kiểm tra xem có tìm kiếm hay không
if (isset($_POST["search"])) {
    $kyw = htmlspecialchars($_POST["kyw"]); // Lấy từ khóa tìm kiếm và tránh XSS
    $titlepage = "Kết quả tìm kiếm với từ khóa: " . $kyw;
}

// Xác định trang hiện tại
$pg = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Số lượng tin tức trên mỗi trang
$so_tintuc = 4;

// Lấy danh sách blog
$dsblog = get_dsblog($kyw, $idloai, $pg, $so_tintuc);

// Tính tổng số tin tức và số trang hiển thị
$tong_tintuc = get_tintuc_all();
$hienthitintuc = hienthitintuc($tong_tintuc, $so_tintuc);

// Bao gồm tệp blog.php để hiển thị kết quả
include "view/blog.php";
