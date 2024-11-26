<?php
// Start the session and include the database connection
session_start();
require "../db/onlineconfig.php";

// Fetch orders from the database
$sql = "SELECT orderID, customerID, productList, quantityList, createdAt, total FROM mimosami_order";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Dashboard</title>
    <link rel="icon" type="image/x-icon" href="xxx">
    <link rel="stylesheet" href="..\assets\css\MimosamiStyle2.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <div class="grid-container-webpage-setup">
        <!-- Header Section -->
        <div class="item1">
            <div class="grid-container-2-columns">
                <div class="grid-item">
                    <h1 style="text-align:left">Orders Dashboard</h1>
                    <p style="text-align:left">Welcome to your Order Management</p>
                </div>
                <div class="grid-item" style="text-align: right;">
                    <input type="text" placeholder="Search..">
                    <img src="..\assets\images\profile.png" alt="Profile" style="width:100%;max-width:50px">
                </div>
            </div>
        </div>

        <!-- Logo Section -->
        <div class="item2b">
            <img src="..\assets\logo\MimosamiLogo.png" alt="MimosamiLogo" style="width:100%;max-width:100px">
        </div>

        <!-- Sidebar Menu -->
        <div class="item2">
            <div class="menu-container">
                <button class="menu"><a href="..\view\SalesDashboard.php">Sales</a></button><br>
                <button class="menu selected"><a href="OrderDashboard.php">Orders</a></button><br>
                <button class="menu"><a href="InventoryDashboard.php">Inventory</a></button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="item3">
            <table id="orderTable">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer ID</th>
                        <th>Product List</th>
                        <th>Quantity List</th>
                        <th>Created At</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['orderID']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['customerID']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['productList']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['quantityList']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['createdAt']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['total']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No orders found</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Footer Section -->
        <div class="item4">
            <p style="text-align: center;">Created by Power</p>
        </div>
    </div>

    <!-- DataTable Initialization -->
    <script>
    document.addEventListener("DOMContentLoaded", () => {
    // Initialize DataTable with disabled features
    $('#inventoryTable').DataTable({
        "paging": false,        // So the pagination does not show
        "searching": false,     // So the search box does not show
        "info": false,         
        "lengthChange": false   
    });
        $(document).ready(function () {
            $('#orderTable').DataTable();
        });
    </script>
</body>
</html>

