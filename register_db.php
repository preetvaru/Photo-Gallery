<?php

include("includes/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $Email = $_POST['email'];
    $Password = $_POST['password'];
    $Phone = $_POST['phone'];
    $Gender = $_POST['gender'];
    $dob  = $_POST['dob'];
    $City = $_POST['city'];
    $State = $_POST['state'];
    $Country = $_POST['country'];
    $Address = $_POST['address'];
    $file = $_FILES['file']['name'];
    $tmp_name = $_FILES['file']['tmp_name'];
    $upload_dir = "upload/";
    $file_path = $upload_dir . basename($file);

    // Validate email
    if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format!";
        header("Location: register.php");
        exit();
    }

    // Check if the email already exists
    $query = mysqli_query($conn, "SELECT * FROM registration WHERE email = '" . mysqli_real_escape_string($conn, $Email) . "'");
    
    if (mysqli_num_rows($query) > 0) {
        echo "<script>
            alert('Email already exists! Please use another email!');
            window.location.href = 'register.php';
            </script>";
        exit(); 
    }

    // Hash the password
    $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

    // Check if the upload folder exists; if not, create it
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Move the uploaded file
    if (move_uploaded_file($tmp_name, $file_path)) {

        // Corrected SQL query (removes the unnecessary column '0' from the VALUES)
        $sql = "INSERT INTO registration (name, email, password, phonenumber, gender, dob, city, state, country, address, file) 
                VALUES ('" . mysqli_real_escape_string($conn, $name) . "', 
                        '" . mysqli_real_escape_string($conn, $Email) . "', 
                        '" . $hashedPassword . "', 
                        '" . mysqli_real_escape_string($conn, $Phone) . "', 
                        '" . mysqli_real_escape_string($conn, $Gender) . "', 
                        '" . mysqli_real_escape_string($conn, $dob) . "', 
                        '" . mysqli_real_escape_string($conn, $City) . "', 
                        '" . mysqli_real_escape_string($conn, $State) . "', 
                        '" . mysqli_real_escape_string($conn, $Country) . "', 
                        '" . mysqli_real_escape_string($conn, $Address) . "', 
                        '" . mysqli_real_escape_string($conn, $file) . "')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>
                alert('Registration successful! Please log in.');
                window.location.href = 'index.php';
                </script>";
            exit();
        } else {
            echo "<script>
                alert('ERROR: Account creation failed!');
                window.location.href = 'register.php';
                </script>";
            exit();
        }
    } else {
        echo "<script>
            alert('File upload failed. Please try again!');
            window.location.href = 'register.php';
            </script>";
        exit();
    }
}
?>
