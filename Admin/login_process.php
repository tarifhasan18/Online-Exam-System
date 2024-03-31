<?php
session_start();

$email = $_POST["email"];
$password = $_POST["password"];

// Check user credentials against stored data
$userData = file("../File storage/admin.txt", FILE_IGNORE_NEW_LINES);
foreach ($userData as $user) {
    list($storedEmail, $storedPassword) = explode("|", $user); 
    if ($email === $storedEmail && $password === $storedPassword) {
        $_SESSION["email"] = $email; 
        header("Location: home.php");
        exit;
    }
}
// If authentication fails, redirect to login page with error message
$_SESSION['error'] = "Invalid email or password!";
header("Location: index.php?error=1");
exit;
?>
