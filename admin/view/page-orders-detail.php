<?php
// Đoạn mã PHP để xử lý thêm sản phẩm vào giỏ hàng
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $idpro = $_POST['idpro'];
    $price = $_POST['price'];
    $name = $_POST['name'];
    $img = $_POST['img'];
    $soluong = $_POST['soluong'];
    $thanhtien = $price * $soluong;
    $idbill =  $orderdetail['id'];

    $existingCartItem = get_cart_item($idpro, $idbill);
    if ($existingCartItem) {
        print_r($existingCartItem);
        $newQuantity = $existingCartItem['soluong'] + $soluong;
        $newTotalPrice = $existingCartItem['price'] * $newQuantity;
        cart_update($idpro, $newQuantity, $newTotalPrice, $idbill);
    } else {
        cart_insert($idpro, $price, $name, $img, $soluong, $thanhtien, $idbill);
    }
    update_order_total($orderdetail['id']);
    header('location: index.php?pg=orders-detail&id=' . $idbill);
}

// Đoạn mã PHP để xử lý xóa sản phẩm khỏi giỏ hàng
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_from_cart'])) {
    $idpro = $_POST['idpro'];
    $idbill = $orderdetail['id'];

    cart_remove($idpro, $idbill);
    update_order_total($orderdetail['id']);
    header('location: index.php?pg=orders-detail&id=' . $idbill);
}


// Lấy danh sách sản phẩm từ cơ sở dữ liệu
$productsql = "SELECT id, name, img, price 
              FROM product
              WHERE service = 0 
                AND stock > 0";
$products = pdo_query($productsql);

extract($orderdetail);
if (isset($employee_id) && $employee_id !== null) {
    $employee_info  = get_user($employee_id);
}
if ($pttt == 0) {
    $tbpt = 'Thanh toán tại quầy';
} elseif ($pttt == 1) {
    $qrCodeUrl =   'https://api.vieqr.com/vietqr/VietinBank/113366668888/10000/compact.jpg?NDck=UngHoCV&FullName=Quy%20Vacxin%20Covid';

    $tbpt = '<img src="' . $qrCodeUrl . '" alt="VietQR" style="width: 100px; height: 100px;">';
}

// Determine the payment method

// Prepare status options
$select = "";
$statusOptions = [
    1 => 'index.php?pg=order-pending&id=' . $id . '&iduser=' . $iduser . '&mahd=' . $mahd,
    2 => 'index.php?pg=order-confirm&id=' . $id . '&iduser=' . $iduser . '&mahd=' . $mahd,
    4 => 'index.php?pg=order-complete&id=' . $id . '&iduser=' . $iduser . '&mahd=' . $mahd,
    5 => 'index.php?pg=order-save&id=' . $id . '&iduser=' . $iduser . '&mahd=' . $mahd //cancel
];

foreach ($statusOptions as $value => $link) {
    $selected = ($status == $value) ? 'selected' : '';
    $select .= '<option value="' . $link . '" ' . $selected . '>' . getStatusText($value) . '</option>';
}

function getStatusText($status)
{
    switch ($status) {
        case 1:
            return 'Opening ( chưa đến cửa hàng)';
        case 2:
            return 'Confirm (đã đến cửa hàng)';
        case 4:
            return 'Completed (đã thanh toán)';
        case 5:
            return 'Cancel (hủy lịch hẹn)';
    }
}

// Determine the status text and badge
switch ($status) {
    case 1:
        $tt = '<span class="badge rounded-pill alert-warning">Chờ xác nhận</span>';
        $tt2 = 'Chờ xác nhận';
        break;
    case 2:
        $tt = '<span class="badge rounded-pill alert-warning">Đã đến cửa hàng</span>';
        $tt2 = 'đã đến cửa hàng';
        break;
    case 4:
        $tt = '<span class="badge rounded-pill alert-success">Hoàn thành</span>';
        $tt2 = 'Hoàn thành';
        break;
    case 5:
        $tt = '<span class="badge rounded-pill alert-danger">Hủy lịch hẹn</span>';
        $tt2 = 'Hủy lịch hẹn';
        break;
    case 5:
        $tt = '<span class="badge rounded-pill alert-danger">Hủy lịch hẹn</span>';
        $tt2 = 'Hủy lịch hẹn';
        break;
    default:
        $tt = '<span class="badge rounded-pill alert-secondary">Không biết</span>';
        $tt2 = 'Không biết';
        break;
}

extract($ordercart);
$html_cartorder = '';
foreach ($ordercart as $item) {
    extract($item);
    $html_cartorder .= '<tr>
                            <td>
                                <div class="left">
                                    <img src="../uploads/' . $img . '" width="40" height="40" class="img-xs" alt="Item">
                                </div>
                                <div class="info">' . $name . "(" .  $soluong . ")" .  '</div>
                            </td>
                            <td>' . number_format($price, 0, ",", ".") . ' VNĐ</td>
                            <td>' . $soluong . '</td>
                            <td class="text-end">' . number_format($thanhtien, 0, ",", ".") . ' VNĐ</td>
                            <td class="text-end">
                                <form method="post" action="">
                                    <input type="hidden" name="idpro" value="' . $idpro . '">
                                    <button type="submit" name="remove_from_cart" class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>';
}

extract($ordercart1);
$html_cartorder1 = '';
foreach ($ordercart1 as $item) {
    extract($item);
    $html_cartorder1 .= '<tr>
                            <td>
                                <div class="left">
                                    <img src="../uploads/' . $img . '" width="40" height="40" class="img-xs" alt="Item">
                                </div>
                                <div class="info">' . $name . '</div>
                            </td>
                            <td>' . number_format($price, 0, ",", ".") . ' VNĐ</td>
                            <td class="text-end">' . number_format($thanhtien, 0, ",", ".") . ' VNĐ</td>
                         
                        </tr>';
}


?>


<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Xuất hóa đơn</h2>
            <p>Chi tiết về lịch hẹn: #<?= $mahd; ?></p>
        </div>
    </div>
    <form action="" method="post">
        <div class="card">
            <header class="card-header">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 mb-lg-0 mb-15">
                        <span>
                            <i class="material-icons md-calendar_today"></i><b><?= $appointment_date; ?> </b>
                        </span> <br>
                        <small class="text-muted">Order ID: #<?= $mahd; ?></small>
                    </div>
                    <div class="col-lg-6 col-md-6 ms-auto text-md-end">
                        <select class="form-select d-inline-block mb-lg-0 mb-15 mw-200" id="mySelect" name="order_status">
                            <?= $select; ?>
                        </select>
                        <a class="btn btn-secondary print ms-2" id="download-pdf"><i class="icon material-icons md-print"></i></a>
                    </div>
                </div>
            </header>
            <div class="card-body">
                <div class="row mb-50 mt-20 order-info-wrap">
                    <div class="col-md-4">
                        <article class="icontext align-items-start">
                            <span class="icon icon-sm rounded-circle bg-primary-light">
                                <i class="text-primary material-icons md-person"></i>
                            </span>
                            <div class="text">
                                <h6 class="mb-1">THÔNG TIN VỀ KHÁCH HÀNG</h6>
                                <p class="mb-1">
                                <p>Tên khách hàng: <?= $nguoidat_ten; ?></p>

                                <p>Địa chỉ Email: <a href="mailto:<?= $nguoidat_email; ?>" class="__cf_email__" data-cfemail="c7a6aba2bf87a2bfa6aab7aba2e9a4a8aa"><?= $nguoidat_email; ?></a>
                                </p>

                                <p>Số điện thoại: <?= $nguoidat_tel; ?>
                                </p>
                                </p>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-4" style="margin-left: 100px;">
                        <article class="icontext align-items-start">
                            <span class="icon icon-sm rounded-circle bg-primary-light">
                                <i class="text-primary material-icons md-person"></i>
                            </span>
                            <div class="text">
                                <h6 class="mb-1">NHÂN VIÊN PHỤ TRÁCH</h6>
                                <?php if ($employee_id !== null && isset($employee_info)) : ?>
                                    <p class="mb-1">
                                    <P>Tên nhân viên: <?= $employee_info['name']; ?> <br> <a href="mailto:<?= $employee_info['email']; ?>" class="__cf_email__" data-cfemail="c7a6aba2bf87a2bfa6aab7aba2e9a4a8aa"><?= $employee_info['email']; ?></a>
                                    </P>
                                    <p>Số điện thoại: <?= $employee_info['sdt']; ?>
                                    </p>
                                    </p>
                                <?php else : ?>
                                    <p class="mb-1">TRỐNG</p>
                                <?php endif; ?>
                            </div>
                        </article>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table">
                                <H5>DANH SÁCH DỊCH VỤ TRONG HÓA ĐƠN</H5>
                                <thead>
                                    <tr>
                                        <th width="40%">dịch vụ</th>
                                        <th width="40%">Đơn giá</th>
                                        <th width="20%" class="text-end">Tổng cộng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?= $html_cartorder1; ?>

                                </tbody>
                            </table>
                            <table class="table">
                                <h5 for="">DANH SÁCH SẢN PHẨM TRONG HÓA ĐƠN</h5>
                                <thead style="padding-left: 200PX; padding-right: 200px;">
                                    <tr style="padding-left: 200PX; padding-right: 200px;">
                                        <th width="40%">Sản phẩm</th>
                                        <th width="20%">Đơn giá</th>
                                        <th width="10%">Số lượng</th>
                                        <th width="20%" class="text-end">Tổng cộng</th>
                                        <TH width="10%" class="text-end">Thao tác</TH>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?= $html_cartorder; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="h-25 pt-4">
                            <tr>
                                <td colspan="4">
                                    <article class="">
                                        <dl class="dlist">
                                            <dt>Tạm tính:</dt>
                                            <dd><?= number_format($total, 0, ",", ".") ?> VNĐ</dd>
                                        </dl>
                                        <dl class="dlist">
                                            <dt>Tổng cộng:</dt>
                                            <dd><b class="h5"><?= number_format($tongthanhtoan, 0, ",", ".") ?></b>
                                                VNĐ</dd>
                                        </dl>
                                        <dl class="dlist">
                                            <dt class="text-muted">Trạng thái</dt>
                                            <dd><?= $tt ?></dd>
                                        </dl>
                                        <dl class="dlist">
                                            <dt class="text-muted">Phương thức thanh toán:</dt>
                                            <dd><?= $tbpt ?></dd>
                                        </dl>
                                        <?php if ($pttt == 0) : ?>
                                            <dl class="dlist">
                                                <dt>Số tiền khách trả:</dt>
                                                <dd><input type="text" class="form-control" name="amount_paid" id="amount_paid" placeholder="Nhập số tiền khách trả"></dd>
                                            </dl>
                                            <dl class="dlist">
                                                <dt>Số tiền trả lại:</dt>
                                                <dd id="amount_returned">0 VNĐ</dd>
                                            </dl>
                                        <?php elseif ($pttt == 1) : ?>
                                            <dl class="dlist">
                                                <dt>Mã giao dịch:</dt>
                                                <dd><input type="text" class="form-control" name="transaction_id" id="transaction_id" placeholder="Nhập mã giao dịch"></dd>
                                            </dl>
                                        <?php endif; ?>
                                    </article>
                                </td>
                            </tr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th width="9%">STT</th>
                    <th>Sản phẩm</th>
                    <th style="padding-left: 165px;">Giá</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $key => $product) : ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td>
                            <div class="row align-items-center">
                                <div class="col-lg-2 col-sm-4 col-8 flex-grow-1 col-name">
                                    <a class="itemside" href="#">
                                        <div class="left">
                                            <img src="../uploads/<?php echo $product['img']; ?>" class="img-sm img-thumbnail" alt="Item">
                                        </div>
                                        <div class="info">
                                            <h6 class="mb-0"><?php echo $product['name']; ?></h6>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td><?php echo number_format($product['price'], 0, ",", "."); ?> VNĐ</td>
                        <td class="text-end">
                            <form method="post" action="">
                                <input type="hidden" name="idpro" value="<?php echo $product['id']; ?>">
                                <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                                <input type="hidden" name="name" value="<?php echo $product['name']; ?>">
                                <input type="hidden" name="img" value="<?php echo $product['img']; ?>">
                                <input type="number" name="soluong" value="1" min="1" class="form-control form-control-sm mb-2" style="width: 80px;">
                                <button type="submit" name="add_to_cart" class="btn btn-sm font-sm rounded btn-brand">
                                    <i class="material-icons md-add_shopping_cart"></i> Thêm vào hoá đơn
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    var select = document.getElementById("mySelect");
    select.addEventListener("change", function() {
        var selectedValue = select.value;
        window.location.href = selectedValue;
    });

    <?php if ($pttt == 0) : ?>
        document.getElementById('amount_paid').addEventListener('input', function() {
            var amountPaid = parseFloat(this.value.replace(/,/g, '')) || 0;
            var total = <?= $tongthanhtoan; ?>;
            var amountReturned = amountPaid - total;
            document.getElementById('amount_returned').innerText = number_format(amountReturned) + ' VNĐ';
        });

        function number_format(number) {
            return new Intl.NumberFormat('vi-VN').format(number);
        }
    <?php endif; ?>
</script>

<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<script>
    document.getElementById('download-pdf').addEventListener('click', function() {
        var element = document.querySelector('.card');
        var options = {
            margin: 10,
            filename: 'don-hang.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 1
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait'
            },
            y: 0
        };
        html2pdf(element, options);
    });
</script>