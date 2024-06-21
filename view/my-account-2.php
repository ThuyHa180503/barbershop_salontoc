<?php
if (isset($_SESSION['s_user']) && (count($_SESSION['s_user']) > 0)) {
    extract($_SESSION['s_user']);
    $userinfo = get_user($id);
    $_SESSION['s_user'] = $userinfo;
    extract($userinfo);
}
$imgpath = IMG_PATH_USER . $img;
if (is_file($imgpath)) {
    $img = '<img src="' . $imgpath . '" alt="" id="preview"/>';
    $old_img = basename($imgpath);
} else {
    $img = '';
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
            <div class="my__account--section__inner border-radius-10 d-flex">
                <div class="account__left--sidebar">
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
                    <form class="account__content" action="index.php?pg=updateuser" method="post" enctype="multipart/form-data">
                        <h3 class="account__content--title mb-20">Thông tin tài khoản</h3>
                        <div class="row">
                            <div class="col-3">
                                <div class="upload-image" style="justify-content: center; text-align: center;">
                                    <div class="image-container">
                                        <?= $img ?>
                                    </div>
                                    <div class="image-prev">
                                        <label for="userimage" id="imagelabel">Chọn ảnh</label> <br />
                                        <input class="account__login--input" type="file" name="img" id="userimage" onchange="showPreview(this)" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-9">
                                <label for="" style="font-weight: 600;">Tên tài khoản:</label>
                                <input class="account__login--input" placeholder="Tên của bạn" type="text" name="username" value="<?= $username ?>">
                                <label for="" style="font-weight: 600;">Email:</label>
                                <input class="account__login--input" placeholder="Email của bạn" type="text" name="email" value="<?= $email ?>">
                                <label for="" style="font-weight: 600;">Họ tên người dùng:</label>
                                <input class="account__login--input" placeholder="Họ và tên" type="text" name="name" value="<?= $name ?>">
                                <label for="" style="font-weight: 600;">Địa chỉ:</label>
                                <input class="account__login--input" placeholder="Địa chỉ" type="text" name="address" value="<?= $address ?>">
                                <label for="" style="font-weight: 600;">Số điện thoại:</label>
                                <input id="phone-input" class="checkout__input--field border-radius-5" placeholder="Số điện thoại" type="text" name="sdt" value="<?= $sdt ?>" required>
                                <div class="account__details--footer d-flex">
                                    <div class="input-hidden" hidden>
                                        <input type="hidden" name="id" value="<?= $id ?>">
                                        <input type="hidden" name="old_img" value="<?= $old_img ?>">
                                    </div>
                                    <button class="account__details--footer__btn" name="update" type="submit">Cập nhật</button>
                                    <a href="index.php?pg=change-pw">
                                        <button class="account__details--footer__btn" type="button">Đổi mật khẩu</button>
                                    </a>
                                </div>
                            </div>
                        </div>


                        <script>
                            document.getElementById('phone-input').addEventListener('input', function(e) {
                                var x = e.target.value.replace(/\D/g,
                                    ''); // Remove non-digit characters
                                if (x.length > 10) x = x.slice(0,
                                    10);
                                e.target.value = x;
                            });

                            document.getElementById('phone-input').addEventListener('blur', function(e) {
                                var x = e.target.value;
                                if (x.length !== 10) {
                                    alert('Số điện thoại phải có đúng 10 chữ số.');
                                    e.target.focus();
                                }
                            });
                        </script>


                    </form>
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