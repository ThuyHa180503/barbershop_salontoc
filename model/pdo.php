<?php

/**
 * Mở kết nối đến CSDL sử dụng PDO
 */
function pdo_get_connection()
{
    $dburl = "mysql:host=localhost;dbname=barbershop;charset=utf8;port=3306";
    $username = 'root';
    $password = '';

    $conn = new PDO($dburl, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
}
/**
 * Thực thi câu lệnh sql thao tác dữ liệu (INSERT, UPDATE, DELETE)
 * @param string $sql câu lệnh sql
 * @param array $args mảng giá trị cung cấp cho các tham số của $sql
 * @throws PDOException lỗi thực thi câu lệnh
 */
function pdo_execute($sql)
{
    $sql_args = array_slice(func_get_args(), 1);
    try {
        $conn = pdo_get_connection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($sql_args);
    } catch (PDOException $e) {
        throw $e;
    } finally {
        unset($conn);
    }
}
function pdo_execute_id($sql)
{
    $sql_args = array_slice(func_get_args(), 1);
    try {
        $conn = pdo_get_connection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($sql_args);
        return $conn->lastInsertId();
    } catch (PDOException $e) {
        throw $e;
    } finally {
        unset($conn);
    }
}
/**
 * Thực thi câu lệnh sql truy vấn dữ liệu (SELECT)
 * @param string $sql câu lệnh sql
 * @param array $args mảng giá trị cung cấp cho các tham số của $sql
 * @return array mảng các bản ghi
 * @throws PDOException lỗi thực thi câu lệnh
 */
function pdo_query($sql, ...$params)
{
    try {
        $conn = pdo_get_connection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        // In ra câu truy vấn SQL (đối với mục đích debug)
        // echo $stmt->queryString;
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows !== false ? $rows : [];
    } catch (PDOException $e) {
        throw $e;
    } finally {
        unset($conn);
    }
}
/**
 * Thực thi câu lệnh sql truy vấn một bản ghi
 * @param string $sql câu lệnh sql
 * @param array $args mảng giá trị cung cấp cho các tham số của $sql
 * @return array mảng chứa bản ghi
 * @throws PDOException lỗi thực thi câu lệnh
 */
function pdo_query_one($sql)
{
    $sql_args = array_slice(func_get_args(), 1);
    try {
        $conn = pdo_get_connection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($sql_args);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    } catch (PDOException $e) {
        throw $e;
    } finally {
        unset($conn);
    }
}

/**
 * Thực thi câu lệnh sql truy vấn một giá trị
 * @param string $sql câu lệnh sql
 * @param array $args mảng giá trị cung cấp cho các tham số của $sql
 * @return giá trị
 * @throws PDOException lỗi thực thi câu lệnh
 */
function pdo_query_value($sql)
{
    $sql_args = array_slice(func_get_args(), 1);
    try {
        $conn = pdo_get_connection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($sql_args);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return array_values($row)[0];
    } catch (PDOException $e) {
        throw $e;
    } finally {
        unset($conn);
    }
}
function encryptNumber($number)
{
    $password = 'securepassword';

    $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $charArray = str_split($charset);
    $length = strlen($charset);

    // Create a hash from the password
    $key = hash('sha256', $password);

    // Convert the number to a string to preserve leading zeros
    $numberString = str_pad(strval($number), 60, '0', STR_PAD_LEFT); // Pad the number with leading zeros to ensure it has 60 digits

    // Encrypt each digit, considering the position of the digit within the number
    $encrypted = '';
    for ($i = 0; $i < strlen($numberString); $i++) {
        $digit = $numberString[$i];
        // Generate a pseudo-random position based on the digit, position, and the key
        $pos = (ord($key[$i % strlen($key)]) + $i + $digit) % $length;
        $encrypted .= $charArray[$pos];
    }

    return $encrypted;
}


function decryptNumber($encrypted)
{
    $password = 'securepassword';

    $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $charArray = str_split($charset);
    $length = strlen($charset);

    // Create a hash from the password
    $key = hash('sha256', $password);

    // Decrypt each character
    $decrypted = '';
    $chars = str_split($encrypted);
    foreach ($chars as $char) {
        // Find the position of the character in the charset
        $pos = array_search($char, $charArray);
        // Reverse the pseudo-random position calculation to find the original digit
        for ($i = 0; $i < 10; $i++) {
            if ((ord($key[$i % strlen($key)]) + $i) % $length == $pos) {
                $decrypted .= $i;
                break;
            }
        }
    }

    return $decrypted;
}
