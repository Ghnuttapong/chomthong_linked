  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <div class="d-flex align-items-center">
            <p><?= $_SESSION['fullname'] ?></p>
            <h3><i class="ml-2 fas fa-user-circle"></i></h3>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="./profile.php" class="dropdown-item">
            <i class="fas fa-id-card-alt mr-2"></i> เปลี่ยนรหัสผ่าน
          </a>
          <div class="dropdown-divider"></div>
          <a href="./logout.php" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> ออกจากระบบ
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->