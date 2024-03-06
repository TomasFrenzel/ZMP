<?php
function generevoani_friendCode($con) {
    $code = "#" . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT); // Generování náhodného kódu s '#' na začátku 10 000 unikatních kodu musí stačit xd
    $query = "SELECT * FROM users WHERE friendCode = '$code'"; // Dotaz pro kontrolu existence kódu
    $result = mysqli_query($con, $query);

    // Kontrola existence kódu v databázi
    if(mysqli_num_rows($result) > 0){
        // funkce probíha do doby než se nenajde unikatní kod
        return generevoani_friendCode($con,);
    } else {
        // když ho najde uloží se
        
        return $code;
    }
}

/*  použití funkce pro generovaní
*   $gen_friednCode = generevoani_friendCode($con, $email);

*   Zavření spojení s databází
*   mysqli_close($con);

*   Vypsání unikátního kódu
*   echo $uniqueCode;
* "#" . 
*/
?>