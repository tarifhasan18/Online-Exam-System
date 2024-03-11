<?php
error_reporting(0);
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    //exit;
}else{
  $email=$_SESSION['email'];
}


// Check if the delete button is clicked
if (isset($_POST['delete'])) {
    // Get the user data to be deleted
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Open the users.txt file
    $usersFile = "../File Storage/users.txt";

    // Read the content of the file into an array
    $usersData = file($usersFile, FILE_IGNORE_NEW_LINES);

    // Open the file for writing
    $file = fopen($usersFile, 'w');

    // Loop through the data to find the user with the provided email
    foreach ($usersData as $line) {
        // Split the line into components
        list($userDataUsername, $userDataEmail, $userDataPassword, $userDataAddress, $userDataImage) = explode("|", $line);

        // Check if the current line matches the user data to be deleted
        if ($userDataUsername == $username && $userDataEmail == $email) {
            // Skip writing this line
            continue;
        }

        // Write the line back to the file
        fwrite($file, "$userDataUsername|$userDataEmail|$userDataPassword|$userDataAddress|$userDataImage\n");
    }

    // Close the file
    fclose($file);

    // Redirect back to the users.php page
    header("Location: users.php");
    exit(); // Stop further execution
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
            margin-left: 50px;
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
            width: 100%;
            margin-left: 100px;
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
    <li id="li2"><a class="active"  href="users.php">Manage Users</a></li>
    <li id="li2"><a href="result.php">Results</a></li>
</ul>


<div class="cat">
    <br>
    <table id="customers">
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Address</th>
            <th>Action</th>
        </tr>
        <?php
        // Read data from users.txt file
        $usersData = file("../File Storage/users.txt", FILE_IGNORE_NEW_LINES);
        
        // Loop through each line of data
        foreach ($usersData as $userData) {
            // Split the line into an array of values
            $userDataArray = explode('|', $userData);
            // Extract username, email, and address from the array
            $username = $userDataArray[0];
            $email = $userDataArray[1];
            $password=$userDataArray[2];
            $address = $userDataArray[3];
            $image = $userDataArray[4];
            ?>
            <tr>
                <td><?php echo $username; ?></td>
                <td><?php echo $email; ?></td>
                <td><?php echo $address; ?></td>
                <td>
                    <form class="form3" action="users.php" method="post">
                        <input type="hidden" name="username" value="<?php echo $username; ?>">
                        <input type="hidden" name="email" value="<?php echo $email; ?>">
                        <input type="hidden" name="password" value="<?php echo $password; ?>">
                        <input type="hidden" name="address" value="<?php echo $address; ?>">
                        <input type="hidden" name="image" value="<?php echo $image; ?>">
                        <button id="button1" name="delete" type="submit">Remove</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>


</body>

 