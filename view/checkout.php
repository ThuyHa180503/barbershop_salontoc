<?php
if (isset($_SESSION['s_user'])) {
    $email = $_SESSION['s_user']['email'];
    $nameuser = $_SESSION['s_user']['name'];
    $sdt = $_SESSION['s_user']['sdt'];
    $address = $_SESSION['s_user']['address'];
} else {
    $email = '';
    $nameuser = '';
    $sdt = '';
    $address = '';
}

$html_cart = "";
$html_cart_mobile = "";
$html_cart_time = "";
if (isset($_SESSION['giohang']) && is_array($_SESSION['giohang'])) {
    $i = 0;
    $sum = 0;
    foreach ($_SESSION['giohang'] as $item) {
        extract($item);
        $tt = (int)$price * (int)$amount;
        (int)$sum += (int)$price * (int)$amount;
        $linkdel = "index.php?pg=delcart&ind=" . $i;
        $html_cart .= '<label for="">                                        <h2 class="product__description--name h4">Thông tin chi tiết:</h2>
</label>
         
        <tr class="cart__table--body__items">
                            <td >
                                <div class="product__image two  d-flex align-items-center">
                                    <div class="product__thumbnail border-radius-5">
                                        <img class="border-radius-5" src="./uploads/' . $img . '" alt="cart-product">
                                        <span class="product__thumbnail--quantity">' . $amount . '</span>
                                    </div>
                                    <div class="product__description">
                                        <h3 class="product__description--name h4">' . $name . '</h3>
                                    </div>
                                    
                                </div>
                            </td>
                            <td >
                                <span class="cart__price">' . number_format($price, 0, ",", ".") . 'VNĐ</span>
                            </td>
                            
                        </tr>
                       ';

        $html_cart_mobile .= '<tr class=" summary__table--items">
                                    <td class=" summary__table--list">
                                        <div class="product__image two  d-flex align-items-center">
                                            <div class="product__thumbnail border-radius-5">
                                                <img class="border-radius-5" src="./uploads/' . $img . '"" alt="cart-product">
                                                <span class="product__thumbnail--quantity">' . $amount . '</span>
                                            </div>
                                            <div class="product__description">
                                                <h3 class="product__description--name h4">' . $name . '</h3>
                                            </div>
                                        </div>
                                    </td>
                                    <td class=" summary__table--list">
                                        <span class="cart__price">' . number_format($price, 0, ",", ".") . 'VNĐ</span>
                                    </td>
                                </tr>';
        $i++;
    }
}
?>
<!-- Start checkout page area -->
<div class="checkout__page--area">
    <div class="container">
        <div class="checkout__page--inner d-flex">
            <div class="main checkout__mian">
                <header class="main__header checkout__mian--header mb-30">

                    <details class="order__summary--mobile__version">
                        <summary class="order__summary--toggle border-radius-5">
                            <span class="order__summary--toggle__inner">
                                <span class="order__summary--toggle__icon">
                                    <svg width="20" height="19" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.178 13.088H5.453c-.454 0-.91-.364-.91-.818L3.727 1.818H0V0h4.544c.455 0 .91.364.91.818l.09 1.272h13.45c.274 0 .547.09.73.364.18.182.27.454.18.727l-1.817 9.18c-.09.455-.455.728-.91.728zM6.27 11.27h10.09l1.454-7.362H5.634l.637 7.362zm.092 7.715c1.004 0 1.818-.813 1.818-1.817s-.814-1.818-1.818-1.818-1.818.814-1.818 1.818.814 1.817 1.818 1.817zm9.18 0c1.004 0 1.817-.813 1.817-1.817s-.814-1.818-1.818-1.818-1.818.814-1.818 1.818.814 1.817 1.818 1.817z" fill="currentColor"></path>
                                    </svg>
                                </span>
                                <span class="order__summary--toggle__text show">
                                    <span>Hiển thị tóm tắt đơn hàng</span>
                                    <svg width="11" height="6" xmlns="http://www.w3.org/2000/svg" class="order-summary-toggle__dropdown" fill="currentColor">
                                        <path d="M.504 1.813l4.358 3.845.496.438.496-.438 4.642-4.096L9.504.438 4.862 4.534h.992L1.496.69.504 1.812z">
                                        </path>
                                    </svg>
                                </span>
                                <span class="order__summary--final__price"><?= number_format($price, 0, ",", ".") ?>VNĐ</span>
                            </span>
                        </summary>
                        <div class="order__summary--section">
                            <div class="cart__table checkout__product--table">
                                <table class="summary__table">
                                    <tbody class="summary__table--body">
                                        <?= $html_cart_mobile; ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- <div class="checkout__discount--code">
                                    <form class="d-flex" action="#">
                                        <label>
                                            <input class="checkout__discount--code__input--field border-radius-5" placeholder="Mã giảm giá"  type="text">
                                        </label>
                                        <button class="checkout__discount--code__btn primary__btn border-radius-5" type="submit">Áp dụng</button>
                                    </form>
                                </div> -->
                            <div class="checkout__total">
                                <table class="checkout__total--table">
                                    <tbody class="checkout__total--body">
                                        <tr class="checkout__total--items">
                                            <td class="checkout__total--title text-left">Tổng đơn hàng </td>
                                            <td class="checkout__total--amount text-right">
                                                <?= number_format($sum, 0, ",", ".") ?>VNĐ</td>
                                        </tr>
                                        <tr class="checkout__total--items">
                                            <td class="checkout__total--title text-left">Tiền Ship</td>
                                            <td class="checkout__total--calculated__text text-right">Tính toán ở bước
                                                tiếp theo</td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="checkout__total--footer">
                                        <tr class="checkout__total--footer__items">
                                            <td class="checkout__total--footer__title checkout__total--footer__list text-left">
                                                Tổng tiền </td>
                                            <td class="checkout__total--footer__amount checkout__total--footer__list text-right">
                                                <?= number_format($sum, 0, ",", ".") ?>VNĐ</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </details>
                    <nav>
                        <ol class="breadcrumb checkout__breadcrumb d-flex">
                            <li class="breadcrumb__item breadcrumb__item--completed d-flex align-items-center">
                                <a class="breadcrumb__link" href="cart.html">Giỏ hàng</a>
                                <svg class="readcrumb__chevron-icon" xmlns="http://www.w3.org/2000/svg" width="17.007" height="16.831" viewBox="0 0 512 512">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M184 112l144 144-144 144"></path>
                                </svg>
                            </li>

                            <li class="breadcrumb__item breadcrumb__item--current d-flex align-items-center">
                                <span class="breadcrumb__text current">Thông tin</span>
                                <svg class="readcrumb__chevron-icon" xmlns="http://www.w3.org/2000/svg" width="17.007" height="16.831" viewBox="0 0 512 512">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M184 112l144 144-144 144"></path>
                                </svg>
                            </li>
                            <li class="breadcrumb__item breadcrumb__item--blank d-flex align-items-center">
                                <span class="breadcrumb__text">Đặt lịch</span>
                                <svg class="readcrumb__chevron-icon" xmlns="http://www.w3.org/2000/svg" width="17.007" height="16.831" viewBox="0 0 512 512">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M184 112l144 144-144 144"></path>
                                </svg>
                            </li>
                            <li class="breadcrumb__item breadcrumb__item--blank">
                                <span class="breadcrumb__text">Thanh toán</span>
                            </li>
                        </ol>
                    </nav>
                </header>
                <main class="main__content_wrapper">
                    <form action="index.php?pg=checkout" method="post">
                        <input type="number" value="<?php echo $sum ?>" name="sum" hidden>
                        <div class="checkout__content--step section__contact--information">
                            <div class="section__header checkout__section--header d-flex align-items-center justify-content-between mb-25">
                                <h2 class="section__header--title h3">Thông tin liên lạc</h2>
                                <?= $tbdn; ?>
                            </div>
                            <div class="customer__information">
                                <div class="checkout__email--phone mb-12">
                                    <label>Họ tên khách hàng:</label>
                                    <input class="checkout__input--field border-radius-5" placeholder="Họ và tên" type="text" name="name" value="<?= $nameuser ?>" required readonly>
                                </div>
                                <div class="checkout__email--phone mb-12">
                                    <label>Email khách hàng:</label>
                                    <input class="checkout__input--field border-radius-5" placeholder="Email" type="text" name="email" value="<?= $email ?>" required>
                                </div>

                                <div class="checkout__email--phone mb-12">
                                    <label>Số điện thoại khách hàng:</label>
                                    <input id="phone-input" class="checkout__input--field border-radius-5" placeholder="Số điện thoại" type="text" name="sdt" value="<?= $sdt ?>" required>
                                </div>
                            </div>
                            <div class="checkout__checkbox" hidden>
                                <input class="checkout__checkbox--input" type="radio" id="paypal" name="pttt" value="0" checked>

                                <span class="checkout__checkbox--checkmark"></span>
                                <label class="checkout__checkbox--label" for="paypal">
                                    Thanh toán tại quầy</label>
                            </div>
                            <div hidden class="checkout__checkbox">
                                <input class="checkout__checkbox--input" type="radio" id="creditCard" name="pttt" value="1">
                                <span class="checkout__checkbox--checkmark"></span>
                                <label class="checkout__checkbox--label" for="creditCard">
                                    Thanh toán bằng thẻ tín dụng</label>
                            </div> <br>

                        </div>
                        <div class="checkout__content--step section__shipping--address" hidden>
                            <div class="section__header mb-25">
                                <h3 class="section__header--title">Địa chỉ giao hàng</h3>
                            </div>
                            <div class="section__shipping--address__content">
                                <div class="row">
                                    <div class="col-lg-6 mb-12">
                                        <div class="checkout__input--list ">
                                            <label>
                                                <input class="checkout__input--field border-radius-5" placeholder="Họ và tên" type="text" name="name" value="<?= $nameuser ?>" required>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-12">
                                        <div class="checkout__input--list">
                                            <label>

                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-12">
                                        <div class="checkout__input--list">
                                            <label>
                                                <input class="checkout__input--field border-radius-5" placeholder="Địa chỉ" type="text" name="address" value="<?= $address ?>" required>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-12">
                                        <div class="checkout__input--list">
                                            <label>
                                                <textarea class="reviews__comment--reply__textarea" placeholder="Ghi chú" name="note" id="" cols="30" rows="10"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-12">
                                        <div class="checkout__input--list checkout__input--select select">
                                            <label class="checkout__select--label" for="country">Quốc gia/ Khu
                                                vực</label>
                                            <select class="checkout__input--select__field border-radius-5" id="country">
                                                <option value="1">VietNam</option>
                                                <option value="2">CamPuChia</option>
                                                <option value="3">Trung Quốc</option>
                                                <option value="4">Thái Lan</option>
                                                <option value="5">Lào</option>
                                                <option value="6">Nhật Bản</option>
                                                <option value="7">Hàn Quốc</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="checkout__content--step__footer d-flex align-items-center">
                            <button class="continue__shipping--btn primary__btn border-radius-5" type="submit" name="btnpay">Đặt lịch</button>
                            <a class="previous__link--content primary__btn border-radius-5" href="index.php?pg=cart" style="color: white;">Quay lại dịch vụ</a>
                        </div>
                    </form>


                </main>
                <footer class="main__footer checkout__footer">
                </footer>
            </div>
            <aside class="checkout__sidebar sidebar">
                <div class="cart__table checkout__product--table">
                    <table class="cart__table--inner">
                        <tbody class="cart__table--body">
                            <?= $html_cart; ?>
                        </tbody>
                    </table>
                </div>
                <!-- <div class="checkout__discount--code">
                        <form class="d-flex" action="#">
                            <label>
                                <input class="checkout__discount--code__input--field border-radius-5" placeholder="Thẻ quà tặng hoặc mã"  type="text">
                            </label>
                            <button class="checkout__discount--code__btn primary__btn border-radius-5" type="submit">Áp dụng</button>
                        </form>
                    </div> -->
                <div class="checkout__total">
                    <table class="checkout__total--table">
                        <tbody class="checkout__total--body">
                            <tr class="checkout__total--items">
                                <td class="checkout__total--title text-left">Tổng dịch vụ:</td>
                                <td class="checkout__total--amount text-right">
                                    <?= number_format($sum, 0, ",", ".") ?>VNĐ
                                </td>
                            </tr>

                        </tbody>

                        <tfoot class="checkout__total--footer">
                            <tr class="checkout__total--footer__items">
                                <td class="checkout__total--footer__title checkout__total--footer__list text-left">Tổng
                                    tiền </td>
                                <td class="checkout__total--footer__amount checkout__total--footer__list text-right">
                                    <?= number_format($sum, 0, ",", ".") ?>VNĐ
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </aside>
        </div>
    </div>
</div>
<!-- End checkout page area -->