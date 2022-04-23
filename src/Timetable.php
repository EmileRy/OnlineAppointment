<?php

class Timetable
{

    //Variables of the object Timetable
    public $id, $doctor_id, $date, $duration, $available;

    public function __construct($id, $doctor_id, $date, $duration, $available = true) {
        $this->id = $id;
        $this->doctor_id = $doctor_id;
        $this->date = $date;
        $this->duration = $duration;
        $this->available = $available;
    }

    public function getDoctor($link){
        return Doctor::getById($link, $this->doctor_id);
    }

    public static function getById($link, $id){
        $result = null;
        $sql = "SELECT doctor_id, date, duration, (SELECT Count(*) FROM Appointments WHERE timetable_id = t.id) unavailable FROM Timetables t WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $id);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $doctor_id, $date, $duration, $unavailable);
                    if(mysqli_stmt_fetch($stmt)){
                        $result = new Timetable($id, $doctor_id, $date, $duration, !$unavailable);
                    }
                }
            }
            mysqli_stmt_close($stmt);
        }
        return $result;
    }

    public static function getDoctorTimetables($link, $doctor_id, $future_only) {
        $result = array();
        $sql = "SELECT t.id, date, duration, (SELECT Count(*) FROM Appointments WHERE timetable_id = t.id) unavailable FROM Timetables t WHERE doctor_id = ?;";
        if($future_only){
            $sql = "SELECT t.id, date, duration, (SELECT Count(*) FROM Appointments WHERE timetable_id = t.id) unavailable FROM Timetables t WHERE doctor_id = ? AND t.date > CURRENT_TIME;";
        }
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $doctor_id);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) > 0){
                    mysqli_stmt_bind_result($stmt, $id, $date, $duration, $unavailable);
                    while(mysqli_stmt_fetch($stmt)){
                        $result[] = new Timetable($id, $doctor_id, $date, $duration, !$unavailable);
                    }
                }
            }
            mysqli_stmt_close($stmt);
        }
        return $result;
    }

}