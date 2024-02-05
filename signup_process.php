<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"]; // Hash password
    $address = $_POST["address"];
    $image = $_FILES["image"];

    // Validate and sanitize data
    // Example: if (empty($username) || empty($email) || empty($password)) { ... }

    // Check if email already exists
    $userData = file("File Storage/users.txt", FILE_IGNORE_NEW_LINES);
    foreach ($userData as $user) {
        list(, $storedEmail, , , ) = explode("|", $user); // Extract email
        if ($email === $storedEmail) {
            // Email already exists, set error message and redirect to signup page
            $_SESSION['error'] = "Email already exists!";
            header("Location: signup.php");
            exit;
        }
    }

    // Handle file upload for image
    $imagePath = "images/" . basename($image["name"]);
    move_uploaded_file($image["tmp_name"], $imagePath);

    // Store user data in a text file
    $data = "$username|$email|$password|$address|$imagePath\n";
    file_put_contents("File Storage/users.txt", $data, FILE_APPEND | LOCK_EX);

    // Redirect user to a confirmation page
    header("Location: index.php");
    exit;
}
?>
