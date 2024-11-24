<?php
include '../db/onlineconfig.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the form
    $productID = $_POST['product_id'] ?? '';
    $productName = $_POST['product_name'] ?? '';
    $price = floatval($_POST['product_price'] ?? 0);
    $quantity = intval($_POST['quantity'] ?? 0);
    $itemTotal = $price * $quantity;

    if (empty($productID) || empty($productName) || $quantity <= 0 || $price <= 0) {
        echo "<script>alert('Invalid input. Please check your form values.');</script>";
        exit();
    }

    // Insert data into the checkout table
    $stmt = $conn->prepare(
        "INSERT INTO mimosami_basket (productID, productName, quantity, price, itemTotal) VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("ssidd", $productID, $productName, $quantity, $price, $itemTotal);

    if ($stmt->execute()) {
        echo "<script>alert('Product added to checkout successfully!');</script>";
        header("Location: ../view/Products.php");

    } else {
        echo "<script>alert('Error: " . addslashes($stmt->error) . "');</script>";
    }

    //clear basket when user checkout

    // Clean up
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>

