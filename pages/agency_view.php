<?php
include dirname(__FILE__) . '/layouts/isadmin.php';
include '../api/db.php';
$conn = new db();
$agencies_arr = $conn->select_join('users', 'agencies', ['users.*', 'agencies.*', 'users.id as user_id'], 'users.id = agencies.user_id WHERE users.enabled = 1 AND users.role = 1');

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

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">หน่วยงาน</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="./index.html">หน้าแรก</a></li>
                                <li class="breadcrumb-item active">หน่วยงาน</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

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
                                                    <th style="width: 20%;" class="sorting" tabindex="0" rowspan="1" colspan="1">ชื่อผู้ใช้</th>
                                                    <th style="width: 20%;" class="sorting" tabindex="0" rowspan="1" colspan="1">ชื่อหน่วยงาน</th>
                                                    <th style="width: 20%;" class="sorting" tabindex="0" rowspan="1" colspan="1">เบอร์ติดต่อ</th>
                                                    <th style="width: 10%;" class="sorting" tabindex="0" rowspan="1" colspan="1"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (empty($agencies_arr)) { ?>
                                                    <td colspan="6" class="text-center">ไม่พบข้อมูล.</td>
                                                <?php } else { ?>
                                                    <?php $no = 1;
                                                    for ($i = 0; $i < count($agencies_arr); $i++) { ?>
                                                        <tr>
                                                            <td><?= $no++ ?></td>
                                                            <td> <?= $agencies_arr[$i]['fullname'] ?> </td>
                                                            <td> <?= $agencies_arr[$i]['username'] ?> </td>
                                                            <td> <?= $agencies_arr[$i]['name'] ?> </td>
                                                            <td> <?= $agencies_arr[$i]['phone'] ?> </td>
                                                            <td>
                                                                <div class="d-flex jutify-content-between w-100">
                                                                    <a class="btn btn-sm rounded-0 btn-info w-100" href="agency_view_single.php?id=<?= $agencies_arr[$i]['user_id'] ?>"> <i class="fas fa-eye"></i></a>
                                                                    <button onclick="confirmDel(<?= $agencies_arr[$i]['user_id'] ?>, 'agency')" data-id="<?= $agencies_arr[$i]['user_id'] ?>" class="btn btn-sm rounded-0 btn-danger w-100"><i class="fas fa-trash-alt"></i></button>
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



        function confirmDel(id, type) {
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
                            id,
                            type
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