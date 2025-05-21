<?php
include('includes/connection.php');
include('includes/header.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);


// echo "SELECT * FROM users WHERE id=".$_SESSION['id']."";
$sql = mysqli_query($conn,"SELECT * FROM registration WHERE id=".$_SESSION['id']."");
$row = mysqli_fetch_assoc($sql);

?>
      <!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Profile</h3></div>
              <div class="col-sm-6">
                
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
              <?php //echo "This is session : ".$_SESSION['id']; ?> 
            <!--end::Row-->
            <div class="row">
            <?php 
                   // echo "<pre>";
                    //print_r($row);
                    ?>
                <!--begin::Col-->
                <div class="col-lg-6 col-6">
                    
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title"><b>Your Details :-</b></h3>
                            <a href="change_profile.php" style="float:right">Edit</a>
                        </div>
                        <!-- /.card-header -->
                        <!-- <div class="card-body p-0"> -->
                            <table class="table table-bordered">
                            
                                <tr class="align-middle">
                                    <th>Name : </th>
                                    <td><?php echo $row['name']; ?></td>
                                </tr>

                                <tr class="align-middle">
                                    <th>Email : </th>
                                    <td><?php echo $row['email']; ?></td>
                                </tr>

                                <tr class="align-middle">
                                    <th>Contact No : </th>
                                    <td><?php echo $row['phonenumber']; ?></td>
                                </tr>

                                <tr class="align-middle">
                                    <th>Gender : </th>
                                    <td><?php echo $row['gender']; ?></td>
                                </tr>

                                <tr class="align-middle">
                                    <th>Address : </th>
                                    <td><?php echo $row['address']; ?></td>
                                </tr>

                                <tr class="align-middle">
                                    <th>Image : </th>
                                    <td><?php echo $row['file']; ?></td>
                                </tr>

                                <tr class="align-middle">
                                    <th>Date Of Birth : </th>
                                    <td><?php echo $row['dob']; ?></td>
                                </tr>

                            </table>
                        <!-- </div> -->
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>  
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
        
      </main>
      <!--end::App Main-->
      <!--begin::Footer-->
      <footer class="app-footer">
        
        <!--begin::Copyright-->
        <strong>
          Copyright &copy; 2025&nbsp;
          <a href="#" class="text-decoration-none"> - Internship</a>.
        </strong>
        All rights reserved.
        <!--end::Copyright-->
      </footer>
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
      integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
      crossorigin="anonymous"
    ></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="./js/adminlte.js"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });
    </script>
    <!--end::OverlayScrollbars Configure-->
    <!-- OPTIONAL SCRIPTS -->
    <!-- sortablejs -->
    <script
      src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"
      integrity="sha256-ipiJrswvAR4VAx/th+6zWsdeYmVae0iJuiR+6OqHJHQ="
      crossorigin="anonymous"
    ></script>
    <!-- sortablejs -->
    <script>
      const connectedSortables = document.querySelectorAll('.connectedSortable');
      connectedSortables.forEach((connectedSortable) => {
        let sortable = new Sortable(connectedSortable, {
          group: 'shared',
          handle: '.card-header',
        });
      });

      const cardHeaders = document.querySelectorAll('.connectedSortable .card-header');
      cardHeaders.forEach((cardHeader) => {
        cardHeader.style.cursor = 'move';
      });
    </script>
    <!-- apexcharts -->
    <script
      src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
      integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8="
      crossorigin="anonymous"
    ></script>
    <!-- ChartJS -->

    <!--end::Script-->
  </body>
  <!--end::Body-->
</html>
