<ul class="list-group list-group-flush">
    <?php
    $appointments = Appointment::getByUserId($link, $_SESSION["id"]);
    foreach($appointments as $appointment){
        $timetable = $appointment->getTimetable($link);
        $date = new DateTime($timetable->date);
        if($date < new DateTime()) {
            $doctor = $timetable->getDoctor($link);
            $doctor_user = $doctor->getUser($link);

            echo("<li class='list-group-item'>Dr. " . $doctor_user->name . " — " . $date->format('d F Y H:i') . "</li>\n");
        }
    }
    ?>
</ul>