<ul class="list-group list-group-flush">
    <?php
    $appointments = Appointment::getByUserId($link, $_SESSION["id"]);
    foreach($appointments as $appointment){
        $timetable = $appointment->getTimetable($link);
        $date = new DateTime($timetable->date);
        if($date >= new DateTime()) {
            $doctor = $timetable->getDoctor($link);
            $doctor_user = $doctor->getUser($link);

            echo("<li class='list-group-item d-flex justify-content-between align-items-start'>\n");
            echo("<div class='me-auto'>\n");
            echo("<div class='fw-bold'>Dr. " . $doctor_user->name . "</div>\n");
            echo("General practitioner\n");
            echo("</div>\n");
            echo("<span class='badge bg-primary rounded-pill'>" . $date->format('d F Y H:i') . "</span>\n");
            echo("</li>\n");
        }
    }
    ?>
</ul>