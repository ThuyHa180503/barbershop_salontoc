<?php
session_start();
ob_start();
if (!isset($_SESSION["giohang"])) {
  $_SESSION["giohang"] = [];
}
// nhúng kết nối csdl
include "model/pdo.php";
include "model/global.php";
include "model/sanpham.php";
include "model/danhmuc.php";
include "model/binhluan.php";
include "model/donhang.php";
include "model/giohang.php";
include "model/tintuc.php";
include "model/dmuc-tintuc.php";
include "model/user.php";
include "model/notification.php";
require_once 'PHPMailer/Mailer.php';
include "view/header.php";
if (!isset($_GET['pg'])) {
  include "controller/home.php";
  include "view/home.php";
} else {
  switch ($_GET['pg']) {
    case 'signin-signup':
      $tbdk = "";
      include "view/login.php";
      break;
    case 'forgot-password':
      include "controller/forgot-password.php";
      include "view/forgot-password.php";
      break;
    case 'signup':
      $tbdk = "";
      include "view/signup.php";
      break;
    case 'reset-pass':
      include "controller/reset_pass.php";
      include "view/reset_pass.php";
      break;
    case 'signin':
      include "controller/signin.php";
      break;
    case 'verify':
      include "controller/verify.php";
      break;
    case 'logout':
      include "controller/logout.php";
      break;
    case 'adduser':
      include "controller/adduser.php";
      include "view/login.php";
      break;
    case 'updateuser':
      include "controller/updateuser.php";
      break;
    case 'my-account':
      include "controller/my-account.php";
      break;
    case 'change-pw':
      include "controller/change-pw.php";
      include "view/change-pw.php";
      break;
    case 'my-account-2';
      include "view/my-account-2.php";
      break;
    case 'my-account-3':
      include "controller/my-account-3.php";
      include "view/my-account-3.php";
      break;
    case 'orders-detail':
      include "controller/orders-detail.php";
      break;
    case 'order-cancelled':
      include "controller/order-cancelled.php";
      break;
    case 'shop':
      include "controller/shop.php";
      include "view/shop.php";
      break;
    case 'services':
      include "controller/services.php";
      include "view/services.php";
      break;
    case 'product-detail':
      include "controller/product-detail.php";
      break;
    case 'process-comment':
      include "controller/process-comment.php";
      break;
    case 'cart':
      include "controller/cart.php";
      break;
    case 'addcart':
      include "controller/addcart.php";
      include_once("./controller/AddToCart.php");
      break;
    case "edit":
      include "controller/edit.php";
      break;
    case 'delcart':
      include "controller/delcart.php";
      break;
    case 'delcart-box':
      include "controller/delcart-box.php";
      break;
    case 'checkout':
      include "controller/checkout.php";
      include "view/checkout.php";
      break;
    case 'checkout-2':
      include "controller/checkout-2.php";
      include "view/checkout-2.php";
      break;
    case 'blog':
      include "controller/blog.php";
      break;
    case 'blog-detail':
      include "controller/blog-detail.php";
      break;
    case 'about':
      include "view/about.php";
      break;
    case 'contact':
      include "view/contact.php";
      break;
    case 'privacy-policy':
      include "view/privacy-policy.php";
      break;
    default:
      include "view/home.php";
      break;
  }
}

include "view/footer.php";
