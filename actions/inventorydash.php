<?php
// To include the database configuration file
include 'config.php';


// Function to get total inventory value
function getTotalInventoryValue($conn) {
    $sql = "SELECT SUM(quantity * unit_price) as total_value FROM inventory";
    $result = $conn->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        return $row['total_value'] ?? 0;
    }
    return 0;
}

// Function to get number of alerts (items below threshold)
function getAlertCount($conn) {
    $sql = "SELECT COUNT(*) as alert_count FROM inventory WHERE quantity <= reorder_level";
    $result = $conn->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        return $row['alert_count'] ?? 0;
    }
    return 0;
}

// Function to get total number of assets
function getTotalAssets($conn) {
    $sql = "SELECT COUNT(*) as total_assets FROM inventory";
    $result = $conn->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        return $row['total_assets'] ?? 0;
    }
    return 0;
}

// Function to get inventory items
function getInventoryItems($conn) {
    $sql = "SELECT * FROM inventory ORDER BY id";
    $result = $conn->query($sql);
    $items = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
    }
    return $items;
}

// Handle POST requests for updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header("Content-Type: application/json"); // Move header here since it's only needed for POST requests
    
    $action = $_POST['action'] ?? '';
    $itemId = $_POST['id'] ?? '';
    
    switch($action) {
        case 'edit':
            $quantity = $_POST['quantity'] ?? '';
            $stmt = $conn->prepare("UPDATE inventory SET quantity = ? WHERE id = ?");
            $stmt->bind_param("ii", $quantity, $itemId);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => $stmt->error]);
            }
            $stmt->close();
            exit;
            
        case 'restock':
            $sql = "UPDATE inventory SET quantity = quantity + reorder_quantity WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $itemId);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => $stmt->error]);
            }
            $stmt->close();
            exit;
    }
}

// Get dashboard data
$totalValue = getTotalInventoryValue($conn);
$alertCount = getAlertCount($conn);
$totalAssets = getTotalAssets($conn);
$inventoryItems = getInventoryItems($conn);

// Format the total value
$formattedTotalValue = number_format($totalValue, 2);

// Note: Don't close the connection here as it might be needed for HTML output
?>

