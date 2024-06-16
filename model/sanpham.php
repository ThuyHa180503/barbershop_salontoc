<?php
require_once 'pdo.php';

function services_insert($name, $img, $price, $old_price, $describe1, $describe2, $bestseller, $hot, $new, $iddm)
{
    $sql = "INSERT INTO product(name, img, price, old_price, describe1, describe2, bestseller, hot, new, iddm, service) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
    pdo_execute($sql, $name, $img, $price, $old_price, $describe1, $describe2, $bestseller, $hot, $new, $iddm, 1);
}
function sanpham_insert($name, $img, $price, $old_price, $describe1, $describe2, $bestseller, $hot, $new, $iddm)
{
    $sql = "INSERT INTO product(name, img, price, old_price, describe1, describe2, bestseller, hot, new, iddm) VALUES (?,?,?,?,?,?,?,?,?,?)";
    pdo_execute($sql, $name, $img, $price, $old_price, $describe1, $describe2, $bestseller, $hot, $new, $iddm);
}

function sanpham_update($name, $img, $price, $old_price, $describe1, $describe2, $bestseller, $hot, $new, $iddm, $id)
{
    if ($img != "") {
        $sql = "UPDATE product SET name=?, img=?, price=?, old_price=?, describe1=?, describe2=?, bestseller=?, hot=?, new=?, iddm=? WHERE id=?";
        pdo_execute($sql, $name, $img, $price, $old_price, $describe1, $describe2, $bestseller, $hot, $new, $iddm, $id);
    } else {
        $sql = "UPDATE product SET name=?, price=?, old_price=?, describe1=?, describe2=?, bestseller=?, hot=?, new=?, iddm=? WHERE id=?";
        pdo_execute($sql, $name, $price, $old_price, $describe1, $describe2, $bestseller, $hot, $new, $iddm, $id);
    }
}

function sanpham_delete($id)
{
    $sql = "DELETE FROM product WHERE  id=?";
    pdo_execute($sql, $id);
}

function get_iddm($id)
{
    $sql = "SELECT iddm FROM product WHERE id=?";
    return pdo_query_value($sql, $id);
}
function hien_thi_st($dssp, $sosp)
{
    $tongsp = count($dssp);
    $strang = ceil($tongsp / $sosp);
    $html_strang = "";

    for ($i = 1; $i <= $strang; $i++) {
        $html_strang .= '<li class="pagination__list">
                        <a href="index.php?pg=shop&page=' . $i . '" class="pagination__item pagination__item--current">' . $i . '</a>
                    </li>';
    }
    return $html_strang;
}

function get_dssp($kyw, $iddm, $pg, $sosp)
{
    $begin = ($pg - 1) * $sosp;
    $sql = "SELECT * FROM product WHERE service = 0";
    if ($iddm > 0) {
        $sql .= " AND iddm=" . $iddm;
    }
    if ($kyw != "") {
        $sql .= " AND name LIKE '%" . $kyw . "%'";
    }
    $sql .= " ORDER BY id ASC LIMIT " . $begin . "," . $sosp;
    return pdo_query($sql);
}

function product_all()
{
    $sql = "SELECT * FROM product WHERE service = 0 ORDER BY id";
    return pdo_query($sql);
}
function count_products()
{
    $sql = "SELECT COUNT(*) as total_products FROM product WHERE service = 0";
    $result = pdo_query($sql);
    return $result[0]['total_products'];
}



function hien_thi_st_services($dssp, $sosp)
{
    $tongsp = count($dssp);
    $strang = ceil($tongsp / $sosp);
    $html_strang = "";

    for ($i = 1; $i <= $strang; $i++) {
        $html_strang .= '<li class="pagination__list">
                        <a href="index.php?pg=shop&page=' . $i . '" class="pagination__item pagination__item--current">' . $i . '</a>
                    </li>';
    }
    return $html_strang;
}

function get_dssp_services($kyw, $iddm, $pg, $sosp)
{
    $begin = ($pg - 1) * $sosp;
    $sql = "SELECT * FROM product WHERE service = 1";
    if ($iddm > 0) {
        $sql .= " AND iddm=" . $iddm;
    }
    if ($kyw != "") {
        $sql .= " AND name LIKE '%" . $kyw . "%'";
    }
    $sql .= " ORDER BY id ASC LIMIT " . $begin . "," . $sosp;
    return pdo_query($sql);
}

function product_all_services()
{
    $sql = "SELECT * FROM product WHERE service = 1 ORDER BY id";
    return pdo_query($sql);
}
function count_total_sold_services()
{
    $sql = "
        SELECT 
            SUM(c.soluong) AS total_quantity,
            SUM(c.thanhtien) AS total_revenue
        FROM 
            cart c
        INNER JOIN 
            product p ON c.idpro = p.id
        WHERE 
            p.service = 1
    ";
    return pdo_query_one($sql);
}
function get_top_selling_services()
{
    $sql = "
        SELECT 
            p.id, p.name, p.price, p.img, SUM(c.soluong) AS total_sold
        FROM 
            cart c
        INNER JOIN 
            product p ON c.idpro = p.id
        WHERE 
            p.service = 1
        GROUP BY 
            p.id, p.name, p.price, p.img
        ORDER BY 
            total_sold DESC
    ";
    return pdo_query($sql);
}
function get_top_selling_products()
{
    $sql = "
        SELECT 
            p.id, p.name, p.price, p.img, SUM(c.soluong) AS total_sold
        FROM 
            cart c
        INNER JOIN 
            product p ON c.idpro = p.id
        WHERE 
            p.service = 0
        GROUP BY 
            p.id, p.name, p.price, p.img
        ORDER BY 
            total_sold DESC
    ";
    return pdo_query($sql);
}

function get_sp_by_id($id)
{
    $sql = "SELECT * FROM product WHERE id=?";
    return pdo_query_one($sql, $id);
}

function get_dssp_lienquan($iddm, $id, $limi)
{
    $sql = "SELECT * FROM product WHERE $iddm=? AND id<>? ORDER BY view DESC limit  " . $limi;
    return pdo_query($sql, $iddm, $id);
}

function get_best($limi)
{
    $sql = " SELECT * FROM product WHERE bestseller=1 order by id limit " . $limi;
    return pdo_query($sql);
}
function get_new($limi)
{
    $sql = " SELECT * FROM product WHERE new=1 order by id limit " . $limi;
    return pdo_query($sql);
}
function get_hot($limi)
{
    $sql = " SELECT * FROM product WHERE hot=1 order by id limit " . $limi;
    return pdo_query($sql);
}

function showsp($dssp)
{
    $html_dssp = '';
    foreach ($dssp as $sp) {
        extract($sp);
        if ($price > 0) {
            $gia = '<span class="current__price">' . number_format($price, 0, ",", ".") . 'VNĐ</span>';
            $gia_cu = '<span class="old__price">' . number_format($old_price, 0, ",", ".") . 'VNĐ</span>';
        } else {
            $gia = '<span class="current__price">Đang cập nhật</span>';
            $gia_cu = '<span class="product__price"></span> <br>';
        }
        $link = "index.php?pg=product-detail&idpro=" . $id;
        $html_dssp .= '<div class="col mb-30">
                    <div class="product__items ">
                        <div class="product__items--thumbnail">
                            <a class="product__items--link" href="' . $link . '">
                                <img class="product__items--img product__primary--img" src="./uploads/' . $img . '" alt="product-img">
                            </a>
                            <div class="product__badge">
                                
                            </div>
                        </div>
                        <div class="product__items--content">
                            <h3 class="product__items--content__title h4"><a href="' . $link . '">' . $name . '</a></h3>
                            <div class="product__items--price">
                                <span class="current__price">' . $gia . '</span>
                                <span class="price__divided"></span>
                                <span class="old__price">' . $gia_cu . '</span>
                            </div>
                            <ul class="rating product__rating d-flex">
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
                            <ul class="product__items--action d-flex">
                                <li class="product__items--action__list">
                                    <form action="' . $link . '" method="get"> 
                                        
                                        <input type="hidden" name="id" value="' . $id . '">
                                        <input type="hidden" name="name" value="' . $name . '">
                                        <input type="hidden" name="img" value="' . $img . '">
                                        <input type="hidden" name="price" value="' . $price . '">
                                        <input type="hidden" name="amount" value="1">
                                        <button class="product__items--action__btn add__to--cart" type="submit" name="btnaddcart">
                                        <svg class="product__items--action__btn--svg" xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 24 24">
                                        <g transform="translate(0 0)">
                                            <g>
                                                <path data-name="Path 1" d="M19 2h-1V1a1 1 0 0 0-2 0v1H8V1a1 1 0 0 0-2 0v1H5C3.346 2 2 3.346 2 5v14c0 1.654 1.346 3 3 3h14c1.654 0 3-1.346 3-3V5c0-1.654-1.346-3-3-3zm1 17c0 .551-.449 1-1 1H5c-.551 0-1-.449-1-1V9h16v10zm0-12H4V5c0-.551.449-1 1-1h1v1a1 1 0 0 0 2 0V4h8v1a1 1 0 0 0 2 0V4h1c.551 0 1 .449 1 1v2z" fill="currentColor"></path>
                                                <path data-name="Path 2" d="M7 12h2v2H7zM11 12h2v2h-2zM15 12h2v2h-2zM7 16h2v2H7zM11 16h2v2h-2zM15 16h2v2h-2z" fill="currentColor"></path>
                                            </g>
                                        </g>
                                    </svg>
                                    
                                            <a href="' . $link . '" class="add__to--cart__text">Đặt lịch ngay</a>
                                        </button>
                                    </form>
                                </li>
                                <li class="product__items--action__list">
                                    <a class="product__items--action__btn" data-open="modal1" href="' . $link . '">
                                        <svg class="product__items--action__btn--svg" xmlns="http://www.w3.org/2000/svg"  width="25.51" height="23.443" viewBox="0 0 512 512"><path d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><circle cx="256" cy="256" r="80" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/></svg>
                                        <span class="visually-hidden">Quick View</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>';
    }
    return $html_dssp;
}
function showsp_($dssp)
{
    $html_dssp = '';
    foreach ($dssp as $sp) {
        extract($sp);
        if ($price > 0) {
            $gia = '<span class="current__price">' . number_format($price, 0, ",", ".") . 'VNĐ</span>';
            $gia_cu = '<span class="old__price">' . number_format($old_price, 0, ",", ".") . 'VNĐ</span>';
        } else {
            $gia = '<span class="current__price">Đang cập nhật</span>';
            $gia_cu = '<span class="product__price"></span> <br>';
        }
        $link = "index.php?pg=product-detail&idpro=" . $id;
        $html_dssp .= '<div class="col mb-30">
                    <div class="product__items ">
                        <div class="product__items--thumbnail">
                            <a class="product__items--link" >
                                <img class="product__items--img product__primary--img" src="./uploads/' . $img . '" alt="product-img">
                            </a>
                            <div class="product__badge">
                                
                            </div>
                        </div>
                        <div class="product__items--content">
                            <h3 class="product__items--content__title h4"><a href="' . $link . '">' . $name . '</a></h3>
                            <div class="product__items--price">
                                <span class="current__price">' . $gia . '</span>
                                <span class="price__divided"></span>
                                <span class="old__price">' . $gia_cu . '</span>
                            </div>
                            <ul class="rating product__rating d-flex">
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
                        
                        </div>
                    </div>
                </div>';
    }
    return $html_dssp;
}
function showsp_slide($dssp)
{
    $html_dssp = '';
    foreach ($dssp as $sp) {
        extract($sp);
        if ($price > 0) {
            $gia = '<span class="current__price">' . number_format($price, 0, ",", ".") . 'VNĐ</span>';
            $gia_cu = '<span class="old__price">' . number_format($old_price, 0, ",", ".") . 'VNĐ</span>';
        } else {
            $gia = '<span class="current__price">Đang cập nhật</span>';
            $gia_cu = '<span class="product__price"></span> <br>';
        }
        $link = "index.php?pg=product-detail&idpro=" . $id;
        $html_dssp .= '<div class="swiper-slide">
                    <div class="product__items ">
                        <div class="product__items--thumbnail">
                            <a class="product__items--link" href="' . $link . '">
                                <img class="product__items--img product__primary--img" src="./uploads/' . $img . '" alt="product-img">
                            </a>
                            <div class="product__badge">
                                
                            </div>
                        </div>
                        <div class="product__items--content">
                            <h3 class="product__items--content__title h4"><a href="' . $link . '">' . $name . '</a></h3>
                            <div class="product__items--price">
                                <span class="current__price">' . $gia . '</span>
                                <span class="price__divided"></span>
                                <span class="old__price">' . $gia_cu . '</span>
                            </div>
                            <ul class="rating product__rating d-flex">
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
                            <ul class="product__items--action d-flex">
                                <li class="product__items--action__list">
                                    <form action="' . $link . '" method="get"> 
                                        
                                        <input type="hidden" name="id" value="' . $id . '">
                                        <input type="hidden" name="name" value="' . $name . '">
                                        <input type="hidden" name="img" value="' . $img . '">
                                        <input type="hidden" name="price" value="' . $price . '">
                                        <input type="hidden" name="amount" value="1">
                                        <button class="product__items--action__btn add__to--cart" type="submit" name="btnaddcart">
                                        <svg class="product__items--action__btn--svg" xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 24 24">
                                        <g transform="translate(0 0)">
                                            <g>
                                                <path data-name="Path 1" d="M19 2h-1V1a1 1 0 0 0-2 0v1H8V1a1 1 0 0 0-2 0v1H5C3.346 2 2 3.346 2 5v14c0 1.654 1.346 3 3 3h14c1.654 0 3-1.346 3-3V5c0-1.654-1.346-3-3-3zm1 17c0 .551-.449 1-1 1H5c-.551 0-1-.449-1-1V9h16v10zm0-12H4V5c0-.551.449-1 1-1h1v1a1 1 0 0 0 2 0V4h8v1a1 1 0 0 0 2 0V4h1c.551 0 1 .449 1 1v2z" fill="currentColor"></path>
                                                <path data-name="Path 2" d="M7 12h2v2H7zM11 12h2v2h-2zM15 12h2v2h-2zM7 16h2v2H7zM11 16h2v2h-2zM15 16h2v2h-2z" fill="currentColor"></path>
                                            </g>
                                        </g>
                                    </svg>
                                    
                                            <a href="' . $link . '" class="add__to--cart__text">Đặt lịch ngay</a>
                                        </button>
                                    </form>
                                </li>
                                <li class="product__items--action__list">
                                    <a class="product__items--action__btn" data-open="modal1" href="' . $link . '">
                                        <svg class="product__items--action__btn--svg" xmlns="http://www.w3.org/2000/svg"  width="25.51" height="23.443" viewBox="0 0 512 512"><path d="M255.66 112c-77.94 0-157.89 45.11-220.83 135.33a16 16 0 00-.27 17.77C82.92 340.8 161.8 400 255.66 400c92.84 0 173.34-59.38 221.79-135.25a16.14 16.14 0 000-17.47C428.89 172.28 347.8 112 255.66 112z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><circle cx="256" cy="256" r="80" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/></svg>
                                        <span class="visually-hidden">Quick View</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>';
    }
    return $html_dssp;
}

//ADMIN

function showsp_admin($dssp)
{
    $html_dssp = '';
    $i = 1;
    foreach ($dssp as $sp) {
        extract($sp);
        if ($price > 0) {
            $gia = '<span>' . number_format($price, 0, ",", ".") . '</span>';
            $gia_cu = '<span>' . number_format($old_price, 0, ",", ".") . '</span>';
        } else {
            $gia = '<span>0</span>';
            $gia_cu = '<span>0</span> <br>';
        }
        if ($bestseller == 1) {
            $bestcheck = 'checked';
        } else {
            $bestcheck = '';
        }
        if ($hot == 1) {
            $hotcheck = 'checked';
        } else {
            $hotcheck = '';
        }
        if ($new == 1) {
            $newcheck = 'checked';
        } else {
            $newcheck = '';
        }
        $html_dssp .= '<article class="itemlist">
                    <div class="row align-items-center">
                        <div class="col-lg-1 col-quantity"> 
                            <span>' . $id . '</span> 
                        </div>
                        <div class="col-lg-2 col-sm-4 col-8 flex-grow-1 col-name">
                            <a class="itemside" href="#">
                                <div class="left">
                                    <img src="' . IMG_PATH_ADMIN . $img . '" class="img-sm img-thumbnail" alt="Item">
                                </div>
                                <div class="info">
                                    <h6 class="mb-0">' . $name . '</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-1 col-sm-2 col-4 col-price"> 
                            <span>' . $gia . '</span> 
                        </div>
                        <div class="col-lg-1 col-sm-2 col-4 col-old_price">
                            <span><del>' . $gia_cu . '</del></span> 
                        </div>
                        <div class="col-lg-5 col-sm-2 col-4 col-describe">
                            <p>' . $describe1 . '</p>
                        </div>
                        <div class="col-lg-1 col-sm-2 col-4 col-action text-end">
                            <a href="index.php?pg=page-update-product&id=' . $id . '" class="btn btn-sm font-sm rounded btn-brand">
                                <i class="material-icons md-edit"></i>Sửa</a>
                            <a href="index.php?pg=delproduct&id=' . $id . '" class="btn btn-sm font-sm btn-light rounded">
                                <i class="material-icons md-delete_forever"></i>Xóa
                            </a>
                        </div>
                        <input hidden type="checkbox" name="best" ' . $bestcheck . ' class="form-control1">
                        <input hidden type="checkbox" name="new" ' . $newcheck . ' class="form-control1">
                        <input hidden type="checkbox" name="hot" ' . $hotcheck . ' class="form-control1">
                    </div>
                </article>';
        $i++;
    }
    return $html_dssp;
}
function showsp_admin_services($dssp)
{
    $html_dssp = '';
    $i = 1;
    foreach ($dssp as $sp) {
        extract($sp);
        if ($price > 0) {
            $gia = '<span>' . number_format($price, 0, ",", ".") . '</span>';
            $gia_cu = '<span>' . number_format($old_price, 0, ",", ".") . '</span>';
        } else {
            $gia = '<span>0</span>';
            $gia_cu = '<span>0</span> <br>';
        }
        if ($bestseller == 1) {
            $bestcheck = 'checked';
        } else {
            $bestcheck = '';
        }
        if ($hot == 1) {
            $hotcheck = 'checked';
        } else {
            $hotcheck = '';
        }
        if ($new == 1) {
            $newcheck = 'checked';
        } else {
            $newcheck = '';
        }
        $html_dssp .= '<article class="itemlist">
                    <div class="row align-items-center">
                        <div class="col-lg-1 col-quantity"> 
                            <span>' . $id . '</span> 
                        </div>
                        <div class="col-lg-2 col-sm-4 col-8 flex-grow-1 col-name">
                            <a class="itemside" href="#">
                                <div class="left">
                                    <img src="' . IMG_PATH_ADMIN . $img . '" class="img-sm img-thumbnail" alt="Item">
                                </div>
                                <div class="info">
                                    <h6 class="mb-0">' . $name . '</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-1 col-sm-2 col-4 col-price"> 
                            <span>' . $gia . '</span> 
                        </div>
                        <div class="col-lg-1 col-sm-2 col-4 col-old_price">
                            <span><del>' . $gia_cu . '</del></span> 
                        </div>
                        <div class="col-lg-5 col-sm-2 col-4 col-describe">
                            <p>' . $describe1 . '</p>
                        </div>
                        <div class="col-lg-1 col-sm-2 col-4 col-action text-end">
                            <a href="index.php?pg=page-update-service&id=' . $id . '" class="btn btn-sm font-sm rounded btn-brand">
                                <i class="material-icons md-edit"></i>Sửa</a>
                            <a href="index.php?pg=delservice&id=' . $id . '" class="btn btn-sm font-sm btn-light rounded">
                                <i class="material-icons md-delete_forever"></i>Xóa
                            </a>
                        </div>
                        <input hidden type="checkbox" name="best" ' . $bestcheck . ' class="form-control1">
                        <input hidden type="checkbox" name="new" ' . $newcheck . ' class="form-control1">
                        <input hidden type="checkbox" name="hot" ' . $hotcheck . ' class="form-control1">
                    </div>
                </article>';
        $i++;
    }
    return $html_dssp;
}

function hien_thi_so_trang($productlist, $soluongsp)
{
    $tong_sp = count($productlist);
    $sotrang = ceil($tong_sp / $soluongsp);
    $html_sotrang = "";

    for ($i = 1; $i <= $sotrang; $i++) {
        $html_sotrang .= '<li class="page-item active">
                        <a class="page-link" href="index.php?pg=products-list&page=' . $i . '">' . $i . '</a>
                        </li>';
    }
    return $html_sotrang;
}

function get_dssp_admin($kyw, $iddm, $page, $soluongsp)
{
    $batdau = ($page - 1) * $soluongsp;
    $sql = "SELECT * FROM product WHERE service = 0";

    if ($iddm > 0) {
        $sql .= " AND iddm=" . $iddm;
    }
    if ($kyw != "") {
        $sql .= " AND name LIKE '%" . $kyw . "%'";
    }

    $sql .= " ORDER BY id ASC LIMIT " . $batdau . "," . $soluongsp;
    return pdo_query($sql);
}

function get_dssp_all()
{
    $sql = "SELECT * FROM product WHERE service = 0 ORDER BY id ASC";
    return pdo_query($sql);
}

function hien_thi_so_trang_services($productlist, $soluongsp)
{
    $tong_sp = count($productlist);
    $sotrang = ceil($tong_sp / $soluongsp);
    $html_sotrang = "";

    for ($i = 1; $i <= $sotrang; $i++) {
        $html_sotrang .= '<li class="page-item active">
                          <a class="page-link" href="index.php?pg=services-list&page=' . $i . '">' . $i . '</a>
                          </li>';
    }
    return $html_sotrang;
}

function get_dssp_admin_services($kyw, $iddm, $page, $soluongsp)
{
    $batdau = ($page - 1) * $soluongsp;
    $sql = "SELECT * FROM product WHERE service = 1";

    if ($iddm > 0) {
        $sql .= " AND iddm = " . $iddm;
    }
    if ($kyw != "") {
        $sql .= " AND name LIKE '%" . $kyw . "%'";
    }

    $sql .= " ORDER BY id ASC LIMIT " . $batdau . ", " . $soluongsp;
    return pdo_query($sql);
}

function get_dssp_all_services()
{
    $sql = "SELECT * FROM product WHERE service = 1 ORDER BY id ASC";
    return pdo_query($sql);
}

function get_img($id)
{
    $sql = "SELECT img FROM product WHERE id=?";
    $getimg = pdo_query_one($sql, $id);

    // Kiểm tra xem có dữ liệu trả về hay không
    if ($getimg !== false && is_array($getimg)) {
        return $getimg['img'];
    } else {
        // Xử lý trường hợp không có dữ liệu
        return 'Ảnh không tồn tại'; // Hoặc giá trị mặc định khác tùy vào yêu cầu của bạn
    }
}
