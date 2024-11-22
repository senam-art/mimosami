<?php
header("Content-Type: application/json");

$servername = "localhost";
$username = "maisy.baer";
$password = "smarty8Aa.g@"; // Default for XAMPP
$dbname = "mimosami";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit();
}

$conn->close();

?>