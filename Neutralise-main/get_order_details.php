<?php
include 'connection.php';

// Check if user is admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    echo json_encode(['error' => 'Unauthorized access', 'redirect' => 'index.php']);
    exit();
}

if (!isset($_GET['order_id'])) {
    echo json_encode(['error' => 'Order ID is required']);
    exit();
}

$order_id = $_GET['order_id'];

// Get order details
$order_query = "SELECT o.*, u.name as customer_name, u.email, u.phone 
                FROM orders o 
                LEFT JOIN users u ON o.user_id = u.id 
                WHERE o.order_id = ?";

$stmt = $con->prepare($order_query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_result = $stmt->get_result();
$order = $order_result->fetch_assoc();

if (!$order) {
    echo json_encode(['error' => 'Order not found']);
    exit();
}

// Get order items
$items_query = "SELECT oi.*, p.name, p.imgSrc as image, p.price 
                FROM order_items oi 
                LEFT JOIN products p ON oi.product_id = p.id 
                WHERE oi.order_id = ?";

$stmt = $con->prepare($items_query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$items_result = $stmt->get_result();

$items = [];
while ($item = $items_result->fetch_assoc()) {
    $items[] = [
        'name' => $item['name'],
        'quantity' => $item['quantity'],
        'price' => $item['price'],
        'image' => 'contents/products/' . $item['image']
    ];
}

// Prepare response
$response = [
    'order_id' => $order['order_id'],
    'customer_name' => $order['customer_name'],
    'email' => $order['email'],
    'phone' => $order['phone'],
    'order_date' => date('d M Y, h:i A', strtotime($order['order_date'])),
    'status' => $order['status'],
    'total_amount' => $order['total_amount'],
    'items' => $items
];

echo json_encode($response);

$stmt->close();
$con->close();
?> 