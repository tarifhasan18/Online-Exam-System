<?php
session_start();
error_reporting(0);
if(isset($_SESSION['email'])){
  
}else{
    header("Location: index.php");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $class = $_POST['class'];
    $subject = $_POST['subject'];

    // Read existing data from the file
    $subjectData = file("../File storage/subject.txt", FILE_IGNORE_NEW_LINES);
    
    // Flag to track if the class and subject already exist
    $subjectExists = false;

    // Check if the class and subject already exist
    foreach ($subjectData as $sub) {
        list($storedClass, $storedSubject) = explode("|", $sub);
        if ($class === $storedClass && $subject === $storedSubject) {
            $subjectExists = true;
            break;
        }
    }

    // If the class and subject exist, show an alert
    if ($subjectExists) {
        echo "'$class' with subject '$subject' already exists.";
    } else {
        // Construct the new line to be inserted
        $newLine = "$class|$subject";

        // Add the new line to the array
        $subjectData[] = $newLine;

        // Convert the array back to a string with newlines
        $data = implode("\n", $subjectData);

        // Append the new line with a newline
        file_put_contents("../File storage/subject.txt", $data . "\n", LOCK_EX);

        echo "'$class' with subject '$subject' inserted successfully.";
    }
}

if (isset($_POST['delete'])) {
    $classToDelete = $_POST['class'];
    $subjectToDelete = $_POST['subject'];

    // Read the content of the text file into an array
    $subjectData = file("../File Storage/subject.txt", FILE_IGNORE_NEW_LINES);

    // Flag to track if the class and subject are found for deletion
    $deleted = false;

    // Loop through the subject data to find the index of the class and subject pair to delete
    foreach ($subjectData as $key => $line) {
        list($class, $subject) = explode("|", $line);
        if ($class == $classToDelete && $subject == $subjectToDelete) {
            // Remove the class and subject pair from the array
            unset($subjectData[$key]);
            $deleted = true;
            break;
        }
    }

    if ($deleted) {
        // Write the modified array back to the file
        file_put_contents("../File Storage/subject.txt", implode("\n", $subjectData));

        // Redirect back to the class list page or any other appropriate page
        header("Location: addsubject.php");
        exit();
    } else {
        echo "Class and subject pair not found.";
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
  <li id="li2"><a class="" href="#home">Dashboard</a></li>
  <hr>
  <li id="li2"><a class="" href="home.php">Home</a></li>
  <li id="li2"><a href="addclass.php">Add Class</a></li>
  <li id="li2"><a class="active" href="addsubject.php">Add Subject</a></li>
  <li id="li2"><a href="#">Schedule Exam</a></li>
  <li id="li2"><a href="#">Add Question</a></li>
  <li id="li2"><a href="#">Manage Users</a></li>
  <li id="li2"><a href="#">Results</a></li>
</ul>
 
<div class="addsubject_cat">
  <form id="addsubject_form" action="addsubject.php" method="post">
  <p for="">Enter Class & Subject name</p>
    <input class="addsubject_input_text" type="text" name="class" placeholder="Enter class name" required><br>
    <input class="addsubject_input_text" type="text" name="subject" placeholder="Enter subject name" required><br>
    <button id="addsubject_button " type="submit" name="addsubject">Add Subject</button>
  </form>
  <table id="addsubject_customers">
        <thead>
            <tr>
                <th>Class Name</th>
                <th>Subject Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
              
        $subjectData = file("../File Storage/subject.txt", FILE_IGNORE_NEW_LINES);
        foreach ($subjectData as $line) {
            // Split the line into class and subject
            list($className, $subjectName) = explode("|", $line);
                ?>
                <tr>
                    <td><?php echo $className; ?></td>
                    <td><?php echo $subjectName; ?></td>
                    <td>
                        <form action="editsubject.php" method="post" style="display:inline;">
                            <input type="hidden" name="class" value="<?php echo $className; ?>">
                            <input type="hidden" name="subject" value="<?php echo $subjectName; ?>">
                            <button type="submit" name="edit">Edit</button>
                        </form>
                        <form action="addsubject.php" method="post" style="display:inline;">
                            <input type="hidden" name="class" value="<?php echo $className; ?>">
                            <input type="hidden" name="subject" value="<?php echo $subjectName; ?>">
                            <button type="submit" name="delete">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>