<?php
require "connection.php";

$username = $_POST["username"];
$verificationCode = $_POST["verificationCode"];
$newPassword = $_POST["newPassword"];
$retypePassword = $_POST["retypePassword"];

if(empty($username)){
    echo("Missing Username");
}else if(empty($newPassword)){
    echo("Please enter a New Password");
}else if(strlen($newPassword) < 6 || strlen($newPassword) > 20){
    echo("Invalied Password");
}else if(empty($retypePassword)){
    echo("Please re-type a New Password");
}else if($newPassword != $retypePassword){
    echo("Password does not matched");
}else if(empty($verificationCode)){
    echo("Please enter Verification Code");
}else{
    $teacherResultset = Database::search("SELECT * FROM `teacher` WHERE `username`='".$username."' AND `verification_code`='".$verificationCode."'");
    $teacherRownumber = $teacherResultset->num_rows;

    if($teacherRownumber == 1){
        Database::insertUpdateDelete("UPDATE `teacher` SET `password`='".$newPassword."' WHERE `username`='".$username."'");
        echo("success");
    }else{
        echo("Invalid Username or Verification Code");
    }
}
?>