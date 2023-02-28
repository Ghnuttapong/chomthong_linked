<?php
include './layouts/isagency.php';
include '../api/db.php';
$conn = new db();
$data = $conn->select_belong('users', 'agencies', 'users.*, agencies.*', 'users.id = agencies.user_id', ['users.id'], [$_SESSION['user_id']]);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include dirname(__FILE__) . '/layouts/css.php'; ?>
    <title><?= $GLOBALS['site_name'] ?> | โปรไฟล์</title>
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
                            <div class="card-header bg-danger">โปรไฟล์</div>
                            <div class="card-body">
                                <div class="d-flex justify-content-center mb-3">
                                    <img src="../assets/profile/<?= $data['path'] == null ? 'default.png' : $data['path'] ?>" alt="<?= $data['fullname'] ?>" style="width: 200px; height: 200px; object-fit: cover;" class="img-circle img-fluid">
                                </div>
                                <form method="post" id="form-profile">
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <input type="file" required name="file" accept="image/png, image/jpeg" class="custom-file-input" id="file">
                                            <label class="custom-file-label" for="customFile">เลือกไฟล์</label>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <input type="submit" class="btn btn-secondary rounded-0" value="ยืนยัน">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">ข้อมูลนักศึกษา</div>
                            <div class="card-body">
                                <div class="text-muted">
                                    <p>ชื่อ-นามสกุล: <span class="text-dark"> <?= $data['fullname'] ?></span></p>
                                    <p>ชื่อผู้ใช้: <span class="text-dark"> <?= $data['username'] ?></span></p>
                                    <p>สถานะ: <span class="text-success">กำลังใช้งาน</span></p>
                                    <div class="flex">
                                        <a href="./profile.php" class="btn btn-primary btn-sm border-0 rounded-0">เปลี่ยนรหัสผ่าน</a>
                                        <a href="./add_profile.php" class="btn btn-secondary btn-sm border-0 rounded-0 ml-2">เพิ่มรูปโปรไฟล์</a>
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

    <?php include './layouts/script.php' ?>
    <script>
        // file button 
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
    <script>
        $('#form-profile').submit(e => {
            e.preventDefault();
            let formData = new FormData();
            formData.append("file", $('input[type="file"]')[0].files[0]);
            $.ajax({
                type: 'POST',
                url: '../api/user/profile.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'JSON',
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
        })
    </script>
</body>


</html>