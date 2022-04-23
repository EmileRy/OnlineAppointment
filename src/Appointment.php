<?php

class Appointment
{

    //Variables of the object Appointment
    public $id, $user_id, $timetable_id, $notes;

    public function __construct($user_id, $timetable_id, $notes, $id = -1) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->timetable_id = $timetable_id;
        $this->notes = $notes;
    }

    public function getTimetable($link){
        return Timetable::getById($link, $this->timetable_id);
    }

    public function save($link){
        if($this->id == -1) {
            $this->create($link);
        } else {
            $this->update($link);
        }
    }

    private function create($link){
        $sql = "SELECT Count(*) FROM Appointments WHERE timetable_id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $this->timetable_id);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $count);
                    if(mysqli_stmt_fetch($stmt) && $count > 0){
                        return;
                    }
                }
            }
            mysqli_stmt_close($stmt);
        }

        $sql = "INSERT INTO Appointments(user_id, timetable_id, notes) VALUES(?,?,?)";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $this->user_id, $this->timetable_id, $this->notes);
            if(mysqli_stmt_execute($stmt)){
                $this->id = mysqli_insert_id($link);
            }
            mysqli_stmt_close($stmt);
        }
    }

    private function update(){

    }

    public function delete($link){
        $sql = "DELETE FROM Appointments WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $this->id);
            mysqli_stmt_execute($stmt);
            $this->id = -1;
            mysqli_stmt_close($stmt);
        }
    }

    public static function getById($link, $id){
        $result = null;
        $sql = "SELECT user_id, timetable_id, notes FROM Appointments WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $id);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $user_id, $timetable_id, $notes);
                    if(mysqli_stmt_fetch($stmt)){
                        $result = new Appointment($user_id, $timetable_id, $notes, $id);
                    }
                }
            }
            mysqli_stmt_close($stmt);
        }
        return $result;
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
                        $result[] = new Appointment($user_id, $timetable_id, $notes, $id);
                    }
                }
            }
            mysqli_stmt_close($stmt);
        }
        return $result;
    }

}