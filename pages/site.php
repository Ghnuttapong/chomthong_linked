<?php
include dirname(__FILE__) . '/layouts/isagency.php';
include '../api/db.php';
include './data/index.php';
$conn = new db();

$total_records = $conn->select_fetch('users', ['COUNT(*) as count'], ['role', 'enabled'], [0, 1]);
$total_pages = ceil($total_records['count'] / 6);

$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$start_record = ($current_page - 1) * 6;

$limit = " LIMIT $start_record, 6";
$data_arr = $conn->select_join('users', 'students', ['users.*', 'students.*', 'users.id as user_id'], 'users.id = students.user_id WHERE users.role = 0 AND users.enabled = 1 ' . $limit);
if (isset($_GET['keyword'])) {
    $data_arr = $conn->select_join('users', 'students', ['users.*', 'students.*', 'users.id as user_id'], 'users.id = students.user_id WHERE users.role = 0 AND students.link IS NOT NULL ' . $limit);
}
if (isset($_GET['department'])) {
    $data_arr = array();
    foreach ($_GET['department'] as $val) {
        $new_data = $conn->select_join('users', 'students', ['users.*', 'students.*', 'users.id as user_id'], 'users.id = students.user_id WHERE users.role = 0 AND users.enabled = 1 AND students.department = "' . $val . '"' . $limit);
        array_push($data_arr, ...$new_data);
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include dirname(__FILE__) . '/layouts/css.php'; ?>
    <title><?= $GLOBALS['site_name'] ?> | ลิงค์เว็บไซต์</title>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <?php include dirname(__FILE__) . '/layouts/preloader.php'; ?>

        <?php include dirname(__FILE__) . '/layouts/navbar.php'; ?>
        <?php include dirname(__FILE__) . '/layouts/sidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">ผลงานนักเรียน</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <?php if ($_SESSION['role'] == 2) { ?>
                                    <li class="breadcrumb-item"><a href="./index.html">หน้าแรก</a></li>
                                <?php } ?>
                                <li class="breadcrumb-item active">ผลงาน</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 col-lg-9">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <?php if (empty($data_arr)) { ?>
                                            <div class="w-100 d-flex justify-content-center">
                                                <h6>ไม่พบข้อมูล</h6>
                                            </div>
                                        <?php } ?>
                                        <?php foreach ($data_arr as $val) { ?>
                                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 d-flex align-items-stretch flex-column">
                                                <div class="card bg-light d-flex flex-fill">
                                                    <div class="card-header text-muted border-bottom-0">
                                                        <?= $val['department'] ?>
                                                    </div>
                                                    <div class="card-body pt-0">
                                                        <div class="row">
                                                            <div class="col-7">
                                                                <h2 class="lead"><b><?= $val['fullname'] ?></b></h2>
                                                                <p class="text-muted text-sm"><b>ระดับชั้น: </b> <?= $val['degree'] ?> </p>
                                                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                                                    <li class="small"><span class="fa-li"><i class="fas fa-id-card"></i></span> รหัสนักศึกษา: <?= $val['username'] ?></li>
                                                                    <li class="small"><span class="fa-li"><i class="fas fa-birthday-cake"></i></span> วันเกิด : <?= $conn->dateFormat($val['birthday']) ?></li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-5 text-center">
                                                                <img src="../assets/profile/<?= $val['path'] == null ? 'default.png' : $val['path'] ?>" alt="<?= $val['fullname'] ?>" style="object-fit: cover; width:100px; height: 100px;" class="img-circle img-fluid">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <div class="text-right">
                                                            <?php if ($_SESSION['role'] == 2) { ?>
                                                                <button onclick="confirmDel(<?= $val['user_id'] ?>)" data-id="<?= $val['user_id'] ?>" class="btn btn-sm bg-danger">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            <?php } ?>
                                                            <?php if ($val['link']) {  ?>
                                                                <a href="<?= $val['link'] ?>" target="_blank" class="btn btn-sm bg-secondary">
                                                                    <i class="fas fa-link"></i>
                                                                </a>
                                                            <?php } ?>
                                                            <a href="student_view_single.php?id=<?= $val['user_id'] ?>" class="btn btn-sm btn-primary">
                                                                <i class="fas fa-user"></i> ดูข้อมูลเพิ่มเติม
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <?php if ($total_pages > 1) { ?>
                                        <ul class="pagination pagination-sm m-0 float-right">
                                            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                                <li class="page-item"><a class="page-link" href="site.php?page=<?= $i ?>"><?= $i ?></a></li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-none d-lg-block w-100">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="" method="get">
                                            <?php foreach ($department_arr as $val) { ?>
                                                <div>
                                                    <input type="checkbox" id="department[]" name="department[]" value="<?= $val ?>">
                                                    <label class="text-muted text-sm"><?= $val ?></label>
                                                </div>
                                            <?php } ?>
                                            <button type="submit" class="btn btn-outline-secondary w-100"><i class='fas fa-filter'></i>กรอง</button>
                                        </form>
                                    </div>
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
    <script>
        $(document).ready(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        })

        function confirmDel(id) {
            Swal.fire({
                title: 'คุณแน่ใจใช่ไหม?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#ccc',
                cancelButtonText: 'ยกเลิก',
                confirmButtonText: 'แน่นอน!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        data: {
                            id
                        },
                        url: '../api/user/delete.php',
                        dataType: 'JSON',
                        success: async function(res) {
                            await Swal.fire(
                                'ลบแล้ว!',
                                res.msg,
                                'success'
                            )
                            await window.location.reload()
                        },
                        error: function(xhr, status, error) {
                            let err = eval(xhr.responseJSON);
                            Toast.fire({
                                icon: 'error',
                                title: err.msg
                            })
                        }
                    })
                }
            })
        }
    </script>
</body>

</html>