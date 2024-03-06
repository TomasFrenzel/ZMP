<?php

// Zpracování odhlášení
if(isset($_GET['logout'])) {
  // Zrušení session
  session_unset();
  session_destroy();

    header("Location: register.php"); // Přesměrování na index stránku nebo jinou vhodnou stránku
    exit();
}

echo "<!DOCTYPE html>
<html lang='cs'>
  <head>
    <meta charset='UTF-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
    <!-- Custom CSS import -->
    <link rel='stylesheet' href='./css/styles.css' />
    <!-- Bootstrap CSS import -->
    <link
      href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css'
      rel='stylesheet'
      integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN'
      crossorigin='anonymous' />
    <!-- Bootstrap JS import -->
    <script
      src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js'
      integrity='sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL'
      crossorigin='anonymous'
      defer></script>
    <!-- Font Awesome import -->
    <link
      rel='stylesheet'
      href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css'
      integrity='sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=='
      crossorigin='anonymous'
      referrerpolicy='no-referrer' />
    <link rel='shortcut icon' href='./img/favicon.svg' type='image/x-icon' />
    <title>Bezpečně na netu | $title</title>
  </head>

  <body>
  <!-- Background image -->
    <div class='background-image-container'>
      <!-- Navbar -->
      <nav class='navbar navbar-expand-md py-md-4'>
        <div
          class='container justify-content-lg-end justify-content-between w-100'>
          <div class='navbar-brand img-logo-container'> <a href='index.html'>
          <a href='index.php'> <img class='w-100' src='./img/logo2.svg
            ' alt='Logo' /></a>
          </div>
          <button
            class='navbar-toggler bg-white mt-3'
            data-bs-toggle='collapse'
            data-bs-target='#nav'
            aria-controls='nav'
            aria-label='Expand navigation'>
            <span class='navbar-toggler-icon'></span>
          </button>
          <div class='collapse navbar-collapse justify-content-end' id='nav'>
            <ul class='navbar-nav row-gap-3'>
              <li class='navbar-link'>
                <a href='' class='navlink'></a>
              </li>
              <li class='navbar-link'>
                <a href='' class='navlink'></a>
              </li>
              <li class='navbar-link'>
                <a href='' class='navlink'></a>
              </li>
              <li class='navbar-link'>
                <a href='./settings.php' class='navlink'>Nastavení</a>
              </li>
              <li class='navbar-link'>
                <a href='?logout=true' class='navlink'>Odhlasit se</a> <!-- Odkaz pro odhlášení -->
              </li>
            </ul>
          </div>
          </div>
      </nav>";
      
?>
