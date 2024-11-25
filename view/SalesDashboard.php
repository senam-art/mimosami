<?php

session_start();

require "../db/onlineconfig.php";

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page
    header("Location: AdminLogin.php");
    exit();
}

// Fetch user data from session
$userName = $_SESSION['username'];

/*
Code to query database and extract data for the different divs
*/
// Fetch Total Sales
$salesQuery = "SELECT SUM(Amount) AS total_sales FROM mimosami_productsales";
$salesResult = $conn->query($salesQuery);

$totalSales = $salesResult->fetch_assoc()['total_sales'];

// Fetch total customers
$customerQuery = "SELECT COUNT(CustomerID) AS customer_count FROM mimosami_customer";
$customerResult = $conn->query($customerQuery);
$customerCount = $customerResult->fetch_assoc()['customer_count'];

// Associative array to map month numbers to month names
$monthNames = [
    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
    5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
    9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
];


//Fetch the number of signups for the current month
$currentMonth = date('m');
$currentYear = date('Y');

$newSignupsQuery =  "SELECT COUNT(CustomerID) AS new_signups
                    FROM mimosami_customer
                    WHERE MONTH(created_at) = $currentMonth
                    AND YEAR(created_at) = $currentYear";

$newSignupsResult =$conn -> query($newSignupsQuery);
$newSignups = $newSignupsResult -> fetch_assoc()['new_signups'];

//Latest month sales data
//Fetch latest month sales data
$latestMonthSalesQuery = "SELECT YEAR(Date) AS year,
                            MONTH(Date) AS month, 
                            SUM(Amount) AS total_sales 
                            FROM mimosami_productsales 
                            GROUP BY YEAR(Date),Month(Date) 
                            ORDER BY year DESC, month DESC 
                            LIMIT 1";

$latestMonthSalesResult = $conn -> query($latestMonthSalesQuery);

//get the data for the latest month 
$latestMonthData = $latestMonthSalesResult -> fetch_assoc();

//get the month name
$latestMonth = $monthNames[$latestMonthData['month']];
$latestSales = $latestMonthData['total_sales'];



/*
Code to query database and extract data for the Monthly sales chart
*/
// Monthly sales data for charts
$monthlySalesQuery = "SELECT YEAR(Date) AS year,
                        MONTH(Date) AS month,
                        SUM(Amount) AS total_sales
                        FROM mimosami_productsales 
                        GROUP BY YEAR(Date), MONTH(Date) 
                        ORDER BY year DESC, month DESC";
$monthlySalesResult = $conn->query($monthlySalesQuery); 

$months = [];
$sales = [];

while ($row = $monthlySalesResult->fetch_assoc()) { 
    $months[] = $monthNames[$row['month']];
    $sales[] = $row['total_sales'];  
}

// Encoding as a JSON
$monthsJson = json_encode($months);
$salesJson = json_encode($sales);



/*
Code to query database and extract data for the Sales by product chart
*/
//Fetching Sales by product
$salesByProductQuery  = "SELECT mp.productName, SUM(mo.Quantity) AS product_sold
                            FROM mimosami_productsales mo
                            JOIN mimosami_products mp ON mo.productID = mp.productID
                            GROUP BY mp.productName
                            ORDER BY product_sold DESC";


$SalesByProductResult = $conn->query($salesByProductQuery);
//Error checking
if (!$SalesByProductResult) {
    die("Query failed: " . $conn->error);
}

//array to store product and corresponding overall sales
$products = [];
$salesCount = [];

while ($row = $SalesByProductResult ->fetch_assoc()){

    $products[] = $row['productName'];
    $salesCount[] =$row['product_sold'];
}

// Encoding as JSON
$productsJson = json_encode($products);
$salesCountJson = json_encode($salesCount);


/*Code to query database to get customer gender
*/
$customerGenderQuery = "SELECT Gender, Count(Gender) as gender_count
                        FROM mimosami_customer 
                        GROUP BY Gender
                        ORDER BY gender_count DESC";

$customerGenderResult = $conn->query($customerGenderQuery);
if (!$SalesByProductResult) {
    die("Query failed: " . $conn->error);
}


// Initialize arrays for chart labels and data
$genderLabels = [];
$genderCounts = [];

while ($row = $customerGenderResult->fetch_assoc()) {
    $genderLabels[] = $row['Gender'];
    $genderCounts[] = $row['gender_count'];
}
//Encoding as JSON
$genderLabelsJson = json_encode($genderLabels);
$genderCountsJson = json_encode($genderCounts);
                        
?>



<!DOCTYPE html>
<html>
<head>
    <meta name='viewport' content="width=device-width initial-scale=1.0">
    <title> Sales Dashboard</title>
    <link rel="icon" type="image/x-icon" href="xxx">
    <link rel="stylesheet" href="../assets/css/MimosamiStyle2.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>

    <div class="grid-container-webpage-setup">
        
        <div class="item1">
            <div class="grid-container-2-columns">
                <div class="grid-item">
                    <h1 style="text-align:left">Sales Dashboard</h1>
                    <p style="text-align:left">Welcome to your Dashboard!</p>
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
            <button class="menu selected">Sales</button><br>
            <button class="menu"><a href = 'OrderDashboard.php'>Order</a></button><br>
            <button class="menu"><a href = 'InventoryDashboard.php'>Inventory</a></button>
            </div>
        </div>
 
        <div class="item3">
            <div class="grid-container-4-columns">
                <div class="grid-item" id="card">
                    <p style="font-size:13px">Total Sales</p>
                    <p style="font-weight:600;font-size:20px;color:#855363">GHC <?php echo number_format($totalSales, 2); ?></p>
                </div>

                <div class="grid-item" id="card">
                    <p style="font-size:13px">Total Customers</p>  
                    <p style="font-weight:600;font-size:20px;color:#855363"><?php echo $customerCount;?></p>                  
                </div>

                <div class="grid-item" id="card">
                    <p style="font-size:13px"><?php echo $latestMonth;?> Sales</p>
                    <p style="font-weight:600;font-size:20px;color:#855363">GHC <?php echo $latestSales;?></p>                   
                </div>

                <div class="grid-item" id="card">
                    <p style="font-size:13px">New Monthly Signups </p>  
                    <p style="font-weight:600;font-size:20px;color:#22a800">+<?php echo $newSignups;?></p>                    
                </div>

            </div>

            <div class="grid-container-2-columns">
                <div class="grid-item"  id="card">
                    <h2>Monthly Sales</h2>
                    <canvas id="monthly-sales"></canvas>
                </div>

               
                <div class="grid-item"  id="card">
                    <h2>Sales by Product</h2>
                    <canvas id="product-sales"></canvas>
                </div>
                
                <div class="grid-item"  id="card">
                    <h2>Customers</h2>
                    <canvas id="customers"></canvas>
                </div> 
            </div>
        </div>  
        
        <div class="item4">
            <p></p>
        <div>

    </div>

</body>

<script>
    // Passing PHP JSON data to JavaScript
    const months = <?php echo $monthsJson; ?>;
    const sales = <?php echo $salesJson; ?>;
    
    //data for Sales by Product
    const productName = <?php echo $productsJson; ?>;
    const productSales = <?php echo $salesCountJson; ?>;

    //Data for customer Gender
    const genderLabels = <?php echo $genderLabelsJson; ?>;
    const genderCounts = <?php echo $genderCountsJson; ?>;


    // Monthly Sales Line Graph
    const monthlySalesCtx = document.getElementById('monthly-sales');
    const monthlySalesChart = new Chart(monthlySalesCtx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Monthly Sales',
                data: sales,
                backgroundColor: '#855363',  
                borderColor: '#855363', 
                fill: false,    
            }]
        }
    });

    // Product Sales Bar Graph
    const productSalesCtx = document.getElementById('product-sales');
    const productSalesChart = new Chart(productSalesCtx, {
        type: 'bar',
        data: {
            labels: productName, 
            datasets: [{
                label: 'Sales by Product',
                data: productSales, 
                backgroundColor: ['#CFE6FC', '#F1A1A5', '#855363','#F7C59F'], 
                borderColor: ['#CFE6FC', '#F1A1A5', '#855363'],
                borderWidth: 1
            }]
        }
    });

    // Customer Gender Pie Chart
    const customersCtx = document.getElementById('customers');
    const customersChart = new Chart(customersCtx, {
        type: 'pie',
        data: {
            labels: genderLabels,
            datasets: [{
                label: 'Customer Gender',
                data: genderCounts, 
                backgroundColor: ['#CFE6FC', '#F1A1A5', '#855363'],
                hoverOffset: 2
            }]
        }
    });
</script>

</html>
