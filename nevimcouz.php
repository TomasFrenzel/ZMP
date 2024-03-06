// Kontrola, zda je odpověď správná nebo nesprávná
if ($user_answer === $correct_answer) {
    $message = "Správná odpověď!";
    $points += 10; // Přidání bodu ke skóre
} else {
    $message = " Nesprávná odpověď. Správná odpověď byla: " . $correct_answer;
    if ($points >= 10) {
        $points -= 10; // Odečtení 10 bodů, pokud je dostatek bodů
    } else {
        $points = 0; // Pokud není dostatek bodů, nastaví se skóre na 0
    }
}



if($_POST['endQuiz'] == 1){
    $query = "INSERT INTO answers(points) VALUES ('$points')";    
    
    $result = mysqli_query($con, $query);

     
}
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
    <h1>Vaše body jsou: <?php $points ?></h1>
    <h2>Vyhodnocení odpovědi</h2>
    <p><?php echo $message; ?></p>
    <a href="quiz.php">Další otázka</a>
    <form action="between.php" method="post">
        <input type='submit' name='endQuiz' value='Ukončit Quiz'>
    </form>
</body>
</html>