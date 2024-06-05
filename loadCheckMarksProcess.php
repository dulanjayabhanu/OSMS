<?php
require "connection.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $studentAnswerResultset = Database::search("SELECT * FROM `answer_sheet` INNER JOIN `assignment` ON
            answer_sheet.assignment_id=assignment.id INNER JOIN `classroom` ON
            assignment.classroom_id=classroom.id INNER JOIN `student` ON
            classroom.student_email=student.email WHERE `assignment_id`='" . $id . "'");
    $studentAnswerRownumber = $studentAnswerResultset->num_rows;

    for ($s = 0; $s < $studentAnswerRownumber; $s++) {
        $studentAnswerData = $studentAnswerResultset->fetch_assoc();
?>
        <div class="def-card p-3 bg-white mb-2">
            <div class="row">
                <div class="offset-2 offset-lg-0 col-3 col-lg-1 bg-white d-flex flex-row justify-content-center align-items-center">
                    <?php
                    $studentProfileResultset = Database::search("SELECT * FROM `student_profile_image` WHERE `student_email`='" . $studentAnswerData["email"] . "'");
                    $studentProfileRownumber = $studentProfileResultset->num_rows;
                    if ($studentProfileRownumber > 0) {
                        $studentProfileData = $studentProfileResultset->fetch_assoc();
                    ?>
                        <img src="<?php echo ($studentProfileData["path"]); ?>" class="img-thumbnail border-0 p-1" style="border-radius: 100%;height:55px;width:60px;box-shadow: 0px 2px 3px 1px rgba(19, 70, 129, 0.5);background-size: contain;" />
                    <?php
                    } else {
                    ?>
                        <div class="col-12 p-3 bg-white d-flex flex-row justify-content-center align-items-center" style="border-radius: 100%;height:50px;width:50px;box-shadow: 0px 2px 3px 1px rgba(19, 70, 129, 0.5);">
                            <img src="resources/images/user.svg" class="img-fluid border-1" style="height:60px;width:60px;" />
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="col-6 col-lg-1 my-auto">
                    <span style="font-family: 'quicksand-bold';"><?php echo ($studentAnswerData["first_name"] . " " . $studentAnswerData["last_name"]); ?></span>
                </div>
                <div class="col-2 my-auto d-none d-lg-block">
                    <span class="text-primary text-start"><?php echo ($studentAnswerData["email"]); ?></span>
                </div>
                <div class="col-2 d-none d-lg-block my-auto">
                    <span class="ps-2"><?php echo (explode(" ", $studentAnswerData["submit_date"])[0]); ?></span><br />
                </div>
                <div class="col-12 col-lg-2 d-grid mt-3 mt-lg-0">
                    <?php
                    $answerResultset = Database::search("SELECT * FROM `answer_sheet` WHERE `assignment_id`='" . $studentAnswerData["assignment_id"] . "'");
                    $answerData = $answerResultset->fetch_assoc();

                    $answerSrc = $answerData["name"];
                    $answerSrcSplit = explode("/", $answerSrc);
                    $answerFileName = $answerSrcSplit[2];
                    ?>
                    <a class="btn def-btn def-btn-danger my-auto text-white text-decoration-none" href="resources/answer_sheet/<?php echo ($answerFileName); ?>" download="<?php echo ($answerFileName); ?>"><i class="bi bi-download text-white"></i>&nbsp;&nbsp;Answer Sheet</a>
                </div>
                <?php
                if (empty($answerData["marks"])) {
                ?>
                    <div class="col-12 col-lg-2 d-grid d-none d-lg-block pt-3 pt-lg-2">
                        <input type="text" class="def-input my-auto" style="width: 98%;" placeholder="Enter Marks" id="marks<?php echo ($s); ?>" />
                    </div>
                    <div class="col-12 col-lg-2 d-grid d-block d-lg-none pt-3 pt-lg-0">
                        <input type="text" class="def-input" placeholder="Enter Marks" id="marks<?php echo ($s); ?>" />
                    </div>
                <?php
                } else {
                ?>
                    <div class="col-12 col-lg-2 d-grid d-none d-lg-block pt-3 pt-lg-2">
                        <input type="text" class="def-input my-auto" style="width: 98%;" placeholder="Enter Marks" value="<?php echo ($answerData["marks"]); ?>" id="marks<?php echo ($s); ?>" />
                    </div>
                    <div class="col-12 col-lg-2 d-grid d-block d-lg-none pt-3 pt-lg-0">
                        <input type="text" class="def-input" placeholder="Enter Marks" value="<?php echo ($answerData["marks"]); ?>" id="marks<?php echo ($s); ?>" />
                    </div>
                <?php
                }
                ?>
                <div class="col-12 col-lg-2 d-grid mt-3 mt-lg-0">
                    <button class="def-btn def-btn-primary my-auto text-white" onclick="submitMarks('<?php echo ($answerData['id']); ?>', 'marks<?php echo ($s); ?>');"><i class="bi bi-check-circle text-white"></i>&nbsp;Submite</button>
                </div>
                <div class="col-12 pt-2">
                    <span style="font-size: 13px;color: #f81919" id="error-text-loader4"></span>
                </div>
            </div>
        </div>
        <!-- Student verify card -->
<?php
    }
}