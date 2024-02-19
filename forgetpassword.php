<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
session_start();

// Function to generate OTP
function generateOTP($length = 6) {
    return rand(pow(10, $length-1), pow(10, $length)-1);
}

// Function to send email with OTP
function sendOTP($email, $otp) {
    // Replace this with your email sending code
   
    //mail($email, "Password Reset OTP", $message);

            $message = "Your OTP for password reset is: $otp";
            $subject="Online Examination System Password Reset OTP";
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tarifhasangaragonj@gmail.com';
            $mail->Password = 'ltfbfotczxsuhlkg';
            $mail->Port = 465;
            $mail->SMTPSecure = 'ssl';
            $mail->isHTML(true);
            $mail->setFrom('tarifhasangaragonj@gmail.com', 'Online Examination System');
            $mail->addAddress($email,"User");
            $mail->Subject = ("$subject");
            $mail->Body = $message;
            $mail->send();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get email from form
    $email = $_POST['email'];
    
    // Check if email exists in your user database (users.txt in this example)
    $users = file("File Storage/users.txt", FILE_IGNORE_NEW_LINES);
    $found = false;
    foreach ($users as $user) {
        $userInfo = explode("|", $user);
        if ($userInfo[1] == $email) {
            $found = true;
            break;
        }
    }

    if ($found) {
        // Generate OTP
        $otp = generateOTP();

        // Store OTP in session
        $_SESSION['otp'] = $otp;
        $_SESSION['reset_email'] = $email;

        // Send OTP via email
        sendOTP($email, $otp);

        // Redirect to OTP verification page
        header("Location: forgetpassword_otp.php");
        exit;
    } else {
        $error = "Email not found";
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
        <style type="text/css">
            body{
                 font-family: cursive;
            }
            .category{
                border: 2px solid black;
                width: 815px;
                margin-left: 250px;
                margin-top: 10px;
                padding: 40px;
                height: 540px;
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
             #update{
                 margin-left: 80px;
                 width: 200px;
                 height: 40px;
                 background-color: blue;
                 color: white;
                 border: 1px solid blue;
                 text-align: center;
                 font-size: 17px;
             }
             #update:hover{
                 cursor: pointer;
                 color: white;
                 background-color: purple;

             }
             #nav2 {
                list-style-type: none;
                margin: 0;
                padding: 0;
                width: 170px;
                background-color: #f1f1f1;
                height: 700px;
                float: left
}#li2 a {
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
#forgetpassword{
    border: 1px solid black;
    margin-left: 400px;
    width: 400px;
    margin-top: 50px;
    padding: 20px;
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

            </div>
        </ul>
    </nav>
        <div id="forgetpassword">
               <h2>Forgot Password</h2><br>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Email: <input type="text" name="email"><br><br>
        <input type="submit" value="Reset Password">
    </form>
            
        </div>
</body>
</html>
