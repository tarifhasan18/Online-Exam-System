<?php
session_start();
error_reporting(0);
if(isset($_SESSION['email'])){
  
}else{
    header("Location: index.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    // Retrieve data from the form
    $classToDelete = $_POST['class'];
    $subjectToDelete = $_POST['subject'];
    $questionToDelete = $_POST['question'];

    // Read the content of the text file into an array
    $questions = file("../File Storage/question.txt", FILE_IGNORE_NEW_LINES);

    // Flag to track if the question is found for deletion
    $deleted = false;

    // Loop through the questions to find the index of the question to delete
    foreach ($questions as $key => $line) {
        // Split the line into components
        list($class, $subject, $question, $option1, $option2, $option3, $option4, $correct) = explode("|", $line);

        // Check if the current line matches the question to delete
        if ($class == $classToDelete && $subject == $subjectToDelete && $question == $questionToDelete) {
            // Remove the question line from the array
            unset($questions[$key]);
            $deleted = true;
            break;
        }
    }

    if ($deleted) {
        // Write the modified array back to the file
        file_put_contents("../File Storage/question.txt", implode("\n", $questions));

        // Redirect back to the page or any other appropriate action
        header("Location: addquestion.php");
        exit(); // Ensure script stops executing after redirect
    } else {
        // Display message if the question was not found
        echo "Question not found.";
    }
}

// Check if the form is submitted for editing
// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
//     //Retrieve data from the form
//     $class = $_POST['class'];
//     $subject = $_POST['subject'];
//     $question = $_POST['question'];
//     $option1 = $_POST['option1'];
//     $option2 = $_POST['option2'];
//     $option3 = $_POST['option3'];
//     $option4 = $_POST['option4'];
//     $correct = $_POST['correct'];

//     // Pass the question details to the edit form
//     // You can use a query string or session to pass data to the edit form
//     $_SESSION['edit_question'] = [
//         'class' => $class,
//         'subject' => $subject,
//         'question' => $question,
//         'option1' => $option1,
//         'option2' => $option2,
//         'option3' => $option3,
//         'option4' => $option4,
//         'correct' => $correct
//     ];

//   $_SESSION['class']=$_POST['class'];
//   $_SESSION['subject']=$_POST['subject'];
//   $_SESSION['question']=$_POST['question'];
//   $_SESSION['option1']= $_POST['option1'];
//   $_SESSION['option2']= $_POST['option2'];
//   $_SESSION['option3']= $_POST['option3'];
//   $_SESSION['option4']= $_POST['option4'];
//   $_SESSION['correct']=$_POST['correct'];


//     // Redirect to the edit question page
//     header("Location: editquestion.php");
//     exit();
// }
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
    
    /*margin-left: 250px;
    margin-top: 60px;*/
    padding: 10px;
    height: 500px;
    float: left;
  }
  button {
  background-color: #04AA6D;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 60%;
}

button:hover {
  opacity: 0.8;
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
  height: 800px;
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
      margin-left: 200px;
      margin-top: 0px;
      padding:30px;
      float: left;
    }

input[type=text], input[type=password] {
  width: 80%;
  padding: 12px 20px;
  margin: 8px 0;
  /*display: inline-block;*/
  border: 1px solid #ccc;
  box-sizing: border-box;
}

button {
  background-color: #04AA6D;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;

  border: none;
  cursor: pointer;
  width: 60%;
}

button:hover {
  opacity: 0.8;
}
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 1200px;
    margin-top: 100px;
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
  margin: 8px 0;
  float: left;
  border: none;
  cursor: pointer;
  width: 100px;
  margin: 2px;
}
#button1:hover{
  background-color: blue;
  color: white;
}
#selectExam{
    width: 270px;
    height: 40px;
}
</style>
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
  <li id="li2"><a class="" href="#home">Dashboard</a></li>
  <hr>
    <li id="li2"><a class="" href="home.php">Home</a></li>

  <li id="li2"><a class="" href="addclass.php">Add Class</a></li>
  <li id="li2"><a href="addsubject.php">Add Subject</a></li>
    <li id="li2"><a href="ScheduleExam.php">Schedule Exam</a></li>
  <li id="li2"><a class="active" href="addquestion.php">Add Question</a></li>
    <li id="li2"><a href="users.php">Manage Users</a></li>
    <li id="li2"><a href="result.php">Results</a></li>
</ul>
 
<h3 style="margin-left: 650px;margin-top: 50px">Enter Exam Questions</h3>
<div class="cat">
<form id="form1" action="addquestion.php" method="post">
    <input type="text" name="class" placeholder="Enter class name" required><br>
    <input type="text" name="subject" placeholder="Enter subject name" required><br>
    <input type="text" name="question" placeholder="Enter question" required><br>
    <input type="text" name="option1" placeholder="Enter option1" required><br>
    <input type="text" name="option2" placeholder="Enter option2" required><br>
    <input type="text" name="option3" placeholder="Enter option3" required><br>
    <input type="text" name="option4" placeholder="Enter option4" required><br>
    <input type="text" name="correct" placeholder="Enter Correct Option" required><br>

    <button type="submit" name="addquestion">Add Question</button>
  </form>
<br>
  
</div><br>
<table id="customers">
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

      // Format the data for writing to file
      $data = "$class|$subject|$question|$option1|$option2|$option3|$option4|$correct";
      
      // Write the data to the file
      file_put_contents("../File Storage/question.txt", $data . PHP_EOL, FILE_APPEND);

}

    ?>

  <?php 
 // Display questions from question.txt in the table
    $questions = file("../File Storage/question.txt", FILE_IGNORE_NEW_LINES);
    foreach ($questions as $question) {
      // Extract question details
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
