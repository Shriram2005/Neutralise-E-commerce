<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: Login-Register.php");
    exit;
}

include('connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Neutralise Naturals</title>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/cart.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include('header.php')?>

    <main class="cart-container">
        <div class="cart-header">
            <h1>Your Shopping Cart</h1>
            <button onclick="window.location.href='shop.php'" class="continue-shopping">
                <i class="fas fa-arrow-left"></i> Continue Shopping
            </button>
        </div>

        <div class="cart-content">
            <div id="cart-items">
                <!-- Cart items will be dynamically inserted here -->
            </div>
            
            <div class="cart-summary">
                <h2>Order Summary</h2>
                <div class="summary-items">
                    <div class="summary-item">
                        <span>Subtotal</span>
                        <span id="subtotal-amount">₹0.00</span>
                    </div>
                    <div class="summary-item">
                        <span>Shipping</span>
                        <span>Free</span>
                    </div>
                    <div class="summary-item total">
                        <span>Total</span>
                        <span id="total-amount">₹0.00</span>
                    </div>
                </div>
                <button id="proceed-to-checkout" class="proceed-to-checkout">
                    Proceed to Checkout <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>

        <!-- Empty cart message -->
        <div id="empty-cart" class="empty-cart" style="display: none;">
            <i class="fas fa-shopping-cart"></i>
            <h2>Your cart is empty</h2>
            <p>Looks like you haven't added any items to your cart yet.</p>
            <button onclick="window.location.href='shop.php'" class="continue-shopping">
                Start Shopping
            </button>
        </div>
    </main>

    <?php include('footer.php');?>

<style>
.cart-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.cart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.cart-header h1 {
    font-size: 1.8rem;
    color: var(--text-color);
    margin: 0;
}

.continue-shopping {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: transparent;
    border: 2px solid var(--green-bg-color);
    color: var(--green-bg-color);
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.continue-shopping:hover {
    background: var(--green-bg-color);
    color: white;
}

.cart-content {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 2rem;
}

.cart-summary {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    position: sticky;
    top: 2rem;
    height: fit-content;
}

.cart-summary h2 {
    font-size: 1.4rem;
    margin-bottom: 1.5rem;
    color: var(--text-color);
}

.summary-items {
    border-top: 1px solid #dee2e6;
    padding-top: 1rem;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
    color: #666;
}

.summary-item.total {
    border-top: 1px solid #dee2e6;
    padding-top: 1rem;
    margin-top: 1rem;
    font-weight: bold;
    font-size: 1.1rem;
    color: var(--text-color);
}

.proceed-to-checkout {
    width: 100%;
    padding: 12px;
    background: var(--green-bg-color);
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 1rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: background 0.3s ease;
}

.proceed-to-checkout:hover {
    background: var(--hover-color);
}

.empty-cart {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-cart i {
    font-size: 4rem;
    color: #dee2e6;
    margin-bottom: 1rem;
}

.empty-cart h2 {
    color: var(--text-color);
    margin-bottom: 0.5rem;
}

.empty-cart p {
    color: #666;
    margin-bottom: 1.5rem;
}

@media (max-width: 768px) {
    .cart-content {
        grid-template-columns: 1fr;
    }

    .cart-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .cart-summary {
        position: static;
        margin-top: 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    displayCart();
});

document.getElementById('proceed-to-checkout').addEventListener('click', function() {
    window.location.href = 'checkout.php';
});
</script>

<script src="./js/cart.js"></script>
<script src="./js/script.js" defer></script>
</body>
</html>