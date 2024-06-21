<?php
$idloai = "";
$html_tintuclist = showdmtt_admin($tintuclist, $idloai);
?>

<section class="content-main">
    <form action="index.php?pg=page-add-blog" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>Thông tin tin tức</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label class="form-label" style="font-weight: 600; font-size: medium;">Tên tác giả: </label>
                            <input type="text" name="author" placeholder="Type here" class="form-control" id="author_name" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="publish_date" style="font-weight: 600; font-size: medium;">Ngày đăng: </label>
                            <input type="date" name="date" class="form-control" id="publish_date" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="title" style="font-weight: 600; font-size: medium;">Tiêu đề: </label>
                            <textarea name="title" id="title" cols="30" rows="10" class="form-control" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="content" style="font-weight: 600; font-size: medium;">Nội dung: </label>
                            <textarea name="content" id="content" cols="30" rows="10" class="form-control form-control1" style="font-size: 17px;" required></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Hình ảnh: </h4>
                        </div>
                        <div class="card-body">
                            <div class="input-upload">
                                <img src="assets/imgs/theme/upload.svg" alt="">
                                <input class="form-control" type="file" name="img" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Danh Mục: </h4>
                        </div>
                        <div class="card-body">
                            <div class="row gx-2">
                                <div class="col-sm-12 mb-3">
                                    <select class="form-select" name="idloai">
                                        <option value=""></option>
                                        <?= $html_tintuclist; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div style="text-align: center; justify-content: center; display: flex;">
                        <button type="submit" name="addblog" class="btn btn-md rounded font-sm hover-up" style="margin-right: 40px;">Thêm tin tức</button>
                        <button type="reset" name="addblog" class="btn btn-md rounded font-sm hover-up">Làm mới</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kiểm tra và lấy dữ liệu từ form
    $author = $_POST['author'] ?? '';
    $date = $_POST['date'] ?? '';
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $idloai = $_POST['idloai'] ?? '';

    // Xử lý upload file ảnh
    if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
        $img_name = $_FILES['img']['name'];
        $img_tmp_name = $_FILES['img']['tmp_name'];
        $upload_dir = 'path/to/upload/dir/';
        $uploaded = move_uploaded_file($img_tmp_name, $upload_dir . $img_name);
    } else {
        $uploaded = false;
    }

    // Kiểm tra xem dữ liệu đã được nhập đầy đủ chưa
    if ($author && $date && $title && $content && $idloai && $uploaded) {
        // Thực hiện lưu dữ liệu vào cơ sở dữ liệu
        // Ví dụ:
        // $sql = "INSERT INTO blog (author, date, title, content, img, idloai) VALUES ('$author', '$date', '$title', '$content', '$img_name', '$idloai')";
        // mysqli_query($conn, $sql);

        echo "Tin tức đã được thêm thành công!";
    } else {
        echo "Vui lòng điền đầy đủ thông tin và đảm bảo tệp hình ảnh được tải lên.";
    }
}
?>