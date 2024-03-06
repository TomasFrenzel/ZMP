<?php
// Připojení k databázi
$servername = "localhost";
$username = "root"; // Změňte na své uživatelské jméno
$password = "303tina2005T"; // Změňte na své heslo
$database = "bezpecnenanetu"; // Změňte na název vaší databáze

$conn = new mysqli($servername, $username, $password, $database);

// Kontrola připojení
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Získání zadaného emailu z formuláře
$email = $_POST['email'];

// Dotaz na databázi pro ověření existence emailu
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);

// Kontrola výsledku dotazu
if ($result->num_rows > 0) {
    echo "Email already exists in the database.";
} else {
    echo "Email is available.";
}

$conn->close();
?>