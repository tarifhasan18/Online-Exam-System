<?php
error_reporting(0);
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    //exit;
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
<style type="text/css">
  body{
     font-family: cursive;
  }
  .cat{
    
    margin-left: 250px;
    margin-top: 60px;
    padding: 10px;
    height: 500px;
    float: left;
  }
  .div1{
    background-color: deeppink;
    padding-top: 23px;
    float: left;
    margin:  25px;
    width: 200px;
    height: 70px;
    text-align: center;
  }
     #nav2 {
  list-style-type: none;
  margin: 0;
  padding: 0;
  width: 170px;
  background-color: #f1f1f1;
  height: 700px;
float: left
}

#li2 a {
  display: block;
  color: #000;
  padding: 8px 16px;
  text-decoration: none;
}

li a.active {
  background-color: #04AA6D;
  color: white;
}

li a:hover:not(.active) {
  background-color: #555;
  color: white;
}
</style>
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

<div class="cat">
  <p style="margin: 50px; ">Welcome to Admin Site</p>

</div>

</body>

</html>

<?php


?>