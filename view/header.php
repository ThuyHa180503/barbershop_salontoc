<?php
if (isset($_SESSION['s_user']) && (count($_SESSION['s_user']) > 0)) {
    extract($_SESSION['s_user']);
    $html_account = '<li class="header__account--items1">
                            <a class="header__account--btn" href="index.php?pg=my-account">
                                <img class="img-xs rounded-circle" src="./uploads/' . $img . '" alt="" alt="User" width="40px" height="40px">
                                <span class="header__account--btn__text">' . $username . '</span>
                            </a>
                        </li>';
    $html_account_mobile = '<a class="offcanvas__account--items__btn d-flex align-items-center" href="index.php?pg=my-account">
                                <img class="img-xs rounded-circle" src="./uploads/' . $img . '" alt="" alt="User" width="40px" height="40px">
                                <span class="offcanvas__account--items__label">' . $username . '</span>
                            </a>';
    $html_account_scroll = '<a class="header__account--btn" href="index.php?pg=my-account">
                                <img class="img-xs rounded-circle" src="./uploads/' . $img . '" alt="" alt="User" width="30px" height="30px">
                            </a>';
} else {
    $html_account = '<li class="header__account--items">
                            <a class="header__account--btn" href="index.php?pg=signin-signup">
                                <svg xmlns="http://www.w3.org/2000/svg"  width="30" height="30" viewBox="0 0 512 512"><path d="M344 144c-3.92 52.87-44 96-88 96s-84.15-43.12-88-96c-4-55 35-96 88-96s92 42 88 96z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><path d="M256 304c-87 0-175.3 48-191.64 138.6C62.39 453.52 68.57 464 80 464h352c11.44 0 17.62-10.48 15.65-21.4C431.3 352 343 304 256 304z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/></svg> 
                                <span class="header__account--btn__text">Đăng Nhập</span>
                            </a>
                        </li>';
    $html_account_mobile = '<a class="offcanvas__account--items__btn d-flex align-items-center" href="index.php?pg=signin-signup">
                                <span class="offcanvas__account--items__icon"> 
                                    <svg xmlns="http://www.w3.org/2000/svg"  width="30" height="30" viewBox="0 0 512 512"><path d="M344 144c-3.92 52.87-44 96-88 96s-84.15-43.12-88-96c-4-55 35-96 88-96s92 42 88 96z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><path d="M256 304c-87 0-175.3 48-191.64 138.6C62.39 453.52 68.57 464 80 464h352c11.44 0 17.62-10.48 15.65-21.4C431.3 352 343 304 256 304z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/></svg> 
                                </span>
                                <span class="offcanvas__account--items__label">Đăng nhập / Đăng ký</span>
                            </a>';
    $html_account_scroll = '<a class="header__account--btn" href="index.php?pg=signin-signup">
                                <svg xmlns="http://www.w3.org/2000/svg"  width="30" height="30" viewBox="0 0 512 512"><path d="M344 144c-3.92 52.87-44 96-88 96s-84.15-43.12-88-96c-4-55 35-96 88-96s92 42 88 96z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><path d="M256 304c-87 0-175.3 48-191.64 138.6C62.39 453.52 68.57 464 80 464h352c11.44 0 17.62-10.48 15.65-21.4C431.3 352 343 304 256 304z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/></svg>
                                <span class="visually-hidden">Đăng Nhập</span>
                            </a>';
}

$html_cart = '';
if (isset($_SESSION['giohang']) && is_array($_SESSION['giohang'])) {
    $i = 0;
    $sum = 0;
    foreach ($_SESSION['giohang'] as $item) {
        extract($item);
        $tt = (int)$price * (int)$amount;
        (int)$sum += (int)$price * (int)$amount;
        $linkdel = "index.php?pg=delcart-box&ind=" . $i;
        $html_cart .= '<div class="minicart__product--items d-flex">
                            <div class="minicart__thumb">
                                <img src="./uploads/' . $img . '" alt="prduct-img">
                            </div>
                            <div class="minicart__text">
                                <h3 class="minicart__subtitle h4">' . $name . '</h3>
                                <div class="minicart__price">
                                    <span class="current__price">' . number_format($price, 0, ",", ".") . 'VNĐ</span>
                                    <span class="old__price">' . number_format($price, 0, ",", ".") . 'VNĐ</span>
                                </div>
                                <div class="minicart__text--footer d-flex align-items-center" data-product-id="' . $id . '" data-product-price="' . $price . '">
                             
                                    <a href="' . $linkdel . '">
                                        <button class="minicart__product--remove">Xóa</button>
                                    </a>
                                </div>
                            </div>
                        </div>';
        $i++;
    }
}
?>

<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <title>Phong Cách Đỉnh Cao, Tự Tin Tỏa Sáng | Barbershop.vn</title>
    <meta name="description" content="Morden Bootstrap HTML5 Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="./view/assets/img/favicon.ico">

    <!-- ======= All CSS Plugins here ======== -->
    <link rel="stylesheet" href="./view/assets/css/plugins/swiper-bundle.min.css">
    <link rel="stylesheet" href="./view/assets/css/plugins/glightbox.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

    <!-- Plugin css -->
    <link rel="stylesheet" href="./view/assets/css/vendor/bootstrap.min.css">

    <!-- Custom Style CSS -->
    <link rel="stylesheet" href="./view/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>

<body>

    <!-- Start preloader -->
    <!-- <div id="preloader">
        <div id="ctn-preloader" class="ctn-preloader">
            <div class="animation-preloader">
                <div class="spinner"></div>
                <div class="txt-loading">
                    <span data-text-preloader="L" class="letters-loading">
                        L
                    </span>
                    
                    <span data-text-preloader="O" class="letters-loading">
                        O
                    </span>
                    
                    <span data-text-preloader="A" class="letters-loading">
                        A
                    </span>
                    
                    <span data-text-preloader="D" class="letters-loading">
                        D
                    </span>
                    
                    <span data-text-preloader="I" class="letters-loading">
                        I
                    </span>
                    
                    <span data-text-preloader="N" class="letters-loading">
                        N
                    </span>
                    
                    <span data-text-preloader="G" class="letters-loading">
                        G
                    </span>
                </div>
            </div>	
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>
    </div> -->
    <!-- End preloader -->

    <!-- Start header area -->
    <header class="header__section">
        <div class="header__topbar bg__secondary">
            <div class="container-fluid">
                <div class="header__topbar--inner d-flex align-items-center justify-content-between">
                    <div class="header__shipping">
                        <ul class="header__shipping--wrapper d-flex">
                            <li class="header__shipping--text text-white">Chào mừng bạn đến với BarberShop</li>
                            <li class="header__shipping--text text-white d-sm-2-none">Phong Cách Đỉnh Cao, Tự Tin Tỏa Sáng</li>
                        </ul>
                    </div>
                    <!-- <div class="language__currency d-none d-lg-block">
                        <ul class="d-flex align-items-center">
                            <li class="language__currency--list">
                                <a class="language__switcher text-white" href="#">
                                    <span>Việt Nam</span> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11.797" height="9.05" viewBox="0 0 9.797 6.05">
                                        <path  d="M14.646,8.59,10.9,12.329,7.151,8.59,6,9.741l4.9,4.9,4.9-4.9Z" transform="translate(-6 -8.59)" fill="currentColor" opacity="0.7"/>
                                    </svg>
                                </a>
                                <div class="dropdown__language">
                                    <ul>
                                        <li class="language__items"><a class="language__text" href="#">English</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="language__currency--list">
                                <a class="account__currency--link text-white" href="#">
                                    <span>VNĐ</span> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11.797" height="9.05" viewBox="0 0 9.797 6.05">
                                        <path  d="M14.646,8.59,10.9,12.329,7.151,8.59,6,9.741l4.9,4.9,4.9-4.9Z" transform="translate(-6 -8.59)" fill="currentColor" opacity="0.7"/>
                                    </svg>
                                </a>
                                <div class="dropdown__currency">
                                    <ul>
                                        <li class="currency__items"><a class="currency__text" href="#">$ US Dollar</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="main__header header__sticky">
            <div class="container-fluid">
                <div class="main__header--inner position__relative d-flex justify-content-between align-items-center">
                    <div class="offcanvas__header--menu__open ">
                        <a class="offcanvas__header--menu__open--btn" href="javascript:void(0)" data-offcanvas>
                            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon offcanvas__header--menu__open--svg" viewBox="0 0 512 512">
                                <path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M80 160h352M80 256h352M80 352h352" />
                            </svg>
                            <span class="visually-hidden">Menu Open</span>
                        </a>
                    </div>
                    <div class="main__logo">
                        <h1 class="main__logo--title"><a class="main__logo--link" href="index.php"><img class="main__logo--img" src="./view/assets/img/logo/nav-log.png" alt="logo-img"></a>
                        </h1>
                    </div>
                    <div class="header__search--widget header__sticky--none d-none d-lg-block">
                        <form class="d-flex header__search--form" action="index.php?pg=shop" method="post">

                            <div class="header__search--box">
                                <label>
                                    <input class="header__search--input" placeholder="Tìm kiếm..." type="text" name="kyw">
                                </label>
                                <button class="header__search--button bg__secondary text-white" type="submit" name="search" aria-label="search button">
                                    <svg class="header__search--button__svg" xmlns="http://www.w3.org/2000/svg" width="35.51" height="35" viewBox="0 0 512 512">
                                        <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32">
                                        </path>
                                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"></path>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="header__account header__sticky--none">
                        <ul class="d-flex">
                            <?php if (isset($_SESSION['s_user'])) : ?>
                                <li class="nav-item dropdown" style="margin-right: 40px;">

                                <?php else : ?>
                                <li class="nav-item dropdown" hidden>

                                <?php endif; ?>

                                <a class="nav-link   btn-icon" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="#000000" class="bi bi-bell-fill" viewBox="0 0 16 16">
                                        <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901" />
                                    </svg>
                                </a>
                                <?php
                                if (isset($_SESSION['s_user'])) {
                                    $recent_notifications_with_zero_recipient = get_recent_notifications($_SESSION['s_user']['id']);
                                    // Tiếp tục xử lý với dữ liệu $recent_notifications_with_zero_recipient ở đây
                                }
                                ?>
                                <style>
                                    .dropdown-item {
                                        display: flex;
                                        font-size: 2rem;
                                        align-items: center;
                                        justify-content: space-between;
                                    }

                                    .dropdown-item .text-muted {
                                        margin-left: 10px;
                                        /* Để tạo khoảng cách giữa nội dung và thời gian */
                                    }
                                </style>

                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <?php foreach ($recent_notifications_with_zero_recipient as $notification) : ?>
                                        <?php
                                        // Tính thời gian kể từ thời điểm tạo thông báo đến hiện tại
                                        $time_ago = strtotime($notification['Time']);
                                        $current_time = time();
                                        $time_difference = $current_time - $time_ago;
                                        $minutes = round($time_difference / 60);

                                        // Xây dựng nội dung thông báo và thời gian trước đó
                                        $notification_content = $notification['Content'];
                                        $time_ago_string = $minutes > 0 ? $minutes . " phút trước" : "vừa mới";

                                        // Hiển thị nội dung thông báo và thời gian trước đó
                                        ?>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <?php echo $notification_content; ?>
                                                <small class="text-muted"><?php echo $time_ago_string; ?></small>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>


                                </li>

                                <?= $html_account; ?>
                                <li class="header__account--items">
                                    <a class="header__account--btn minicart__open--btn" href="javascript:void(0)" data-offcanvas>
                                        <svg class="product__items--action__btn--svg" xmlns="http://www.w3.org/2000/svg" width="30.51" height="30.443" viewBox="0 0 24 24">
                                            <g transform="translate(0 0)">
                                                <g>
                                                    <path data-name="Path 1" d="M19 2h-1V1a1 1 0 0 0-2 0v1H8V1a1 1 0 0 0-2 0v1H5C3.346 2 2 3.346 2 5v14c0 1.654 1.346 3 3 3h14c1.654 0 3-1.346 3-3V5c0-1.654-1.346-3-3-3zm1 17c0 .551-.449 1-1 1H5c-.551 0-1-.449-1-1V9h16v10zm0-12H4V5c0-.551.449-1 1-1h1v1a1 1 0 0 0 2 0V4h8v1a1 1 0 0 0 2 0V4h1c.551 0 1 .449 1 1v2z" fill="currentColor"></path>
                                                    <path data-name="Path 2" d="M7 12h2v2H7zM11 12h2v2h-2zM15 12h2v2h-2zM7 16h2v2H7zM11 16h2v2h-2zM15 16h2v2h-2z" fill="currentColor"></path>
                                                </g>
                                            </g>
                                        </svg>
                                        <span class="header__account--btn__text">Lịch hẹn</span>
                                        <span class="items__count" id="cart-item-count"><?php echo count($_SESSION['giohang']); ?></span>
                                    </a>
                                </li>
                        </ul>
                    </div>
                    <div class="header__menu d-none header__sticky--block d-lg-block">
                        <nav class="header__menu--navigation">
                            <ul class="d-flex">
                                <li class="header__menu--items style2">
                                    <a class="header__menu--link" href="index.php" style="font-weight: bold;">Trang chủ</a>
                                </li>
                                <li class="header__menu--items mega__menu--items style2">
                                    <a class="header__menu--link" href="index.php?pg=shop" style="font-weight: bold;">Cửa hàng <a>
                                </li>
                                <li class="header__menu--items mega__menu--items style2">
                                    <a class="header__menu--link" href="index.php?pg=services" style="font-weight: bold;">Dịch vụ <a>
                                </li>
                                <li class="header__menu--items style2">
                                    <a class="header__menu--link" href="index.php?pg=blog" style="font-weight: bold;">Tin tức</a>
                                </li>
                                <li class="header__menu--items style2">
                                    <a class="header__menu--link" href="index.php?pg=about" style="font-weight: bold;">Về chúng tôi</a>
                                </li>
                                <li class="header__menu--items style2">
                                    <a class="header__menu--link " href="index.php?pg=contact" style="font-weight: bold;">Liên hệ </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="header__account header__account2 header__sticky--block">
                        <ul class="d-flex">
                            <li class="header__account--items header__account2--items  header__account--search__items d-none d-lg-block">
                                <a class="header__account--btn search__open--btn" href="javascript:void(0)" data-offcanvas>
                                    <svg class="header__search--button__svg" xmlns="http://www.w3.org/2000/svg" width="30.51" height="30.443" viewBox="0 0 512 512">
                                        <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32" />
                                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448" />
                                    </svg>
                                    <span class="visually-hidden">Tìm kiếm</span>
                                </a>
                            </li>
                            <li class="header__account--items header__account2--items">
                                <?= $html_account_scroll; ?>
                            </li>
                            <li class="header__account--items header__account2--items">
                                <a class="header__account--btn minicart__open--btn" href="javascript:void(0)" data-offcanvas>
                                    <svg class="product__items--action__btn--svg" xmlns="http://www.w3.org/2000/svg" width="30.51" height="30.443" viewBox="0 0 24 24">
                                        <g transform="translate(0 0)">
                                            <g>
                                                <path data-name="Path 1" d="M19 2h-1V1a1 1 0 0 0-2 0v1H8V1a1 1 0 0 0-2 0v1H5C3.346 2 2 3.346 2 5v14c0 1.654 1.346 3 3 3h14c1.654 0 3-1.346 3-3V5c0-1.654-1.346-3-3-3zm1 17c0 .551-.449 1-1 1H5c-.551 0-1-.449-1-1V9h16v10zm0-12H4V5c0-.551.449-1 1-1h1v1a1 1 0 0 0 2 0V4h8v1a1 1 0 0 0 2 0V4h1c.551 0 1 .449 1 1v2z" fill="currentColor"></path>
                                                <path data-name="Path 2" d="M7 12h2v2H7zM11 12h2v2h-2zM15 12h2v2h-2zM7 16h2v2H7zM11 16h2v2h-2zM15 16h2v2h-2z" fill="currentColor"></path>
                                            </g>
                                        </g>
                                    </svg>
                                    <span class="items__count style2" id="cart-item-count"><?php echo count($_SESSION['giohang']); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="header__bottom">
            <div class="container-fluid">
                <div class="header__bottom--inner position__relative d-none d-lg-flex justify-content-between align-items-center">
                    <div class="header__menu">
                        <nav class="header__menu--navigation">
                            <ul class="d-flex">
                                <li class="header__menu--items">
                                    <a class="header__menu--link" href="index.php" style="font-weight: bold;">Trang chủ<a>
                                </li>
                                <li class="header__menu--items mega__menu--items">
                                    <a class="header__menu--link" href="index.php?pg=shop" style="font-weight: bold;">Cửa hàng</a>
                                </li>
                                <li class="header__menu--items mega__menu--items">
                                    <a class="header__menu--link" href="index.php?pg=services" style="font-weight: bold;">Dịch vụ</a>
                                </li>
                                <li class="header__menu--items">
                                    <a class="header__menu--link" href="index.php?pg=blog" style="font-weight: bold;">Tin tức</a>
                                </li>
                                <li class="header__menu--items">
                                    <a class="header__menu--link" href="index.php?pg=about" style="font-weight: bold;">Về chúng tôi</a>
                                </li>
                                <li class="header__menu--items">
                                    <a class="header__menu--link" href="index.php?pg=contact" style="font-weight: bold;">Liên hệ </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Start Offcanvas header menu -->
        <div class="offcanvas__header">
            <div class="offcanvas__inner">
                <div class="offcanvas__logo">
                    <a class="offcanvas__logo_link" href="index.php">
                        <img src="./view/assets/img/logo/nav-log.png" alt="Grocee Logo" width="158" height="36">
                    </a>
                    <button class="offcanvas__close--btn" data-offcanvas>close</button>
                </div>
                <nav class="offcanvas__menu">
                    <ul class="offcanvas__menu_ul">
                        <li class="offcanvas__menu_li">
                            <a class="offcanvas__menu_item" href="index.php">TRANG CHỦ</a>
                        </li>
                        <li class="offcanvas__menu_li">
                            <a class="offcanvas__menu_item" href="index.php?pg=shop">CỬA HÀNG</a>
                        </li>
                        <li class="offcanvas__menu_li">
                            <a class="offcanvas__menu_item" href="index.php?pg=services">DỊCH VỤ</a>
                        </li>
                        <li class="offcanvas__menu_li">
                            <a class="offcanvas__menu_item" href="index.php?pg=blog">TIN TỨC</a>
                        </li>
                        <li class="offcanvas__menu_li"><a class="offcanvas__menu_item" href="index.php?pg=about">VỀ
                                CHÚNG TÔI</a></li>
                        <li class="offcanvas__menu_li"><a class="offcanvas__menu_item" href="index.php?pg=contact">LIÊN
                                HỆ</a></li>
                    </ul>
                    <div class="offcanvas__account--items">
                        <?= $html_account_mobile; ?>
                    </div>
                    <div class="language__currency">
                        <ul class="d-flex align-items-center">
                            <li class="language__currency--list">
                                <a class="offcanvas__language--switcher" href="#">
                                    <span>Việt Nam</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11.797" height="9.05" viewBox="0 0 9.797 6.05">
                                        <path d="M14.646,8.59,10.9,12.329,7.151,8.59,6,9.741l4.9,4.9,4.9-4.9Z" transform="translate(-6 -8.59)" fill="currentColor" opacity="0.7" />
                                    </svg>
                                </a>

                            </li>
                            <li class="language__currency--list">
                                <a class="offcanvas__account--currency__menu" href="#">
                                    <span>VNĐ</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11.797" height="9.05" viewBox="0 0 9.797 6.05">
                                        <path d="M14.646,8.59,10.9,12.329,7.151,8.59,6,9.741l4.9,4.9,4.9-4.9Z" transform="translate(-6 -8.59)" fill="currentColor" opacity="0.7" />
                                    </svg>
                                </a>
                                <div class="offcanvas__account--currency__submenu">
                                    <ul>
                                        <li class="currency__items"><a class="currency__text" href="#">$ US Dollar</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!-- End Offcanvas header menu -->

        <!-- Start Offcanvas stikcy toolbar -->
        <div class="offcanvas__stikcy--toolbar">
            <ul class="d-flex justify-content-between">
                <li class="offcanvas__stikcy--toolbar__list">
                    <a class="offcanvas__stikcy--toolbar__btn" href="index.php">
                        <span class="offcanvas__stikcy--toolbar__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" width="21.51" height="21.443" viewBox="0 0 22 17">
                                <path fill="currentColor" d="M20.9141 7.93359c.1406.11719.2109.26953.2109.45703 0 .14063-.0469.25782-.1406.35157l-.3516.42187c-.1172.14063-.2578.21094-.4219.21094-.1406 0-.2578-.04688-.3515-.14062l-.9844-.77344V15c0 .3047-.1172.5625-.3516.7734-.2109.2344-.4687.3516-.7734.3516h-4.5c-.3047 0-.5742-.1172-.8086-.3516-.2109-.2109-.3164-.4687-.3164-.7734v-3.6562h-2.25V15c0 .3047-.11719.5625-.35156.7734-.21094.2344-.46875.3516-.77344.3516h-4.5c-.30469 0-.57422-.1172-.80859-.3516-.21094-.2109-.31641-.4687-.31641-.7734V8.46094l-.94922.77344c-.11719.09374-.24609.14062-.38672.14062-.16406 0-.30468-.07031-.42187-.21094l-.35157-.42187C.921875 8.625.875 8.50781.875 8.39062c0-.1875.070312-.33984.21094-.45703L9.73438.832031C10.1094.527344 10.5312.375 11 .375s.8906.152344 1.2656.457031l8.6485 7.101559zm-3.7266 6.50391V7.05469L11 1.99219l-6.1875 5.0625v7.38281h3.375v-3.6563c0-.3046.10547-.5624.31641-.7734.23437-.23436.5039-.35155.80859-.35155h3.375c.3047 0 .5625.11719.7734.35155.2344.211.3516.4688.3516.7734v3.6563h3.375z">
                                </path>
                            </svg>
                        </span>
                        <span class="offcanvas__stikcy--toolbar__label">Trang chủ</span>
                    </a>
                </li>
                <li class="offcanvas__stikcy--toolbar__list">
                    <a class="offcanvas__stikcy--toolbar__btn" href="index.php?pg=shop">
                        <span class="offcanvas__stikcy--toolbar__icon">
                            <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="18.51" height="17.443" viewBox="0 0 448 512">
                                <path d="M416 32H32A32 32 0 0 0 0 64v384a32 32 0 0 0 32 32h384a32 32 0 0 0 32-32V64a32 32 0 0 0-32-32zm-16 48v152H248V80zm-200 0v152H48V80zM48 432V280h152v152zm200 0V280h152v152z">
                                </path>
                            </svg>
                        </span>
                        <span class="offcanvas__stikcy--toolbar__label">Cửa hàng</span>
                    </a>
                </li>
                <li class="offcanvas__stikcy--toolbar__list">
                    <a class="offcanvas__stikcy--toolbar__btn" href="index.php?pg=services">
                        <span class="offcanvas__stikcy--toolbar__icon">
                            <svg class="product__items--action__btn--svg" xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 24 24">
                                <g transform="translate(0 0)">
                                    <g>
                                        <path data-name="Path 1" d="M19 2h-1V1a1 1 0 0 0-2 0v1H8V1a1 1 0 0 0-2 0v1H5C3.346 2 2 3.346 2 5v14c0 1.654 1.346 3 3 3h14c1.654 0 3-1.346 3-3V5c0-1.654-1.346-3-3-3zm1 17c0 .551-.449 1-1 1H5c-.551 0-1-.449-1-1V9h16v10zm0-12H4V5c0-.551.449-1 1-1h1v1a1 1 0 0 0 2 0V4h8v1a1 1 0 0 0 2 0V4h1c.551 0 1 .449 1 1v2z" fill="currentColor"></path>
                                        <path data-name="Path 2" d="M7 12h2v2H7zM11 12h2v2h-2zM15 12h2v2h-2zM7 16h2v2H7zM11 16h2v2h-2zM15 16h2v2h-2z" fill="currentColor"></path>
                                    </g>
                                </g>
                            </svg>
                        </span>
                        <span class="offcanvas__stikcy--toolbar__label">Dịch vụ</span>
                    </a>
                </li>


                <li class="offcanvas__stikcy--toolbar__list ">
                    <a class="offcanvas__stikcy--toolbar__btn search__open--btn" href="javascript:void(0)" data-offcanvas>
                        <span class="offcanvas__stikcy--toolbar__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 512 512">
                                <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32" />
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448" />
                            </svg>
                        </span>
                        <span class="offcanvas__stikcy--toolbar__label">Tìm kiếm</span>
                    </a>
                </li>
                <li class="offcanvas__stikcy--toolbar__list">
                    <a class="offcanvas__stikcy--toolbar__btn minicart__open--btn" href="javascript:void(0)" data-offcanvas>
                        <span class="offcanvas__stikcy--toolbar__icon">
                            <svg class="product__items--action__btn--svg" xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 24 24">
                                <g transform="translate(0 0)">
                                    <g>
                                        <path data-name="Path 1" d="M19 2h-1V1a1 1 0 0 0-2 0v1H8V1a1 1 0 0 0-2 0v1H5C3.346 2 2 3.346 2 5v14c0 1.654 1.346 3 3 3h14c1.654 0 3-1.346 3-3V5c0-1.654-1.346-3-3-3zm1 17c0 .551-.449 1-1 1H5c-.551 0-1-.449-1-1V9h16v10zm0-12H4V5c0-.551.449-1 1-1h1v1a1 1 0 0 0 2 0V4h8v1a1 1 0 0 0 2 0V4h1c.551 0 1 .449 1 1v2z" fill="currentColor"></path>
                                        <path data-name="Path 2" d="M7 12h2v2H7zM11 12h2v2h-2zM15 12h2v2h-2zM7 16h2v2H7zM11 16h2v2h-2zM15 16h2v2h-2z" fill="currentColor"></path>
                                    </g>
                                </g>
                            </svg>
                        </span>
                        <span class="offcanvas__stikcy--toolbar__label">Lịch hẹn</span>
                        <span class="items__count" id="cart-item-count"><?php echo count($_SESSION['giohang']); ?></span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End Offcanvas stikcy toolbar -->

        <!-- Start offCanvas minicart -->
        <div class="offCanvas__minicart">
            <div class="minicart__header ">
                <div class="minicart__header--top d-flex justify-content-between align-items-center">
                    <h2 class="minicart__title h3">Lịch hẹn</h2>
                    <button class="minicart__close--btn" aria-label="minicart close button" data-offcanvas>
                        <svg class="minicart__close--icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M368 368L144 144M368 144L144 368" />
                        </svg>
                    </button>
                </div>
                <!-- <p class="minicart__header--desc">Clothing and fashion products are limited</p> -->
            </div>
            <div class="minicart__product">
                <?= $html_cart; ?>
            </div>
            <div class="minicart__amount">
                <div class="minicart__amount_list d-flex justify-content-between">
                    <span>Tạm Tính:</span>
                    <span id="totalAmount"><b><?= number_format($sum, 0, ",", ".") ?>VNĐ</b></span>
                </div>
                <div class="minicart__amount_list d-flex justify-content-between">
                    <span>Tổng:</span>
                    <span id="totalAmount"><b><?= number_format($sum, 0, ",", ".") ?>VNĐ</b></span>
                </div>
            </div>
            <div class="minicart__conditions text-center">
                <input class="minicart__conditions--input" id="accept" type="checkbox">
                <label class="minicart__conditions--label" for="accept">Tôi đồng ý với <a class="minicart__conditions--link" href="index.php?pg=privacy-policy">Chính sách và quyền riêng
                        tư</a></label>
            </div>
            <div class="minicart__button d-flex justify-content-center">
                <a class="primary__btn minicart__button--link" href="index.php?pg=cart">Đặt Lịch hẹn</a>
            </div>
        </div>
        <!-- End offCanvas minicart -->

        <!-- Start serch box area -->
        <div class="predictive__search--box ">
            <div class="predictive__search--box__inner">
                <h2 class="predictive__search--title">Tìm Kiếm Sản Phẩm</h2>
                <form class="predictive__search--form" action="index.php?pg=shop" method="post">
                    <label>
                        <input class="predictive__search--input" placeholder="Tìm kiếm" type="text" name="kyw">
                    </label>
                    <button class="predictive__search--button" aria-label="search button" type="submit" name="search">
                        <svg class="header__search--button__svg" xmlns="http://www.w3.org/2000/svg" width="30.51" height="25.443" viewBox="0 0 512 512">
                            <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32" />
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448" />
                        </svg>
                    </button>
                </form>
            </div>
            <button class="predictive__search--close__btn" aria-label="search close button" data-offcanvas>
                <svg class="predictive__search--close__icon" xmlns="http://www.w3.org/2000/svg" width="40.51" height="30.443" viewBox="0 0 512 512">
                    <path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M368 368L144 144M368 144L144 368" />
                </svg>
            </button>
        </div>
        <!-- End serch box area -->

    </header>
    <!-- End header area -->