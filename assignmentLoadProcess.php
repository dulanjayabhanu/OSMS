<?php
session_start();
require "connection.php";

if (isset($_SESSION["student"])) {
    $subject = $_POST["subject"];
    $assignmentResultset = Database::search("SELECT * FROM `classroom` INNER JOIN `teacher_has_subject` ON
    classroom.teacher_email=teacher_has_subject.teacher_email INNER JOIN `assignment` ON
    teacher_has_subject.id=assignment.teacher_has_subject_id WHERE `student_email`='" . $_SESSION["student"]["email"] . "' AND `assignment`.`type`='1'");
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
            $fileSrc = $srcSplit[0] . "//" . $srcSplit[1] . "//";
            $fileName = $srcSplit[2];
        ?>
            <!-- Assignment card -->
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
                                        <?php
                                        $answerResultset = Database::search("SELECT * FROM `answer_sheet` WHERE `assignment_id`='" . $assignmentData["id"] . "' AND `status`='3'");
                                        $answerRownumber = $answerResultset->num_rows;

                                        if ($answerRownumber == 1) {
                                            $answerData = $answerResultset->fetch_assoc();
                                        ?>
                                            <div class="col-12 ps-3 pe-3 pb-3 pt-1">
                                                <div class="col-12 d-grid text-center p-2" style=" background-image: linear-gradient(24deg, #2130fc, #9774fa);border-radius: 24px;animation-name: result-card-light;animation-duration: 2s;animation-iteration-count: infinite">
                                                    <span class="fs-5 text-white border-bottom border-white pb-3 pt-2" style="font-family: 'quicksand-bold';">Your Assignment Marks Released</span>
                                                    <span class="text-white pt-3 pb-2 fs-5 my-auto">Your Marks is<?php
                                                    if($answerData["marks"] <= 100.00 & $answerData["marks"] > 75.00){
                                                        ?>
                                                        <span class="fs-4 text-white ps-3 pe-3" style="border-radius: 24px;background-color:#017c38;"><?php echo($answerData["marks"]); ?>%</span></span>
                                                        <?php
                                                    }else if($answerData["marks"] <= 75.00 & $answerData["marks"] > 65.00){
                                                        ?>
                                                        <span class="fs-4 text-white ps-3 pe-3" style="border-radius: 24px;background-color:#0cc92c;"><?php echo($answerData["marks"]); ?>%</span></span>
                                                        <?php
                                                    }else if($answerData["marks"] <= 65.00 & $answerData["marks"] > 55.00){
                                                        ?>
                                                        <span class="fs-4 text-black ps-3 pe-3" style="border-radius: 24px;background-color:#37f146;"><?php echo($answerData["marks"]); ?>%</span></span>
                                                        <?php
                                                    }else if($answerData["marks"] <= 55.00 & $answerData["marks"] > 40.00){
                                                        ?>
                                                        <span class="fs-4 text-black ps-3 pe-3" style="border-radius: 24px;background-color:#fbff00;"><?php echo($answerData["marks"]); ?>%</span></span>
                                                        <?php
                                                    }else if($answerData["marks"] <= 40.00 & $answerData["marks"] > 0){
                                                        ?>
                                                        <span class="fs-4 text-black ps-3 pe-3" style="border-radius: 24px;background-color:#c4c4c4;"><?php echo($answerData["marks"]); ?>%</span></span>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="col-12 col-lg-6 d-grid text-center">
                                                <button class="def-btn def-btn-primary text-white" onclick="loadAssignmentUploadModal(<?php echo ($assignmentData['id']); ?>);"><i class="bi bi-upload text-white fs-4"></i>&nbsp;&nbsp;Upload Answers</button>
                                            </div>
                                            <div class="col-12 col-lg-6 d-grid text-center">
                                                <a class="def-btn def-btn-danger text-white text-decoration-none" href="resources/assignments/<?php echo ($fileName); ?>" download="<?php echo ($fileName); ?>"><i class="bi bi-download text-white fs-4"></i>&nbsp;&nbsp;Download</a>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Assignment card -->
<?php
        }
    }
} else {
    echo ("Something Went Wrong");
}
?>