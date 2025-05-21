<?php
include('../includes/connection.php');

if ($_POST['action'] === 'fetch_folders') {
    $user_id = intval($_POST['userId']);
    $folders = $conn->query("SELECT id, folder_name FROM user_folders WHERE user_id = $user_id");
    $folder_data = [];

    while ($row = $folders->fetch_assoc()) {
        $folder_data[] = $row;
    }

    echo json_encode(['folders' => $folder_data]);
    exit;
}

if ($_POST['action'] === 'fetch_photos') {
    $folder_id = intval($_POST['folderId']);
    $photos = $conn->query("SELECT photo_name FROM user_photos WHERE folder_id = $folder_id");
    $photo_data = [];

    while ($row = $photos->fetch_assoc()) {
        $photo_data[] = $row;
    }

    echo json_encode(['photos' => $photo_data]);
    exit;
}
?>
