<?php
require "connection.php";

if(isset($_POST["email"])){
    $email = $_POST["email"];
    $officerVerifyResultset = Database::search("SELECT * FROM `teacher` INNER JOIN `unique_code` ON
    teacher.email=unique_code.teacher_email WHERE `user_type`='2' AND `email`='".$email."' AND `verify_status`='2'");
    $officerVerifyRownumber = $officerVerifyResultset->num_rows;

    if($officerVerifyRownumber == 1){
        Database::insertUpdateDelete("UPDATE `teacher` SET `verify_status`='1' WHERE `email`='".$email."'");
        echo("success");
    }else{
        echo("Something Went Wrong");
    }
}else{
    echo("Something Went Wrong");
}
?>