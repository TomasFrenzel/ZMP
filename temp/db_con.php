<?php
$servername = 'localhost';
$username = 'root';
$password = '303tina2005T'; // Mění se podle hesla localhostu
$db = 'bezpecnenanetu'; //zmenit az jakoby nebudu

$con = mysqli_connect($servername, $username, $password, $db);

if (!$con) {
    die('Connection error: ' . mysqli_connect_error());
}
?>