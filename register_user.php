<?php
// Include the database configuration file to connect to the database
include 'config.php';

// Enable error reporting to display errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form was submitted using the POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Collect and trim form data to remove unnecessary whitespace
    $Firstname = trim($_POST['fname']);
    $Lastname = trim($_POST['lname']);
    $Username = trim($_POST['uname']);
    $Email = trim($_POST['email']);
    $Password = trim($_POST['pword']);
    $RetypePassword = trim($_POST['pwordretype']);
    
    // Check if any required fields are empty
    if (empty($Firstname) || empty($Lastname) || empty($Username) || empty($Email) || empty($Password) || empty($RetypePassword)) {
        die('Please fill in all required fields.'); // Stop execution if any field is empty
    }
    
    // Check if password and confirm password match
    if ($RetypePassword !== $Password) {
        die('Passwords do not match.'); // Stop execution if passwords do not match
    }

    // Prepare a statement to check if the email is already registered in the database
    $stmt = $conn->prepare('SELECT email FROM users WHERE email = ?');
    $stmt->bind_param('s', $Email); // Bind the email parameter to the query
    $stmt->execute(); // Execute the query
    $results = $stmt->get_result(); // Get the result of the query

    // Check if the email already exists in the database
    if ($results->num_rows > 0) {
        echo '<script>alert("User already registered.");</script>';
        echo '<script>window.location.href = "register.php";</script>';
    } else {
        // Hash the password for security before storing it in the database
        $hashed_password = password_hash($Password, PASSWORD_BCRYPT);

        // Define the default role for a new user (e.g., 'user' role)
        $userrole = 'user'; // Adjust based on your role-based system

        // Prepare an INSERT statement to add the new user to the database
        $query = 'INSERT INTO `users` (`fname`, `lname`, `username`, `email`, `password`, `role`) VALUES (?, ?, ?, ?, ?, ?)';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssssss', $Firstname, $Lastname, $Username, $Email, $hashed_password, $userrole);

        // Execute the statement and check if it was successful
        if ($stmt->execute()) {
            header('Location: UserLogin.php'); // Redirect to the login page if successful
        } else {
            header('Location: Signup.php'); // Redirect back to the registration page if failed
        }
    }

    // Close the statement after execution
    $stmt->close();
}

// Close the database connection at the end
$conn->close();
?>
