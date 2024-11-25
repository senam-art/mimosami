<?php
// Start a session
session_start();

// Include database configuration
require "..//db/config.php"; // Ensure this initializes a PDO instance in $conn

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get input values safely
    $username = isset($_POST['uname']) ? htmlspecialchars(trim($_POST['uname'])) : null;
    $password = isset($_POST['pword']) ? trim($_POST['pword']) : null;

    if (empty($username) || empty($password)) {
        echo "Both username and password are required.";
        exit();
    }

    try {
        // Query to fetch the user
        $sql = "SELECT username, password FROM adminUsers_mimosami WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();

        // Fetch result
        $row = $stmt->get_result();

        if ($row->num_rows > 0) {
            // Verify the password
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $username; // Store username in session
                header("Location: ../view/SalesDashboard.html");
                exit();
            } else {
                echo "Invalid username or password!";
            }
        } else {
            echo "User not found!";
        }
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
} 

?>
