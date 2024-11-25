<?php
// Enable error reporting to display errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../db/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $uname = trim($_POST['uname']);
    $email = trim($_POST['email']);
    $pword = trim($_POST['pword']);
    $pwordretype = trim($_POST['pwordretype']);

    if (empty($fname) || empty($lname) || empty($uname) || empty($email) || empty($pword) || empty($pwordretype)) {
        die("Your fields are empty");
    }

    if ($pwordretype !== $pword) {
        die("Your passwords do not match");
    }



    $stmt = $conn->prepare('SELECT email FROM mimosami_customer WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $results = $stmt->get_result();
   

    if ($results->num_rows > 0) {
        echo '<script>alert("A user with this email already exists.")</script>';
        exit();
    } else {
        $hashed_password = password_hash($pword, PASSWORD_BCRYPT);
        $stmt = $conn->prepare('INSERT INTO mimosami_customer (fname, lname, uname, email, pword) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('sssss', $fname, $lname, $uname, $email, $hashed_password);

        // if ($stmt->execute()) {
        //     echo '<script>window.location.href = "userLogin.php";</script>';
        // } else {
        //     echo '<script>alert("Failed to register. Please try again.")</script>';

        if ($stmt->execute()) {
            header("Location: ../../db/userLogin.php");
            exit();
        } else {
            header("Location: ../../view/Signup.php");
            exit();
        }
    }
}



$stmt->close();
$conn->close();

exit();
