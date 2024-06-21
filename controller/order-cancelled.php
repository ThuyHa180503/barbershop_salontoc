<?php

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $id = $_GET['id'];
    if (isset($_SESSION['s_user'])) {
        $iduser = $_SESSION['s_user']['id'];
    }
    // Lấy trạng thái từ cơ sở dữ liệu hoặc bất kỳ nguồn dữ liệu nào khác
    $status = get_status($id);

    // Kiểm tra xem có phải đơn hàng đang ở trạng thái "Pending" hay không
    update_status($id, 6);
    $orderlist = get_orders_by_user($iduser);
    include "view/my-account-3.php";
} else {
    include "view/index.php";
}
