<?php
session_start();
require "connection.php";

if(isset($_SESSION["student"])){
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $dateOfBirth = $_POST["dateOfBirth"];
    $line1 = $_POST["line1"];
    $line2 = $_POST["line2"];
    $city = $_POST["city"];
    $postalCode = $_POST["postalCode"];
    $parentFirstName = $_POST["parentFirstName"];
    $parentLastName = $_POST["parentLastName"];
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

            $filename = "resources/images/profile_image/".$_SESSION["student"]["first_name"]."_".uniqid().$newFileExtention;
            move_uploaded_file($image["tmp_name"], $filename);

            $imageResultset = Database::search("SELECT * FROM `student_profile_image` WHERE `student_email`='".$_SESSION["student"]["email"]."'");
            $imageRownumber = $imageResultset->num_rows;

            if($imageRownumber == 1){
                Database::insertUpdateDelete("UPDATE `student_profile_image` SET `path`='".$filename."' WHERE `student_email`='".$_SESSION["student"]["email"]."'");
            }else{
                Database::insertUpdateDelete("INSERT INTO `student_profile_image` (`path`,`student_email`) VALUES ('".$filename."','".$_SESSION["student"]["email"]."')");
            }

        }else{
            echo("Please Select a valied image");
        }
    }

    Database::insertUpdateDelete("UPDATE `student` SET `first_name`='".$fname."',`last_name`='".$lname."',`mobile`='".$mobile."',`date_of_birth`='".$dateOfBirth."' WHERE `email`='".$_SESSION["student"]["email"]."'");
    $studentHasAddressResultset = Database::search("SELECT * FROM `student_has_address` WHERE `student_email`='".$_SESSION["student"]["email"]."'");
    $studentHasAddressRownumber = $studentHasAddressResultset->num_rows;
    if($studentHasAddressRownumber == 0){
        Database::insertUpdateDelete("INSERT INTO `student_has_address` (`student_email`,`city_id`,`line1`,`line2`,`postal_code`) VALUES ('".$_SESSION["student"]["email"]."','".$city."','".$line1."','".$line2."','".$postalCode."')");
    }else{
        Database::insertUpdateDelete("UPDATE `student_has_address` SET `city_id`='".$city."',`line1`='".$line1."',`line2`='".$line2."',`postal_code`='".$postalCode."' WHERE `student_email`='".$_SESSION["student"]["email"]."'");
    }
    Database::insertUpdateDelete("UPDATE `parent` SET `first_name`='".$parentFirstName."',`last_name`='".$parentLastName."' WHERE `email`='".$_SESSION["student"]["parent_email"]."'");
    echo("profile updated");
}else{
    header("Location:studentDashboard.php");
}
