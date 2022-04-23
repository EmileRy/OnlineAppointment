<?php
session_start();

require_once (__DIR__ . "/../../src/Doctor.php");
require_once (__DIR__ . "/../../src/Timetable.php");
require_once (__DIR__ . "/../../src/Type.php");
require_once (__DIR__ . "/../../src/Appointment.php");
require_once (__DIR__ . "/../../src/User.php");
require_once (__DIR__ . "/../../config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LatvijasDoctor</title>
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">-->
    <link href="../../custom-theme.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../../style.css">
    <script src="../../script.js"></script>
</head>
<body>
<?php include("navbar.php") ?>
<div class="container col-xl-10 col-xxl-8 px-4 py-5">
