<?php
// Prevent any output
ob_start();

// Database configuration
$host = "localhost";
$user = "root";
$pass = "";
$db = "neutrali_demo2";

try {
    $con = mysqli_connect($host, $user, $pass, $db);
    
    if (!$con) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }
    
    // Set charset to ensure proper handling of special characters
    mysqli_set_charset($con, "utf8mb4");
    
} catch (Exception $e) {
    // Log error but don't output anything
    error_log("Database connection error: " . $e->getMessage());
    die("Database connection error. Please try again later.");
}
// $con=mysqli_connect($host,$user,$pass,$db);
?>
