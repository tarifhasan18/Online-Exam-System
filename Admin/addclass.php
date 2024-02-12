<?php
session_start();
if(isset($_SESSION['email'])){
  
}else{
    header("Location: index.php");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $class = $_POST['class'];

    // Read existing classes from the file
    $classData = file("../File storage/class.txt", FILE_IGNORE_NEW_LINES);
    
    // Flag to track if the class already exists
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
        // If the class doesn't exist, insert it into the file
        $classData[] = $class; // Add the new class to the array
        $data = implode("\n", $classData); // Convert the array back to string with newlines
        file_put_contents("../File storage/class.txt", $data . "\n", LOCK_EX); // Append new class with newline
        echo "'$class' inserted successfully.";
    }
}
if (isset($_POST['delete'])) {
    $classToDelete = $_POST['class'];

    // Read the content of the text file into an array
    $classData = file("../File Storage/class.txt", FILE_IGNORE_NEW_LINES);

    // Find the index of the class name to delete
    $index = array_search($classToDelete, $classData);

    if ($index !== false) {
        // Remove the class name from the array
        unset($classData[$index]);

        // Write the modified array back to the file
        file_put_contents("../File Storage/class.txt", implode("\n", $classData));

        // Redirect back to the class list page
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
<style type="text/css">
  body{
    font-family: cursive;
  }
  .cat{
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
  width: 200px;
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
#form1 {
  		border: 3px solid #f1f1f1; 
  		width: 500px;
  		margin-left: 250px;
  		margin-top: 50px;
      padding:30px;
  	}

input[type=text], input[type=password] {
  width: 60%;
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
  width: 40%;
}

button:hover {
  opacity: 0.8;
}
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 600px;
  margin-left: 190px;
  margin-top: 50px;
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
.form2{
  text-align: center;
  margin-left: 60px;
}
#button1{
   background-color: red;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  float: left;
  border: none;
  cursor: pointer;
  width: 30%;
  margin: 2px;
}
#button1:hover{
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
        
        <li><a href="logout.php">Logout</a></li>
          <li><?php echo $_SESSION['email']?></li>

      </div>
    </ul>
  </nav> 
<ul id="nav2">
  <li id="li2"><a class="" href="#home">Dashboard</a></li>
  <hr>
    <li id="li2"><a class="" href="home.php">Home</a></li>

  <li id="li2"><a class="active" href="addclass.php">Add Class</a></li>
  <li id="li2"><a href="addsubject.php">Add Subject</a></li>
  <li id="li2"><a href="#">Schedule Exam</a></li>
  <li id="li2"><a href="#">Add Question</a></li>
  <li id="li2"><a href="#">Manage Users</a></li>
  <li id="li2"><a href="#">Results</a></li>

</ul>
 
<div class="cat">
    
  <form id="form1" action="addclass.php" method="post">
  <p for="">Enter Class name</p>
    <input type="text" name="class" placeholder="Enter class name" required><br>
    <button type="submit" name="addclass">Add Class</button>
  </form>
  <table id="customers">
        <thead>
            <tr>
                <th>Class Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Read class names from the file
            $classData = file("../File Storage/class.txt", FILE_IGNORE_NEW_LINES);

            // Output each class name with action buttons
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