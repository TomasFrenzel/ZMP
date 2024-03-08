<?php
session_start();
$title = 'odpověd';
include_once('./temp/headingUser.php');
require_once('./temp/db_con.php');

$user_id = $_SESSION['id'];

//kontrola zda je uživatel přihlášený
$loggedIn = isset($_SESSION['id']);
    if($loggedIn){
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
        echo"
            <sesion class='container txt-color d-flex  align-items-center flex-column full-section'>
                <h1>Vyhodnocení odpovědi</h1>
                <p>$message</p>
                <p>Vaše body jsou : $points </p>
                <a href='quiz.php' class='button mt-3'>Další otázka</a>
                <a href='user.php' class='button mt-3'>Profil</a>
            </sesion>

        ";
    }else{
        header('location: block.php');
    }

    
?>
