<?php
    session_start();

    $loggedIn = isset($_SESSION['id']);
    if($loggedIn){
    
        $title = "Testy";
        //zahlaví
        require_once('./temp/headingUser.php');
    
        //Propojení
        require_once('./temp/db_con.php');
    
        //sestions
        $username= $_SESSION["username"];
        $idUsers = $_SESSION["id"];
        $friednCode = $_SESSION['friendCode'];
        $profileImg=$_SESSION["profileImg"];

        //bude házet errory není v databzi ještě
        //$points = $_SESSION['points'];  
    
        $query = "SELECT * FROM scores WHERE idUsers=?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $idUsers);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $score = $row["score"];
        
        //

       $usernameFriendCode = $username ." ". $friednCode;
        echo "<section
        class='container d-flex  align-items-center flex-column full-section'>
        <img src='$profileImg' alt='Úvodní fotka uživatele $username'class='round-image'>
        <h1>$usernameFriendCode</h1>
        <h2>Vaše skore je $score <h2>
        
        
        
          
        
        <form action='user.php' method='POST'>
        <input type='submit' name='submit' value='Quize' class='button mt-3'>
        </form>";
    
        //<img  src='$profileImg' alt='Úvodní fotka uživatele $username' class='user-image'>;

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
<img src="" alt="">
