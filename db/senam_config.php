<?php
// Database configuration
$host = 'localhost'; 
$dbname = 'mimosami'; 
$username = 'root'; // Your database username, 'root' for local development
$password = ''; // Your database password, empty for local development unless set


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



try {
    // Create a PDO instance for database connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set PDO error mode to exception for better error handling
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection error
    die("Connection failed: " . $e->getMessage());
  
}
?>
