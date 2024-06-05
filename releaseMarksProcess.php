<?php
include "connection.php";

if(isset($_GET["id"])){
    $id = $_GET["id"];

    $answerResultset = Database::search("SELECT * FROM `answer_sheet` WHERE `assignment_id`='".$id."' AND `status`='1'");
    $answerRownumber = $answerResultset->num_rows;

    if($answerRownumber > 0){
        for($x = 0; $x < $answerRownumber; $x++){
            $answerData = $answerResultset->fetch_assoc();

            if(!empty($answerData["marks"]) & intval($answerData["marks"]) > 0){
                Database::insertUpdateDelete("UPDATE `answer_sheet` SET `status`='3' WHERE `id`='".$answerData["id"]."'");
                echo("Marks Released");
            }else{
                echo("An error has occurred while entering marks. Please check again");
            }
        }
    }else{
        echo("Marks Already Released");
    }
}else{
    echo("Something Went Wrong");
}
?>