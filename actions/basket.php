<?php
include '../db/onlineconfig.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productID = htmlspecialchars($_POST['productID'] ?? '');
    $productName = htmlspecialchars($_POST['productName'] ?? '');
    $quantity = (float)($_POST['quantity'] ?? 0); // Cast quantity to a float
    $price = (float)($_POST['price'] ?? 0); // Cast price to a float
    $itemTotal = $price * $quantity; // Perform the multiplication with numeric values

    $stmt = $conn->prepare(
        "INSERT INTO mimosami_basket (productID, productName, quantity, price, itemTotal) VALUES (?, ?, ?, ?, ?)"
    );

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters with the appropriate types
    $stmt->bind_param("ssidd", $productID, $productName, $quantity, $price, $itemTotal);

    // Execute the statement and handle errors
    if ($stmt->execute()) {
        echo '<script>alert("Your item has been added to your basket");</script>';
        header("Location: ../view/Products.php");
        exit;

    } else {
        echo "<script>alert('Error: We could not add your item to your basket');</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
