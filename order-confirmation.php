<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header("Location: Login-Register.php");
    exit;
}

include('connection.php');

// Get the user_id from the session
$user_id = $_SESSION['user_id'];

// Fetch the latest order for the user
$sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_id DESC LIMIT 1";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Neutralise Naturals</title>
    <link rel="stylesheet" href="./css/index.css">
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/85a51766c8.js" crossorigin="anonymous"></script>
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Jacques+Francois&display=swap"
        rel="stylesheet">
    <script src="./js/script.js" defer></script>

</head>
<body>
    <?php include('header.php')?>

    <main class="order-confirmation-container">
        <h1>Order Confirmation</h1>
        <p>Your order has been successfully placed!</p>
        <p>Order ID: <?php echo $order['order_id']; ?></p>
        <p>Total Amount: ₹<?php echo number_format($order['total_amount'], 2); ?></p>
        <p>Payment Status: <?php echo $order['payment_status']; ?></p>

        <a href="index.php">Go to Home</a>
    </main>

        <!-- Include footer -->
    <?php include('footer.php');?>

    <script src="./js/script.js" defer></script>

    <style type="">
/**/



/* Order Confirmation Page Styles */
.order-confirmation-container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin-top: 40px;
}

.order-confirmation-container h1 {
    font-size: 2.5rem;
    margin-bottom: 20px;
    text-align: center;
    color: #333;
}

.order-confirmation-container p {
    font-size: 1.2rem;
    margin-bottom: 10px;
    text-align: center;
    color: #555;
}

.order-confirmation-container a {
    display: block;
    text-align: center;
    margin-top: 20px;
    font-size: 1.1rem;
    color: #007bff;
    text-decoration: none;
}

.order-confirmation-container a:hover {
    text-decoration: underline;
}

/* Responsive Styling */
@media (max-width: 768px) {
    .order-confirmation-container {
        padding: 15px;
    }
    
    .order-confirmation-container h1 {
        font-size: 2rem;
    }
    
    .order-confirmation-container p {
        font-size: 1rem;
    }
    
    .order-confirmation-container a {
        font-size: 1rem;
    }
}

/* For smaller screens (Mobile) */
@media (max-width: 480px) {
    .order-confirmation-container {
        padding: 10px;
        margin-top: 20px;
    }
    
    .order-confirmation-container h1 {
        font-size: 1.8rem;
    }
    
    .order-confirmation-container p {
        font-size: 0.9rem;
    }
    
    .order-confirmation-container a {
        font-size: 1rem;
    }
}

    </style>

</body>
</html>
