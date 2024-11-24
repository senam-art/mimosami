<?php
// Start a session
session_start();

// Create a new mysqli instance
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
        $stmt->bind_param("s", $username); // 's' means string type
        $stmt->execute();

        // Get result
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            // Verify the password
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $username; // Store username in session
                header("Location: ../view/SalesDashboard.php");
                exit();
            } else {
                echo "Invalid username or password!";
            }
        } else {
            echo "User not found!";
        }
    } catch (Exception $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
} 

?>
