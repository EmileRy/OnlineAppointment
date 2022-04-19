<?php
include("../../components/navbar/main.php");
?>

    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["first_name"]); ?></b>. Welcome to OnlineAppointment.</h1>
<?php
$doctor = Doctor::getByUserId($link, $_SESSION["id"]);
if($doctor !== null){
    echo("You're a doctor");
    $timetables = Timetable::getDoctorTimetables($link, $doctor->id);
    foreach ($timetables as $t) {
        echo($t->id);
    }
}
?>
    <p>
        <a href="pages/account/reset-password.php" class="btn btn-warning">Reset password</a>
        <a href="pages/account/logout.php" class="btn btn-danger ml-3">Sign out</a>
    </p>

<?php
include("../../components/footer/main.php");