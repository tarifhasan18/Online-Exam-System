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
if (isset($_POST['submit'])) {
  $_SESSION['class']=$_POST['class'];
    if (isset($_SESSION['class'])){
        header("Location: subject.php");
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
        <li><a href="logout.php">Logout</a></li>
        <li><img style="float: left;  border-radius: 50%;" width="30px" height="30px" src="<?php echo $image;?>"><a href="profile.php" style="float: left; margin-top: 5px"><?php echo $username;?></a> </li>
      </div>
    </ul>
  </nav>
  <br><br>
  <h2 style="text-align: center;">Select a Class</h2>
<div class="category">
<?php
$classData = file("File storage/class.txt");
foreach ($classData as $className) {
    if (trim($className) !== '') {
        ?>
        <form id="class" action="home.php" method="post">
            <input type="text" name="class" value="<?php echo $className; ?>" hidden="">
            <input id="classname" type="submit" name="submit" value="<?php echo $className; ?>">
        </form>
        <?php
    }
}
?>
</div>
</body>
</html>