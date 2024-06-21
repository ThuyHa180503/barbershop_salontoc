<?php
$tbdk = "";
$username = $_GET["username"];
$password = $_GET["password"];
$id = $_GET["id"];
//xử lý: kiem tra
updateUserStatus($id);
$kq = checkuser($username, $password);
if (is_array($kq) && (count($kq))) {
    $_SESSION['s_user'] = $kq;
    header('location: index.php');
}
  //xl