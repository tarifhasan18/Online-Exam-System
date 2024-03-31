<?php
error_reporting(0);
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
}else{
  $email=$_SESSION['email'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../CSS/style.css" />
  <title>Online Examination System</title>
</head>
<body>
  <nav class="navbar">
    <div class="logo">Online Examination System</div>
    <ul class="nav-links">
      <div class="menu">
        <li><a href="logout.php">Logout</a></li>
        <li><a href="#"><?php echo $email; ?></a></li>
      </div>
    </ul>
  </nav>
<ul id="nav2">
     <li id="li2"><a class="" href="">Dashboard</a></li>
     <li id="li2"><a class="active" href="home.php">Home</a></li>
     <li id="li2"><a href="addclass.php">Add Class</a></li>
     <li id="li2"><a href="addsubject.php">Add Subject</a></li>
     <li id="li2"><a href="#">Schedule Exam</a></li>
     <li id="li2"><a href="addquestion.php">Add Question</a></li>
     <li id="li2"><a href="users.php">Manage Users</a></li>
     <li id="li2"><a href="#">Results</a></li>
</ul>

<div class="home_cat">
  <p style="margin: 50px; ">Welcome to Admin Site</p>
</div>
</body>
</html>