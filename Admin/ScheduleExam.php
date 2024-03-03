<?php
error_reporting(0);
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    //exit;
}else{
  $email=$_SESSION['email'];
}
if(isset($_POST['addexam']))
{
    // Retrieve POST data
    $examname = $_POST['examname'];
    $starttime = $_POST['starttime'];
    $endtime = $_POST['endtime'];
    // Format the date and time values
    $formattedStartTime = date('Y-m-d H:i:s');
    $formattedEndTime = date('Y-m-d H:i:s');
    // Prepare data to be written to the file
    $data = "$examname|$starttime|$endtime\n";

    // File path
    $filename = "../File Storage/exam.txt";

    // Append data to the file
    file_put_contents($filename, $data, FILE_APPEND | LOCK_EX);

    // Redirect to a success page or do other actions as needed
    header("Location: ScheduleExam.php");
    exit();
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

// Read data from exam.txt
$exams = readExamData();

// Check if the index is provided in the POST request
if(isset($_POST['index'])) {
    // Read exam data from the file
    $exams = readExamData();
    
    // Get the index of the exam to delete
    $index = $_POST['index'];

    // Remove the exam record at the specified index
    unset($exams[$index]);

    // Write the updated exam data back to the file
    $filename = "../File Storage/exam.txt";
    $file = fopen($filename, 'w');
    foreach ($exams as $exam) {
        fwrite($file, implode('|', $exam) . "\n");
    }
    fclose($file);
}

// Redirect back to the page where the exam schedule is displayed
//header("Location: ScheduleExam.php");
//exit();
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
            font-family: ;
        }
        .cat{

            /*margin-left: 250px;
            margin-top: 60px;*/
            padding: 10px;
            height: 500px;
            float: left;

        }
        button {
            background-color: #04AA6D;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 60%;
            font-weight: bold;
        }

        button:hover {
            opacity: 0.8;
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
            float: left;
            font-family: cursive;
        }

        #li2 a {
            display: block;
            color: #000;
            padding: 8px 16px;
            text-decoration: none;
            font-family: cursive;
        }

        li a.active {
            background-color: #04AA6D;
            color: white;
        }

        li a:hover:not(.active) {
            background-color: #555;
            color: white;
        }
        #form1 {
            border: 3px solid #f1f1f1;
            width: 500px;
            margin-left: 290px;
            margin-top: 0px;
            padding:30px;
        }

        input[type=text], input[type=password] {
            width: 350px;
            padding: 12px 20px;
            margin: 8px 0;
            /*display: inline-block;*/
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            background-color: #04AA6D;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;

            border: none;
            cursor: pointer;
            width: 40%;
        }

        button:hover {
            background-color: darkblue;
            color: white;
        }
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 1000px;
            margin-left: 0px;
        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        #customers tr:nth-child(even){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;}

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #04AA6D;
            color: white;
        }
        #button1{
            background-color: red;
            color: white;

            margin: 8px 0;
            float: left;
            border: none;
            cursor: pointer;
            width: 70px;
            margin-left: 5px; 
        }
        #button1:hover{
            background-color: blue;
            color: white;
        }
        input[type=datetime-local]{
            width: 200px;
            height: 30px;
        }
    </style>
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
    <li id="li2"><a class="" href="#home">Dashboard</a></li>
    <hr>
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
<div class="cat">

    <form id="form1" action="ScheduleExam.php" method="post" enctype="multipart/form-data">
        <p for="" style="font-weight: bold">Enter Exam Details</p>
        <!--input type="text" name="examid" placeholder="Enter Exam ID" required><br-->
        <input type="text" name="examname" placeholder="Enter Exam Name" required><br><br>
        <label style="font-size: 18px">Exam Start Time</label>
        <input type="datetime-local" name="starttime" step="1" placeholder="Enter Start Time" required><br><br>
        <label style="font-size: 18px">Exam Close Time</label>
        <input type="datetime-local" name="endtime" step="1" placeholder="Enter End Time" required><br><br>
        <button style="margin-left: 100px" type="submit" name="addexam">Scedule Exam</button>
    </form>
    <br>
        <div>
        <h2 style="text-align: center;">Exam Scheduled</h2>
        <table id="customers">
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
                            <button id="button1" type="submit" name="edit">Edit</button>
                        </form>
                        <form action="ScheduleExam.php" method="post">
                            <input type="hidden" name="index" value="<?php echo $index; ?>">
                            <button id="button1" type="submit" name="delete">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</body>

</html>