<?php
require "connection.php";

$id = $_GET["id"];
$name = $_GET["name"];
$grade = $_GET["grade"];

$query = "SELECT * FROM `answer_sheet` INNER JOIN `assignment` ON
answer_sheet.assignment_id=assignment.id INNER JOIN `classroom` ON
assignment.classroom_id=classroom.id INNER JOIN `student` ON
classroom.student_email=student.email";

if (!empty($name) & $grade == 0 & $id == 0) {
    $query .= " WHERE `assignment`.`name` LIKE '%" . $name . "%'";
} else if (empty($name) & $grade != 0 & $id == 0) {
    $query .= " WHERE `classroom`.`grade_id`='" . $grade . "'";
} else if (!empty($name) & $grade != 0 & $id == 0) {
    $query .= " WHERE `assignment`.`name` LIKE '%" . $name . "%' AND `classroom`.`grade_id`='" . $grade . "'";
} else if (!empty($name) & $grade == 0 & $id != 0) {
    $query .= " WHERE `assignment`.`name` LIKE '%" . $name . "%' AND `assignment_id`='" . $id . "'";
} else if (empty($name) & $grade != 0 & $id != 0) {
    $query .= " WHERE `assignment_id`='" . $id . "' AND `classroom`.`grade_id`='" . $grade . "'";
} else if (empty($name) & $grade == 0 & $id != 0) {
    $query .= " WHERE `assignment_id`='" . $id . "'";
}

$answerResultset = Database::search($query);
$answerRownumber = $answerResultset->num_rows;

if ($answerRownumber > 0) {
    for ($x = 0; $x < $answerRownumber; $x++) {
        $answerData = $answerResultset->fetch_assoc();
?>
        <!-- Student card -->
        <div class="col-12 p-2">
            <div class="col-12 p-3 def-card bg-white">
                <div class="row">
                    <div class="col-12 col-lg-2 my-auto">
                        <span><?php echo ($answerData["first_name"] . " " . $answerData["last_name"]); ?></span>
                    </div>
                    <div class="col-12 col-lg-3 my-auto">
                        <span><?php echo ($answerData["email"]); ?></span>
                    </div>
                    <div class="col-12 col-lg-1 my-auto">
                        <?php
                        $assignmentSplit = explode("/", $answerData["name"]);
                        $assignmentFileName = explode(".", $assignmentSplit[2]);
                        $assignmentFileSplit = explode("_", $assignmentFileName[0]);
                        ?>
                        <span><?php echo ($assignmentFileSplit[1]); ?></span>
                    </div>
                    <div class="col-12 col-lg-3 d-grid mt-2 mt-lg-0">
                        <?php
                        $assignmentName = $assignmentFileSplit[1] . "-" . $assignmentFileSplit[2];
                        ?>
                        <span><?php echo ($assignmentFileName[1]); ?></span>
                    </div>
                    <div class="col-12 col-lg-3 d-grid mt-2 mt-lg-0">
                        <span><?php echo ($answerData["marks"]); ?></span>
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
