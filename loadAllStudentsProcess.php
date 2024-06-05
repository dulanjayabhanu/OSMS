<?php
require "connection.php";

$studentResultset = Database::search("SELECT * FROM `student`");
$studentRownumber = $studentResultset->num_rows;

if($studentRownumber < 10){
    echo("0".$studentRownumber);
}else{
    echo($studentRownumber);
}
?>