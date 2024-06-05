<?php
require "connection.php";

if(isset($_POST["email"]) & isset($_POST["grade"])){
    if($_POST["grade"] == 0){
        echo("Please Select A Class");
    }else{
        $email = $_POST["email"];
        $grade = $_POST["grade"];
        Database::insertUpdateDelete("UPDATE `classroom` SET `year`='".date("Y")."',`grade_id`='".$grade."' WHERE `student_email`='".$email."'");

        $studentResultset = Database::search("SELECT * FROM `student` WHERE `email`='".$email."'");
        $studentData = $studentResultset->fetch_assoc();

        if($studentData["payment_status"] == 2){
            echo("This Student Still Use Trail Version");
        }else if($studentData["payment_status"] == 2){
            echo("This Student's Trail Version Expired");
        }else{
            Database::insertUpdateDelete("UPDATE `student` SET `payment_status`='1' WHERE `email`='".$email."' AND `payment_status`='3'");
            echo("success");
        }
    }
}else{
    echo("Something Went Wrong");
}
?>