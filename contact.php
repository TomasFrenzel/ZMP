<?php
$title = 'Kontaktujte nás';

// Připojení k databázi
require_once('./temp/db_con.php');

// Error zpráva
$error_message = '';

// Odeslání dat do databáze
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];

  // Kontrola, zda jsou všechna data prázdná
  if (empty($name) || empty($email) || empty($message)) {
    $error_message = 'Chyba: všechna pole musí být vyplněná';
  }
  // Kontrola, zda jsou všechna data platné délky
  elseif (strlen($name) > 100 || strlen($email) > 255 || strlen($message) > 255) {
    $error_message = 'Chyba: zadejte platná data';
  } else {
    // SQL dotaz pro odeslání formuláře do databáze
    $stmt = $con->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $name, $email, $message);
    $stmt->execute();
    
    header("location: contactTxt.php?sent=true&name=$name&email=$email&message=$message");
  }
}
require_once('./temp/heading.php');



echo "<section class='container'>
<h2 class='display-3 text-white text-center fw-bold my-5'>
  Kontaktujte <span class='colored-text'>nás</span>
</h2>
<p class='text-danger text-center'>$error_message</p>
<form action='contact.php' method='post' class='d-flex flex-column align-items-center'>
  <input type='text' name='name' placeholder='Jméno a příjmení' class='form-input w-75 my-4' style='cursor: text' />
  <input type='email' name='email' placeholder='E-mail' class='form-input w-75 my-4' style='cursor: text' />
  <textarea name='message' cols='30' rows='10' placeholder='Zpráva' class='form-input w-75 my-4'
    style='cursor: text; resize: none; overflow: hidden'></textarea>
  <input type='submit' class='button mt-4 w-25' name='submit' value='odeslat' />
</form>
</section>";

// Zahrnutí zápatí
include_once('./temp/footer.php');
?>