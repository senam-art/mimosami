<?php

require "../db/onlineconfig.php";

// Query to get the total number of suppliers
$totalSuppliersQuery = "SELECT COUNT(*) AS totalSuppliers FROM mimosami_supplier";
$resultTotal = $conn->query($totalSuppliersQuery);
$totalSuppliers = $resultTotal->fetch_assoc()['totalSuppliers'];

// Query to get the number of active suppliers
$activeSuppliersQuery = "SELECT COUNT(*) AS activeSuppliers FROM mimosami_supplier WHERE status = 'active' OR status = 'Active'";
$resultActive = $conn->query($activeSuppliersQuery);
$activeSuppliers = $resultActive->fetch_assoc()['activeSuppliers'];

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta name='viewport' content="width=device-width, initial-scale=1.0">
    <title>Supplier Dashboard</title>
    <link rel="icon" type="image/x-icon" href="xxx">
    <link rel="stylesheet" href="../assets/css/MimosamiStyle2.css">
    <link rel="stylesheet" href="../assets/css/suppliersdashboard.css">
    <script src="../assets/js/fetchSuppliers.js"></script>
    <script src="../assets/js/addSuppliers.js"></script>
    <script src="../assets/js/editSuppliers.js"></script>


    <style>
           #supplierListContainer {
        max-width: 100%;
        overflow-x: auto;  /* Enables horizontal scrolling if content overflows */
        }

        /* Styling for the table */
        #supplierTable {
            width: 100%;
            border-collapse: collapse;
        }

        #supplierTable th, #supplierTable td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        #supplierTable th {
            background-color: #f4f4f4;
        }

        #supplierTable tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        #supplierTable tr:hover {
            background-color: #f1f1f1;
        }



        /* Optional: Ensures responsiveness on smaller screens */
        @media (max-width: 768px) {
            #supplierTable {
                width: 100%; /* Makes sure the table fits the screen on mobile */
                font-size: 12px; /* Smaller font size for mobile screens */
            }
        }
        
    </style>
</head>
<body>
    <div class="grid-container-webpage-setup">
        <div class="item1">
            <div class="grid-container-2-columns">
                <div class="grid-item">
                    <h1 style="text-align:left">Supplier Dashboard</h1>
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
                <button class="menu"><a href="SalesDashboard.php">Sales</a></button><br>
                <button class="menu selected"><a href="SupplierDashboard.php">Suppliers</a></button><br>
                <button class="menu"><a href="InventoryDashboard.php">Inventory</a></button>
            </div>
        </div>
 
        <div class="item3">
            <h2>Supplier Management</h2>
            
            <!-- Action Buttons -->
            <div style="margin-bottom: 20px;">
                  <!-- Button to open the modal (For adding a new supplier) -->
                <button id="addSupplierButton">Add Supplier</button>
                <button class="btn btn-secondary" id="btnShowSupplierList">Hide Suppliers</button>
                
            </div>

           
            

            <!-- Add/Edit Modal -->
            <!-- Modal backdrop -->
        <div id="supplierModalBackdrop"></div>

        <!-- Add/Edit Modal -->
        <div id="supplierModal">
            <form id="supplierForm">
                <input type="hidden" name="id" id="supplierId">
                <label>Name:</label>
                <input type="text" name="name" id="supplierName" required>
                <label>Address:</label>
                <input type="address" name="address" id="supplierAddress" required>
                <label>Email:</label>
                <input type="email" name="email" id="supplierEmail" required>
                <label>Phone:</label>
                <input type="tel" name="phone" id="supplierPhone" required>
                <label>Status:</label>
                <select name="status" id="supplierStatus">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                <button type="submit">Save</button>
                <button type="button" id="btnCancel">Cancel</button>
            </form>
        </div>

      


                <!-- Supplier List -->
            <div id="supplierListContainer" class="form-container" style = display:block;>
                <h3>Supplier List</h3>
                <table id="supplierTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dynamically populated rows -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="item4">
            <p style="text-align: center;">Created by Power</p>
        </div>
    </div>

    <script>
        const showSupplierListButton = document.getElementById('btnShowSupplierList');
        const supplierListContainer = document.getElementById('supplierListContainer');

               
        showSupplierListButton.addEventListener('click', () => {
     
            if (supplierListContainer.style.display === 'block') {
                supplierListContainer.style.display = 'none'; // Hide the supplier list
                showSupplierListButton.textContent = 'Show Suppliers'; // Update button text
            } else {
                supplierListContainer.style.display = 'block'; // Show the supplier list
                showSupplierListButton.textContent = 'Hide Suppliers'; // Update button text
            }
        });

      //Add/edit supplier
      // DOM Elements
        const supplierModal = document.getElementById('supplierModal');
        const supplierModalBackdrop = document.getElementById('supplierModalBackdrop');
        const btnCancel = document.getElementById('btnCancel');
        const supplierForm = document.getElementById('supplierForm');
        
        // Function to fetch supplier data and populate the table
        // Function to fetch supplier data and populate the table
    function fetchSuppliers() {
        fetch('../actions/suppliers.php')  // Replace with your actual API endpoint
            .then(response => response.json())  // Parse the JSON response
            .then(data => {
                const supplierTableBody = document.querySelector('#supplierTable tbody');
                supplierTableBody.innerHTML = '';  // Clear existing table rows

                if (data.length === 0) {
                    supplierTableBody.innerHTML = '<tr><td colspan="5">No suppliers found.</td></tr>';
                } else {
                    // Loop through each supplier and create a new table row
                    data.forEach(supplier => {
                        const row = document.createElement('tr');
                        
                        row.innerHTML = `
                            <td>${supplier.SupplierID}</td>
                            <td>${supplier.SupplierName}</td>
                            <td>${supplier.Email}</td>
                            <td>${supplier.PhoneNumber}</td>
                            <td>${supplier.Status}</td>
                            <td>
                                <button class="editButton" data-id="${supplier.SupplierID}">Edit</button>
                                <button class="deleteButton" data-id="${supplier.SupplierID}">Delete</button>
                            </td>
                        `;

                        supplierTableBody.appendChild(row);
                    });

                    // Add event listeners for Edit and Delete buttons
                    const editButtons = document.querySelectorAll('.editButton');
                    editButtons.forEach(button => {
                        button.addEventListener('click', handleEdit);
                    });

                    const deleteButtons = document.querySelectorAll('.deleteButton');
                    deleteButtons.forEach(button => {
                        button.addEventListener('click', handleDelete);
                    });
                }
            })
            .catch(error => {
                console.error('Error fetching supplier data:', error);
                alert('There was an error fetching supplier data.');
            });
    }


    // Fetch suppliers when the page loads
    window.onload = fetchSuppliers;


    /*Editing Suppliers
    */ 
    // Fetch supplier details for editing
    function fetchSupplierDetails(id) {
    fetch(`../actions/supplier.php?id=${id}`, {
        method: 'GET',
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
        console.error("Error fetching supplier:", data.error);
        } else {
        // Populate the form fields with the fetched supplier data
        document.getElementById('supplierName').value = data.SupplierName;
        document.getElementById('supplierEmail').value = data.Email;
        document.getElementById('supplierAddress').value = data.Address;
        document.getElementById('supplierPhone').value = data.PhoneNumber;
        document.getElementById('supplierStatus').value = data.Status;
        }
    })
    .catch(error => console.error('Error:', error));
    }

    // Update supplier details
    function updateSupplier(id) {
    const updatedSupplier = {
        id: id,
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        address: document.getElementById('address').value,
        phone: document.getElementById('phone').value,
        status: document.getElementById('status').value
    };

    fetch('../actions/suppliers.php', {
        method: 'PUT',
        headers: {
        'Content-Type': 'application/json'
        },
        body: JSON.stringify(updatedSupplier)
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
        console.error("Error updating supplier:", data.error);
        // Handle error, maybe display a message to the user
        } else {
        alert('Supplier updated successfully');
        // Optionally redirect or reset the form
        }
    })
    .catch(error => console.error('Error:', error));
    }

    // Function to handle edit button click event
    function handleEditButtonClick(event) {
        // Get supplier ID from the button's data-id attribute
        const supplierId = event.target.getAttribute('data-id');

        if (!supplierId) {
            console.error('No supplier ID provided');
            return;
        }

        // Fetch the supplier details
        fetchSupplierDetails(supplierId);

        // Add event listener for the update button once the modal/form is shown
        document.getElementById('updateButton').addEventListener('click', () => {
            // Call the update function to send the updated data
            updateSupplier(supplierId);
        });
        }


        // Handle Delete Button
    function handleDelete(event) {
        const supplierId = event.target.getAttribute('data-id');
        
        // Ask for confirmation before deletion
        if (confirm('Are you sure you want to delete this supplier?')) {
            // Send DELETE request to delete the supplier
            fetch(`../actions/supplier.php?id=${supplierId}`, {
                method: 'DELETE',  // Use 'DELETE' for deleting the supplier
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Supplier deleted successfully!');
                    fetchSuppliers(); // Refresh the supplier list
                } else {
                    alert('Failed to delete supplier!');
                }
            })
            .catch(error => {
                console.error('Error deleting supplier:', error);
                alert('An error occurred while deleting the supplier.');
            });
        }
    }

        

        // Show Modal Function
        function showModal() {
            supplierModal.style.display = 'block';
            supplierModalBackdrop.style.display = 'block';
        }

        // Hide Modal Function
        function hideModal() {
            supplierModal.style.display = 'none';
            supplierModalBackdrop.style.display = 'none';
        }

        // Open modal when needed (e.g., for editing or adding)
        document.getElementById('addSupplierButton').addEventListener('click', () => {
            // Reset form for adding new supplier
            supplierForm.reset();
            document.getElementById('supplierId').value = ''; // Clear the ID
            showModal();
        });

        // Close modal when cancel button is clicked
        btnCancel.addEventListener('click', () => {
            hideModal();
        });


        //Adding a new supplier 
        supplierForm.addEventListener('submit', (event) => {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(supplierForm);
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });

         // Remove the 'id' field from the data object
        delete data.id;

        // Print the data object to the console
        console.log(data);

        fetch('../actions/suppliers.php', {
            method: 'POST', // Use 'PUT' for editing existing supplier
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data), // Send data as JSON
        })
        .then((response) => response.json())
        .then((data) => {
            console.log(data);  // Log the server response
            if (data.success) {
                alert('Supplier saved successfully!');
                hideModal();
                fetchSuppliers();  // Optionally, refresh the supplier list
            } else {
                alert('Failed to save supplier!');
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('Failed to save supplier: ' + data.error);
        });
    });






    </script>


</body>
</html>