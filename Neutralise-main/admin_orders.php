<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders Dashboard - Neutralise Naturals</title>
    <link rel="stylesheet" href="./css/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Jacques+Francois&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php
    // Check if user is admin before including header
    if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
        echo '<script>window.location.href = "index.php";</script>';
        exit();
    }
    
    include 'header.php';
    include 'connection.php';

    // Get filter parameters
    $status_filter = isset($_GET['status']) ? $_GET['status'] : 'all';
    $date_filter = isset($_GET['date']) ? $_GET['date'] : 'all';
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    // Build SQL query based on filters
    $sql = "SELECT o.*, u.name as customer_name, u.email, u.phone 
            FROM orders o 
            LEFT JOIN users u ON o.user_id = u.id 
            WHERE 1=1";

    if ($status_filter !== 'all') {
        $sql .= " AND o.status = '$status_filter'";
    }

    if ($date_filter !== 'all') {
        switch($date_filter) {
            case 'today':
                $sql .= " AND DATE(o.order_date) = CURDATE()";
                break;
            case 'week':
                $sql .= " AND o.order_date >= DATE_SUB(NOW(), INTERVAL 1 WEEK)";
                break;
            case 'month':
                $sql .= " AND o.order_date >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
                break;
        }
    }

    if ($search !== '') {
        $sql .= " AND (o.order_id LIKE '%$search%' OR u.name LIKE '%$search%' OR u.email LIKE '%$search%')";
    }

    $sql .= " ORDER BY o.order_date DESC";
    $result = $con->query($sql);
    ?>

    <div class="admin-orders-container">
        <div class="dashboard-header">
            <h1>Orders Dashboard</h1>
            <div class="order-stats">
                <?php
                $total_orders = mysqli_num_rows($result);
                $pending_orders = mysqli_query($con, "SELECT COUNT(*) as count FROM orders WHERE status='pending'")->fetch_assoc()['count'];
                $processing_orders = mysqli_query($con, "SELECT COUNT(*) as count FROM orders WHERE status='processing'")->fetch_assoc()['count'];
                $completed_orders = mysqli_query($con, "SELECT COUNT(*) as count FROM orders WHERE status='completed'")->fetch_assoc()['count'];
                ?>
                <div class="stat-card">
                    <i class="fas fa-shopping-cart"></i>
                    <div class="stat-info">
                        <span class="stat-value"><?php echo $total_orders; ?></span>
                        <span class="stat-label">Total Orders</span>
                    </div>
                </div>
                <div class="stat-card pending">
                    <i class="fas fa-clock"></i>
                    <div class="stat-info">
                        <span class="stat-value"><?php echo $pending_orders; ?></span>
                        <span class="stat-label">Pending</span>
                    </div>
                </div>
                <div class="stat-card processing">
                    <i class="fas fa-cog"></i>
                    <div class="stat-info">
                        <span class="stat-value"><?php echo $processing_orders; ?></span>
                        <span class="stat-label">Processing</span>
                    </div>
                </div>
                <div class="stat-card completed">
                    <i class="fas fa-check-circle"></i>
                    <div class="stat-info">
                        <span class="stat-value"><?php echo $completed_orders; ?></span>
                        <span class="stat-label">Completed</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="filters-section">
            <form action="" method="GET" class="filters-form">
                <div class="search-box">
                    <input type="text" name="search" placeholder="Search orders..." value="<?php echo $search; ?>">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </div>
                
                <div class="filter-group">
                    <select name="status" onchange="this.form.submit()">
                        <option value="all" <?php echo $status_filter === 'all' ? 'selected' : ''; ?>>All Status</option>
                        <option value="pending" <?php echo $status_filter === 'pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="processing" <?php echo $status_filter === 'processing' ? 'selected' : ''; ?>>Processing</option>
                        <option value="completed" <?php echo $status_filter === 'completed' ? 'selected' : ''; ?>>Completed</option>
                    </select>

                    <select name="date" onchange="this.form.submit()">
                        <option value="all" <?php echo $date_filter === 'all' ? 'selected' : ''; ?>>All Time</option>
                        <option value="today" <?php echo $date_filter === 'today' ? 'selected' : ''; ?>>Today</option>
                        <option value="week" <?php echo $date_filter === 'week' ? 'selected' : ''; ?>>This Week</option>
                        <option value="month" <?php echo $date_filter === 'month' ? 'selected' : ''; ?>>This Month</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="orders-table-container">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Contact</th>
                        <th>Order Date</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $status_class = strtolower($row['status']);
                            echo "<tr>";
                            echo "<td>#" . $row['order_id'] . "</td>";
                            echo "<td>" . $row['customer_name'] . "</td>";
                            echo "<td>
                                    <div class='contact-info'>
                                        <span>" . $row['email'] . "</span>
                                        <span>" . $row['phone'] . "</span>
                                    </div>
                                  </td>";
                            echo "<td>" . date('d M Y, h:i A', strtotime($row['order_date'])) . "</td>";
                            echo "<td>₹" . number_format($row['total_amount'], 2) . "</td>";
                            echo "<td><span class='status-badge $status_class'>" . ucfirst($row['status']) . "</span></td>";
                            echo "<td class='actions'>
                                    <button onclick='viewOrder(" . $row['order_id'] . ")' class='action-btn view-btn' title='View Details'>
                                        <i class='fas fa-eye'></i>
                                    </button>
                                    <button onclick='updateStatus(" . $row['order_id'] . ")' class='action-btn edit-btn' title='Update Status'>
                                        <i class='fas fa-edit'></i>
                                    </button>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='no-orders'>No orders found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div id="orderModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="orderDetails"></div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div id="statusModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Update Order Status</h2>
            <form id="updateStatusForm">
                <input type="hidden" id="orderId">
                <select id="newStatus">
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="completed">Completed</option>
                </select>
                <button type="submit" class="update-btn">Update Status</button>
            </form>
        </div>
    </div>

<style>
.admin-orders-container {
    max-width: 1400px;
    margin: 40px auto;
    padding: 0 20px;
}

.dashboard-header {
    margin-bottom: 30px;
}

.dashboard-header h1 {
    font-family: var(--font-heading);
    font-size: 2rem;
    color: var(--text-color);
    margin-bottom: 20px;
}

.order-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    gap: 15px;
}

.stat-card i {
    font-size: 2rem;
    color: var(--green-bg-color);
}

.stat-info {
    display: flex;
    flex-direction: column;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: bold;
    color: var(--text-color);
}

.stat-label {
    font-size: 0.9rem;
    color: #666;
}

.filters-section {
    margin-bottom: 30px;
}

.filters-form {
    display: flex;
    gap: 20px;
    align-items: center;
    flex-wrap: wrap;
}

.search-box {
    flex: 1;
    min-width: 300px;
    position: relative;
}

.search-box input {
    width: 100%;
    padding: 12px 40px 12px 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
}

.search-box button {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #666;
    cursor: pointer;
}

.filter-group {
    display: flex;
    gap: 15px;
}

.filter-group select {
    padding: 12px 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
    background: white;
    cursor: pointer;
}

.orders-table-container {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    overflow-x: auto;
}

.orders-table {
    width: 100%;
    border-collapse: collapse;
}

.orders-table th {
    background: #f8f9fa;
    padding: 15px;
    text-align: left;
    font-weight: 600;
    color: var(--text-color);
    border-bottom: 2px solid #eee;
}

.orders-table td {
    padding: 15px;
    border-bottom: 1px solid #eee;
}

.contact-info {
    display: flex;
    flex-direction: column;
    gap: 5px;
    font-size: 0.9rem;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 500;
}

.status-badge.pending {
    background: #fff3cd;
    color: #856404;
}

.status-badge.processing {
    background: #cce5ff;
    color: #004085;
}

.status-badge.completed {
    background: #d4edda;
    color: #155724;
}

.actions {
    display: flex;
    gap: 10px;
}

.action-btn {
    padding: 8px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.view-btn {
    background: #e3f2fd;
    color: #1976d2;
}

.edit-btn {
    background: #fdf2e9;
    color: #ed6c02;
}

.action-btn:hover {
    opacity: 0.8;
}

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
    max-width: 600px;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}

.close {
    position: absolute;
    right: 20px;
    top: 20px;
    font-size: 1.5rem;
    cursor: pointer;
    color: #666;
}

.update-btn {
    background: var(--green-bg-color);
    color: white;
    padding: 12px 24px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
    margin-top: 20px;
}

.no-orders {
    text-align: center;
    padding: 40px;
    color: #666;
}

@media (max-width: 768px) {
    .order-stats {
        grid-template-columns: repeat(2, 1fr);
    }

    .filters-form {
        flex-direction: column;
    }

    .search-box {
        width: 100%;
    }

    .filter-group {
        width: 100%;
        justify-content: space-between;
    }

    .filter-group select {
        flex: 1;
    }
}

@media (max-width: 480px) {
    .order-stats {
        grid-template-columns: 1fr;
    }

    .orders-table th:nth-child(3),
    .orders-table td:nth-child(3) {
        display: none;
    }
}
</style>

<script>
// View Order Details
function viewOrder(orderId) {
    const modal = document.getElementById('orderModal');
    const orderDetails = document.getElementById('orderDetails');
    
    // Fetch order details using AJAX
    fetch(`get_order_details.php?order_id=${orderId}`)
        .then(response => response.json())
        .then(data => {
            orderDetails.innerHTML = `
                <h2>Order #${data.order_id}</h2>
                <div class="order-info">
                    <p><strong>Customer:</strong> ${data.customer_name}</p>
                    <p><strong>Email:</strong> ${data.email}</p>
                    <p><strong>Phone:</strong> ${data.phone}</p>
                    <p><strong>Order Date:</strong> ${data.order_date}</p>
                    <p><strong>Status:</strong> ${data.status}</p>
                </div>
                <div class="order-items">
                    ${data.items.map(item => `
                        <div class="order-item">
                            <img src="${item.image}" alt="${item.name}">
                            <div class="item-details">
                                <h4>${item.name}</h4>
                                <p>Quantity: ${item.quantity}</p>
                                <p>Price: ₹${item.price}</p>
                            </div>
                        </div>
                    `).join('')}
                </div>
                <div class="order-total">
                    <h3>Total: ₹${data.total_amount}</h3>
                </div>
            `;
            modal.style.display = 'block';
        });
}

// Update Order Status
function updateStatus(orderId) {
    const modal = document.getElementById('statusModal');
    document.getElementById('orderId').value = orderId;
    modal.style.display = 'block';
}

// Close Modals
document.querySelectorAll('.close').forEach(closeBtn => {
    closeBtn.onclick = function() {
        this.closest('.modal').style.display = 'none';
    }
});

window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}

// Handle Status Update Form
document.getElementById('updateStatusForm').onsubmit = function(e) {
    e.preventDefault();
    const orderId = document.getElementById('orderId').value;
    const newStatus = document.getElementById('newStatus').value;
    
    // Update status using AJAX
    fetch('update_order_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            order_id: orderId,
            status: newStatus
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script>

</body>
</html> 