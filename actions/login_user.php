<?php
include '../db/config.php';

// Enable error reporting to display errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Start session at the beginning

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $email = trim($_POST['uname']);
    $password = trim($_POST['password']);

    if (empty($uname) || empty($password)) {
        die('Please fill in all required fields');
    }
    var_dump($password);

    // Prepare a statement to check if the email is already registered in the database
    $stmt = $conn->prepare("SELECT email, pword ,CustomerID, fname,lname FROM Mimosami_customer WHERE email = ?");
    $stmt->bind_param('s', $email); // Bind the email parameter to the query
    $stmt->execute(); // Execute the query
    $results = $stmt->get_result(); // Get the result of the query

    if ($results->num_rows > 0) {
        $user = $results->fetch_assoc();
        var_dump($user['password']); // Debug output for hashed password

        if (password_verify($password, $user['password'])) {
            // Store user data in session variables
            $_SESSION['CustomerID'] = $user['CustomerID'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['uname'] = $user['uname'];
            $_SESSION['fname'] = $user['fname'];
            $_SESSION['lname'] = $user['lname'];

            header('Location: ../view/admin/dashboard.php');
            exit(); // Make sure to exit after the redirect
        } else {
            echo 'Incorrect password. Please try again.';
        }
    } else {
        echo "User not in the system";
    }
    $stmt->close();
}
?>