
<?php
//stránka
$title = "Register";

//zahlaví
include_once('../temp/heading.php');

//Propojení
require_once('../temp/db_con.php');


echo"<form action='test.php' method='post'>
<input type='email'placeholder='Email' name='email'><br>
<input type='password'placeholder='heslo' name='password'><br>
<input type='password'placeholder='znova heslo' name='password2'><br>
<input type='text' name='username'placeholder='username'>
<input type='submit' name='submit'value='Odelsat'>
</form>

";
if (isset($_POST["submit"])) {
    
    
    // Check if all required fields are set
    if (isset($_POST["email"], $_POST["password"], $_POST["password2"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $password2 = $_POST["password2"];
        $username = $_POST["username"];




        if (!($password == $password2)) {

            echo 'Jendo z vaších zadaných hesel se neshoduje';
        
            
        }else{
            //vytáhne z tabulky email kde email se '$email'
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = $conn->query($sql);

                //jestli se hodnota řádku rovna 1 a více vypíše...
            if ($result->num_rows > 0) {
                echo "Tento email už je zaregistrovaný";
            } else {
                //jinak porkačuje normalně v registraci
                $salt = 'saka9@*6sJAjh*hg5jS@d3*4sad*H@A';

                function secouredPass($password) {
                    //algoritmus hesla
                    return $salt . $password . chunk_split($salt, 12 , ".");
                }
                $hashPassword = password_hash(secouredPass($password), PASSWORD_BCRYPT,['cost' => 12]);
                 // 
                 $query = "INSERT INTO users (email, pass, username) VALUES ('$email', '$hashPassword', '$username')";
    
                 $result = mysqli_query($con, $query);
                 
                 //otevře login.php
                 header('location: testLogin.php');
     
                 if (!$result) {
                     die ("dotaz do databáze selhal" . mysqli_error());
                 }
            }
            
        }
        
        
       
        }
    } else {
        echo 'Některé povinné pole nebylo vyplněno.';
    }

echo "<a href='testLogin.php'><button type='button'>Login</button> </a>";


?>
