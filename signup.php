<?php
session_start();
// Check if user is logged in, redirect to home page if logged in
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
<form id="#signup_form" action="signup_process.php" method="post" enctype="multipart/form-data">
  <div class="container">
  	  <label for="uname"><b>Enter Username</b></label> <br>
  	  <input id="signup_input_text" type="text" placeholder="Enter Username" name="username" required><br>
      <label for="email"><b>Email</b></label> <br>
      <input id="signup_input_text" type="text" placeholder="Enter Email" name="email" required><br>
      <label for="password"><b>Password</b></label><br>
      <input id="signup_input_password" type="password" placeholder="Enter Password" name="password" required><br>
      <label for="Address"><b>Address</b></label><br>
      <input id="signup_input_text" type="text" placeholder="Enter Addres" name="address" required><br><br>
      <label for="Image"><b>Upload your Image</b></label>
      <input type="file" name="image" placeholder="Upload image" required><br>
    <button id="signup_button" type="submit" name="submit">Sign Up</button>
  </div>
  <label style="margin-left: 230px;">Already have account? </label><a href="index.php">Log In</a><br><br>   
</div>
</form>
</body>
</html>