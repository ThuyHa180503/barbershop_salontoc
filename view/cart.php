<?php
$html_new = showsp_slide($dssp_new);
?>

<main class="main__content_wrapper">
    <!-- Start breadcrumb section -->
    <section class="breadcrumb__section breadcrumb__bg">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__content--title text-white mb-25">Lịch hẹn</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center">
                            <li class="breadcrumb__content--menu__items"><a class="text-white" href="index.php">Trang
                                    chủ</a></li>
                            <li class="breadcrumb__content--menu__items"><span class="text-white">Lịch hẹn</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End breadcrumb section -->

    <!-- cart section start -->
    <section class="cart__section section--padding">
        <div class="container-fluid">
            <div class="cart__section--inner">
                <h2 class="cart__title mb-40">Thông tin lịch hẹn</h2>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="cart__table">
                            <table class="cart__table--inner">
                                <thead class="cart__table--header">
                                    <tr class="cart__table--header__items">
                                        <th class="cart__table--header__list">Loại dịch vụ</th>
                                        <th class="cart__table--header__list">Giá</th>
                                        <th class="cart__table--header__list">Ngày hẹn làm</th>
                                        <th class="cart__table--header__list">Thời gian hẹn làm</th>
                                    </tr>
                                </thead>
                                <tbody class="cart__table--body"></tbody>
                            </table>
                            <div class="continue__shopping d-flex justify-content-between">
                                <a href="index.php?pg=cart&del=1">
                                    <button class="continue__shopping--clear" type="submit">Xóa lịch hẹn</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="cart__summary border-radius-10">
                            <div class="cart__note mb-20">
                                <h3 class="cart__note--title">Ghi chú</h3>
                                <p class="cart__note--desc" style="color : red">**Lưu ý cho nhân viên...**</p>
                                <textarea class="cart__note--textarea border-radius-5"></textarea>
                            </div>
                            <div class="cart__summary--total mb-20">
                                <table class="cart__summary--total__table">
                                    <tbody>

                                        <tr class="cart__summary--total__list">
                                            <td class="cart__summary--total__title text-left" style="font-weight: 500;">TỔNG CỘNG</td>
                                            <td class="cart__summary--amount text-right" id="totalAmount">
                                                <?= number_format($sum, 0, ",", ".") ?>VNĐ</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="cart__summary--footer">
                                <ul class="d-flex justify-content-between">
                                    <li>
                                        <button class="cart__summary--footer__btn primary__btn cart" type="button" onclick="updateCart()" style="text-align: center; justify-content: center; display: flex;">Tiến hành đặt lịch</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- End brand logo section -->

    <!-- Start shipping section -->
    <section class="shipping__section2 shipping__style3 section--padding">
        <div class="container">
            <div class="shipping__section2--inner shipping__style3--inner d-flex justify-content-between">
                <div class="shipping__items2 d-flex align-items-center">
                    <div class="shipping__items2--icon">
                        <img src="./view/assets/img/other/shipping1.png" alt="">
                    </div>
                    <div class="shipping__items2--content">
                        <h2 class="shipping__items2--content__title h3">Vận Chuyển</h2>
                        <p class="shipping__items2--content__desc">Miễn Phí Vận Chuyển</p>
                    </div>
                </div>
                <div class="shipping__items2 d-flex align-items-center">
                    <div class="shipping__items2--icon">
                        <img src="./view/assets/img/other/shipping2.png" alt="">
                    </div>
                    <div class="shipping__items2--content">
                        <h2 class="shipping__items2--content__title h3">Thanh Toán</h2>
                        <p class="shipping__items2--content__desc">Thanh toán trực tiếp và trực tuyến</p>
                    </div>
                </div>
                <div class="shipping__items2 d-flex align-items-center">
                    <div class="shipping__items2--icon">
                        <img src="./view/assets/img/other/shipping3.png" alt="">
                    </div>
                    <div class="shipping__items2--content">
                        <h2 class="shipping__items2--content__title h3">Liên Hệ</h2>
                        <p class="shipping__items2--content__desc">Hotline: 10072004</p>
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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function formatCurrency(value) {
        var formattedValue = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        return formattedValue + ' VNĐ';
    }

    function getCart() {
        $.ajax({
            url: 'controller/UpdateQuantity.php',
            method: 'get',
            success: function(response) {
                const items = JSON.parse(response);
                console.log(items);
                var idList = items.map(item => item.id).join(',');
                localStorage.setItem('cartIds', idList)
                var i = 0;
                var htmlOutput = '';
                items.forEach(function(item) {
                    localStorage.setItem("sum" + item.id, parseInt(item.price) * parseInt(item.amount));
                    const linkdel = "index.php?pg=delcart&ind=" + i;
                    htmlOutput += '<tr class="cart__table--body__items">' +
                        '<td class="cart__table--body__list">' +
                        '<div class="cart__product d-flex align-items-center">' +
                        '<button class="cart__remove--btn" aria-label="search button" type="button">' +
                        '<a href="' + linkdel + '">' +
                        '<svg fill="currentColor" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" width="16px" height="16px"><path d="M 4.7070312 3.2929688 L 3.2929688 4.7070312 L 10.585938 12 L 3.2929688 19.292969 L 4.7070312 20.707031 L 12 13.414062 L 19.292969 20.707031 L 20.707031 19.292969 L 13.414062 12 L 20.707031 4.7070312 L 19.292969 3.2929688 L 12 10.585938 L 4.7070312 3.2929688 z"/></svg>' +
                        '</a>' +
                        '</button>' +
                        '<div class="cart__thumbnail">' +
                        '<a href="product-details.html"><img class="border-radius-5 item-img" src="./uploads/' +
                        item.img + '" alt="cart-product"></a>' +
                        '</div>' +
                        '<div class="cart__content">' +
                        '<h4 class="cart__content--title item-name">' + item.name + '</h4>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        '<input type="hidden" class="pid" value="' + item.id + '">' +
                        '<td class="cart__table--body__list">' +
                        '<span class="cart__price">' + formatCurrency(item.price) + '</span>' +
                        '</td>' +
                        '<input type="hidden" class="pprice" value="' + item.price + '">' +

                        '<td class="cart__table--body__list">' +
                        '<span class="cart__price end" id="totalAmount">' + item.appointment_date +
                        '</span>' +
                        '</td>' +
                        '<td class="cart__table--body__list">' +
                        '<span class="cart__price end" id="totalAmount">' + item.time +
                        '</span>' +
                        '</td>' +
                        '</tr>'
                    i++;
                });
                $('.cart__table--body').append(htmlOutput);
            }
        });
    }

    $(document).ready(function() {
        getCart();

        function formatCurrency(value) {
            var formattedValue = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            return formattedValue + ' VNĐ';
        }
        $(document).on("click", ".quantity__value.decrease, .quantity__value.increase", function() {
            // Get the parent .quantity__box element
            var quantityBox = $(this).closest('.quantity__box');

            // Get the associated item ID
            var itemId = quantityBox.find('.itemQty').data("id");

            // Get the current quantity value
            var currentQuantity = parseInt(quantityBox.find('.itemQty').val());

            // Determine if the increase or decrease button was clicked
            var isIncrease = $(this).hasClass('increase');

            // Update the quantity based on the button clicked
            // var newQuantity = isIncrease ? currentQuantity + 1 : Math.max(1, currentQuantity - 1);
            var newQuantity = isIncrease ? Math.min(50, currentQuantity + 1) : Math.max(1, currentQuantity -
                1);

            // Update the displayed quantity
            quantityBox.find('.itemQty').val(newQuantity);

            // Trigger the "change" event to update the total amount and localStorage
            quantityBox.find('.itemQty').trigger('change');
        });
        $(document).on("change", ".itemQty", function() {
            var itemId = $(this).data("id");
            var newQuantity = $(this).val();
            var itemPrice = parseFloat($(this).closest('.cart__table--body__items').find('.pprice').val());
            var newTotalAmountPerProduct = itemPrice * newQuantity;

            localStorage.setItem("sum" + itemId, newTotalAmountPerProduct);
            $(this).closest('.cart__table--body__items').find('#totalAmount').text(formatCurrency(
                newTotalAmountPerProduct));

            const cartIds = localStorage.getItem('cartIds').split(',')
            // console.log(cartIds)
            let newTotalAmount = 0
            for (const id of cartIds) {
                newTotalAmount += parseInt(localStorage.getItem("sum" + id))
            }

            // console.log(newTotalAmount)
            $('.cart__summary--amount').text(formatCurrency(newTotalAmount))
        });
    });

    function updateCart() {

        window.location.href = "index.php?pg=checkout";
    }
</script>
<script>
    //Chặn e - + cho tất cả các trường input số
    document.addEventListener('keydown', function(e) {
        var target = e.target;

        // Kiểm tra xem phần tử đang có focus có phải là một trường input số hay không
        if (target.tagName === 'INPUT' && target.type === 'number') {
            var key = e.key;

            // Nếu là một trường input số, và phím là 'e', 'E', '-', hoặc '+', chặn sự kiện
            if (key === 'e' || key === 'E' || key === '-' || key === '+') {
                e.preventDefault();
            }
        }
    });

    // Chặn giá trị vượt quá 50
    document.addEventListener('input', function(e) {
        var target = e.target;

        // Kiểm tra xem phần tử đang có focus có phải là một trường input số hay không
        if (target.tagName === 'INPUT' && target.type === 'number') {
            var value = parseInt(target.value, 10);

            // Chặn 'e', 'E', '-', '+', và giới hạn giá trị tối đa là 50
            if (isNaN(value) || value > 50) {
                target.value = 50;
            }
        }
    });
</script>