<?php
$tbdk = "";

if (isset($_POST["register"])) {
    $username = htmlspecialchars($_POST["username"]);
    $password = $_POST["password"];
    $repassword = $_POST["repassword"];
    $email = htmlspecialchars($_POST["email"]);

    if (empty($username) || empty($password) || empty($email) || empty($repassword)) {
        $tbdk = "Vui lòng điền đầy đủ thông tin đăng ký.";
    } elseif (strlen($password) < 6) {
        $tbdk = "Mật khẩu phải chứa ít nhất 6 ký tự.";
    } elseif (isUsernameExists($username)) {
        $tbdk = "Tài khoản đã tồn tại. Vui lòng chọn một tài khoản khác.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $tbdk = "Địa chỉ email không hợp lệ.";
    } elseif ($password != $repassword) {
        $tbdk = "Mật khẩu nhập lại không khớp.";
    } else {
        // Thêm người dùng vào cơ sở dữ liệu
        user_insert($username, $password, $email);
        $tbdk = "Đăng ký thành công, vui lòng kiểm tra email để xác nhận tài khoản.";

        // Gửi email xác nhận
        $checkmail = checkmail($username, $email);
        if ($checkmail && is_array($checkmail)) {
            $_SESSION['reset_user_id'] = $checkmail['id'];
            $verificationLink = "http://localhost/barbershop/index.php?pg=verify&id=" . urlencode($checkmail['id']) . "&username=" . urlencode($username) . "&password=" . urlencode($password);

            $emailContent = '<div style="border: 1px solid #dadce0;border-radius:8px;padding:20px 30px;width: 40%;margin: 0px auto;" align="center">
                                <img src="https://barbershop.vn/themes/img/logo-barbershop.png" alt="logo" style="width: 190px;padding-bottom: 20px;padding-top: 5px;">
                                <div style="font-family: Google Sans,Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-bottom:thin solid #dadce0;color:rgba(0,0,0,0.87);line-height:32px;padding-bottom:24px;text-align:center;">
                                    <h1 style="font-size:24px">Xác nhận đăng ký</h1>
                                </div>
                                <div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:14px;color:rgba(0,0,0,0.87);line-height:20px;padding-top:20px;text-align:left">
                                    <span style="display: block;text-align: center;width: 360px;margin: 0 auto;font-size: 18px;line-height: 1.3;" >Bấm vào đường dẫn để tiếp tục đăng nhập vào tài khoản của bạn</span>
                                    <a href="' . $verificationLink . '" style="display: block;width: 100px;margin: 0 auto;line-height: 30px;border-radius: 0.3rem;background: #353434;color: #fff;border: 0;text-align: center;text-decoration: none;margin-top: 20px;">TẠI ĐÂY</a>
                                </div>
                            </div>';

            sendMail($email, "Xac thuc email", $emailContent);
        }
    }
}
// Hiển thị thông báo và chuyển hướng đến Gmail
echo '<script>
                alert("' . $tbdk . '");
              </script>';
exit();



// Hiển thị thông báo lỗi nếu có
if (!empty($tbdk)) {
    echo '<script>alert("' . $tbdk . '");</script>';
}
