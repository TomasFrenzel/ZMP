<?php
//start session
session_start();

//title
$title = "Quiz";

//zahlavi
require_once('./temp/headingUser.php');

//Propojení
require_once('./temp/db_con.php');

//session
$username=$_SESSION["username"];
$idUsers = $_SESSION["id"];

//kontrola zda je uživatel přihlášený
$loggedIn = isset($_SESSION['id']);
    if($loggedIn){
        //echo "<h1>ted se $username nachazíš v quizu :) </h1>";
// Získání náhodné otázky z databáze
$sql = "SELECT * FROM question ORDER BY RAND() LIMIT 1";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $otazka = $row["otazka"];
    $aText = $row["aText"];
    $bText = $row["bText"];
    $cText = $row["cText"];
    $spravna = $row["spravna"];
} else {
    echo "No questions found.";
}

$con->close();

//vytviření SESSIONS
$_SESSION['otazka']=$otazka;
echo"<h1>Bezpečnostní test</h1>
<form action='between.php' method='post'>
    <p>$otazka</p>
    <input type='radio' name='answer' value='a'> $aText <br>
    <input type='radio' name='answer' value='b'> $bText <br>
    <input type='radio' name='answer' value='c'> $cText <br>
    <input type='hidden' name='correct_answer' value=' $spravna'>
    <input type='submit' name='submit' value='Vyhodnotit'>
</form>";

    } else{
        header('location: block.php');
    }


?>


    

        



