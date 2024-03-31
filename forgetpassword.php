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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    
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
        $otp = generateOTP();
        $_SESSION['otp'] = $otp;
        $_SESSION['reset_email'] = $email;

        sendOTP($email, $otp);

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
