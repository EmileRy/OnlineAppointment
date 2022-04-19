<?php

include("components/navbar/main.php");

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    include ("components/login/main.php");
} else {
    include ("components/find-doctor-form/main.php");
}

include("components/footer/main.php");