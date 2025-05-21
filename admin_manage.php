
<?php


// // Check if the admin is logged in
// if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
//     header("Location: admin_login.php"); // Redirect to login if not logged in
//     exit();
// }

// Start output buffering
ob_start();
include('../includes/admin_header.php');

// Database connection
$server = "localhost"; 
$username = "root"; 
$password = ""; 
$database_name = "internship_db"; 
$conn = mysqli_connect($server, $username, $password, $database_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// The rest of your existing code...
?>
<?php
// Handle User Deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $sql = "DELETE FROM registration WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $stmt->close();

        header("Location: admin_manage.php?message=User deleted successfully");
        exit();
    } else {
        header("Location: admin_manage.php?error=" . $conn->error);
        exit();
    }
}

// Handle Making Users Inactive
if (isset($_POST['make_inactive'])) {
    if (!empty($_POST['user_ids'])) {
        foreach ($_POST['user_ids'] as $id) {
            $sql = "UPDATE registration SET status = 0 WHERE id = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("i", $id);
                $stmt->execute();
            }
        }
        header("Location: admin_manage.php?message=Selected users marked as inactive");
        exit();
    } else {
        header("Location: admin_manage.php?error=No users selected");
        exit();
    }
}

// Handle Making Users Active
if (isset($_POST['make_active'])) {
    if (!empty($_POST['user_ids'])) {
        foreach ($_POST['user_ids'] as $id) {
            $sql = "UPDATE registration SET status = 1 WHERE id = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("i", $id);
                $stmt->execute();
            }
        }
        header("Location: admin_manage.php?message=Selected users marked as active");
        exit();
    } else {
        header("Location: admin_manage.php?error=No users selected");
        exit();
    }
}

// Handle Delete button
if (isset($_POST['make_delete'])) {
    if (!empty($_POST['user_ids'])) {
        foreach ($_POST['user_ids'] as $id) {
            $sql = "DELETE FROM registration WHERE id = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("i", $id);
                $stmt->execute();
            }
        }
        header("Location: admin_manage.php?message=Selected users Deleted Successfuly!");
        exit();
    } else {
        header("Location: admin_manage.php?error=No users selected");
        exit();
    }
}

// Fetch users from the database
$sql = "SELECT id, name, email, phonenumber, dob, status FROM registration";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Members</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<form id="userForm" method="POST" action="admin_manage.php">
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <h3 class="mb-0">Manage Members</h3>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card-body">
                <?php
                if (isset($_GET['message'])) {
                    echo "<div class='alert alert-success'>" . $_GET['message'] . "</div>";
                } elseif (isset($_GET['error'])) {
                    echo "<div class='alert alert-danger'>" . $_GET['error'] . "</div>";
                }
                ?>
 
            
                
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                        <button type="submit" name="make_active" class="btn btn-success">Make Active</button> 
                        <button type="submit" name="make_inactive" class="btn btn-warning">Make Inactive</button>
                        <button type="submit" name="make_delete" class="btn btn-danger">Delete</button>

                        <!-- <a href='?delete_id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a> -->
                        <!-- <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete1</button> -->
                        
                        
                        
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</a>   
                        </div>
                    </div>            
                
                    <table class="table table-bordered table-striped"> 
                        <thead> 
                            <tr> 
                                <th>Sr.No</th>
                                <th>Name</th> 
                                <th>Email</th> 
                                <th>Phone</th> 
                                <th>DOB</th>
                                <th>Status</th>
                                <th>Action</th> 
                                <th>Select</th>
                            </tr> 
                        </thead> 
                        <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            $count = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $count . "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . $row['phonenumber'] . "</td>";
                                echo "<td>" . $row['dob'] . "</td>";

                                $status_text = ($row['status'] == 1) ? 'Active' : 'Inactive';
                                $status_class = ($row['status'] == 1) ? 'text-success' : 'text-danger';
                                echo "<td class='$status_class'>$status_text</td>";

                                // <a href="#" class="btn btn-success btn-sm " data-bs-toggle="modal" data-bs-target="#editModal" "
                                echo "<td>
                                <a href='users_edit.php?id=" . $row['id'] . "' class='btn btn-success btn-sm' >Edit</a> 
                                        <a href='?delete_id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                      </td>";

                                echo "<td><input type='checkbox' name='user_ids[]' value='" . $row['id'] . "'></td>";
                                echo "</tr>";
                                $count++;
                            }
                        } else {
                            echo "<tr><td colspan='8'>No users found.</td></tr>";
                        }
                        ?>
                        </tbody> 
                    </table>
                </form>
            </div>
        </div>
    </div>
</main>

<!-- Add User Modal -->
<!-- Bootstrap Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="dob" name="dob" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <!-- Button Section -->
                        <div class="col-md-12 mb-3">
                        <button type="submit" class="btn btn-primary">Add User</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        setTimeout(function() {
            $(".alert-success").fadeOut("slow");
        }, 2000); // 2000ms = 2 seconds

    });

document.getElementById('addUserForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var formData = new FormData(this);

    fetch('add_user.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        if (data.includes("successfully")) {
            window.location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
});
</script>

<style>
    input[type="checkbox"] {
        width: 20px;
        height: 20px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<!-- Footer -->
<footer class="app-footer">
    <strong>
        Copyright &copy; 2025&nbsp;
        <a href="#" class="text-decoration-none">Internship</a>.
    </strong>
    All rights reserved.
</footer>
</body>
</html>

<?php ob_end_flush(); ?>