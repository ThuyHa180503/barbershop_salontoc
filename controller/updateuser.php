<?php
// xác định giá trị input
if (isset($_POST["update"])) {
    $username = $_POST["username"];
    // $password=$_POST["password"];
    $email = $_POST["email"];
    $name = $_POST["name"];
    $address = $_POST["address"];
    $sdt = $_POST["sdt"];
    $id = $_POST["id"];
    $role = 0;

    $img = $_FILES["img"]["name"];
    $target_file = IMG_PATH_USER . basename($img);
    if ($img != "") {
        //upload hình
        $target_file = IMG_PATH_USER . $img;
        move_uploaded_file($_FILES["img"]["tmp_name"], $target_file);

        // //xóa hình cũ trên host
        // $old_img=IMG_PATH_USER.$_POST['old_img'];
        // if(file_exists($old_img)) unlink($old_img);

    } else {
        $img = "";
    }
    //xử lý
    user_update($username, $password, $email, $name, $img, $address, $sdt, $role, $id);

    include "view/my-account.php";
}
