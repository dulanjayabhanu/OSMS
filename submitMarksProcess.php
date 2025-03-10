<?php
require "connection.php";

$answerSheetId = $_POST["id"];
$marks = $_POST["marks"];

if (empty($marks)) {
    echo ("Please enter student's marks");
} else if (!is_numeric($marks)) {
    echo ("Invalied marks");
} else if (intval($marks) > 100 | intval($marks) < 0) {
    echo ("Marks should be given in the range of 0-100");
} else {
    $answerSheetResultset = Database::search("SELECT * FROM `answer_sheet` WHERE `id`='" . $answerSheetId . "'");
    $answerSheetRownumber = $answerSheetResultset->num_rows;

    if ($answerSheetRownumber > 0) {
        $answerSheetData = $answerSheetResultset->fetch_assoc();

        Database::insertUpdateDelete("UPDATE `answer_sheet` SET `marks`='" . $marks . "' WHERE `id`='" . $answerSheetId . "'");
        echo ("Marks Added");
    } else {
        echo ("Something Went Wrong");
    }
}
