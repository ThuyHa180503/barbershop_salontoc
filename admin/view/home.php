<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php
$count_products = count_products();
$count_completed_orders = count_completed_orders();
$count_pending_orders = count_pending_orders();
$count_cancle_orders = count_cancle_orders();
$count_cancle1_orders = count_cancle1_orders();
$revenue = 0;
$count_order = 0;
$total_products = 0;
$total_users = 0;
foreach ($orderlist as $order) {
    if ($order['status'] == 4) {
        $revenue += $order['total'];
    }
    if ($order['status'] == 1 || $order['status'] == 2) {
        $count_order++;
    }
}
$html_order = '';
foreach ($orderlimit as $item) {
    if ($item['status'] == 1) $tt = '<span class="badge rounded-pill alert-primary">Chờ xác nhận</span>'; // chờ xác nhận
    if ($item['status'] == 2) $tt = '<span class="badge rounded-pill alert-info">Hẹn thành công</span>'; //xác nhận
    if ($item['status'] == 3) $tt = '<span class="badge rounded-pill alert-info">Đang làm</span>'; //đang làm
    if ($item['status'] == 4) $tt = '<span class="badge rounded-pill alert-success">Hoàn thành</span>'; //Hoàn thành
    if ($item['status'] == 5) $tt = '<span class="badge rounded-pill alert-warning">Quá hạn</span>';
    if ($item['status'] == 6) $tt = '<span class="badge rounded-pill alert-danger">Hủy</span>'; //Hủy
    $html_order .= '<tr>
                        <td width="20%">#' . $item['mahd'] . '</td>
                        <td width="30%"><b>' . $item['nguoidat_ten'] . '</b></td>
                        <td width="20%">' . number_format($item['tongthanhtoan'], 0, ",", ".") . 'VNĐ</td>
                        <td>' . $tt . '</td>
                        <td class="text-end">' . $item['date'] . '</td>
                    </tr> ';
}

foreach ($count_product as $item) {
    $total_products += 1;
}

foreach ($count_user as $item) {
    $total_users += 1;
}


?>

<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Trang chủ </h2>
        </div>
    </div>
    <div class="row">

        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-success-light"><i class="fa-brands fa-product-hunt" style="color:green"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Sản phẩm</h6> <span><?= $count_products ?></span>

                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-primary-light"><i class="fa-solid fa-star" style="color: primary;"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Lịch hẹn</h6> <span><?= $count_order ?></span>

                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-warning-light"><i class="text-warning material-icons md-qr_code"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Các dịch vụ</h6> <span><?= $total_products ?></span>

                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-info-light"><i class="text-info material-icons md-person"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Số người dùng</h6> <span><?= $total_users ?></span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4 flex-column">
                <article class="icontext flex-grow-1">
                    <span class="icon icon-sm rounded-circle bg-primary-light"><i class="fa-solid fa-calendar-days"></i></span>
                    <div class="text">
                        <h7 class="mb-1 card-title" style="font-weight: bold;">Lịch hẹn thành công</h7> <span><?= $count_completed_orders ?></span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4 flex-column">
                <article class="icontext flex-grow-1">
                    <span class="icon icon-sm rounded-circle bg-info-light"><i class="fa-regular fa-calendar-days"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Lịch hẹn sắp tới</h6> <span><?= $count_pending_orders ?></span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4 flex-column">
                <article class="icontext flex-grow-1">
                    <span class="icon icon-sm rounded-circle bg-info-light"><i class="fa-regular fa-calendar"></i></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Lịch hẹn đã hủy</h6> <span><?= $count_cancle_orders ?></span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4 flex-column">
                <article class="icontext flex-grow-1">
                    <span class="icon icon-sm rounded-circle bg-warning-light"><i class="text-info material-icons md-person"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Lịch hẹn đã bị hủy</h6> <span><?= $count_cancle1_orders ?></span>
                    </div>
                </article>
            </div>
        </div>
    </div>
    <div class="card-body" style="background-color: white;">
        <h2>Doanh thu các tháng trong năm</h2>
        <canvas id="revenueChart" width="400" height="100"></canvas>
        <script>
            <?php
            // Step 2: Fetch the monthly revenue data from the PHP function
            $monthly_revenue = get_monthly_revenue();

            // Prepare data for Chart.js
            $months = [];
            $revenues = [];
            foreach ($monthly_revenue as $row) {
                $months[] = $row['month'];
                $revenues[] = $row['revenue'];
            }

            // Convert PHP arrays to JSON
            $months_json = json_encode($months);
            $revenues_json = json_encode($revenues);
            ?>

            // Step 3: Generate a chart using Chart.js
            var ctx = document.getElementById('revenueChart').getContext('2d');
            var revenueChart = new Chart(ctx, {
                type: 'bar', // Change this to 'line' if you prefer a line chart
                data: {
                    labels: <?= $months_json ?>,
                    datasets: [{
                        label: 'Doanh thu hàng tháng',
                        data: <?= $revenues_json ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    </div>

    <div class="">
        <div class="card mb-4 mt-4">
            <header class="card-header">
                <h4 class="card-title">Lịch hẹn mới nhất</h4>
            </header>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên Khách Hàng</th>
                                <th>Tổng Tiền</th>
                                <th>Trạng Thái</th>
                                <th class="text-end">Ngày Đặt Hẹn</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?= $html_order; ?>
                        </tbody>
                    </table>
                </div>
                <!-- table-responsive //end -->
            </div>
        </div>
    </div>

</section>