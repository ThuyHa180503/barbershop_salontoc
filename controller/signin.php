<?php
$tbdk = "";
//input
if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    //xử lý: kiem tra
    $kq = checkuser($username, $password);
    if (is_array($kq) && (count($kq))) {
        $_SESSION['s_user'] = $kq;
        header('location: index.php');
    } else {
        if (empty($username) || empty($password)) {
            $tb = "Vui lòng điền đầy đủ thông tin !";
        } else {
            $tb = "Tài khoản không tồn tại hoặc thông tin đăng nhập sai !";
        }
        $_SESSION['tb_dangnhap'] = $tb;
        header('location: index.php?pg=signin-signup');
    }
    //xl
}
