<?php if (isset($_GET['idblog']) && ($_GET["idblog"] > 0)) {
    $id = $_GET['idblog'];
    $idloai = get_iddmuc($id);
    $blogchitiet = get_blog_by_id($id);
    $bloglienquan = get_blog_lienquan($idloai, $id, 2);
    include "view/blog-details.php";
} else {
    include "view/home.php";
};
