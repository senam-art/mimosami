<?php
include '../db/onlineconfig.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch items from the basket
    $basketItems = [];
    $basketQuant = [];
    $customerID=  1;//$_SESSION['customerID']; // Replace with actual customer ID, e.g., from session or form input
    $total= $_SESSION['total'];
    
    $sql = "SELECT productID, quantity FROM mimosami_basket";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $basketItems[] = $row['productID'];
            $basketQuant[] = intval($row['quantity']);
        }
    }

    // Check if there are items to insert
    if (!empty($basketItems) && !empty($basketQuant)) {
        
        // Prepare insert statement including Customer ID
        $stmt = $conn->prepare("INSERT INTO mimosami_order (customerID, productList, quantityList,total) VALUES ( ?, ?,?,?)");
        if ($stmt) {
            // Insert aggregated data as a single record
            $productList = implode(',', $basketItems); // Combine product IDs as a comma-separated string
            $quantityList = implode(',', $basketQuant); // Combine quantities as a comma-separated string
            
            $stmt->bind_param("isss", $customerID, $productList, $quantityList,$total);
            if (!$stmt->execute()) {
                echo "Error inserting order: " . $stmt->error;
            }
            $stmt->close();}

        // Clear basket after checkout
        $clearBasketSQL = "DELETE FROM mimosami_basket";
        if (!$conn->query($clearBasketSQL)) {
            echo "Error clearing basket: " . $conn->error;
        }
    } else {
        echo "Basket is empty.";
    }
}

$conn->close();
header("Location: ../view/Homepage.html"); // Redirect to a confirmation page
exit();
?>

