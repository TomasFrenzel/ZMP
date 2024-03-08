<?php
//stránka
$title = "Register";

//zahlaví
include_once('./temp/heading.php');

//Propojení
require_once('./temp/db_con.php');
//funkce
require_once('./temp/function.php');

echo "<sesion class='container d-flex  align-items-center flex-column full-section color'>
<h2 class='color p-4'>Registrovat se</h2>
<form action='register.php' method='post'>
    <input type='email' placeholder='Email' name='email' class=''><br>
    <input type='password' placeholder='heslo' name='password' class=''><br>
    <input type='password' placeholder='znova heslo' name='password2' class=''><br>
    <input type='text' name='username' placeholder='username' class=''  <br>
    <input type='submit' name='submit' value='Odeslat' class='button m-4 align-items-center' >
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
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $username))  {
            echo "<h4>Uživatelské jméno obsahuje nepovolené znaky</h4>";
            echo "<h5>Už máte účet?</h5>
            <a href='login.php'><img src='./img/test.svg' alt='logo'></a>
            </section>";
            exit(); // Zastaví běh pokud uživatelské jméno obsahuje nepovolené znaky
        }elseif(!preg_match('/^[a-zA-Z0-9_@]+$/', $password) || !preg_match('/^[a-zA-Z0-9_@]+$/', $password2)){
            echo "<h4>Heslo obsahuje nepovolené znaky</h4>";
            echo "<h5>Už máte účet?</h5>
            <a href='login.php'><img src='./img/test.svg' alt='logo'></a>
            </section>";
            exit(); // Zastaví běh pokud heslo obsahuje nepovolené znaky
        }

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
                $profileImgAuto="./profileImg/Group3AutoIMG987654321.svg";

                // Vložení nového uživatele do databáze
                $query = "INSERT INTO users (email, pass, username, friendCode, profileImg) VALUES (?, ?, ?, ?, ?)";
                $stmt = $con->prepare($query);
                $stmt->bind_param("sssss", $email, $hashPassword, $username, $gen_friednCode, $profileImgAuto);
                $stmt->execute();

                // Přesměrování na login.php po úspěšné registraci
                header('location: login.php');
                exit();
            } else {
                echo '<h4>Jedno z vašich zadaných hesel se neshoduje</h4> <br>';
            }
        } else {
            echo '<h4>Tento emailová adresa je již využívána</h4> <br>';
        }
    } else {
        echo "<h4>Musíte vyplnit všechna povinná pole</h4> <br>";
    }
}

echo "<h5>Už máte účet?</h5>
<a href='login.php'><img src='./img/login.svg' alt='logo'></a>
</section>";

?>
