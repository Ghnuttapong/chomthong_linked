<?php include './data/index.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href=".//" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <?php include dirname(__FILE__) . '/layouts/css.php'; ?>
    <title><?= $site_name ?> | สมัครสมาชิก</title>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="d-flex align-items-center justify-content-center my-4 ">
            <img src="../assets/brand/icon.png" alt=<?= $project_name ?> class="brand-image img-circle" width="80" height="80" style="opacity: .8">
            <h4 class="ml-2"> วิทยาลัยการอาชีพจอมทอง </h4>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body">
                <form method="post" id="form-register">
                    <div class="input-group mb-3">
                        <input type="text" name="username" require class="form-control" placeholder="รหัสนักศึกษา" id="username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="รหัสผ่าน" require id="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="type" value="student">
                    <select name="prefix" class="form-control" id="prefix">
                        <option value="นาย">นาย</option>
                        <option value="นางสาว">นางสาว</option>
                    </select>
                    <div class="row mt-3">
                        <div class="col-md-6 mb-3">
                            <input type="text" name="firstname" class="form-control" placeholder="ชื่อ" require id="firstname">
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" name="lastname" class="form-control" placeholder="นามสกุล" require id="lastname">
                        </div>
                    </div>

                    <select name="degree" class="form-control mb-3" id="degree">
                        <option selected disabled value="">ระดับชั้น</option>
                        <option value="ปวช.">ปวช.</option>
                        <option value="ปวส.">ปวส.</option>
                    </select>

                    <select name="department" class="form-control mb-3" id="department">
                        <option selected disabled value="">แผนกวิชา</option>
                        <?php foreach ($department_arr as $key => $val) { ?>
                            <option value="<?= $val ?>"><?= $val ?></option>
                        <?php } ?>
                    </select>

                    <div class="mb-3">
                        <input class="form-control" type="date" name="birthday" id="birthday">
                    </div>
                    <div class="d-flex align-items-center">
                        <button type="submit" value="Sign In" class="btn btn-primary w-50 btn-block">สมัครสมาชิก</button>
                        <div class="ml-4 text-center w-full">
                            <a href="login.html" class="text-secondary">มีบัญชีแล้ว?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include dirname(__FILE__) . '/layouts/script.php'; ?>

    <script>
        $('#form-register').submit(function(e) {
            e.preventDefault()
            $.ajax({
                type: 'POST',
                data: $(this).serialize(),
                url: '../api/auth/register.php',
                dataType: 'JSON',
                success: function(res) {
                    Toast.fire({
                        icon: 'success',
                        title: res.msg
                    })
                    setInterval(function() {
                        window.location.href = 'login.html'
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