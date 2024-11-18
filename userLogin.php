<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<link rel="icon" type="image/x-icon" href="file:///C:/Users/hp/OneDrive/Documents/Ashesi/Year%203_Sem%201/Web%20Technology/Web%20Tech%20Final/power/mimosamifav.ico">
	<link rel="stylesheet" href="MimosamiStyleLogin.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
 
    <div class="grid-container-webpage-setup">
        <div class="item1a">
            <a href="Homepage.html"><img src="MimosamiLogo.png" alt="MimosamiLogo" style="width:100%;max-width:100px"></a>

        </div>

        <div class="item1">

        </div>

        <div class="item1b">
            <button><a href="AdminLogin.html">Admin</a></button>
        </div>

        <div class="item2">

            <div class="grid-container-2-columns">
                <div class="grid-item">
                    <h1> Welcome to Mimosami!</h1>
                    <p>Login to your account</p>
                    <p>Don't have an account?</p>
                    <button><a href ="Signup.html">Sign Up!</a></button>
                </div>

                <div class="grid-item" id="card">
                    <h2>Login</h2>
                    <form>
                        <input id="uname" type="text" placeholder="Username" required><br>
                        <input id="pword" type="password" placeholder="Password" required> <br>
                        <input type="submit" id="submit">
                    </form>
                </div>

            </div>
        </div>
    </div>

</body>

<script>
<!--Javascipt-->
const form=document.getElementById("login");

form.addEventListener('submit', function(event){
    event.preventDefault();

    const uname=document.getElementById('uname').value;
    const pword=document.getElementById('pword').value;

    if(uname ===""){
        alert('Please enter your username.');
        return;
    }


    if(pword ===""){
        alert('Please enter your password.');
        return;
    }

    alert("Waiting to login.");
    form.submit();
    });
    
</script>
</html>


<!-- <?php

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
 ?> -->