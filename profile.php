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
function updateUser($newUsername, $newEmail, $newPassword, $newAddress, $currentUserEmail) {
    $users = file("File Storage/users.txt", FILE_IGNORE_NEW_LINES);
    foreach ($users as $key => $user) {
        list($storedUsername, $storedEmail, $storedPassword, $storedAddress, $storedImage) = explode("|", $user);

        if ($storedEmail === $currentUserEmail) {
            $users[$key] = "$newUsername|$newEmail|$newPassword|$newAddress|$storedImage";
            break;
        }
    }

    file_put_contents("File Storage/users.txt", implode("\n", $users));
}

if (isset($_POST['update'])) {
    $newUsername = $_POST['name'];
    $newEmail = $_POST['email'];
    $newAddress = $_POST['address'];
    $newPassword = $_POST['password'];

    $_SESSION['username'] = $newUsername;
    $_SESSION['email'] = $newEmail;
    $_SESSION['address'] = $newAddress;
    $_SESSION['password'] = $newPassword;

    updateUser($newUsername, $newEmail, $newPassword, $newAddress, $_SESSION['email']);
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
            </div>
        </ul>
    </nav>
<ul id="profile_nav2">
  <li id="profile_li2"><a class="" href="">Dashboard</a></li><hr>
  <li id="profile_li2"><a class="active" href="profile.php">Profile</a></li>
</ul>
<br><br>
<h2 style="text-align: center; margin-left: 100px;">Profile</h2>
    <div class="category">
    <div style='margin-left: 300px'>
        <img style='height: 140px; width: 160px;border-radius: 50%' src="<?php echo $image; ?>">
        </div>;
        <form style="margin-top: 20px;margin-left:220px" action="profile.php" method="post" enctype="multipart/form-data">
        <input style="font-size:17px;width: 350px; height: 50px; padding: 10px; background-color: aliceblue; border: 1px solid aliceblue;" type="text" name="name" value="<?php echo $username; ?>"><br><br>
        <input style="font-size:17px;width: 350px; height: 50px; padding: 10px; background-color: aliceblue; border: 1px solid aliceblue;" type="text" name="email" value="<?php echo $email;?>"><br><br>
        <input style="font-size:17px;width: 350px; height: 50px; padding: 10px; background-color: aliceblue; border: 1px solid aliceblue;" type="text" name="address" value="<?php echo $address;?>">
        <br><br>
        <input style="font-size:17px;width: 350px; height: 50px; padding: 10px; background-color: aliceblue; border: 1px solid aliceblue;" type="password" name="password" value="<?php echo $password;?>"><br>
        <input id="profile_update"  type="submit" name="update" value="Update Information">
        </form>
    </div>
  </body>
  </html>
