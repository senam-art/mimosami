<?php
session_start();

require "../db/onlineconfig.php";

//Fetch items from the database
$query = "SELECT ItemId, Item Name,Cost,Supplier ID,status FROM inventory"; // Replace 'inventory' with your table name
$result = $conn->query($query);
?>




<!DOCTYPE html>
<html>
<head>
	<meta name='viewport' content="width=device-width inital-scale=1.0">
	<title>Inventory Dashboard</title>
	<link rel="icon" type="image/x-icon" href="xxx">
    <link rel="stylesheet" href="..\assets\css\MimosamiStyle2.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"> <!--DataTables CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> <!-- DataTables JS -->
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
            <button class="menu"><a href ="SalesDashboard.php">Sales</a></button><br>
            <button class="menu"><a href ="OrderDashboard.php"></a>Order</button><br>
            <button class="menu selected"><a href ="InventoryDashboard.php"></a>Inventory</button>
            </div>
        </div>
 
        <div class="item3">
            <div class="grid-container-3-columns">
                <div class="grid-item" id="card">
                    <p style="font-size:13px">Total Inventory Value</p>
                    <p style="font-weight:600;font-size:20px;color:#855363">GHC 2,000</p>
                </div>

                <div class="grid-item" id="card">
                    <p style="font-size:13px">Alerts</p>  
                    <p style="font-weight:600;font-size:20px;color:#bd4444">150</p>                  
                </div>

                <div class="grid-item" id="card">
                    <p style="font-size:13px">Total Items</p>
                    <p style="font-weight:600;font-size:20px;color:#855363">500</p>                   
                </div>

        </div>


                <table>

                    <tr>
                        <th>ID</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    <tr>
                        <td>001</td>
                        <td>Flour</td>
                        <td>30</td>
                        <td>Good</td>
                        <td>
                            <button class="action">Edit</button>
                            <button class="action">Restock</button>
                        </td>
                    </tr>
                    <tr>
                        <td>001</td>
                        <td>Flour</td>
                        <td>30</td>
                        <td>Good</td>
                        <td>
                            <button class="action">Edit</button>
                            <button class="action">Restock</button>
                        </td>
                    </tr>

                </table>

            </div>
            
 
        
        <div class="item4">
            <p style="text-align: center;">Created by Power</p>
        <div>

    </div>

</body>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Add event listeners to Edit buttons
        const editButtons = document.querySelectorAll("button.action:nth-child(1)");
        editButtons.forEach(button => {
            button.addEventListener("click", (event) => {
                const row = event.target.closest("tr");
                const itemCell = row.children[1]; // Assuming "Item" is the second column
                const quantityCell = row.children[2]; // Assuming "Quantity" is the third column
                
                // If the button is in "Save" mode, save the changes
                if (button.textContent === "Save") {
                    const newItemName = itemCell.querySelector("input").value;
                    const newQuantity = quantityCell.querySelector("input").value;
                    
                    // Update the table with new values
                    itemCell.textContent = newItemName;
                    quantityCell.textContent = newQuantity;
                    
                    // Revert the button text back to "Edit"
                    button.textContent = "Edit";
                } else {
                    // If the button is in "Edit" mode, replace text with input fields for editing
                    const itemName = itemCell.textContent;
                    const quantityValue = quantityCell.textContent;
                    
                    itemCell.innerHTML = `<input type="text" value="${itemName}">`;
                    quantityCell.innerHTML = `<input type="number" value="${quantityValue}">`;
                    
                    // Change the button text to "Save"
                    button.textContent = "Save";
                }
            });
        });

        // Add event listeners to Restock buttons
        const restockButtons = document.querySelectorAll("button.action:nth-child(2)");
        restockButtons.forEach(button => {
            button.addEventListener("click", () => {
                alert("The supplier has been contacted for restocking!");
            });
        });
    });
</script>
 

    


</html>