<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    //exit;
}else{
  $email=$_SESSION['email'];
}
if (isset($_POST['update'])) {
    if (isset($_POST['oldClassName']) && isset($_POST['newClassName']) && isset($_POST['oldSubjectName']) && isset($_POST['newSubjectName'])) {
        $oldClassName = $_POST['oldClassName'];
        $newClassName = $_POST['newClassName'];
        $oldSubjectName = $_POST['oldSubjectName'];
        $newSubjectName = $_POST['newSubjectName'];

        // Read the content of the text file into an array
        $subjectData = file("../File Storage/subject.txt", FILE_IGNORE_NEW_LINES);

        // Find the index of the old class and subject pair
        $index = array_search("$oldClassName|$oldSubjectName", $subjectData);

        // If the old class and subject pair is found, update it with the new values
        if ($index !== false) {
            $subjectData[$index] = "$newClassName|$newSubjectName";

            // Write the modified array back to the file
            file_put_contents("../File Storage/subject.txt", implode("\n", $subjectData));

            // Redirect back to the subject list page
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
<style type="text/css">
  body{
     font-family: cursive;
  }
  .cat{
    
    margin-left: 250px;
    margin-top: 60px;
    padding: 10px;
    height: 500px;
    float: left;
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
        #edit{
            width: 170px;
            background-color: darkcyan;
            color: white;
            border: 1px solid darkcyan;
            height: 40px;
            font-weight: bold;
            font-size: 17px;
            margin-top: 30px;
            margin-left: 100px;
        }
        #edit:hover{
            background-color: darkblue;
            color: white;
            cursor: pointer;
        }
        #form2{
            border: 1px solid black;
            width: 400px;
            padding-left: 30px;
            padding-top: 20px;
            padding-bottom: 30px;
            margin-left: 100px;
            margin-top: 10px;
        }
        #newClassName{
          padding: 10px;
        }
</style>
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

<div class="cat">
  <h2 style="text-align: center; margin-left: 70px">Edit Subject Info</h2>
    <form id="form2" action="editsubject.php" method="post">
        <label for="newClassName">New Class Name:</label>
        <input type="text" id="newClassName" name="newClassName" value="<?php echo $_POST['class'] ?>">
        <input type="hidden" name="oldClassName" value="<?php echo $_POST['class']; ?>"><br><br>
        <label for="newClassName">New Subject Name:</label>
        <input type="text" id="newClassName" name="newSubjectName" value="<?php echo $_POST['subject'] ?>">
        <input type="hidden" name="oldSubjectName" value="<?php echo $_POST['subject']; ?>">
        <button id="edit" type="submit" name="update">Update</button>
    </form>

</div>

</body>

</html>

