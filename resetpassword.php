<?php
session_start();

// Handle invalid access
if (!isset($_SESSION['reset_email'])) {
    header("Location: index.php");
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];

    // Update password in users.txt file
    $email = $_SESSION['reset_email'];
    $users = file("File Storage/users.txt", FILE_IGNORE_NEW_LINES);
    $updatedUsers = [];
    foreach ($users as $user) {
        $userInfo = explode("|", $user);
        if ($userInfo[1] == $email) {
            // Update password
            $userInfo[2] = $password;
        }
        $updatedUsers[] = implode("|", $userInfo);
    }
    // Write updated users to file
    file_put_contents("File Storage/users.txt", implode(PHP_EOL, $updatedUsers));

    // Redirect to login page
    header("Location: index.php");
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
#forgetpassword{
    border: 1px solid black;
    margin-left: 400px;
    width: 400px;
    margin-top: 50px;
    padding: 20px;
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

            </div>
        </ul>
    </nav>
        <div id="forgetpassword">
    <h2>Reset Password</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        New Password: <input type="password" name="password"><br><br>
        <input type="submit" value="Reset">
    </form>
</div>
</body>
</html>
