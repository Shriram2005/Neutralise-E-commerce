<?php
// Start session first
session_start();

// Check if already logged in
include 'check_admin.php';
include 'connection.php';

// Get all orders with customer details
$query = "SELECT o.*, r.full_name as customer_name, r.email, r.phone 
          FROM orders o 
          LEFT JOIN register r ON o.user_id = r.id 
          ORDER BY o.order_date DESC";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Error: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - Neutralise Naturals</title>
    <link rel="stylesheet" href="./css/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Jacques+Francois&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="admin-orders">
        <div class="page-header">
            <h1>Manage Orders</h1>
            <a href="admin_dashboard.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <div class="orders-container">
            <div class="filters">
                <input type="text" id="orderSearch" placeholder="Search orders..." onkeyup="filterOrders()">
                <select id="statusFilter" onchange="filterOrders()">
                    <option value="">All Statuses</option>
                    <option value="Pending">Pending</option>
                    <option value="Processing">Processing</option>
                    <option value="Shipped">Shipped</option>
                    <option value="Delivered">Delivered</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>

            <div class="orders-table-container">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Contact</th>
                            <th>Total Amount</th>
                            <th>Order Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (mysqli_num_rows($result) > 0) {
                            while($order = mysqli_fetch_assoc($result)) { 
                        ?>
                            <tr data-order-id="<?php echo $order['id']; ?>" data-status="<?php echo $order['status']; ?>">
                                <td>#<?php echo $order['id']; ?></td>
                                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                <td>
                                    <div class="contact-info">
                                        <span><?php echo htmlspecialchars($order['email']); ?></span>
                                        <span><?php echo htmlspecialchars($order['phone']); ?></span>
                                    </div>
                                </td>
                                <td>₹<?php echo number_format($order['total_amount'], 2); ?></td>
                                <td><?php echo date('d M Y', strtotime($order['order_date'])); ?></td>
                                <td>
                                    <select class="status-select" onchange="updateOrderStatus(<?php echo $order['id']; ?>, this.value)">
                                        <option value="Pending" <?php echo ($order['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                        <option value="Processing" <?php echo ($order['status'] == 'Processing') ? 'selected' : ''; ?>>Processing</option>
                                        <option value="Shipped" <?php echo ($order['status'] == 'Shipped') ? 'selected' : ''; ?>>Shipped</option>
                                        <option value="Delivered" <?php echo ($order['status'] == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
                                        <option value="Cancelled" <?php echo ($order['status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                                    </select>
                                </td>
                                <td>
                                    <button class="view-btn" onclick="viewOrderDetails(<?php echo $order['id']; ?>)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php 
                            }
                        } else {
                            echo '<tr><td colspan="7" class="no-orders">No orders found</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div id="orderDetailsModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Order Details</h2>
            <div id="orderDetailsContent"></div>
        </div>
    </div>

<style>
.admin-orders {
    max-width: 1400px;
    margin: 40px auto;
    padding: 0 20px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.page-header h1 {
    font-family: var(--font-heading);
    font-size: 2rem;
    color: var(--text-color);
}

.back-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: var(--green-bg-color);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    transition: background-color 0.3s;
}

.back-btn:hover {
    background: var(--hover-color);
}

.filters {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}

.filters input,
.filters select {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
}

.filters input {
    flex: 1;
    min-width: 200px;
}

.orders-table-container {
    overflow-x: auto;
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.orders-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 800px;
}

.orders-table th,
.orders-table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

.orders-table th {
    background: var(--main-bg-color);
    color: var(--text-color);
    font-weight: 600;
}

.orders-table tbody tr:hover {
    background: #f9f9f9;
}

.contact-info {
    display: flex;
    flex-direction: column;
    gap: 5px;
    font-size: 0.9rem;
}

.status-select {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 0.9rem;
}

.view-btn {
    background: var(--green-bg-color);
    color: white;
    border: none;
    padding: 8px;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.view-btn:hover {
    background: var(--hover-color);
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
}

.modal-content {
    position: relative;
    background: white;
    margin: 50px auto;
    padding: 30px;
    width: 90%;
    max-width: 800px;
    border-radius: 15px;
    max-height: 80vh;
    overflow-y: auto;
}

.close {
    position: absolute;
    right: 20px;
    top: 20px;
    font-size: 1.5rem;
    cursor: pointer;
}

@media (max-width: 768px) {
    .filters {
        flex-direction: column;
    }

    .page-header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
}
</style>

<script>
function filterOrders() {
    const searchTerm = document.getElementById('orderSearch').value.toLowerCase();
    const statusFilter = document.getElementById('statusFilter').value;
    const rows = document.querySelectorAll('.orders-table tbody tr');

    rows.forEach(row => {
        const orderData = row.textContent.toLowerCase();
        const status = row.getAttribute('data-status');
        const matchesSearch = orderData.includes(searchTerm);
        const matchesStatus = !statusFilter || status === statusFilter;

        row.style.display = matchesSearch && matchesStatus ? '' : 'none';
    });
}

function updateOrderStatus(orderId, newStatus) {
    fetch('update_order_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `order_id=${orderId}&status=${newStatus}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const row = document.querySelector(`tr[data-order-id="${orderId}"]`);
            row.setAttribute('data-status', newStatus);
            alert('Order status updated successfully!');
        } else {
            alert('Failed to update order status.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the order status.');
    });
}

function viewOrderDetails(orderId) {
    fetch(`get_order_details.php?order_id=${orderId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const modal = document.getElementById('orderDetailsModal');
                const content = document.getElementById('orderDetailsContent');
                
                let html = `
                    <div class="order-details">
                        <div class="customer-details">
                            <h3>Customer Information</h3>
                            <p><strong>Name:</strong> ${data.order.customer_name}</p>
                            <p><strong>Email:</strong> ${data.order.email}</p>
                            <p><strong>Phone:</strong> ${data.order.phone}</p>
                            <p><strong>Address:</strong> ${data.order.address}</p>
                        </div>
                        <div class="order-items">
                            <h3>Order Items</h3>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>`;
                
                data.items.forEach(item => {
                    html += `
                        <tr>
                            <td>${item.product_name}</td>
                            <td>${item.quantity}</td>
                            <td>₹${item.price}</td>
                            <td>₹${item.quantity * item.price}</td>
                        </tr>`;
                });
                
                html += `
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3"><strong>Total Amount</strong></td>
                                        <td><strong>₹${data.order.total_amount}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>`;
                
                content.innerHTML = html;
                modal.style.display = 'block';
            } else {
                alert('Failed to load order details.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while loading the order details.');
        });
}

// Close modal when clicking the close button or outside the modal
document.querySelector('.close').onclick = function() {
    document.getElementById('orderDetailsModal').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('orderDetailsModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>

</body>
</html> 