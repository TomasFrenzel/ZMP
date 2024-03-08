<?php
session_start();
$title = 'odpověd';
include_once('./temp/heading.php');
require_once('./temp/db_con.php');

$user_id = $_SESSION['id'];

$user_answer = $_POST['answer'];
$correct_answer = $_POST['correct_answer'];

$query = "SELECT score FROM scores WHERE idUsers=?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$row = $result->fetch_assoc();
$points = $row['score'];


if ($user_answer === $correct_answer) {
    $message = "Správná odpověď!";
    $points += 10;
} else {
    if($points <= 0){
        $message = "Nesprávná odpověď. Správná odpověď byla: " . $correct_answer;
    }else{
        $message = "Nesprávná odpověď. Správná odpověď byla: " . $correct_answer;
        $points -= 10;
    }
}

$sql_update = "UPDATE scores SET score = '$points' WHERE idUsers = '$user_id'";
$con->query($sql_update);

$con->close();
?>


<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vyhodnocení odpovědi</title>
</head>
<body>
    <h1>Vyhodnocení odpovědi</h1>
    <p><?php echo $message; ?></p>
    <p>Vaše body jsou :<?php echo $points?> </p>
    <a href="quiz.php">Další otázka</a>
</body>
</html>
