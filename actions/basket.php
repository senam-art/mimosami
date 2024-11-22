<?php
include '../db/config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the form
    $productID = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $price = $_POST['product_price'];
    $quantity = $_POST['quantity'];
    $itemTotal = $price * $quantity;

    // Insert data into the checkout table
    $stmt = $conn->prepare("INSERT INTO mimosami_checkout (productID, productName, quantity, price, itemTotal) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssidd", $productID, $productName, $quantity, $price, $itemTotal);

    if ($stmt->execute()) {
        echo "Product added to checkout successfully!";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
