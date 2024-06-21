<?php $tbdn = "";
if (isset($_SESSION['s_user'])) {
    if (isset($_GET['vnp_TransactionStatus'])) {
        if ($_GET['vnp_TransactionStatus'] == '02') {
        } else {
            header('location: index.php?pg=checkout-2&mahd=' . $mahd);
        }
    }
    if (isset($_POST['btnpay'])) {
        $nguoidat_ten = $_POST['name'];
        $nguoidat_tel = $_POST['sdt'];
        $nguoidat_diachi = $_POST['address'];
        $nguoidat_email = $_POST['email'];
        $note = $_POST['note'];
        $sum = $_POST['sum'];
        $pttt = $_POST['pttt'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $datetime = new DateTime();
        $date = $datetime->format('Y-m-d');
        $time = $datetime->format('H:i:s');
        $iduser = $_SESSION['s_user']['id'];
        $mahd = "BarberShop" . rand(1, 999);
        $total = get_tongdonhang();
        $ship = 0;
        $appointment_date =   ($_SESSION['giohang'][0]['appointment_date']);
        $time =   ($_SESSION['giohang'][0]['time']);
        //TẠO MAIL THÔNG BÁO ĐẶT LỊCH THÀNH CÔNG!
        $link_text = '<div style="border: 1px solid #dadce0;border-radius:8px;padding:20px 30px;width: 40%;margin: 0px auto;" align="center">
        <img src="https://barbershop.vn/themes/img/logo-barbershop.png" alt="logo" style="width: 190px;padding-bottom: 20px;padding-top: 5px;">
        <div style="font-family: Google Sans,Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-bottom:thin solid #dadce0;color:rgba(0,0,0,0.87);line-height:32px;padding-bottom:24px;text-align:center;">
            <h1 style="font-size:24px">Đặt lịch hẹn thành công</h1>
        </div>
        <div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:14px;color:rgba(0,0,0,0.87);line-height:20px;padding-top:20px;text-align:left">
            <span style="display: block;text-align: center;width: 360px;margin: 0 auto;font-size: 18px;line-height: 1.3;" >BarberShop chân thành cảm ơn quý khách đã tin tưởng và lên lịch hẹn. </span>
                        <span style="display: block;width: 360px;margin: 0 auto;font-size: 18px;line-height: 1.3; font-weight:bold;" >NỘI DUNG CUỘC HẸN: </span>
                        <p> Mã hóa đơn: ' . $mahd . '</p>
                        <p> Tổng tiền : ' . $total . '</p>
                        <p> Ngày hẹn làm: ' . $appointment_date . '</p>
                        <p> Thời gian hẹn làm: ' . $time . '</p>
        </div>
    </div>';
        sendMail($nguoidat_email, "Lich hen voi BarberShop", $link_text);


        if (isset($_SESSION['giatrivoucher'])) {
            $voucher = $_SESSION['giatrivoucher'];
        } else {
            $voucher = 0;
        }
        $tongthanhtoan = ($total - $voucher) + $ship;
        $_SESSION['customer_info'] = array(
            'name' => $nguoidat_ten,
            'sdt' => $nguoidat_tel,
            'address' => $nguoidat_diachi,
            'email' => $nguoidat_email,
        );
        $idbill = order_insert_id($mahd, $iduser, $nguoidat_ten, $nguoidat_email, $nguoidat_tel, $nguoidat_diachi, $note, $total, $ship, $voucher, $tongthanhtoan, $pttt, $date, $time, $appointment_date);
        foreach ($_SESSION['giohang'] as $sp) {
            extract($sp);
            cart_insert($id, $price, $name, $img, $amount, $thanhtien, $idbill);
        }
        header('location: index.php?pg=checkout-2&mahd=' . $mahd);
    }
} else {
    $tbdn = '<p class="layout__flex--item">
                  <span style="color:red; font-weight:500">Bạn cần đăng nhập để thanh toán ! </span>
                  <a class="layout__flex--item__link" href="index.php?pg=signin-signup" style="font-weight: 900;">Đăng nhập</a>
                </p>';
};
