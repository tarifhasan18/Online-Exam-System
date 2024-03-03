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
    // Read exam data from the file
    $exams = readExamData();

    // Get the index of the exam to edit
    $index = $_POST['index'];

    // Update the exam record at the specified index
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
    <style type="text/css">
        body{
            font-family: Arial;
        }
        .cat{
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
            float: left

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
            width: 700px;
            margin-left: 300px;
            margin-top: 50px;
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
            opacity: 0.8;
        }
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
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
            padding: 14px 20px;
            margin: 8px 0;
            float: left;
            border: none;
            cursor: pointer;
            width: 40%;
            margin: 2px;
        }
        #button1:hover{
            background-color: blue;
            color: white;
        }
        #form2{
            border: 1px solid black;
            width: 500px;
            padding-left: 70px;
            padding-top: 30px;
            padding-bottom: 30px;
            margin-left: 250px;
            margin-top: 0px;
        }
        #name,#address{
            width: 300px;
            padding: 10px;
            background-color: aliceblue;
            border: 1px solid aliceblue;
        }#name,#address:hover{
             border: 1px solid aliceblue;
             cursor: pointer;
         }
        #submit{
            margin-left: 100px;
            padding: 10px;
            border: 1px solid darkcyan;
            color: white;
            background-color: darkcyan;
            font-weight: bold;
        }
        #submit:hover{
            background-color: blue;
            border: 1px solid blue;
            color: white;
            cursor: pointer ;
            padding: 10px;
        }
        input[type=datetime-local]{
            width: 200px;
            height: 30px;
        }
        #editexam{
            width: 140px;
            height: 40px;
            background-color: darkcyan;
            border: 1px solid darkcyan;
            color: white;
            margin-left: 80px;
        }#editexam:hover{
            background-color: darkblue;
            color: white;
            cursor: pointer;
                 }
    </style>
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

<h3 style="margin-left: 610px; margin-top: 60px">Edit Exam Information</h3>
<div class="cat">
    <form id="form2" method="post" action="editexam.php">
        <input type="text" name="index" value="<?php echo $_POST['index'];?>" hidden="">
        <p>Exam Name</p>
        <input type="text" name="examname" value="<?php echo $_POST['examname']?>"><br><br>

       <label style="font-size:x">Start Time</label> 
       <input type="datetime-local" step="1" name="starttime" value="<?php echo $_POST['starttime']?>"><br><br>
        <label>Close Time</label> 
        <input type="datetime-local" step="1" name="endtime" value="<?php echo $_POST['endtime']?>"><br><br>
        <input id="editexam" type="submit" name="Edit" value="Edit Information">
        <?php

        ?>

    </form>


</div>

</body>

</html>