<?php
//stránka
$title = "Register";

//zahlaví
include_once('./temp/heading.php');

//Propojení
require_once('./temp/db_con.php');
//funkce
require_once('./temp/function.php');



echo"<form action='register.php' method='post'>
<input type='email'placeholder='Email' name='email'><br>
<input type='password'placeholder='heslo' name='password'><br>
<input type='password'placeholder='znova heslo' name='password2'><br>
<input type='text' name='username'placeholder='username'>
<input type='submit' name='submit'value='Odelsat'>
</form>

";
if (isset($_POST["submit"])) {

        // Check if all required fields are set
        if (isset($_POST["email"], $_POST["password"], $_POST["password2"], $_POST["username"])){
                    $email = $_POST["email"];
                    $password = $_POST["password"];
                    $password2 = $_POST["password2"];
                    $username = $_POST["username"];
            
                    $query = "SELECT * FROM users WHERE email='" . $email . "'";
            
                    $result = mysqli_query($con, $query);
                    if(mysqli_num_rows($result) === 0){
                    //vnořt if   
                    if (!($password == $password2)) {

                        echo 'Jendo z vaších zadaných hesel se neshoduje';
                        
                    }else{

                        $salt = 'saka9@*6sJAjh*hg5jS@d3*4sad*H@A';

                            function secouredPass($password) {
                                //algoritmus hesla
                                return $salt . $password . chunk_split($salt, 12 , ".");
                            }
                            $hashPassword = password_hash(secouredPass($password), PASSWORD_BCRYPT,['cost' => 12]);
                            $gen_friednCode = generevoani_friendCode($con);
                            
                            
                            
                            
                            
                            //uložení do databze
                            $query = "INSERT INTO users (email, pass, username, friendCode) VALUES ('$email', '$hashPassword', '$username', '$gen_friednCode')";

                            $result = mysqli_query($con, $query);
                            
                            
                            //otevře login.php
                            header('location: login.php');
                
                            if (!$result) {
                                die ("dotaz do databáze selhal" . mysqli_error());
                            } else {
                                echo 'Některé povinné pole nebylo vyplněno.';
                            }


                    }










                    }else{
                        echo 'Tento emailova adresa je již využívana';
                    }


                    
                        
            }else{
                echo"<h2> musíte vyplnit všehny pole</h2>";
            }
        
        } 

echo "<a href='login.php'><button type='button'>Login</button> </a>";