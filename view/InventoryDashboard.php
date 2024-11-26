<?php
session_start();
require "../db/onlineconfig.php"; // Include the database configuration

// Function to fetch inventory items
function fetchInventoryItems($conn) {
    $query = "SELECT ItemID, ItemName, Quantity FROM mimosami_inventory";
    $result = $conn->query($query);
    $items = [];
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        $result->free();
    }
    
    return $items;
}

// For the different request methods
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the raw POST data and decode it
    $input = json_decode(file_get_contents("php://input"), true);

    // Validate input
    if (isset($input['id'], $input['name'], $input['quantity']) &&
        !empty($input['id']) && !empty($input['name']) && is_numeric($input['quantity'])) {

        $ItemID = $conn->real_escape_string($input['id']);
        $ItemName = $conn->real_escape_string($input['name']);
        $Quantity = (int)$input['quantity'];

        // Prepare the SQL statement
        $query = "UPDATE mimosami_inventory SET ItemName = ?, Quantity = ? WHERE ItemID = ?";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("sii", $ItemName, $Quantity, $ItemID);

            // Execute the query
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "Item updated successfully"]);
            } else {
                echo json_encode(["success" => false, "error" => "Database update failed: " . $stmt->error]);
            }

            $stmt->close();
        } else {
            echo json_encode(["success" => false, "error" => "Failed to prepare statement: " . $conn->error]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "Invalid input data"]);
    }
    exit; // Stop further execution for AJAX requests
}

// Fetch inventory items for the page
$inventoryItems = fetchInventoryItems($conn);

// Calculate total inventory value and other metrics
$totalValue = 0;
$totalItems = count($inventoryItems);
$lowStockAlerts = 0;

foreach ($inventoryItems as $item) {
    // Assuming each item has a default price - you'd replace this with actual pricing logic
    $itemPrice = 10; // Example fixed price
    $totalValue += $item['Quantity'] * $itemPrice;
    
    // Count low stock items (less than 10)
    if ($item['Quantity'] < 10) {
        $lowStockAlerts++;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name='viewport' content="width=device-width initial-scale=1.0">
    <title>Inventory Dashboard</title>
    <link rel="icon" type="image/x-icon" href="xxx">
    <link rel="stylesheet" href="..\assets\css\MimosamiStyle2.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <div class="grid-container-webpage-setup">
        <div class="item1">
            <div class="grid-container-2-columns">
                <div class="grid-item">
                    <h1 style="text-align:left">Dashboard</h1>
                    <p style="text-align:left">Welcome to your Inventory</p>
                </div>
                <div class="grid-item" style="text-align: right;">
                    <input type="text" placeholder="Search..">
                    <img src="..\assets\images\profile.png" alt="Profile" style="width:100%;max-width:50px">
                </div>
            </div>
        </div>

        <div class="item2b">
            <img src="..\assets\logo\MimosamiLogo.png" alt="MimosamiLogo" style="width:100%;max-width:100px">
        </div>

        <div class="item2">
            <div class="menu-container">
                <button class="menu"><a href="..\view\SalesDashboard.php">Sales</a></button><br>
                <button class="menu"><a href="OrderDashboard.php">Order</a></button><br>
                <button class="menu selected"><a href="InventoryDashboard.php">Inventory</a></button>
            </div>
        </div>
 
        <div class="item3">
            <div class="grid-container-3-columns">
                <div class="grid-item" id="card">
                    <p style="font-size:13px">Total Inventory Value</p>
                    <p style="font-weight:600;font-size:20px;color:#855363">GHC <?php echo number_format($totalValue, 2); ?></p>
                </div>

                <div class="grid-item" id="card">
                    <p style="font-size:13px">Low Stock Alerts</p>  
                    <p style="font-weight:600;font-size:20px;color:#bd4444"><?php echo $lowStockAlerts; ?></p>                  
                </div>

                <div class="grid-item" id="card">
                    <p style="font-size:13px">Total Items</p>
                    <p style="font-weight:600;font-size:20px;color:#855363"><?php echo $totalItems; ?></p>                   
                </div>
            </div>

            <table id="inventoryTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inventoryItems as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['ItemID']); ?></td>
                        <td><?php echo htmlspecialchars($item['ItemName']); ?></td>
                        <td><?php echo htmlspecialchars($item['Quantity']); ?></td>
                        <td>
                            <button class="action edit-btn">Edit</button>
                            <button class="action restock-btn">Restock</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="item4">
            <p style="text-align: center;">Created by Power</p>
        </div>
    </div>

    <script>
document.addEventListener("DOMContentLoaded", () => {
    // Initialize DataTable with disabled features
    $('#inventoryTable').DataTable({
        "paging": false,        // So the pagination does not show
        "searching": false,     // So the search box does not show
        "info": false,         
        "lengthChange": false   
    });

    // Event delegation for buttons in the table
    document.querySelector("#inventoryTable tbody").addEventListener("click", (event) => {
        const button = event.target;
        const row = button.closest("tr");

        if (!row) return; // Ensure the click is on a valid table row

        // Restock Button Handler
        if (button.classList.contains("restock-btn")) {
            alert("The supplier will be contacted for restocking!");
            return;
        }

        // Edit Button Handler
        if (button.classList.contains("edit-btn")) {
            const itemCell = row.children[1]; // Item name cell
            const quantityCell = row.children[2]; // Quantity cell

            const itemName = itemCell.textContent;
            const quantityValue = quantityCell.textContent;

            // Enter edit mode
            itemCell.innerHTML = `<input type="text" value="${itemName}">`;
            quantityCell.innerHTML = `<input type="number" value="${quantityValue}">`;

            button.textContent = "Save";
            button.classList.remove("edit-btn");
            button.classList.add("save-btn");
        } 
        // Save Button Handler
        else if (button.classList.contains("save-btn")) {
            const itemID = row.children[0].textContent; // ID is in the first column
            const itemCell = row.children[1];
            const quantityCell = row.children[2];

            const newItemName = itemCell.querySelector("input").value;
            const newQuantity = quantityCell.querySelector("input").value;

            // Send updated data to the server
            fetch("InventoryDashboard.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    id: itemID,
                    name: newItemName,
                    quantity: newQuantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the table with new values
                    itemCell.textContent = newItemName;
                    quantityCell.textContent = newQuantity;
                    
                    const button = row.querySelector(".save-btn");
                    button.textContent = "Edit";
                    button.classList.remove("save-btn");
                    button.classList.add("edit-btn");

                    alert("Item updated successfully!");
                }
            });
        }
    });
});
</script>
</body>
</html>
<?php
$conn->close(); // Close the database connection
?>