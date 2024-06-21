<?php
if (isset($_SESSION['s_user'])) {
    $iduser = $_SESSION['s_user']['id'];
}
$orderlist = get_orders_by_user($iduser);
