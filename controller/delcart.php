<?php
if (isset($_GET['ind']) && ($_GET['ind'] >= 0)) {
    array_splice($_SESSION['giohang'], $_GET['ind'], 1);
    header('location: index.php?pg=cart');
}
