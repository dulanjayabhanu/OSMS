<?php
require "connection.php";

if(isset($_GET["email"])){
    $email = $_GET["email"];

    $teacherResultset = Database::search("SELECT * FROM `teacher` WHERE `email`='".$email."'");
    $teacherRownumber = $teacherResultset->num_rows;

    if($teacherRownumber == 1){
        $teacherData = $teacherResultset->fetch_assoc();
        if( intval($teacherData["block_status"]) == 1){
            Database::insertUpdateDelete("UPDATE `teacher` SET `block_status`='2' WHERE `email`='".$email."'");
            echo("teacher blocked");
        }else if(intval($teacherData["block_status"]) == 2){
            Database::insertUpdateDelete("UPDATE `teacher` SET `block_status`='1' WHERE `email`='".$email."'");
            echo("teacher unblocked");
        }
    }else{
        echo("Something Went Wrong");
    }

}else{
    echo("Something Went Wrong");
}

?>