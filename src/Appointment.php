<?php

class Appointment
{

    //Variables of the object Appointment
    public $id, $user_id, $timetable_id, $notes;

    public function __construct($id, $user_id, $timetable_id, $notes) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->timetable_id = $timetable_id;
        $this->notes = $notes;
    }

    public function getTimetable($link){
        return Timetable::getById($link, $this->timetable_id);
    }

    public static function getByUserId($link, $user_id) {
        $result = array();
        $sql = "SELECT id, timetable_id, notes FROM Appointments WHERE user_id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $user_id);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) > 0){
                    mysqli_stmt_bind_result($stmt, $id, $timetable_id, $notes);
                    while(mysqli_stmt_fetch($stmt)){
                        $result[] = new Appointment($id, $user_id, $timetable_id, $notes);
                    }
                }
            }
            mysqli_stmt_close($stmt);
        }
        return $result;
    }

}