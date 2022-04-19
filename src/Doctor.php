<?php

class Doctor
{

    //Variables of the object Doctor
    public $id, $user_id, $type_id, $address;

    public static function getByUserId($link, $user_id) {
        $result = null;
        $sql = "SELECT id, type_id, address FROM doctors WHERE user_id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $user_id);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $id, $type_id, $address);
                    if(mysqli_stmt_fetch($stmt)){
                        $result = new Doctor();

                        $result->user_id = $user_id;
                        $result->id = $id;
                        $result->type_id = $type_id;
                        $result->address = $address;
                    }
                }
            }
            mysqli_stmt_close($stmt);
        }
        return $result;
    }

}