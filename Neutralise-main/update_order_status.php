<?php
include 'connection.php';

// Check if user is admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    echo json_encode(['error' => 'Unauthorized access', 'redirect' => 'index.php']);
    exit();
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['order_id']) || !isset($data['status'])) {
    echo json_encode(['error' => 'Order ID and status are required']);
    exit();
}

$order_id = $data['order_id'];
$status = $data['status'];

// Validate status
$valid_statuses = ['pending', 'processing', 'completed'];
if (!in_array($status, $valid_statuses)) {
    echo json_encode(['error' => 'Invalid status']);
    exit();
}

// Update order status
$update_query = "UPDATE orders SET status = ? WHERE order_id = ?";
$stmt = $con->prepare($update_query);
$stmt->bind_param("si", $status, $order_id);

$response = [];
if ($stmt->execute()) {
    $response['success'] = true;
    $response['message'] = 'Order status updated successfully';
} else {
    $response['success'] = false;
    $response['error'] = 'Failed to update order status';
}

echo json_encode($response);

$stmt->close();
$con->close();
?> 