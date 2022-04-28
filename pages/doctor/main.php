<?php
include("../../components/navbar/main.php");

if($_SERVER["REQUEST_METHOD"] != "POST" || empty(trim($_POST["doctor_id"]))) {
    header("location: ../../index.php");
}

$doctor = Doctor::getById($link, trim($_POST["doctor_id"]));
if($doctor == null){
    header("location: ../../index.php");
}
$doctor_user = $doctor->getUser($link);
$doctor_type = $doctor->getType($link);

?>
    <div class="row">
        <div class="col-lg-3">
            <div class="card" style="margin-bottom: 20px;">
                <img src="../../assets/images/user.jpeg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?php echo("Dr. " . $doctor_user->first_name . " " . $doctor_user->name) ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?php echo($doctor_type->name) ?></h6>
                    <p class="card-text"><?php echo($doctor->address) ?></p>
                </div>
            </div>
            <div class="card" style="margin-bottom: 20px;">
                <div class="card-body">
                    <h5 class="card-title">No availabilities?</h5>
                    <p class="card-text">You can search another <?php echo(strtolower($doctor_type->name)) ?></p>
                    <form method="post" action="list.php">
                        <input type="hidden" name="type_id" value="<?php echo($doctor_type->id) ?>">
                        <button type='submit' class='btn btn-outline-primary'>Find another one</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <?php include("../../components/calendar/doctor-calendar.php") ?>
                </div>
            </div>
        </div>
    </div>

<?php
include("../../components/footer/main.php");