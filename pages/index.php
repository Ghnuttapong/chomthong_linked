<?php
// check session
include dirname(__FILE__) . '/layouts/isadmin.php';
include '../api/db.php';
$conn = new db();
$new_users = $conn->select_all('users WHERE enabled = 0', ['COUNT(*) as count']);
$cur_student = $conn->select_all('users WHERE enabled = 1 AND role = 0', ['COUNT(*) as count']);
$cur_agency = $conn->select_all('users WHERE enabled = 1 AND role = 1', ['COUNT(*) as count']);
$link_students = $conn->select_all('students WHERE link IS NOT NULL', ['COUNT(*) as count']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include dirname(__FILE__) . '/layouts/css.php'; ?>
  <title><?= $GLOBALS['site_name'] ?> | หน้าแรก</title>
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
              <h1 class="m-0">รายงาน</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">หน้าแรก</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= $new_users[0]['count'] ?></h3>
                <p>สมาชิกใหม่</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-plus"></i>
              </div>
              <a href="./user_approve.php" class="small-box-footer">ดูเพิ่มเติม <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?= $cur_student[0]['count'] ?></h3>
                <p>นักเรียนทั้งหมด</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="./site.php" class="small-box-footer">ดูเพิ่มเติม <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $cur_agency[0]['count'] ?></h3>
                <p>หน่วยงานทั้งหมด</p>
              </div>
              <div class="icon">
                <i class="fas fa-building"></i>
              </div>
              <a href="./agency_view.php" class="small-box-footer">ดูเพิ่มเติม <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= $link_students[0]['count'] ?></h3>
                <p>ลิงค์นักเรียน</p>
              </div>
              <div class="icon">
                <i class="fas fa-link"></i>
              </div>
              <a href="./site.php?keyword='linked'" class="small-box-footer">ดูเพิ่มเติม <i class="fas fa-arrow-circle-right"></i></a>
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