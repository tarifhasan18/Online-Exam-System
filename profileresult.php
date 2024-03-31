<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit;
} else {
    $email = $_SESSION['email'];
    $address = $_SESSION['address'];
    $image = $_SESSION['image'];
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
}
error_reporting(0);

$file = "File Storage/result.txt";
$resultData = file($file, FILE_IGNORE_NEW_LINES);

$results = [];

foreach ($resultData as $line) {
    // Split the line into individual data elements
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

// Define an array to store ranks for each class and subject
$classSubjectRanks = [];
foreach ($results as $result) {
    $class = $result['class'];
    $subject = $result['subject'];
    $marks = $result['marks'];
    if (!isset($classSubjectRanks[$class][$subject])) {
        $classSubjectRanks[$class][$subject] = [];
    }
    $classSubjectRanks[$class][$subject][] = $marks;
}

// Sort marks for each class and subject in descending order
foreach ($classSubjectRanks as $class => &$subjects) {
    foreach ($subjects as $subject => &$marks) {
        arsort($marks);
    }
}
unset($subject);
unset($marks);

// Calculate ranks for each class and subject
foreach ($results as &$result) {
    $class = $result['class'];
    $subject = $result['subject'];
    $marks = $result['marks'];
    $rank = 1; // Initialize rank to 1
    foreach ($classSubjectRanks[$class][$subject] as $mark) {
        if ($marks < $mark) {
            $rank++;
        } else {
            break;
        }
    }
    $result['rank'] = $rank;
}
unset($result);

$outputFile = "File Storage/filtered_results.txt";
$fileHandle = fopen($outputFile, 'w');
if ($fileHandle === false) {
    echo "Error opening file for writing.";
} else {
    foreach ($results as $result) {
        $row = implode('|', $result) . "\n";
        fwrite($fileHandle, $row);
    }
    fclose($fileHandle);
}

$file = "File Storage/filtered_results.txt";
$resultData = file($file, FILE_IGNORE_NEW_LINES);

$results = [];

// Get the logged-in user's email
$email = $_SESSION['email'];

foreach ($resultData as $line) {
    $data = explode('|', $line);
    if ($data[2] === $email) { 
        $results[] = [
            'examname' => $data[0],
            'date' => $data[1],
            'class' => $data[4],
            'subject' => $data[5],
            'total' => $data[6],
            'marks' => $data[7],
            'rank' => $data[8] 
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="CSS/style.css" />
    <title>Online Examination System</title>
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
                <li><img style="float: left;  border-radius: 50%;" width="30px" height="30px" src="<?php echo $image ?>"><a href="profile.php" style="float: left; margin-top: 5px"><?php echo $username ?></a> </li>
            </div>
        </ul>
    </nav>
    <ul id="profileresult_nav2">
        <li id="profileresult_li2"><a class="" href="">Dashboard</a></li><hr>
        <li id="profileresult_li2"><a href="profile.php">Profile</a></li>
        <li id="profileresult_li2"><a class="active" href="profileresult.php">Result</a></li>
    </ul>
    <div class="profileresult_cat">
        <h2 style="text-align:center; margin-left: 190px;">Your Exam Results and Rank</h2>
        <table id="profileresults_customers">
            <tr>
                <th>Exam Name</th>
                <th>Date & Time</th>
                <th>Class</th>
                <th>Subject</th>
                <th>Full Marks</th>
                <th>Obtained Marks</th>
                <th>Rank</th>
            </tr>
            <?php foreach ($results as $result) : ?>
                <tr>
                    <td><?php echo $result['examname'] ?></td>
                    <td><?php echo $result['date'] ?></td>
                    <td><?php echo $result['class'] ?></td>
                    <td><?php echo $result['subject'] ?></td>
                    <td><?php echo $result['total'] ?></td>
                    <td><?php echo $result['marks'] ?></td>
                    <td><?php echo $result['rank'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>
