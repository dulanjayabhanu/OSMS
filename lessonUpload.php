<?php
session_start();
require "connection.php";

if (isset($_SESSION["teacher"])) {
    $subject = $_POST["subject"];
    $class = $_POST["class"];
    $type = $_POST["type"];

    if ($subject == 0) {
        echo ("Please select subject");
    } else if ($class == 0) {
        echo ("Please select class");
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

                $classResultset = Database::search("SELECT * FROM `grade` WHERE `id`='" . $class . "'");
                $classData = $classResultset->fetch_assoc();

                $subjectResultset = Database::search("SELECT * FROM `subject` WHERE `id`='" . $subject . "'");
                $subjectData = $subjectResultset->fetch_assoc();

                $teacherHasSubjectResultset = Database::search("SELECT * FROM `teacher_has_subject` WHERE `subject_id`='" . $subject . "' AND `grade_id`='" . $class . "' AND `teacher_email`='" . $_SESSION["teacher"]["email"] . "'");
                $teacherHasSubjectData = $teacherHasSubjectResultset->fetch_assoc();

                $classRoomResultset = Database::search("SELECT * FROM `classroom` WHERE `grade_id`='" . $class . "' AND `teacher_email`='" . $_SESSION["teacher"]["email"] . "'");
                $classRoomData = $classRoomResultset->fetch_assoc();

                $assignmentResultset = Database::search("SELECT * FROM `assignment` WHERE `classroom_id`='" . $classRoomData["id"] . "' AND `teacher_has_subject_id`='" . $teacherHasSubjectData["id"] . "' AND `type`='2'");
                $assignmentData = $assignmentResultset->fetch_assoc();

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

                $filename = "resources/lesson_notes/" . date("Y") . "_" . $classData["name"] . "_" . $subjectData["name"] . "_Lesson" . $assUniqId . $newFileExtention;
                move_uploaded_file($doc["tmp_name"], $filename);

                Database::insertUpdateDelete("INSERT INTO `assignment` (`name`,`classroom_id`,`teacher_has_subject_id`,`type`) VALUES ('" . $filename . "','" . $classRoomData["id"] . "','" . $teacherHasSubjectData["id"] . "','2')");
                echo ("Lesson Note Uploaded");
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
