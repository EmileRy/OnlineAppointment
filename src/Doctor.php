<?php

class Doctor
{

    //Variables of the object Doctor
    public $id, $user_id, $type_id, $address;

    public function __construct($id, $user_id, $type_id, $address) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->type_id = $type_id;
        $this->address = $address;
    }

    public function getUser($link){
        return User::getById($link, $this->user_id);
    }

    public function getType($link){
        return Type::getById($link, $this->type_id);
    }

    public static function getById($link, $id) {
        $result = null;
        $sql = "SELECT user_id, type_id, address FROM Doctors WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $id);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $user_id, $type_id, $address);
                    if(mysqli_stmt_fetch($stmt)){
                        $result = new Doctor($id, $user_id, $type_id, $address);
                    }
                }
            }
            mysqli_stmt_close($stmt);
        }
        return $result;
    }

    public static function getByUserId($link, $user_id) {
        $result = null;
        $sql = "SELECT id, type_id, address FROM Doctors WHERE user_id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $user_id);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $id, $type_id, $address);
                    if(mysqli_stmt_fetch($stmt)){
                        $result = new Doctor($id, $user_id, $type_id, $address);
                    }
                }
            }
            mysqli_stmt_close($stmt);
        }
        return $result;
    }

    public static function getAll($link) {
        $result = array();
        $sql = "SELECT id, user_id, type_id, address FROM Doctors ORDER BY id";
        if($stmt = mysqli_prepare($link, $sql)){
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) >= 1){
                    mysqli_stmt_bind_result($stmt, $id, $user_id, $type_id, $address);
                    while(mysqli_stmt_fetch($stmt)){
                        $result[] = new Doctor($id, $user_id, $type_id, $address);
                    }
                }
            }
            mysqli_stmt_close($stmt);
        }
        return $result;
    }

    public static function getRandom($link, $max_amount){
        $result = array();
        $doctors = self::getAll($link);
        shuffle($doctors);
        if(sizeof($doctors) < $max_amount)
            $max_amount = sizeof($doctors);
        for($i = 0; $i < $max_amount; $i++){
            $result[] = $doctors[$i];
        }
        return $result;
    }

}