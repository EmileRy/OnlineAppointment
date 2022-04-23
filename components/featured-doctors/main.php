<h4>They are on LatvijasDoctor</h4>
<hr class="my-4">
<div class="row row-cols-1 row-cols-md-3 g-4">
    <?php
    $doctors = Doctor::getRandom($link, 3);
    foreach ($doctors as $doctor) {
        $doctor_user = $doctor->getUser($link);
        $doctor_type = $doctor->getType($link);
        echo("<div class='col'>\n");
        echo("<div class='card'>\n");
        echo("<img src='../../assets/images/user.jpeg' class='card-img-top' alt='...'>\n");
        echo("<div class='card-body'>\n");
        echo("<h5 class='card-title'>Dr. " . $doctor_user->name . "</h5>\n");
        echo("<p class='card-text'>" . $doctor_type->name . "</p>\n");
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            echo("<form method='post' action='../../pages/doctor/main.php'>\n");
            echo("<input type='hidden' name='doctor_id' value='$doctor->id'>\n");
            echo("<button href='#' class='btn btn-primary' type='submit'>Book appointment</button>\n");
            echo("</form>\n");
        }
        echo("</div>");
        echo("</div>");
        echo("</div>");
    }
    ?>
</div>