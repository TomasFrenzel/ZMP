<?php
// Název stránky
$title = 'Úvod';

// Zahrnutí záhlaví
include_once('./temp/heading.php');

// Obsah sekce
echo '<!-- Main section -->
<section
  class="container d-flex justify-content-center align-items-center flex-column full-section">
  <h1 class="text-center text-white fw-bold display-2 px-2">
    Bezpečně na <span class="colored-text">netu</span>
  </h1>
  <p class="fw-light text-white main-description text-center px-2">
    Web o základních pravidlech bezpečnosti na internetu
  </p>
  <a href="./aboutus.php" class="button mt-3">Chci vědět více</a>
</section>';

// Zahrnutí zápatí
include_once('./temp/footer.php');
?>