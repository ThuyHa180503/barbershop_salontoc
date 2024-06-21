<?php
$tb_mail = '';
if (isset($_POST['guiemail'], $_POST['fg_usr'], $_POST['fg_mail'])) {
    $usr = $_POST['fg_usr'];
    $Mailer = $_POST['fg_mail'];
    $checkmail = checkmail($usr, $Mailer);

    if ($checkmail && is_array($checkmail)) {
        $_SESSION['reset_user_id'] = $checkmail['id'];
        //Nội dung mail là link dẩn tới trang thay đổi password và có username của user muốn thay đổi pass
        $context = "http://localhost/barbershop/index.php?pg=reset-pass&id=" . $checkmail['id'];
        $link_text = '<div style="border: 1px solid #dadce0;border-radius:8px;padding:20px 30px;width: 40%;margin: 0px auto;" align="center">
                       <img src="https://barbershop.vn/themes/img/logo-barbershop.png" alt="logo" style="width: 190px;padding-bottom: 20px;padding-top: 5px;">
                       <div style="font-family: Google Sans,Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-bottom:thin solid #dadce0;color:rgba(0,0,0,0.87);line-height:32px;padding-bottom:24px;text-align:center;">
                           <h1 style="font-size:24px">Đổi mật khẩu mới</h1>
                       </div>
                       <div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:14px;color:rgba(0,0,0,0.87);line-height:20px;padding-top:20px;text-align:left">
                           <span style="display: block;text-align: center;width: 360px;margin: 0 auto;font-size: 18px;line-height: 1.3;" >Bấm vào đường dẫn để tiếp tục tiến hành thay đổi mật khẩu của bạn</span>
                           <a href="' . $context . '" style="display: block;width: 100px;margin: 0 auto;line-height: 30px;border-radius: 0.3rem;background: #353434;color: #fff;border: 0;text-align: center;text-decoration: none;margin-top: 20px;">TẠI ĐÂY</a>
                       </div>
                   </div>';
        sendMail($Mailer, "Mat khau moi", $link_text);

        // Thành công thì thông báo user kiểm tra mail
        $tb_mail = '<p class="h4" style="color: green;">Đã gửi mail! Vui lòng kiểm tra mail của bạn.</p>';
    } else {
        $tb_mail = '<p class="h4" style="color: red;">Username và Email không khớp với bất kỳ mail nào!</p>';
    }
};
