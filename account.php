<?php
// Initialize the session
session_start();

require_once ("src/Doctor.php");
require_once ("src/Timetable.php");
require_once ("config.php");

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
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
</body>
</html>