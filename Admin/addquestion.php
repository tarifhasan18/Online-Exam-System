<?php
session_start();
error_reporting(0);
if(isset($_SESSION['email'])){
  
}else{
    header("Location: index.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $classToDelete = $_POST['class'];
    $subjectToDelete = $_POST['subject'];
    $questionToDelete = $_POST['question'];
    $questions = file("../File Storage/question.txt", FILE_IGNORE_NEW_LINES);

    // Flag to track if the question is found for deletion
    $deleted = false;

    foreach ($questions as $key => $line) {
        list($class, $subject, $question, $option1, $option2, $option3, $option4, $correct) = explode("|", $line);
        if ($class == $classToDelete && $subject == $subjectToDelete && $question == $questionToDelete) {
            unset($questions[$key]);
            $deleted = true;
            break;
        }
    }

    if ($deleted) {
        file_put_contents("../File Storage/question.txt", implode("\n", $questions));
        header("Location: addquestion.php");
        exit(); 
    } else {
        echo "Question not found.";
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
          <li><?php echo $_SESSION['email']?></li>
      </div>
    </ul>
  </nav> 
<ul id="nav2">
  <li id="addquestion_li2"><a class="" href="#home">Dashboard</a></li><hr>
  <li id="addquestion_li2"><a class="" href="home.php">Home</a></li>
  <li id="addquestion_li2"><a class="" href="addclass.php">Add Class</a></li>
  <li id="addquestion_li2"><a href="addsubject.php">Add Subject</a></li>
  <li id="addquestion_li2"><a href="ScheduleExam.php">Schedule Exam</a></li>
  <li id="addquestion_li2"><a class="active" href="addquestion.php">Add Question</a></li>
  <li id="addquestion_li2"><a href="users.php">Manage Users</a></li>
  <li id="addquestion_li2"><a href="result.php">Results</a></li>
</ul>
 
<h3 style="margin-left: 650px;margin-top: 50px">Enter Exam Questions</h3>
<div class="addquestion_cat">
<form id="addquestion_form1" action="addquestion.php" method="post">
    <input class="addquestion_input_text" type="text" name="class" placeholder="Enter class name" required><br>
    <input class="addquestion_input_text" type="text" name="subject" placeholder="Enter subject name" required><br>
    <input class="addquestion_input_text" type="text" name="question" placeholder="Enter question" required><br>
    <input class="addquestion_input_text" type="text" name="option1" placeholder="Enter option1" required><br>
    <input class="addquestion_input_text" type="text" name="option2" placeholder="Enter option2" required><br>
    <input class="addquestion_input_text" type="text" name="option3" placeholder="Enter option3" required><br>
    <input class="addquestion_input_text" type="text" name="option4" placeholder="Enter option4" required><br>
    <input class="addquestion_input_text" type="text" name="correct" placeholder="Enter Correct Option" required><br>
    <button type="submit" name="addquestion">Add Question</button>
  </form>
<br>
</div><br>

<table id="addquestion_customers">
   <tr>
    <th>Class Name</th>
    <th>Subject</th>
    <th>Question</th>
    <th>Option 1</th>
    <th>Option 2</th>
    <th>Option 3</th>
    <th>Option 4</th>
    <th>Correct Option </th>
    <th>Action</th>
   </tr>
<?php 

if(isset($_POST['addquestion']))
{
    $class=$_POST['class'];
    $subject=$_POST['subject'];
    $question=$_POST['question'];
    $option1=$_POST['option1'];
    $option2=$_POST['option2'];
    $option3=$_POST['option3'];
    $option4=$_POST['option4'];
    $correct=$_POST['correct'];

      $data = "$class|$subject|$question|$option1|$option2|$option3|$option4|$correct";
      file_put_contents("../File Storage/question.txt", $data . PHP_EOL, FILE_APPEND);
}
    ?>
  <?php 
    $questions = file("../File Storage/question.txt", FILE_IGNORE_NEW_LINES);
    foreach ($questions as $question) {
      list($class, $subject, $question, $option1, $option2, $option3, $option4, $correct) = explode("|", $question);
      ?>
      <tr>
        <td><?php echo $class; ?></td>
        <td><?php echo $subject; ?></td>
        <td><?php echo $question; ?></td>
        <td><?php echo $option1; ?></td>
        <td><?php echo $option2; ?></td>
        <td><?php echo $option3; ?></td>
        <td><?php echo $option4; ?></td>
        <td><?php echo $correct; ?></td>
        <td>
          <form action="editquestion.php" method="post">
            <input type="hidden" name="class" value="<?php echo $class; ?>">
            <input type="hidden" name="subject" value="<?php echo $subject; ?>">
            <input type="hidden" name="question" value="<?php echo $question; ?>">
            <input type="hidden" name="option1" value="<?php echo $option1; ?>">
            <input type="hidden" name="option2" value="<?php echo $option2; ?>">
            <input type="hidden" name="option3" value="<?php echo $option3; ?>">
            <input type="hidden" name="option4" value="<?php echo $option4; ?>">
            <input type="hidden" name="correct" value="<?php echo $correct; ?>">
        <button type="submit" name="edit">Edit</button>
          </form>
          <form action="addquestion.php" method="post">
            <input type="hidden" name="class" value="<?php echo $class; ?>">
            <input type="hidden" name="subject" value="<?php echo $subject; ?>">
            <input type="hidden" name="question" value="<?php echo $question; ?>">
            <button type="submit" name="delete">Delete</button>
          </form>
        </td>
      </tr>
    <p> </p>

    <?php 
  }

?>
 </table>
</body>
