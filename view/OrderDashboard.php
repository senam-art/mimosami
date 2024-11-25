<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

require "../db/onlineconfig.php";


// Fetch suppliers from the database
$query = "SELECT SupplierID, SupplierName FROM mimosami_supplier"; 
$result = $conn->query($query);
    

?>


<!DOCTYPE html>
<html>
<head>
	<meta name='viewport' content="width=device-width initial-scale=1.0">
	<title>Order Dashboard</title>
	<link rel="icon" type="image/x-icon" href="xxx">
    <link rel="stylesheet" href="../assets/css/MimosamiStyle2.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"> <!--DataTables CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> <!-- DataTables JS -->
</head>

<body>

    <div class="grid-container-webpage-setup">
        
        <div class="item1">
            <div class="grid-container-2-columns">
                <div class="grid-item">
                    <h1 style="text-align:left">Order Dashboard</h1>
                    <p style="text-align:left">Welcome to your Order</p>
                </div>
                <div class="grid-item" style="text-align: right;">
                    <input type="text" placeholder="Search..">
                    <img src="../assets/images/profile.png" alt="Profile" style="width:100%;max-width:50px">
                </div>
            </div>
        </div>

        <div class="item2b">
            <img src="../assets/logo/MimosamiLogo.png" alt="MimosamiLogo" style="width:100%;max-width:100px">
        </div>

        <div class="item2">
            <div class="menu-container">
            <button class="menu"><a href ="SalesDashboard.php">Sales</a></button><br>
            <button class="menu selected"><a href ="OrderDashboard.php"></a>Order</button><br>
            <button class="menu"><a href ="InventoryDashboard.php"></a>Inventory</button>
            </div>
        </div>
 
        <div class="item3">
            <h2>Select your supplier</h2>
            <select id="supplierDropdown">
                <option value="">Select a supplier</option>
                <?php
                //Populate dropdown with list of suppliers
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row['SupplierID']) . "'>" . htmlspecialchars($row['SupplierName']) . "</option>";
                    }
                } else {
                    echo "<option value=''>No suppliers found</option>";
                }
                ?>
            </select>
            <br>
            <br>
            <div>
                <button class="action-button" onclick="addSupplier()">Add Supplier</button>
                <button class="action-button" onclick="editSupplier()">Edit Supplier</button>
            </div>
            <br>
            <!-- Add a Supplier Form -->
            <div id = "addSupplierForm" style = display:none;>
                <form method = "POST" >
                    <label for  = "supplier_name">Supplier Name</label>
                    <input type = "text" id = "supplier_name" name = "supplier_name" required>
                    <br>
                    <br>

                    <label for  = "phone_number">Phone Number</label>
                    <input type = "text" id = "phone_number" name = "phone_number" required>
                    <br>
                    <br>

                    <label for  = "supplier_address">Address:</label>
                    <input type = "text" id = "supplier_address" name = "supplier_address" required>
                    <br>

                    <button type = "submit" name="add_supplier">Save</button>
                    <button type ="button" onclick = "closeAddSupplierForm()">Cancel</button>
            </div>

            <!-- Edit Supplier Form -->
             <!-- Edit Supplier Form (Initial display hidden) -->
            <div id="editSupplierForm" style="display:none;">
                <form method="POST" >
                    <input type="hidden" id="supplier_id" name="supplier_id">
                    
                    <label for="edit_supplier_name">Supplier Name</label>
                    <input type="text" id="edit_supplier_name" name="supplier_name" required>
                    <br>

                    <label for="edit_contact_info">Contact Information</label>
                    <input type="text" id="edit_contact_info" name="contact_info" required>
                    <br>

                    <button type="submit" name="edit_supplier">Update Supplier</button>
                    <button type="button" onclick="closeEditSupplierForm()">Cancel</button>
                </form>
            </div>


<script>
     function editSupplier() {
        const supplierId = document.getElementById('supplierDropdown').value;
        if (supplierId) {
            // Fetch supplier details via Ajax
            fetchSupplierDetails(supplierId);
        } else {
            alert('Please select a supplier to edit.');
        }
    }


    function fetchSupplierDetails(supplierId) {
        // Fetch supplier data using Ajax
        fetch('get_supplier_details.php?id=' + supplierId)
            .then(response => response.json())
            .then(data => {
                // Populate the form with existing supplier data
                document.getElementById('supplier_id').value = data.id;
                document.getElementById('edit_supplier_name').value = data.supplier_name;
                document.getElementById('edit_contact_info').value = data.contact_info;
                document.getElementById('editSupplierForm').style.display = 'block'; // Show the edit form
            })
            .catch(error => alert('Error fetching supplier details: ' + error));
    }

    function closeEditSupplierForm() {
        document.getElementById('editSupplierForm').style.display = 'none'; // Close the edit form without submitting
    }
</script>


          
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

        </div>
            
 
        
        <div class="item4">
            <p style="text-align: center;">Created by Power</p>
        <div>

    </div>

</body>

<script>
    function addSupplier() {
        document.getElementById('addSupplierForm').style.display = 'block'; // Show the add supplier form
        }

    function closeAddSupplierForm(){
        document.getElementById('addSupplierForm').style.display = 'none'; // Close the form without submitting
    }


    function editSupplier() {
        const supplierId = document.getElementById('supplierDropdown').value;
        if (supplierId) {
            alert('Edit Supplier functionality coming soon for Supplier ID: ' + supplierId);
        } else {
                alert('Please select a supplier to edit.');
        }
    }

    function fetchSupplierDetails(supplierId) {
        // Fetch supplier data using Ajax
        fetch('get_supplier_details.php?id=' + supplierId)
            .then(response => response.json())
            .then(data => {
                // Populate the form with existing supplier data
                document.getElementById('supplier_id').value = data.id;
                document.getElementById('edit_supplier_name').value = data.supplier_name;
                document.getElementById('edit_contact_info').value = data.contact_info;
                document.getElementById('editSupplierForm').style.display = 'block'; // Show the edit form
            })
            .catch(error => alert('Error fetching supplier details: ' + error));
    }

    function closeEditSupplierForm() {
        document.getElementById('editSupplierForm').style.display = 'none'; // Close the edit form without submitting
    }



</script>


</html>