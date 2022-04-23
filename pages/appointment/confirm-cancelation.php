<?php
include("../../components/navbar/main.php");

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["appointment_id"])){
    $appointment = Appointment::getById($link, $_POST["appointment_id"]);
} else {
    header("location: ../account/account.php");
}

$timetable = $appointment->getTimetable($link);
$doctor = $timetable->getDoctor($link);
$doctor_user = $doctor->getUser($link);
$doctor_type = $doctor->getType($link);

$date = new DateTime($timetable->date);
?>

    <div class="container col-xl-10 col-xxl-6 px-4 py-5">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Cancel your appointment?</h5>
                <p class="card-text">You're about to <span style="font-weight: bold; color: red;">cancel</span> your appointment with <span
                            style="font-weight: bold;">Dr. <?php echo($doctor_user->first_name . " " . $doctor_user->name) ?></span>
                </p>
                <h5>
                    <span class="badge bg-secondary"><?php echo($date->format('d F Y') . " at " . $date->format('H:i')) ?></span>
                </h5>
                <div class="row">
                    <div class="col-6" align="right">
                        <a href='../account/account.php' class='btn btn-outline-secondary'>Back to my account</a>
                    </div>
                    <div class="col-6" align="left">
                        <form method='post' action='cancel.php'>
                            <input type='hidden' name='appointment_id' value='<?php echo($appointment->id) ?>'>
                            <button class='btn btn-danger' type='submit'>Cancel appointment</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-footer text-muted">
                Dr. <?php echo($doctor_user->first_name . " " . $doctor_user->name . " — " . $doctor_type->name) ?>
            </div>
        </div>
    </div>

<?php
include("../../components/footer/main.php");