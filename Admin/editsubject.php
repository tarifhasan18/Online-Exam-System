<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
}else{
  $email=$_SESSION['email'];
}
if (isset($_POST['update'])) {
    if (isset($_POST['oldClassName']) && isset($_POST['newClassName']) && isset($_POST['oldSubjectName']) && isset($_POST['newSubjectName'])) {
        $oldClassName = $_POST['oldClassName'];
        $newClassName = $_POST['newClassName'];
        $oldSubjectName = $_POST['oldSubjectName'];
        $newSubjectName = $_POST['newSubjectName'];
        $subjectData = file("../File Storage/subject.txt", FILE_IGNORE_NEW_LINES);

        // Find the index of the old class and subject pair
        $index = array_search("$oldClassName|$oldSubjectName", $subjectData);

        // If the old class and subject pair is found, update it with the new values
        if ($index !== false) {
            $subjectData[$index] = "$newClassName|$newSubjectName";
            file_put_contents("../File Storage/subject.txt", implode("\n", $subjectData));
            header("Location: addsubject.php");
            exit();
        } else {
            echo "Old class and subject pair not found.";
        }
    } else {
        echo "Please provide both old and new class names, as well as old and new subject names.";
    }
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
        <li><a href="#"><?php echo $email; ?></a></li>
      </div>
    </ul>
  </nav>
<ul id="nav2">
   <li id="li2"><a class="" href="">Dashboard</a></li>
   <li id="li2"><a  href="home.php">Home</a></li>
   <li id="li2"><a href="addclass.php">Add Class</a></li>
   <li id="li2"><a class="active" href="addsubject.php">Add Subject</a></li>
   <li id="li2"><a href="#">Schedule Exam</a></li>
   <li id="li2"><a href="#">Add Question</a></li>
   <li id="li2"><a href="users.php">Manage Users</a></li>
   <li id="li2"><a href="#">Results</a></li>
</ul>

<div class="editsubject_cat">
  <h2 style="text-align: center; margin-left: 70px">Edit Subject Info</h2>
    <form id="editquestion_form" action="editsubject.php" method="post">
        <label for="newClassName">New Class Name:</label>
        <input type="text" id="newClassName" name="newClassName" value="<?php echo $_POST['class'] ?>">
        <input type="hidden" name="oldClassName" value="<?php echo $_POST['class']; ?>"><br><br>
        <label for="newClassName">New Subject Name:</label>
        <input type="text" id="newClassName" name="newSubjectName" value="<?php echo $_POST['subject'] ?>">
        <input type="hidden" name="oldSubjectName" value="<?php echo $_POST['subject']; ?>">
        <button id="edit_question" type="submit" name="update">Update</button>
    </form>
</div>
</body>
</html>

