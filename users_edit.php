<?php
include('../includes/connection.php');
include('../includes/admin_header.php');

if (isset($_GET['id']) && $_GET['id'] != '') {
    $user_id = $_GET['id'];
    $sql = mysqli_query($conn, "SELECT * FROM registration WHERE id=" . $user_id);
    $row = mysqli_fetch_assoc($sql);
} else {
    echo "Error: Invalid ID.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['userId']; // Hidden input for user ID
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phonenumber = mysqli_real_escape_string($conn, $_POST['phonenumber']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);

    $query = "UPDATE registration SET 
                name='$name', 
                phonenumber='$phonenumber', 
                gender='$gender', 
                address='$address', 
                dob='$dob'";

    // Handle profile picture upload
    if (!empty($_FILES["file"]["name"])) {
        $target_dir = "uploads/"; // Ensure this directory exists
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Create directory if not exists
        }
        $file_name = time() . "_" . basename($_FILES["file"]["name"]); // Unique file name
        $target_file = $target_dir . $file_name;
        move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

        // Add file update in query
        $query .= ", file='$target_file'";
    }

    $query .= " WHERE id='$user_id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('User updated successfully!'); window.location.href='admin_manage.php';</script>";
    } else {
        echo "<script>alert('Error updating user!'); window.location.href='user_edit.php?id=$user_id';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Edit User Profile (Admin)</h3>
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
                        <form method="POST" enctype="multipart/form-data" action="users_edit.php?id=<?php echo $user_id; ?>" style="box-shadow:none;">
                            <input type="hidden" name="userId" value="<?php echo $row['id']; ?>"> <!-- Hidden input for ID -->
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="name">Name:</label>
                                    <input type="text" class="form-control" name="name" id="name" value="<?php echo $row['name'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="email" value="<?php echo $row['email'] ?>" readonly />
                                </div>
                                <div class="mb-3">
                                    <label for="phonenumber">Contact No.</label>
                                    <input type="text" class="form-control" name="phonenumber" id="phonenumber" value="<?php echo $row['phonenumber'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="gender">Gender:</label>
                                    <select class="form-control" name="gender" id="gender" required>
                                        <option value="male" <?php echo ($row['gender'] == "male") ? "selected" : ""; ?>>Male</option>
                                        <option value="female" <?php echo ($row['gender'] == "female") ? "selected" : ""; ?>>Female</option>
                                        <option value="other" <?php echo ($row['gender'] == "other") ? "selected" : ""; ?>>Other</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="address">Address:</label>
                                    <input type="text" class="form-control" name="address" id="address" value="<?php echo $row['address'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="dob">Date of Birth:</label>
                                    <input class="form-control" type="date" id="dob" name="dob" value="<?php echo $row['dob'] ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Old Profile Picture:</label>
                                    <?php if ($row['file']) { ?>
                                        <div class="mb-2">
                                            <img src="<?php echo $row['file']; ?>" alt="Profile Picture" class="img-fluid" style="max-height: 150px; max-width: 150px;">
                                        </div>
                                    <?php } else { ?>
                                        <p>No profile picture uploaded yet.</p>
                                    <?php } ?>

                                    <label for="inputGroupFile02">Upload New Profile Picture:</label>
                                    <input type="file" class="form-control" id="inputGroupFile02" name="file"/>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary">Update</button>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

<footer class="app-footer">
    <strong>Copyright &copy; 2025&nbsp;
        <a href="#" class="text-decoration-none">Internship</a>.
    </strong>
    All rights reserved.
</footer>

</body>
</html>

<?php ob_end_flush(); ?>
