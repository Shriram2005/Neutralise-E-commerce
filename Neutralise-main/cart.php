<?php
session_start(); // Start session to check user login status

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header("Location: Login-Register.php");
    exit;
}

include('connection.php');

// Get the user_id from the session
$user_id = $_SESSION['user_id'];

// Fetch cart items for this user from the database
$sql = "SELECT * FROM cart WHERE user_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Display the cart items
echo "<h1>Your Cart</h1>";
while ($row = $result->fetch_assoc()) {
    echo "<p>Product ID: " . $row['product_id'] . " - Quantity: " . $row['quantity'] . "</p>";
}
?>


<!-- cart.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Neutralise Naturals</title>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/cart.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Include other necessary stylesheets and scripts -->
</head>
<body>
    <!-- Include header -->
   <?php include('header.php')?>

    <main class="cart-container">
        <h1>Your Shopping Cart</h1>
        <div id="cart-items">
            <!-- Cart items will be dynamically inserted here -->
        </div>
        <div class="cart-summary">
            <h2>Cart Summary</h2>
            <div class="summary-item">
                <span>Subtotal</span>
                <span id="subtotal-amount">₹0.00</span>
            </div>
            <div class="summary-item">
                <span>Total</span>
                <span id="total-amount">₹0.00</span>
            </div>
            <button id="proceed-to-checkout" class="proceed-to-checkout">Proceed to Checkout</button>
        </div>
    </main>

    <!-- Include footer -->
     <?php include('footer.php');?>

     
    <script src="./js/cart.js"></script>
    <script src="./js/script.js" defer></script>
</body>
</html>
<script>
    document.getElementById('proceed-to-checkout').addEventListener('click', function() {
    window.location.href = 'checkout.php'; // Redirect to checkout.php
});

    </script>