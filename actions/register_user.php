<?php
include '../db/config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $uname = trim($_POST['uname']);
    $email = trim($_POST['email']);
    $pword = trim($_POST['pword']);
    $pwordretype = trim($_POST['pwordretype']);

    if (empty($fname) || empty($lname) || empty($uname) || empty($email) || empty($pword) || empty($pwordretype)) {
        header("Location: Signup.php?error=empty_fields");
        exit();
    }

    if ($pwordretype !== $pword) {
        header("Location: Signup.php?error=password_mismatch");
        exit();
    }

    $stmt = $conn->prepare('SELECT email FROM Mimosami_customer WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $results = $stmt->get_result();

    if ($results->num_rows > 0) {
        header("Location: Signup.php?error=email_exists");
        exit();
    }

    $stmt = $conn->prepare('SELECT uname FROM Mimosami_customer WHERE uname = ?');
    $stmt->bind_param('s', $uname);
    $stmt->execute();
    $results = $stmt->get_result();

    if ($results->num_rows > 0) {
        header("Location: Signup.php?error=username_exists");
        exit();
    }

    $hashed_password = password_hash($pword, PASSWORD_BCRYPT);
    $stmt = $conn->prepare('INSERT INTO Mimosami_customer (fname, lname, uname, email, pword) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('sssss', $fname, $lname, $uname, $email, $hashed_password);

    if ($stmt->execute()) {
        header("Location: UserLogin.php?success=registration_complete");
        exit();
    } else {
        header("Location: Signup.php?error=registration_failed");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
