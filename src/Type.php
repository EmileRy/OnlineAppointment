<?php

class Type
{

    //Variables of the object Type
    public $id, $name;

    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public static function getAll($link) {
        $result = array();
        $sql = "SELECT id, name FROM Types ORDER BY id";
        if($stmt = mysqli_prepare($link, $sql)){
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) >= 1){
                    mysqli_stmt_bind_result($stmt, $id, $name);
                    while(mysqli_stmt_fetch($stmt)){
                        $result[] = new Type($id, $name);
                    }
                }
            }
            mysqli_stmt_close($stmt);
        }
        return $result;
    }

}