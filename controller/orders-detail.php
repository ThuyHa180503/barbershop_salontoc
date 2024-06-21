<?php
if (isset($_GET['id']) && ($_GET["id"] > 0)) {
    $id = $_GET['id'];
    if (isset($_SESSION['s_user'])) {
        $iduser = $_SESSION['s_user']['id'];
    }
    $ordercart = get_cart_by_id_client($id);
    $orderdetail = get_order_by_id($id);
    include "view/order-detail.php";
} else {
    include "view/home.php";
}
