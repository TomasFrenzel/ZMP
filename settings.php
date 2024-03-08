<?php 

session_start();
//stránka
$title = "nastavení";

//zahlaví
include_once('./temp/heading.php');

//Propojení
require_once('./temp/db_con.php');

//funkce
require_once('./temp/function.php');

$username= $_SESSION["username"];
$idUsers = $_SESSION["id"];



echo"
    <form action='settings.php' method='post' enctype='multipart/form-data'>
        Select image to upload:
        <input type='file' name='fileToUpload' id='fileToUpload'>
        <input type='submit' value='Upload Image' name='submit'>
    </form>
";

// Kontrola připojení
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Zpracování nahrávaného souboru


if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $target_dir = "profileImg/"; // Adresář pro ukládání nahrávaných souborů

    // Kontrola, zda byl vybrán soubor
    if(empty($_FILES["fileToUpload"]["name"])) {
        echo "Musíte vybrat soubor.";
    } else {
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Pokračujte s nahráním souboru pouze pokud byl vybrán
        // (dále můžete přidat další kontroly, např. kontrolu typu souboru)
    }

    // Povolené formáty obrázků (zde jsem uvedl příklad pro JPEG)
 
    
    if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType !="png") {
        echo "Omlouváme se ale jsou povoleny jenom JPG, JPEG nebo PNG.";
        
    }

    // Nahrání souboru, pokud všechny kontroly proběhnou v pořádku

    else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            // Uložení cesty k obrázku do databáze
            $sql = "UPDATE users SET profileImg = '$target_file' WHERE id = '$idUsers'";
            if ($con->query($sql)) {
                echo "Soubor ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " se uspěšně nahrál.";
                $_SESSION["prifilImg"] = $target_file;
            } else {
                echo "Error: " . $sql . "<br>" . $con->error;
            }
        } else {
            echo "Omlouváme se ale nastala chyba v nahrárvaní souboru do databáze.";
        }
    }

$con->close();
}
