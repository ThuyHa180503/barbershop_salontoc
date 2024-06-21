<?php
$tbpw = "";

if (isset($_POST['change_pw'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['pw'];
    $newpassword = $_POST['newpw'];
    $repassword = $_POST['repw'];

    // Kiểm tra xác thực mật khẩu và thực hiện đổi mật khẩu
    if (isPasswordExists($username, $password)) {
        if (strlen($newpassword) < 6) {
            $tbpw = '<span class="h4" style="color: red;">Mật khẩu mới phải chứa ít nhất 6 ký tự.</span>';
        } elseif ($newpassword === $repassword) {
            change_password($username, $newpassword);
            $tbpw = '<span class="h4" style="color: green;">Đổi mật khẩu thành công!</span>';
        } else {
            $tbpw = '<span class="h4" style="color: red;">Mật khẩu mới không trùng khớp!</span>';
        }
    } else {
        $tbpw = '<span class="h4" style="color: red;">Mật khẩu hiện tại không chính xác!</span>';
    }
}

echo $tbpw;
