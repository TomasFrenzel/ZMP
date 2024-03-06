<?php
    session_start();

    $loggedIn = isset($_SESSION['id']);
    if($loggedIn){
    
        $title = "Testy";
        //zahlaví
        include_once('./temp/headingUser.php');
    
        //Propojení
        require_once('./temp/db_con.php');
    
        //sestions
        $username= $_SESSION["username"];
        $idUsers = $_SESSION["id"];
        //bude házet errory není v databzi ještě
        //$points = $_SESSION['points'];  
    
        //echo"<img src='$profilmg' alt='Úvodní fotka uživatele $username'>";
        echo"<h1>Jste přihlášen/a $username</h1>";
        //echo"<h2>Vaše skore je $points <h2>";
        
        
        
        echo"
        <form action='user.php' method='POST'>
        <input type='submit' name='submit' value='Quize'>
        </form>";
    
    
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            header('location: quiz.php');
        
        }
    
    
    }else {
        echo"nejste přihlášeni";}
    
    
    
    
     //databaze 
        /*$query = "SELECT * FROM answers WHERE idUsers='" . $idUsers . "'";    
        
        $result = mysqli_query($con, $query);
    
        if (mysqli_num_rows($result) > 1) {
            while($row = mysqli_fetch_assoc($result)){
                //body z databze answers
                $_SESSION['points']=$row["points"];
            }
        
        }else {
            //hazí to todle pole points jeste není vyplněné
        echo'nastala chyba';
        
        }*/
    

?>
