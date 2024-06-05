<?php
session_start();
require "connection.php";

if (isset($_SESSION["student"])) {
    $email = $_SESSION["student"]["email"];

    $studentResultset = Database::search("SELECT * FROM `student` WHERE `email`='" . $email . "'");
    $studentData = $studentResultset->fetch_assoc();

    $gradeResultset = Database::search("SELECT * FROM `student_has_subject` WHERE `student_email`='" . $email . "'");
    $gradeData = $gradeResultset->fetch_assoc();
    $paymentResultset = Database::search("SELECT * FROM `invoice` WHERE `student_email`='" . $email . "' AND `grade_id`='" . $gradeData["grade_id"] . "'");
    $paymentData = $paymentResultset->fetch_assoc();

    if ($_SESSION["student"]["payment_status"] == 3 & $studentData["payment_status"] == 1) {
        session_destroy();
        session_start();
        $_SESSION["student"] = $studentData;
        echo ("success");
    }
}
