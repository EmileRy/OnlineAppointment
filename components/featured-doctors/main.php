<h4>They are on LatvijasDoctor</h4>
<hr class="my-4">
<div class="row row-cols-1 row-cols-md-3 g-4">
    <?php
    for ($i = 1; $i <= 3; $i++) {
        echo("<div class='col'>\n");
        echo("<div class='card'>\n");
        echo("<img src='../../assets/images/user.jpeg' class='card-img-top' alt='...'>\n");
        echo("<div class='card-body'>\n");
        echo("<h5 class='card-title'>Dr. Juiphe</h5>\n");
        echo("<p class='card-text'>General practitioner</p>\n");
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            echo("<a href='#' class='btn btn-primary'>Book appointment</a>\n");
        }
        echo("</div>");
        echo("</div>");
        echo("</div>");
    }
    ?>
</div>