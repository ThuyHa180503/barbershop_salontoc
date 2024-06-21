<?php
$dsdm = danhmuc_all();
$kyw = "";
$titledm = "";
$titlepage = "";

if (!isset($_GET['iddm'])) {
    $iddm = 0;
} else {
    $iddm = $_GET['iddm'];
    $titledm = get_name_dm($iddm);
}

if (isset($_POST["search"])) {
    $kyw = $_POST["kyw"];
    $titlepage = "Tìm kiếm sản phẩm: '$kyw'";
}
if (!isset($_GET['page'])) {
    $pg = 1;
} else {
    $pg = $_GET['page'];
}
$sosp = 16;
$dssp = get_dssp($kyw, $iddm, $pg, $sosp);
$tongsp = get_dssp_all();
$hienthist = hien_thi_st($tongsp, $sosp);
