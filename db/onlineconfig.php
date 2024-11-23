<?php
// Database configuration
$host = "bfdfpzg6gmxix10gvnmq-mysql.services.clever-cloud.com"; // Remote server IP address
$port = "3306"; // MySQL default port (you can specify it explicitly if required)
$username = "uja2vtcd9b5auduk"; // Your database username
$password = "l1BE7ZCl9NSEH16N1BdP"; // Your database password
$dbname = "bfdfpzg6gmxix10gvnmq"; // Your database name

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Create a new mysqli instance
    $conn = new mysqli($host, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_errno) {
        die("Connection failed: " . $conn->connect_error);
    }

    echo "Connection successful!";
} catch (Exception $e) {
    // Catch any other errors
    die("An error occurred: " . $e->getMessage());
}
?>
