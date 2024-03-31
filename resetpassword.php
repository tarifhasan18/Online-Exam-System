<?php
session_start();
if (!isset($_SESSION['reset_email'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];
    $email = $_SESSION['reset_email'];
    $users = file("File Storage/users.txt", FILE_IGNORE_NEW_LINES);
    $updatedUsers = [];
    foreach ($users as $user) {
        $userInfo = explode("|", $user);
        if ($userInfo[1] == $email) {
            $userInfo[2] = $password;
        }
        $updatedUsers[] = implode("|", $userInfo);
    }
    file_put_contents("File Storage/users.txt", implode(PHP_EOL, $updatedUsers));
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="CSS/style.css" />
        <title>Online Examination System</title>
    </head>
    <body>
    <nav class="navbar">
        <div class="logo">Online Examination System</div>
        <ul class="nav-links">
            <div class="menu">
                <li><a href="home.php">Home</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Contact Us</a></li>
            </div>
        </ul>
    </nav>
    <div id="reset_password">
    <h2>Reset Password</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        New Password: <input type="password" name="password"><br><br>
        <input type="submit" value="Reset">
    </form>
</div>
</body>
</html>
