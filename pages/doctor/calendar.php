<?php
include("../../components/navbar/main.php");

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../account/login.php");
    exit;
}

include("../../components/calendar/doctor-calendar.php");

include("../../components/footer/main.php");