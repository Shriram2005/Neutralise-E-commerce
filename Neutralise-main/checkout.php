<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: Login-Register.php");
    exit;
}

include('connection.php');

// Get user details from register table
$user_id = $_SESSION['user_id'];
$stmt = $con->prepare("SELECT * FROM register WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Get cart total
$stmt = $con->prepare("SELECT SUM(p.price * c.quantity) as total FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$cart_total = $result['total'] ?? 0;

// Check if cart is empty
$stmt = $con->prepare("SELECT COUNT(*) as count FROM cart WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cart_count = $stmt->get_result()->fetch_assoc()['count'];

if ($cart_count == 0) {
    header("Location: cart.php?error=empty");
    exit;
}

// Process order submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    if (empty($_POST['address']) || empty($_POST['phone'])) {
        $error = "Please fill in all required fields.";
    } else {
        try {
            $con->begin_transaction();

            // Insert order
            $stmt = $con->prepare("INSERT INTO orders (user_id, total_amount, shipping_address, phone) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("idss", $user_id, $cart_total, $_POST['address'], $_POST['phone']);
            $stmt->execute();
            $order_id = $con->insert_id;

            // Move cart items to order_items
            $stmt = $con->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) SELECT ?, c.product_id, c.quantity, p.price FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
            $stmt->bind_param("ii", $order_id, $user_id);
            $stmt->execute();

            // Clear user's cart
            $stmt = $con->prepare("DELETE FROM cart WHERE user_id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();

            $con->commit();
            header("Location: orders.php?success=1");
            exit;
        } catch (Exception $e) {
            $con->rollback();
            $error = "An error occurred while processing your order. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Neutralise Naturals</title>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include('header.php')?>

    <main class="checkout-container">
        <div class="checkout-header">
            <h1>Checkout</h1>
        </div>

        <?php if (isset($error)): ?>
            <div class="error-message">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <div class="checkout-content">
            <form method="POST" class="checkout-form">
                <div class="form-section">
                    <h2>Shipping Details</h2>
                    
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" value="<?php echo htmlspecialchars($user['full_name']); ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number*</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required pattern="[0-9]{10}" title="Please enter a valid 10-digit phone number">
                    </div>

                    <div class="form-group">
                        <label for="address">Shipping Address*</label>
                        <textarea id="address" name="address" required rows="3"><?php echo htmlspecialchars($user['address']); ?></textarea>
                    </div>
                </div>

                <div class="form-section">
                    <h2>Order Summary</h2>
                    <div class="order-summary">
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>₹<?php echo number_format($cart_total, 2); ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Shipping</span>
                            <span>Free</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total</span>
                            <span>₹<?php echo number_format($cart_total, 2); ?></span>
                        </div>
                    </div>

                    <div class="payment-method">
                        <h3>Payment Method</h3>
                        <div class="payment-option">
                            <input type="radio" id="cod" name="payment_method" value="Cash on Delivery" checked>
                            <label for="cod">Cash on Delivery</label>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="cart.php" class="back-to-cart">
                        <i class="fas fa-arrow-left"></i> Back to Cart
                    </a>
                    <button type="submit" class="confirm-order">
                        Confirm Order <i class="fas fa-check"></i>
                    </button>
                </div>
            </form>
        </div>
    </main>

    <?php include('footer.php');?>

<style>
.checkout-container {
    max-width: 1000px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.checkout-header {
    margin-bottom: 2rem;
}

.checkout-header h1 {
    font-size: 1.8rem;
    color: var(--text-color);
    margin: 0;
}

.error-message {
    background-color: #f8d7da;
    color: #721c24;
    padding: 1rem;
    border-radius: 4px;
    margin-bottom: 1rem;
}

.checkout-content {
    background: white;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    padding: 2rem;
}

.form-section {
    margin-bottom: 2rem;
}

.form-section h2 {
    font-size: 1.4rem;
    color: var(--text-color);
    margin-bottom: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    color: #666;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
}

.form-group input:read-only {
    background-color: #f8f9fa;
}

.order-summary {
    background-color: #f8f9fa;
    padding: 1.5rem;
    border-radius: 4px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
    color: #666;
}

.summary-row.total {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #ddd;
    font-weight: bold;
    color: var(--text-color);
}

.payment-method {
    margin-top: 2rem;
}

.payment-method h3 {
    font-size: 1.2rem;
    margin-bottom: 1rem;
}

.payment-option {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #eee;
}

.back-to-cart {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #666;
    text-decoration: none;
    transition: color 0.3s ease;
}

.back-to-cart:hover {
    color: var(--text-color);
}

.confirm-order {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background-color: var(--green-bg-color);
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s ease;
}

.confirm-order:hover {
    background-color: var(--dark-green-color);
}

@media (max-width: 768px) {
    .checkout-content {
        padding: 1rem;
    }

    .form-actions {
        flex-direction: column;
        gap: 1rem;
    }

    .back-to-cart,
    .confirm-order {
        width: 100%;
        justify-content: center;
    }
}
</style>

</body>
</html>