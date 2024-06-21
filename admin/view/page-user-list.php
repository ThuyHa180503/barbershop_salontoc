<?php
$html_userlist = "";
$html_role = "";
foreach ($listuser as $users) {
    extract($users);
    if ($role == 1) {
        $html_role = '<a class="dropdown-item" href="index.php?pg=abort-role&id=' . $id . '">Hủy quyền Admin</a>';
    }
    if ($role == 0) {
        $html_role = '<a class="dropdown-item" href="index.php?pg=update-role&id=' . $id . '">Cấp quyền Admin</a>';
    }
    $html_userlist .= '<tr>
                        <td width="23%">
                            <a href="#" class="itemside">
                                <div class="left">
                                    <img src="../uploads/' . $img . '" class="img-sm img-avatar" alt="Userpic">
                                </div>
                                <div class="info pl-3">
                                    <h6 class="mb-0 title">' . $username . '</h6>
                                    <small class="text-muted" style="font-size: 12px;">' . $name . '</small> <br>
                                    <small class="text-muted">Mã khách hàng: #' . $id . '</small>
                                </div>
                            </a>
                        </td>
                        <td>
                            <a href="mailto:' . $email . '" class="__cf_email__">' . $email . '</a>
                        </td>
                        <td><span class="badge rounded-pill alert-success">' . $sdt . '</span></td>
                        <td width="20%">' . $address . '</td>
                        <td width="10%">
                            <span class="badge rounded-pill ' . (($role == 1) ? 'bg-primary' : 'bg-secondary') . '">' . (($role == 1) ? 'admin' : 'user') . '</span>
                        </td>
                        <td class="text-end">
                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                <div class="dropdown-menu">
                                    ' . $html_role . '
                                    <a class="dropdown-item text-danger" href="index.php?pg=deluser&id=' . $id . '">Xóa</a>
                                </div>
                            </div>
                        </td>
                    </tr>';
}
?>

<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Danh sách tài khoản</h2>
    </div>
    <div class="card mb-4">
        <header class="card-header">
            <div class="row">
                <div class="">
                    <form action="index.php?pg=user-list" method="post">
                        <div class="input-group">
                            <div class="col-3">
                                <input type="text" name="kyw" placeholder="Tìm..." class="form-control">

                            </div>
                            <div class="col-7"> <button hidden class="btn btn-light bg btn-fix" type="submit" name="search"> <i class="fa-solid fa-magnifying-glass" style="color: zz;"></i></button>
                            </div>
                            <div class="col-2"> <select class="form-select mx-2" id="user-role-filter" style="width: 150px;">
                                    <option value="">Tất cả</option>
                                    <option value="1">Admin</option>
                                    <option value="0">User</option>
                                </select></div>

                        </div>
                    </form>
                </div>
            </div>
        </header>
        <!-- card-header end// -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tài Khoản</th>
                            <th>Email</th>
                            <th>SDT</th>
                            <th>Địa Chỉ</th>
                            <th>Quyền</th>
                            <th class="text-end"> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= $html_userlist; ?>
                    </tbody>
                </table>
                <!-- table-responsive.// -->
            </div>
        </div>
        <!-- card-body end// -->
    </div>
    <!-- card end// -->
    <div class="pagination-area mt-15 mb-50" style="text-align: center; justify-content: center; display: flex;">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-start">
                <?php echo $hienthi_user; ?>
            </ul>
        </nav>
    </div>
</section>
<script>
    document.getElementById('user-role-filter').addEventListener('change', function() {
        var role = this.value;
        var rows = document.getElementsByTagName('tr');
        for (var i = 0; i < rows.length; i++) {
            var roleCell = rows[i].getElementsByTagName('td')[4];
            if (roleCell) {
                var roleText = roleCell.textContent.trim();
                if (role === '') {
                    rows[i].style.display = '';
                } else if (role === '1' && roleText === 'admin') {
                    rows[i].style.display = '';
                } else if (role === '0' && roleText === 'user') {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
    });
</script>