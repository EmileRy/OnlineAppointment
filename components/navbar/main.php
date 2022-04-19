<?php
session_start();

require_once (__DIR__ . "/../../src/Doctor.php");
require_once (__DIR__ . "/../../src/Timetable.php");
require_once (__DIR__ . "/../../config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LatvijasDoctor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../../style.css">
    <script src="../../script.js"></script>
</head>
<body>
<?php include("navbar.php") ?>