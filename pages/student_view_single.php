<?php
// check session
include dirname(__FILE__) . '/layouts/isagency.php';
include '../api/db.php';
$conn = new db();
$_GET['id'] ? $id = $_GET['id'] : header('location: ./site.php');
$students_arr = $conn->select_join('users', 'students', ['users.*', 'students.*', 'users.id as user_id'], 'users.id = students.user_id WHERE users.enabled = 1 AND users.role = 0 AND users.id =' . $id);
if (count($students_arr) < 1) header('location: ./site.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include dirname(__FILE__) . '/layouts/css.php'; ?>
    <title><?= $GLOBALS['site_name'] ?> | ข้อมูลนักเรียน</title>
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
                        <a href="./site.php" class="text-muted">
                            <i class="fas fa-long-arrow-alt-left"></i>
                            ย้อนกลับ
                        </a>
                        <div class="d-flex justify-content-center mb-2 w-100">
                            <img src="../assets/profile/<?= $students_arr[0]['path'] ?  $students_arr[0]['path'] : 'default.png' ?>" width="150px" height="150px" alt="">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">ชื่อ - นามสกุล</label>
                                <input type="text" disabled class="form-control mb-2" value="<?= $students_arr[0]['fullname'] ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="">รหัสนักเรียน</label>
                                <input type="text" disabled class="form-control mb-2" value="<?= $students_arr[0]['username'] ?>">
                            </div>
                            <div class="col-md-2">
                                <label for="">ระดับชั้น</label>
                                <input type="text" disabled class="form-control mb-2" value="<?= $students_arr[0]['degree'] ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="">วันเกิด</label>
                                <input type="text" disabled class="form-control mb-2" value="<?= $conn->dateFormat($students_arr[0]['birthday']) ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="">แผนก</label>
                                <input type="text" disabled class="form-control mb-2" value="<?= $students_arr[0]['department'] ?>">
                            </div>
                            <div class="col-md-12">
                                <label for="">ลิงค์</label>
                                <input type="text" disabled class="form-control mb-2" value="<?= $students_arr[0]['link'] ?>">
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

    <?php include dirname(__FILE__) . '/layouts/script.php' ?>

</body>

</html>