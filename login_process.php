<?php
session_start();

// Retrieve form data
$email = $_POST["email"];
$password = $_POST["password"];

// Check user credentials against stored data
$userData = file("File Storage/users.txt", FILE_IGNORE_NEW_LINES);
foreach ($userData as $user) {
    list(, $storedEmail, $storedPassword, , ) = explode("|", $user); // Extract email and password
    if ($email === $storedEmail && $password === $storedPassword) {
        // Authentication successful, start session and redirect
        $_SESSION["email"] = $email; // Store email in session
        header("Location: home.php");
        exit;
    }
}

// If authentication fails, redirect to login page with error message
$_SESSION['error'] = "Invalid email or password!";
header("Location: index.php?error=1");
exit;
?>
