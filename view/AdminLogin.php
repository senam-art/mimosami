<?php 
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

require "../db/onlineconfig.php";

// Start a session
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get input values safely
    $username = isset($_POST['uname']) ? htmlspecialchars(trim($_POST['uname'])) : null;
    $password = isset($_POST['pword']) ? trim($_POST['pword']) : null;

    if (empty($username) || empty($password)) {
        echo "Both username and password are required.";
        exit();
    }

    try {
        // Query to fetch the user
        $sql = "SELECT username, password FROM adminUsers_mimosami WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username); // 's' means string type
        $stmt->execute();

        // Get result
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            // Verify the password
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $username; // Store username in session
                header("Location: SalesDashboard.php");
                exit();
            } else {
                echo "Invalid username or password!";
            }
        } else {
            echo "User not found!";
        }
    } catch (Exception $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="icon" type="image/x-icon" href="file:///C:/Users/hp/OneDrive/Documents/Ashesi/Year%203_Sem%201/Web%20Technology/Web%20Tech%20Final/power/mimosamifav.ico">
    <link rel="stylesheet" href="../assets/css/MimosamiStyleLogin.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body style="background-color:#CFE6FC">
    <div class="grid-container-webpage-setup">
        <div class="item1a">
            <a href="Homepage.html"><img src="../assets/logo/MimosamiLogo.png" alt="MimosamiLogo" style="width:100%;max-width:100px"></a>
        </div>
        <div class="item1"></div>
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
                    <form id="login" method="POST">
                        <input id="uname" name="uname" type="text" placeholder="Username" required><br>
                        <span id="uname-error" style="color: red; display: none;">Please enter your username.</span><br>
                        
                        <input id="pword" name="pword" type="password" placeholder="Password" required><br>
                        <span id="pword-error" style="color: red; display: none;">Please enter your password.</span><br>

                        <input type="submit" id="submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    // Get the input elements and error spans
    const unameInput = document.getElementById('uname');
    const pwordInput = document.getElementById('pword');
    const unameError = document.getElementById('uname-error');
    const pwordError = document.getElementById('pword-error');

        // Add event listeners for 'blur' (when the input loses focus)
    unameInput.addEventListener('blur', function() {
    if (unameInput.value === "") {
        unameError.style.display = 'inline';  // Show error message
         } else {
        unameError.style.display = 'none';  // Hide error message
        }
    });

    pwordInput.addEventListener('blur', function() {
        if (pwordInput.value === "") {
            pwordError.style.display = 'inline';  // Show error message
        } else {
            pwordError.style.display = 'none';  // Hide error message
        }
        });

        // Now, we can submit the form when both fields are filled
        const form = document.getElementById("login");

        form.addEventListener('submit', function(event){
            // Prevent form submission if validation fails
        if (unameInput.value === "" || pwordInput.value === "") {
            event.preventDefault(); // Prevent form submission
            // Make sure error messages are shown
            if (unameInput.value === "") unameError.style.display = 'inline';
            if (pwordInput.value === "") pwordError.style.display = 'inline';
        }
        });
</script>
</html>
