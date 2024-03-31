<?php
session_start();
if(isset($_SESSION['email'])){
  
}else{
    header("Location: index.php");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $class = $_POST['class'];
    $classData = file("../File storage/class.txt", FILE_IGNORE_NEW_LINES);
    $classExists = false;
    // Check if the class already exists
    foreach ($classData as $storedClass) {
        if ($class === $storedClass) {
            $classExists = true;
            break;
        }
    }
    // If the class exists, show an alert
    if ($classExists) {
        echo "'$class' already exists.";
    } else {
        $classData[] = $class; 
        $data = implode("\n", $classData);
        file_put_contents("../File storage/class.txt", $data . "\n", LOCK_EX); 
        echo "'$class' inserted successfully.";
    }
}
if (isset($_POST['delete'])) {
    $classToDelete = $_POST['class'];
    $classData = file("../File Storage/class.txt", FILE_IGNORE_NEW_LINES);
    $index = array_search($classToDelete, $classData);
    if ($index !== false) {
        unset($classData[$index]);
        file_put_contents("../File Storage/class.txt", implode("\n", $classData));
        header("Location: addclass.php");
        exit();
    } else {
        echo "Class not found.";
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
<ul id="addclass_nav2">
  <li id="addclass_li2"><a class="" href="#home">Dashboard</a></li><hr>
  <li id="addclass_li2"><a class="" href="home.php">Home</a></li>
  <li id="addclass_li2"><a class="active" href="addclass.php">Add Class</a></li>
  <li id="addclass_li2"><a href="addsubject.php">Add Subject</a></li>
  <li id="addclass_li2"><a href="#">Schedule Exam</a></li>
  <li id="addclass_li2"><a href="#">Add Question</a></li>
  <li id="addclass_li2"><a href="#">Manage Users</a></li>
  <li id="addclass_li2"><a href="#">Results</a></li>
</ul>
 
<div class="addclass_cat">
  <form id="addclass_form" action="addclass.php" method="post">
  <p for="">Enter Class name</p>
    <input type="text" name="class" placeholder="Enter class name" required><br>
    <button id="addclass_button" type="submit" name="addclass">Add Class</button>
  </form>
  <table id="addclass_customers">
        <thead>
            <tr>
                <th>Class Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $classData = file("../File Storage/class.txt", FILE_IGNORE_NEW_LINES);
            foreach ($classData as $className) {
                ?>
                <tr>
                    <td><?php echo $className; ?></td>
                    <td>
                        <form action="editclass.php" method="post" style="display:inline;">
                            <input type="hidden" name="class" value="<?php echo $className; ?>">
                            <button type="submit" name="edit">Edit</button>
                        </form>
                        <form action="addclass.php" method="post" style="display:inline;">
                            <input type="hidden" name="class" value="<?php echo $className; ?>">
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