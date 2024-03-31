<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $address = $_POST["address"];
    $image = $_FILES["image"];

    // Check if email already exists
    $userData = file("File Storage/users.txt", FILE_IGNORE_NEW_LINES);
    foreach ($userData as $user) {
        list(, $storedEmail, , , ) = explode("|", $user); // Extract email
        if ($email === $storedEmail) {
            $_SESSION['error'] = "Email already exists!";
            header("Location: signup.php");
            exit;
        }
    }
    $imagePath = "images/" . basename($image["name"]);
    move_uploaded_file($image["tmp_name"], $imagePath);
    $data = "$username|$email|$password|$address|$imagePath\n";
    file_put_contents("File Storage/users.txt", $data, FILE_APPEND | LOCK_EX);

    header("Location: index.php");
    exit;
}
?>
