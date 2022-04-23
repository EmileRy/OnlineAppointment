<?php

class User
{

    //Variables of the object User
    public $id, $email, $name, $first_name;

    public function __construct($id, $email, $name, $first_name) {
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;
        $this->first_name = $first_name;
    }

    public static function getById($link, $id) {
        $result = null;
        $sql = "SELECT email, name, first_name FROM Users WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $id);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $email, $name, $first_name);
                    if(mysqli_stmt_fetch($stmt)){
                        $result = new User($id, $email, $name, $first_name);
                    }
                }
            }
            mysqli_stmt_close($stmt);
        }
        return $result;
    }

}