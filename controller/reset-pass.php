<?php
$iduser = $_GET['id'];
$tbpw = "";
if (isset($_POST['guipwd'])) {
    $rs_pwf = $_POST['rs_pwd'];
    $rs_cfp = $_POST['rs_cfp'];
    if (empty($rs_pwf) || empty($rs_cfp)) {
        $tbpw = '<p class="h4" style="color: red;">Vui lòng điền đầy đủ thông tin đăng ký.</p>';
    } elseif (strlen($rs_pwf) < 6 || strlen($rs_cfp) < 6) {
        $tbpw = '<p class="h4" style="color: red;">Tài khoản và mật khẩu phải chứa ít nhất 6 ký tự.</p>';
    } else {
        if (($_POST['rs_pwd']) == ($_POST['rs_cfp'])) {
            user_change_password($rs_pwf, $iduser);
        }
        $tbpw = '<p class="h4" style="color: green;">Đổi mật khẩu thành công !</p>';
    }
}
