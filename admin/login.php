<?php
session_start();
include "../model/pdo.php";
include "../model/user.php";
// ob_start();
if (isset($_POST["login"])) {
    $uname = $_POST["uname"];
    $pass = $_POST["pass"];
    $user = checkuser($uname, $pass);
    if (isset($user) && (is_array($user)) && (count($user) > 0)) {
        extract($user);
        if ($role == 1) {
            $_SESSION['s_user'] = $user;
            header('location: index.php');
        } else {
            $tb = "Tài khoản này không có quyền đăng nhập trang quản trị";
        }
    } else {
        if (empty($uname) || empty($pass)) {
            $tb = "Vui lòng điền đầy đủ thông tin !";
        } else {
            $tb = "Tài khoản này không tồn tại. Hoặc đã nhầm !";
        }
    }
}
?>

<!DOCTYPE HTML>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <title>BarberShop | Đăng nhập</title>
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
</head>

<body>
    <main>
        <header class="main-header style-2 navbar">
            <div class="col-brand">
                <a href="index.php" class="brand-wrap">
                    <img src="./view/assets/imgs/theme/nav-log.png" class="logo" alt="BarberShop Dashboard">
                </a>
            </div>
            <div class="col-nav">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link btn-icon darkmode" href="#"> <i class="material-icons md-nights_stay"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="requestfullscreen nav-link btn-icon"><i class="material-icons md-cast"></i></a>
                    </li>
                    <li class="dropdown nav-item">
                        <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" id="dropdownLanguage" aria-expanded="false"><i class="material-icons md-public"></i></a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownLanguage">
                            <a class="dropdown-item text-brand" href="#"><img src="./view/assets/imgs/theme/flag-us.png" alt="English">English</a>
                            <a class="dropdown-item" href="#"><img src="./view/assets/imgs/theme/flag-fr.png" alt="Français">Français</a>
                        </div>
                    </li>
                </ul>
            </div>
        </header>
        <section class="content-main mt-80 mb-80">
            <div class="card mx-auto card-login">
                <div class="card-body">
                    <h4 class="card-title mb-4">Đăng nhập</h4>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="mb-3">
                            <input class="form-control" placeholder="Tên người dùng" type="text" name="uname">
                        </div>
                        <!-- form-group// -->
                        <div class="mb-3">
                            <input class="form-control" placeholder="Mật khẩu" type="password" name="pass">
                        </div>
                        <!-- form-group// -->
                        <div class="mb-3">
                            <label class="form-check">
                                <input type="checkbox" class="form-check-input" checked="">
                                <span class="form-check-label">Ghi nhớ mật khẩu</span>
                            </label>
                        </div>
                        <!-- form-group form-check .// -->
                        <div class="mb-4">
                            <?php
                            if (isset($tb) && ($tb != "")) {
                                echo "<span style='color: red;'>" . $tb . "</span> <br> <br> ";
                            }
                            ?>
                            <button type="submit" class="btn btn-primary w-100" name="login"> Đăng nhập </button>
                        </div>
                        <!-- form-group// -->

                </div>
        </section>
        <footer class="main-footer text-center">
            <p class="font-xs">
                <script>
                    document.write(new Date().getFullYear())
                </script> ©, BarberShop - Fashion .
            </p>
            <p class="font-xs mb-30">Thiết kế bởi nhóm 6</p>
        </footer>
    </main>
    <script src="./view/assets/js/vendors/jquery-3.6.0.min.js"></script>
    <script src="./view/assets/js/vendors/bootstrap.bundle.min.js"></script>
    <script src="./view/assets/js/vendors/jquery.fullscreen.min.js"></script>
    <!-- Main Script -->
    <script src="./view/assets/js/main.js" type="text/javascript"></script>
</body>

</html>