<?php
include './layouts/isLogin.php';

$data = $conn->select_belong('users', 'students', 'users.*, students.*', 'users.id = students.user_id', ['users.id'], [$_SESSION['user_id']]);

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

<body>
    <?php include dirname(__FILE__) . '/layouts/navbar.php' ?>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-danger">โปรไฟล์</div>
                    <div class="card-body">
                        <div class="d-flex justify-content-center mb-3">
                            <img src="../../assets/profile/<?= $data['path'] == null ? 'default.png' : $data['path'] ?>" alt="<?= $data['fullname'] ?>" style="width: 200px; height: 200px; object-fit: cover;" class="img-circle img-fluid">
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
                            <p>รหัสนักศึกษา: <span class="text-dark"> <?= $data['username'] ?></span></p>
                            <p>ระดับชั้น: <span class="text-dark"> <?= $data['degree'] ?></span></p>
                            <p>แผนก: <span class="text-dark"> <?= $data['department'] ?></span></p>
                            <p>วัน/เดือน/ปีเกิด: <span class="text-dark"> <?= $conn->dateFormat($data['birthday']) ?></span></p>
                            <div class="flex">
                                <a href="./change_password.php" class="btn btn-primary btn-sm border-0 rounded-0">เปลี่ยนรหัสผ่าน</a>
                                <a href="./add_profile.php" class="btn btn-secondary btn-sm border-0 rounded-0 ml-2">เพิ่มรูปโปรไฟล์</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php include dirname(__FILE__) . '/layouts/script.php' ?>
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
                url: '../../api/user/profile.php',
                data: formData,
                processData: false,
                contentType: false,
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