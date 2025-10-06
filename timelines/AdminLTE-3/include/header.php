<?php
session_start(); // Ensure session is started on every page

if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true || $_SESSION['role'] !== 'admin' ) {
    header('Location: ../login.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin TimeLines</title>
<?php        ?>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../Font-Awesome-6.4.0/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css?v=1">
  <!-- dark-mode .content-wrapper{background-color:#121416;color:#fff} it is a page color changes -->
    <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!--table css -->
  <link rel="stylesheet" href="dist/css/tableformat.css?v=<?php echo time(); ?>">
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div> -->

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="dashbord.php" class="nav-link">Home</a>
      </li>
      
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <!-- Or as a link -->
        <a href="../index.php" class="nav-link">
          <i class="fas fa-arrow-left"></i> Back To Website
        </a>

     </li>
      <!-- Navbar Search -->
     
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
  

    <!-- Sidebar -->
    <div class="sidebar">
     
      <div class="user-panel  pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo ucwords(strtolower($_SESSION['user_name'])); ?>
        </a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="dashbord.php" class="nav-link <?= ($_SERVER['PHP_SELF'] == '/timelines/AdminLTE-3/dashbord.php') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                
              </p>
            </a>
           
          </li>

            <li class="nav-header">Categories</li>
           <li class="nav-item ">
            <a href="categories.php" class="nav-link <?= ($_SERVER['PHP_SELF'] == '/timelines/AdminLTE-3/categories.php') ? 'active' : '' ?>">
             <i class="nav-icon fa-solid fa-layer-group"></i>
              <p>
               Categories
              </p>
            </a>
           
          </li>
           <li class="nav-item <?= (
              $_SERVER['PHP_SELF'] == '/timelines/AdminLTE-3/indexpage.php' 
              || $_SERVER['PHP_SELF'] == '/timelines/AdminLTE-3/productpage.php'
              || $_SERVER['PHP_SELF'] == '/timelines/AdminLTE-3/trending.php') ? 'menu-open' : '' ?>">

            <a href="#" class="nav-link <?= (
              $_SERVER['PHP_SELF'] == '/timelines/AdminLTE-3/indexpage.php' 
              || $_SERVER['PHP_SELF'] == '/timelines/AdminLTE-3/productpage.php'
              || $_SERVER['PHP_SELF'] == '/timelines/AdminLTE-3/trending.php') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Tables
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="indexpage.php" class="nav-link 
                <?= ($_SERVER['PHP_SELF'] == '/timelines/AdminLTE-3/indexpage.php') ? 'active' : '' ?>">

                  <i class="<?= ($_SERVER['PHP_SELF'] == '/timelines/AdminLTE-3/indexpage.php') 
              ? 'fas fa-dot-circle nav-icon' 
              : 'far fa-circle nav-icon' ?>"></i>
                  <p>Crousel Table</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="productpage.php" class="nav-link
                <?= ($_SERVER['PHP_SELF'] == '/timelines/AdminLTE-3/productpage.php') ? 'active' : '' ?>">
                
                  <i class="<?= ($_SERVER['PHP_SELF'] == '/timelines/AdminLTE-3/productpage.php') 
              ? 'fas fa-dot-circle nav-icon' 
              : 'far fa-circle nav-icon' ?>"></i>
                  <p>Product Table</p>
                </a>
              </li>
             <li class="nav-item">
                <a href="trending.php" class="nav-link
                <?= ($_SERVER['PHP_SELF'] == '/timelines/AdminLTE-3/trending.php') ? 'active' : '' ?>">
                
                  <i class="<?= ($_SERVER['PHP_SELF'] == '/timelines/AdminLTE-3/trending.php') 
              ? 'fas fa-dot-circle nav-icon' 
              : 'far fa-circle nav-icon' ?>"></i>
                  <p>Trending Table</p>
                        
                </a>
              </li>
            </ul>
          </li>
         <li class="nav-item <?= (
              $_SERVER['PHP_SELF'] == '/timelines/AdminLTE-3/customer_table.php' 
              || $_SERVER['PHP_SELF'] == '/timelines/AdminLTE-3/admin_table.php') ? 'menu-open' : '' ?>">
          
            <a href="#" class="nav-link <?= (
                $_SERVER['PHP_SELF'] == '/timelines/AdminLTE-3/customer_table.php' 
                || $_SERVER['PHP_SELF'] == '/timelines/AdminLTE-3/admin_table.php') ? 'active' : '' ?>">
              <i class="nav-icon fa-solid fa-user"></i>
              <p>
                Users
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
          
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="admin_table.php" class="nav-link <?= ($_SERVER['PHP_SELF'] == '/timelines/AdminLTE-3/admin_table.php') ? 'active' : '' ?>">
                  <i class="<?= ($_SERVER['PHP_SELF'] == '/timelines/AdminLTE-3/admin_table.php') 
              ? 'fas fa-dot-circle nav-icon' 
              : 'far fa-circle nav-icon' ?>"></i>

                  <p>Admin</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="customer_table.php" class="nav-link <?= ($_SERVER['PHP_SELF'] == '/timelines/AdminLTE-3/customer_table.php') ? 'active' : '' ?>">
                  <i class="<?= ($_SERVER['PHP_SELF'] == '/timelines/AdminLTE-3/customer_table.php') 
                  ? 'fas fa-dot-circle nav-icon' 
                 : 'far fa-circle nav-icon' ?>"></i>
                  <p>Customer</p>
                </a>
              </li>
            </ul>
          </li>

           <li class="nav-item">
            <a href="order.php" class="nav-link <?= ($_SERVER['PHP_SELF'] == '/timelines/AdminLTE-3/order.php') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-truck"></i>
              <p>
                Order
              </p>
            </a>
          </li>
            <li class="nav-item">
            <a href="mailbox.php" class="nav-link <?= ($_SERVER['PHP_SELF'] == '/timelines/AdminLTE-3/mailbox.php') ? 'active' : '' ?>">
              <i class="nav-icon far fa-envelope"></i>
              <p>
                Mailbox
              
              </p>
            </a>
</li>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

 
    <!-- /.content-header -->
