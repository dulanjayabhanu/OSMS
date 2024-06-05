<?php
session_start();
require "connection.php";

if (isset($_SESSION["student"])) {
    $email = $_SESSION["student"]["email"];
    $studentResultset = Database::search("SELECT * FROM `student` WHERE `email`='" . $email . "'");
    $studentData = $studentResultset->fetch_assoc();

    $date = new DateTime($studentData["joined_date"]);
    date_add($date, date_interval_create_from_date_string("30 days"));

    $expireDate = new DateTime(date_format($date, "Y-m-d H:i:s"));

    $tdate = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $tdate->setTimezone($tz);
    $currentDate = new DateTime($tdate->format("Y-m-d H:i:s"));

    $difference = $expireDate->diff($currentDate);

    if ($difference->format("%d") == 0 & $difference->format("%H") == 0 & $difference->format("%i") == 0 & $difference->format("%s") == 0) {
        Database::insertUpdateDelete("UPDATE `student` SET `payment_status`='4' WHERE `email`='" . $studentData["email"] . "'");
        $studentResultset1 = Database::search("SELECT * FROM `student` WHERE `email`='" . $email . "'");
        $studentData1 = $studentResultset1->fetch_assoc();
        session_destroy();
        session_start();
        $_SESSION["student"] = $studentData1;
    }
    echo ($difference->format('%d') . " Days : " . $difference->format("%H") . " Hours : " .
        $difference->format('%i') . " Minutes : " . $difference->format('%s') . " Seconds");
}
?>