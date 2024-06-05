<?php
session_start();
require "connection.php";

$username = $_POST["username"];
$password = $_POST["password"];
$rememberme = $_POST["rememberme"];

if (empty($username)) {
    echo ("Please enter your Username");
} else if (strlen($username) > 50) {
    echo ("Username shold be <50 characters");
} else if (empty($password)) {
    echo ("Please enter your Password");
} else if (strlen($password) < 6 | strlen($password) > 20) {
    echo ("Password must be between 6 - 20 characters");
} else {
    $officerResultset = Database::search("SELECT * FROM `teacher` INNER JOIN `unique_code` ON
    teacher.email=unique_code.teacher_email WHERE `username`='".$username."' AND `password`='".$password."' AND `unique_code`.`name`=''");
    $officerRownumber = $officerResultset->num_rows;

    if($officerRownumber == 1){
        $officerData = $officerResultset->fetch_assoc();
        $_SESSION["officer"] = $officerData;

        if($rememberme == "true"){
            setcookie("ao_username",$username,time() + (60*60*24*365));
            setcookie("ao_password",$password,time() + (60*60*24*365));
        }else{
            setcookie("ao_username","",time());
            setcookie("ao_password","",time());
        }
        echo("success");
    }else{
        echo("Invalid Username or Password");
    }
}
?>