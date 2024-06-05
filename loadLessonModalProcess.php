<?php
require "connection.php";
$docSrc = $_POST["docSrc"];

$assignmentResultset = Database::search("SELECT * FROM `assignment` WHERE `name`='" . $docSrc . "'");
$assignmentData = $assignmentResultset->fetch_assoc();

$assignmentSrc = $assignmentData["name"];
$srcSplit = explode("/", $assignmentSrc);
$fileName = $srcSplit[2];
?>
<div class="text-center pt-1 pb-1">
    <h5 class="modal-title mt-2 fs-3"><?php echo($fileName); ?></h5>
</div>
<div class="modal-body mt-2 pb-2">
    <div class="row g-1 ps-2 pe-2 pb-3">
        <embed style="height: 1000px;border-radius: 24px;" src="<?php echo($assignmentSrc); ?>" />
    </div>
</div>
<div class="modal-footer">
    <button class="def-btn def-btn-body text-black" type="button" data-bs-dismiss="modal"><i class="bi bi-fullscreen-exit fs-4 text-black"></i></button>
</div>