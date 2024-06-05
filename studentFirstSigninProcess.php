<?php
session_start();
require "connection.php";

$username = $_POST["username"];
$password = $_POST["password"];
$oneTimeCode = $_POST["oneTimecode"];

if (empty($username)) {
    echo ("Please enter your Username");
} else if (strlen($username) > 50) {
    echo ("Username shold be <50 characters");
} else if (empty($password)) {
    echo ("Please enter your Password");
} else if (strlen($password) < 6 | strlen($password) > 20) {
    echo ("Password must be between 6 - 20 characters");
} else if (empty($oneTimeCode)) {
    echo ("Please enter your One-Time Code");
} else if (strlen($oneTimeCode) < 5 | strlen($oneTimeCode) > 5) {
    echo ("One-Time Code must be 5 characters");
} else {
    $studentResultset = Database::search("SELECT * FROM `student` WHERE `username`='" . $username . "' AND `password`='" . $password . "'");
    $studentRownumber = $studentResultset->num_rows;

    if ($studentRownumber == 1) {
        $studentData = $studentResultset->fetch_assoc();

        $uniqueCodeRsultset = Database::search("SELECT * FROM `student_unique_code` WHERE `student_email`='" . $studentData["email"] . "' AND `name`='" . $oneTimeCode . "'");
        $uniqueCodeRownumber = $uniqueCodeRsultset->num_rows;

        if ($uniqueCodeRownumber == 1) {
            $uniqueCodeData = $uniqueCodeRsultset->fetch_assoc();

            $startDate = new DateTime($studentData["joined_date"]);
            $tdate = new DateTime();
            $tz = new DateTimeZone("Asia/Colombo");
            $tdate->setTimezone($tz);

            $endDate = new DateTime($tdate->format("Y-m-d H:i:s"));

            $dateDifference = $endDate->diff($startDate);

            $year = $dateDifference->format('%Y');
            $month = $dateDifference->format('%m');
            $day = $dateDifference->format('%d');
            $hour = $dateDifference->format('%H');
            $minute = $dateDifference->format('%i');
            $second = $dateDifference->format('%s');

            if ($year < 01 && $month < 01 && $day < 01 && $hour <= 14 && $minute <= 59 && $second <= 59) {
                Database::insertUpdateDelete("UPDATE `student_unique_code` SET `name`='',`status`='2' WHERE `id`='" . $uniqueCodeData["id"] . "'");
                $_SESSION["student"] = $studentData;
                echo ("success");
            } else {
                Database::insertUpdateDelete("UPDATE `student_unique_code` SET `name`='exp' WHERE `id`='" . $uniqueCodeData["id"] . "'");
                echo ("Your one-time code has expired. Please notify an Academic Officer.");
            }
        } else {
            echo ("Your One-Time Code does not match");
        }
    } else {
        echo ("You are not a valid Student");
    }
}
