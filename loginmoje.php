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
</form>

";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Zabezpečení proti SQL injection pomocí připraveného dotazu
    $query = "SELECT * FROM users WHERE email='" . $email . "'";    
    
    $result = mysqli_query($con, $query);

    $salt = 'saka9@*6sJAjh*hg5jS@d3*4sad*H@A';
    

    if ($result) {
        // Kontrola, zda byl vrácen nějaký záznamu
        if (mysqli_num_rows($result) == 1) {

            while($row = mysqli_fetch_assoc($result)){
            $passDat=$row["pass"];
            
            //session email, id, username,  
            $_SESSION["email"] = $row["email"];
            $_SESSION["id"] = $row["id"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["prifilImg"] = $row["ProfilImg"]; //patrik pomůže s vkládnaním profilu

            }
            
            //salt
            
            //funcke databaze
            function secouredPass($password) {
                //algoritmus hesla
                return $salt . $password . chunk_split($salt, 12 , ".");
            }
            $hashPassword = password_hash(secouredPass($password), PASSWORD_BCRYPT,['cost' => 12]);
            

           


            
            //kontrola zda je heslo správné
           if (password_verify(secouredPass($password), $passDat)){
                echo "Jste přihlášen";
                while($row = mysqli_fetch_assoc($result)){
                    $idUsers = $_SESSION["id"];
                }

                 //kontrola zda se v tabulce nenachazí tento záznam
                $query = "SELECT * FROM scores WHERE idUsers='$idUsers'";    
    
                $result = mysqli_query($con, $query);
            
                //zadá počátek bodu pokud v tabulce jeste není
                if($result){
                    if (mysqli_num_rows($result) == 1){
                        $_SESSION['score'] = $row['score'];
                    }else{
                        $startPoints = 0;
                    
                        $query = "INSERT INTO scores (idUsers, score) VALUES ('$idUsers', '$startPoints')";
    
                        $result = mysqli_query($con, $query);
                    }
                }

                //otevře testUser.php
                header('location: user.php');


            }else {
                echo "špatné heslo jste zadal";
            }
        }   
    }else {
        echo "Uživatel s tímto emailem neexitusje";
        
        }
   
}




?>