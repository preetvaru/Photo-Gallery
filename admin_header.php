<?php
  include('connection.php');
  
  session_start();
  
  if(!isset($_SESSION['adminid'])){
   
    header("Location: admin_index.php");
    exit;
  }

  error_reporting(E_ALL ^ E_NOTICE); 
  $server ="localhost"; 
  $username = "root"; 
  $password= ""; 
  $database_name = "internship_db"; 

  $conn =mysqli_connect($server, $username, $password, $database_name); 
  $qry = mysqli_query($conn,"SELECT * FROM admin_login WHERE id=".$_SESSION['adminid']);
  $row = mysqli_fetch_assoc($qry);

?>
<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Admin | Dashboard</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"
    />
    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
    />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
      integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="../css/adminlte.css" />
    <!--end::Required Plugin(AdminLTE)-->
    <!-- apexcharts -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
      integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
      crossorigin="anonymous"
    />
    <!-- jsvectormap -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
      integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4="
      crossorigin="anonymous"
    />


    <style>
    /* body {
      font-family: Arial, Helvetica, sans-serif;
      background-color: #f5f5f5;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    } */

    .form-container {
      margin: 0 20px;
    }

    form {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
      width: 100%;
      box-sizing: border-box;
      margin-top: 20px;
      display: flex;
    }

    .column-left {
      flex: 1;
      padding-right: 20px;
    }

    .column-right {
      flex: 1;
      padding-left: 20px;
    }

    label {
      display: block;
      margin-bottom: 8px;
      color: #333;
      font-weight: bold;
    }

    input, select {
      width: 100%;
      padding: 10px;
      margin-bottom: 16px;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 16px;
    }

    button {
      background-color: #4caf50;
      color: #fff;
      padding: 12px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
    }

    button:hover {
      background-color: #45a049;
    }

    img {
      max-width: 100%;
      height: auto;
      margin-bottom: 16px;
      border-radius: 4px;
    }
  </style>


  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      <nav class="app-header navbar navbar-expand bg-body">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Start Navbar Links-->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>
            
          </ul>
          <!--end::Start Navbar Links-->
          <!--begin::End Navbar Links-->
          <ul class="navbar-nav ms-auto">
            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img
                  src="<?php echo "../".$row['file']; ?>"
                  class="user-image rounded-circle shadow"                
                  alt="User Image"
                />
                <span class="d-none d-md-inline"><?php echo $row['name']; ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <!--begin::User Image-->
                <li class="user-header text-bg-primary">
                  <img
                    src="<?php echo "../".$row['file']; ?>"
                    class="rounded-circle shadow"
                    alt="User Image"
                  />
                  <p>
                  Email : <?php echo $row['username']; ?><br>
                  Phone : <?php echo $row['phonenumber']; ?>
                    <!-- <small>Member since Jan. 2025</small> -->
                  </p>
                </li>
                <!--end::User Image-->
                
                <!--begin::Menu Footer-->
                <li class="user-footer">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                  <a href="admin_logout.php" class="btn btn-default btn-flat float-end">Sign out</a>
                </li>
                <!--end::Menu Footer-->
              </ul>
            </li>
            <!--end::User Menu Dropdown-->
          </ul>
          <!--end::End Navbar Links-->
        </div>
        <!--end::Container-->
      </nav>
      <!--end::Header-->
      <!--begin::Sidebar-->
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="./index.html" class="brand-link">
            <!--begin::Brand Image-->
            <img
              src="/internship/intern.png"
              alt="AdminLTE Logo"
              class="brand-image opacity-75 shadow"
            />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">Welcome Admin - <br> <?php echo $row['name']; ?></span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="menu"
              data-accordion="false"
            >
              <li class="nav-item">
                <a href="admin_dashboard.php" class="nav-link">
                    <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="admin_gallery.php" class="nav-link">
                  <i class="nav-icon bi bi-image"></i>
                    <p>Gallery</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="admin_manage.php" class="nav-link">
                    <i class="nav-icon bi bi-table"></i>
                        <p>Manage Members</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="admin_change_profile.php" class="nav-link">
                    <i class="nav-icon bi bi-person"></i>
                        <p>Profile</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="admin_logout.php" class="nav-link">
                    <i class="nav-icon bi bi-box-arrow-in-right"></i>
                        <p>Log Out</p>
                </a>
              </li>
              
            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->