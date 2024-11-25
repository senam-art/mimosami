<?php
include '../db/onlineconfig.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productID = htmlspecialchars($_POST['productID'] ?? '');
    $productName = htmlspecialchars($_POST['productName'] ?? '');
    $quantity = htmlspecialchars($_POST['quantity'] ?? 0);
    $price = htmlspecialchars($_POST['price'] ?? 0);
    $itemTotal = htmlspecialchars($price * $quantity);

    $stmt = $conn->prepare(
        "INSERT INTO mimosami_basket (productID, productName, quantity, price, itemTotal) VALUES (?, ?, ?, ?, ?)"
    );

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssidd", $productID, $productName, $quantity, $price, $itemTotal);

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


