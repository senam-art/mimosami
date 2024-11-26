<?php
include '../db/onlineconfig.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $basketItems = [];
    $basketQuant = [];
    $customerID = 1; 
    $total = isset($_SESSION['total']) ? $_SESSION['total'] : 0;

    $sql = "SELECT productID, quantity, price FROM mimosami_basket";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $basketItems[] = $row;
        }
    }

    if (!empty($basketItems)) {
        $stmt = $conn->prepare("INSERT INTO mimosami_order (customerID, productList, quantityList, total) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $productList = implode(',', array_column($basketItems, 'productID'));
            $quantityList = implode(',', array_column($basketItems, 'quantity'));

            $stmt->bind_param("issd", $customerID, $productList, $quantityList, $total);
            if (!$stmt->execute()) {
                echo "Error inserting order: " . $stmt->error;
                $stmt->close();
                $conn->close();
                exit();
            }

            $OrderID = $conn->insert_id;
            $stmt->close();
        } else {
            echo "Failed to prepare order statement: " . $conn->error;
            $conn->close();
            exit();
        }

        $productSalesStmt = $conn->prepare("INSERT INTO mimosami_productsales (OrderID, CustomerID, ProductID, Quantity, Amount) VALUES (?, ?, ?, ?, ?)");
        if ($productSalesStmt) {
            foreach ($basketItems as $item) {
                $productID = $item['productID'];
                $quantity = $item['quantity'];
                $price = $item['price'];
                $cost = $quantity * $price;

                $productSalesStmt->bind_param("iisss", $OrderID, $customerID, $productID, $quantity, $cost);
                if (!$productSalesStmt->execute()) {
                    echo "Error inserting product sales: " . $productSalesStmt->error;
                }
            }
            $productSalesStmt->close();
        } else {
            echo "Failed to prepare product sales statement: " . $conn->error;
            $conn->close();
            exit();
        }
        $clearBasketSQL = "DELETE FROM mimosami_basket";
        if (!$conn->query($clearBasketSQL)) {
            echo "Error clearing basket: " . $conn->error;
        }
    } else {

        echo "Basket is empty.";
    }
}

$conn->close();
header("Location: ../view/thankyou.html");
exit();
?>


