<?php


function active_nav($page_name)
{
    if ($_SERVER['PHP_SELF'] == '/' . $GLOBALS['project_name'] . '/pages/' . $page_name) {
        return "active";
    }
}

function active_menu_open(array $page_name)
{
    $active = 'menu-close';
    foreach ($page_name as $name) {
        if ($_SERVER['PHP_SELF'] == '/' . $GLOBALS['project_name'] . '/pages/' . $name) {
            $active = 'menu-open';
        }
    }
    return $active;
}

?>
<aside class="main-sidebar sidebar-light-danger elevation-4">
    <a href="./" class="brand-link">
        <img src="../assets/brand/icon.png" alt="<?= $GLOBALS['project_name'] ?>" class="brand-image img-circle" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= $site_name ?></span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">

        <div class="form-inline mt-3 pb-3 ">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">เมนู</li>
                <?php if ($_SESSION['role'] == 2) { ?>
                    <li class="nav-item">
                        <a href="./index.html" class="nav-link <?= active_nav('index.php') ?>">
                            <i class="nav-icon fas fa-tachometer-alt" aria-hidden="true"></i>
                            <p>
                                รายงาน
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./user_approve.html" class="nav-link <?= active_nav('user_approve.php') ?>">
                            <i class="nav-icon fas fa-user-plus"></i>
                            <p>
                                รายการสมาชิกใหม่
                                <span class="right badge badge-danger">New</span>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./agency_view.html" class="nav-link <?= active_nav('agency_view.php') ?>">
                            <i class="nav-icon fas fa-briefcase"></i>
                            <p>
                                รายชื่อหน่วยงาน
                            </p>
                        </a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a href="./site.html" class="nav-link <?= active_nav('site.php') ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            รายชื่อนักเรียน
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>