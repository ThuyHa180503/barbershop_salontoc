<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php

$count_total_sold_services = count_total_sold_services();

$orders_today = 0;
$orders_current_quarter = 0;
$orders_current_year = 0;
$revenue = 0;
$revenue_today = 0;
$revenue_current_quarter = 0;
$revenue_current_year = 0;
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

foreach ($orderlist_get_orders_today as $order) {
    if ($order['status'] == 4) {
        $revenue_today += $order['total'];
    }
}

foreach ($orderlist_get_orders_current_quarter as $order) {
    if ($order['status'] == 4) {
        $revenue_current_quarter += $order['total'];
    }
}

foreach ($orderlist_get_orders_current_year as $order) {
    if ($order['status'] == 4) {
        $revenue_current_year += $order['total'];
    }
}

$html_order = '';
foreach ($orderlist as $item) {
    if ($item['status'] == 1) $tt = '<span class="badge rounded-pill alert-warning">Pending</span>';
    if ($item['status'] == 2) $tt = '<span class="badge rounded-pill alert-success">Confirm</span>';
    if ($item['status'] == 3) $tt = '<span class="badge rounded-pill alert-success">Delivering</span>';
    if ($item['status'] == 4) $tt = '<span class="badge rounded-pill alert-success">Complete</span>';
    if ($item['status'] == 5) $tt = '<span class="badge rounded-pill alert-warning">Delivery failed</span>';
    if ($item['status'] == 6) $tt = '<span class="badge rounded-pill alert-danger">Cancelled</span>';
    $html_order .= '<tr>
                        <td width="20%">#' . $item['mahd'] . '</td>
                        <td width="30%"><b>' . $item['nguoidat_ten'] . '</b></td>
                        <td width="20%">' . number_format($item['tongthanhtoan'], 0, ",", ".") . ' VNĐ</td>
                        <td>' . $tt . '</td>
                        <td class="text-end">' . $item['date'] . '</td>
                    </tr>';
}

foreach ($count_product as $item) {
    $total_products += 1;
}

foreach ($count_user as $item) {
    $total_users += 1;
}

$html_userlist = '';
foreach ($userlist as $item) {
    extract($item);
    $html_userlist .= '<tr>
                            <td width="25%">
                                <a href="#" class="itemside">
                                    <div class="left">
                                        <img src="../uploads/' . $img . '" class="img-sm img-avatar" alt="Userpic">
                                    </div>
                                    <div class="info pl-3">
                                        <h6 class="mb-0 title">' . $username . '</h6>
                                        <small class="text-muted">' . $name . '</small>
                                        <small class="text-muted">Seller ID: #' . $id . '</small>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <a href="mailto:' . $email . '" class="__cf_email__">' . $email . '</a>
                            </td>
                            <td><span class="badge rounded-pill alert-success">' . $sdt . '</span></td>
                            <td width="30%">' . $address . '</td>
                        </tr>';
}
?>
<?php
$top_selling_services = get_top_selling_services();

$html_services = '';
foreach ($top_selling_services as $service) {
    $html_services .= '<tr>
    <td>' . $service['id'] . '</td>
    <td>' . $service['name'] . '</td>
    <td>' . number_format($service['price'], 0, ",", ".") . ' VNĐ</td>
    <td>' . $service['total_sold'] . '</td>
    <td>' . number_format($service['price'] * $service['total_sold'], 0, ",", ".") . ' VNĐ</td>
 </tr>';
}
$html_products = '';
foreach ($top_selling_products as $service) {
    $html_products .= '<tr>
                            <td>' . $service['id'] . '</td>
                            <td>' . $service['name'] . '</td>
                            <td>' . number_format($service['price'], 0, ",", ".") . ' VNĐ</td>
                            <td>' . $service['total_sold'] . '</td>
                            <td><img src="../uploads/' . $service['img'] . '" class="img-sm" alt="' . $service['name'] . '"></td>
                       </tr>';
}
?>


<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Báo cáo dịch vụ</h2>

        </div>
        <div>
            <a href="index.php?pg=report_products" class="btn btn-primary btn-sm rounded">Báo cáo sản phẩm</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-primary-light"><i class="text-primary material-icons md-today"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Doanh Thu Ngày</h6>
                        <span><?= number_format($revenue_today, 0, ",", ".") ?> VNĐ</span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-primary-light"><i class="text-primary material-icons md-view_quilt"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Doanh Thu Quý</h6>
                        <span><?= number_format($revenue_current_quarter, 0, ",", ".") ?> VNĐ</span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-primary-light"><i class="text-primary material-icons md-calendar_today"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Doanh Thu Năm</h6>
                        <span><?= number_format($revenue_current_year, 0, ",", ".") ?> VNĐ</span>
                    </div>
                </article>
            </div>
        </div>
    </div>


    <div class="card mb-4">
        <header class="card-header">
            <h4 class="card-title">Doanh thu theo loại dịch vụ </h4>
        </header>
        <!-- card-header end// -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="product-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= $html_services; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- card-body end// -->
    </div>
    <style>
        .pagination {
            display: flex;
            justify-content: start;
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        .page-item {
            margin-right: 10px;
        }

        .page-item.active .page-link {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        .page-link {
            display: block;
            padding: 0.5rem 0.75rem;
            text-decoration: none;
            color: #007bff;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
        }

        .page-link:hover {
            background-color: #e9ecef;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#product-table');
            var rows = table.find('tbody tr');
            var rowsPerPage = 5;
            var currentPage = 1;

            // Hide all rows except the first one
            rows.hide().slice(0, rowsPerPage).show();

            // Add pagination controls
            var pageCount = Math.ceil(rows.length / rowsPerPage);
            var pagination = $('<div class="pagination"  style="text-align: center; justify-content: center;" ></div>');
            for (var i = 1; i <= pageCount; i++) {
                $('<a href="#" class="page-link" style="color: white; background-color: black;">' + i + '</a>').appendTo(pagination).click(function() {
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