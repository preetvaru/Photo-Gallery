<?php 

if(!isset($_SESSION['id'])){
    // Optionally, redirect after logging out
    header("Location: ./index.php");
    exit(); 
  }
?>