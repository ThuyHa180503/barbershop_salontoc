<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra xem các trường cần thiết có tồn tại không
    if (isset($_POST['idpro'], $_SESSION['s_user']['id'], $_POST['content'])) {
        $idpro = $_POST['idpro'];
        $iduser = $_SESSION['s_user']['id'];
        $content = $_POST['content'];
        $rating = $_POST['rating'];
        // Lấy ngày và giờ hiện tại
        $date = date('Y-m-d');
        $time = date('H:i:s');
        // Thực hiện chèn bình luận
        comment_insert($iduser, $idpro, $content, $date, $time, $rating);
        // Chuyển hướng sau khi thêm bình luận
        header("Location: index.php?pg=product-detail&idpro=$idpro");
        exit();
    }
}
