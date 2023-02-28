<?php
include dirname(__FILE__) . '/layouts/isadmin.php';
include '../api/db.php';
$conn = new db();
$students_arr = $conn->select_join('students', 'users', ['students.*', 'users.*'], 'students.user_id = users.id WHERE role = 0 AND enabled = 0');
$agencies_arr = $conn->select_join('agencies', 'users', ['agencies.*', 'users.*'], 'agencies.user_id = users.id WHERE role = 1 AND enabled = 0');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include dirname(__FILE__) . '/layouts/css.php'; ?>
    <title><?= $GLOBALS['site_name'] ?> | สมาชิกใหม่</title>
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
                            <h1 class="m-0">สมาชิกใหม่</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="./index.html">หน้าแรก</a></li>
                                <li class="breadcrumb-item active">สมาชิกใหม่</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="card card-danger card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="student-two-tab" data-toggle="pill" href="#student-two" role="tab" aria-controls="student-two" aria-selected="true">นักเรียนใหม่</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="agency-two-tab" data-toggle="pill" href="#agency-two" role="tab" aria-controls="agency-two" aria-selected="false">หน่วยงาน</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade show active" id="student-two" role="tabpanel" aria-labelledby="student-two-tab">
                                <div id="students_table" class="dataTables_wrapper dt-bootstrap4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="student_example" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="student_example_info">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%;" class="sorting sorting_asc" tabindex="0" rowspan="1" colspan="1" aria-sort="ascending">ลำดับ</th>
                                                        <th style="width: 40%;" class="sorting" tabindex="0" rowspan="1" colspan="1">ชื่อ - นามสกุล</th>
                                                        <th style="width: 15%;" class="sorting" tabindex="0" rowspan="1" colspan="1">รหัสนักศึกษา</th>
                                                        <th style="width: 15%;" class="sorting" tabindex="0" rowspan="1" colspan="1">แผนก</th>
                                                        <th style="width: 10%;" class="sorting" tabindex="0" rowspan="1" colspan="1">ระดับชั้น</th>
                                                        <th style="width: 10%;" class="sorting" tabindex="0" rowspan="1" colspan="1"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (empty($students_arr)) { ?>
                                                        <td colspan="6" class="text-center">Not found data.</td>
                                                    <?php } else { ?>
                                                        <?php $no = 1;
                                                        for ($i = 0; $i < count($students_arr); $i++) { ?>
                                                            <tr>
                                                                <td><?= $no++ ?></td>
                                                                <td>
                                                                    <?= $students_arr[$i]['fullname'] ?>
                                                                </td>
                                                                <td>
                                                                    <?= $students_arr[$i]['username'] ?>
                                                                </td>
                                                                <td>
                                                                    <?= $students_arr[$i]['department'] ?>
                                                                </td>
                                                                <td>
                                                                    <?= $students_arr[$i]['degree'] ?>
                                                                </td>
                                                                <td>
                                                                    <div class="text-center">
                                                                        <button onclick="approve(this)" data-id="<?= $students_arr[$i]['id'] ?>" class="btn btn-secondary btn-sm rounded-0"><i class="fas fa-check"></i></button>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="agency-two" role="tabpanel" aria-labelledby="agency-two-tab">
                                <div id="agency_table" class="dataTables_wrapper dt-bootstrap4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="agency_example" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="agency_example_info">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%;" class="sorting sorting_asc" tabindex="0" rowspan="1" colspan="1" aria-sort="ascending">ลำดับ</th>
                                                        <th style="width: 40%;" class="sorting" tabindex="0" rowspan="1" colspan="1">ชื่อ - นามสกุล</th>
                                                        <th style="width: 15%;" class="sorting" tabindex="0" rowspan="1" colspan="1">ชื่อหน่วยงาน</th>
                                                        <th style="width: 15%;" class="sorting" tabindex="0" rowspan="1" colspan="1">เบอร์ติดต่อ</th>
                                                        <th style="width: 10%;" class="sorting" tabindex="0" rowspan="1" colspan="1">ที่อยู่</th>
                                                        <th style="width: 10%;" class="sorting" tabindex="0" rowspan="1" colspan="1"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (empty($agencies_arr)) { ?>
                                                        <td colspan="6" class="text-center">Not found data.</td>
                                                    <?php } else { ?>
                                                        <?php $no = 1;
                                                        for ($i = 0; $i < count($agencies_arr); $i++) { ?>
                                                            <tr>
                                                                <td><?= $no++ ?></td>
                                                                <td>
                                                                    <?= $agencies_arr[$i]['fullname'] ?>
                                                                </td>
                                                                <td>
                                                                    <?= $agencies_arr[$i]['name'] ?>
                                                                </td>
                                                                <td>
                                                                    <?= $agencies_arr[$i]['phone'] ?>
                                                                </td>
                                                                <td>
                                                                    <?= $agencies_arr[$i]['address'] ?>
                                                                </td>
                                                                <td>
                                                                    <div class="text-center">
                                                                        <button onclick="approve(this)" data-id="<?= $agencies_arr[$i]['id'] ?>" class="btn btn-secondary btn-sm rounded-0"><i class="fas fa-check"></i></button>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
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
            $("#student_example").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            }).buttons().container().appendTo('#agency_table .col-md-6:eq(0)');
            $("#agency_example").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            }).buttons().container().appendTo('#student_table .col-md-6:eq(0)');
        })

        function approve(elm) {
            let data = elm.dataset.id
            $.ajax({
                url: '../api/approve.php',
                type: 'post',
                dataType: 'JSON',
                data: {
                    id: data
                },
                success: async function(res) {
                    await Toast.fire({
                        icon: 'success',
                        title: res.msg
                    })
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
    </script>
</body>

</html>