<?php
session_start();

$servername = "localhost";
$db_username = "akua.amofa";
$db_password = "newtoMysql@2";
$dbname = "mimosami.db";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $uname = htmlspecialchars(trim($_POST['uname']));
    $pword = trim($_POST['pword']);

    $sql = "SELECT uname, pword FROM USERS WHERE uname=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pword, $row['pword'])) {
            $_SESSION['username'] = $uname;
            header("Location: Homepage.html");
            exit();
        } else {
            echo "Invalid username or password!";
        }
    } else {
        echo "User not found!";
    }

    $stmt->close();
    $conn->close();
}
?>
































<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="file:///C:/Users/hp/OneDrive/Documents/Ashesi/Year%203_Sem%201/Web%20Technology/Web%20Tech%20Final/power/mimosamifav.ico">
    <link rel="stylesheet" href="MimosamiStyleLogin.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="grid-container-webpage-setup">
        <div class="item1a">
            <a href="Homepage.html">
                <img src="MimosamiLogo.png" alt="MimosamiLogo" style="width:100%;max-width:100px">
            </a>
        </div>
        <div class="item1"></div>
        <div class="item1b">
            <button><a href="AdminLogin.html">Admin</a></button>
        </div>

        <div class="item2">
            <div class="grid-container-2-columns">
                <div class="grid-item">
                    <h1>Welcome to Mimosami!</h1>
                    <p>Login to your account</p>
                    <p>Don't have an account?</p>
                    <button><a href="Signup.html">Sign Up!</a></button>
                </div>
                <div class="grid-item" id="card">
                    <h2>Login</h2>
                    <form id="login">
                        <input id="uname" name="uname" type="text" placeholder="Username" required><br>
                        <input id="pword" name="pword" type="password" placeholder="Password" required><br>
                        <input type="submit" id="submit" value="Login">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById("login");

        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            const uname = document.getElementById('uname').value.trim();
            const pword = document.getElementById('pword').value.trim();

            // Validation
            if (uname === "") {
                alert('Please enter your username.');
                return;
            }

            if (pword === "") {
                alert('Please enter your password.');
                return;
            }

            // Feedback or next step
            alert("Waiting to login.");
            // Here you can add additional login logic, e.g., sending data to a server via AJAX
        });
    </script>
</body>
</html>