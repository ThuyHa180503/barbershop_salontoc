<?php
// session_start();
ob_start();
if (isset($_SESSION['s_user']) && (is_array($_SESSION['s_user'])) && (count($_SESSION['s_user']) > 0)) {
    $admin = $_SESSION['s_user'];
} else {
    header('location: login.php');
}
?>

<!DOCTYPE HTML>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <title>Barbershop | Trang chủ</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="./view/assets/imgs/favicon.ico">
    <!-- Template CSS -->
    <link href="./view/assets/css/main.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>
    <div class="screen-overlay"></div>
    <aside class="navbar-aside" id="offcanvas_aside">
        <div class="aside-top">
            <a href="index.php" class="brand-wrap">
                <img src="./view/assets/imgs/theme/nav-log.png" class="logo" alt="BarberShop Dashboard">
            </a>
            <div>
                <button class="btn btn-icon btn-aside-minimize"> <i class="text-muted material-icons md-menu_open"></i>
                </button>
            </div>
        </div>
        <nav>
            <ul class="menu-aside">
                <li class="menu-item "> <a class="menu-link" href="index.php"> <i class="icon material-icons md-home"></i> <span class="text">Trang Chủ</span> </a> </li>
                <li class="menu-item"> <a class="menu-link" href="index.php?pg=report"> <i class="icon material-icons md-report"></i> <span class="text">Báo cáo</span> </a> </li>
                <li class="menu-item"> <a class="menu-link" href="index.php?pg=products-list"> <i class="icon material-icons md-shopping_bag"></i> <span class="text">Sản Phẩm</span> </a>
                </li>
                <li class="menu-item"> <a class="menu-link" href="index.php?pg=services-list"> <i class="icon material-icons md-room_service"></i> <span class="text">Dịch vụ</span> </a>
                </li>
                <li class="menu-item"> <a class="menu-link" href="index.php?pg=categories"><i class="icon material-icons md-category"></i> <span class="text">Danh Mục</span> </a> </li>
                <li class="menu-item"> <a class="menu-link" href="index.php?pg=orders"><i class="icon material-icons md-schedule"></i> <span class="text">Lịch Hẹn</span> </a> </li>
                <li class="menu-item"> <a class="menu-link" href="index.php?pg=invoices"><i class="icon material-icons md-receipt"></i> <span class="text">Hóa Đơn</span> </a> </li>
                <li class="menu-item"> <a class="menu-link" href="index.php?pg=user-list"> <i class="icon material-icons md-person"></i> <span class="text">Tài Khoản</span> </a> </li>
                <li class="menu-item"> <a class="menu-link" href="index.php?pg=page-blog-list"><i class="icon material-icons md-add_box"></i> <span class="text">Tin Tức</span> </a> </li>
                <li class="menu-item"> <a class="menu-link" href="index.php?pg=page-review"> <i class="icon material-icons md-comment"></i> <span class="text">Đánh Giá</span> </a> </li>
            </ul>
            <br>
            <br>
        </nav>
    </aside>

    <main class="main-wrap">
        <header class="main-header navbar">
            <div class="col-search">
            </div>
            <div class="col-nav">
                <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside"> <i class="material-icons md-apps"></i> </button>
                <ul class="nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle btn-icon" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="material-icons md-notifications animation-shake"></i>
                            <span class="badge rounded-pill">3</span>
                        </a>
                        <?php

                        $recent_notifications_with_zero_recipient = get_recent_notifications_with_zero_recipient(); ?>
                        <style>
                            .dropdown-item {
                                display: flex;
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




                    <li class="dropdown nav-item">
                        <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" id="dropdownAccount" aria-expanded="false"> <img class="img-xs rounded-circle" src="./view/assets/imgs/people/quantri.jpg" alt="User"></a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownAccount">
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="logout.php"><i class="material-icons md-exit_to_app"></i>Đăng xuất</a>
                        </div>
                    </li>
                </ul>
            </div>
        </header>
        <script>
            // Lấy tham số pg từ URL
            const urlParams = new URLSearchParams(window.location.search);
            const pg = urlParams.get('pg');

            // Tìm tất cả các phần tử có class 'menu-item'
            const menuItems = document.querySelectorAll('.menu-item');

            // Duyệt qua từng phần tử và thêm class 'active' nếu có phù hợp với giá trị của pg
            menuItems.forEach(item => {
                const link = item.querySelector('.menu-link');
                const href = link.getAttribute('href');
                if (href && href.includes(`pg=${pg}`)) {
                    item.classList.add('active');
                }
            });
        </script>