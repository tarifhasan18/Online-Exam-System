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
    // Redirect to the exam page if session variables are not set
    header("Location: exam.php");
    exit;
}

$submittedAnswers = $_SESSION['submitted_answers'];
$questions = $_SESSION['questions'];

if (!isset($_SESSION['examname'], $_SESSION['starttime'], $_SESSION['endtime'])) {
    // Redirect to the exam page if session variables are not set
    header("Location: exam.php");
    exit;
}

$examname=$_SESSION['examname'];
$starttime=$_SESSION['starttime'];
$endtime=$_SESSION['endtime'];
// Calculate the score
$score = 0;
foreach ($questions as $index => $question) {
    // Check if the submitted answer matches the correct answer
    if (isset($submittedAnswers[$index]) && $submittedAnswers[$index] == $question['correct_answer']) {
        $score++;
    }
}

// Calculate percentage score
$percentageScore = ($score / count($questions)) * 100;

// Store necessary data in session for result display
$_SESSION['totalQuestions'] = count($questions);
$_SESSION['score'] = $score;

$total=$_SESSION['totalQuestions'];
$score=$_SESSION['score'];

$Wrong = $total - $score;
// Prepare the data to be inserted
$data = "$examname|$email|$username|$selectedClass|$selectedSubject|$total|$score|$starttime\n";

// Path to the result.txt file
$file = "File Storage/result.txt";

// Open the file in append mode
$handle = fopen($file, "a");

// Write the data to the file
fwrite($handle, $data);

// Close the file handle
fclose($handle);

$hostname="Online Examination System";
$hostemail="tarifhasangaragonj@gmail.com";

$emailsubject="Exam Marks";
$message="$username your Recent Result is here. Check it out <br><br>Exam Name: $examname<br>Class: $selectedClass <br> Subject: $selectedSubject <br><br>Yo've got $score out of $total. <br> Correct: $score and Wrong: $Wrong<br> <br> Click here to see your All Results and Ranks: <br>http://localhost/Online%20Examination%20System/profileresult.php <br><br> Regards <br> Online Exam System<br>Thank You";

$email=$email;
//$receiveremail="tarifhasan725@gmail.com";
//$receiverName="Tarif Hasan";

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


    //header("Location: ./index.php?=email_sent!");
    if ($mail->send()) {
    echo "<br>Your result has been sent to $email.";
}else {
    echo "Email sending failed: " . $mail->ErrorInfo;
}

// Redirect to the result display page
header("Location: result_display.php");
exit;
?>
