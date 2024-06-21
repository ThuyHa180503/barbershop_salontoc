<?php
if (isset($_SESSION['s_user']) && (count($_SESSION['s_user']) > 0)) {
    extract($_SESSION['s_user']);
    $userinfo = get_user($id);
    $_SESSION['s_user'] = $userinfo;
    extract($userinfo);
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
                            <li class="breadcrumb__content--menu__items"><a class="text-white" href="index.php">Trang chủ</a></li>
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
            <div class="my__account--section__inner border-radius-10 d-flex" style="width: auto;">
                <div class="account__left--sidebar" style="        width: 24rem;
">
                    <h2 class="account__content--title h3 mb-20">Thông tin của tôi</h2>
                    <ul class="account__menu">
                        <li class="account__menu--list active"><a href="index.php?pg=my-account">Tài khoản</a></li>
                        <li class="account__menu--list"><a href="index.php?pg=my-account-3">Lịch hẹn của tôi</a></li>
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
                        <h3 class="account__content--title mb-20">Thông tin tài khoản</h3>
                        <div class="account__details two">
                            <div class="container">
                                <style>
                                    .col-4 {
                                        display: flex;
                                        flex-direction: column;
                                        align-items: center;
                                        text-align: center;
                                        height: 100%;
                                        /* Chiều cao tối đa của phần tử */
                                    }

                                    .upload-image {
                                        margin-bottom: 10px;
                                        /* Khoảng cách với phần tử tiếp theo */
                                    }

                                    .image-container {
                                        width: 120px;
                                        /* Chiều rộng của ảnh */
                                        height: 120px;
                                        /* Chiều cao của ảnh */
                                        overflow: hidden;
                                        /* Ẩn phần ảnh vượt quá khung */
                                        border-radius: 50%;
                                        /* Bo tròn khung ảnh */
                                    }

                                    .account__details--footer {
                                        margin-top: auto;
                                        /* Đẩy phần tử nút lên gần phần tử ảnh */
                                    }
                                </style>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="upload-image">
                                        <div class="image-container">
                                            <img src="./uploads/<?= $img ?>" alt="" id="preview" />
                                        </div>
                                    </div>
                                    <div class="account__details--footer d-flex">
                                        <a href="index.php?pg=my-account-2">
                                            <button class="account__details--footer__btn" type="button">Cập nhật thông tin</button>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-8">
                                    <P>
                                        <strong style="color: #000">Tên tài khoản:</strong>
                                        <?= $username ?> <br>
                                        <strong style="color: #000">Email:</strong>
                                        <?= $email ?> <br>
                                        <strong style="color: #000">Họ và tên:</strong>
                                        <?= $name ?> <br>
                                        <strong style="color: #000">Địa chỉ:</strong>
                                        <?= $address ?> <br>
                                        <strong style="color: #000">Số điện thoại:</strong>
                                        <?= $sdt ?>
                                    </P>
                                </div>
                            </div>

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
                        <h2 class="shipping__items2--content__title h3">Dịch vụ</h2>
                        <p class="shipping__items2--content__desc">Chăm sóc tận tâm</p>
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
                        <p class="shipping__items2--content__desc">Hỗ trợ 24/7</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End shipping section -->

</main>