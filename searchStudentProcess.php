<?php
require "connection.php";

$stname = $_POST["stname"];
$grade = $_POST["grade"];

$query = "SELECT * FROM `student` INNER JOIN `classroom` ON
student.email=classroom.student_email INNER JOIN `grade` ON
classroom.grade_id=grade.id";

if (!empty($stname) & $grade == 0) {
    $query .= " WHERE `first_name` LIKE '" . $stname . "%' OR `last_name` LIKE '" . $stname . "%'";
} else if (empty($stname) & $grade != 0) {
    $query .= " WHERE `classroom`.`grade_id`='" . $grade . "'";
} else if (!empty($stname) & $grade != 0) {
    $query .= " WHERE `first_name` LIKE '" . $stname . "%' OR `last_name` LIKE '" . $stname . "%' AND `classroom`.`grade_id`='" . $grade . "'";
}

$studentResultset = Database::search($query);
$studentRownumber = $studentResultset->num_rows;

if ($studentRownumber > 0) {
    for ($x = 0; $x < $studentRownumber; $x++) {
        $studentData = $studentResultset->fetch_assoc();
?>
        <!-- Student card -->
        <div class="col-12 p-2">
            <div class="col-12 p-3 def-card bg-white">
                <div class="row">
                    <div class="col-12 col-lg-2 my-auto">
                        <span><?php echo ($studentData["first_name"] . " " . $studentData["last_name"]); ?></span>
                    </div>
                    <div class="col-12 col-lg-3 my-auto">
                        <span><?php echo ($studentData["email"]); ?></span>
                    </div>
                    <div class="col-12 col-lg-1 my-auto">
                        <span><?php echo ($studentData["name"]); ?></span>
                    </div>
                    <div class="col-12 col-lg-3 d-grid mt-2 mt-lg-0">
                        <select class="def-input bg-body" id="upgrade-class">
                            <option value="0">Update Class To...</option>
                            <?php
                            $classResultset = Database::search("SELECT * FROM `grade`");
                            $classRownumber = $classResultset->num_rows;

                            for ($c = 0; $c < $classRownumber; $c++) {
                                $classData = $classResultset->fetch_assoc();
                            ?>
                                <option value="<?php echo ($classData["id"]) ?>"><?php echo ($classData["name"]); ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12 col-lg-3 d-grid mt-2 mt-lg-0">
                        <button class="def-btn def-btn-success text-white" onclick="upgradeClass('<?php echo ($studentData['email']); ?>');"><i class="bi bi-caret-up-fill text-white fs-6"></i>&nbsp;&nbsp;Update</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Student card -->
    <?php
    }
    ?>
<?php
} else {
?>
    <!-- Student empty card -->
    <div class="col-12 p-2">
        <div class="col-12 pt-5 pb-5 def-card bg-white text-center">
            <span>No Results</span>
        </div>
    </div>
    <!-- Student empty card -->
<?php
}
