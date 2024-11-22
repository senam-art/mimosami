<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require '../actions/admin_login.php'
?>


<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin Login</title>
	<link rel="icon" type="image/x-icon" href="file:///C:/Users/hp/OneDrive/Documents/Ashesi/Year%203_Sem%201/Web%20Technology/Web%20Tech%20Final/power/mimosamifav.ico">
	<link rel="stylesheet" href="../assets/css/MimosamiStyleLogin.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body style="background-color:#CFE6FC">
 
    <div class="grid-container-webpage-setup">
        <div class="item1a">
            <a href="Homepage.html"><img src="../assets/logo/MimosamiLogo.png" alt="MimosamiLogo" style="width:100%;max-width:100px"></a>

        </div>

        <div class="item1">

        </div>

        <div class="item1b">
            <button><a href="AdminLogin.html">Admin</a></button>
        </div>

        <div class="item2" style="background-color:#f2f7f8">

            <div class="grid-container-2-columns">
                <div class="grid-item">
                    <h1> Welcome to Admin!</h1>
                    <p>Login to your account</p>
                    <p>Not a admin?</p>
                    <button><a href ="UserLogin.html">Login</a></button>
                </div>

                <div class="grid-item" id="card">
                    <h2>Login</h2>

                    <form action="../actions/admin_login.php" method="POST">
                        <input id="uname" name="uname" type="text" placeholder="Username" required><br>
                        <input id="pword" name="pword" type="password" placeholder="Password" required> <br>
                        <input type="submit" id="submit">
                    </form>


                </div>

            </div>
        </div>
    </div>

</body>

<script>
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