<?php
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

$filename = "File Storage/question.txt";
$questions = [];

if (file_exists($filename)) {
    $lines = file($filename, FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        $data = explode('|', $line);
        // Check if the question belongs to the selected class and subject
        if ($data[0] == $selectedClass && $data[1] == $selectedSubject) {
            $questions[] = [
                'class' => $data[0],
                'subject' => $data[1],
                'question' => $data[2],
                'options' => [$data[3], $data[4], $data[5], $data[6]],
                'correct_answer' => $data[7]
            ];
        }
    }
}

// Retrieve submitted answers from session if available
if(isset($_SESSION['submitted_answers'])) {
    $submittedAnswers = $_SESSION['submitted_answers'];
} else {
    $submittedAnswers = [];
}

$examFilename = "File Storage/exam.txt";
$examData = [];
$currentDateTime = date('Y-m-d H:i:s');

if (file_exists($examFilename)) {
    $examLines = file($examFilename, FILE_IGNORE_NEW_LINES);
    foreach ($examLines as $examLine) {
        $exam = explode('|', $examLine);
        $remainingTime = strtotime($exam[2]) - strtotime($currentDateTime); // Calculate remaining time
        $examData[] = [
            'examname' => $exam[0],
            'starttime' => $exam[1],
            'endtime' => $exam[2],
            'remaining_time' => $remainingTime
        ];
    }
}

$file = "File Storage/exam.txt";
    $lines = file($file);
    foreach ($lines as $line) {
        list($examname, $starttime, $endtime) = explode('|', $line);
    }
    $_SESSION['examname']=$examname;
    $_SESSION['starttime']=$starttime;
    $_SESSION['endtime']=$endtime;
    $formattedstarttime = date('Y-m-d H:i:s', strtotime($starttime));
    $formattedEndTime = date('Y-m-d H:i:s', strtotime($endtime));

    $start_datetime = new DateTime($formattedstarttime);
    $end_datetime = new DateTime($formattedEndTime);

    $time_difference = $start_datetime->diff($end_datetime);

    $total_hours = $time_difference->format('%h');
    $total_minutes = $time_difference->format('%i');
    $total_seconds = $time_difference->format('%s');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'answer_') !== false) {
            $index = substr($key, strlen('answer_'));
            $submittedAnswers[$index] = $value;
        }
    }
    $_SESSION['submitted_answers'] = $submittedAnswers;
    $_SESSION['questions'] = $questions;
    header("Location: process_exam.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Online Examination System</title>
    <script src="main.js"></script>
</head>
<body>
    <nav class="navbar">
        <div class="logo">Online Examination System</div>
        <ul class="nav-links">
            <div class="menu">
                <li><a href="home.php">Home</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="logout.php">Logout</a></li>
                <li><img style="float: left; border-radius: 50%;" width="30px" height="30px" src="<?php echo $image;?>"><a href="profile.php" style="float: left; margin-top: 5px"><?php echo $username;?></a></li>
            </div>
        </ul>
    </nav>
    <br>
    <p id="currentTime" style="text-align: center;margin-left: 70px;"></p>

    <?php if (empty($questions)): ?>
        <p>No questions found for the selected class and subject.</p>
    <?php else: ?>
        <div id="question_category">
            <div id="examdetails">
               <p><?php echo $_SESSION['examname']; ?></p>
               <p>Subject: <?php echo $selectedSubject; ?></p>
               <p>Class: <?php echo $selectedClass; ?></p>
               <p>Total Time: <?php echo "$total_hours hr: $total_minutes min: $total_seconds sec"; ?></p><br><hr>     
            </div>
          <div id="remainingTime">
            <label style="float: left;">Remaining Time: </label><div id="countdown"></div>
          </div>
          <div id="examstarted">
            <label style="float: ">Exam Started: <br><?php echo $formattedstarttime; ?></label>
          </div><br><br><br>
            <form id="examForm1" method="post">
                <?php foreach ($questions as $index => $question): ?>
                    <p><strong><?php echo ($index + 1) . ". " . $question['question']; ?></strong></p>
                    <?php foreach ($question['options'] as $option): ?>
                        <label>
                            <input type="radio" name="answer_<?php echo $index; ?>" value="<?php echo $option; ?>" <?php if(isset($submittedAnswers[$index]) && $submittedAnswers[$index] == $option) echo 'checked'; ?>>
                            <?php echo $option; ?><br>
                        </label>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <br><br>
                <button id="submit_answer" name="submit">Submit Answer</button>
            </form>
        </div>
    <?php endif; ?>

<p id="message" style="text-align: center;">No Exam is available now. Please Wait for the next schedule. Next Exam is at: <?php echo $starttime; ?></p>
</body>
</html>