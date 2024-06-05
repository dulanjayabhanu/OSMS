<?php
require "connection.php";

if(isset($_POST["email"])){
    $email = $_POST["email"];
    $studentVerifyResultset = Database::search("SELECT * FROM `student` INNER JOIN `student_unique_code` ON
    student.email=student_unique_code.student_email WHERE `email`='".$email."' AND `verify_status`='2'");
    $studentVerifyRownumber = $studentVerifyResultset->num_rows;

    if($studentVerifyRownumber == 1){
        Database::insertUpdateDelete("UPDATE `student` SET `verify_status`='1' WHERE `email`='".$email."'");
        echo("success");
    }else{
        echo("Something Went Wrong");
    }
}else{
    echo("Something Went Wrong");
}
?>