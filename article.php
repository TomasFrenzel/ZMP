<?php
// Připojení k databázi
require_once('./temp/db_con.php');

// Kontrola, zda byl vybrán článek
if (!isset($_GET['id'])) {
    header('location: articles.php');
}

// SQL dotaz k vyhledání článku
$stmt = $con->prepare("SELECT * FROM articles WHERE id=?");
$stmt->bind_param('s', $_GET['id']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Název stránky
$title = $row['name'];

// Zahrnutí záhlaví
include_once('./temp/heading.php');

// Obsah stránky
echo $row['content'];

// Ukončení připojení k databázi
$con->close();

// Zahrnutí zápatí
include_once('./temp/footer.php');
?>