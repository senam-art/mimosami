<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../db/onlineconfig.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uname = htmlspecialchars(trim($_POST['uname']));
    $pword = trim($_POST['pword']);

    $sql = "SELECT CustomerID, uname, pword FROM mimosami_customer WHERE uname=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pword, $row['pword'])) {
            $_SESSION['uname'] = $uname;
            $_SESSION['CustomerID'] = $row['CustomerID'];
            header("Location: ../view/Products.php");
            exit();
        } else {
            echo "Invalid username or password!";
        }
    } else {
        echo "User not found!";
    }
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link
      rel="icon"
      type="image/x-icon"
      href="../assets/favicon/mimosamifav.ico"
    />
    <link rel="stylesheet" href="../assets/css/MimosamiStyleLogin.css" >
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>

  <body>
    <div class="grid-container-webpage-setup">
      <div class="item1a">
        <a href="../view/Homepage.html"
          ><img
            src="../assets/logo/MimosamiLogo.png"
            alt="MimosamiLogo"
            style="width: 100%; max-width: 100px"
        /></a>
      </div>

      <div class="item1"></div>

      <div class="item1b">
        <button><a href="../view/AdminLogin.php">Admin</a></button>
      </div>

      <div class="item2">
        <div class="grid-container-2-columns">
          <div class="grid-item">
            <h1>Welcome to Mimosami!</h1>
            <p>Login to your account</p>
            <p>Don't have an account?</p>
            <button><a href="Signup.php">Sign Up!</a></button>
          </div>

          <div class="grid-item" id="card">
            <h2>Login</h2>
            <form id="login" method="POST">
              <input
                id="uname"
                name="uname"
                type="text"
                placeholder="Username"
                required
              /><br />
              <input
                id="pword"
                name="pword"
                type="password"
                placeholder="Password"
                required
              />
              <br />
              <button type="submit" name="submitBtn" id="submitBtn">
                Submit
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>

  <script>
    const form = document.getElementById("login");

    form.addEventListener("submit", function (event) {
      event.preventDefault();

      const uname = document.getElementById("uname").value;
      const pword = document.getElementById("pword").value;

      if (uname === "") {
        alert("Please enter your username.");
        return;
      }

      if (pword === "") {
        alert("Please enter your password.");
        return;
      }

      //alert("Waiting to login.");
      form.submit();
    });
  </script>
</html>