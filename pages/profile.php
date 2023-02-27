<?php
include "../api/db.php";
include dirname(__FILE__) . '/layouts/isagency.php';
$conn = new db();
$data = $conn->select_fetch('users', ['*'], ['id'], [$_SESSION['user_id']]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include './layouts/css.php' ?>
    <title><?= $site_name ?> | เปลี่ยนรหัสผ่าน</title>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <?php include "./layouts/preloader.php" ?>

        <?php include "./layouts/navbar.php" ?>
        <?php include "./layouts/sidebar.php" ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content pt-5">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header bg-danger">เปลี่ยนรหัสผ่าน</div>
                            <div class="card-body">
                                <form method="post" id="form-password">
                                    <input type="password" name="curent_password" placeholder="รหัสผ่านเดิม" class="form-control mb-2 rounded-0">
                                    <input type="password" name="new_password" placeholder="รหัสผ่านใหม่" class="form-control mb-2 rounded-0">
                                    <input type="password" name="confirm_password" placeholder="ยืนยันรหัสผ่าน" class="form-control mb-2 rounded-0">
                                    <div class="d-flex justify-content-end">
                                        <input type="submit" class="btn btn-secondary btn-flat" value="ส่ง">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">ข้อมูลผู้ดูแล</div>
                            <div class="card-body">
                                <div class="text-muted">
                                    <p>ชื่อ-นามสกุล: <span class="text-dark"> <?= $data['fullname'] ?></span></p>
                                    <p>ชื่อผู้ใช้: <span class="text-dark"> <?= $data['username'] ?></span></p>
                                    <p>สถานะ: <span class="text-success">กำลังใช้งาน</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->

    <?php include './layouts/script.php' ?>
    <script>
        $('#form-password').on('submit', function(e) {
            e.preventDefault()
            $.ajax({
                type: 'POST',
                data: $(this).serialize(),
                url: '../api/user/change_password.php',
                dataType: 'JSON',
                success: function(res) {
                    Toast.fire({
                        icon: 'success',
                        title: res.msg
                    })
                    setInterval(function() {
                        window.location.reload()
                    }, 1000)
                },
                error: function(xhr, status, error) {
                    let err = eval(xhr.responseJSON);
                    Toast.fire({
                        icon: 'error',
                        title: err.msg
                    })
                }
            })
        })
    </script>
</body>

</html>