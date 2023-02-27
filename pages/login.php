<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href=".//" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <?php include dirname(__FILE__) . '/layouts/css.php'; ?>
  <title><?= $site_name ?> | เข้าสู่ระบบ</title>
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="d-flex align-items-center justify-content-center my-4 ">
      <img src="../assets/brand/icon.png" alt=<?= $project_name ?> class="brand-image img-circle" width="80" height="80" style="opacity: .8">
      <h4 class="ml-2"> วิทยาลัยการอาชีพจอมทอง </h4>
    </div>
    <!-- /.login-logo -->

    <form id="form-login" method="post">
      <div class="card">
        <div class="card-body login-card-body">
          <div class="input-group mb-3">
            <input type="text" name="username" require class="form-control" placeholder="ชื่อผู้ใช้" id="username">
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
          <div class="d-flex gap-2 align-items-center">
            <button type="submit" value="Sign In" class="btn btn-primary w-50 btn-block">เข้าสู่ระบบ</button>
            <div class="ml-3 text-center w-full">
              <a href="register.html" class="text-secondary">สมัครสมาชิก</a>
            </div>
          </div>
        </div>
        <!-- /.login-card-body -->
      </div>
    </form>
  </div>
  <!-- /.login-box -->


  <?php include dirname(__FILE__) . '/layouts/script.php'; ?>
  <script>
    $('#form-login').on('submit', function(e) {
      e.preventDefault()
      $.ajax({
        type: 'POST',
        data: $(this).serialize(),
        url: '../api/auth/login.php',
        dataType: 'JSON',
        success: function(res) {
          Toast.fire({
            icon: 'success',
            title: res.msg
          })
          setInterval(function() {
              window.location.href = res.url
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