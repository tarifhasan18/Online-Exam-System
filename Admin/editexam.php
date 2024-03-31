<?php
error_reporting(0);
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit;
} else {
    $email = $_SESSION['email'];
}
// Function to read data from the exam.txt file
function readExamData()
{
    $filename = "../File Storage/exam.txt";
    $examData = [];

    if (file_exists($filename)) {
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        foreach ($lines as $line) {
            $data = explode('|', $line);
            $examData[] = [
                'examname' => $data[0],
                'starttime' => $data[1],
                'endtime' => $data[2]
            ];
        }
    }

    return $examData;
}

// Check if form data is provided in the POST request
if (isset($_POST['examname']) && isset($_POST['starttime']) && isset($_POST['endtime']) && isset($_POST['index'])) {
    $exams = readExamData();
    $index = $_POST['index'];
    $exams[$index] = [
        'examname' => $_POST['examname'],
        'starttime' => $_POST['starttime'],
        'endtime' => $_POST['endtime']
    ];

    // Write the updated exam data back to the file
    $filename = "../File Storage/exam.txt";
    $file = fopen($filename, 'w');
    foreach ($exams as $exam) {
        fwrite($file, implode('|', $exam) . "\n");
    }
    fclose($file);
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
            <li><?php echo $_SESSION['email']?></li>
        </div>
    </ul>
</nav>
<ul id="nav2">
    <li id="li2"><a class="" href="#home">Dashboard</a></li><hr>
    <li id="li2"><a class="" href="home.php">Home</a></li>
    <li id="li2"><a class="" href="addclass.php">Add Class</a></li>
    <li id="li2"><a href="addsubject.php">Add Subject</a></li>
    <li id="li2"><a href="addchapter.php">Add Chapter</a></li>
    <li id="li2"><a class="active" href="ScheduleExam.php">Schedule Exam</a></li>
    <li id="li2"><a href="addquestion.php">Add Question</a></li>
    <li id="li2"><a href="users.php">Manage Users</a></li>
    <li id="li2"><a href="result.php">Results</a></li>
</ul>

<h3 style="margin-left: 610px; margin-top: 60px">Edit Exam Information</h3>
<div class="editexam_cat">
    <form id="editexam_form" method="post" action="editexam.php">
        <input type="text" name="index" value="<?php echo $_POST['index'];?>" hidden="">
        <p>Exam Name</p>
        <input type="text" name="examname" value="<?php echo $_POST['examname']?>"><br><br>
       <label style="font-size:x">Start Time</label> 
       <input type="datetime-local" step="1" name="starttime" value="<?php echo $_POST['starttime']?>"><br><br>
        <label>Close Time</label> 
        <input type="datetime-local" step="1" name="endtime" value="<?php echo $_POST['endtime']?>"><br><br>
        <input id="editexam" type="submit" name="Edit" value="Edit Information">
    </form>
</div>
</body>
</html>