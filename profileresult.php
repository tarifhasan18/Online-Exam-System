<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit;
} else {
    $email = $_SESSION['email'];
    $address = $_SESSION['address'];
    $image = $_SESSION['image'];
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
}
error_reporting(0);

// Read the contents of the result.txt file
$file = "File Storage/result.txt";
$resultData = file($file, FILE_IGNORE_NEW_LINES);

// Define an array to store the result data
$results = [];

// Loop through each line of the file
foreach ($resultData as $line) {
    // Split the line into individual data elements
    $data = explode('|', $line);

    // Store the data in the results array
    $results[] = [
        'examname' => $data[0],
        'date' => $data[7],
        'email' => $data[1],
        'username' => $data[2],
        'class' => $data[3],
        'subject' => $data[4],
        'total' => $data[5],
        'marks' => $data[6]
    ];
}

// Define an array to store ranks for each class and subject
$classSubjectRanks = [];

// Loop through the results to calculate ranks for each class and subject
foreach ($results as $result) {
    $class = $result['class'];
    $subject = $result['subject'];
    $marks = $result['marks'];

    // Initialize an array to store ranks if not already set
    if (!isset($classSubjectRanks[$class][$subject])) {
        $classSubjectRanks[$class][$subject] = [];
    }

    // Add marks to the array for the current class and subject
    $classSubjectRanks[$class][$subject][] = $marks;
}

// Sort marks for each class and subject in descending order
foreach ($classSubjectRanks as $class => &$subjects) {
    foreach ($subjects as $subject => &$marks) {
        arsort($marks);
    }
}
unset($subject);
unset($marks);

// Calculate ranks for each class and subject
foreach ($results as &$result) {
    $class = $result['class'];
    $subject = $result['subject'];
    $marks = $result['marks'];
    $rank = 1; // Initialize rank to 1
    foreach ($classSubjectRanks[$class][$subject] as $mark) {
        // Compare the current marks with each mark in the sorted array
        if ($marks < $mark) {
            // If the current marks are less than the mark in the array, increment the rank
            $rank++;
        } else {
            // If the current marks are greater than or equal to the mark in the array, break the loop
            break;
        }
    }
    $result['rank'] = $rank; // Assign the rank to the result
}
unset($result);

// Define the path to the output text file
$outputFile = "File Storage/filtered_results.txt";

// Open the output file in write mode (create if it doesn't exist)
$fileHandle = fopen($outputFile, 'w');

// Check if the file opened successfully
if ($fileHandle === false) {
    echo "Error opening file for writing.";
} else {
    // Write each row of data to the file
    foreach ($results as $result) {
        $row = implode('|', $result) . "\n"; // Create a string representation of the row
        fwrite($fileHandle, $row); // Write the row to the file
    }

    // Close the file handle
    fclose($fileHandle);
}

// Read the contents of the result.txt file
$file = "File Storage/filtered_results.txt";
$resultData = file($file, FILE_IGNORE_NEW_LINES);

// Define an array to store the user's results
$results = [];

// Get the logged-in user's email
$email = $_SESSION['email'];

// Loop through each line of the file
foreach ($resultData as $line) {
    // Split the line into individual data elements
    $data = explode('|', $line);

    // Check if the email matches the logged-in user's email
    if ($data[2] === $email) { // Assuming email is at index 2
        // Store the data in the results array
        $results[] = [
            'examname' => $data[0],
            'date' => $data[1],
            'class' => $data[4],
            'subject' => $data[5],
            'total' => $data[6],
            'marks' => $data[7],
            'rank' => $data[8] // Assuming rank is at index 8
        ];
    }
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
        .cat {
            padding: 10px;
            height: 500px;
            float: left;
            border: ;
            margin-left: 5px;
            margin-top: 50px;
            width: 800px;
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

        #form1 {
            border: 3px solid #f1f1f1;
            width: 700px;
            margin-left: 300px;
            margin-top: 50px;
            padding: 30px;
        }

        input[type=text],
        input[type=password] {
            width: 60%;
            padding: 12px 20px;
            margin: 8px 0;
            /*display: inline-block;*/
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button:hover {
            opacity: 0.8;
        }

        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 1010px;
            margin-left: 5px;
        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #04AA6D;
            color: white;
        }

        #button1 {
            background-color: red;
            color: white;
            padding: 14px 20px;
            margin-left: 28px;
            float: ;
            border: none;
            cursor: pointer;
            width: 100px;
            margin: 2px;
        }

        #button1:hover {
            background-color: blue;
            color: white;
        }

        #delete {
            background-color: red;
            color: white;
            font-weight: bold;
            border: 1px solid red;
            padding: 5px;
        }

        #delete:hover {
            cursor: pointer;
            background-color: blue;
            color: white;
            border: 1px solid blue;
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
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="logout.php">Logout</a></li>
                <li><img style="float: left;  border-radius: 50%;" width="30px" height="30px"
                        src="<?php echo $image ?>"><a href="profile.php"
                        style="float: left; margin-top: 5px"><?php echo $username ?></a> </li>
                <!--li><a href="profile.php"><?php echo $email ?></a></li-->

            </div>
        </ul>
    </nav>
    <ul id="nav2">
        <li id="li2"><a class="" href="">Dashboard</a></li>
        <hr>
        <li id="li2"><a href="profile.php">Profile</a></li>
        <li id="li2"><a class="active" href="profileresult.php">Result</a></li>

    </ul>


    <div class="cat">
        <h2 style="text-align:center; margin-left: 190px;">Your Exam Results and Rank</h2>
        <table id="customers">
            <tr>
                <th>Exam Name</th>
                <th>Date & Time</th>
                <th>Class</th>
                <th>Subject</th>
                <th>Full Marks</th>
                <th>Obtained Marks</th>
                <th>Rank</th>
            </tr>
            <?php foreach ($results as $result) : ?>
                <tr>
                    <td><?php echo $result['examname'] ?></td>
                    <td><?php echo $result['date'] ?></td>
                    <td><?php echo $result['class'] ?></td>
                    <td><?php echo $result['subject'] ?></td>
                    <td><?php echo $result['total'] ?></td>
                    <td><?php echo $result['marks'] ?></td>
                    <td><?php echo $result['rank'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>
