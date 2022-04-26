<?php
include("../../components/navbar/main.php");

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../account/login.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["timetable_id"])){
    $appointment = new Appointment($_SESSION["id"], trim($_POST["timetable_id"]), "");
    $appointment->save($link);
    $timetable = $appointment->getTimetable($link);
} else {
    header("location: ../account/account.php");
}

$doctor = $timetable->getDoctor($link);
$doctor_user = $doctor->getUser($link);
$doctor_type = $doctor->getType($link);

$date = new DateTime($timetable->date);
?>

<div class="container col-xl-10 col-xxl-6 px-4 py-5">
    <div class="card border-success text-center">
        <div class="card-body">
            <h5 class="card-title">Congratulation!</h5>
            <p class="card-text">Your appointment with <span style="font-weight: bold;">Dr. <?php echo($doctor_user->first_name . " " . $doctor_user->name) ?></span> is booked!</p>
            <h5>
                <span class="badge bg-success"><?php echo($date->format('d F Y') . " at " . $date->format('H:i')) ?></span>
            </h5>
            <a href="../account/account.php" class="btn btn-outline-success">My account</a>
        </div>
        <div class="card-footer border-success text-muted">
            Dr. <?php echo($doctor_user->first_name . " " . $doctor_user->name . " — " . $doctor_type->name) ?>
        </div>
    </div>
</div>

<?php
include("../../components/footer/main.php");