<?php
session_start();
include('connection.php');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create a log file for cart actions
function logCartAction($message) {
    $logFile = __DIR__ . '/cart.log';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

// Log SQL query
function logQuery($query, $params = []) {
    $message = "SQL Query: " . $query;
    if (!empty($params)) {
        $message .= "\nParameters: " . print_r($params, true);
    }
    logCartAction($message);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    logCartAction("User not logged in");
    echo json_encode(['success' => false, 'message' => 'Please log in to manage your cart']);
    exit;
}

$user_id = $_SESSION['user_id'];
$action = $_GET['action'] ?? '';

logCartAction("Action: $action, User ID: $user_id");

header('Content-Type: application/json');

switch ($action) {
    case 'add':
        if (!isset($_POST['product_id'])) {
            logCartAction("Product ID missing in add action");
            echo json_encode(['success' => false, 'message' => 'Product ID is required']);
            exit;
        }

        $product_id = (int)$_POST['product_id'];
        $quantity = (int)($_POST['quantity'] ?? 1);
        $size_option = $_POST['size_option'] ?? null;

        logCartAction("Adding to cart - Product ID: $product_id, Quantity: $quantity, Size: " . ($size_option ?? 'null'));

        // Check if product exists in cart
        $query = "SELECT cart_id, quantity FROM cart WHERE user_id = ? AND product_id = ? AND (size_option = ? OR (size_option IS NULL AND ? IS NULL))";
        logQuery($query, [$user_id, $product_id, $size_option, $size_option]);
        
        $stmt = $con->prepare($query);
        if (!$stmt) {
            logCartAction("Prepare failed: " . $con->error);
            echo json_encode(['success' => false, 'message' => 'Database error']);
            exit;
        }

        $stmt->bind_param("iiss", $user_id, $product_id, $size_option, $size_option);
        if (!$stmt->execute()) {
            logCartAction("Execute failed: " . $stmt->error);
            echo json_encode(['success' => false, 'message' => 'Error checking cart']);
            exit;
        }

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Update quantity
            $row = $result->fetch_assoc();
            $new_quantity = $row['quantity'] + $quantity;
            logCartAction("Updating quantity to $new_quantity for cart_id: " . $row['cart_id']);
            
            $query = "UPDATE cart SET quantity = ? WHERE cart_id = ?";
            logQuery($query, [$new_quantity, $row['cart_id']]);
            
            $stmt = $con->prepare($query);
            if (!$stmt) {
                logCartAction("Prepare update failed: " . $con->error);
                echo json_encode(['success' => false, 'message' => 'Database error']);
                exit;
            }
            $stmt->bind_param("ii", $new_quantity, $row['cart_id']);
        } else {
            // Insert new item
            logCartAction("Inserting new cart item");
            $query = "INSERT INTO cart (user_id, product_id, quantity, size_option) VALUES (?, ?, ?, ?)";
            logQuery($query, [$user_id, $product_id, $quantity, $size_option]);
            
            $stmt = $con->prepare($query);
            if (!$stmt) {
                logCartAction("Prepare insert failed: " . $con->error);
                echo json_encode(['success' => false, 'message' => 'Database error']);
                exit;
            }
            $stmt->bind_param("iiis", $user_id, $product_id, $quantity, $size_option);
        }

        $success = $stmt->execute();
        if (!$success) {
            logCartAction("Final execute failed: " . $stmt->error);
            echo json_encode(['success' => false, 'message' => 'Error updating cart']);
            exit;
        }

        logCartAction("Cart operation successful");
        echo json_encode(['success' => $success]);
        break;

    case 'remove':
        if (!isset($_GET['product_id'])) {
            echo json_encode(['success' => false, 'message' => 'Product ID is required']);
            exit;
        }

        $product_id = (int)$_GET['product_id'];
        $stmt = $con->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $user_id, $product_id);
        $success = $stmt->execute();
        echo json_encode(['success' => $success]);
        break;

    case 'update_quantity':
        if (!isset($_POST['product_id']) || !isset($_POST['change'])) {
            echo json_encode(['success' => false, 'message' => 'Product ID and change amount are required']);
            exit;
        }

        $product_id = (int)$_POST['product_id'];
        $change = (int)$_POST['change'];

        // First get current quantity
        $stmt = $con->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $new_quantity = $row['quantity'] + $change;
            
            if ($new_quantity <= 0) {
                // Remove item if quantity would be 0 or less
                $stmt = $con->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
                $stmt->bind_param("ii", $user_id, $product_id);
            } else {
                // Update quantity
                $stmt = $con->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
                $stmt->bind_param("iii", $new_quantity, $user_id, $product_id);
            }
            $success = $stmt->execute();
            echo json_encode(['success' => $success]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Item not found in cart']);
        }
        break;

    case 'get':
        $stmt = $con->prepare("
            SELECT c.*, p.name, p.price, p.image1 as image 
            FROM cart c 
            JOIN products p ON c.product_id = p.id 
            WHERE c.user_id = ?
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        
        echo json_encode(['success' => true, 'items' => $items]);
        break;

    case 'count':
        $stmt = $con->prepare("SELECT SUM(quantity) as count FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        echo json_encode(['success' => true, 'count' => (int)($row['count'] ?? 0)]);
        break;

    case 'clear':
        $stmt = $con->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $success = $stmt->execute();
        echo json_encode(['success' => $success]);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
} 