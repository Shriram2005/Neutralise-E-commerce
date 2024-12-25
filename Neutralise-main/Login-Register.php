<?php
session_start(); // Start session to manage user login state
// Redirect to index page if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to the homepage or dashboard
    exit;
}

include('connection.php');
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if the email exists in the database
    $sql = "SELECT * FROM register WHERE email = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $email); // Bind email to the parameter
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct, login successful
            $_SESSION['user_id'] = $user['id']; // Store user ID in session
            $_SESSION['email'] = $user['email']; // Store email in session
            header("Location: index.php"); // Redirect to a dashboard or homepage
        } else {
            // Password is incorrect
            echo "Incorrect password.";
        }
    } else {
        // No user found with that email
        echo "No user found with that email.";
    }
}
?>



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
    <?php include('header.php');?>


    <!-- Login/Register -->

    <div class="form-container">
         <p class="title">Welcome back</p>
        <form class="form" method="POST" action="">
    <input type="email" class="input" placeholder="Email" name="email" required>
    <input type="password" class="input" placeholder="Password" name="password" required>
    <p class="page-link">
        <span class="page-link-label">Forgot Password?</span>
    </p>
    <button class="form-btn" type="submit">Log in</button>
</form>
         <p class="sign-up-label">
           Don't have an account?<span class="sign-up-link" onclick="window.location.href='register.php'">Sign up</span>
         </p>
         <div class="buttons-container">
           <div class="apple-login-button">
             <svg stroke="currentColor" fill="currentColor" stroke-width="0" class="apple-icon" viewBox="0 0 1024 1024" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
               <path d="M747.4 535.7c-.4-68.2 30.5-119.6 92.9-157.5-34.9-50-87.7-77.5-157.3-82.8-65.9-5.2-138 38.4-164.4 38.4-27.9 0-91.7-36.6-141.9-36.6C273.1 298.8 163 379.8 163 544.6c0 48.7 8.9 99 26.7 150.8 23.8 68.2 109.6 235.3 199.1 232.6 46.8-1.1 79.9-33.2 140.8-33.2 59.1 0 89.7 33.2 141.9 33.2 90.3-1.3 167.9-153.2 190.5-221.6-121.1-57.1-114.6-167.2-114.6-170.7zm-105.1-305c50.7-60.2 46.1-115 44.6-134.7-44.8 2.6-96.6 30.5-126.1 64.8-32.5 36.8-51.6 82.3-47.5 133.6 48.4 3.7 92.6-21.2 129-63.7z"></path>
             </svg>
             <span>Log in with Apple</span>
           </div>
           <div class="google-login-button">
             <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.1" x="0px" y="0px" class="google-icon" viewBox="0 0 48 48" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
               <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12
       c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24
       c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path>
               <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657
       C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path>
               <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36
       c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path>
               <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571
       c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
             </svg>
             <span>Log in with Google</span>
           </div>
         </div>
       </div>



<?php include('footer.php');?>

<!-- ... rest of the existing code ... -->
    <script src="./js/script.js" defer></script>
</body>

</html>