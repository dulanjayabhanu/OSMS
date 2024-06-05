<?php
session_start();
require "connection.php";

if (isset($_SESSION["student"])) {
    $subject = $_POST["subject"];
    $assignmentResultset = Database::search("SELECT * FROM `classroom` INNER JOIN `teacher_has_subject` ON
    classroom.teacher_email=teacher_has_subject.teacher_email INNER JOIN `assignment` ON
    teacher_has_subject.id=assignment.teacher_has_subject_id WHERE `student_email`='" . $_SESSION["student"]["email"] . "' AND `assignment`.`type`='2'");
    $assignmentRownumber = $assignmentResultset->num_rows;

    if ($assignmentRownumber == 0) {
?>
        <!-- Student empty card -->
        <div class="col-12">
            <div class="col-6 col-lg-12 pt-5 pb-5 def-card bg-white text-center">
                <span>No Results</span>
            </div>
        </div>
        <!-- Student empty card -->
        <?php
    } else {
        for ($x = 0; $x < $assignmentRownumber; $x++) {
            $assignmentData = $assignmentResultset->fetch_assoc();
            $assignmentSrc = $assignmentData["name"];
            $srcSplit = explode("/", $assignmentSrc);
            $fileSrc = $srcSplit[0]."//".$srcSplit[1]."//";
            $fileName = $srcSplit[2];
        ?>
            <!-- Lesson card -->
            <div class="col-lg-12 p-2">
                <div class="col-12 p-1 def-card bg-white card-animate">
                    <div class="col-12 ps-2">
                        <div class="card-body p-1">
                            <div class="row">
                                <div class="col-12 pt-2 pe-2 pb-2 text-start text-md-center text-lg-start">
                                    <h5 class="text-capitalize" style="font-family: 'quicksand-bold';color: #353535;"><i class="bi bi-file-earmark-richtext text-primary fs-4"></i>&nbsp;<?php echo ($fileName); ?></h5>
                                </div>
                                <div class="col-12">
                                    <div class="row g-2 pt-2 pe-2 pb-2">
                                        <div class="col-12 col-lg-6 d-grid">
                                            <button class="def-btn def-btn-success text-white" onclick="loadLessonModal('<?php echo ($assignmentData['name']); ?>');"><i class="bi bi-box-arrow-up-left text-white fs-4"></i>&nbsp;&nbsp;View</button>
                                        </div>
                                        <div class="col-12 col-lg-6 d-grid text-center">
                                            <a class="def-btn def-btn-danger text-white text-decoration-none" href="resources/lesson_notes/<?php echo ($fileName); ?>" download="<?php echo ($fileName); ?>"><i class="bi bi-download text-white fs-4"></i>&nbsp;&nbsp;Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Lesson card -->
<?php
        }
    }
} else {
    echo ("Something Went Wrong");
}
?>