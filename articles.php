<?php
// Připojení do databáze
require_once('./temp/db_con.php');

// Název stránky
$title = 'Články';

// Zahrnutí záhlaví
include_once('./temp/heading.php');

// Obsah sekce
echo '<!-- Articles section -->
<section class="container">
    <h2 class="display-3 text-white fw-bold my-5">
        Všechny <span class="colored-text">články</span>
    </h2>
    <div class="container d-flex articles-flex-column">
        <div class="col-lg-6 d-flex flex-column">';

// Cyklus na vytištění článků
$sql = "SELECT * FROM articles";
$result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) == 0) {
    echo '<p>Nebyly nalezeny žádné články</p>';
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        $article_id = $row['id'];
        $article_name = $row['name'];

        echo "<a href='./article.php?id=$article_id' class='articles-article text-white my-3'>$article_name</a>";
    }
}
// Obsah sekce
echo '</div>
<div class="col-6 d-flex justify-content-end">
    <img src="./img/articles-blob.svg" alt="ilustrační obrázek" class="articles-image w-75" />
</div>
</div>
</section>';

// Ukončení připojení k databázi
$con->close();

// Zahrnutí zápatí
include_once('./temp/footer.php');
?>