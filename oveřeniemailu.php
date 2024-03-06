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
    // Zkontrolujte vyplnění povinných polí
    if (isset($_POST["email"], $_POST["password"], $_POST["password2"], $_POST["username"]) &&
        !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["password2"]) && !empty($_POST["username"])) {
        
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
                // Generujte unikátní ověřovací kód
                $verificationCode = uniqid();

                // Bezpečné hashování hesla
                $hashPassword = password_hash(secouredPass($password), PASSWORD_BCRYPT, ['cost' => 12]);
                $gen_friednCode = generevoani_friendCode($con);

                // Vložení nového uživatele do databáze s ověřovacím kódem
                $query = "INSERT INTO users (email, pass, username, friendCode, verification_code, is_verified) VALUES (?, ?, ?, ?, ?, 0)";
                $stmt = $con->prepare($query);
                $stmt->bind_param("sssss", $email, $hashPassword, $username, $gen_friednCode, $verificationCode);
                $stmt->execute();

                // Odeslat ověřovací email
                $to = $email;
                $subject = 'Registrace na webu - ověření emailu';
                $message = "Děkujeme za registraci. Pro dokončení registrace prosím klikněte na následující odkaz: http://example.com/verify.php?code=$verificationCode";
                $headers = 'From: info@example.com' . "\r\n" .
                    'Reply-To: info@example.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                mail($to, $subject, $message, $headers);

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
?>
