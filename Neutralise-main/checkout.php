<?php
session_start(); // Start session to check user login status

// Check if the user is logged in
// if (!isset($_SESSION['user_id'])) {
//     // If not logged in, redirect to login page
//     header("Location: Login-Register.php");
//     exit;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_method = $_POST['payment_method'];
    $_SESSION['payment_method'] = $payment_method; // Store payment method in session
    header("Location: payment-details.php"); // Redirect to payment details page
    exit;
    
}

include('connection.php');

// Get the user_id from the session
$user_id = $_SESSION['user_id'];

// Fetch cart items for this user from the database
$sql = "SELECT cart.*, products.price FROM cart INNER JOIN products ON cart.product_id = products.id WHERE cart.user_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$total_amount = 0;

// Calculate the total amount for the cart
while ($row = $result->fetch_assoc()) {
    $total_amount += $row['quantity'] * $row['price'];
}

// Handle the payment process (dummy processing here)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_method = $_POST['payment_method']; // Payment method selected by the user
    $payment_status = 'Pending'; // Assuming payment is initially pending

    // Insert the order into the database (order processing)
    $order_sql = "INSERT INTO orders (user_id, total_amount, payment_method, payment_status) VALUES (?, ?, ?, ?)";
    $order_stmt = $con->prepare($order_sql);
    $order_stmt->bind_param("idss", $user_id, $total_amount, $payment_method, $payment_status);
    $order_stmt->execute();

    // Here, you can integrate a real payment gateway like Razorpay, Paytm, etc.
    // For now, let's assume payment is successful and update the status
    $payment_status = 'Successful'; // After payment processing
    $order_update_sql = "UPDATE orders SET payment_status = ? WHERE user_id = ? AND payment_status = 'Pending'";
    $order_update_stmt = $con->prepare($order_update_sql);
    $order_update_stmt->bind_param("si", $payment_status, $user_id);
    $order_update_stmt->execute();

    // Redirect to confirmation page after payment
    header("Location: order-confirmation.php");
    exit;
}
?>


<script>
        // JavaScript to handle showing payment details based on selected payment method
        function showPaymentDetails() {
            let paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            let cardDetails = document.getElementById('card-details');
            let paytmDetails = document.getElementById('paytm-details');
            let gpayDetails = document.getElementById('gpay-details');
            let netBankingDetails = document.getElementById('net-banking-details');
            
            // Hide all payment details sections
            cardDetails.style.display = 'none';
            paytmDetails.style.display = 'none';
            gpayDetails.style.display = 'none';
            netBankingDetails.style.display = 'none';

            // Show relevant payment details section based on the selected payment method
            if (paymentMethod == 'Credit/Debit Card') {
                cardDetails.style.display = 'block';
            } else if (paymentMethod == 'Paytm') {
                paytmDetails.style.display = 'block';
            } else if (paymentMethod == 'Google Pay') {
                gpayDetails.style.display = 'block';
            } else if (paymentMethod == 'Net Banking') {
                netBankingDetails.style.display = 'block';
            }
        }
    </script>
<!-- Checkout Page (checkout.php) -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Neutralise Naturals</title>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/cart.css">
    <!-- <link rel="stylesheet" href="./css/index.css"> -->
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

    <main class="checkout-container">
        <h1>Your Checkout</h1>
        <div class="cart-summary">
            <p>Total Amount: ₹<?php echo number_format($total_amount, 2); ?></p>
        </div>

        <h2>Select Payment Method</h2>
<form action="checkout.php" method="POST">
    <div class="payment-option">
        <input type="radio" id="credit-card" name="payment_method" value="Credit/Debit Card" required>
        <label for="credit-card">Credit/Debit Card</label>
    </div>
    <div class="payment-option">
        <input type="radio" id="paytm" name="payment_method" value="Paytm" required>
        <label for="paytm">Paytm</label>
    </div>
    <div class="payment-option">
        <input type="radio" id="gpay" name="payment_method" value="Google Pay" required>
        <label for="gpay">Google Pay</label>
    </div>
    <div class="payment-option">
        <input type="radio" id="net-banking" name="payment_method" value="Net Banking" required>
        <label for="net-banking">Net Banking</label>
    </div>



    <button type="submit">Proceed to Pay</button>
</form>

    </main>

 <?php include('footer.php');?>

    <script src="./js/cart.js"></script>
    <script src="./js/script.js" defer></script>
</body>
</html>
<style type="">
    /* General Styles */


/* Checkout Page Styles */
.checkout-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin-top: 40px;
}

.checkout-container h1 {
    font-size: 2.5rem;
    margin-bottom: 20px;
    text-align: center;
    color: #333;
}

.checkout-container p {
    font-size: 1.2rem;
    margin-bottom: 10px;
    text-align: center;
    color: #555;
}

.checkout-container h2 {
    font-size: 2rem;
    margin-top: 30px;
    margin-bottom: 15px;
    color: #333;
}

.cart-summary {
    text-align: center;
    margin-bottom: 20px;
}

.cart-summary p {
    font-size: 1.4rem;
    color: #333;
}

.payment-option {
    margin: 15px 0;
    font-size: 1.1rem;
}

.payment-option input {
    margin-right: 10px;
}

button {
    display: block;
    width: 100%;
    padding: 12px;
    background-color: #007bff;
    color: #fff;
    font-size: 1.2rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 20px;
}

button:hover {
    background-color: #0056b3;
}

form {
    margin-top: 20px;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .checkout-container {
        padding: 15px;
    }

    .checkout-container h1 {
        font-size: 2rem;
    }

    .checkout-container p {
        font-size: 1rem;
    }

    .checkou

</style>