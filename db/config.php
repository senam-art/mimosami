<?php

$servername = "localhost";
$username = "maisy.baer";
$password = "smarty8Aa.g@";
$dbname = "webtech_fall2024_maisy_baer";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
} else {
    echo "Connection successful!";
}


?>
