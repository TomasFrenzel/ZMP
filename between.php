<?php
session_start(); // Spustíme session, pokud nebyla již spuštěna
$title = 'test';
//zahlaví
include_once('./temp/heading.php');

//Propojení
require_once('./temp/db_con.php');


$user_id = $_SESSION['id'];

// Získání odpovědi uživatele a správné odpovědi
$user_answer = $_POST['answer']; // Odpověď uživatele
$correct_answer = $_POST['correct_answer']; // Správná odpověď

// Kontrola, zda je odpověď správná nebo nesprávná
if ($user_answer === $correct_answer) {
    $message = "Správná odpověď!";
    $_SESSION['score'] += 10; // Přidání bodu ke skóre
} else {
    $message = "Nesprávná odpověď. Správná odpověď byla: " . $correct_answer;
    $_SESSION['score'] = max(0, $_SESSION['score'] - 10); // Odečtení 10 bodů, ale minimálně 0
}

// Aktualizace skóre v databázi
$sql_update = "UPDATE scores SET score = score + $_SESSION['score'] WHERE user_id = $user_id";
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
    <a href="test.php">Další otázka</a>
</body>
</html>
