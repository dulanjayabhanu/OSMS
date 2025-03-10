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
    $studentResultset = Database::search("SELECT * FROM `student` INNER JOIN `student_unique_code` ON
    student.email=student_unique_code.student_email WHERE `username`='".$username."' AND `password`='".$password."' AND `student_unique_code`.`name`='' AND `block_status`='1'");
    $studentRownumber = $studentResultset->num_rows;

    if($studentRownumber == 1){
        $studentData = $studentResultset->fetch_assoc();
        $_SESSION["student"] = $studentData;

        if($rememberme == "true"){
            setcookie("stu-username",$username,time() + (60*60*24*365));
            setcookie("stu-password",$password,time() + (60*60*24*365));
        }else{
            setcookie("stu-username","",time());
            setcookie("stu-password","",time());
        }
        echo("success");
    }else{
        echo("Invalid Username or Password");
    }
}
?>