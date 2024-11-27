<?php
/*Database configuration*/
$host = 'localhost:3306';
$dbname = 'webtech_fall2024_senam_dzomeku'; 
$username = 'senam.dzomeku'; 
$password = "857120261"; 


try {
    // Create a new mysqli instance
    $conn = new mysqli($host, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_errno) {
        die("Connection failed: " . $conn->connect_error);
    }
    
} catch (Exception $e) {
    // Catch any other errors
    die("An error occurred: " . $e->getMessage());
}
?>
