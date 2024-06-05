<?php
session_start();
require "connection.php";

if(isset($_SESSION["student"])){
    $email = $_GET["email"];

    $array;

    function generateUniqId($startNum, $idLenght)
        {
            $uniqId = uniqid();
            $newUniqId = substr($uniqId, intval($startNum), intval($idLenght));
            return $newUniqId;
        }

    $billId = "bill_".generateUniqId(6,5);

    $cityResultset = Database::search("SELECT * FROM `student_has_address` WHERE `student_email`='".$email."'");
    $cityRownumber = $cityResultset->num_rows;

    if($cityRownumber == 1){
        $cityData = $cityResultset->fetch_assoc();

        $cityId = $cityData["city_id"];
        $address = $cityData["line1"].", ".$cityData["line2"];

        $districtresultset = Database::search("SELECT * FROM `city` WHERE `id`='".$cityId."'");
        $districtData = $districtresultset->fetch_assoc();

        $amount = 2000;

        $fname = $_SESSION["student"]["first_name"];
        $lanme = $_SESSION["student"]["last_name"];
        $mobile = $_SESSION["student"]["mobile"];
        $studentAddress = $address;
        $city = $districtData["name"];

        $array["id"] = $billId;
        $array["amount"] = $amount;
        $array["first_name"] = $fname;
        $array["last_name"] = $lanme;
        $array["mobile"] = $mobile;
        $array["address"] = $studentAddress;
        $array["city"] = $city;
        $array["email"] = $email;
        echo(json_encode($array));

    }else{
        echo("2");
    }
}else{
    echo("1");
}

?>