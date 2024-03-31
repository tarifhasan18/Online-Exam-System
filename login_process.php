<?php
session_start();

$email = $_POST["email"];
$password = $_POST["password"];

// Check user credentials against stored data
$userData = file("File Storage/users.txt", FILE_IGNORE_NEW_LINES);
foreach ($userData as $user) {
    list($storedUsername, $storedEmail, $storedPassword, $storedAddress, $storedImage) = explode("|", $user); 
    if ($email === $storedEmail && $password === $storedPassword) {
        $_SESSION["email"] = $email; 
        $_SESSION['username']=$storedUsername;
        $_SESSION['address']=$storedAddress;
        $_SESSION['image']=$storedImage;
        $_SESSION['password']=$password;
        header("Location: home.php");
        exit;
    }
}
$_SESSION['error'] = "Invalid email or password!";
header("Location: index.php?error=1");
exit;
?>
