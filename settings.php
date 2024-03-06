<?php 
//stránka
$title = "nastavení";

//zahlaví
include_once('./temp/heading.php');

//Propojení
require_once('./temp/db_con.php');


echo"
    <form action='settings.php' method='post' enctype='multipart/form-data'>
        Select image to upload:
        <input type='file' name='fileToUpload' id='fileToUpload'>
        <input type='submit' value='Upload Image' name='submit'>
    </form>
";

// Kontrola připojení
if ($con->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Zpracování nahrávaného souboru
$target_dir = "uploads/"; // Adresář pro ukládání nahrávaných souborů
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Kontrola, zda je soubor skutečně obrázek
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } elseif ($check == Null){
        echo"nevybrali jste žádny soubor";
    }else {
        echo "Soubor není obrázek.";
        $uploadOk = 0;
    }
}


// Kontrola velikosti souboru
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Omllouváme se ake váš obrázek je moc velký.";
    $uploadOk = 0;
}

// Povolené formáty obrázků (zde jsem uvedl příklad pro JPEG)
if($imageFileType != "jpg" && $imageFileType != "jpeg") {
    echo "Omlouváme se ale jsou povoleny jenom JPG, JPEG.";
    $uploadOk = 0;
}

// Nahrání souboru, pokud všechny kontroly proběhnou v pořádku
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
        // Uložení cesty k obrázku do databáze
        $sql = "INSERT INTO users (profileImg) VALUES ('$target_file')";
        if ($con->query($sql) === TRUE) {
            echo "Nahraní probehlo uspešně.";
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    } else {
        echo "Omlouváme se ale nastala chyba v nahrárvaní souboru do databáze.";
    }
}

$con->close();



?>