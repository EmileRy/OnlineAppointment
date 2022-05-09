<?php

class Doctor
{

    //Variables of the object Doctor
    public $id, $user_id, $type_id, $address, $identification_number;

    public function __construct($user_id, $type_id, $address, $identification_number, $id = -1) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->type_id = $type_id;
        $this->address = $address;
        $this->identification_number = $identification_number;
    }

    public function getUser($link){
        return User::getById($link, $this->user_id);
    }

    public function getType($link){
        return Type::getById($link, $this->type_id);
    }

    public function save($link){
        if($this->id == -1) {
            $this->create($link);
        } else {
            $this->update($link);
        }
    }

    private function create($link){
        $sql = "INSERT INTO Doctors(user_id, type_id, address, identification_number) VALUES(?,?,?,?)";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ssss", $this->user_id, $this->type_id, $this->address, $this->identification_number);
            if(mysqli_stmt_execute($stmt)){
                $this->id = mysqli_insert_id($link);
            }
            mysqli_stmt_close($stmt);
        }
    }

    private function update(){

    }

    public static function getById($link, $id) {
        $result = null;
        $sql = "SELECT user_id, type_id, address, identification_number FROM Doctors WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $id);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $user_id, $type_id, $address, $identification_number);
                    if(mysqli_stmt_fetch($stmt)){
                        $result = new Doctor($user_id, $type_id, $address, $identification_number, $id);
                    }
                }
            }
            mysqli_stmt_close($stmt);
        }
        return $result;
    }

    public static function getByUserId($link, $user_id) {
        $result = null;
        $sql = "SELECT id, type_id, address, identification_number FROM Doctors WHERE user_id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $user_id);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $id, $type_id, $address, $identification_number);
                    if(mysqli_stmt_fetch($stmt)){
                        $result = new Doctor($user_id, $type_id, $address, $identification_number, $id);
                    }
                }
            }
            mysqli_stmt_close($stmt);
        }
        return $result;
    }

    public static function getAll($link, $type_id = -1) {
        $result = array();
        $sql = "SELECT id, user_id, type_id, address, identification_number FROM Doctors ORDER BY id";

        if($type_id > 0){
            $sql = "SELECT id, user_id, type_id, address, identification_number FROM Doctors WHERE type_id = ? ORDER BY id";
        }

        if($stmt = mysqli_prepare($link, $sql)){
            if($type_id > 0){
                mysqli_stmt_bind_param($stmt, "s", $type_id);
            }
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) >= 1){
                    mysqli_stmt_bind_result($stmt, $id, $user_id, $type_id, $address, $identification_number);
                    while(mysqli_stmt_fetch($stmt)){
                        $result[] = new Doctor($user_id, $type_id, $address, $identification_number, $id);
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