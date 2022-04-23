<ul class="list-group list-group-flush">
    <?php
    $appointments = Appointment::getByUserId($link, $_SESSION["id"]);
    foreach($appointments as $appointment){
        $timetable = $appointment->getTimetable($link);
        $date = new DateTime($timetable->date);
        if($date >= new DateTime()) {
            $doctor = $timetable->getDoctor($link);
            $doctor_user = $doctor->getUser($link);
            $doctor_type = $doctor->getType($link);

            echo("<li class='list-group-item d-flex justify-content-between align-items-start'>\n");
            echo("<div class='me-auto'>\n");
            echo("<div><span style='font-weight: bold;'>Dr. " . $doctor_user->first_name . " " . $doctor_user->name . "</span> — " . $doctor_type->name . "</div>\n");
            echo($date->format('d F Y H:i') . "\n");
            echo("</div>\n");
            echo("<form method='post' action='../appointment/confirm-cancelation.php'>\n");
            echo("<input type='hidden' name='appointment_id' value='$appointment->id'>\n");
            echo("<button type='submit' class='btn btn-outline-primary btn-sm'>Cancel</button>\n");
            echo("</form>\n");
            echo("</li>\n");
        }
    }
    ?>
</ul>