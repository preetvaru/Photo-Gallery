<?php

include('includes/connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Registration</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-size: cover;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.49);
            border: 2px solid rgb(5, 9, 14);
        }
        h2 {
            margin-bottom: 20px;
        }
        .error { color: red; font-weight: bold; }
        .success { color: green; font-weight: bold; }
  </style>
</head>
<body>

<div class="login-container">
  <h2><center>Registration</center></h2>

  <!-- Display Error or Success Messages -->
  <?php if(isset($_SESSION['error'])): ?>
      <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
  <?php endif; ?>

  <?php if(isset($_SESSION['success'])): ?>
      <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
  <?php endif; ?>

  <form action="register_db.php" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group mb-3">
                <label for="name">Name:</label>
                <input class="form-control" type="text" id="name" name="name" required>
            </div>    
            <div class="form-group mb-3">
                <label for="email">Email:</label>
                <input class="form-control" type="email" id="email" name="email" required>
            </div>
            <div class="form-group mb-3">
                <label for="password">Password:</label>
                <input class="form-control" type="password" id="password" name="password" required>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group mb-3">
                <label for="phone">Phone Number:</label>
                <input class="form-control" type="number" id="phone" name="phone" required>
            </div>  
            <div class="form-group mb-3">
                <label for="gender">Gender:</label>
                <select class="form-select" id="gender" name="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>  
            <div class="form-group mb-3">
                <label for="dob">Date of Birth:</label>
                <input class="form-control" type="date" id="dob" name="dob" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group mb-3">
                <label for="city">City:</label>
                <input class="form-control" type="text" id="city" name="city" required>
            </div>
            <div class="form-group mb-3">
                <label for="state">State:</label>
                <input class="form-control" type="text" id="state" name="state" required>
            </div>
            <div class="form-group mb-3">
                <label for="country">Country:</label>
                <input class="form-control" type="text" id="country" name="country" required>
            </div>    
        </div>    
        <div class="col-md-12">
            <div class="form-group mb-3">
                <label for="address">Address:</label>
                <textarea class="form-control" id="address" name="address" required></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="file">Upload Photo:</label>
                <input type="file" class="form-control" id="file" name="file" required>
            </div>
            <div class="form-group mb-3">
                <?php
                $num1 = rand(1, 10);
                $num2 = rand(1, 10);
                $total = $num1 + $num2;
                ?>
                <label for="captcha" id="totalcaptcha" data-value="<?php echo $total; ?>">
                    Captcha: <?php echo "$num1 + $num2 = ?"; ?>
                </label>
                <input class="form-control" type="text" id="captcha" name="captcha" required>
                <span class="error errcaptcha"></span>
            </div>
        </div>
    </div>
    <div class="form-group text-center">
        <button type="submit" class="btn btn-primary" id="submit">Submit</button>
        <button type="reset" class="btn btn-danger">Cancel</button>
    </div>     
  </form>

  <p class="text-center">Are you a member? <a href="index.php">Sign In</a></p>
</div>

<script>
$(document).ready(function(){
    $("#submit").click(function(event){
        $(".errcaptcha").text("");
        let totalCaptcha = $("#totalcaptcha").data("value");
        let captcha = $("#captcha").val();
        
        if (parseInt(totalCaptcha) !== parseInt(captcha)) {
            $(".errcaptcha").text("Please enter a valid Captcha");
            event.preventDefault(); // Stop form submission
        }
    });
});
</script>

</body>
</html>
