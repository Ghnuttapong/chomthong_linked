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
    <title><?= $GLOBALS['site_name'] ?> | หน้าแรก</title>
</head>

<body>
    <?php include dirname(__FILE__) . '/layouts/navbar.php' ?>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-danger">ส่งลิงค์นักเรียน</div>
                    <div class="card-body">
                        <form method="post" id="form-link">
                            <div class="input-group mb-3">
                                <input type="text" name="link" value="<?= $data['link'] == null ? '' : $data['link'] ?>" id="link" placeholder="https://www.example.com" class="form-control rounded-0">
                                <span class="input-group-append">
                                    <input type="submit" class="btn btn-secondary btn-flat" value="ส่ง">
                                </span>
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
        $('#form-link').submit(e => {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '../../api/send_link.php',
                data: { link: $('#link').val() },
                dataType: 'JSON',
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
        })
    </script>
</body>

</html>