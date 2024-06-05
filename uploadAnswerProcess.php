<?php
session_start();
require "connection.php";

if (isset($_SESSION["student"])) {
    $assignmentId = $_POST["assignmentId"];
    if (empty($assignmentId)) {
        echo ("Something Went Wrong");
    } else {
        if (isset($_FILES["doc"])) {
            $doc = $_FILES["doc"];
            $allowedFileExtentions = array("application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/pdf", "text/plain");
            $fileExtention = $doc["type"];

            if (in_array($fileExtention, $allowedFileExtentions)) {
                $newFileExtention;
                if ($fileExtention == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
                    $newFileExtention = ".docx";
                } else if ($fileExtention == "application/pdf") {
                    $newFileExtention = ".pdf";
                } else if ($fileExtention == "text/plain") {
                    $newFileExtention = ".txt";
                }

                $assignmentResultset = Database::search("SELECT * FROM `assignment` WHERE `id`='" . $assignmentId . "' AND `type`='1'");
                $assignmentData = $assignmentResultset->fetch_assoc();

                $teacherHasSubjectResultset = Database::search("SELECT * FROM `teacher_has_subject` WHERE `id`='".$assignmentData["teacher_has_subject_id"]."'");
                $teacherHasSubjectData = $teacherHasSubjectResultset->fetch_assoc();

                $classResultset = Database::search("SELECT * FROM `grade` WHERE `id`='" . $teacherHasSubjectData["grade_id"] . "'");
                $classData = $classResultset->fetch_assoc();

                $subjectResultset = Database::search("SELECT * FROM `subject` WHERE `id`='" . $teacherHasSubjectData["subject_id"] . "'");
                $subjectData = $subjectResultset->fetch_assoc();

                $tdate = new DateTime();
                $tz = new DateTimeZone("Asia/Colombo");
                $tdate->setTimezone($tz);
                $currentDate = $tdate->format("Y-m-d H:i:s");

                function generateUniqId($startNum, $idLenght)
                {
                    $uniqId = uniqid();
                    $newUniqId = substr($uniqId, intval($startNum), intval($idLenght));
                    return $newUniqId;
                }
                $assUniqId = generateUniqId(5, 4);

                $filename = "resources/answer_sheet/" . date("Y") . "_" . $classData["name"] . "_" . $subjectData["name"] . "_AnswerSheet" . $assUniqId . $newFileExtention;
                move_uploaded_file($doc["tmp_name"], $filename);

                Database::insertUpdateDelete("INSERT INTO `answer_sheet` (`name`,`submit_date`,`assignment_id`,`status`) VALUES ('" . $filename . "','" . $currentDate . "','" . $assignmentId . "','2')");
                echo ("Answer Sheet Uploaded");
            } else {
                echo ("Unsupported File Type");
            }
        } else {
            echo ("Something Went Wrong");
        }
    }
} else {
    echo ("Something Went Wrong");
}
