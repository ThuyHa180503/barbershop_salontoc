<?php
// Default date range (current month)
$start_date = date('Y-m-01');
$end_date = date('Y-m-t');

// Update date range if form is submitted
if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
}
// Assuming this is where you handle the search POST request
if (isset($_POST["search"])) {
    $kyw = $_POST["kyw"];
    // Assuming $start_date and $end_date are defined somewhere
    $categorized_appointments = get_appointments_by_status_($start_date, $end_date, $kyw);
} else {
    // Default behavior without search
    $categorized_appointments = get_appointments_by_status_($start_date, $end_date);
}
// Fetch categorized appointments based on the specified date range

$pending_appointments = $categorized_appointments['pending'];

// Generate HTML for pending appointments
$html_pending = '';
foreach ($pending_appointments as $order) {
    $paymentMethod = ($order['pttt'] == 0) ? 'Thanh toán tại quầy' : 'Thanh toán chuyển khoản';

    $html_pending .= '<tr>
                        <td>#' . $order['mahd'] . '</td>
                        <td><b>' . $order['name'] . '</b></td>
                        <td><b>' . $order['nguoidat_ten'] . '</b></td>
                        <td>' . number_format($order['tongthanhtoan'], 0, ",", ".") . ' VNĐ</td>
                        <td>' . $order['appointment_date'] . '</td>
                        <td>' . $paymentMethod . '</td>
                                <td class="text-end">
                                <a href="index.php?pg=invoices-detail&id=' . $order['id'] . '" class="btn btn-md rounded font-sm">Chi tiết</a>
                            </td>
                    </tr>';
}
?>

<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Danh sách hóa đơn</h2>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <header class="card-header">
                    <div class="row align-items-center gx-3">
                        <!-- Date Range Filter Form -->
                        <div class="col-lg-8 col-md-6">
                            <form action="index.php?pg=invoices" method="post" class="mb-3 mb-md-0">
                                <div class="row align-items-center">
                                    <div class="col-md-auto mb-2">
                                        <label for="start_date" class="visually-hidden">From</label>
                                        <input type="date" id="start_date" name="start_date" value="<?= htmlspecialchars($start_date) ?>" class="form-control">
                                    </div>
                                    <div class="col-md-auto mb-2">
                                        <label for="end_date" class="visually-hidden">To</label>
                                        <input type="date" id="end_date" name="end_date" value="<?= htmlspecialchars($end_date) ?>" class="form-control">
                                    </div>
                                    <div class="col-md-auto mb-2">
                                        <button type="submit" class="btn btn-primary">Lọc</button>
                                    </div>
                                </div>
                            </form>

                        </div>

                        <!-- Product Search Form -->
                        <div class="col-lg-4 col-md-6">
                            <form action="index.php?pg=invoices" method="post" class="mb-3 mb-md-0">
                                <div class="input-group">
                                    <input type="text" name="kyw" placeholder="Tìm kiếm theo tên nhân viên..." class="form-control">
                                    <button type="submit" name="search" class="btn btn-light">
                                        <i class="material-icons md-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </header>

                <div class="card-body">
                    <div class="table-responsive mb-4">
                        <table class="table table-hover product-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên Nhân viên</th>
                                    <th>Tên Khách Hàng</th>
                                    <th>Tổng Tiền</th>
                                    <th>Ngày Làm dịch vụ</th>
                                    <th>Thanh toán</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?= $html_pending; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('.product-table');
        var rows = table.find('tbody tr');
        var rowsPerPage = 4;
        var currentPage = 1;

        // Hide all rows except the first one
        rows.hide().slice(0, rowsPerPage).show();

        // Add pagination controls
        var pageCount = Math.ceil(rows.length / rowsPerPage);
        var pagination = $('<div class="pagination"  style="text-align: center; justify-content: center;" ></div>');
        for (var i = 1; i <= pageCount; i++) {
            $('<a href="#" class="page-link" style="color: white; background-color: black; border-radius: 5px; margin-top:10px;">' + i + '</a>').appendTo(pagination).click(function() {
                currentPage = parseInt($(this).text());
                updateTable();
            });
        }
        pagination.insertAfter(table);

        function updateTable() {
            var start = (currentPage - 1) * rowsPerPage;
            var end = start + rowsPerPage;
            rows.hide().slice(start, end).show();
        }
    });
</script>