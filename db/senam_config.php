<?php
// Database configuration
$host = 'localhost'; 
$dbname = 'mimosami'; 
$username = 'root'; // Your database username, 'root' for local development
$password = ''; // Your database password, empty for local development unless set

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
