<?php
// Khởi tạo kết nối PDO
$host = 'localhost'; // Địa chỉ máy chủ của cơ sở dữ liệu
$port = '3306'; // Số cổng kết nối cơ sở dữ liệu
$db = 'barbershop'; // Tên cơ sở dữ liệu
$user = 'root'; // Tên người dùng cơ sở dữ liệu
$pass = ''; // Mật khẩu cơ sở dữ liệu

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log('Database connection error: ' . $e->getMessage());
    echo 'Kết nối thất bại: ' . $e->getMessage();
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $datetime = new DateTime();
    $date = $datetime->format('Y-m-d');
    $time = $datetime->format('H:i:s');
    $mahd = "BarberShop" . rand(1, 999);
    $appointment_date = $_POST["appointment_date"];

    // Dữ liệu từ form
    $userId = $_POST['user']; // ID nhân viên tạo hóa đơn
    $customerName = $_POST['nguoidat_ten'];
    $customerAddress = $_POST['nguoidat_diachi'];
    $customerPhone = $_POST['nguoidat_tel'];
    $customerEmail = $_POST['nguoidat_email'];
    $serviceIds = $_POST['service'];
    $serviceQuantities = $_POST['service_quantity'];
    $paymentMethod = $_POST['pttt'];
    $time = $_POST['appointment_time'];

    // Tính tổng giá
    $total = 0;
    foreach ($serviceIds as $key => $serviceId) {
        $service = get_sp_by_id($serviceId); // Hàm lấy thông tin dịch vụ từ ID
        $total += $service['price'] * $serviceQuantities[$key];
    }

    // Chèn dữ liệu vào bảng 'orders'
    $sqlOrder = "INSERT INTO orders (mahd, date, time, nguoidat_ten, nguoidat_email, nguoidat_tel, nguoidat_diachi, note, total, ship, voucher, tongthanhtoan, pttt, status, iduser, appointment_date, employee_id) 
                 VALUES (:mahd, :date, :time, :nguoidat_ten, :nguoidat_email, :nguoidat_tel, :nguoidat_diachi, '', :total, 0, '', :total, :pttt, 2, :iduser, :appointment_date, :employee_id)";
    try {
        $stmt = $pdo->prepare($sqlOrder);
        $stmt->execute([
            'mahd' => $mahd,
            'date' => $date,
            'time' => $time,
            'nguoidat_ten' => $customerName,
            'nguoidat_email' => $customerEmail,
            'nguoidat_tel' => $customerPhone,
            'nguoidat_diachi' => $customerAddress,
            'total' => $total,
            'pttt' => $paymentMethod,
            'iduser' => $userId,
            'appointment_date' => $appointment_date,
            'employee_id' => $userId // ID nhân viên tạo hóa đơn
        ]);

        // Lấy ID đơn hàng vừa chèn
        $orderId = $pdo->lastInsertId();

        // Chèn các dịch vụ vào bảng cart
        foreach ($serviceIds as $key => $serviceId) {
            $service = get_sp_by_id($serviceId);
            cart_insert($serviceId, $service['price'], $service['name'], $service['img'], $serviceQuantities[$key], $service['price'] * $serviceQuantities[$key], $orderId);
        }

        echo "<script>
                alert('Lịch hẹn đã được tạo thành công!');
                window.location.href = window.location.href; // Reload the page
              </script>";
        //TẠO MAIL THÔNG BÁO ĐẶT LỊCH THÀNH CÔNG!
        $link_text = '<div style="border: 1px solid #dadce0;border-radius:8px;padding:20px 30px;width: 40%;margin: 0px auto;" align="center">
        <img src="https://barbershop.vn/themes/img/logo-barbershop.png" alt="logo" style="width: 190px;padding-bottom: 20px;padding-top: 5px;">
        <div style="font-family: Google Sans,Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-bottom:thin solid #dadce0;color:rgba(0,0,0,0.87);line-height:32px;padding-bottom:24px;text-align:center;">
            <h1 style="font-size:24px">Đặt lịch hẹn thành công</h1>
        </div>
        <div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:14px;color:rgba(0,0,0,0.87);line-height:20px;padding-top:20px;text-align:left">
            <span style="display: block;text-align: center;width: 360px;margin: 0 auto;font-size: 18px;line-height: 1.3;" >BarberShop chân thành cảm ơn quý khách đã tin tưởng và lên lịch hẹn. </span>
                        <span style="display: block;width: 360px;margin: 0 auto;font-size: 18px;line-height: 1.3; font-weight:bold;" >NỘI DUNG CUỘC HẸN: </span>
                        <p> Mã hóa đơn: ' . $mahd . '</p>
                        <p> Tổng tiền : ' . $total . '</p>
                        <p> Ngày hẹn làm: ' . $appointment_date . '</p>
                        <p> Thời gian hẹn làm: ' . $time . '</p>
        </div>
       </div>';
        sendMail($customerEmail, "Lich hen voi BarberShop", $link_text);

        exit();
    } catch (PDOException $e) {
        error_log('Database query error: ' . $e->getMessage());
        echo 'Lưu dữ liệu thất bại: ' . $e->getMessage();
    }
}
?>

<?php
// Kết nối đến cơ sở dữ liệu
// Hàm lấy danh sách dịch vụ từ cơ sở dữ liệu
$sqlServices = "SELECT id, name FROM product WHERE service = 1"; // Giả sử 'service' là trường trong bảng product để xác định dịch vụ
$services = pdo_query($sqlServices);

// Hàm lấy danh sách người dùng (nhân viên) từ cơ sở dữ liệu
$sqlUsers = "SELECT id, username FROM users WHERE role = 1";
$users = pdo_query($sqlUsers);
?>


<?php
// Kết nối đến cơ sở dữ liệu

// Hàm lấy danh sách dịch vụ từ cơ sở dữ liệu
$sqlServices = "SELECT id, name FROM product WHERE service = 1"; // Giả sử 'service' là trường trong bảng product để xác định dịch vụ
$services = pdo_query($sqlServices);

// Hàm lấy danh sách người dùng (nhân viên) từ cơ sở dữ liệu
$sqlUsers = "SELECT id, username FROM users WHERE role = 1";
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

    .body {
        background-color: white;

    }
</style>


<body class="mb-5">
    <div class="container mt-5" style="
    width: 60vw;
">

        <div class="card-body" style="background-color: white; margin-top: 20px; border-radius: 20px;">
            <h2 style="text-align: center;">Tạo lịch hẹn</h2>
            <form action="" method="POST" id="appointmentForm">
                <div class="form-group" style="margin-top: 20px;">
                    <label for="user" class="mt-2">Người tạo hóa đơn:</label>
                    <select name="user" id="user" class="form-control">
                        <?php foreach ($users as $user) : ?>
                            <option value="<?= $user['id'] ?>"><?= $user['username'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group" style="margin-top: 20px;">
                    <label for="customer_name" class="mt-2">Tên khách hàng:</label>
                    <input type="text" class="form-control" required name="nguoidat_ten">
                </div>
                <div class="form-group" style="margin-top: 20px;">
                    <label for="customer_address" class="mt-2">Địa chỉ:</label>
                    <input type="text" class="form-control" name="nguoidat_diachi">
                </div>
                <div class="form-group" style="margin-top: 20px;">
                    <label for="customer_phone" class="mt-2">Số điện thoại:</label>
                    <input type="text" class="form-control" required name="nguoidat_tel">
                </div>
                <div class="form-group" style="margin-top: 20px;">
                    <label for="customer_email" class="mt-2">Email:</label>
                    <input type="email" class="form-control" name="nguoidat_email">
                </div>
                <div class="form-group" style="margin-top: 20px;">
                    <label for="service">Dịch vụ:</label>
                    <select name="service[]" id="service" class="form-control">
                        <?php foreach ($services as $service) : ?>
                            <option value="<?= $service['id'] ?>"><?= $service['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" id="service_quantity" name="service_quantity[]" value="1" hidden>
                </div>
                <div class="form-group" style="margin-top: 20px;">
                    <label for="payment-method">Phương thức thanh toán:</label>
                    <select name="pttt" id="payment-method" class="form-control">
                        <option value="1">Chuyển khoản</option>
                        <option value="0">Thanh toán tại quầy</option>
                    </select>
                </div>
                <?php $currentDate = date('Y-m-d'); ?>
                <div class="container">
                    <div class="row">
                        <div class="col-5">
                            <div class="form-group" style="margin-top: 20px;">
                                <div class="product__variant--list mb-15">
                                    <label for="appointment_date" style="display: inline-block; width: 150px;">Chọn ngày hẹn:</label>
                                    <input type="date" class="form-control" style="display: inline-block; width: fit-content;" id="appointment_date" name="appointment_date" min="<?= $currentDate ?>" value="<?= $currentDate ?>" required>

                                </div>
                            </div>
                        </div>
                        <div class="col-2"></div>
                        <div class="col-5">
                            <div class="form-group" style="margin-top: 20px;">
                                <div class="product__variant--list mb-15">
                                    <label for="appointment_time" style="display: inline-block; width: 150px;">Thời gian mong muốn:</label>
                                    <select id="appointment_time" name="appointment_time" min="<?= $currentDate ?>" value="<?= $currentDate ?>" required style="width: 145px;display: inline-block;background-color: #F4F5F9;height: 43px; border: none; ">
                                        <!-- JavaScript sẽ thêm các tùy chọn thời gian vào đây -->
                                    </select>
                                    <script>
                                        var currentDate = new Date(); // Lấy ngày và giờ hiện tại
                                        var currentHour = currentDate.getHours(); // Lấy giờ hiện tại (0-23)

                                        // Kiểm tra xem đã qua 21 giờ chưa
                                        if (currentHour >= 21) {
                                            // Nếu đã qua 21 giờ, tính toán ngày mới bằng cách thêm 1 ngày vào currentDate

                                            currentDate.setDate(currentDate.getDate() + 1);

                                            // Format lại currentDate thành chuỗi YYYY-MM-DD để gán vào input[type="date"]
                                            var year = currentDate.getFullYear();
                                            var month = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // Tháng đếm từ 0
                                            var day = currentDate.getDate().toString().padStart(2, '0');
                                            var formattedDate = `${year}-${month}-${day}`;

                                            // Gán giá trị ngày mới vào input[type="date"]
                                            document.getElementById("appointment_date").value = formattedDate;
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    // JavaScript để tạo các tùy chọn thời gian
                    var select = document.getElementById("appointment_time");

                    // Thời gian bắt đầu và kết thúc (tính theo phút từ 8:00 đến 21:00)
                    var startTime = 8 * 60; // 8:00 AM
                    var endTime = 21 * 60; // 9:00 PM

                    // Tạo các tùy chọn thời gian
                    for (var i = startTime; i <= endTime; i += 30) {
                        var hours = Math.floor(i / 60);
                        var minutes = i % 60;
                        var timeString = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
                        var option = document.createElement("option");
                        option.text = timeString;
                        option.value = timeString;
                        select.appendChild(option);
                    }
                </script>
                <div class="container" style=" justify-content: center; ">
                    <div class="row">
                        <div class="col-4"><button type="submit" class="btn btn-primary" style="margin-top: 20px; margin-left: 80px;" name="btnTaoLich">Tạo lịch</button></div>
                        <div class="col-4"> <button type="reset" class="btn btn-primary" style="margin-top: 20px; margin-left: 40px;">Làm mới</button>
                        </div>
                        <div class="col-4"> <button type="" class="btn btn-primary" style="margin-top: 20px;"><a href="index.php?pg=orders" style="color: white;">Quay lại</a></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
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
            height: 150vh;
        }
    </style>
</body>

</html>