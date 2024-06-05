<?php
require "connection.php";

if (isset($_GET["subject"]) && isset($_GET["grade"]) && isset($_GET["email"])) {
    $email = $_GET["email"];
    $subjectId = $_GET["subject"];
    $gradeId = $_GET["grade"];

    $teacherHasSubjectResultset = Database::search("SELECT * FROM `teacher_has_subject` WHERE `teacher_email`='" . $email . "' AND `subject_id`='" . $subjectId . "' AND `grade_id`='" . $gradeId . "'");
    $teacherHasSunbjectRownumber = $teacherHasSubjectResultset->num_rows;

    if ($teacherHasSunbjectRownumber > 0) {
        echo ("This Grade and Subject already Assigned");
    } else {
        Database::insertUpdateDelete("INSERT INTO `teacher_has_subject` (`teacher_email`,`subject_id`,`grade_id`) VALUES ('" . $email . "','" . $subjectId . "','" . $gradeId . "')");

        $subjectResultset = Database::search("SELECT * FROM `subject` WHERE `id`='".$subjectId."'");
        $subjectData = $subjectResultset->fetch_assoc();
        $gradeResultset = Database::search("SELECT * FROM `grade` WHERE `id`='".$gradeId."'");
        $gradeData = $gradeResultset->fetch_assoc();
?>
        <div class="col-12 def-btn" style="background-color: #cdf1ff;">
            <div class="row">
                <div class="col-9 ps-2 text-end my-auto">
                    <span><?php echo($gradeData["name"]); ?> | <?php echo($subjectData["name"]); ?></span>
                </div>
                <div class="col-3">
                    <button class="border-0 bg-transparent" onclick="removeClassAndSubjectCard('<?php echo($teacherHasSubjectData['email']); ?>');"><i class="bi bi-x-circle-fill fs-5 text-primary"></i></button>
                </div>
            </div>
        </div>
<?php
    }
} else {
    echo ("Something Went Wrong");
}

?>