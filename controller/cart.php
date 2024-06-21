<?php
// Lấy danh sách sản phẩm mới nhất
$dssp_new = get_new(10);

// Kiểm tra nếu có tham số 'del' được gửi qua URL và giá trị của nó là '1'
if (isset($_GET['del']) && ($_GET['del'] == 1)) {
    // Xóa giỏ hàng
    unset($_SESSION["giohang"]);

    // Chuyển hướng về trang giỏ hàng
    header('Location: index.php?pg=cart');
    exit(); // Đảm bảo dừng thực thi sau khi chuyển hướng
} else {
    // Bao gồm tệp view/cart.php để hiển thị giỏ hàng
    include "view/cart.php";
}
