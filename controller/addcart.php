<?php

function updateCartItemCount()
{
    if (isset($_SESSION['giohang'])) {
        $total_items = count($_SESSION['giohang']);
    } else {
        $total_items = 0;
    }
    echo '<script>updateCartItemCount(' . $total_items . ');</script>';
}

session_start();

if (isset($_POST["btnaddcart"])) {
    // Lấy thông tin sản phẩm từ form
    $id = $_POST['id'];
    $name = $_POST["name"];
    $appointment_date = $_POST["appointment_date"];
    $time = $_POST["time"];
    $img = $_POST["img"];
    $amount = 1; // Đảm bảo số lượng luôn là 1
    $price = $_POST["price"];
    $thanhtien = (int)$amount * (int)$price;

    // Tạo một mảng mới chứa thông tin sản phẩm
    $sp = array(
        "id" => $id,
        "name" => $name,
        "img" => $img,
        "price" => $price,
        "amount" => $amount,
        "thanhtien" => $thanhtien,
        "appointment_date" => $appointment_date,
        "time" => $time
    );

    // Kiểm tra xem giỏ hàng đã tồn tại hay chưa
    if (isset($_SESSION['giohang'])) {
        // Kiểm tra xem sản phẩm đã có trong giỏ hàng hay chưa
        $found = false;
        foreach ($_SESSION['giohang'] as &$item) {
            if ($item['id'] == $id) {
                // Nếu sản phẩm đã có trong giỏ hàng, giữ nguyên số lượng là 1
                $item['amount'] = 1;
                $item['thanhtien'] = (int)$item['amount'] * (int)$item['price'];
                $found = true;
                break;
            }
        }

        // Nếu sản phẩm chưa có trong giỏ hàng, thêm sản phẩm vào giỏ hàng
        if (!$found) {
            $_SESSION['giohang'][] = $sp;
        }
    } else {
        // Nếu giỏ hàng chưa tồn tại, tạo giỏ hàng mới và thêm sản phẩm vào
        $_SESSION['giohang'] = array($sp);
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng và chuyển hướng đến trang giỏ hàng
    updateCartItemCount();
    header('location: index.php?pg=cart');
}
