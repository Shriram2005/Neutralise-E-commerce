<?php
include 'connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
    $status = isset($_POST['status']) ? $_POST['status'] : '';

    // Validate inputs
    if ($order_id <= 0 || empty($status)) {
        echo json_encode(['success' => false, 'message' => 'Invalid input parameters']);
        exit;
    }

    // Update the order status
    $query = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('si', $status, $order_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Order status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update order status']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$con->close();
?> 