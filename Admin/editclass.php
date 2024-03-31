<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
}else{
  $email=$_SESSION['email'];
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
    <li id="li2"><a class="active" href="addclass.php">Add Class</a></li>
    <li id="li2"><a href="addsubject.php">Add Subject</a></li>
    <li id="li2"><a href="#">Schedule Exam</a></li>
    <li id="li2"><a href="#">Add Question</a></li>
    <li id="li2"><a href="users.php">Manage Users</a></li>
    <li id="li2"><a href="#">Results</a></li>
</ul>

<div class="editclass_cat">
  <h2 style="text-align: center; margin-left: 70px">Edit Class</h2>
    <form id="editclass_form" action="editclass.php" method="post">
        <label for="newClassName">New Class Name:</label>
        <input type="text" id="newClassName" name="newClassName" value="<?php echo $_POST['class'] ?>">
        <input type="hidden" name="oldClassName" value="<?php echo $_POST['class']; ?>">
        <button id="editclass" type="submit" name="update">Update</button>
    </form>
</div>
</body>
</html>
<?php
if (isset($_POST['update'])) {
  if (isset($_POST['oldClassName']) && isset($_POST['newClassName'])) {
        $oldClassName = $_POST['oldClassName'];
        $newClassName = $_POST['newClassName'];

        $classData = file("../File Storage/class.txt", FILE_IGNORE_NEW_LINES);

        // Find the index of the old class name
        $index = array_search($oldClassName, $classData);

         // If the old class name is found, update it with the new class name
        if ($index !== false) {
            $classData[$index] = $newClassName;

            // Write the modified array back to the file
            file_put_contents("../File Storage/class.txt", implode("\n", $classData));
            header("Location: addclass.php");
            exit();
        } else {
            echo "Old class name not found.";
        }
    } else {
        echo "Please provide both old and new class names.";
    }
}

?>