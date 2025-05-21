<?php
include("includes/connection.php");
include('includes/header.php');


// Handle folder creation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['folder_name'])) {
  $user_id = $_SESSION['id'];

  $folder_name = $_POST['folder_name'];
  // $folder_name_db = $_POST['folder_name']."_".$user_id;
  
  $check = mysqli_query($conn,"SELECT * FROM user_folders WHERE folder_name='$folder_name' AND user_id = '$user_id'");
  $result = mysqli_num_rows($check);

  if($result > 0){
    echo "<script>alert('$folder_name - Folder Name already exists.');</script>";
    
  }
  else{
    
    $target_dir = "gallery_folders/" . $folder_name;
    $created_at = date('Y-m-d H:i:s');
    if (mkdir($target_dir, 0777, true)) {
      $query = mysqli_query($conn, "INSERT INTO user_folders VALUES('',$user_id, '$folder_name', '$created_at')");

      echo "<script>alert('Folder $folder_name has been created successfully.');</script>";
    }
    // mkdir($target_dir, 0777, true);
  }
  // echo $folder_name;
  // exit;
  

  // // $query = mysqli_query($conn,"INSERT INTO user_folders VALUES($user_id,'$folder_name',date('Y-m-d H:i:s'))");

  

  // // Check if folder already exists
  // if (file_exists($target_dir)) {
  //   echo "<script>alert('$folder_name already exists.');</script>";
  // } else {
  //   // Create the folder
  //   
  //     echo "<script>alert('Folder $folder_name has been created successfully.');</script>";
  //   } else {
  //     echo "<script>alert('Failed to create folder $folder_name');</script>";
  //   }
  // }
}

// Handle folder deletion
// Handle folder deletion (filesystem + DB)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_folder'])) {
  if (!empty($_POST['selected_folders'])) {
      foreach ($_POST['selected_folders'] as $folder_name) {
          $user_id = $_SESSION['id'];
          $folder_result = mysqli_query($conn, "SELECT id FROM user_folders WHERE folder_name='$folder_name' AND user_id='$user_id'");
          if ($folder_row = mysqli_fetch_assoc($folder_result)) {
              $folder_id = $folder_row['id'];

              // Delete images from user_photos (if used)
              mysqli_query($conn, "DELETE FROM user_photos WHERE folder_id = '$folder_id'");

              // Delete folder record from user_folders
              mysqli_query($conn, "DELETE FROM user_folders WHERE id = '$folder_id'");

              // Delete from filesystem
              $folder_path = "gallery_folders/$folder_name";
              if (is_dir($folder_path)) {
                  foreach (glob($folder_path . "/*") as $file) {
                      unlink($file);
                  }
                  rmdir($folder_path);
              }

              echo "<script>alert('Folder $folder_name deleted successfully.');</script>";
          }
      }
  } else {
      echo "<script>alert('No folders selected.');</script>";
  }
}

// Handle image deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_selected'])) {
  if (isset($_POST['selected_images'])) {
    $folder_name = $_POST['folder_name'];
    foreach ($_POST['selected_images'] as $image) {
      $image_path = "gallery_folders/$folder_name/$image";
      if (file_exists($image_path)) {
        unlink($image_path);
        echo "<p>Image '$image' has been deleted.</p>";
      }
    }
  } else {
    echo "<p>No images selected for deletion.</p>";
  }
}

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['photo']) && isset($_POST['folder_name'])) {
  $folder_name = $_POST['folder_name'];
  
  $target_dir = "gallery_folders/" . $folder_name . "/";
  
  $target_file = $target_dir . basename($_FILES["photo"]["name"]);
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  // Check if folder exists
  if (!file_exists($target_dir)) {
    echo "<p>Folder '$folder_name' does not exist.</p>";
  } else {
    // Validate image file
    $uploadOk = 1;
    if (getimagesize($_FILES["photo"]["tmp_name"]) === false) {
      echo "<p>File is not an image.</p>";
      $uploadOk = 0;
    }
    if (file_exists($target_file)) {
      echo "<p>Sorry, file already exists.</p>";
      $uploadOk = 0;
    }
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
      echo "<p>Sorry, only JPG, JPEG, PNG, and GIF files are allowed.</p>";
      $uploadOk = 0;
    }

    // Upload the file if everything is ok
    if ($uploadOk && move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
      echo "<p>The file " . basename($_FILES["photo"]["name"]) . " has been uploaded.</p>";
    } else {
      echo "<p>Sorry, your file was not uploaded.</p>";
    }
  }
}
?>

<!--begin::App Main-->
<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Gallery</h3></div>
        <div class="col-sm-6"></div>
      </div>
    </div>
  </div>

  <div class="app-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <form method="POST" action="gallery.php">
            <label for="folder_name">Create a New Folder</label><br />
            <input type="text" id="folder_name" name="folder_name" placeholder="Enter folder name" required />
            <button type="submit" class="btn btn-success">Create</button>
          </form>
        </div>

        <div class="col-lg-12">
          <br>
          <!-- Delete Folder button -->
          <form method="POST" action="gallery.php">
            <div>
            <div style="display: flex; justify-content: flex-end;">
              <button type="submit" name="delete_folder" class="btn btn-danger" style="margin-right:10px;">Delete Selected Folders</button>
            </div>
            </div>
            <br>
            <br>
            <div>
              <div>
                <br>
            <p><br>Existing Folders:</p>
            <div style="display: flex; flex-wrap: wrap; gap: 20px;">
              <?php

              $qry = mysqli_query($conn,"SELECT * FROM user_folders WHERE user_id=".$_SESSION['id']);
              $count = mysqli_num_rows($qry);
              if($count > 0){

                while($row = mysqli_fetch_assoc($qry)){
                  $folder_name = $row['folder_name'];
                  $folder_id = $row['id'];
                  $user_id = $row['user_id'];
  
                  // print_r($row);
                  echo "<div style='width:200px;height:200px;background:#f2f2f2;border:2px solid #ccc;border-radius:8px;box-shadow:0 4px 6px rgba(0,0,0,0.1);display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:10px;'>"
                          . "<h4 style='font-size:18px;color:#333;'>$folder_name</h4>"
                          . "<input type='checkbox' name='selected_folders[]' value='$folder_name' />"
                          
                          . "<input type='hidden' name='folder' value='$folder_name' />"
                          . "<a href='gallery_details.php?user_id=" . $user_id . "&folder_id=". $folder_id ."' class='btn btn-primary'>View Folder</a>"
                          
                          . "</div>";
                }
              }
              // $folders = glob('gallery_folders/*', GLOB_ONLYDIR);
              else {
                echo "<p>No folders found.</p>";
              }
              ?>
            </div>
            </div>
            </div>
          </form>
        </div>

        <?php
        if (isset($_GET['folder'])) {
          $folder_name = $_GET['folder'];
          echo "<h2>Upload Photos to '$folder_name'</h2>";
          echo "<form method='POST' action='gallery.php?folder=$folder_name' enctype='multipart/form-data'>
                  <input type='hidden' name='folder_name' value='$folder_name' />
                  <input type='file' name='photo' required />
                  <button type='submit' class='btn btn-success' style='margin-top:5px;'>Upload Photo</button>
                </form>";

          $folder_path = "gallery_folders/$folder_name";
          $images = glob($folder_path . "/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
          if ($images) {
            echo "<h3>Uploaded Photos:</h3>";
            echo "<form method='POST' action='gallery.php?folder=$folder_name'>";
            echo "<div style='display: flex; flex-wrap: wrap; gap: 20px;'>";
            foreach ($images as $image) {
              $image_name = basename($image);
              echo "<div style='width:200px;height:200px;background:#f2f2f2;border:2px solid #ccc;border-radius:8px;box-shadow:0 4px 6px rgba(0,0,0,0.1);display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:10px;'>"
                      . "<img src='$image' style='max-width:100%;max-height:100%;object-fit:contain;' alt='Uploaded Image' />"
                      . "<input type='checkbox' name='selected_images[]' value='$image_name' />"
                    . "</div>";
            }
            echo "</div>";
            echo "<button type='submit' name='delete_selected' class='btn btn-danger' style='margin-top:20px;'>Delete Selected</button>";
            echo "<input type='hidden' name='folder_name' value='$folder_name' />";
            echo "</form>";
          } else {
            echo "<p>No images found in this folder.</p>";
          }
        }
        ?>
      </div>
    </div>
  </div>
</main>

<footer class="app-footer">
  <strong>Copyright &copy; 2014-2024&nbsp;<a href="https://adminlte.io" class="text-decoration-none">- Internship</a>.</strong>
  All rights reserved.
</footer>
<!--end::App Main-->
