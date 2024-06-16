<?php
require_once 'pdo.php';

function cart_insert($idpro, $price, $name, $img, $soluong, $thanhtien, $idbill)
{
    $sql = "INSERT INTO cart(idpro, price, name, img, soluong, thanhtien, idbill) VALUES (?, ?, ?, ?, ?, ?, ?)";
    pdo_execute($sql, $idpro, $price, $name, $img, $soluong, $thanhtien, $idbill);
}

function update_quantity_product($idpro, $soluong)
{
    $sql = "UPDATE cart SET soluong=? WHERE idpro=?";
    pdo_execute($sql, $soluong, $idpro);
}

function get_tongdonhang()
{
    // Calculate total order amount
    $total = 0;

    // Loop through each product in the cart
    foreach ($_SESSION['giohang'] as $sp) {
        $amount = $sp['amount'];
        $gia = $sp['price'];
        $thanhtien = $amount * $gia;

        $total += $thanhtien;
    }

    return $total;
}

function get_cart_by_id($id, $service = 0)
{
    // Use prepared statement to avoid SQL injection
    $sql = "SELECT c.*, p.name FROM cart c JOIN product p ON c.idpro = p.id WHERE c.idbill = ? AND p.service = ?";
    $result = pdo_query($sql, $id, $service);
    return $result;
}

function get_cart_by_id_client($id)
{
    // Use prepared statement to avoid SQL injection
    $sql = "SELECT c.*, p.name FROM cart c JOIN product p ON c.idpro = p.id WHERE c.idbill = ?";
    $result = pdo_query($sql, $id);
    return $result;
}

function get_cart_by_id_service($id, $service = 1)
{
    // Use prepared statement to avoid SQL injection
    $sql = "SELECT c.*, p.name FROM cart c JOIN product p ON c.idpro = p.id WHERE c.idbill = ? AND p.service = ?";
    $result = pdo_query($sql, $id, $service);
    return $result;
}

function cart_remove($idpro, $idbill)
{
    $sql = "DELETE FROM cart WHERE idpro = ? AND idbill = ?";
    pdo_execute($sql, $idpro, $idbill);
}

function get_cart_item($idpro, $idbill)
{
    $sql = "SELECT * FROM cart WHERE idpro = ? AND idbill = ?";
    return pdo_query_one($sql, $idpro, $idbill);
}

function cart_update($idpro, $soluong, $thanhtien, $idbill)
{
    $sql = "UPDATE cart SET soluong = ?, thanhtien = ? WHERE idpro = ? AND idbill = ?";
    pdo_execute($sql, $soluong, $thanhtien, $idpro, $idbill);
}

// Example implementation of the pdo_query function