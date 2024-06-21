<?php $total_price = 0;
foreach ($_SESSION['cart_item'] as $k => $v) {
    if ($_POST["code"] == $k) {
        if ($_POST["quantity"] == '0') {
            unset($_SESSION["cart_item"][$k]);
        } else {
            $_SESSION['cart_item'][$k]["quantity"] = $_POST["quantity"];
        }
    }
    $total_price += $_SESSION['cart_item'][$k]["price"] * $_SESSION['cart_item'][$k]["quantity"];
}
if ($total_price != 0 && is_numeric($total_price)) {
    print "$" . number_format($total_price, 2);
    exit;
};
