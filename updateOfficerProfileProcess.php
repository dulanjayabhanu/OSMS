<?php
session_start();
require "connection.php";

if(isset($_SESSION["officer"])){
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $mobile = $_POST["mobile"];

    if(isset($_FILES["image"])){
        $image = $_FILES["image"];
        $allowedImageExtentions = array("image/jpeg", "image/jpg", "image/png", "image/svg+xml");
        $fileExtention = $image["type"];

        if(in_array($fileExtention, $allowedImageExtentions)){
            $newFileExtention;
            if($fileExtention == "image/jpeg"){
                $newFileExtention = ".jpeg";
            }else if($fileExtention == "image/jpg"){
                $newFileExtention = ".jpg";
            }else if($fileExtention == "image/png"){
                $newFileExtention = ".png";
            }else if($fileExtention == "image/svg+xml"){
                $newFileExtention = ".svg";
            }

            $filename = "resources/images/profile_image/".$_SESSION["officer"]["first_name"]."_".uniqid().$newFileExtention;
            move_uploaded_file($image["tmp_name"], $filename);

            $imageResultset = Database::search("SELECT * FROM `teacher_profile_image` WHERE `teacher_email`='".$_SESSION["officer"]["email"]."'");
            $imageRownumber = $imageResultset->num_rows;

            if($imageRownumber == 1){
                Database::insertUpdateDelete("UPDATE `teacher_profile_image` SET `path`='".$filename."' WHERE `teacher_email`='".$_SESSION["officer"]["email"]."'");
            }else{
                Database::insertUpdateDelete("INSERT INTO `teacher_profile_image` (`path`,`teacher_email`) VALUES ('".$filename."','".$_SESSION["officer"]["email"]."')");
            }

        }else{
            echo("Please Select a valied image");
        }
    }

    Database::insertUpdateDelete("UPDATE `teacher` SET `first_name`='".$fname."',`last_name`='".$lname."',`mobile`='".$mobile."' WHERE `email`='".$_SESSION["officer"]["email"]."'");
    echo("profile updated");
}else{
    header("Location:academicOfficerDashboard.php");
}
