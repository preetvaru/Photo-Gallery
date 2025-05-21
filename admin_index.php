<?php
include("../includes/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $err;
    // Check if email and password are set
    if (isset($_POST['email'], $_POST['password'])) {

        $Email = $_POST['email'];
        $Password = $_POST['password'];

        // Validate email
        if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            die("INVALID EMAIL FORMAT");
        }

        // Fetch user from the database
        $query = mysqli_query($conn, "SELECT * FROM admin_login WHERE username = '" . mysqli_real_escape_string($conn, $Email) . "'");
        $user = mysqli_fetch_assoc($query);

        // echo $Password;
        // print_r($user['password']);

        if ($Email == $user['username'] && $Password == $user['password']) {
            
            // Redirect to the dashboard or another page
        session_start();
        $_SESSION['adminid'] = $user['id'];     
        header('Location: admin_dashboard.php'); 
        echo "Login successful! Welcome, " . htmlspecialchars($user['name']) . ".";
        exit();// Always call exit after a redirect 
        } else {
            $err = "Invalid email or password.";
        }
    } else {
        $err = "Please fill in all required fields.";
    }
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url(images/bg-1.jpg);
            background-size: cover;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="text-center">Admin Login</h2>
        <form method="post" action="admin_index.php">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" class="form-control" id="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <label style="color:red"><?php if(isset($err)){ echo $err;  }else{ $err=''; } ?></label>
                <button type="submit" class="btn btn-primary btn-block" >Sign In</button>
            </div>
            <div class="form-group d-flex justify-content-between">
                <label class="checkbox-wrap">Remember Me
                    <input type="checkbox" checked>
                    <span class="checkmark"></span>
                </label>
                <a href="#">Forgot Password?</a>
            </div>
        </form>
    </div>
</body>
</html>





<?php

?>