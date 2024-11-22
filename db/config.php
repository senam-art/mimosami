<?php
// Set the content type to JSON
header("Content-Type: application/json");

// Database configuration
$host = "localhost"; // Remote server IP address
$port = "3341"; // MySQL default port (you can specify it explicitly if required)
$username = "maisy.baer"; // Your database username
$password = "smarty8Aa.g@"; // Your database password
$dbname = "webtech_fall2024_maisy_baer"; // Your database name

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
