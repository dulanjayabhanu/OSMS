<?php
require "connection.php";

if(isset($_POST["email"])){
    $email = $_POST["email"];
    $teacherVerifyResultset = Database::search("SELECT * FROM `teacher` INNER JOIN `unique_code` ON
    teacher.email=unique_code.teacher_email WHERE `user_type`='1' AND `email`='".$email."' AND `verify_status`='2'");
    $teacherVerifyRownumber = $teacherVerifyResultset->num_rows;

    if($teacherVerifyRownumber == 1){
        Database::insertUpdateDelete("UPDATE `teacher` SET `verify_status`='1' WHERE `email`='".$email."'");
        echo("success");
    }else{
        echo("Something Went Wrong");
    }
}else{
    echo("Something Went Wrong");
}
?>