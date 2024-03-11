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


// Ensure the session variables are set
if (!isset($_SESSION['totalQuestions'], $_SESSION['score'], $_SESSION['questions'], $_SESSION['submitted_answers'])) {
    // Redirect to the exam page if session variables are not set
    header("Location: exam.php");
    exit;
}

$totalQuestions = $_SESSION['totalQuestions'];
$score = $_SESSION['score'];
$questions = $_SESSION['questions'];
$submittedAnswers = $_SESSION['submitted_answers'];

// Calculate percentage score
$percentageScore = ($score / $totalQuestions) * 100;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Result</title>
    <link rel="stylesheet" href="CSS/style.css">
    <style type="text/css">
                .scrollable-div {
            width: 420px; /* Set the width of the div */
            height: 250px; /* Set the height of the div */
            overflow: auto; /* Add scrollbars when content overflows */
            border: 1px solid #ccc; /* Add border for visualization */
            padding: 10px; /* Add padding for content */
            /* Add margin for spacing between divs */
            float: left;
            margin-left: 10px;
        }
        #category{
            margin-left: 200px;
            border: 2px solid black;
            height: 600px;
            width: 900px;
            margin-top:10px;
        }
        #result{
            margin-left: 400px;
        }
        #scroll{
            margin-top: 20px;
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
    <h3 style="text-align: center; margin-top: 40px;"><?php echo $username." Your Exam Results"; ?></h3>
    <div id="category">
            <div id="result">
                <h2>Exam Result</h2>
                <p><b>Name: <?php echo $username; ?></b></p>
                <p><b>Exam Name: <?php echo $_SESSION['examname']; ?></b></p>
                <p><b>Class: <?php echo $selectedClass; ?></b></p>
                <p><b>Subject: <?php echo $selectedSubject; ?></b></p>
                <p>Total Questions: <?php echo $totalQuestions; ?></p>
                <p>Correct Answers: <?php echo $score; ?></p>
                <p>Incorrect Answers: <?php echo $totalQuestions - $score; ?></p>
                <p>Your Score: <?php echo $score; ?>/<?php echo $totalQuestions; ?> (<?php echo $percentageScore; ?>%)</p>  
                <p>Go to to <a href="profileresult.php">Result</a> see your all previous results</p>
                <p>Your Result has been sent to <?php echo $email; ?></p>
            </div>
    
     <div id="scroll">
        <h2 style="text-align: center;">Correct Answers and Your Answers</h1>
        <div class="scrollable-div">
        <h3>Correct Answers:</h3>
        <ol>
            <?php foreach ($questions as $index => $question): ?>
                <li>
                    <p><strong>Question <?php echo $index + 1; ?>: </strong><?php echo $question['question']; ?></p>
                    <p><strong>Correct Answer: </strong><?php echo $question['correct_answer']; ?></p>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>

    <!-- Scrollable div for your answers -->
   
    <div class="scrollable-div">
         <h3>Your Answers:</h3>
        <ol>
            <?php foreach ($questions as $index => $question): ?>
                <li>
                    <p><strong>Question <?php echo $index + 1; ?>: </strong><?php echo $question['question']; ?></p>
                    <p><strong>Your Answer: </strong><?php echo isset($submittedAnswers[$index]) ? $submittedAnswers[$index] : "Not answered"; ?></p>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
        
     </div>
    </div>
</body>
</html>
