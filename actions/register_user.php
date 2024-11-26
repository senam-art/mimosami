<?php
// Enable error reporting to display errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../db/onlineconfig.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = isset($_POST['fname']) ? trim($_POST['fname']) : '';
    $lname = isset($_POST['lname']) ? trim($_POST['lname']) : '';
    $uname = isset($_POST['uname']) ? trim($_POST['uname']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $pword = isset($_POST['pword']) ? trim($_POST['pword']) : '';
    $gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
    $pwordretype = isset($_POST['pwordretype']) ? trim($_POST['pwordretype']) : '';

    // Validate if any field is empty
    if (empty($fname) || empty($lname) || empty($uname) || empty($email) || empty($pword) || empty($pwordretype) || empty($gender)) {
        die("Your fields are empty");
    }

    // Validate password match
    if ($pwordretype !== $pword) {
        die("Your passwords do not match");
    }

    // Check if the email already exists
    $stmt = $conn->prepare('SELECT email FROM mimosami_customer WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $results = $stmt->get_result();

    if ($results->num_rows > 0) {
        echo '<script>alert("A user with this email already exists.")</script>';
        header("Location: ../view/Signup.php");
        exit();
    } else {
        // Hash the password
        $hashed_password = password_hash($pword, PASSWORD_BCRYPT);
        $stmt = $conn->prepare('INSERT INTO mimosami_customer (fname, lname, uname, email, gender, pword) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('ssssss', $fname, $lname, $uname, $email, $gender, $hashed_password);

        if ($stmt->execute()) {
            header("Location: ../actions/userLogin.php");
            exit();
        } else {
            header("Location: ../view/Signup.php");
            exit();
        }
    }

    $stmt->close();
    $conn->close();
    exit();
}
