<?php
    session_start();

    $loggedIn = isset($_SESSION['id']);
    if($loggedIn){
    
        $title = "Účet";
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
        <h1 class='red-header'>$usernameFriendCode</h1>
        <h2>Máte <span class='colored-text'>$score </span>bodů<h2>
        
        
        
          
        
        <form action='user.php' method='POST'>
        <input type='submit' name='submit' value='Quize' class='button mt-3'>
        </form>";
    
        //<img  src='$profileImg' alt='Úvodní fotka uživatele $username' class='user-image'>;

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            header('location: quiz.php');
        
        }
    
    
    }else{
        header('location: block.php');
    }
    

?>
