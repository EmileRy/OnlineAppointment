<?php
include("../../components/navbar/main.php");

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../account/login.php");
    exit;
}
$doctor = Doctor::getByUserId($link, $_SESSION["id"]);
if($doctor == null){
    header("location: ../account/account.php");
    exit;
}
$doctor_user = $doctor->getUser($link);
$doctor_type = $doctor->getType($link);

?>
    <div class="row">
        <div class="col-lg-3">
            <div class="card" style="margin-bottom: 20px;">
                <div class="card-body">
                    <h5 class="card-title">My dashboard</h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?php echo("Dr. " . $doctor_user->first_name . " " . $doctor_user->name) ?></h6>
                    <p class="card-text"><?php echo($doctor->address) ?></p>
                </div>
            </div>
            <ul class="list-group" style="margin-bottom: 20px;">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Type
                    <span class="badge bg-secondary rounded-pill"><?php echo($doctor_type->name) ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Identification number
                    <span class="badge bg-secondary rounded-pill"><?php echo($doctor->identification_number) ?></span>
                </li>
            </ul>
            <?php include("../../components/quick-appointment-creator/main.php"); ?>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <?php include("../../components/calendar/dashboard-calendar.php") ?>
                </div>
            </div>
        </div>
    </div>

<?php
include("../../components/footer/main.php");