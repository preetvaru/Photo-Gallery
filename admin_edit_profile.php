<?php include('../includes/connection.php'); ?>
<?php include('../includes/admin_header.php'); ?>

<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Check if the form is submitted
 

    // Fetch user data to display in form
    $sql = mysqli_query($conn, "SELECT * FROM admin_login WHERE id=1");
    $row = mysqli_fetch_assoc($sql);
?>

<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $phonenumber = trim($_POST['phonenumber']);
    $gender = trim($_POST['gender']);
    $admin_id = 1; // Always updating id=1

    // Handle profile picture upload
    $uploadDir = "../uploads/";
    $filePath = "";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Ensure the folder exists
    }

    if (!empty($_FILES['file']['name'])) {
        $fileName = time() . "_" . basename($_FILES["file"]["name"]); // Rename to avoid overwriting
        $filePath = $uploadDir . $fileName;
        $dbFilePath = "uploads/" . $fileName; // Store relative path in DB
        $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileType, $allowedTypes)) {
            if (!move_uploaded_file($_FILES["file"]["tmp_name"], $filePath)) {
                die("Error moving file: " . $_FILES["file"]["error"]);
            }
        } else {
            die("Invalid file format. Only JPG, JPEG, PNG, and GIF are allowed.");
        }
    }

    // Prepare the update query
    if (!empty($filePath)) {
        // Update profile with new image
        $sql = "UPDATE admin_login SET name=?, phonenumber=?, gender=?, file=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $name, $phonenumber, $gender, $dbFilePath, $admin_id);
    } else {
        // Update profile without changing image
        $sql = "UPDATE admin_login SET name=?, phonenumber=?, gender=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $phonenumber, $gender, $admin_id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='admin_change_profile.php';</script>";
    } else {
        echo "Error updating profile: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
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
                            <h3 class="mb-0">Change Profile</h3>
                        </div>
                        <div class="col-sm-6"></div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card card-primary card-outline mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Update Your Profile</h5>
                                </div>

                                <form action='admin_edit_profile.php' method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        
                                        <!-- Full Name -->
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Full Name</label>
                                            <input type="text" class="form-control" name="name" id="name" value="<?php echo $row['name'] ?>"  required>
                                        </div>

                                        <!-- Email Address -->
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" class="form-control" name="email" id="email" value="<?php echo $row['username'] ?>" readonly>
                                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                                        </div>

                                        <!-- Contact no. -->
                                        <div class="mb-3">
                                            <label for="age" class="form-label">Contact no.</label>
                                            <input type="number" class="form-control" name="phonenumber" id="phonenumber" value="<?php echo $row['phonenumber'] ?>" required>
                                        </div>

                                        <!-- Gender Selection -->
                                        <div class="mb-3">
                                            <label for="gender" class="form-label">Gender</label>
                                            <select class="form-control" name="gender" id="gender" required>
                                                <option value="male" <?php echo ($row['gender'] == "male") ? "selected" : ""; ?>>male</option>
                                                <option value="female" <?php echo ($row['gender'] == "female") ? "selected" : ""; ?>>Female</option>
                                                <option value="other" <?php echo ($row['gender'] == "other") ? "selected" : ""; ?>>Other</option>
                                            </select>
                                        </div>

                                        <!-- Profile Picture Upload -->
                                        <div class="form-group mb-3">
                                            <label for="inputGroupFile02">Old Picture:</label>
                                            
                                            <?php if ($row['file']) { ?>
                                                <div class="mb-2">
                                                    <img src="<?php echo "../".$row['file']; ?>" alt="Profile Picture" class="img-fluid" style="max-height: 150px; max-width: 150px;">
                                                </div>
                                            <?php } else { ?>
                                                <div class="mb-2">
                                                    <p>No profile picture uploaded yet.</p>
                                                </div>
                                                <?php } ?>
                                                
                                            <label for="inputGroupFile02">Add New Profile Picture:</label>
                                            <input type="file" class="form-control" id="inputGroupFile02" name="file"/>
                                        </div><br>

                                        <!-- Terms and Conditions -->
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" name="terms" id="terms" required>
                                            <label class="form-check-label" for="terms">I confirm my details are correct</label>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Update Profile</button>
                                        </div>
                                    </div>
                                </form>

                                <div class="card-footer text-center">
                                    <small>Make sure your details are accurate before submission.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="app-footer text-center py-3">
            <strong>Copyright &copy; 2014-2024 
                <a href="https://adminlte.io" class="text-decoration-none">Internship Management</a>.
            </strong> All rights reserved.
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../../dist/js/adminlte.js"></script>

</body>
</html>



