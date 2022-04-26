<?php
include("../../components/navbar/main.php");

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../account/login.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["timetable_id"])){
    $timetable = Timetable::getById($link, $_GET["timetable_id"]);
} else {
    header("location: ../account/account.php");
}

$doctor = $timetable->getDoctor($link);
$doctor_user = $doctor->getUser($link);
$doctor_type = $doctor->getType($link);

$date = new DateTime($timetable->date);
?>

<div class="container col-xl-10 col-xxl-6 px-4 py-5">
    <div class="card text-center">
        <div class="card-body">
            <h5 class="card-title">Confirm your appointment</h5>
            <p class="card-text">You're about to book an appointment with  <span
                        style="font-weight: bold;">Dr. <?php echo($doctor_user->first_name . " " . $doctor_user->name) ?></span>
            </p>
            <h5>
                <span class="badge bg-secondary"><?php echo($date->format('d F Y') . " at " . $date->format('H:i')) ?></span>
            </h5>
            <div class="row">
                <div class="col-6" align="right">
                    <form method='post' action='../doctor/main.php'>
                        <input type='hidden' name='doctor_id' value='<?php echo($doctor->id) ?>'>
                        <button type='submit' class='btn btn-outline-secondary'>Cancel</button>
                    </form>
                </div>
                <div class="col-6" align="left">
                    <form method='post' action='book.php'>
                        <input type='hidden' name='timetable_id' value='<?php echo($timetable->id) ?>'>
                        <button class='btn btn-success' type='submit'>Confirm</button>
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