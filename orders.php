<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: Login-Register.php");
    exit;
}

include('connection.php');

// Get user's orders
$user_id = $_SESSION['user_id'];
$sql = "SELECT o.*, GROUP_CONCAT(CONCAT(p.name, ' (', oi.quantity, ')') SEPARATOR ', ') as products 
        FROM orders o 
        LEFT JOIN order_items oi ON o.order_id = oi.order_id 
        LEFT JOIN products p ON oi.product_id = p.id 
        WHERE o.user_id = ? 
        GROUP BY o.order_id 
        ORDER BY o.order_date DESC";

$stmt = $con->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - Neutralise Naturals</title>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include('header.php')?>

    <main class="orders-container">
        <div class="orders-header">
            <h1>My Orders</h1>
            <button onclick="window.location.href='shop.php'" class="continue-shopping">
                <i class="fas fa-arrow-left"></i> Continue Shopping
            </button>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="success-message">
                Your order has been placed successfully!
            </div>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <div class="orders-list">
                <?php while ($order = $result->fetch_assoc()): ?>
                    <div class="order-card">
                        <div class="order-header">
                            <div class="order-info">
                                <h3>Order #<?php echo $order['order_id']; ?></h3>
                                <span class="order-date">
                                    <?php echo date('F j, Y', strtotime($order['order_date'])); ?>
                                </span>
                            </div>
                            <div class="order-status <?php echo strtolower($order['order_status']); ?>">
                                <?php echo $order['order_status']; ?>
                            </div>
                        </div>
                        <div class="order-details">
                            <div class="order-products">
                                <strong>Products:</strong>
                                <p><?php echo $order['products'] ?: 'No products found'; ?></p>
                            </div>
                            <div class="order-amount">
                                <strong>Total Amount:</strong>
                                <p>₹<?php echo number_format($order['total_amount'], 2); ?></p>
                            </div>
                            <div class="order-shipping">
                                <strong>Shipping Address:</strong>
                                <p><?php echo htmlspecialchars($order['shipping_address']); ?></p>
                            </div>
                            <div class="order-payment">
                                <strong>Payment Method:</strong>
                                <p><?php echo $order['payment_method']; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="no-orders">
                <i class="fas fa-shopping-bag"></i>
                <h2>No orders yet</h2>
                <p>Looks like you haven't placed any orders yet.</p>
                <button onclick="window.location.href='shop.php'" class="continue-shopping">
                    Start Shopping
                </button>
            </div>
        <?php endif; ?>
    </main>

    <?php include('footer.php');?>

<style>
.orders-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.orders-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.orders-header h1 {
    font-size: 1.8rem;
    color: var(--text-color);
    margin: 0;
}

.success-message {
    background-color: #d4edda;
    color: #155724;
    padding: 1rem;
    border-radius: 4px;
    margin-bottom: 1rem;
    text-align: center;
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

.order-card {
    background: white;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #eee;
}

.order-info h3 {
    margin: 0;
    color: var(--text-color);
}

.order-date {
    font-size: 0.9rem;
    color: #666;
}

.order-status {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 500;
}

.order-status.pending {
    background: #fff3cd;
    color: #856404;
}

.order-status.processing {
    background: #cce5ff;
    color: #004085;
}

.order-status.shipped {
    background: #d4edda;
    color: #155724;
}

.order-status.delivered {
    background: #d4edda;
    color: #155724;
}

.order-status.cancelled {
    background: #f8d7da;
    color: #721c24;
}

.order-details {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.order-details strong {
    display: block;
    margin-bottom: 0.5rem;
    color: #666;
}

.order-details p {
    margin: 0;
    color: var(--text-color);
}

.no-orders {
    text-align: center;
    padding: 3rem 1rem;
}

.no-orders i {
    font-size: 4rem;
    color: #dee2e6;
    margin-bottom: 1rem;
}

.no-orders h2 {
    color: var(--text-color);
    margin-bottom: 0.5rem;
}

.no-orders p {
    color: #666;
    margin-bottom: 1.5rem;
}

@media (max-width: 768px) {
    .orders-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .order-header {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }

    .order-details {
        grid-template-columns: 1fr;
        text-align: center;
    }
}
</style>

</body>
</html> 