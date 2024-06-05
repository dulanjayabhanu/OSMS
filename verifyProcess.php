<?php

session_start();
require "connection.php";

if (isset($_GET["vcode"])) {
    $verificationcode = $_GET["vcode"];
    if (!empty($verificationcode)) {
        $adminResultset = Database::search("SELECT * FROM `admin` WHERE `verification_code`='" . $verificationcode . "'");
        $adminRownumber = $adminResultset->num_rows;

        if ($adminRownumber == 1) {
            $adminData = $adminResultset->fetch_assoc();
            $_SESSION["adminUser"] = $adminData;
            echo ("success");
        } else {
            echo ("Invalied verification code");
        }
    } else {
        echo ("Please enter your verification code");
    }
} else {
    echo ("Please enter your verification code");
}
