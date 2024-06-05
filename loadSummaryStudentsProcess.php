<?php
require "connection.php";

$studentResultset = Database::search("SELECT * FROM `student`");
$studentRownumber = $studentResultset->num_rows;

$verifyStudents = 0;
$unVerifyStudents = 0;

for ($x = 0; $x < $studentRownumber; $x++) {
    $studentData = $studentResultset->fetch_assoc();

    if ($studentData["verify_status"] == 1) {
        $verifyStudents += 1;
    } else if ($studentData["verify_status"] == 2) {
        $unVerifyStudents += 1;
    }
}

?>
<div class="col-12 text-center pt-3 pb-2 border-bottom">
    <h2>Student Summary</h2>
</div>
<div class="col-12 p-4 pe-4 mt-3 text-center text-lg-start">
    <span class="fs-5 pb-2" style="font-family: 'quicksand-bold';">Verifed Students</span><br />
    <div class="col-12 mt-2">
        <span class="badge rounded-pill text-black fs-5" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#fbff00;">&nbsp;&nbsp;<?php if($verifyStudents < 10){
            echo("0".$verifyStudents);
        }else{
            echo($verifyStudents);
        }?>&nbsp;&nbsp;</span>
    </div>
</div>
<div class="col-12 p-4 pe-4 text-center text-lg-start border-top">
    <span class="fs-5 pb-2" style="font-family: 'quicksand-bold';">Unverifed Students</span><br />
    <div class="col-12 mt-2">
        <span class="badge rounded-pill text-white fs-5" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#27da77;">&nbsp;&nbsp;<?php if($verifyStudents < 10){
            echo("0".$unVerifyStudents);
        }else{
            echo($unVerifyStudents);
        }?>&nbsp;&nbsp;</span>
    </div>
</div>