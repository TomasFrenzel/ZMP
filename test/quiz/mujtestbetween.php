<?php
$title = "Testy";
//zahlaví
include_once('./temp/headingUser.php');
    
//Propojení
require_once('./temp/db_con.php');


//start session
session_start();
$idUsers=$_SESSION['id'];
$otazka=$_SESSION['otazka'];

$points= 1;


// Získání odpovědi uživatele a správné odpovědi
$user_answer = $_POST['answer']; // Odpověď uživatele
$correct_answer = $_POST['correct_answer']; // Správná odpověď z databaze

// Kontrola, zda je odpověď správná nebo nesprávná
if ($user_answer === $correct_answer) {
    $message = "Správná odpověď!";
    echo $message;
    $points += 10;
    echo $points;
    
} else {
    $message = " Nesprávná odpověď. Na otázku: " . $otazka . ". Správná odpověd byla: ". $correct_answer;
    echo $message;
    if ($points >= 10) {
        $points -= 10;
    } else {
        $points += 0;
    }
    echo $points;
}




if(isset($_POST["dalsiOtazka"])){
    $query = "SELECT * FROM answers WHERE idUsers='" . $idUsers . "'";
            
    $result = mysqli_query($con, $query);
        if(mysqli_num_rows($result) === 1){
            $query = "UPDATE answers SET points = '$points' WHERE idUsers = $idUsers";    
    
            $result = mysqli_query($con, $query);
            header('location: quiz.php');
        
        }else{
            $query = "INSERT INTO answers (idUsers, points) VALUES ('$idUsers', '$points')";

            $result = mysqli_query($con, $query);
            header('location: quiz.php');
        }
    
    
}


?>
<a href="quiz.php">Další otázka</a>
<form action="between.php">
    <input type="submit" name="dalsiOtazka" value="Další otázka">
</form>

