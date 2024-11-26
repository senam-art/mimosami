<!DOCTYPE html>
<html>
<head>
    <meta name='viewport' content="width=device-width, initial-scale=1.0">
    <title>Supplier Dashboard</title>
    <link rel="icon" type="image/x-icon" href="xxx">
    <link rel="stylesheet" href="../assets/css/MimosamiStyle2.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <style>
        /* Additional styles for form containers */
        .form-container {
            display: none;
            background-color: #f4f4f4;
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
        }
        .form-container.active {
            display: block;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, 
        .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .btn {
            padding: 10px 15px;
            background-color: #855363;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }
        .btn-secondary {
            background-color: #6c757d;
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
                <button class="menu"><a href="InventoryDashbaord.html">Inventory</a></button>
            </div>
        </div>
 
        <div class="item3">
            <h2>Supplier Management</h2>
            
            <!-- Action Buttons -->
            <div style="margin-bottom: 20px;">
                <button class="btn" id="btnShowAddSupplier">Add Supplier</button>
                <button class="btn" id="btnShowEditSupplier">Edit Supplier</button>
                <button class="btn btn-secondary" id="btnShowSupplierList">Supplier List</button>
            </div>

            <!-- Supplier Statistics -->
            <div class="grid-container-3-columns">
                <div class="grid-item" id="card">
                    <p style="font-size:13px">Total Suppliers</p>
                    <p style="font-weight:600;font-size:20px;color:#855363" id="totalSuppliersCount">0</p>
                </div>
                <div class="grid-item" id="card">
                    <p style="font-size:13px">Alerts</p>  
                    <p style="font-weight:600;font-size:20px;color:#bd4444" id="supplierAlertsCount">0</p>                  
                </div>
                <div class="grid-item" id="card">
                    <p style="font-size:13px">Active Suppliers</p>
                    <p style="font-weight:600;font-size:20px;color:#855363" id="activeSuppliersCount">0</p>                   
                </div>
            </div>

            <!-- Add Supplier Form -->
            <div id="addSupplierForm" class="form-container">
                <h3>Add New Supplier</h3>
                <form id="supplierAddForm">
                    <div class="form-group">
                        <label>Supplier Name</label>
                        <input type="text" name="supplierName" required>
                    </div>
                    <div class="form-group">
                        <label>Contact Email</label>
                        <input type="email" name="supplierEmail" required>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" name="supplierPhone" required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="supplierStatus">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn">Save Supplier</button>
                    <button type="button" class="btn btn-secondary" id="btnCancelAdd">Cancel</button>
                </form>
            </div>

            <!-- Edit Supplier Form -->
            <div id="editSupplierForm" class="form-container">
                <h3>Edit Existing Supplier</h3>
                <form id="supplierEditForm">
                    <div class="form-group">
                        <label>Select Supplier</label>
                        <select id="supplierEditSelect" name="supplierId" required>
                            <option value="">Choose Supplier</option>
                            <!-- Dynamically populated options -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Supplier Name</label>
                        <input type="text" name="supplierName" required>
                    </div>
                    <div class="form-group">
                        <label>Contact Email</label>
                        <input type="email" name="supplierEmail" required>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" name="supplierPhone" required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="supplierStatus">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn">Update Supplier</button>
                    <button type="button" class="btn btn-secondary" id="btnCancelEdit">Cancel</button>
                </form>
            </div>

            <!-- Supplier List -->
            <div id="supplierListContainer" class="form-container">
                <h3>Supplier List</h3>
                <table id="supplierTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dynamically populated rows -->
                    </tbody>
                </table>
            </div>
        </div>
            
        <div class="item4">
            <p style="text-align: center;">Created by Power</p>
        </div>
    </div>

    
   <script>
    $(document).ready(function() {
        // Function to load supplier statistics
        function loadSupplierStatistics() {
            $.ajax({
                url: '../actions/supplier_handler.php',
                method: 'POST',
                data: { action: 'get_supplier_stats' },
                dataType: 'json',
                success: function(response) {
                    $('#totalSuppliersCount').text(response.total_suppliers);
                    $('#activeSuppliersCount').text(response.active_suppliers);
                },
                error: function() {
                    alert('Failed to load supplier statistics');
                }
            });
        }

        // Function to load suppliers
        function loadSuppliers(search = '', page = 1) {
            $.ajax({
                url: '../actions/supplier_handler.php',
                method: 'POST',
                data: { 
                    action: 'get_suppliers', 
                    search: search, 
                    page: page 
                },
                dataType: 'json',
                success: function(response) {
                    // Clear existing table rows
                    $('#supplierTable tbody').empty();
                    
                    // Populate table
                    response.suppliers.forEach(function(supplier) {
                        $('#supplierTable tbody').append(`
                            <tr>
                                <td>${supplier.SupplierID}</td>
                                <td>${supplier.SupplierName}</td>
                                <td>${supplier.PhoneNumber}</td>
                                <td>${supplier.Address}</td>
                                <td>${supplier.IsActive ? 'Active' : 'Inactive'}</td>
                            </tr>
                        `);
                    });

                    // Update pagination
                    // (You can add pagination controls here)
                },
                error: function() {
                    alert('Failed to load suppliers');
                }
            });
        }

        // Add Supplier Form Submission
        $('#supplierAddForm').submit(function(e) {
            e.preventDefault();
            
            $.ajax({
                url: '../actions/supplier_handler.php',
                method: 'POST',
                data: {
                    action: 'add_supplier',
                    supplierName: $('input[name="supplierName"]').val(),
                    phoneNumber: $('input[name="supplierPhone"]').val(),
                    address: $('input[name="supplierAddress"]').val()
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert('Supplier added successfully');
                        loadSupplierStatistics();
                        loadSuppliers();
                        $('#addSupplierForm').removeClass('active');
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Failed to add supplier');
                }
            });
        });

        // Initial load of suppliers and statistics
        loadSupplierStatistics();
        loadSuppliers();

        // Search functionality
        $('input[placeholder="Search.."]').on('keyup', function() {
            loadSuppliers($(this).val());
        });

        // (Rest of the previous JavaScript remains the same)
    });
    </script>

</body>
</html>