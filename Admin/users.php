<?php
error_reporting(0);
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
}else{
  $email=$_SESSION['email'];
}
// Check if the delete button is clicked
if (isset($_POST['delete'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $usersFile = "../File Storage/users.txt";
    $usersData = file($usersFile, FILE_IGNORE_NEW_LINES);
    $file = fopen($usersFile, 'w');

    // find the user with the provided email
    foreach ($usersData as $line) {
        list($userDataUsername, $userDataEmail, $userDataPassword, $userDataAddress, $userDataImage) = explode("|", $line);
        if ($userDataUsername == $username && $userDataEmail == $email) {
            continue;
        }
        fwrite($file, "$userDataUsername|$userDataEmail|$userDataPassword|$userDataAddress|$userDataImage\n");
    }
    fclose($file);
    header("Location: users.php");
    exit();
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
            <li style=" font-family: cursive;"><?php echo $_SESSION['email']?></li>
        </div>
    </ul>
</nav>
<ul id="nav2">
    <li id="li2"><a class="" href="#home">Dashboard</a></li><hr>
    <li id="li2"><a class="" href="home.php">Home</a></li>
    <li id="li2"><a class="" href="addclass.php">Add Class</a></li>
    <li id="li2"><a href="addsubject.php">Add Subject</a></li>
    <li id="li2"><a href="ScheduleExam.php">Schedule Exam</a></li>
    <li id="li2"><a href="addquestion.php">Add Question</a></li>
    <li id="li2"><a class="active"  href="users.php">Manage Users</a></li>
    <li id="li2"><a href="result.php">Results</a></li>
</ul>
<div class="users_cat">
    <br>
    <table id="user_list">
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Address</th>
            <th>Action</th>
        </tr>
        <?php
        $usersData = file("../File Storage/users.txt", FILE_IGNORE_NEW_LINES);
        foreach ($usersData as $userData) {
            $userDataArray = explode('|', $userData);
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
                        <button id="remove_user" name="delete" type="submit">Remove</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
</body>

 