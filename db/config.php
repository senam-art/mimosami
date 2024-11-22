<?php
// Set the content type to JSON
header("Content-Type: application/json");

// Database configuration
$servername = "169.239.251.102"; // Remote server IP address
$port = "3306"; // MySQL default port (you can specify it explicitly if required)
$username = "maisy.baer"; // Your database username
$password = "smarty8Aa.g@"; // Your database password
$dbname = "webtech_fall2024_maisy_baer"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// If connection is successful
echo json_encode(["success" => "Connected successfully!"]);

// Close the connection
$conn->close();
?>