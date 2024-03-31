<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
session_start();
error_reporting(0);
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit;
}else{
  $email=$_SESSION['email'];
  $address=$_SESSION['address'];
  $image=$_SESSION['image'];
  $username=$_SESSION['username'];
  $password=$_SESSION['password'];
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
        <li><a href="/">About Us</a></li>
        <li><a class="active" href="contact.php">Contact Us</a></li>
        <li><a href="logout.php">Logout</a></li>
          <li><img style="float: left;  border-radius: 50%;" width="30px" height="30px" src="<?php echo $image;?>"><a href="profile.php" style="float: left; margin-top: 5px"><?php echo $username;?></a> </li>
      </div>
    </ul>
  </nav>

  </div>
  <h2 style="text-align:center;margin-top: 80px">Email Us</h2>
  <form method="post" action="contact.php">
  <input id="contact_input" type="text" name="name" placeholder="Enter Your Name" required><br><br>
  <input id="contact_input" type="text" name="email" placeholder="Enter Your Email Address" required><br><br>
  <input id="contact_input" type="text" name="subject" placeholder="Enter Your Email Subject" required><br><br>
  <input id="contact_input" style="height:70px" type="text" name="message" placeholder="Write Your message" required><br><br>
  <input id="#contact_input_submit" type="submit" name="send" value="Send">
  
</form>
  </body>

</html>
<?php 
if (isset($_POST['send'])) {
  $name=$_POST['name'];
    $email=$_POST['email'];
    $subject=$_POST['subject'];
    $msg=$_POST['message'];
    $message='Name:<br>'.$name.'<br>'.'<hr>Email:<br>'.$email.'<br><hr>Message:<br>'.$msg;
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'tarifhasangaragonj@gmail.com';
    $mail->Password = 'ltfbfotczxsu hlkg';
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';
    $mail->isHTML(true);
    $mail->setFrom($email, $name);
    $mail->addAddress('tarifhasangaragonj@gmail.com','MD Tarif Hasan');
    $mail->Subject = ("$subject");
    $mail->Body = $message;
    $mail->send();

    if ($mail) {
    echo "<script>";
    echo "alert('Email Sent Successfully')";
    echo "</script>";
}else {
    echo "Email sending failed: " . $mail->ErrorInfo;
}
}
?>