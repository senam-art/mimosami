<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<link rel="icon" type="image/x-icon" href="..assets/favicon/mimosamifav.ico">
	<link rel="stylesheet" href="../assets/css/MimosamiStyleLogin.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
 
    <div class="grid-container-webpage-setup">
        <div class="item1a">
            <a href="Homepage.html"><img src="../assets/logo/MimosamiLogo.png" alt="MimosamiLogo" style="width:100%;max-width:100px"></a>

        </div>

        <div class="item1">

        </div>

        <div class="item1b">
            <button><a href="AdminLogin.php">Admin</a></button>
        </div>


            <div class="grid-container-2-columns">
                <div class="grid-item">
                    <h1> Welcome to Mimosami!</h1>
                    <p>Login to your account</p>
                    <p>Already have an account?</p>
                    <button><a href ="../db/UserLogin.php">Login!</a></button>
                </div>

                <div class="grid-item" id="card">
                    <h2>Sign up</h2>
                    <form>
                        <input id="fname" type="text" placeholder="First Name" required><br>
                        <input id="lname" type="text" placeholder="Last Name" required> <br>                        
                        <input id="uname" type="text" placeholder="Username" required><br>
                        <input id="email" type="email" placeholder="Email" required><br>
                        <input id="pword" type="password" placeholder="Password" required> <br>
                        <input id="pwordretype" type="password" placeholder="Retype your password" required> <br>
                        <input type="submit" id="submit">
                    </form>
                </div>

            </div>
        </div>
    </div>

</body>

<script>
    const form=document.getElementById("signup");

    form.addEventListener('submit', function(event){
        event.preventDefault();

        const fname=document.getElementById('fname').value;
        const lname=document.getElementById('lname').value;
        const uname=document.getElementById('uname').value;
        const email=document.getElementById('email').value;
        const pword=document.getElementById('pword').value;
        const pwordretype=document.getElementById('pwordretype').value;


        if(fname ===""){
            alert('Please enter your first name.');
            return;
        }


        if(lname ===""){
            alert('Please enter your last name.');
            return;
        }

        if(uname ===""){
            alert('Please enter your username.');
            return;
        }

        if(!emailIsValid(email)){
            alert('Please enter a valid email address.');
            return;
        }


        if(!pwordIsValid(pword)){
            alert('Please enter a valid password. It should contain at least 8 characters, 1 upper case letter, 3 numbers, 1 special character');
            return;
        }

        if(pwordretype!==pword){
            alert('Your passwords do not match.');
            return;
        }


        alert("Waiting to Sign up.");
        form.submit();
        });

    function emailIsValid(email){
        return /^[^\s@]+@[^\s@]+$/.test(email);
    }

    function pwordIsValid(pword){
        return /^(?=.*[A-Z])(?=(?:.*\d.*\d.*\d))(?=.*[!@#$%^&*()_+=[\]{};':"\\|,.<>/?~`-])[A-Za-z\d!@#$%^&*()_+=[\]{};':"\\|,.<>/?~`-]{8,}$/.test(pword);
    }
</script>
</html>