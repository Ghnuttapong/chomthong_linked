<?php
// check session
include dirname(__FILE__) . '/layouts/isadmin.php';
include '../api/db.php';
$conn = new db();
$_GET['id'] ? $id = $_GET['id'] : header('location: ./agency_view.php');
$agencies_arr = $conn->select_join('users', 'agencies', ['users.*', 'agencies.*', 'users.id as user_id'], 'users.id = agencies.user_id WHERE users.enabled = 1 AND users.role = 1 AND users.id =' . $id);
if (count($agencies_arr) < 1) header('location: ./agency_view.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include dirname(__FILE__) . '/layouts/css.php'; ?>
    <title><?= $GLOBALS['site_name'] ?> | ข้อมูลหน่วยงาน</title>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <?php include dirname(__FILE__) . '/layouts/preloader.php';
        ?>

        <?php include dirname(__FILE__) . '/layouts/navbar.php'; ?>
        <?php include dirname(__FILE__) . '/layouts/sidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">รายละเอียด</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="card">
                    <div class="card-body">
                        <a href="./agency_view.php" class="text-muted">
                            <i class="fas fa-long-arrow-alt-left"></i>
                            ย้อนกลับ
                        </a>
                        <div class="d-flex justify-content-center mb-2 w-100">
                            <img src="../assets/profile/<?= $agencies_arr[0]['path'] ?  $agencies_arr[0]['path'] : 'default.png' ?>" width="150px" height="150px" alt="">
                        </div>
                        <label for="">ชื่อ - นามสกุล</label>
                        <input type="text" disabled class="form-control mb-2" value="<?= $agencies_arr[0]['fullname'] ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">ชื่อผู้ใช้</label>
                                <input type="text" disabled class="form-control mb-2" value="<?= $agencies_arr[0]['username'] ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="">ชื่อหน่วยงาน</label>
                                <input type="text" disabled class="form-control mb-2" value="<?= $agencies_arr[0]['name'] ?>">
                            </div>
                        </div>
                        <label for="">เบอร์ติดต่อ</label>
                        <input type="text" disabled class="form-control mb-2" value="<?= $agencies_arr[0]['phone'] ?>">
                        <label for="">ที่อยู่</label>
                        <textarea style="resize: none;" class="form-control" disabled cols="30" rows="3"><?= $agencies_arr[0]['address'] ?></textarea>
                    </div>
                </div>
        </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->

    <?php include dirname(__FILE__) . '/layouts/script.php' ?>

</body>

</html>