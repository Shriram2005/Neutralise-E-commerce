<?php
session_start();

// Check if user is admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: admin_login.php");
    exit();
}

include 'connection.php';

// Get statistics
$total_orders = mysqli_query($con, "SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];
$total_products = mysqli_query($con, "SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];
$total_customers = mysqli_query($con, "SELECT COUNT(*) as count FROM register")->fetch_assoc()['count'];
$total_revenue = mysqli_query($con, "SELECT SUM(total_amount) as total FROM orders")->fetch_assoc()['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Neutralise Naturals</title>
    <link rel="stylesheet" href="./css/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Jacques+Francois&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="admin-dashboard">
        <div class="dashboard-header">
            <h1>Admin Dashboard</h1>
            <div class="admin-info">
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['admin_name']); ?></span>
                <a href="admin_logout.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </div>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <i class="fas fa-shopping-cart"></i>
                <div class="stat-info">
                    <span class="stat-value"><?php echo $total_orders; ?></span>
                    <span class="stat-label">Total Orders</span>
                </div>
            </div>

            <div class="stat-card">
                <i class="fas fa-box"></i>
                <div class="stat-info">
                    <span class="stat-value"><?php echo $total_products; ?></span>
                    <span class="stat-label">Products</span>
                </div>
            </div>

            <div class="stat-card">
                <i class="fas fa-users"></i>
                <div class="stat-info">
                    <span class="stat-value"><?php echo $total_customers; ?></span>
                    <span class="stat-label">Customers</span>
                </div>
            </div>

            <div class="stat-card">
                <i class="fas fa-rupee-sign"></i>
                <div class="stat-info">
                    <span class="stat-value">₹<?php echo number_format($total_revenue, 2); ?></span>
                    <span class="stat-label">Total Revenue</span>
                </div>
            </div>
        </div>

        <div class="admin-features">
            <div class="feature-card" onclick="window.location.href='admin_orders.php'">
                <div class="feature-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h3>Manage Orders</h3>
                <p>View and manage customer orders</p>
            </div>

            <div class="feature-card" onclick="window.location.href='manage_products.php'">
                <div class="feature-icon">
                    <i class="fas fa-box"></i>
                </div>
                <h3>Manage Products</h3>
                <p>Add, edit, or remove products</p>
            </div>

            <div class="feature-card" onclick="window.location.href='view_customers.php'">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Customer Management</h3>
                <p>View customer details and orders</p>
            </div>

            <div class="feature-card" onclick="window.location.href='view_testimonials.php'">
                <div class="feature-icon">
                    <i class="fas fa-star"></i>
                </div>
                <h3>Testimonials</h3>
                <p>Manage customer testimonials</p>
            </div>

            <div class="feature-card" onclick="window.location.href='view_blog.php'">
                <div class="feature-icon">
                    <i class="fas fa-blog"></i>
                </div>
                <h3>Blog Management</h3>
                <p>Manage blog posts and content</p>
            </div>

            <div class="feature-card" onclick="window.location.href='admin_settings.php'">
                <div class="feature-icon">
                    <i class="fas fa-cog"></i>
                </div>
                <h3>Settings</h3>
                <p>Manage admin settings</p>
            </div>
        </div>
    </div>

<style>
.admin-dashboard {
    max-width: 1400px;
    margin: 40px auto;
    padding: 0 20px;
}

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.dashboard-header h1 {
    font-family: var(--font-heading);
    font-size: 2rem;
    color: var(--text-color);
}

.admin-info {
    display: flex;
    align-items: center;
    gap: 20px;
}

.logout-btn {
    background: var(--green-bg-color);
    color: white;
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: background-color 0.3s;
}

.logout-btn:hover {
    background: var(--hover-color);
}

.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
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

.admin-features {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.feature-card {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    transition: transform 0.3s, box-shadow 0.3s;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
}

.feature-icon {
    width: 60px;
    height: 60px;
    background: var(--main-bg-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
}

.feature-icon i {
    font-size: 1.5rem;
    color: var(--green-bg-color);
}

.feature-card h3 {
    font-family: var(--font-heading);
    font-size: 1.2rem;
    color: var(--text-color);
    margin-bottom: 10px;
}

.feature-card p {
    font-size: 0.9rem;
    color: #666;
}

@media (max-width: 768px) {
    .dashboard-header {
        flex-direction: column;
        text-align: center;
        gap: 20px;
    }

    .admin-info {
        flex-direction: column;
    }

    .stats-container {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .stats-container {
        grid-template-columns: 1fr;
    }

    .admin-features {
        grid-template-columns: 1fr;
    }
}
</style>

</body>
</html> 