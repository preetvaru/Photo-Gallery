<?php 
include('includes/connection.php');

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // echo "ccmg";
    // exit;
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $phonenumber = $_POST['phonenumber']; 
    $address = $_POST['address'];

    // Handle file upload (profile picture)
    $file = $_FILES['file'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileError = $file['error'];
    $fileSize = $file['size'];
     
    if ($fileError === 0 && $fileSize > 0) {
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png'];
        
        if (in_array($fileExt, $allowed)) {
            // Generate a unique name for the file
            $fileNewName = uniqid('', true) . "." . $fileExt;
            $fileDestination = 'upload/' . $fileNewName;

            // Move the uploaded file to the server directory
            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                // Update profile data with new image
                $fileQuery = ", file = '$fileDestination'";
            } else {
                $fileQuery = '';  // No file uploaded, so fileQuery is empty
            }
        } else {
            // Handle invalid file type
            echo "Invalid file type.";
            $fileQuery = '';  // Ensure fileQuery is empty in case of invalid file type
        }
    } else {
        // No file uploaded, just update the profile without the file
        $fileQuery = '';
    }
    
    // Update the user profile in the database
    session_start();
    $userId = $_SESSION['id'];  // Assuming session has user id
    // Construct SQL query and include $fileQuery only if it is not empty
    $sql = "UPDATE registration SET name = '$name', phonenumber = '$phonenumber', gender = '$gender', address ='$address', dob = '$dob'" . $fileQuery . " WHERE id = $userId";
    
    if (mysqli_query($conn, $sql)) {
        // Redirect to profile page or show a success message
        header("Location: change_profile.php");
        exit();
    } else {
        // Handle database error
        echo "Error updating profile: " . mysqli_error($conn);
    }
}
?>
