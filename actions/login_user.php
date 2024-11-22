<?php
include '../db/config.php';

// Enable error reporting to display errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Start session at the beginning

// Check if the required POST keys exist
if (!isset($_POST['uname']) || !isset($_POST['pword'])) {
    die('Please fill in all required fields.');
}

// Sanitize and trim user inputs
$uname = trim($_POST['uname']);
$pword = trim($_POST['pword']);

if (empty($uname) || empty($pword)) {
    die('Please fill in all required fields.');
}

// Debugging: Uncomment to check form submission
// var_dump($_POST);
// var_dump($pword);

// Prepare a statement to check if the email is already registered in the database
$stmt = $conn->prepare("SELECT uname, pword FROM mimosami_customers WHERE uname = ?");
$stmt->bind_param('s', $uname); // Bind the email parameter to the query
$stmt->execute(); // Execute the query
$results = $stmt->get_result(); // Get the result of the query

if ($results->num_rows > 0) {
    $user = $results->fetch_assoc();
    // Debug output for hashed password
    // var_dump($user['pword']);

    if (password_verify($pword, $user['pword'])) {
        // Store user data in session variables
        $_SESSION['uname'] = $user['uname'];

        header('Location: ../view/admin/dashboard.php');
        exit(); // Make sure to exit after the redirect
    } else {
        echo 'Incorrect password. Please try again.';
    }
} else {
    echo 'User not in the system.';
}

$stmt->close();
?>
