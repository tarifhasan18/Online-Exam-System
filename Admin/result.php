<?php
session_start();
error_reporting(0);
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit;
}
// Read the contents of the result.txt file
$file = "../File Storage/result.txt";
$resultData = file($file, FILE_IGNORE_NEW_LINES);

// Define an array to store the result data
$results = [];

// Check if the delete action is requested
if (isset($_POST['delete']) && $_POST['delete'] == 'Delete') {
    $examname = $_POST['examname'];
    // Remove the result with the specified exam name
    foreach ($resultData as $key => $line) {
        $data = explode('|', $line);
        if ($data[0] == $examname) {
            unset($resultData[$key]);
            break;
        }
    }
    // Write the updated data back to the file
    file_put_contents($file, implode("\n", $resultData));
    // Redirect to the same page to refresh the results
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

// Loop through each line of the file
foreach ($resultData as $line) {
    // Split the line into individual data elements
    $data = explode('|', $line);

    // Store the data in the results array
    $results[] = [
        'examname' => $data[0],
        'date' => $data[7],
        'email' => $data[1],
        'username' => $data[2],
        'class' => $data[3],
        'subject' => $data[4],
        'total' => $data[5],
        'marks' => $data[6]
    ];
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
        .cat{
            padding: 10px;
            height: 500px;
            float: left;
            border: ;
            margin-left: 5px;
            margin-top: 50px;
            width: 800px;
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
            width: 60%;
            padding: 12px 20px;
            margin: 8px 0;
            /*display: inline-block;*/
            border: 1px solid #ccc;
            box-sizing: border-box;
        }


        button:hover {
            opacity: 0.8;
        }
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 1010px;
            margin-left: 5px;
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
            margin-left: 28px;
            float: ;
            border: none;
            cursor: pointer;
            width: 100px;
            margin: 2px;
        }
        #button1:hover{
            background-color: blue;
            color: white;
        }
        #delete{
            background-color: red;
            color: white;
            font-weight: bold;
            border: 1px solid red;
            padding: 5px;
        }
        #delete:hover{
            cursor: pointer;
            background-color: blue;
            color: white;
            border: 1px solid blue;
        }
    </style>
</head>

<body>
<nav class="navbar">

    <div class="logo">Online Examination System</div>

    <ul class="nav-links">

        <div class="menu">

            <li><a href="logout.php">Logout</a></li>
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
    <li id="li2"><a href="ScheduleExam.php">Schedule Exam</a></li>
    <li id="li2"><a href="addquestion.php">Add Question</a></li>
    <li id="li2"><a href="users.php">Manage Users</a></li>
    <li id="li2"><a class="active"  href="result.php">Result</a></li>
</ul>


     <div class="cat">
        <h2 style="text-align:center; margin-left: 190px;">Previous All Exam Results</h2>
        <table id="customers">
            <tr>
                <th>Exam Name</th>
                <th>Date & Time</th>
                <th>Email</th>
                <th>Username</th>
                <th>Class</th>
                <th>Subject</th>
                <th>Full Marks</th>
                <th>Obtained Marks</th>
                <th>Action</th> <!-- New column for delete action -->

            </tr>
            <?php foreach ($results as $result) : ?>
                <tr>
                    <td><?php echo $result['examname'] ?></td>
                    <td><?php echo $result['date'] ?></td>
                    <td><?php echo $result['email'] ?></td>
                    <td><?php echo $result['username'] ?></td>
                    <td><?php echo $result['class'] ?></td>
                    <td><?php echo $result['subject'] ?></td>
                    <td><?php echo $result['total'] ?></td>
                    <td><?php echo $result['marks'] ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="examname" value="<?php echo $result['examname'] ?>">
                            <input type="submit" name="delete" value="Delete" id="delete">
                        </form>
                    </td> <!-- Button for delete action -->
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</body>

</html>
