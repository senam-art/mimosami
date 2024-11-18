<?php
2 // Check if the form data is sent via POST
3 if ($_SERVER['REQUEST_METHOD'] == 'POST') {

4 // Retrieve and sanitize form data
5 $uname = htmlspecialchars(trim($_POST['uname'])); // Removes HTML tags and whitespace
6 $password = filter_var(trim($_POST['age']), FILTER_SANITIZE_NUMBER_INT); // Sanitizes to integer

7
8 // Check if the fields are empty
9 if (empty($name) || empty($age)) {
10 echo "Please provide both name and age.";
11 } else {
12 // Display the sanitized information
13 echo "Hello, " . $name . "! You are " . $age . " years old.";
14 }
15 } else {
16 echo "Invalid request method.";
17 }
18 ?>
19
