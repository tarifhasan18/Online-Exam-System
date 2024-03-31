<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

error_reporting(0);
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit;
} else {
    $email=$_SESSION['email'];
    $address=$_SESSION['address'];
    $image=$_SESSION['image'];
    $username=$_SESSION['username'];
}

if (!isset($_SESSION['selectedClass']) && !isset($_SESSION['selectedSubject'])) {
    header("Location: home.php");
    exit;
}

$selectedSubject=$_SESSION['selectedSubject'];
$selectedClass=$_SESSION['selectedClass'];

// Ensure the session variables are set
if (!isset($_SESSION['submitted_answers'], $_SESSION['questions'])) {
    header("Location: exam.php");
    exit;
}

$submittedAnswers = $_SESSION['submitted_answers'];
$questions = $_SESSION['questions'];

if (!isset($_SESSION['examname'], $_SESSION['starttime'], $_SESSION['endtime'])) {
    header("Location: exam.php");
    exit;
}

$examname=$_SESSION['examname'];
$starttime=$_SESSION['starttime'];
$endtime=$_SESSION['endtime'];
// Calculate the score
$score = 0;
foreach ($questions as $index => $question) {
    if (isset($submittedAnswers[$index]) && $submittedAnswers[$index] == $question['correct_answer']) {
        $score++;
    }
}

// Calculate percentage score
$percentageScore = ($score / count($questions)) * 100;

$_SESSION['totalQuestions'] = count($questions);
$_SESSION['score'] = $score;

$total=$_SESSION['totalQuestions'];
$score=$_SESSION['score'];

$Wrong = $total - $score;
$data = "$examname|$email|$username|$selectedClass|$selectedSubject|$total|$score|$starttime\n";

$file = "File Storage/result.txt";
$handle = fopen($file, "a");
fwrite($handle, $data);
fclose($handle);

   $hostname="Online Examination System";
   $hostemail="tarifhasangaragonj@gmail.com";
   $emailsubject="Exam Marks";
   $message="$username your Recent Result is here. Check it out <br><br>Exam Name: $examname<br>Class: $selectedClass <br> Subject: $selectedSubject <br><br>Yo've got $score out of $total. <br> Correct: $score and Wrong: $Wrong<br> <br> Click here to see your All Results and Ranks: <br>http://localhost/Online%20Examination%20System/profileresult.php <br><br> Regards <br> Online Exam System<br>Thank You";
    $email=$email;

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'tarifhasangaragonj@gmail.com'; //Host Email
    $mail->Password = 'ltfbfotczxsuhlkg'; // Host email App Password
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';
    $mail->isHTML(true);
    $mail->setFrom($hostemail, $hostname); // Sender's Email and Name
    $mail->addAddress("$email");
    $mail->Subject = ("$emailsubject");
    $mail->Body = $message;

if ($mail->send()) {
    echo "<br>Your result has been sent to $email.";
}else {
    echo "Email sending failed: " . $mail->ErrorInfo;
}

header("Location: result_display.php");
exit;
?>
