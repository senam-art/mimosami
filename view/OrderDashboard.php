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
            <button class="menu selected"><a href ="OrderDashboard.html"></a>Order</button><br>
            <button class="menu"><a href ="InventoryDashbaord.html"></a>Inventory</button>
            </div>
        </div>
 
        <div class="item3">
            <h2>Select your supplier</h2>
            <select id="supplierDropdown">
            <option value="">Select a supplier</option>
            </select>

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
                    <p style="font-size:13px">Total Assets</p>
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

</script>


</html>