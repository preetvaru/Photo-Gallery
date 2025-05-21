<?php
$server = "localhost"; 
$username = "root"; 
$password = ""; 
$database_name = "internship_db"; 
$conn = mysqli_connect($server, $username, $password, $database_name);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $dob = $_POST["dob"];
    $status = $_POST["status"];

    $sql = "INSERT INTO registration (name, email, phonenumber, dob, status) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $email, $phone, $dob, $status);

    if ($stmt->execute()) {
        echo "User added successfully!";
    } else {
        echo "Error adding user.";
    }
}
?>
