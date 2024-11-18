<?php

session_start();

$servername = "localhost";
$username = "akua.amofa";
$password = "newtoMysql@2";
$dbname = "mimosami.db";

2 // Check if the form data is sent via POST
3 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli($localhost, $akua.amofa, $newtoMysql@2, $dbname);

4 // Retrieve and sanitize form data
5 $uname = htmlspecialchars(trim($_POST['uname'])); // Removes HTML tags and whitespace
6 $password = hash($_POST['password']); //

7
8 // Check if the fields are empty
9 if (empty($name) || empty($age)) {
10 echo "Please provide your login details.";
11 }

$table=$conn->("SELECT uname,pword FROM USERS WHERE name='$user' ")

if ($user=user['user'] && $pword=user['pword']){
 $_SESSION['username'] = $user;
        header("Homepage.html");
     exit();
} else {
    // Login failed
    $error = "Invalid username or password!";
}

$conn->close();
}
18 ?>
19
