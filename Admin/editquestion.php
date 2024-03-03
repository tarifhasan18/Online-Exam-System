<?php
session_start();
error_reporting(0);

if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
} else {
    $email = $_SESSION['email'];
}


if (isset($_POST['edit'])) {
    // Retrieve old and new values from the form
    $oldclass = $_POST['oldclass'];
    $newclass = $_POST['newclass'];
    $oldsubject = $_POST['oldsubject'];
    $newsubject = $_POST['newsubject'];
    $old_question = $_POST['old_question'];
    $new_question = $_POST['new_question'];
    $old_option1 = $_POST['old_option1'];
    $new_option1 = $_POST['new_option1'];
    $old_option2 = $_POST['old_option2'];
    $new_option2 = $_POST['new_option2'];
    $old_option3 = $_POST['old_option3'];
    $new_option3 = $_POST['new_option3'];
    $old_option4 = $_POST['old_option4'];
    $new_option4 = $_POST['new_option4'];
    $new_correct = $_POST['new_correct'];
    $old_correct = $_POST['old_correct'];

    // Read the content of the text file into an array
    $questionData = file("../File Storage/question.txt", FILE_IGNORE_NEW_LINES);

    // Loop through the question data to find the index of the old question
    foreach ($questionData as $key => $line) {
        // Split the line into components
        $parts = explode("|", $line);

        // Check if the current line matches the old question
        if ($parts[0] == $oldclass && $parts[1] == $oldsubject && $parts[2] == $old_question &&
            $parts[3] == $old_option1 && $parts[4] == $old_option2 && $parts[5] == $old_option3 &&
            $parts[6] == $old_option4 && $parts[7] == $old_correct) {

            // Update the question details with the new values
            $questionData[$key] = "$newclass|$newsubject|$new_question|$new_option1|$new_option2|$new_option3|$new_option4|$new_correct";

            // Write the modified array back to the file
            file_put_contents("../File Storage/question.txt", implode("\n", $questionData));

            // Redirect back to the subject list page
            header("Location: addquestion.php");
            exit();
        }
    }

    // If the old question is not found
    echo "Old question not found.";
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
    body {
      font-family: cursive;
    }

    .cat {
      margin-left: 250px;
      margin-top: 60px;
      padding: 10px;
      height: 500px;
      float: left;
    }

    .div1 {
      background-color: deeppink;
      padding-top: 23px;
      float: left;
      margin: 25px;
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

    #submit {
      margin-left: 100px;
      padding: 10px;
      border: 1px solid darkcyan;
      color: white;
      background-color: darkcyan;
      font-weight: bold;
    }

    #submit:hover {
      background-color: blue;
      border: 1px solid blue;
      color: white;
      cursor: pointer;
      padding: 10px;
    }

    #edit {
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

    #edit:hover {
      background-color: darkblue;
      color: white;
      cursor: pointer;
    }

    #form2 {
      border: 1px solid black;
      width: 400px;
      padding-left: 30px;
      padding-top: 20px;
      padding-bottom: 30px;
      margin-left: 100px;
      margin-top: 10px;
    }

    #newClassName {
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
    <li id="li2"><a href="home.php">Home</a></li>
    <li id="li2"><a class="active" href="addclass.php">Add Class</a></li>
    <li id="li2"><a href="addsubject.php">Add Subject</a></li>
    <li id="li2"><a href="#">Schedule Exam</a></li>
    <li id="li2"><a href="#">Add Question</a></li>
    <li id="li2"><a href="users.php">Manage Users</a></li>
    <li id="li2"><a href="#">Results</a></li>
  </ul>
  <div class="cat">
    <h2 style="text-align: center; margin-left: 70px">Edit Question</h2>
    <form id="form2" action="editquestion.php" method="post">
      <label>New Class</label>
      <input type="text" name="newclass" value="<?php echo $_POST['class'] ?>">
      <input type="hidden" name="oldclass" value="<?php echo $_POST['class'] ?>">

      <label>New Subject</label>
      <input type="text" name="newsubject" value="<?php echo $_POST['subject'] ?>">
      <input type="hidden" name="oldsubject" value="<?php echo $_POST['subject'] ?>">


      <label for="new_question">New Question:</label>
      <input type="text" id="new_question" name="new_question" value="<?php echo $_POST['question']; ?>">
      <input type="hidden" name="old_question" value="<?php echo $_POST['question']; ?>">

      <label for="new_option1">Option 1:</label>
      <input type="text" id="new_option1" name="new_option1" value="<?php echo $_POST['option1']; ?>">
      <input type="hidden" name="old_option1" value="<?php echo $_POST['option1']; ?>">

      <label for="new_option2">Option 2:</label>
      <input type="text" id="new_option2" name="new_option2" value="<?php echo $_POST['option2']; ?>">
      <input type="hidden" name="old_option2" value="<?php echo $_POST['option2']; ?>">

      <label for="new_option3">Option 3:</label>
      <input type="text" id="new_option3" name="new_option3" value="<?php echo $_POST['option3']; ?>">
      <input type="hidden" name="old_option3" value="<?php echo $_POST['option3']; ?>">

      <label for="new_option4">Option 4:</label>
      <input type="text" id="new_option4" name="new_option4" value="<?php echo $_POST['option4']; ?>">
      <input type="hidden" name="old_option4" value="<?php echo $_POST['option4']; ?>">

      <label for="new_correct">Correct Option:</label>
      <input type="text" id="new_correct" name="new_correct" value="<?php echo $_POST['correct']; ?>">
      <input type="hidden" name="old_correct" value="<?php echo $_POST['correct']; ?>">

      <button id="edit" type="submit" name="edit">Edit</button>
    </form>
  </div>
</body>
</html>
