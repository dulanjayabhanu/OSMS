<?php
require "connection.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $teacherHasSubjectResultset = Database::search("SELECT * FROM `teacher_has_subject` WHERE `id`='" . $id . "'");
    $teacherHasSubjectRownumber = $teacherHasSubjectResultset->num_rows;
    $teacherHasSubjectEmailResultset = Database::search("SELECT * FROM `teacher_has_subject` WHERE `id`='" . $id . "'");
    $teacherHasSubjectEmailData = $teacherHasSubjectEmailResultset->fetch_assoc();
    if ($teacherHasSubjectRownumber > 0) {
        $teacherHasSubjectData = $teacherHasSubjectResultset->fetch_assoc();
        Database::insertUpdateDelete("DELETE FROM `teacher_has_subject` WHERE `id`='" . $id . "'");

        $teacherHasSubjectResultset2 = Database::search("SELECT * FROM `teacher_has_subject` WHERE `teacher_email`='" . $teacherHasSubjectEmailData["teacher_email"] . "'");
        $teacherHasSubjectRownumber2 = $teacherHasSubjectResultset2->num_rows;

        for ($x = 0; $x < $teacherHasSubjectRownumber2; $x++) {
            $teacherHasSubjectData2 = $teacherHasSubjectResultset2->fetch_assoc();
?>
            <!-- class and subject card -->
            <div class="col-6 col-md-4 col-lg-3 p-2">
                <div class="col-12 def-btn" style="background-color: #cdf1ff;">
                    <div class="row">
                        <div class="col-9 ps-2 text-end my-auto">
                            <span>
                                <?php
                                $gradeResultset = Database::search("SELECT * FROM `grade`");
                                $gardeRownumber = $gradeResultset->num_rows;

                                $subjectResultset = Database::search("SELECT * FROM `subject`");
                                $subjectRownumber = $subjectResultset->num_rows;

                                for ($y = 0; $y < $gardeRownumber; $y++) {
                                    $gradeData = $gradeResultset->fetch_assoc();
                                    if ($teacherHasSubjectData2["grade_id"] == $gradeData["id"]) {
                                        echo ($gradeData["name"]); ?> | <?php for ($z = 0; $z < $subjectRownumber; $z++) {
                                                                                $subjectData = $subjectResultset->fetch_assoc();
                                                                                if ($teacherHasSubjectData2["subject_id"] == $subjectData["id"]) {
                                                                            ?>
                                                <?php echo ($subjectData["name"]); ?></span>
            <?php
                                                                                }
                                                                            }
                                                                        }
                                                                    }
            ?>
                        </div>
                        <div class="col-3"><button class="border-0 bg-transparent" onclick="removeClassAndSubjectCard('<?php echo ($teacherHasSubjectData2['id']); ?>');"><i class="bi bi-x-circle-fill fs-5 text-primary"></i></button></div>
                    </div>
                </div>
            </div>
            <!-- class and subject card -->
        <?php
        }
        ?>
        <!-- Add new card -->
        <div class="col-6 col-md-4 col-lg-3 p-2 order-last">
            <button class="border-0 bg-transparent" id="add-new-loader1" onclick="showAddNewCard();">
                <div class="col-12 def-btn" style="background-color: #cecece;">
                    <div class="row">
                        <div class="col-9 ps-2 text-end my-auto">
                            <span>Add New</span>
                        </div>
                        <div class="col-3"><span class="pe-5"><i class="bi bi-plus-circle-fill fs-5 text-secondary"></i></span></div>
                    </div>
                </div>
            </button>

            <div class="col-12 def-btn d-none" id="add-new-loader2" style="background-color: #cecece;">
                <div class="row">
                    <div class="col-12 text-center pb-2">
                        <span>Add New</span>
                    </div>
                    <div class="col-12 mt-1 text-start">
                        <span>Grade</span>
                    </div>
                    <div class="col-12 d-grid">
                        <select class="def-input" id="grade">
                            <?php
                            $gradeResultset1 = Database::search("SELECT * FROM `grade`");
                            $gardeRownumber1 = $gradeResultset1->num_rows;

                            for ($g = 0; $g < $gardeRownumber1; $g++) {
                                $gradeData1 = $gradeResultset1->fetch_assoc();
                            ?>
                                <option value="<?php echo ($gradeData1["id"]) ?>"><?php echo ($gradeData1["name"]) ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12 mt-2 text-start">
                        <span>Subject</span>
                    </div>
                    <div class="col-12 pb-2 border-bottom d-grid">
                        <select class="def-input" id="subject">
                            <?php
                            $subjectResultset1 = Database::search("SELECT * FROM `subject`");
                            $subjectRownumber1 = $subjectResultset1->num_rows;

                            for ($s = 0; $s < $subjectRownumber1; $s++) {
                                $subjectData1 = $subjectResultset1->fetch_assoc();
                            ?>
                                <option value="<?php echo ($subjectData1["id"]) ?>"><?php echo ($subjectData1["name"]) ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12 mt-3 pb-2">
                        <div class="row">
                            <div class="col-6 d-flex flex-row justify-content-center">
                                <span class="def-btn def-btn-danger" onclick="showAddNewCard();" style="cursor: pointer;"><i class="bi bi-x text-white"></i></span>
                            </div>
                            <div class="col-6 d-flex flex-row justify-content-center">
                                <span class="def-btn def-btn-primary text-white" onclick="saveAddNewCard('<?php echo ($teacherHasSubjectData2['teacher_email']); ?>');" style="cursor: pointer;"><i class="bi bi-check2 text-white"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add new card -->
<?php
    }
}else{
    echo("Something Went Wrong");
}
?>