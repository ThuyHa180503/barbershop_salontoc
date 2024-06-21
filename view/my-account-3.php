<?php

$html_orderlist = '';
foreach ($orderlist as $order) {
    extract($order);
    if ($status == 1) {
        $tt = '<span class="badge rounded-pill alert-primary" style="color:blue;">Chờ xác nhận</span>';
        $tt2 = '<a class="cancelled__filter--btn second__btn href="javascript:void(0);" onclick="confirmCancellation(' . $id . ');">Hủy lịch hẹn</a>';
    } else {
        $tt2 = '';
    }
    if ($status == 2) $tt = '<span class="badge rounded-pill alert-success">Xác nhận đã đến cửa hàng</span>';
    if ($status == 3) $tt = '<span class="badge rounded-pill alert-success">Delivering</span>';
    if ($status == 4) $tt = '<span class="badge rounded-pill alert-success">Hoàn thành</span>';
    if ($status == 6) $tt = '<span class="badge rounded-pill alert-warning">Do bạn hủy hoặc đã quá hẹn</span>';
    if ($status == 5) $tt = '<span class="badge rounded-pill alert-danger">Bị hủy</span>';
    $html_orderlist .= '<tr class="account__table--body__child">
                            <td class="account__table--body__child--items">#' . $mahd . '</td>
                            <td class="account__table--body__child--items">' . $date . '</td>
                            <td class="account__table--body__child--items">
                                ' . $tt . ' 
                            </td>
                            <td class="account__table--body__child--items">' . number_format($tongthanhtoan, 0, ",", ".") . 'VNĐ</td>
                            <td class="account__table--body__child--items">
                                <a href="index.php?pg=orders-detail&id=' . $id . '" class="detail__filter--btn second__btn">Chi tiết</a> <br>
                                ' . $tt2 . '
                            </td>
                        </tr>';
}
?>

<main class="main__content_wrapper">
    <!-- Start breadcrumb section -->
    <section class="breadcrumb__section breadcrumb__bg">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__content--title text-white mb-25">Tài khoản</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center">
                            <li class="breadcrumb__content--menu__items"><a class="text-white" href="index.php">Trang
                                    chủ</a></li>
                            <li class="breadcrumb__content--menu__items"><span class="text-white">Tài khoản</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End breadcrumb section -->

    <!-- my account section start -->
    <section class="my__account--section section--padding">
        <div class="container">
            <!-- <p class="account__welcome--text">Hello, Admin welcome to your dashboard!</p> -->
            <div class="my__account--section__inner border-radius-10 d-flex">
                <div class="account__left--sidebar">
                    <h2 class="account__content--title h3 mb-20">Thông tin của tôi</h2>
                    <ul class="account__menu">
                        <li class="account__menu--list"><a href="index.php?pg=my-account">Tài khoản</a></li>
                        <li class="account__menu--list active"><a href="index.php?pg=my-account-3">Lịch hẹn của tôi</a>
                        </li>
                        <li class="account__menu--list"><a href="index.php?pg=logout">Đăng xuất</a></li>
                        <?php
                        if ($role == 1) {
                            echo '<li class="account__menu--list"><a href="admin/index.php" target="_blank">Dành cho Admin</a></li>';
                        }
                        ?>
                    </ul>
                </div>
                <div class="account__wrapper">
                    <div class="account__content">
                        <h2 class="account__content--title h3 mb-20">Lịch sử lịch hẹn</h2>
                        <div class="account__table--area">
                            <table class="account__table">
                                <thead class="account__table--header">
                                    <tr class="account__table--header__child">
                                        <th class="account__table--header__child--items">Mã lịch hẹn</th>
                                        <th class="account__table--header__child--items">Ngày đặt lịch hẹn</th>
                                        <th class="account__table--header__child--items">Tình trạng</th>
                                        <th class="account__table--header__child--items">Tổng tiền</th>
                                        <th class="account__table--header__child--items">Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody class="account__table--body mobile__none">
                                    <?= $html_orderlist; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- my account section end -->

    <!-- Start shipping section -->
    <section class="shipping__section2 shipping__style3 section--padding pt-0">
        <div class="container">
            <div class="shipping__section2--inner shipping__style3--inner d-flex justify-content-between">
                <div class="shipping__items2 d-flex align-items-center">
                    <div class="shipping__items2--icon">
                        <img src="./view/assets/img/other/shipping1.png" alt="">
                    </div>
                    <div class="shipping__items2--content">
                        <h2 class="shipping__items2--content__title h3">Dịch vụ </h2>
                        <p class="shipping__items2--content__desc">Chăm sóc chu đáo</p>
                    </div>
                </div>
                <div class="shipping__items2 d-flex align-items-center">
                    <div class="shipping__items2--icon">
                        <img src="./view/assets/img/other/shipping2.png" alt="">
                    </div>
                    <div class="shipping__items2--content">
                        <h2 class="shipping__items2--content__title h3">Thanh Toán</h2>
                        <p class="shipping__items2--content__desc">Thanh toán trực tiếp và trực tuyến</p>
                    </div>
                </div>
                <div class="shipping__items2 d-flex align-items-center">
                    <div class="shipping__items2--icon">
                        <img src="./view/assets/img/other/shipping3.png" alt="">
                    </div>
                    <div class="shipping__items2--content">
                        <h2 class="shipping__items2--content__title h3">Liên Hệ</h2>
                        <p class="shipping__items2--content__desc">Hotline: 0399725203</p>
                    </div>
                </div>
                <div class="shipping__items2 d-flex align-items-center">
                    <div class="shipping__items2--icon">
                        <img src="./view/assets/img/other/shipping4.png" alt="">
                    </div>
                    <div class="shipping__items2--content">
                        <h2 class="shipping__items2--content__title h3">Hỗ trợ</h2>
                        <p class="shipping__items2--content__desc">Hỗ trợ 24/7 </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End shipping section -->

</main>

<script>
    function confirmCancellation(orderId) {
        var result = confirm("Bạn có chắc chắn muốn hủy lịch hẹn này không?");
        if (result) {
            // Nếu người dùng xác nhận, thực hiện hủy lịch hẹn
            window.location.href = "index.php?pg=order-cancelled&id=" + orderId;
        }
        // Ngược lại, không làm gì cả
    }
</script>