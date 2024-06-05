<?php
session_start();
require "connection.php";

if(isset($_SESSION["adminUser"])){
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

            $filename = "resources/images/profile_image/".$_SESSION["adminUser"]["first_name"]."_".uniqid().$newFileExtention;
            move_uploaded_file($image["tmp_name"], $filename);

            $imageResultset = Database::search("SELECT * FROM `admin_profile_image` WHERE `admin_email`='".$_SESSION["adminUser"]["email"]."'");
            $imageRownumber = $imageResultset->num_rows;

            if($imageRownumber == 1){
                Database::insertUpdateDelete("UPDATE `admin_profile_image` SET `path`='".$filename."' WHERE `admin_email`='".$_SESSION["adminUser"]["email"]."'");
            }else{
                Database::insertUpdateDelete("INSERT INTO `admin_profile_image` (`path`,`admin_email`) VALUES ('".$filename."','".$_SESSION["adminUser"]["email"]."')");
            }

        }else{
            echo("Please Select a valied image");
        }
    }

    Database::insertUpdateDelete("UPDATE `admin` SET `first_name`='".$fname."',`last_name`='".$lname."',`mobile`='".$mobile."' WHERE `email`='".$_SESSION["adminUser"]["email"]."'");
    echo("profile updated");
}else{
    header("Location:adminPanel.php");
}
