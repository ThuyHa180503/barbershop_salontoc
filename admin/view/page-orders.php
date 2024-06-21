<?php
pdo_update_expired_orders();
// Default date range (current month)
$start_date = date('Y-m-01');
$end_date = date('Y-m-t');

// Update date range if form is submitted
if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
}

// Handle search keyword
$search_keyword = isset($_POST['kyw']) ? $_POST['kyw'] : '';

// Fetch categorized appointments based on the specified date range and search keyword
$categorized_appointments = get_appointments_by_status($start_date, $end_date, $search_keyword);
$successful_appointments = $categorized_appointments['successful'];
$missed_appointments = $categorized_appointments['missed'];
$cancel_appointments = $categorized_appointments['cancel'];
$cancel1_appointments = $categorized_appointments['cancel1'];
// Generate HTML for successful appointments
$html_successful = '';
if (!empty($successful_appointments)) {
    foreach ($successful_appointments as $order) {
        $paymentMethod = ($order['pttt'] == 0) ? 'Thanh toán tại quầy' : 'Thanh toán chuyển khoản';

        $html_successful .= '<tr>
                                <td>#' . $order['mahd'] . '</td>
                                <td><b>' . $order['name'] . '</b></td>
                                <td><b>' . $order['nguoidat_ten'] . '</b></td>
                                <td>' . number_format($order['tongthanhtoan'], 0, ",", ".") . ' VNĐ</td>
                                <td><span class="badge rounded-pill alert-success">Hẹn thành công</span></td>
                                <td>' . $order['appointment_date'] . '</td>
                                <td>' . $paymentMethod . '</td>
                                <td class="text-end">
                                    <a href="index.php?pg=orders-detail&id=' . $order['id'] . '" class="btn btn-md rounded font-sm">Chi tiết</a>
                                </td>
                            </tr>';
    }
} else {
    $html_successful = '<tr><td colspan="8" class="text-center">Không có dữ liệu nào về lịch hẹn </td></tr>';
}
$html_missed = '';

// Generate HTML for missed appointments
if (!empty($missed_appointments)) {
    foreach ($missed_appointments as $order) {
        $paymentMethod = ($order['pttt'] == 0) ? 'Thanh toán tại quầy' : 'Thanh toán chuyển khoản';

        $html_missed .= '<tr>
                            <td>#' . $order['mahd'] . '</td>
                            <td><b>' . $order['name'] . '</b></td>
                            <td><b>' . $order['nguoidat_ten'] . '</b></td>
                            <td>' . number_format($order['tongthanhtoan'], 0, ",", ".") . ' VNĐ</td>
                            <td><span class="badge rounded-pill alert-primary">Khách chưa đến</span></td>
                            <td>' . $order['appointment_date'] . '</td>
                            <td>' . $paymentMethod . '</td>
                            <td class="text-end">
                                <a href="index.php?pg=orders-detail&id=' .  $order['id'] . '" class="btn btn-md rounded font-sm">Chi tiết</a>
                            </td>
                        </tr>';
    }
} else {
    $html_missed = '<tr><td colspan="8" class="text-center">Không có dữ liệu nào về lịch hẹn</td></tr>';
}


$html_cancel = '';
// Generate HTML for cancel appointments
if (!empty($cancel_appointments)) {
    foreach ($cancel_appointments as $order) {
        $paymentMethod = ($order['pttt'] == 0) ? 'Thanh toán tại quầy' : 'Thanh toán chuyển khoản';

        $html_cancel .= '<tr>
                            <td>#' . $order['mahd'] . '</td>
                            <td><b>' . $order['name'] . '</b></td>
                            <td><b>' . $order['nguoidat_ten'] . '</b></td>
                            <td>' . number_format($order['tongthanhtoan'], 0, ",", ".") . ' VNĐ</td>
                            <td><span class="badge rounded-pill alert-warning">Đã bị hủy</span></td>
                            <td>' . $order['appointment_date'] . '</td>
                            <td>' . $paymentMethod . '</td>
                            <td class="text-end">
                                <a href="index.php?pg=orders-detail&id=' . $order['id'] . '" class="btn btn-md rounded font-sm">Chi tiết</a>
                            </td>
                        </tr>';
    }
} else {
    $html_cancel = '<tr><td colspan="8" class="text-center">Không có dữ liệu</td></tr>';
}
$html_cancel1 = '';
// Generate HTML for cancel1 appointments
if (!empty($cancel1_appointments)) {
    foreach ($cancel1_appointments as $order) {
        $paymentMethod = ($order['pttt'] == 0) ? 'Thanh toán tại quầy' : 'Thanh toán chuyển khoản';

        $html_cancel1 .= '<tr>
                            <td>#' . $order['mahd'] . '</td>
                            <td><b>' . $order['name'] . '</b></td>
                            <td><b>' . $order['nguoidat_ten'] . '</b></td>
                            <td>' . number_format($order['tongthanhtoan'], 0, ",", ".") . ' VNĐ</td>
                            <td><span class="badge rounded-pill alert-danger">Đã hủy/ Quá hạn</span></td>
                            <td>' . $order['appointment_date'] . '</td>
                            <td>' . $paymentMethod . '</td>
                            <td class="text-end">
                                <a href="index.php?pg=orders-detail&id=' . $order['id'] . '" class="btn btn-md rounded font-sm">Chi tiết</a>
                            </td>
                        </tr>';
    }
} else {
    $html_cancel1 = '<tr><td colspan="8" class="text-center">Không có dữ liệu</td></tr>';
}
?>


<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Danh sách lịch hẹn</h2>
        </div>
        <div>
            <a href="index.php?pg=add_orders" class="btn btn-primary btn-sm rounded">Thêm lịch hẹn</a>

        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <header class="card-header">
                    <div class="row gx-3">
                        <div class="col-lg-4 col-md-6 me-auto">
                            <form action="index.php?pg=orders" method="post" class="d-flex align-items-center">
                                <input type="date" name="start_date" value="<?= htmlspecialchars($start_date) ?>" class="form-control mb-2 me-2">
                                <input type="date" name="end_date" value="<?= htmlspecialchars($end_date) ?>" class="form-control mb-2 me-2">
                                <button class="btn btn-primary mb-2" type="submit">Lọc</button>
                            </form>

                        </div>

                        <!-- Product Search Form -->
                        <div class="col-lg-4 col-md-6">
                            <form action="index.php?pg=orders" method="post" class="mb-3 mb-md-0">
                                <div class="input-group">
                                    <input type="text" name="kyw" placeholder="Tìm kiếm theo tên khách hàng..." class="form-control">
                                    <button type="submit" name="search" class="btn btn-light">
                                        <i class="material-icons md-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </header>
                <p>
                <div class="container my-4">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation" style=" margin-right: 20px;">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Khách hàng đang ở cửa hàng</button>
                        </li>
                        <li class="nav-item" role="presentation" style=" margin-right: 20px;">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Khách hàng đang chờ xác nhận</button>
                        </li>
                        <li class="nav-item" role="presentation" style=" margin-right: 20px;">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Khách hàng đã bị hủy</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact1" type="button" role="tab" aria-controls="contact" aria-selected="false">Khách hàng đã hủy</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="card-body">
                                <h3>Khách hàng đang ở cửa hàng</h3>
                                <div class="table-responsive mb-4">
                                    <table class="table table-hover product-table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tên người tạo</th>
                                                <th>Tên khách hàng</th>
                                                <th>Tổng Tiền</th>
                                                <th>Trạng Thái</th>
                                                <th>Ngày hẹn làm</th>
                                                <th>Thanh toán</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?= $html_successful; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="card-body">
                                <h3>Khách hàng đang chờ xác nhận</h3>
                                <div class="table-responsive">
                                    <table class="table table-hover product-table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tên người tạo</th>
                                                <th>Tên khách hàng</th>
                                                <th>Tổng Tiền</th>
                                                <th>Trạng Thái</th>
                                                <th>Ngày Hẹn làm</th>
                                                <th>Thanh toán</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?= $html_missed; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="card-body">
                                <h3>Khách hàng đã bị hủy</h3>
                                <div class="table-responsive">
                                    <table class="table table-hover product-table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tên người tạo</th>
                                                <th>Tên khách hàng</th>
                                                <th>Tổng Tiền</th>
                                                <th>Trạng Thái</th>
                                                <th>Ngày Hẹn Làm</th>
                                                <th>Thanh toán</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?= $html_cancel; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="contact1" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="card-body">
                                <h3>Khách hàng đã hủy/ hết hạn</h3>
                                <div class="table-responsive">
                                    <table class="table table-hover product-table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tên người tạo</th>
                                                <th>Tên khách hàng</th>
                                                <th>Tổng Tiền</th>
                                                <th>Trạng Thái</th>
                                                <th>Ngày Hẹn Làm</th>
                                                <th>Thanh toán</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?= $html_cancel1; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('.product-table');
        var rows = table.find('tbody tr');
        var rowsPerPage = 5;
        var currentPage = 1;

        // Hide all rows except the first one
        rows.hide().slice(0, rowsPerPage).show();

        // Add pagination controls
        var pageCount = Math.ceil(rows.length / rowsPerPage);
        var pagination = $('<div class="pagination"  style="text-align: center; justify-content: center;" ></div>');
        for (var i = 1; i <= pageCount; i++) {
            $('<a href="#" class="page-link" style="color: white; background-color: black; border-radius: 5px; margin-top:100px;">' + i + '</a>').appendTo(pagination).click(function() {
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