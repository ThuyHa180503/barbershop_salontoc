<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    print_r($_POST['product']);
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $datetime = new DateTime();
    $date = $datetime->format('Y-m-d');
    $time = $datetime->format('H:i:s');
    $mahd = "BarberShop" . rand(1, 999);
    $appointment_date = $_POST["appointment_date"];

    $userId = $_POST['user'];
    $serviceIds = $_POST['service'];
    $serviceQuantities = $_POST['service_quantity'];
    $productIds = $_POST['product'];
    $productQuantities = $_POST['product_quantity'];
    $paymentMethod = $_POST['pttt'];

    // Retrieve user information from database
    $user = get_user($userId); // Implement get_user function to fetch user details

    // Check if user exists
    if ($user) {
        $nguoidat_ten = $user['username'];
        $nguoidat_email = $user['email'];
        $nguoidat_tel = $user['sdt'];
        $nguoidat_diachi = $user['address'];
    } else {
        // Handle case where user is not found
        $nguoidat_ten = "";
        $nguoidat_email = "";
        $nguoidat_tel = "";
        $nguoidat_diachi = "";
    }

    // Calculate total price
    $total = 0;

    // Loop through selected services to calculate total
    foreach ($serviceIds as $key => $serviceId) {
        $service = get_sp_by_id($serviceId);
        $total += $service['price'] * $serviceQuantities[$key];
    }

    // Loop through selected products to calculate total
    foreach ($productIds as $key => $productId) {
        $product = get_sp_by_id($productId);
        $total += $product['price'] * $productQuantities[$key];
    }

    // Insert order into database
    $orderId = order_insert_id($mahd, $userId, $nguoidat_ten, $nguoidat_email, $nguoidat_tel, $nguoidat_diachi, '', $total, 0, '', $total, $paymentMethod, $date, $time, $appointment_date);

    // Loop through selected services and insert into cart
    foreach ($serviceIds as $key => $serviceId) {
        $service = get_sp_by_id($serviceId);
        cart_insert($serviceId, $service['price'], $service['name'], $service['img'], $serviceQuantities[$key], $service['price'] * $serviceQuantities[$key], $orderId);
    }

    // Loop through selected products and insert into cart
    foreach ($productIds as $key => $productId) {
        $product = get_sp_by_id($productId);
        cart_insert($productId, $product['price'], $product['name'], $product['img'], $productQuantities[$key], $product['price'] * $productQuantities[$key], $orderId);
    }
}

?>


<?php
// Kết nối đến cơ sở dữ liệu

// Lấy danh sách dịch vụ từ cơ sở dữ liệu
$sqlServices = "SELECT id, name FROM product WHERE service = 1"; // Giả sử 'service' là trường trong bảng product để xác định dịch vụ
$services = pdo_query($sqlServices);

// Lấy danh sách sản phẩm từ cơ sở dữ liệu
$sqlProducts = "SELECT id, name FROM product WHERE service = 0"; // Giả sử 'service' là trường trong bảng product để xác định sản phẩm
$products = pdo_query($sqlProducts);
$sqlUsers = "SELECT id, username FROM users";
$users = pdo_query($sqlUsers);
?>



<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th,
td {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

th {
    background-color: #f2f2f2;
}

.remove-btn {
    background-color: #ff0000;
    color: #ffffff;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
}
</style>


<body class="mb-5">
    <div class="container mt-5">
        <h2>Tạo Đơn Hàng</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="user">Người đặt:</label>
                <select name="user" id="user" class="form-control">
                    <!-- Options for users -->
                    <?php foreach ($users as $user) : ?>
                    <option value="<?= $user['id'] ?>"><?= $user['username'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="service">Dịch vụ:</label>
                <select name="service[]" id="service" class="form-control" multiple>
                    <!-- Options for services -->
                    <?php foreach ($services as $service) : ?>
                    <option value="<?= $service['id'] ?>"><?= $service['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="number" id="service_quantity" name="service_quantity[]" value="1" hidden>
            </div>
            <div class="form-group">
                <label for="product">Sản phẩm:</label>
                <select name="product[]" id="product" class="form-control" multiple>
                    <!-- Options for products -->
                    <?php foreach ($products as $product) : ?>
                    <option value="<?= $product['id'] ?>"><?= $product['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="product_quantity">Số lượng sản phẩm:</label>
                <input type="number" id="product_quantity" name="product_quantity[]" class="form-control" value="1">
            </div>
            <div class="form-group">
                <label for="payment-method">Phương thức thanh toán:</label>
                <select name="pttt" id="payment-method" class="form-control">
                    <option value="chuyen_khoan">Chuyển khoản</option>
                    <option value="thanh_toan_tai_quay">Thanh toán tại quầy</option>
                </select>
            </div>
            <?php $currentDate = date('Y-m-d');; ?>
            <div class="product__variant--list mb-15">
                <label for="appointment_date">Chọn ngày hẹn:</label>
                <input type="date" id="appointment_date" name="appointment_date" min="<?= $currentDate ?>"
                    value="<?= $currentDate ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Tạo Đơn Hàng</button>
        </form>


        <!-- Div to contain selected items -->
        <div id="selected-items" class="mt-4 mb-5" style="margin-bottom: 5rem !important;">
            <h3>Các mục đã chọn:</h3>
            <table id="selected-table" class="table">
                <thead>
                    <tr>
                        <th>Tên</th>
                        <th>Số lượng</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody id="selected-body">
                    <!-- Selected items will be added here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const serviceSelect = document.getElementById("service");
        const productSelect = document.getElementById("product");
        const serviceQuantityInput = document.getElementById("service_quantity");
        const productQuantityInput = document.getElementById("product_quantity");
        const selectedTable = document.getElementById("selected-table");
        const selectedBody = document.getElementById("selected-body");

        function addSelectedRow(name, quantity) {
            const row = document.createElement("tr");
            row.innerHTML = `
                    <td>${name}</td>
                    <td>${quantity}</td>
                    <td><button class="remove-btn">Xóa</button></td>
                `;
            selectedBody.appendChild(row);
        }

        serviceSelect.addEventListener("change", function() {
            const selectedServiceIndex = serviceSelect.selectedIndex;
            const selectedServiceName = serviceSelect.options[selectedServiceIndex].text;
            const selectedServiceQuantity = serviceQuantityInput.value;
            addSelectedRow(selectedServiceName, selectedServiceQuantity);
        });

        productSelect.addEventListener("change", function() {
            const selectedProductIndex = productSelect.selectedIndex;
            const selectedProductName = productSelect.options[selectedProductIndex].text;
            const selectedProductQuantity = productQuantityInput.value;
            addSelectedRow(selectedProductName, selectedProductQuantity);
        });

        selectedBody.addEventListener("click", function(event) {
            if (event.target.classList.contains("remove-btn")) {
                event.target.parentElement.parentElement.remove();
            }
        });
    });
    </script>
    <style>
    .main-wrap {
        margin-left: 220px;
        height: 100vh;
    }
    </style>
</body>

</html>