<?php
extract($spchitiet);
// die(print_r($spchitiet, true));
$html_dssp_lienquan = showsp_slide($splienquan);

if (isset($_GET['idpro'])) {
    $idpro = $_GET['idpro'];
}

$total_comments = count_comments_by_idpro($idpro);
$html_dsbl = "";
foreach ($commentlist as $item) {
    // Khởi tạo lại chuỗi HTML cho đánh giá sao
    $html_rating = '<ul class="rating d-flex" data-commentid="' . $item['id'] . '">';
    for ($i = 1; $i <= 5; $i++) {
        $activeClass = ($i <= $item['rating']) ? 'active' : '';
        $html_rating .= '<li class="rating__list ' . $activeClass . '" data-rating="' . $i . '">
                                <span class="rating__list--icon">
                                    <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">  
                                        <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="' . ($activeClass ? 'currentColor' : '#ccc') . '"></path>
                                    </svg>
                                </span>
                            </li>';
    }
    $html_rating .= '</ul>';
    $html_dsbl .= '<div class="reviews__comment--list d-flex">
                            <div class="reviews__comment--thumb">
                                <img src="./uploads/' . $item['img'] . '" alt="comment-thumb">
                            </div>
                            <div class="reviews__comment--content">
                                <div class="reviews__comment--top d-flex justify-content-between">
                                    <div class="reviews__comment--top__left">
                                        <h3 class="reviews__comment--content__title h4">' . $item['name'] . '</h3>
                                        ' . $html_rating . '
                                    </div>
                                    <span class="reviews__comment--content__date">' . $item['date'] . '</span>
                                </div>
                                <p class="reviews__comment--content__desc">' . $item['content'] . '</p>
                            </div>
                        </div>';
}
?>

<main class="main__content_wrapper">

    <!-- Start breadcrumb section -->
    <section class="breadcrumb__section breadcrumb__bg">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__content--title text-white mb-25">Chi tiết dịch vụ</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center">
                            <li class="breadcrumb__content--menu__items"><a class="text-white" href="index.php">Trang
                                    chủ</a></li>
                            <li class="breadcrumb__content--menu__items"><span class="text-white">Chi tiết dịch
                                    vụ</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End breadcrumb section -->

    <!-- Start product details section -->
    <section class="product__details--section section--padding">
        <div class="container">
            <div class="row row-cols-lg-2 row-cols-md-2">
                <div class="col">
                    <div class="product__details--media">
                        <div class="product__media--preview  swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="product__media--preview__items">
                                        <a class="product__media--preview__items--link glightbox" data-gallery="product-media-preview" href="./uploads/<?= $img ?>"><img class="product__media--preview__items--img" src="./uploads/<?= $img ?>" alt="product-media-img"></a>
                                        <div class="product__media--view__icon">
                                            <a class="product__media--view__icon--link glightbox" href="./uploads/<?= $img ?>" data-gallery="product-media-preview">
                                                <svg class="product__media--view__icon--svg" xmlns="http://www.w3.org/2000/svg" width="22.51" height="22.443" viewBox="0 0 512 512">
                                                    <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path>
                                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="product__media--nav swiper">
                            <div class="swiper-wrapper">
                            </div>
                            <div class="swiper__nav--btn swiper-button-next"></div>
                            <div class="swiper__nav--btn swiper-button-prev"></div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="product__details--info">
                        <h2 class="product__details--info__title mb-15"><?= $name ?></h2>
                        <div class="product__details--info__price mb-10">
                            <span class="current__price"><?= number_format($price, 0, ",", ".") ?>VNĐ</span>
                            <span class="price__divided"></span>
                            <span class="old__price">- <?= number_format($old_price, 0, ",", ".") ?>VNĐ</span>
                        </div>
                        <div class="product__details--info__rating d-flex align-items-center mb-15">
                            <ul class="rating d-flex justify-content-center">
                                <li class="rating__list">
                                    <span class="rating__list--icon">
                                        <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                            <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                        </svg>
                                    </span>
                                </li>
                                <li class="rating__list">
                                    <span class="rating__list--icon">
                                        <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                            <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                        </svg>
                                    </span>
                                </li>
                                <li class="rating__list">
                                    <span class="rating__list--icon">
                                        <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                            <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                        </svg>
                                    </span>
                                </li>
                                <li class="rating__list">
                                    <span class="rating__list--icon">
                                        <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                            <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                        </svg>
                                    </span>
                                </li>
                                <li class="rating__list">
                                    <span class="rating__list--icon">
                                        <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                            <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                        </svg>
                                    </span>
                                </li>
                            </ul>
                            <span class="product__items--rating__count--number">(<?= $total_comments; ?>)</span>
                        </div>
                        <p class="product__details--info__desc mb-15"><?= $describe1 ?></p>
                        <?php
                        // Get the current date in the format YYYY-MM-DD
                        $currentDate = date('Y-m-d');
                        ?>

                        <form action="index.php?pg=addcart" method="post" class="product__variant">
                            <div class="product__variant--list quantity d-flex align-items-center mb-20">
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <input type="hidden" name="amount" value="1">
                                <input type="hidden" name="name" value="<?= $name ?>">
                                <input type="hidden" name="img" value="<?= $img ?>">
                                <input type="hidden" name="price" value="<?= $price ?>">
                            </div>

                            <!-- Date input field -->
                            <div class="row">
                                <div class="col-5">
                                    <div class="product__variant--list mb-15">
                                        <label for="appointment_date">Chọn ngày hẹn:</label>
                                        <input type="date" id="appointment_date" name="appointment_date" min="<?= $currentDate ?>" value="<?= $currentDate ?>" required>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="product__variant--list mb-15">
                                        <label for="appointment_time">Thời gian mong muốn:</label>
                                        <select id="time" name="time" min="<?= $currentDate ?>" value="<?= $currentDate ?>" required style="width: 145px;">
                                            <!-- JavaScript sẽ thêm các tùy chọn thời gian vào đây -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <script>
                                // JavaScript để tạo các tùy chọn thời gian
                                var select = document.getElementById("time");

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

                                function validateAppointment() {
                                    // Lấy ngày hiện tại
                                    var currentDate = new Date();
                                    var currentDateString = currentDate.toISOString().slice(0, 10); // Lấy định dạng YYYY-MM-DD
                                    // Lấy ngày hẹn và thời gian đã chọn
                                    var selectedDate = document.getElementById('appointment_date').value;
                                    var selectedTime = document.getElementById('time').value;
                                    // Nếu ngày hẹn là ngày hiện tại
                                    if (selectedDate === currentDateString) {
                                        // Lấy giờ hiện tại
                                        var currentTime = currentDate.getHours() + ':' + currentDate.getMinutes(); // Lấy định dạng HH:mm
                                        // So sánh thời gian đã chọn với giờ hiện tại
                                        if (selectedTime < currentTime) {
                                            alert('Không thể đặt lịch với thời gian đã qua.');
                                            return false; // Ngăn không cho form submit
                                        }
                                    }
                                    return true; // Cho phép form submit
                                }
                            </script>


                            <div class="product__variant--list mb-15">
                                <button class="variant__buy--now__btn primary__btn" type="submit" name="btnaddcart" value="true" onclick="return validateAppointment();">Đặt
                                    lịch</button>
                            </div>

                            <div class=" product__details--info__meta">
                                <p class="product__details--info__meta--list">
                                    <strong>Mã:</strong> <span><?= $id ?></span>
                                </p>
                            </div>
                        </form>

                        <div class="quickview__social d-flex align-items-center mb-15">
                            <label class="quickview__social--title">Chia sẻ xã hội:</label>
                            <ul class="quickview__social--wrapper mt-0 d-flex">
                                <li class="quickview__social--list">
                                    <a class="quickview__social--icon" target="_blank" href="https://www.facebook.com">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="7.667" height="16.524" viewBox="0 0 7.667 16.524">
                                            <path data-name="Path 237" d="M967.495,353.678h-2.3v8.253h-3.437v-8.253H960.13V350.77h1.624v-1.888a4.087,4.087,0,0,1,.264-1.492,2.9,2.9,0,0,1,1.039-1.379,3.626,3.626,0,0,1,2.153-.6l2.549.019v2.833h-1.851a.732.732,0,0,0-.472.151.8.8,0,0,0-.246.642v1.719H967.8Z" transform="translate(-960.13 -345.407)" fill="currentColor" />
                                        </svg>
                                        <span class="visually-hidden">Facebook</span>
                                    </a>
                                </li>
                                <li class="quickview__social--list">
                                    <a class="quickview__social--icon" target="_blank" href="https://www.instagram.com">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16.497" height="16.492" viewBox="0 0 19.497 19.492">
                                            <path data-name="Icon awesome-instagram" d="M9.747,6.24a5,5,0,1,0,5,5A4.99,4.99,0,0,0,9.747,6.24Zm0,8.247A3.249,3.249,0,1,1,13,11.238a3.255,3.255,0,0,1-3.249,3.249Zm6.368-8.451A1.166,1.166,0,1,1,14.949,4.87,1.163,1.163,0,0,1,16.115,6.036Zm3.31,1.183A5.769,5.769,0,0,0,17.85,3.135,5.807,5.807,0,0,0,13.766,1.56c-1.609-.091-6.433-.091-8.042,0A5.8,5.8,0,0,0,1.64,3.13,5.788,5.788,0,0,0,.065,7.215c-.091,1.609-.091,6.433,0,8.042A5.769,5.769,0,0,0,1.64,19.341a5.814,5.814,0,0,0,4.084,1.575c1.609.091,6.433.091,8.042,0a5.769,5.769,0,0,0,4.084-1.575,5.807,5.807,0,0,0,1.575-4.084c.091-1.609.091-6.429,0-8.038Zm-2.079,9.765a3.289,3.289,0,0,1-1.853,1.853c-1.283.509-4.328.391-5.746.391S5.28,19.341,4,18.837a3.289,3.289,0,0,1-1.853-1.853c-.509-1.283-.391-4.328-.391-5.746s-.113-4.467.391-5.746A3.289,3.289,0,0,1,4,3.639c1.283-.509,4.328-.391,5.746-.391s4.467-.113,5.746.391a3.289,3.289,0,0,1,1.853,1.853c.509,1.283.391,4.328.391,5.746S17.855,15.705,17.346,16.984Z" transform="translate(0.004 -1.492)" fill="currentColor" />
                                        </svg>
                                        <span class="visually-hidden">Instagram</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End product details section -->

    <!-- Start product details tab section -->
    <section class="product__details--tab__section section--padding">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <ul class="product__details--tab d-flex mb-30">
                        <li class="product__details--tab__list active" data-toggle="tab" data-target="#description">Mô
                            tả</li>
                        <li class="product__details--tab__list" data-toggle="tab" data-target="#reviews">Đánh giá</li>
                    </ul>
                    <div id="cmt" class="product__details--tab__inner border-radius-10">
                        <div class="tab_content">
                            <div id="description" class="tab_pane active show">
                                <div class="product__tab--content">
                                    <div class="product__tab--content__step mb-30">
                                        <?= $describe2 ?>
                                    </div>
                                </div>
                            </div>
                            <div id="reviews" class="tab_pane">
                                <div class="product__reviews">
                                    <div class="product__reviews--header">
                                        <h2 class="product__reviews--header__title h3 mb-20">Phản hồi khách hàng</h2>
                                        <div class="reviews__ratting d-flex align-items-center">
                                            <ul class="rating d-flex">
                                                <li class="rating__list">
                                                    <span class="rating__list--icon">
                                                        <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                            <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                </li>
                                                <li class="rating__list">
                                                    <span class="rating__list--icon">
                                                        <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                            <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                </li>
                                                <li class="rating__list">
                                                    <span class="rating__list--icon">
                                                        <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                            <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                </li>
                                                <li class="rating__list">
                                                    <span class="rating__list--icon">
                                                        <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                            <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                </li>
                                                <li class="rating__list">
                                                    <span class="rating__list--icon">
                                                        <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                            <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                </li>
                                            </ul>
                                            <span class="reviews__summary--caption">Dựa trên <?= $total_comments; ?>
                                                đánh giá</span>
                                        </div>
                                        <a class="actions__newreviews--btn primary__btn" href="#writereview">Viết đánh
                                            giá</a>
                                    </div>
                                    <div class="reviews__comment--area">
                                        <?= $html_dsbl; ?>
                                    </div>
                                    <?php
                                    if (isset($_SESSION['s_user']) && (count($_SESSION['s_user']) > 0)) {
                                    ?>
                                        <div id="writereview" class="reviews__comment--reply__area">
                                            <form action="index.php?pg=process-comment" method="post" id="commentForm">
                                                <h3 class="reviews__comment--reply__title mb-15">Thêm một bài đánh giá</h3>
                                                <div class="reviews__ratting d-flex align-items-center mb-20">
                                                </div>
                                                <div class="row" id="">
                                                    <div class="col-12 mb-10">
                                                        <textarea name="content" class="reviews__comment--reply__textarea" placeholder="Bình luận của bạn...."></textarea>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="idpro" value="<?php echo $idpro; ?>">
                                                <input type="hidden" name="rating" id="hiddenRatingInput" value="">
                                                <button class="reviews__comment--btn text-white primary__btn" type="submit">GỬI</button>
                                            </form>
                                        </div>
                                    <?php
                                    } else {
                                        $_SESSION['page'] = "product-details";
                                        $_SESSION['idpro'] = $_GET['idpro'];
                                        echo 'Hãy <a href="index.php?pg=signin-signup" style="color:#353434; text-decoration: none;" > Đăng nhập </a> để đánh giá !';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End product details tab section -->

    <!-- Start product section -->
    <section class="product__section product__section--style3 section--padding">
        <div class="container product3__section--container">
            <div class="section__heading text-center mb-50">
                <h2 class="section__heading--maintitle">Có thể bạn sẽ thích</h2>
            </div>
            <div class="product__section--inner product__swiper--column4__activation swiper">
                <div class="swiper-wrapper">
                    <?= $html_dssp_lienquan ?>
                </div>
                <div class="swiper__nav--btn swiper-button-next"></div>
                <div class="swiper__nav--btn swiper-button-prev"></div>
            </div>
        </div>
    </section>
    <!-- End product section -->

    <!-- Start shipping section -->
    <section class="shipping__section2 shipping__style3 section--padding pt-0">
        <div class="container">
            <div class="shipping__section2--inner shipping__style3--inner d-flex justify-content-between">
                <div class="shipping__items2 d-flex align-items-center">
                    <div class="shipping__items2--icon">
                        <img src="./view/assets/img/other/shipping1.png" alt="">
                    </div>
                    <div class="shipping__items2--content">
                        <h2 class="shipping__items2--content__title h3">Dịch vụ</h2>
                        <p class="shipping__items2--content__desc">Tận tình chu đáo</p>
                    </div>
                </div>
                <div class="shipping__items2 d-flex align-items-center">
                    <div class="shipping__items2--icon">
                        <img src="./view/assets/img/other/shipping2.png" alt="">
                    </div>
                    <div class="shipping__items2--content">
                        <h2 class="shipping__items2--content__title h3">Thanh Toán</h2>
                        <p class="shipping__items2--content__desc">Thanh toán trực tiếp và online</p>
                    </div>
                </div>
                <div class="shipping__items2 d-flex align-items-center">
                    <div class="shipping__items2--icon">
                        <img src="./view/assets/img/other/shipping3.png" alt="">
                    </div>
                    <div class="shipping__items2--content">
                        <h2 class="shipping__items2--content__title h3">Liên Hệ</h2>
                        <p class="shipping__items2--content__desc">Hotline: 0399725293</p>
                    </div>
                </div>
                <div class="shipping__items2 d-flex align-items-center">
                    <div class="shipping__items2--icon">
                        <img src="./view/assets/img/other/shipping4.png" alt="">
                    </div>
                    <div class="shipping__items2--content">
                        <h2 class="shipping__items2--content__title h3">Hỗ trợ</h2>
                        <p class="shipping__items2--content__desc">Hỗ trợ 24/7</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End shipping section -->
</main>