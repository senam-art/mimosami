<?php
// Set the content type to JSON
header("Content-Type: application/json");

// Database configuration
$servername = "169.239.251.102"; // Remote server IP address
$port = "3306"; // MySQL default port (you can specify it explicitly if required)
$username = "maisy.baer"; // Your database username
$password = "smarty8Aa.g@"; // Your database password
$dbname = "webtech_fall2024_maisy_baer"; // Your database name

try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully!";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
