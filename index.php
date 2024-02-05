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
  <style type="text/css">
    body{
     font-family: cursive;
  }
  	form {
  		border: 3px solid #f1f1f1; 
  		width: 700px; 
  		margin-left: 300px;
  		margin-top: 50px;
  	}

input[type=text], input[type=password] {
  width: 60%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

button {
  background-color: #0866FF;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 60%;
}

button:hover {
  opacity: 0.8;
}

.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

img.avatar {
  width: 40%;
  border-radius: 50%;
}

.container {
  padding: 16px;
  margin-left: 200px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}
  </style>
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
        unset($_SESSION['error']); // Unset the session variable to prevent repeated alerts
    }
    ?>
<form action="login_process.php" method="post">

  <div class="container">
    <label for="email"><b>Email*</b></label> <br>
    <input type="text" placeholder="Enter Email" name="email" required><br>

    <label for="password"><b>Password</b></label><br>
    <input type="password" placeholder="Enter Password" name="password" required><br>
        
    <button type="submit" name="login">Login</button>
  </div>
  <hr style="width:270px; margin-left: 220px;"> <br>
  <label style="margin-left: 230px;">Don't have account? </label><a href="signup.php">Sign Up</a><br><br>

  
   
    
  </div>
</form>
</body>

</html>