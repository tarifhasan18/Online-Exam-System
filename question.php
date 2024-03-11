<?php
error_reporting(0);
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit;
} else {
    $email=$_SESSION['email'];
    $address=$_SESSION['address'];
    $image=$_SESSION['image'];
    $username=$_SESSION['username'];
}

if (!isset($_SESSION['selectedClass']) && !isset($_SESSION['selectedSubject'])) {
    header("Location: home.php");
    exit;
}

$selectedSubject=$_SESSION['selectedSubject'];
$selectedClass=$_SESSION['selectedClass'];

// Read the content of the question.txt file
$filename = "File Storage/question.txt";
$questions = [];

if (file_exists($filename)) {
    $lines = file($filename, FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        $data = explode('|', $line);
        // Check if the question belongs to the selected class and subject
        if ($data[0] == $selectedClass && $data[1] == $selectedSubject) {
            $questions[] = [
                'class' => $data[0],
                'subject' => $data[1],
                'question' => $data[2],
                'options' => [$data[3], $data[4], $data[5], $data[6]],
                'correct_answer' => $data[7]
            ];
        }
    }
}

// Retrieve submitted answers from session if available
if(isset($_SESSION['submitted_answers'])) {
    $submittedAnswers = $_SESSION['submitted_answers'];
} else {
    $submittedAnswers = [];
}

// Read the content of the exam.txt file for countdown
$examFilename = "File Storage/exam.txt";
$examData = [];
$currentDateTime = date('Y-m-d H:i:s');

if (file_exists($examFilename)) {
    $examLines = file($examFilename, FILE_IGNORE_NEW_LINES);
    foreach ($examLines as $examLine) {
        $exam = explode('|', $examLine);
        $remainingTime = strtotime($exam[2]) - strtotime($currentDateTime); // Calculate remaining time
        $examData[] = [
            'examname' => $exam[0],
            'starttime' => $exam[1],
            'endtime' => $exam[2],
            'remaining_time' => $remainingTime
        ];
    }
}

//echo $examData['examname'];
$file = "File Storage/exam.txt";
    $lines = file($file);

    // Loop through each line and display its content
    foreach ($lines as $line) {
        // Split the line into examname, starttime, and endtime
        list($examname, $starttime, $endtime) = explode('|', $line);

        // Echo each variable
       // echo "<p>Exam Name: $examname</p>";
       // echo "<p>Start Time: $starttime</p>";
        //echo "<p>End Time: $endtime</p>";
        //echo "<hr>"; // Optional: Add a horizontal line between each exam
    }
    //echo $examname;
    $_SESSION['examname']=$examname;
    $_SESSION['starttime']=$starttime;
    $_SESSION['endtime']=$endtime;
            $formattedstarttime = date('Y-m-d H:i:s', strtotime($starttime));
         // Convert $endtime to desired format
        $formattedEndTime = date('Y-m-d H:i:s', strtotime($endtime));

        // Convert start time and end time to DateTime objects
$start_datetime = new DateTime($formattedstarttime);
$end_datetime = new DateTime($formattedEndTime);

// Calculate the difference between start time and end time
$time_difference = $start_datetime->diff($end_datetime);

// Get the total exam time in hours, minutes, and seconds
$total_hours = $time_difference->format('%h');
$total_minutes = $time_difference->format('%i');
$total_seconds = $time_difference->format('%s');

// Output the total exam time
//echo "Total exam time: $total_hours hours, $total_minutes minutes, $total_seconds seconds";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Store submitted answers in session
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'answer_') !== false) {
            $index = substr($key, strlen('answer_'));
            $submittedAnswers[$index] = $value;
        }
    }
    $_SESSION['submitted_answers'] = $submittedAnswers;

    // Store questions in session
    $_SESSION['questions'] = $questions;

    // Redirect to result processing page
    header("Location: process_exam.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Online Examination System</title>
    <style type="text/css">
        #category {
            border: 2px solid black;
            width: 830px;
            margin-left: 250px;
            margin-top: 60px;
            padding: 10px;
            height: 100%;
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
        body {
            font-family: cursive;
        }
          #countdown {
            font-size: 18px; /* Adjust font size as needed */
            /* Add spacing between countdown and submit button */
        }
        #examdetails{
            text-align: center;
            font-weight: bold;
        }
        #remainingTime{
            float: left;
        }
        #examstarted{
            float: right;
        }
        #myButton{
            background-color: blue;
            padding: 7px;
            color: white;
            font-weight: bold;
            border: 1px solid blue;
            margin-left: 350px;
        }
        #myButton:hover{
            cursor: pointer;
            opacity: .8;
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
                <!-- Add profile link -->
                <li><img style="float: left; border-radius: 50%;" width="30px" height="30px" src="<?php echo $image;?>"><a href="profile.php" style="float: left; margin-top: 5px"><?php echo $username;?></a></li>
            </div>
        </ul>
    </nav>
    <br>


    <p id="currentTime" style="text-align: center;margin-left: 70px;"></p>

    <script>
        // Function to reload the page
        function reloadPage() {
            location.reload(); // Reload the current page
        }

        // Schedule the reload at the specified time
        function scheduleReload(reloadTime) {
            var reloadDate = new Date(reloadTime); // Parse the reload time string
            var now = new Date(); // Get the current date and time
            var timeUntilReload = reloadDate - now; // Calculate the time until reload
            if (timeUntilReload < 0) {
                // If the reload time is in the past, schedule it for the next day
                timeUntilReload += 24 * 60 * 60 * 1000; // Add 24 hours
            }
            setTimeout(reloadPage, timeUntilReload); // Schedule the reload
        }

        // Example: Reload the page at the specified PHP reload time
        scheduleReload('<?php echo $starttime; ?>');
    </script>

<script>
    // Function to update the current time
    function updateCurrentTime() {
        // Get the current time
        var currentTime = new Date();

        // Format the time as desired
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var seconds = currentTime.getSeconds();

        // Add leading zeros if needed
        hours = (hours < 10 ? "0" : "") + hours;
        minutes = (minutes < 10 ? "0" : "") + minutes;
        seconds = (seconds < 10 ? "0" : "") + seconds;

        // Display the formatted time
        document.getElementById("currentTime").textContent = hours + ":" + minutes + ":" + seconds;
    }

    // Call the updateCurrentTime function initially to display the current time
    updateCurrentTime();

    // Update the current time every second
    setInterval(updateCurrentTime, 1000);
</script>

    <?php if (empty($questions)): ?>
        <p>No questions found for the selected class and subject.</p>
    <?php else: ?>
        <div id="category">
            <div id="examdetails">
                <p><?php echo $_SESSION['examname']; ?></p>
          <p>Subject: <?php echo $selectedSubject; ?></p>
          <p>Class: <?php echo $selectedClass; ?></p>
          <p>Total Time: <?php echo "$total_hours hr: $total_minutes min: $total_seconds sec"; ?></p>
          <!--p>Exam Started at: <?php echo $formattedstarttime; ?></p-->
          <br>
          <hr>
                
            </div>
          <div id="remainingTime">
            <label style="float: left;">Remaining Time: </label><div id="countdown"></div>
              
          </div>
          <div id="examstarted">
            <label style="float: ">Exam Started: <br><?php echo $formattedstarttime; ?></label>
              
          </div><br><br><br>
          
            <form id="examForm1" method="post">
                <!--h2>MCQ Questions for <?php echo $selectedClass; ?> - <?php echo $selectedSubject; ?></h2-->
                <?php foreach ($questions as $index => $question): ?>
                    <p><strong><?php echo ($index + 1) . ". " . $question['question']; ?></strong></p>
                    <?php foreach ($question['options'] as $option): ?>
                        <label>
                            <input type="radio" name="answer_<?php echo $index; ?>" value="<?php echo $option; ?>" <?php if(isset($submittedAnswers[$index]) && $submittedAnswers[$index] == $option) echo 'checked'; ?>>
                            <?php echo $option; ?><br>
                        </label>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <br><br>
                <button id="myButton" name="submit">Submit Answer</button>
            </form>
        </div>
    <?php endif; ?>

<script>
        function countdownTimer(endtime) {
            var endTime = new Date(endtime).getTime();
            
            var interval = setInterval(function() {
                var currentTime = new Date().getTime();
                var remainingTime = endTime - currentTime;

                if (remainingTime <= 0) {
                    clearInterval(interval);
                    //document.getElementById('countdown').innerHTML = "EXPIRED";
                    //document.getElementById("myButton").submit(); // Automatically submit the form
                } else {
                    var seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);
                    var minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
                    var hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    document.getElementById('countdown').innerHTML = hours + "h " + minutes + "m " + seconds + "s ";
                }
            }, 1000);
        }

        countdownTimer("<?php echo $formattedEndTime ?>"); // Pass end time as parameter
    </script>

<script>
// Define the function to auto-submit the form
function autoSubmitForm() {
    // Trigger a click event on the submit button
    document.getElementById("myButton").click();
}

// Get the current time
const currentTime = new Date();

// Define the time at which you want to auto-submit the form (replace with your desired time)
const desiredTime = new Date("<?php echo $formattedEndTime; ?>"); // Example: February 14, 2024, 19:50:00

// Calculate the delay until the desired time
const delay = desiredTime.getTime() - currentTime.getTime();

// Check if the desired time is in the future
if (delay > 0) {
    // Set a timeout to auto-submit the form at the desired time
    setTimeout(autoSubmitForm, delay);
}

  </script>

<!--p id="contentToHide">Hi</p-->
<p id="message" style="text-align: center;">No Exam is available now. Please Wait for the next schedule. Next Exam is at: <?php echo $starttime; ?></p>


<script>
    // Function to run after the document has finished loading
    document.addEventListener("DOMContentLoaded", function() {
        // Get current time
        const currentTime = new Date();

        // Define start and end times
        const startTime = new Date("<?php echo $formattedstarttime; ?>");
        const endTime = new Date("<?php echo $formattedEndTime; ?>");

        // Compare current time with start and end times
        if (currentTime >= startTime && currentTime <= endTime) {
            // Current time is between start and end times
            document.getElementById("category").style.display = "block"; // Show 
            document.getElementById("message").style.display = "none"; // Hide messagecontent
        }
        else{
            // Current time is not between start and end times
            document.getElementById("category").style.display = "none"; // Hide
           document.getElementById("message").style.display = "block"; // Show message content
        }
    });
</script>


</body>
</html>