<?php
// continue the session
session_start();
$pass = '303tina2005T';
$databaze = 'quiz';

// initialize the mysql data
$connect = mysql_connect('localhost', 'root', $pass, $databaze);
$select_db = mysql_select_db('mysql');

// get the quiz id from the session
$quiz_id = $_SESSION['quiz'];

// get the total number of questions in the quiz
$length = $_SESSION['length'];

// get the questions from the session
$_SESSION['questions_array'] = $_SESSION['questions'];
$current_question = array_shift($_SESSION['questions_array']);

// initialize the counter
$_SESSION['counter'] = 1;

// get the current question number
$counter = $_SESSION['counter'];

// select the current question from the database
$question_query = "SELECT * FROM questions WHERE quiz_id = $quiz_id AND question_number = $counter";
$question_result = mysql_query($question_query);
$question_row = mysql_fetch_assoc($question_result);

// select the answer choices for the current question from the database
$answer_query = "SELECT * FROM answer_choices WHERE question_id = {$question_row['id']}";
$answer_result = mysql_query($answer_query);

?>

<html>
<head>
	<title>Quiz <?php echo mysql_real_escape_string($_GET['id']);?></title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<div class="container">
		<h3><?php echo $question_row['question_text']; ?></h3>
		<form action="submit.php" method="post">
			<input type="hidden" name="question_id" value="<?php echo $question_row['id']; ?>">
			<div class="form-check">
				<?php while ($answer_row = mysql_fetch_assoc($answer_result)) {
					echo"<input class='form-check-input' type='radio' name='answer' id='$answer_row['id'] ' value=' $answer_row['answer_text'] ?>'
					<label class='form-check-label' for=' $answer_row['id']'>
						$answer_row['answer_text']";
                        
                    }
                        ?>