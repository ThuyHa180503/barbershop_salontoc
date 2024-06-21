<?php
if (isset($_SESSION['s_user']) && (count($_SESSION['s_user']) > 0)) {
    include "view/my-account.php";
}
