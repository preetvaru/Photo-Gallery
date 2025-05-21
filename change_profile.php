<?php
    include('includes/connection.php');
    include('includes/header.php');
    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Check if the form is submitted
 

    // Fetch user data to display in form
    $sql = mysqli_query($conn, "SELECT * FROM registration WHERE id=" . $_SESSION['id']);
    $row = mysqli_fetch_assoc($sql);
?>

<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Change Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../../dist/css/adminlte.css" />
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Edit Profile</h3>
                        </div>
                        <div class="col-sm-6">
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-content">
                <div class="container-fluid">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card card-primary card-outline mb-4">
                                <div class="card-header">
                                    <div class="card-title">Edit Profile</div>
                                </div>
                                <form method="POST" enctype="multipart/form-data" action='update.php' style="box-shadow:none;">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="name">Name:</label>
                                            <input type="text" name="name" id="name" value="<?php echo $row['name'] ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $row['email'] ?>" readonly />
                                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="phonenumber">Contact No.</label>
                                            <input type="text" name="phonenumber" id="phonenumber" value="<?php echo $row['phonenumber'] ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="gender">Gender:</label>
                                            <select name="gender" id="gender" required>
                                                <option value="male" <?php echo ($row['gender'] == "male") ? "selected" : ""; ?>>male</option>
                                                <option value="female" <?php echo ($row['gender'] == "female") ? "selected" : ""; ?>>Female</option>
                                                <option value="other" <?php echo ($row['gender'] == "other") ? "selected" : ""; ?>>Other</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="address">Address</label>
                                            <input type="text" name="address" id="address" value="<?php echo $row['address'] ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="age">Age:</label>
                                            <input class="form-control" type="date" id="dob" name="dob" value="<?php echo $row['dob'] ?>" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="inputGroupFile02">Old Picture:</label>
                                            
                                            <?php if ($row['file']) { ?>
                                                <div class="mb-2">
                                                    <img src="<?php echo    $row['file']; ?>" alt="Profile Picture" class="img-fluid" style="max-height: 150px; max-width: 150px;">
                                                </div>
                                            <?php } else { ?>
                                                <div class="mb-2">
                                                    <p>No profile picture uploaded yet.</p>
                                                </div>
                                                <?php } ?>
                                                
                                            <label for="inputGroupFile02">Add New Profile Picture:</label>
                                            <input type="file" class="form-control" id="inputGroupFile02" name="file"/>
                                        </div><br>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                                <div class="card-footer">
                                    <!-- You can add footer content here if needed -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer class="app-footer">
            <strong>Copyright &copy; 2014-2024&nbsp;<a href="https://adminlte.io" class="text-decoration-none">- Internship</a>.</strong>
            All rights reserved.
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../../dist/js/adminlte.js"></script>
</body>
</html>



