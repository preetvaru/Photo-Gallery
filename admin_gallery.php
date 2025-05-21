<?php
include('../includes/connection.php');
include('../includes/admin_header.php');

$users = $conn->query("SELECT id, name FROM registration");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin User Gallery</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    #userDropdown { width: 250px; padding: 8px; font-size: 14px; margin-bottom: 10px; display: block; }
    #galleryContainer { display: flex; flex-direction: column; gap: 15px; margin-top: 20px; }
    .gallery-section { font-weight: bold; color: #333; margin-top: 10px; }
    .gallery-list { list-style: none; padding: 0; display: flex; flex-wrap: wrap; gap: 15px; }
    .folder-item { display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9; }
    .folder-icon { width: 40px; height: 40px; }
    .photo-container { display: flex; flex-wrap: wrap; gap: 10px; }
    .gallery-img { width: 120px; height: 120px; border-radius: 5px; object-fit: cover; box-shadow: 2px 2px 5px rgba(0,0,0,0.2); }
  </style>
</head>
<body>

<div style="padding:30px;padding-top:10px">
  <label for="userDropdown"><strong>Select User:</strong></label>
  <select id="userDropdown">
    <option value="all">Select a User</option>
    <?php while ($row = $users->fetch_assoc()) { ?>
      <option value="<?= htmlspecialchars($row['id']); ?>"><?= htmlspecialchars($row['name']); ?></option>
    <?php } ?>
  </select>

  <div id="galleryContainer">
    <div>
      <h3 class="gallery-section">Folders:</h3>
      <ul id="folderList" class="gallery-list"></ul>
    </div>
    <div>
      <h3 class="gallery-section">Photos:</h3>
      <div id="photoGallery" class="photo-container"></div>
    </div>
  </div>
</div>

<script>
$(document).ready(function () {
  function loadGallery(userId) {
    $('#folderList').html('');
    $('#photoGallery').html('');

    if (userId === "all") {
      $('#folderList').html('<li>Please select a user to view folders</li>');
      return;
    }

    $.post("fetch_gallery.php", { action: "fetch_folders", userId: userId }, function (response) {
      if (response.folders && response.folders.length > 0) {
        response.folders.forEach(function (folder) {
          $('#folderList').append(`
            <li class="folder-item" data-folder-id="${folder.id}">
              <img src="../gall.png" class="folder-icon">
              <div><strong>${folder.folder_name}</strong></div>
            </li>
          `);
        });
      } else {
        $('#folderList').html('<li>No folders available</li>');
      }
    }, 'json');
  }

  function loadPhotos(folderId) {
    $('#photoGallery').html('<p>Loading photos...</p>');

    $.post("fetch_gallery.php", { action: "fetch_photos", folderId: folderId }, function (response) {
      $('#photoGallery').html('');

      if (response.photos && response.photos.length > 0) {
        response.photos.forEach(function (photo) {
          $('#photoGallery').append(`<img src="../${photo.photo_name}" class="gallery-img">`);
        });
      } else {
        $('#photoGallery').html('<p>No photos in this folder</p>');
      }
    }, 'json');
  }

  $('#userDropdown').change(function () {
    const userId = $(this).val();
    loadGallery(userId);
  });

  $(document).on('click', '.folder-item', function () {
    const folderId = $(this).data('folder-id');
    loadPhotos(folderId);
  });
});
</script>

</body>
</html>
