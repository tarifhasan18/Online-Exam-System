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
}

if (!isset($_SESSION['class'])) {
    // Redirect or handle the case where class is not set
    header("Location: home.php"); // Redirect to index.php or any appropriate page
    exit;
}
if (isset($_POST['class']) && isset($_POST['subject'])) {
    $_SESSION['selectedClass'] = $_POST['class'];
    $_SESSION['selectedSubject'] = $_POST['subject'];
    //echo $selectedSubject;
    if (isset($_SESSION['selectedClass']) && isset($_SESSION['selectedSubject'])) {
        header("Location: question2.php");
    }
}

$selectedClass = $_SESSION['class'];

$lines = file("File Storage/subject.txt", FILE_IGNORE_NEW_LINES);

$subjects = array();
foreach ($lines as $line) {
    $data = explode("|", $line);
    if ($data[0] == $selectedClass) {
        $subjects[] = $data[1];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subjects</title>
    <link rel="stylesheet" href="CSS/style.css" />
    <style type="text/css">
        body {
            font-family: cursive;
        }

        .category {
            border: 2px solid black;
            width: 815px;
            margin-left: 250px;
            margin-top: 10px;
            padding: 40px;
            height: 540px;
        }

        #subject {
            float: left;
        }

        #subjectname {
            background-color: #1C1C1C;
            color: white;
            width: 220px;
            height: 100px;
            margin: 10px;
            font-weight: bold;
        }

        #subjectname:hover {
            cursor: pointer;
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
            <li><a href="home.php">Home</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Contact Us</a></li>
            <li><a href="logout.php">Logout</a></li>
            <li><img style="float: left;  border-radius: 50%;" width="30px" height="30px" src="<?php echo $image; ?>"><a
                        href="profile.php"
                        style="float: left; margin-top: 5px"><?php echo $username; ?></a></li>
        </div>
    </ul>
</nav>
<br><br>
<h2 style="text-align: center;">Select a Subject for <?php echo $_SESSION['class']; ?></h2>
<div class="category">
    <?php
    if (empty($subjects)) {
        echo "No subjects found for this class.";
    } else {
        foreach ($subjects as $subject) {
            ?>
            <form id="subject" action='subject.php' method='post'>
                <input type="hidden" name="class" value="<?php echo htmlspecialchars($selectedClass); ?>">
                <input type="hidden" name="subject" value="<?php echo htmlspecialchars($subject); ?>">
                <button id="subjectname" type="submit" name="submit"><?php echo htmlspecialchars($subject); ?></button>
            </form>
            <?php
        }
    }
    ?>
</div>
</body>
</html>
