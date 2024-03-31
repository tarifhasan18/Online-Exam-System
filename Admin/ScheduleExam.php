<?php
error_reporting(0);
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
}else{
  $email=$_SESSION['email'];
}
if(isset($_POST['addexam']))
{
    $examname = $_POST['examname'];
    $starttime = $_POST['starttime'];
    $endtime = $_POST['endtime'];
    $formattedStartTime = date('Y-m-d H:i:s');
    $formattedEndTime = date('Y-m-d H:i:s');
    $data = "$examname|$starttime|$endtime\n";
    $filename = "../File Storage/exam.txt";

    // Append data to the file
    file_put_contents($filename, $data, FILE_APPEND | LOCK_EX);
    header("Location: ScheduleExam.php");
    exit();
}
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

// Read data from exam.txt
$exams = readExamData();

// Check if the index is provided in the POST request
if(isset($_POST['index'])) {
    $exams = readExamData();
    $index = $_POST['index'];

    // Remove the exam record at the specified index
    unset($exams[$index]);
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
            <li><a style=" font-family: cursive;" href="logout.php">Logout</a></li>
            <li style=" font-family: cursive;"><?php echo $_SESSION['email']?></li>
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
<h3 style="margin-top: 50px; margin-left: 660px">Set an Exam Schedule</h3>
<div class="scheduleexam_cat">
    <form id="scheduleexam_form" action="ScheduleExam.php" method="post" enctype="multipart/form-data">
        <p for="" style="font-weight: bold">Enter Exam Details</p>
        <input id="examname_admin" type="text" name="examname" placeholder="Enter Exam Name" required><br><br>
        <label style="font-size: 18px">Exam Start Time</label>
        <input type="datetime-local" name="starttime" step="1" placeholder="Enter Start Time" required><br><br>
        <label style="font-size: 18px">Exam Close Time</label>
        <input type="datetime-local" name="endtime" step="1" placeholder="Enter End Time" required><br><br>
        <button style="margin-left: 100px" type="submit" name="addexam">Scedule Exam</button>
    </form>
    <br>
        <div>
        <h2 style="text-align: center;">Exam Scheduled</h2>
        <table id="scheduleexam_list">
            <tr>
                <th>Exam Name</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Action</th>
            </tr>
            <?php foreach ($exams as $index => $exam) : ?>
                <tr>
                    <td><?php echo $exam['examname']; ?></td>
                    <td><?php echo $exam['starttime']; ?></td>
                    <td><?php echo $exam['endtime']; ?></td>
                    <td>
                        <form action="editexam.php" method="post">
                            <input type="hidden" name="index" value="<?php echo $index; ?>">
                            <input type="hidden" name="examname" value="<?php echo $exam['examname']; ?>">
                            <input type="hidden" name="starttime" value="<?php echo $exam['starttime']; ?>">
                            <input type="hidden" name="endtime" value="<?php echo $exam['endtime']; ?>">
                            <button id="scheduleexambutton" type="submit" name="edit">Edit</button>
                        </form>
                        <form action="ScheduleExam.php" method="post">
                            <input type="hidden" name="index" value="<?php echo $index; ?>">
                            <button id="scheduleexambutton" type="submit" name="delete">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>