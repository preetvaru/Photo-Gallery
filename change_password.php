<?php
include("includes/connection.php");
include('includes/header.php');
?>
<?php
// Initialize error and success variables
$err = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the current user ID from the session
    $userId = $_SESSION['id']; 

    // Check if old password, new password, and confirm password are set
    if (isset($_POST['old_password'], $_POST['new_password'], $_POST['confirm_password'])) {
        $oldPassword = $_POST['old_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        // Check if new password and confirm password match
        if ($newPassword !== $confirmPassword) {
            $err = "New password and confirm password do not match.";
        } else {
            // Fetch user data from the database based on the session user ID
            $query = mysqli_query($conn, "SELECT * FROM registration WHERE id = '" . mysqli_real_escape_string($conn, $userId) . "'");
            $user = mysqli_fetch_assoc($query);

            if ($user) {
                // Verify if the old password matches
                if (password_verify($oldPassword, $user['password'])) {
                    // Hash the new password before updating
                    $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                    // Update the password in the database
                    $updateQuery = "UPDATE registration SET password = '" . mysqli_real_escape_string($conn, $hashedNewPassword) . "' WHERE id = '" . mysqli_real_escape_string($conn, $userId) . "'";
                    $updateResult = mysqli_query($conn, $updateQuery);

                    if ($updateResult) {
                        $success = "Password updated successfully!";
                    } else {
                        $err = "Error updating the password. Please try again.";
                    }
                } else {
                    $err = "Old password is incorrect.";
                }
            } else {
                $err = "User not found.";
            }
        }
    } else {
        $err = "Please fill in all required fields.";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Change Password</title>
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
                            <h3 class="mb-0">Change Password</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-content">
                <div class="container-fluid">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card card-primary card-outline mb-4">
                                <form method="POST" style="box-shadow:none">
                                    <div class="card-body">
                                        <!-- Display error or success message -->
                                        <?php if ($err): ?>
                                            <div class="alert alert-danger"><?php echo $err; ?></div>
                                        <?php elseif ($success): ?>
                                            <div class="alert alert-success"><?php echo $success; ?></div>
                                        <?php endif; ?>

                                        <div class="mb-3">
                                            <label for="oldPassword" class="form-label">Old Password</label>
                                            <input type="password" class="form-control" id="oldPassword" name="old_password" required />
                                        </div>
                                        <div class="mb-3">
                                            <label for="newPassword" class="form-label">New Password</label>
                                            <input type="password" class="form-control" id="newPassword" name="new_password" required />
                                        </div>
                                        <div class="mb-3">
                                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required />
                                        </div>
                                        <br>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
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
