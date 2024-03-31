<?php
error_reporting(0);
session_start();

// Check if user is already logged in
if (isset($_SESSION["email"])) {
    header("Location: home.php");
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
        <li><a href="#">Home</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Contact Us</a></li>
      </div>
    </ul>
  </nav>
 
    <?php
    // Check if error session variable is set and display alert
    if (isset($_SESSION['error'])) {
        echo '<script>alert("' . $_SESSION['error'] . '")</script>';
        unset($_SESSION['error']); 
    }
    ?>
<form id="index_form" action="login_process.php" method="post">
  <div class="container">
    <label for="email"><b>Email*</b></label> <br>
    <input id="index_input_text" type="text" placeholder="Enter Email" name="email" required><br>
    <label for="password"><b>Password</b></label><br>
    <input id="index_input_password" type="password" placeholder="Enter Password" name="password" required><br>
        <label for=""><a href="forgetpassword.php">Forget Password</a></label> <br>
    <button id="index_button" type="submit" name="login">Login</button>
  </div>
  <hr style="width:270px; margin-left: 220px;"> <br>
  <label style="margin-left: 230px;">Don't have account? </label><a href="signup.php">Sign Up</a><br><br>
  </div>
</form>
</body>

</html>