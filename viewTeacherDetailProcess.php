<?php
require "connection.php";

if (isset($_GET["email"])) {
    $email = $_GET["email"];

    $teacherResultset = Database::search("SELECT * FROM `teacher` WHERE `email`='" . $email . "'");
    $teacherData = $teacherResultset->fetch_assoc();
    $teacherProfileResultset = Database::search("SELECT * FROM `teacher_profile_image` WHERE `teacher_email`='" . $teacherData["email"] . "'");
    $teacherClassResultset = Database::search("SELECT DISTINCT `grade`.`name` FROM `teacher_has_subject` INNER JOIN `grade` ON
                                                            teacher_has_subject.grade_id=grade.id WHERE `teacher_has_subject`.`teacher_email`='" . $teacherData["email"] . "'");
    $teacherSubjectResultset = Database::search("SELECT DISTINCT `subject`.`name` FROM `teacher_has_subject` INNER JOIN `subject` ON
                                                            teacher_has_subject.subject_id=subject.id WHERE `teacher_has_subject`.`teacher_email`='" . $teacherData["email"] . "'");
?>
    <!-- Teacher detail area -->
    <div class="col-12 text-center pt-3 pb-2 border-bottom">
        <h2>Teacher Detail</h2>
    </div>
    <div class="col-12 pt-3 pb-3 d-flex flex-row justify-content-center align-items-center">
        <?php
        $teacherProfileRownumber = $teacherProfileResultset->num_rows;
        if ($teacherProfileRownumber == 1) {
            $teacherProfileData = $teacherProfileResultset->fetch_assoc();
        ?>
            <div class="col-md-4 d-flex flex-row justify-content-center align-items-center">
                <img src="<?php echo ($teacherProfileData["path"]); ?>" class="img-thumbnail border-1" style="border-radius: 100%;height:120px;width:120px;box-shadow: 0px 2px 3px 1px rgba(19, 70, 129, 0.5);" />
            </div>
        <?php
        } else {
        ?>
            <div class="col-md-4 d-flex flex-row justify-content-center align-items-center">
                <img src="resources/images/user.svg" class="img-fluid p-2" style="height:120px;border-radius: 24px;">
            </div>
        <?php
        }
        ?>
    </div>
    <div class="col-12 text-center">
        <span class="text-black text-capitalize fs-5" data-bs-toggle="tooltip" id="tooltip" data-bs-placement="right" title="Verifed" style="font-family: 'quicksand-bold';"><?php echo ($teacherData["first_name"] . " " . $teacherData["last_name"]);
                                                                                                                                                                                if ($teacherData["verify_status"] == 1) {
                                                                                                                                                                                ?>
                <i class="bi bi-patch-check-fill fs-6 fw-bold" data-bs-toggle="tooltip" id="tooltip" data-bs-placement="right" title="Verifed Teacher" style="color: #27da77;"></i>
            <?php
                                                                                                                                                                                } else if ($teacherData["verify_status"] == 2) {
            ?>
                <i class="bi bi-info-circle fs-6 fw-bold" data-bs-toggle="tooltip" id="tooltip" data-bs-placement="right" title="Unverifed Teacher" style="color: #100F0F;"></i>
            <?php
                                                                                                                                                                                }
            ?></span>
    </div>
    <div class="offset-2 col-4 d-grid pt-2 pb-1">
        <?php
        if ($teacherData["block_status"] == 1) {
        ?>
            <button class="def-btn def-btn-danger text-white" id="block-btn" onclick="blockTeacher('<?php echo ($teacherData['email']) ?>');"><i class="bi bi-exclamation-circle text-white"></i>&nbsp;&nbsp;Block</button>
        <?php
        } else if ($teacherData["block_status"] == 2) {
        ?>
            <button class="def-btn def-btn-success text-white" id="block-btn" onclick="blockTeacher('<?php echo ($teacherData['email']) ?>');"><i class="bi bi-check2-circle text-white"></i>&nbsp;&nbsp;Unblock</button>
        <?php
        }
        ?>
    </div>
    <div class="col-4 d-grid pt-2 pb-1">
        <button class="def-btn def-btn-primary text-white" onclick="loadClassAndSubject('<?php echo ($teacherData['email']) ?>');"><i class="bi bi-pencil-square text-white"></i>&nbsp;&nbsp;Edit</button>
    </div>
    <div class="col-12 p-4 pe-4 mt-3 text-center text-lg-start border-top">
        <span class="fs-5 pb-2" style="font-family: 'quicksand-bold';">Assign Classes</span><br />
        <div class="col-12 mt-2">
            <?php
            $teacherClassRownumber = $teacherClassResultset->num_rows;
            for ($y = 0; $y < $teacherClassRownumber; $y++) {
                $teacherClassData = $teacherClassResultset->fetch_assoc();
            ?>
                <span class="badge rounded-pill text-black" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#fbff00;"><?php echo ($teacherClassData["name"]); ?></span>
            <?php
            }
            ?>
        </div>
    </div>
    <div class="col-12 p-4 pe-4 text-center text-lg-start border-top border-bottom">
        <span class="fs-5 pb-2" style="font-family: 'quicksand-bold';">Assign Subjects</span><br />
        <div class="col-12 mt-2">
            <?php
            $teacherSubjectRownumber = $teacherSubjectResultset->num_rows;
            for ($y = 0; $y < $teacherSubjectRownumber; $y++) {
                $teacherSubjectData = $teacherSubjectResultset->fetch_assoc();
            ?>
                <span class="badge rounded-pill text-black" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#27da77;"><?php echo ($teacherSubjectData["name"]); ?></span>
            <?php
            }
            ?>
        </div>
    </div>
    <div class="col-12 ps-4 pe-4 mt-3 pb-3">
        <div class="row g-1">
            <div class="col-12 p-2">
                <div class="row">
                    <div class="col-5">
                        <span class="form-label" style="font-family: 'quicksand-bold';">First Name : </span>
                    </div>
                    <div class="col-7">
                        <span class="form-label text-primary"><?php echo ($teacherData["first_name"]); ?></span>
                    </div>
                </div>
            </div>
            <div class="col-12 p-2">
                <div class="row">
                    <div class="col-5">
                        <span class="form-label" style="font-family: 'quicksand-bold';">Last Name : </span>
                    </div>
                    <div class="col-7">
                        <span class="form-label text-primary"><?php echo ($teacherData["last_name"]); ?></span>
                    </div>
                </div>
            </div>
            <div class="col-12 p-2">
                <div class="row">
                    <div class="col-5">
                        <span class="form-label" style="font-family: 'quicksand-bold';">Mobile : </span>
                    </div>
                    <div class="col-7">
                        <span class="form-label text-primary"><?php echo ($teacherData["mobile"]); ?></span>
                    </div>
                </div>
            </div>
            <div class="col-12 p-2">
                <div class="row">
                    <div class="col-5">
                        <span class="form-label" style="font-family: 'quicksand-bold';">Email : </span>
                    </div>
                    <div class="col-7">
                        <span class="form-label text-primary"><?php echo ($teacherData["email"]); ?></span>
                    </div>
                </div>
            </div>
            <div class="col-12 p-2">
                <div class="row">
                    <div class="col-5">
                        <span class="form-label" style="font-family: 'quicksand-bold';">Registered Date : </span>
                    </div>
                    <div class="col-7">
                        <span class="form-label text-primary"><?php echo ($teacherData["joined_date"]); ?></span>
                    </div>
                </div>
            </div>
            <div class="col-12 p-2">
                <div class="row">
                    <div class="col-5">
                        <span class="form-label" style="font-family: 'quicksand-bold';">Address : </span>
                    </div>
                    <div class="col-7">
                        <?php
                        $addressResultset = Database::search("SELECT * FROM `teacher_has_address` INNER JOIN `city` ON
                        teacher_has_address.city_id=city.id INNER JOIN `district` ON
                        city.district_id=district.id INNER JOIN `province` ON
                        district.province_id=province.id WHERE `teacher_email`='" . $teacherData["email"] . "'");
                        $addressData = $addressResultset->fetch_assoc();

                        $cityResultset = Database::search("SELECT * FROM `city`");
                        $cityRownumber = $cityResultset->num_rows;
                        $districtResultset = Database::search("SELECT * FROM `district`");
                        $districtRownumber = $districtResultset->num_rows;
                        $provinceResultset = Database::search("SELECT * FROM `province`");
                        $provinceRownumber = $provinceResultset->num_rows;

                        $addressRownumber = $addressResultset->num_rows;

                        $addressCheck;

                        if ($addressRownumber > 0) {
                            $addressCheck = "true";
                        ?>
                            <span class="form-label text-primary"><?php echo ($addressData["line1"]); ?>,&nbsp;<?php echo ($addressData["line2"]); ?></span>
                        <?php
                        } else {
                            $addressCheck = "false";
                        ?>
                            <span class="form-label text-black">Not Found</span>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-12 p-2">
                <div class="row">
                    <div class="col-5">
                        <span class="form-label" style="font-family: 'quicksand-bold';">City : </span>
                    </div>
                    <div class="col-7">
                        <?php
                        if ($addressCheck == "true") {
                            for ($c = 0; $c < $cityRownumber; $c++) {
                                $cityData = $cityResultset->fetch_assoc();
                                if (!empty($addressData["city_id"])) {
                                    if ($cityData["id"] == $addressData["city_id"]) {
                        ?>
                                        <span class="form-label text-primary"><?php echo ($cityData["name"]); ?></span>
                            <?php
                                    }
                                }
                            }
                        } else if ($addressCheck == "false") {
                            ?>
                            <span class="form-label text-black">Not Found</span>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-12 p-2">
                <div class="row">
                    <div class="col-5">
                        <span class="form-label" style="font-family: 'quicksand-bold';">District : </span>
                    </div>
                    <div class="col-7">
                        <?php
                        if ($addressCheck == "true") {
                            for ($d = 0; $d < $districtRownumber; $d++) {
                                $districtData = $districtResultset->fetch_assoc();
                                if (!empty($addressData["district_id"])) {
                                    if ($districtData["id"] == $addressData["district_id"]) {
                        ?>
                                        <span class="form-label text-primary"><?php echo ($districtData["name"]); ?></span>
                            <?php
                                    }
                                }
                            }
                        } else if ($addressCheck == "false") {
                            ?>
                            <span class="form-label text-black">Not Found</span>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-12 p-2">
                <div class="row">
                    <div class="col-5">
                        <span class="form-label" style="font-family: 'quicksand-bold';">Province : </span>
                    </div>
                    <div class="col-7">
                        <?php
                        if ($addressCheck == "true") {
                            for ($p = 0; $p < $provinceRownumber; $p++) {
                                $provinceData = $provinceResultset->fetch_assoc();
                                if (!empty($addressData["province_id"])) {
                                    if ($provinceData["id"] == $addressData["province_id"]) {
                        ?>
                                        <span class="form-label text-primary"><?php echo ($provinceData["name"]); ?></span>
                            <?php
                                    }
                                }
                            }
                        } else if ($addressCheck == "false") {
                            ?>
                            <span class="form-label text-black">Not Found</span>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-12 p-2">
                <div class="row">
                    <div class="col-5">
                        <span class="form-label" style="font-family: 'quicksand-bold';">Postal Code : </span>
                    </div>
                    <div class="col-7">
                        <?php
                        if ($addressCheck == "true") {
                        ?>
                            <span class="form-label text-primary"><?php echo ($addressData["postal_code"]); ?></span>
                        <?php
                        } else if ($addressCheck == "false") {
                        ?>
                            <span class="form-label text-black">Not Found</span>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Teacher detail area -->
<?php
} else {
    echo ("Something Went Wrong");
}
?>