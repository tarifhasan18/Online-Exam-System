<?php
session_start();

if (!isset($_SESSION['otp']) || !isset($_SESSION['reset_email'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp = $_POST['otp'];

    if ($otp == $_SESSION['otp']) {
        header("Location: resetpassword.php");
        exit;
    } else {
        $error = "Invalid OTP";
    }
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
        <div id="forgetpassword_otp">
    <h2>OTP Verification</h2>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Enter OTP: <input type="text" name="otp"><br><br>
        <input type="submit" value="Verify">
    </form>
</div>
</body>
</html>
