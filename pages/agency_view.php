<?php
include dirname(__FILE__) . '/layouts/isadmin.php';
include '../api/db.php';
$conn = new db();
$data_arr = $conn->select_all('users WHERE enabled = 0 AND role = 1', ['*'])
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include dirname(__FILE__) . '/layouts/css.php'; ?>
    <title><?= $GLOBALS['site_name'] ?> | รายชื่อหน่วยงาน</title>
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
                            <h1 class="m-0">หน่วยงาน</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="./index.html">หน้าแรก</a></li>
                                <li class="breadcrumb-item active">หน่วยงาน</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header ui-sortable-handle">
                            <h3 class="card-title">
                                รายการ
                            </h3>
                        </div>
                        <div class="card-body">

                            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10%;" class="sorting sorting_asc" tabindex="0" rowspan="1" colspan="1" aria-sort="ascending">ลำดับ</th>
                                                    <th style="width: 40%;" class="sorting" tabindex="0" rowspan="1" colspan="1">ชื่อ - นามสกุล</th>
                                                    <th style="width: 20%;" class="sorting" tabindex="0" rowspan="1" colspan="1">รหัสนักศึกษา</th>
                                                    <th style="width: 10%;" class="sorting" tabindex="0" rowspan="1" colspan="1"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (empty($data_arr)) { ?>
                                                    <td colspan="6" class="text-center">ไม่พบข้อมูล.</td>
                                                <?php } else { ?>
                                                    <?php $no = 1;
                                                    for ($i = 0; $i < count($data_arr); $i++) { ?>
                                                        <tr>
                                                            <td><?= $no++ ?></td>
                                                            <td>
                                                                <?= $data_arr[$i]['fullname'] ?>
                                                            </td>
                                                            <td> <?= $data_arr[$i]['username'] ?> </td>
                                                            <td>
                                                                <button onclick="approve(this)" data-id="<?= $data_arr[$i]['id'] ?>" class="btn btn-info w-100">อนุมัติ</button>
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

        function approve(elm) {
            let data = elm.dataset.id
            $.ajax({
                url: '../api/approve.php',
                type: 'post',
                dataType: 'JSON',
                data: {
                    id: data
                },
                success: function(res) {
                    Toast.fire({
                        icon: 'success',
                        title: res.msg
                    })
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