<?php
if (isset($_SESSION['s_user']) && (count($_SESSION['s_user']) > 0)) {
    unset($_SESSION['s_user']);
}
header('location: index.php');
