<?php
$iduser = "";
if (isset($_GET['idpro']) && ($_GET["idpro"] > 0)) {
    $id = $_GET['idpro'];
    $iddm = get_iddm($id);
    $spchitiet = get_sp_by_id($id);
    $splienquan = get_dssp_lienquan($iddm, $id, 4);
    $commentlist = comment_select_by_idpro($id);
    include "view/product-details.php";
} else {
    include "view/home.php";
}
