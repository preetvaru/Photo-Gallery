<?php
include("includes/connection.php");
include('includes/header.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get user and folder IDs
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
$folder_id = isset($_GET['folder_id']) ? intval($_GET['folder_id']) : 0;

// Handle image upload
if (isset($_POST['upload'])) {
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    $upload_folder = "uploads/";

    if (!is_dir($upload_folder)) {
        mkdir($upload_folder, 0755, true);
    }

    $target_path = $upload_folder . basename($image);

    if (move_uploaded_file($tmp, $target_path)) {
        $insert = mysqli_query($conn, "INSERT INTO user_photos (user_id, folder_id, photo_name) VALUES ($user_id, $folder_id, '$target_path')");
        $message = $insert ? "Image uploaded successfully!" : "Database error: " . mysqli_error($conn);
    } else {
        $message = "Failed to upload image.";
    }
}

// Handle image deletion
if (isset($_POST['delete_selected']) && !empty($_POST['selected_photos'])) {
    $selected_photos = $_POST['selected_photos'];

    foreach ($selected_photos as $photo_id) {
        $res = mysqli_query($conn, "SELECT photo_name FROM user_photos WHERE id = $photo_id");
        $row = mysqli_fetch_assoc($res);
        if ($row && file_exists($row['photo_name'])) {
            unlink($row['photo_name']); // Delete from folder
        }
        mysqli_query($conn, "DELETE FROM user_photos WHERE id = $photo_id"); // Delete from DB
    }

    $message = "Selected photos deleted successfully!";
}

// Fetch images for gallery
$query = mysqli_query($conn, "SELECT * FROM user_photos WHERE user_id=$user_id AND folder_id=$folder_id");
$count = mysqli_num_rows($query);
?>

<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Gallery Details</h3></div>
        <div class="col-sm-6"></div>
      </div>
    </div>
  </div>

  <div class="app-content">
    <div class="container-fluid">

        <!-- Image Upload Section -->
        <div class="row mb-4">
            <div class="col-md-6">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-2">
                        <input type="file" name="image" required class="form-control">
                    </div>
                    <button type="submit" name="upload" class="btn btn-primary">Upload Image</button>
                </form>
                <?php if (!empty($message)) echo "<p class='mt-2 text-success fw-bold'>$message</p>"; ?>
            </div>
        </div>

        <!-- Gallery & Delete Form -->
        <form method="POST">
            <p><strong>Existing Images:</strong></p>
            <div class="row">
                <?php 
                if ($count > 0) {
                    while ($row = mysqli_fetch_assoc($query)) {
                        ?>
                        <div class="col-md-3 mb-3 text-center">
                            <img src="<?= $row['photo_name'] ?>" class="img-fluid border rounded" style="height: 200px; object-fit: cover;"><br>
                            <input type="checkbox" name="selected_photos[]" value="<?= $row['id'] ?>">
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>No images found.</p>";
                }
                ?>
            </div>

            <?php if ($count > 0): ?>
                <div class="row" style="height:20px">
                    <button type="submit" name="delete_selected" class="btn btn-danger">Delete Selected Photos</button>
                </div>
            <?php endif; ?>
        </form>

    </div>
  </div>
</main>

<footer class="app-footer">
  <strong>&copy; 2014-2024 <a href="https://adminlte.io" class="text-decoration-none">Internship</a>.</strong> All rights reserved.
</footer>
