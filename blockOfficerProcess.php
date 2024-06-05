<?php
require "connection.php";

if(isset($_GET["email"])){
    $email = $_GET["email"];

    $officerResultset = Database::search("SELECT * FROM `teacher` WHERE `email`='".$email."'");
    $officerRownumber = $officerResultset->num_rows;

    if($officerRownumber == 1){
        $officerData = $officerResultset->fetch_assoc();
        if( intval($officerData["block_status"]) == 1){
            Database::insertUpdateDelete("UPDATE `teacher` SET `block_status`='2' WHERE `email`='".$email."'");
            echo("officer blocked");
        }else if(intval($officerData["block_status"]) == 2){
            Database::insertUpdateDelete("UPDATE `teacher` SET `block_status`='1' WHERE `email`='".$email."'");
            echo("officer unblocked");
        }
    }else{
        echo("Something Went Wrong");
    }

}else{
    echo("Something Went Wrong");
}

?>