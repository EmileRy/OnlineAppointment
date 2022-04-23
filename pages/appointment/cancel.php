<?php
include("../../components/navbar/main.php");

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["appointment_id"])){
    $appointment = Appointment::getById($link, $_POST["appointment_id"]);
    $appointment->delete($link);
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
        <div class="card border-danger text-center">
            <div class="card-body">
                <h5 class="card-title">Appointment canceled</h5>
                <p class="card-text">Your appointment with <span style="font-weight: bold;">Dr. <?php echo($doctor_user->first_name . " " . $doctor_user->name) ?></span> has been canceled</p>
                <h5>
                    <span class="badge bg-danger"><?php echo($date->format('d F Y') . " at " . $date->format('H:i')) ?></span>
                </h5>
                <a href="../account/account.php" class="btn btn-outline-danger">My account</a>
            </div>
            <div class="card-footer border-danger text-muted">
                Dr. <?php echo($doctor_user->first_name . " " . $doctor_user->name . " — " . $doctor_type->name) ?>
            </div>
        </div>
    </div>

<?php
include("../../components/footer/main.php");