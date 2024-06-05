<?php
session_start();
require "connection.php";
if(isset($_SESSION["student"])){
    $student = $_SESSION["student"];

    $email = $_POST["email"];
    $amount = $_POST["amount"];
    $id = $_POST["id"];

    $gradeResultset = Database::search("SELECT * FROM `student_has_subject` WHERE `student_email`='".$email."'");
    $gradeData = $gradeResultset->fetch_assoc();
    $paymentResultset = Database::search("SELECT * FROM `invoice` WHERE `student_email`='".$email."' AND `grade_id`='".$gradeData["grade_id"]."'");
    $paymentRownumber = $paymentResultset->num_rows;

    if($paymentRownumber == 0){
        $datetime = new DateTime();
        $timezone = new DateTimeZone("Asia/Colombo");
        $datetime->setTimezone($timezone);
        $date = $datetime->format("Y-m-d H:i:s");

        Database::insertUpdateDelete("INSERT INTO `invoice` (`date`,`total`,`student_email`,`grade_id`,`bill_id`) VALUES ('".$date."','".$amount."','".$email."','".$gradeData["grade_id"]."','".$id."')");
        Database::insertUpdateDelete("UPDATE `student` SET `payment_status`='3' WHERE `email`='".$email."'");
        $studentResultset = Database::search("SELECT * FROM `student` WHERE `email`='".$email."'");
        $studentData = $studentResultset->fetch_assoc();
        session_destroy();
        session_start();
        $_SESSION["student"] = $studentData;
        echo("success");
    }else{
        echo("Something Went Wrong");
    }
}else{
    header("Location:studentDashboard.php");
}
?>