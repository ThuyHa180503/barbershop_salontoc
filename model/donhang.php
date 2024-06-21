<?php
require_once 'pdo.php';
function order_insert_id($mahd, $iduser, $nguoidat_ten, $nguoidat_email, $nguoidat_tel, $nguoidat_diachi, $note, $total, $ship, $voucher, $tongthanhtoan, $pttt, $date, $time, $appointment_date)
{
    $sql = "INSERT INTO orders (mahd, iduser, nguoidat_ten, nguoidat_email, nguoidat_tel, nguoidat_diachi, note, total, ship, voucher, tongthanhtoan, pttt, date, time,appointment_date) VALUES (?, ?, ?, ?, ?, ? ,?, ?, ?, ?, ?, ?, ?, ?, ?)";
    return pdo_execute_id($sql, $mahd, $iduser, $nguoidat_ten, $nguoidat_email, $nguoidat_tel, $nguoidat_diachi, $note, $total, $ship, $voucher, $tongthanhtoan, $pttt, $date, $time, $appointment_date);
}

function get_order_limi($limi)
{
    $sql = "SELECT * FROM orders ORDER BY id DESC limit " . $limi;
    return pdo_query($sql);
}

function get_order_home()
{
    $sql = "SELECT * FROM orders";
    return pdo_query($sql);
}
function count_completed_orders()
{
    $sql = "SELECT COUNT(*) as total_completed_orders FROM orders WHERE status = 4";
    $result = pdo_query($sql);
    return $result[0]['total_completed_orders'];
}
function count_pending_orders()
{
    $sql = "SELECT COUNT(*) as total_pending_orders FROM orders WHERE status = 1";
    $result = pdo_query($sql);
    return $result[0]['total_pending_orders'];
}
function count_cancle_orders()
{
    $sql = "SELECT COUNT(*) as total_pending_orders FROM orders WHERE status = 5";
    $result = pdo_query($sql);
    return $result[0]['total_pending_orders'];
}
function count_cancle1_orders()
{
    $sql = "SELECT COUNT(*) as total_cancle1_orders FROM orders WHERE status = 6";
    $result = pdo_query($sql);
    return $result[0]['total_cancle1_orders'];
}
function get_orders_today()
{
    $sql = "SELECT * FROM orders WHERE DATE(appointment_date) = CURDATE()";
    return pdo_query($sql);
}
function get_orders_current_quarter()
{
    $sql = "SELECT * FROM orders 
            WHERE QUARTER(appointment_date) = QUARTER(CURDATE()) 
              AND YEAR(appointment_date) = YEAR(CURDATE())";
    return pdo_query($sql);
}
function get_orders_current_year()
{
    $sql = "SELECT * FROM orders WHERE YEAR(appointment_date) = YEAR(CURDATE())";
    return pdo_query($sql);
}


function hien_thi_other($orderlist, $soluongother)
{
    $tong_other = count($orderlist);
    $so_trang_other = ceil($tong_other / $soluongother);
    $html_stother = "";
    for ($i = 1; $i <= $so_trang_other; $i++) {
        $html_stother .= '<li class="page-item active">
                            <a class="page-link" href="index.php?pg=orders&page=' . $i . '">' . $i . '</a>
                        </li>';
    }
    return $html_stother;
}

function get_order_all($kyw, $page, $soluongother)
{
    $batdau = ($page - 1) * $soluongother;
    $sql = "SELECT * FROM orders WHERE 1";

    if ($kyw != "") {
        $sql .= " AND mahd LIKE '%" . $kyw . "%'";
    }

    $sql .= " ORDER BY id ASC LIMIT " . $batdau . "," . $soluongother;

    return pdo_query($sql);
}

function get_other_all()
{
    $sql = " SELECT * FROM orders ORDER BY id ASC ";
    return pdo_query($sql);
}

function get_order($kyw, $status)
{
    $sql = "SELECT * FROM orders WHERE 1";

    if ($kyw != "") {
        $sql .= " AND mahd LIKE '%" . $kyw . "%'";
    }

    if ($status !== null) {
        $sql .= " AND status = " . $status;
    }

    $sql .= " ORDER BY id";

    return pdo_query($sql);
}


function get_orders_by_user($iduser)
{
    $sql = "SELECT * FROM orders WHERE iduser = $iduser ORDER BY id DESC";
    return pdo_query($sql);
}

function get_order_by_id($id)
{
    $sql = "SELECT * FROM orders WHERE id=?";
    return pdo_query_one($sql, $id);
}


function get_status($id)
{
    $sql = "SELECT status FROM orders WHERE id=" . $id;
    $kq = pdo_query_one($sql);
    return $kq["status"];
}

function update_order_total($order_id)
{
    // Lấy tổng giá trị của các mặt hàng trong giỏ hàng có idbill = $order_id
    $sql = "SELECT SUM(thanhtien) AS total FROM cart WHERE idbill = ?";
    $total_result = pdo_query_one($sql, $order_id);
    $total = $total_result['total'];

    // Cập nhật trường tongthanhtoan trong bảng orders
    $update_sql = "UPDATE orders SET tongthanhtoan = ? WHERE id = ?";
    pdo_execute($update_sql, $total, $order_id);
}

function update_employee_id($id, $status)
{
    $sql = "UPDATE orders SET employee_id = ? WHERE id = ?";
    pdo_execute($sql, $status, $id);
}

function get_appointments_by_time($start_date, $end_date)
{
    $pdo = pdo_get_connection();

    $sql = "SELECT * FROM orders WHERE appointment_date BETWEEN :start_date AND :end_date";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':start_date' => $start_date,
        ':end_date' => $end_date
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function get_monthly_revenue()
{
    $pdo = pdo_get_connection();

    $sql = "SELECT MONTH(appointment_date) as month, SUM(tongthanhtoan) as revenue
            FROM orders
            WHERE YEAR(appointment_date) = YEAR(CURDATE()) AND status = 4
            GROUP BY MONTH(appointment_date)
            ORDER BY MONTH(appointment_date)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function get_monthly_revenue_products()
{
    $pdo = pdo_get_connection();

    $sql = "SELECT MONTH(o.appointment_date) as month, SUM(c.thanhtien) as revenue
            FROM orders o
            JOIN cart c ON o.id = c.idbill
            JOIN products p ON c.idpro = p.id
            WHERE YEAR(o.appointment_date) = YEAR(CURDATE()) 
              AND o.status = 4 
              AND p.service = 0
            GROUP BY MONTH(o.appointment_date)
            ORDER BY MONTH(o.appointment_date)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_appointments_by_status($start_date, $end_date, $keyword = '')
{
    $pdo = pdo_get_connection();

    // Prepare the keyword for SQL LIKE clause
    $keyword = '%' . $keyword . '%';

    $sql_successful = "
        SELECT orders.*, users.name 
        FROM orders 
        JOIN users ON users.id = orders.iduser 
        WHERE orders.appointment_date BETWEEN :start_date AND :end_date 
        AND (users.name LIKE :keyword OR orders.nguoidat_ten LIKE :keyword)
        AND orders.status = 2
    ";
    $stmt_successful = $pdo->prepare($sql_successful);
    $stmt_successful->execute([
        ':start_date' => $start_date,
        ':end_date' => $end_date,
        ':keyword' => $keyword
    ]);
    $successful_appointments = $stmt_successful->fetchAll(PDO::FETCH_ASSOC);

    $sql_missed = "
        SELECT orders.*, users.name 
        FROM orders 
        JOIN users ON users.id = orders.iduser 
        WHERE orders.appointment_date BETWEEN :start_date AND :end_date 
        AND (users.name LIKE :keyword OR orders.nguoidat_ten LIKE :keyword)
        AND orders.status = 1
    ";
    $stmt_missed = $pdo->prepare($sql_missed);
    $stmt_missed->execute([
        ':start_date' => $start_date,
        ':end_date' => $end_date,
        ':keyword' => $keyword
    ]);
    $missed_appointments = $stmt_missed->fetchAll(PDO::FETCH_ASSOC);

    $sql_cancel = "
        SELECT orders.*, users.name 
        FROM orders 
        JOIN users ON users.id = orders.iduser 
        WHERE orders.appointment_date BETWEEN :start_date AND :end_date 
        AND (users.name LIKE :keyword OR orders.nguoidat_ten LIKE :keyword)
        AND orders.status = 5
    ";
    $stmt_cancel = $pdo->prepare($sql_cancel);
    $stmt_cancel->execute([
        ':start_date' => $start_date,
        ':end_date' => $end_date,
        ':keyword' => $keyword
    ]);
    $cancel_appointments = $stmt_cancel->fetchAll(PDO::FETCH_ASSOC);

    $sql_cancel1 = "
        SELECT orders.*, users.name 
        FROM orders 
        JOIN users ON users.id = orders.iduser 
        WHERE orders.appointment_date BETWEEN :start_date AND :end_date 
        AND (users.name LIKE :keyword OR orders.nguoidat_ten LIKE :keyword)
        AND orders.status = 6
    ";
    $stmt_cancel1 = $pdo->prepare($sql_cancel1);
    $stmt_cancel1->execute([
        ':start_date' => $start_date,
        ':end_date' => $end_date,
        ':keyword' => $keyword
    ]);
    $cancel1_appointments = $stmt_cancel1->fetchAll(PDO::FETCH_ASSOC);

    return [
        'successful' => $successful_appointments,
        'missed' => $missed_appointments,
        'cancel' => $cancel_appointments,
        'cancel1' => $cancel1_appointments,
    ];
}
//ĐÂY LÀ ĐƠN HÀNG HOÀN THÀNH --TUY NHIÊN ĐỔI TÊN SỢ LỖI
function get_appointments_by_status_($start_date, $end_date, $kyw = null)
{
    $pdo = pdo_get_connection();

    // Base SQL query to select pending appointments within the date range and status 0, including user name
    $sql_pending = "
        SELECT orders.*, users.name AS name
        FROM orders 
        JOIN users ON users.id = orders.employee_id 
        WHERE orders.appointment_date BETWEEN :start_date AND :end_date 
        AND orders.status = 4
    ";

    // If $kyw (keyword) is provided, add filter by users.name
    if ($kyw !== null) {
        $sql_pending .= " AND users.name LIKE :keyword";
        $stmt_pending = $pdo->prepare($sql_pending);
        $stmt_pending->execute([
            ':start_date' => $start_date,
            ':end_date' => $end_date,
            ':keyword' => '%' . $kyw . '%'
        ]);
    } else {
        // Execute the base query without any additional filters
        $stmt_pending = $pdo->prepare($sql_pending);
        $stmt_pending->execute([
            ':start_date' => $start_date,
            ':end_date' => $end_date
        ]);
    }

    $pending_appointments = $stmt_pending->fetchAll(PDO::FETCH_ASSOC);

    return [
        'pending' => $pending_appointments,
    ];
}
//ĐÂY LÀ ĐƠN HÀNG HOÀN THÀNH --TUY NHIÊN ĐỔI TÊN SỢ LỖI
function get_appointments_by_status_order($start_date, $end_date, $kyw = null)
{
    $pdo = pdo_get_connection();

    // Base SQL query to select pending appointments within the date range and status 0, including user name
    $sql = "
        SELECT orders.*, users.name AS name
        FROM orders 
        JOIN users ON users.id = orders.employee_id 
        WHERE orders.appointment_date BETWEEN :start_date AND :end_date 
    ";
    if ($kyw) {
        $sql .= " AND orders.customer_name LIKE :keyword";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);

    if ($kyw) {
        $keyword = "%{$kyw}%";
        $stmt->bindParam(':keyword', $keyword);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}





function update_status($id, $status)
{
    $sql = "UPDATE orders SET status = ? WHERE id = ?";
    pdo_execute($sql, $status, $id);
}
