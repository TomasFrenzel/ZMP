<?php
//stránka
$title = "Register";

//zahlaví
include_once('./temp/heading.php');

//Propojení
require_once('./temp/db_con.php');
//funkce
require_once('./temp/function.php');

echo "<form action='register.php' method='post'>
    <input type='email' placeholder='Email' name='email'><br>
    <input type='password' placeholder='heslo' name='password'><br>
    <input type='password' placeholder='znova heslo' name='password2'><br>
    <input type='text' name='username' placeholder='username'>
    <input type='submit' name='submit' value='Odeslat'>
</form>";

if (isset($_POST["submit"])) {
    // kotroluje vyplnění polí
    if (isset($_POST["email"], $_POST["password"], $_POST["password2"], $_POST["username"]) &&
        !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["password2"]) && !empty($_POST["username"])) {
        
        // z formuláře
        $email = $_POST["email"];
        $password = $_POST["password"];
        $password2 = $_POST["password2"];
        $username = $_POST["username"];

        // Zkontrolujte, zda email neexistuje již v databázi
        $query = "SELECT * FROM users WHERE email=?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            if ($password == $password2) {
                // Bezpečné hashování hesla
                $hashPassword = password_hash(secouredPass($password), PASSWORD_BCRYPT, ['cost' => 12]);
                $gen_friednCode = generevoani_friendCode($con);

                // Vložení nového uživatele do databáze
                $query = "INSERT INTO users (email, pass, username, friendCode) VALUES (?, ?, ?, ?)";
                $stmt = $con->prepare($query);
                $stmt->bind_param("ssss", $email, $hashPassword, $username, $gen_friednCode);
                $stmt->execute();

                // Přesměrování na login.php po úspěšné registraci
                header('location: login.php');
                exit();
            } else {
                echo 'Jedno z vašich zadaných hesel se neshoduje';
            }
        } else {
            echo 'Tento emailová adresa je již využívána';
        }
    } else {
        echo "<h2>Musíte vyplnit všechna povinná pole</h2>";
    }
}

echo "<a href='login.php'><button type='button'>Login</button></a>";

// Definice funkce secouredPass()
function secouredPass($password) {
    // Definujte salt uvnitř funkce nebo jej předejte jako parametr
    $salt = 'saka9@*6sJAjh*hg5jS@d3*4sad*H@A';
    //algoritmus hesla
    return $salt . $password . chunk_split($salt, 12 , ".");
}
?>
