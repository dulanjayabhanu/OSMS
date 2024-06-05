<?php
require "connection.php";

$officerVerifyResultset = Database::search("SELECT * FROM `teacher` INNER JOIN `unique_code` ON
                                    teacher.email=unique_code.teacher_email WHERE `user_type`='2' AND `verify_status`='2'");
$officerVerifyRownumber = $officerVerifyResultset->num_rows;
?>
<div class="def-card p-2 bg-white mb-1">
    <div class="row">
        <div class="col-2 my-auto ps-3">
            <span style="font-family: 'quicksand-bold';">Profile</span><br />
        </div>
        <div class="col-4 my-auto">
            <span style="font-family: 'quicksand-bold';">Teacher Detail</span><br />
        </div>
        <div class="col-4 my-auto">
            <span style="font-family: 'quicksand-bold';">Invitation Status</span><br />
        </div>
        <div class="col-2 my-auto">
            <span style="font-family: 'quicksand-bold';">Make Verify</span><br />
        </div>
    </div>
</div>
<?php
if ($officerVerifyRownumber == 0) {
?>
    <!-- Officer verify empty card -->
    <div class="def-card ps-3 pe-3 pt-5 pb-5 bg-white mb-2 text-center">
        <span>No Results</span>
    </div>
    <!-- Officer verify empty card -->
    <?php
} else {
    for ($v = 0; $v < $officerVerifyRownumber; $v++) {
        $officerVerifyData = $officerVerifyResultset->fetch_assoc();
    ?>
        <!-- Officer verify card -->
        <div class="def-card p-3 bg-white mb-2">
            <div class="row">
                <div class="col-2 bg-white d-flex flex-row justify-content-center align-items-center">
                    <?php
                    $officerVerifyProfileResultset = Database::search("SELECT * FROM `teacher_profile_image` WHERE `teacher_email`='" . $officerVerifyData["email"] . "'");
                    $officerVerifyProfileRownumber = $officerVerifyProfileResultset->num_rows;
                    if ($officerVerifyProfileRownumber > 0) {
                        $officerVerifyProfileData = $officerVerifyProfileResultset->fetch_assoc();
                    ?>
                        <img src="<?php echo ($officerVerifyProfileData["path"]); ?>" class="img-thumbnail border-0 p-1" style="border-radius: 100%;height:55px;width:60px;box-shadow: 0px 2px 3px 1px rgba(19, 70, 129, 0.5);background-size: contain;" />
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
                <div class="col-4 my-auto">
                    <span style="font-family: 'quicksand-bold';"><?php echo ($officerVerifyData["first_name"] . " " . $officerVerifyData["last_name"]); ?></span><br />
                    <span class="text-primary" style="font-size: 11px;"><?php echo ($officerVerifyData["email"]); ?></span>
                </div>
                <div class="col-3 my-auto">
                    <?php
                    if ($officerVerifyData["status"] == 1) {
                    ?>
                        <span class="badge rounded-pill text-black fs-6 fw-light" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#fbff00;"><i class="bi bi-check"></i>&nbsp;Pending</span>
                    <?php
                    } else if ($officerVerifyData["status"] == 2) {
                    ?>
                        <span class="badge rounded-pill text-white fs-6 fw-light" style="font-family:'quicksand-regular';padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#2c99c4;"><i class="bi bi-check-all text-white"></i>&nbsp;Accepted</span>
                    <?php
                    }
                    ?>
                </div>
                <div class="col-3 d-grid">
                    <?php
                    if ($officerVerifyData["status"] == 1 && $officerVerifyData["verify_status"] == 2) {
                    ?>
                        <button class="def-btn def-btn-body text-black-50" disabled><i class="bi bi-check-circle text-black-50"></i>&nbsp;Verify</button>
                    <?Php
                    } else {
                    ?>
                        <button class="def-btn def-btn-success text-white" onclick="verifyNewOfficer('<?php echo ($officerVerifyData['email']); ?>');"><i class="bi bi-check-circle text-white"></i>&nbsp;Verify</button>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- Officer verify card -->
<?php
    }
}
?>