<?php
// Ensure session_start() is called before any output (already handled by includes)
include('../includes/connection.php'); // Correct path to the connection file
include('../includes/admin_header.php');

// Fetch the total number of members based on id from the database
$query = "SELECT COUNT(id) AS total_members FROM registration";  // Total members count
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $total_members = $row['total_members']; // Store the total members count in a variable
} else {
    // Handle error if query fails
    echo "Error: " . mysqli_error($conn);
}

// Fetch the total number of active members based on the 'status' column from the database
$active_query = "SELECT COUNT(id) AS active_members FROM registration WHERE status = 1";  // Count active members where status = 1
$active_result = mysqli_query($conn, $active_query);

if ($active_result) {
    $active_row = mysqli_fetch_assoc($active_result);
    $total_active_members = $active_row['active_members']; // Store active members count
} else {
    // Handle error if query fails
    echo "Error: " . mysqli_error($conn);
}

// Fetch the total number of inactive members based on the 'status' column from the database
$inactive_query = "SELECT COUNT(id) AS inactive_members FROM registration WHERE status = 'inactive'";  // Count inactive members
$inactive_result = mysqli_query($conn, $inactive_query);

if ($inactive_result) {
    $inactive_row = mysqli_fetch_assoc($inactive_result);
    $total_inactive_members = $inactive_row['inactive_members']; // Store inactive members count
} else {
    // Handle error if query fails
    echo "Error: " . mysqli_error($conn);
}

// Fetch the total number of recent active members who created accounts in the last 5 days
$recent_query = "SELECT COUNT(id) AS recent_members 
                 FROM registration 
                 WHERE status = 1 
                   AND create_at >= NOW() - INTERVAL 5 DAY";

$recent_result = mysqli_query($conn, $recent_query);

if ($recent_result) {
    $recent_row = mysqli_fetch_assoc($recent_result);
    $total_recent_members = $recent_row['recent_members']; // Store recent active members count
} else {
    // Handle error if query fails
    echo "Error: " . mysqli_error($conn);
}

?>



<!--begin::App Main-->
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Dashboard</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
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
            <div class="row">
                <!--begin::Col-->
                <div class="col-lg-3 col-6">
                    <!--begin::Small Box Widget 1-->
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <h3><?php echo $total_members; ?></h3>
                            <p>TOTAL MEMBERS</p>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z"></path>
                        </svg>
                    </div>
                    <!--end::Small Box Widget 1-->
                </div>
                <!--end::Col-->
                
                <div class="col-lg-3 col-6">
                    <!--begin::Small Box Widget 2 (Active Members)-->
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <h3><?php echo $total_active_members; ?><sup class="fs-5"></sup></h3>
                            <p>TOTAL ACTIVE MEMBERS</p>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z"></path>
                        </svg>
                    </div>
                    <!--end::Small Box Widget 2-->
                </div>
                <!--end::Col-->
                
                <div class="col-lg-3 col-6">
                    <!--begin::Small Box Widget 3-->
                    <div class="small-box text-bg-warning">
                        <div class="inner">
                            <h3><?php echo $total_inactive_members; ?></h3>
                            <p>TOTAL INACTIVE MEMBERS</p>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z"></path>
                        </svg>
                    </div>
                    <!--end::Small Box Widget 3-->
                </div>
                <!--end::Col-->
                
                <div class="col-lg-3 col-6">
                    <!--begin::Small Box Widget 4-->
                    <div class="small-box text-bg-danger">
                        <div class="inner">
                            <h3><?php echo $total_recent_members; ?></h3>
                            <p>RECENT NEW MEMBERS</p>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z"></path>
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z"></path>
                        </svg>
                    </div>
                    <!--end::Small Box Widget 4-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
</main>
<!--end::App Main-->
<!--begin::Footer-->
<footer class="app-footer">
    <strong>Copyright &copy; 2025&nbsp;<a href="#" class="text-decoration-none"> - Internship</a>.</strong> All rights reserved.
</footer>
<!--end::Footer-->
</div>
<!--end::App Wrapper-->
