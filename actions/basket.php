<?php
include '../db/onlineconfig.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the form
    $productID = htmlspecialchars($_POST['productID'] ?? '');
    $productName = htmlspecialchars($_POST['productName'] ?? '');
    $quantity = htmlspecialchars($_POST['quantity'] ?? 0);
    $price = htmlspecialchars($_POST['price'] ?? 0);
    $itemTotal = htmlspecialchars($price * $quantity);

    // Insert data into the basket table
    $stmt = $conn->prepare(
        "INSERT INTO mimosami_basket (productID, productName, quantity, price, itemTotal) VALUES (?, ?, ?, ?, ?)"
    );

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssidd", $productID, $productName, $quantity, $price, $itemTotal);

    if ($stmt->execute()) {
        header("Location: ../view/Products.php");
        exit;
    } else {
        echo "<script>alert('Error: " . addslashes($stmt->error) . "');</script>";
    }

    // Clean up
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>


