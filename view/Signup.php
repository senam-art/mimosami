<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Mimosami</title>
    <link rel="stylesheet" href="MimosamiStyleLogin.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="grid-container-webpage-setup">
        <div class="item1a">
            <a href="Homepage.html"><img src="MimosamiLogo.png" alt="Mimosami Logo" style="width:100%;max-width:100px"></a>
        </div>
        <div class="item1b">
            <button><a href="AdminLogin.html">Admin</a></button>
        </div>

        <div class="grid-container-2-columns">
            <div class="grid-item">
                <h1>Welcome to Mimosami!</h1>
                <p>Login to your account</p>
                <p>Already have an account?</p>
                <button><a href="UserLogin.html">Login!</a></button>
            </div>

            <div class="grid-item" id="card">
                <h2>Sign Up</h2>
                <form id="signup-form" action="register_user.php" method="POST">
                    <input id="fname" name="fname" type="text" placeholder="First Name" required><br>
                    <input id="lname" name="lname" type="text" placeholder="Last Name" required><br>
                    <input id="uname" name="uname" type="text" placeholder="Username" required><br>
                    <input id="email" name="email" type="email" placeholder="Email" required><br>
                    <input id="pword" name="pword" type="password" placeholder="Password" required><br>
                    <input id="pwordretype" name="pwordretype" type="password" placeholder="Retype your password" required><br>
                    <button type="submit">Sign Up</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>


<script>
    document.getElementById("signup-form").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent default form submission

        const fname = document.getElementById("fname").value.trim();
        const lname = document.getElementById("lname").value.trim();
        const uname = document.getElementById("uname").value.trim();
        const email = document.getElementById("email").value.trim();
        const pword = document.getElementById("pword").value.trim();
        const pwordretype = document.getElementById("pwordretype").value.trim();

        let isValid = true;

        // Email validation pattern
        const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

        // Clear all previous error messages
        clearErrors();

        // Validate First Name
        if (!fname) {
            displayError("fname", "First name is required.");
            isValid = false;
        }

        // Validate Last Name
        if (!lname) {
            displayError("lname", "Last name is required.");
            isValid = false;
        }

        // Validate Username
        if (!uname || uname.length < 3) {
            displayError("uname", "Username must be at least 3 characters long.");
            isValid = false;
        }

        // Validate Email
        if (!email.match(emailPattern)) {
            displayError("email", "Please enter a valid email address.");
            isValid = false;
        }

        // Validate Password
        if (pword.length < 8) {
            displayError("pword", "Password must be at least 8 characters long.");
            isValid = false;
        }

        // Validate Password Match
        if (pword !== pwordretype) {
            displayError("pwordretype", "Passwords do not match.");
            isValid = false;
        }

        // If valid, proceed to submit the form
        if (isValid) {
            this.submit();
        }
    });

    // Clear all error messages
    function clearErrors() {
        document.querySelectorAll(".error-message").forEach((error) => error.remove());
    }

    // Display error message below the input field
    function displayError(inputId, message) {
        const inputField = document.getElementById(inputId);
        const error = document.createElement("div");
        error.className = "error-message";
        error.style.color = "red";
        error.style.fontSize = "0.9em";
        error.innerText = message;

        inputField.insertAdjacentElement("afterend", error);
    }
</script>

</html>