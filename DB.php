<?php

class DB
{

    public static function getSQL(){
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        return new mysqli("localhost", "root", "root", "online_appointment");
    }

}