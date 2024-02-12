<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit;
}else{
  $email=$_SESSION['email'];
  $address=$_SESSION['address'];
  $image=$_SESSION['image'];
  $username=$_SESSION['username'];
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
  .category{
    border: 2px solid black;
    width: 815px;
    margin-left: 250px;
    margin-top: 60px;
    padding: 40px;
    height: 540px;
  }

  #class{
      float: left;

  }
  #classname{
      background-color: deeppink;
      color: white;
      width: 220px;
      height: 100px;
      margin: 10px;
      font-weight: bold;
  }#classname:hover{
      cursor: pointer;
      background-color: blue;
      color: white;
     }
</style>
</head>

<body>
  <nav class="navbar">
   
    <div class="logo">Online Examination System</div>

    <ul class="nav-links">

      <div class="menu">

        <li><a href="home.php">Home</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Contact Us</a></li>
        <li><a href="logout.php">Logout</a></li>
        <li><a href="#"><?php echo $email; ?></a></li>

      </div>
    </ul>
  </nav>


<div class="category">


</div>

</body>

</html>

<?php


?>