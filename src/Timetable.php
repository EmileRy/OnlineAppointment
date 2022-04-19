<?php

class Timetable
{

    //Variables of the object Timetable
    public $id, $doctor_id, $date, $duration;

    public static function getDoctorTimetables($link, $doctor_id) {
        $result = array();
        $sql = "SELECT id, date, duration FROM Timetables WHERE doctor_id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $doctor_id);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) > 0){
                    mysqli_stmt_bind_result($stmt, $id, $date, $duration);
                    while(mysqli_stmt_fetch($stmt)){
                        $timetable = new Timetable();

                        $timetable->doctor_id = $doctor_id;
                        $timetable->id = $id;
                        $timetable->date = $date;
                        $timetable->duration = $duration;

                        $result[] = $timetable;
                    }
                }
            }
            mysqli_stmt_close($stmt);
        }
        return $result;
    }

}