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
    $teacherResultset = Database::search("SELECT * FROM `teacher` INNER JOIN `unique_code` ON
    teacher.email=unique_code.teacher_email WHERE `username`='".$username."' AND `password`='".$password."' AND `unique_code`.`name`=''");
    $teacherRownumber = $teacherResultset->num_rows;

    if($teacherRownumber == 1){
        $teacherData = $teacherResultset->fetch_assoc();
        $_SESSION["teacher"] = $teacherData;

        if($rememberme == "true"){
            setcookie("username",$username,time() + (60*60*24*365));
            setcookie("password",$password,time() + (60*60*24*365));
        }else{
            setcookie("username","",time());
            setcookie("password","",time());
        }
        echo("success");
    }else{
        echo("Invalid Username or Password");
    }
}
?>