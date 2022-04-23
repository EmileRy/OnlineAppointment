<?php
include("../../components/navbar/main.php");

$task = "";
$timetable = null;

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["timetable_id"])) {
    $timetable = Timetable::getById($link, trim($_GET["timetable_id"]));
    if($timetable == null){
        header("location: ../account/account.php");
    }
    $task = "confirm_book";
} else if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["book_timetable_id"])){
    $appointment = new Appointment($_SESSION["id"], trim($_POST["book_timetable_id"]), "");
    $appointment->save($link);
    $timetable = $appointment->getTimetable($link);
    $task = "booked";
} else if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cancel_appointment_id"])){

    $task = "confirm_cancelation";
} else {
    header("location: ../account/account.php");
}

$doctor = $timetable->getDoctor($link);
$doctor_user = $doctor->getUser($link);
$doctor_type = $doctor->getType($link);

$date = new DateTime($timetable->date);

if($task == "confirm_book"){
    include("confirm-booking.php");
} else if($task == "booked") {
    include("book.php");
} else if($task == "confirm_cancelation"){
    include("confirm-cancelation.php");
}

include("../../components/footer/main.php");