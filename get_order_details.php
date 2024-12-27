<?php
include 'connection.php';

header('Content-Type: application/json');

if (!isset($_GET['order_id'])) {
    echo json_encode(['success' => false, 'message' => 'Order ID is required']);
    exit;
}

$order_id = (int)$_GET['order_id'];

// Get order details with customer information
$order_query = "SELECT o.*, r.full_name as customer_name, r.email, r.phone, r.address 
                FROM orders o 
                LEFT JOIN register r ON o.user_id = r.id 
                WHERE o.id = ?";
$stmt = $con->prepare($order_query);
$stmt->bind_param('i', $order_id);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Order not found']);
    exit;
}

$order = $order_result->fetch_assoc();

// Get order items
$items_query = "SELECT oi.*, p.name as product_name, p.price 
                FROM order_items oi 
                LEFT JOIN products p ON oi.product_id = p.id 
                WHERE oi.order_id = ?";
$stmt = $con->prepare($items_query);
$stmt->bind_param('i', $order_id);
$stmt->execute();
$items_result = $stmt->get_result();

$items = [];
while ($item = $items_result->fetch_assoc()) {
    $items[] = $item;
}

$response = [
    'success' => true,
    'order' => $order,
    'items' => $items
];

echo json_encode($response);

$stmt->close();
$con->close();
?> 