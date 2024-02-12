<?php 
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit;
}else{
  $email=$_SESSION['email'];
  $address=$_SESSION['address'];
  $image=$_SESSION['image'];
  $username=$_SESSION['username'];
  $password=$_SESSION['password'];
}
error_reporting(0);
// Function to update user information
// Function to update user information
function updateUser($newUsername, $newEmail, $newPassword, $newAddress, $currentUserEmail) {
    // Read user data from the file
    $users = file("File Storage/users.txt", FILE_IGNORE_NEW_LINES);

    // Loop through each line to find the user
    foreach ($users as $key => $user) {
        list($storedUsername, $storedEmail, $storedPassword, $storedAddress, $storedImage) = explode("|", $user);
        
        // Check if the stored email matches the current user's email
        if ($storedEmail === $currentUserEmail) {
            // Update user information
            $users[$key] = "$newUsername|$newEmail|$newPassword|$newAddress|$storedImage";
            break;
        }
    }

    // Save updated user data back to the file
    file_put_contents("File Storage/users.txt", implode("\n", $users));
}

// Check if the form has been submitted for updating user information
if (isset($_POST['update'])) {
    // Retrieve the updated information from the form
    $newUsername = $_POST['name'];
    $newEmail = $_POST['email'];
    $newAddress = $_POST['address'];
    $newPassword = $_POST['password'];

    // Update session variables with new information
    $_SESSION['username'] = $newUsername;
    $_SESSION['email'] = $newEmail;
    $_SESSION['address'] = $newAddress;
    $_SESSION['password'] = $newPassword;

    // Update user information in the file
    updateUser($newUsername, $newEmail, $newPassword, $newAddress, $_SESSION['email']);

    // Redirect back to profile.php to reflect the changes
    header("Location: profile.php");
    exit;
}

?>
<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="CSS/style.css" />
        <title>Online Examination System</title>
        <style type="text/css">
            body{
                 font-family: cursive;
            }
            .category{
                border: 2px solid black;
                width: 815px;
                margin-left: 250px;
                margin-top: 10px;
                padding: 40px;
                height: 540px;
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
            #class{
                float: left;

            }
            #classname{
                background-color: deeppink;
                color: white;
                width: 220px;
                height: 100px;
                margin: 10px;
                font-weight: bold;
            }#classname:hover{
                 cursor: pointer;
                 background-color: blue;
                 color: white;
             }
             #update{
                 margin-left: 80px;
                 width: 200px;
                 height: 40px;
                 background-color: blue;
                 color: white;
                 border: 1px solid blue;
                 text-align: center;
                 font-size: 17px;
             }
             #update:hover{
                 cursor: pointer;
                 color: white;
                 background-color: purple;

             }
             #nav2 {
                list-style-type: none;
                margin: 0;
                padding: 0;
                width: 170px;
                background-color: #f1f1f1;
                height: 700px;
                float: left
}#li2 a {
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
                <li><img style="float: left;  border-radius: 50%;" width="30px" height="30px" src="<?php echo $image?>"><a href="profile.php" style="float: left; margin-top: 5px"><?php echo $username;?></a> </li>
                <!--li><a href="profile.php"><?php echo $email ?></a></li-->

            </div>
        </ul>
    </nav>
<ul id="nav2">
  <li id="li2"><a class="" href="">Dashboard</a></li>
  <hr>
  <li id="li2"><a class="active" href="profile.php">Profile</a></li>

</ul>
<br>
    <br>
<h2 style="text-align: center; margin-left: 100px;">Profile</h2>
    <div class="category">
        <div style='margin-left: 300px'>
        <img style='height: 140px; width: 160px;border-radius: 50%' src="<?php echo $image; ?>">
        </div>;
        <form style="margin-top: 20px;margin-left:220px" action="profile.php" method="post" enctype="multipart/form-data">
           <!--label style="font-size: 18px; font-weight: bold">Username</label-->
            <!--input type="text" name="userid" value="<?php echo $_SESSION['userid']; ?>" hidden=""-->
            <input style="font-size:17px;width: 350px; height: 50px; padding: 10px; background-color: aliceblue; border: 1px solid aliceblue;" type="text" name="name" value="<?php echo $username; ?>">
            <br><br>
            <!--label style="font-size: 18px; font-weight: bold">Email</label-->
            <input style="font-size:17px;width: 350px; height: 50px; padding: 10px; background-color: aliceblue; border: 1px solid aliceblue;" type="text" name="email" value="<?php echo $email;?>">
            <br><br>
            <input style="font-size:17px;width: 350px; height: 50px; padding: 10px; background-color: aliceblue; border: 1px solid aliceblue;" type="text" name="address" value="<?php echo $address;?>">
            <br><br>
            <input style="font-size:17px;width: 350px; height: 50px; padding: 10px; background-color: aliceblue; border: 1px solid aliceblue;" type="password" name="password" value="<?php echo $password;?>">
            <br>
             <input id="update"  type="submit" name="update" value="Update Information">


        </form>

    </div>

    </body>

    </html>
