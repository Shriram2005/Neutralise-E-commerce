<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="max-age=86400">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neutralise Naturals</title>

    <!-- stylesheet -->
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/Login-Register.css">
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/85a51766c8.js" crossorigin="anonymous"></script>
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Jacques+Francois&display=swap"
        rel="stylesheet">
</head>


<body>
    <!-------- Navbar --------->
    <?php include 'header.php';?>

<?php
include 'connection.php'; // Include your database connection file

if (isset($_POST['register'])) {
    // Retrieve form data
    $full_name = mysqli_real_escape_string($con, $_POST['full_name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);
    
    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert query
        $sql = "INSERT INTO `register` (`full_name`, `email`, `phone`, `address`, `password`)
                VALUES ('$full_name', '$email', '$phone', '$address', '$hashed_password')";

        // Execute query
        if (mysqli_query($con, $sql)) {
            echo "<script>alert('Registration successful!');</script>";
            header('Location: login-register.html'); // Redirect to login page
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
    }
}
?>



    <!-- Login/Register -->

    <div class="form-container">
         <p class="title">Welcome back</p>
<form method="POST" class="form">
  <!-- Full Name -->
  <input type="text" name="full_name" class="input" placeholder="Full Name" required>
  
  <!-- Email -->
  <input type="email" name="email" class="input" placeholder="Email" required>
  
  <!-- Phone -->
  <input type="tel" name="phone" class="input" placeholder="Phone" pattern="[0-9]{10}" required>
  
  <!-- Address -->
  <textarea name="address" class="input" placeholder="Address" rows="3" required></textarea>
  
  <!-- Password -->
  <input type="password" name="password" class="input" placeholder="Password" required>
  
  <!-- Confirm Password -->
  <input type="password" name="confirm_password" class="input" placeholder="Confirm Password" required>
  
  <!-- Register Button -->
  <button type="submit" name="register" class="form-btn">Register</button>

   <!-- <button type="button" class="form-btn" onclick="window.location.href='Login-Register.php'">Log in</button> -->
  
  <!-- Login Button -->
  <p class="page-link">
    <span class="page-link-label" onclick="window.location.href='Login-Register.php'">Already have an account?</span>
   
  </p>

</form>
       </div>



<?php include('footer.php');?>

<!-- ... rest of the existing code ... -->
    <script src="./js/script.js" defer></script>
</body>

</html>