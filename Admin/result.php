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

$results = [];

// Check if the delete action is requested
if (isset($_POST['delete']) && $_POST['delete'] == 'Delete') {
    $examname = $_POST['examname'];
    foreach ($resultData as $key => $line) {
        $data = explode('|', $line);
        if ($data[0] == $examname) {
            unset($resultData[$key]);
            break;
        }
    }
    // Write the updated data back to the file
    file_put_contents($file, implode("\n", $resultData));
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

foreach ($resultData as $line) {
    $data = explode('|', $line);
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
    <li id="li2"><a href="users.php">Manage Users</a></li>
    <li id="li2"><a class="active"  href="result.php">Result</a></li>
</ul>
     <div class="admin_result_cat">
        <h2 style="text-align:center; margin-left: 190px;">Previous All Exam Results</h2>
        <table id="admin_result">
            <tr>
                <th>Exam Name</th>
                <th>Date & Time</th>
                <th>Email</th>
                <th>Username</th>
                <th>Class</th>
                <th>Subject</th>
                <th>Full Marks</th>
                <th>Obtained Marks</th>
                <th>Action</th> 
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
                    </td> 
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
