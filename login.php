<?php
session_start();
//stránka
$title = "Login";

//zahlaví
include_once('./temp/heading.php');

//Propojení
require_once('./temp/db_con.php');

echo"
<H1>Prosím přihlašte se xddd</H1>
<form action='login.php' method='post'>
    <input type='email'placeholder='Email' name='email'><br>
    <input type='password'placeholder='heslo' name='password'><br>
    <input type='submit' name='login'value='Login'>
</form>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Zabezpečení proti SQL injection pomocí připraveného dotazu
    $query = "SELECT * FROM users WHERE email=?";    
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $passDat = $row["pass"];
        
        //kontrola zda je heslo správné
        if (password_verify(secouredPass($password), $passDat)){
            echo "Jste přihlášen";
            $_SESSION["email"] = $row["email"];
            $_SESSION["id"] = $row["id"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["prifilImg"] = $row["ProfilImg"]; //patrik pomůže s vkládnaním profilu

            // Získání id uživatele
            $idUsers = $row["id"];

            //kontrola zda se v tabulce nenachazí tento záznam
            $query = "SELECT * FROM scores WHERE idUsers=?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("i", $idUsers);
            $stmt->execute();
            $result = $stmt->get_result();

            //zadá počátek bodu pokud v tabulce jeste není
            if($result->num_rows == 0) {
                $startPoints = 0;
                $query = "INSERT INTO scores (idUsers, score) VALUES (?, ?)";
                $stmt = $con->prepare($query);
                $stmt->bind_param("ii", $idUsers, $startPoints);
                $stmt->execute();
            }

            //otevře testUser.php
            header('location: user.php');
        } else {
            echo "špatné heslo jste zadal";
        }
    } else {
        echo "Uživatel s tímto emailem neexistuje";
    }
}

function secouredPass($password) {
    // Definujte salt uvnitř funkce nebo jej předejte jako parametr
    $salt = 'saka9@*6sJAjh*hg5jS@d3*4sad*H@A';
    //algoritmus hesla
    return $salt . $password . chunk_split($salt, 12 , ".");
}

?>
