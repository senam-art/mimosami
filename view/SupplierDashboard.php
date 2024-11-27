<?php
include '../db/onlineconfig.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta name='viewport' content="width=device-width, initial-scale=1.0">
    <title>Supplier Dashboard</title>
    <link rel="icon" type="image/x-icon" href="../assets/favicon/mimosamifav.ico">
    <link rel="stylesheet" href="../assets/css/MimosamiStyle2.css">
    <link rel="stylesheet" href="../assets/css/suppliersdashboard.css">

    <style>
        #supplierListContainer {
            max-width: 100%;
            overflow-x: auto;
        }

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

        /* Modal Styles */
        #supplierModal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            width: 300px;
        }

        #supplierModalBackdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        #supplierForm {
            display: flex;
            flex-direction: column;
        }

        #supplierForm label {
            margin-top: 10px;
        }

        #supplierForm input,
        #supplierForm select {
            margin-bottom: 10px;
            padding: 8px;
        }

        button {
            padding: 8px;
            cursor: pointer;
        }

        button[type="submit"] {
            background-color: #855363;
            color: white;
            border: none;
            border-radius: 4px;
        }

        #btnCancel {
            background-color: #657585;
            color: white;
            border: none;
            border-radius: 4px;
        }

        #supplierTable button:nth-child(1) {
            background-color: #2196F3;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 6px 12px;
            margin: 0 4px;
        }

        #supplierTable button:nth-child(2) {
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 6px 12px;
            margin: 0 4px;
        }

        @media (max-width: 768px) {
            #supplierTable {
                font-size: 12px;
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
                <button class="menu"><a href="..\view\SalesDashboard.php">Sales</a></button><br>
                <button class="menu"><a href="..\view\OrderDashboard.php">Orders</a></button><br>
                <button class="menu"><a href="InventoryDashboard.php">Inventory</a></button>
                <button class="menu selected"><a href="..\view\SupplierDashboard.php">Supplier</a></button>
            </div>
        </div>

        <div class="item3">
            <h2>Supplier Management</h2>
            
            <!-- Action Buttons -->
            <div style="margin-bottom: 20px;">
                <button id="addSupplierButton" style="background-color: #855363";> Add Supplier</button>
                <button class="btn btn-secondary" id="btnShowSupplierList" style="background-color: #7c8691";>Hide Suppliers</button>
            </div>

            <!-- Supplier Statistics -->
            <div class="grid-container-2-columns">
                <div class="grid-item" id="card">
                    <p style="font-size:13px">Total Suppliers</p>
                    <p style="font-weight:600;font-size:20px;color:#855363" id="totalSuppliersCount">0</p>
                </div>
            
                <div class="grid-item" id="card">
                    <p style="font-size:13px">Active Suppliers</p>
                    <p style="font-weight:600;font-size:20px;color:#855363" id="activeSuppliersCount">0</p>                   
                </div>
            </div>

            <!-- Modal backdrop -->
            <div id="supplierModalBackdrop"></div>

            <!-- Supplier Modal -->
            <div id="supplierModal">
                <h3>Add/Edit Supplier</h3>
                <form id="supplierForm">
                    <input type="hidden" name="id" id="supplierId">
                    
                    <label for="supplierName">Name:</label>
                    <input type="text" name="name" id="supplierName" required>
                    
                    <label for="supplierEmail">Email:</label>
                    <input type="email" name="email" id="supplierEmail" required>
                    
                    <label for="supplierAddress">Address:</label>
                    <input type="text" name="address" id="supplierAddress" required>
                    
                    <label for="supplierPhone">Phone:</label>
                    <input type="tel" name="phone" id="supplierPhone" required>
                    
                    <label for="supplierStatus">Status:</label>
                    <select name="status" id="supplierStatus">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    
                    <button type="submit">Save</button>
                    <button type="button" id="btnCancel">Cancel</button>
                </form>
            </div>

            <!-- Supplier List -->
            <div id="supplierListContainer" class="form-container" style="display:block;">
                <h3>Supplier List</h3>
                <table id="supplierTable">
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
                        <!-- Will be populated by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>

        <div class="item4">
            <p style="text-align: center;">Created by Power</p>
        </div>
    </div>

    <script>
        // Your existing JavaScript with working CRUD
        const supplierModal = document.getElementById('supplierModal');
        const supplierModalBackdrop = document.getElementById('supplierModalBackdrop');
        const supplierForm = document.getElementById('supplierForm');
        const btnCancel = document.getElementById('btnCancel');
        const addSupplierButton = document.getElementById('addSupplierButton');
        const btnShowSupplierList = document.getElementById('btnShowSupplierList');
        const supplierListContainer = document.getElementById('supplierListContainer');

        function fetchSuppliers() {
            fetch('../actions/suppliers.php')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('#supplierTable tbody');
                    tbody.innerHTML = '';

                    // Update statistics
                    const totalSuppliers = data.length;
                    const activeSuppliers = data.filter(s => s.Status.toLowerCase() === 'active').length;
                    
                    document.getElementById('totalSuppliersCount').textContent = totalSuppliers;
                    document.getElementById('activeSuppliersCount').textContent = activeSuppliers;

                    data.forEach(supplier => {
                        tbody.innerHTML += `
                            <tr>
                                <td>${supplier.SupplierID}</td>
                                <td>${supplier.SupplierName}</td>
                                <td>${supplier.Email}</td>
                                <td>${supplier.PhoneNumber}</td>
                                <td>${supplier.Status}</td>
                                <td>
                                    <button onclick="handleEdit(${supplier.SupplierID})">Edit</button>
                                    <button onclick="handleDelete(${supplier.SupplierID})">Delete</button>
                                </td>
                            </tr>
                        `;
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading suppliers');
                });
        }

        function showModal() {
            supplierModal.style.display = 'block';
            supplierModalBackdrop.style.display = 'block';
        }

        function hideModal() {
            supplierModal.style.display = 'none';
            supplierModalBackdrop.style.display = 'none';
            supplierForm.reset();
            document.getElementById('supplierId').value = '';
        }

        function handleEdit(id) {
            fetch(`../actions/suppliers.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('supplierId').value = data.SupplierID;
                    document.getElementById('supplierName').value = data.SupplierName;
                    document.getElementById('supplierEmail').value = data.Email;
                    document.getElementById('supplierAddress').value = data.Address;
                    document.getElementById('supplierPhone').value = data.PhoneNumber;
                    document.getElementById('supplierStatus').value = data.Status;
                    showModal();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading supplier details');
                });
        }

        function handleDelete(id) {
            if (confirm('Are you sure you want to delete this supplier?')) {
                fetch(`../actions/suppliers.php?id=${id}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Supplier deleted successfully');
                        fetchSuppliers();
                    } else {
                        alert(data.message || 'Error deleting supplier');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting supplier');
                });
            }
        }

        supplierForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(supplierForm);
            const data = {};
            formData.forEach((value, key) => data[key] = value);

            const id = document.getElementById('supplierId').value;
            const method = id ? 'PUT' : 'POST';

            fetch('../actions/suppliers.php', {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    alert(result.message);
                    hideModal();
                    fetchSuppliers();
                } else {
                    alert(result.message || 'Error saving supplier');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error saving supplier');
            });
        });

        addSupplierButton.addEventListener('click', () => {
            supplierForm.reset();
            document.getElementById('supplierId').value = '';
            showModal();
        });

        btnCancel.addEventListener('click', hideModal);
        supplierModalBackdrop.addEventListener('click', hideModal);

        btnShowSupplierList.addEventListener('click', () => {
            const isVisible = supplierListContainer.style.display !== 'none';
            supplierListContainer.style.display = isVisible ? 'none' : 'block';
            btnShowSupplierList.textContent = isVisible ? 'Show Suppliers' : 'Hide Suppliers';
        });

        // Initial load
        fetchSuppliers();
    </script>
</body>
</html>