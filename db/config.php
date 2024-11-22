<?php
header("Content-Type: application/json");

$servername = "localhost:3306";
$username = "maisy.baer";
$password = "smarty8Aa.g@"; // Default for XAMPP
$dbname = "webtech_fall2024_maisy_baer";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit();
}

$conn->close();

?>