<?php
session_start();
require "connection.php";

if ($_SESSION["student"]["payment_status"] == 3 | $_SESSION["student"]["payment_status"] == 2 & isset($_SESSION["student"])) {
    $student = $_SESSION["student"];
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Student Profile - Online Student Management System</title>
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="style.css" />
        <link rel="icon" type="image/x-icon" href="resources/images/favicon.ico" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    </head>

    <?php
    if ($_SESSION["student"]["payment_status"] == 3) {
    ?>

        <body onload="studentGradeUpdateCheckerStart();">
        <?php
    } else {
        ?>

            <body onload="timeCounterCaller(); studentGradeUpdateCheckerStart();">
            <?php
        }
            ?>

            <div class="container-fluid">
                <div class="row">
                    <!-- side panel -->
                    <div class="col-12 col-lg-2" style="background-color: #e5fdff;">
                        <div class="row" style="height: 100vh;">
                            <div class="col-12" style="height:40%;background-image: linear-gradient(24deg, #3972eb, #59ccfa);background-repeat: no-repeat;">
                                <div class="row">
                                    <div class="col-12 text-center pt-2">
                                        <h2 class="text-white" style="font-family: 'barlow-bold';">OSMS</h2>
                                    </div>
                                    <div class="col-12 p-1">
                                        <?php
                                        $studentProfileResultset = Database::search("SELECT * FROM `student_profile_image` WHERE `student_email`='" . $student["email"] . "'");
                                        $studentProfileRownumber = $studentProfileResultset->num_rows;

                                        if ($studentProfileRownumber > 0) {
                                            $studentProfileData = $studentProfileResultset->fetch_assoc();
                                        ?>
                                            <div class="col-12 d-flex flex-row justify-content-center align-items-center p-1">
                                                <img src="<?php echo ($studentProfileData["path"]); ?>" class="img-thumbnail border-0" style="border-radius: 100%;height:120px;width:120px;box-shadow: 0px 2px 3px 1px rgba(19, 70, 129, 0.5);" />
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="col-12 d-flex flex-row justify-content-center align-items-center p-1">
                                                <img src="resources/images/user.svg" class="img-thumbnail border-0" style="border-radius: 100%;height:120px;width:120px;box-shadow: 0px 2px 3px 1px rgba(19, 70, 129, 0.5);" />
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                    $studentResultset = Database::search("SELECT * FROM `student` WHERE `email`='" . $student["email"] . "'");
                                    $studentData = $studentResultset->fetch_assoc();
                                    ?>
                                    <div class="col-12 text-center pb-2">
                                        <span class="text-white text-capitalize fs-5" data-bs-toggle="tooltip" id="tooltip" data-bs-placement="right" title="Verifed" style="font-family: 'quicksand-bold';"><?php echo ($studentData["first_name"] . " " . $studentData["last_name"]); ?><?php if ($studentData["verify_status"] == "1") {
                                                                                                                                                                                                                                                                                            ?>
                                            <i class="bi bi-check-circle-fill fs-6 fw-bold" style="color: #fff;"></i>
                                        <?php
                                                                                                                                                                                                                                                                                            } ?></span>
                                        <script>
                                            var exampleEl = document.getElementById("tooltip");
                                            var tooltip = new bootstrap.Tooltip(exampleEl);
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 p-2 pb-2" style="background-color: #e5fdff;height:80%;">
                                <div class="nav flex-column nav-pills mt-2" role="tablist" aria-orientation="vertical">
                                    <nav class="nav flex-column gap-2 p-2">
                                        <a class="fw-bold def-btn def-btn-primary text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="studentDashboard.php"><i class="bi bi-pencil-square fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;My Dashboard</a>
                                        <a class="fw-bold def-btn def-btn-primary-active text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="studentProfile.php"><i class="bi bi-person fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;My Profile</a>
                                        <a class="fw-bold def-btn def-btn-primary text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="#"><i class="bi bi-bell fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;Notifications</a>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- side panel -->
                    <!-- main content area -->
                    <div class="col-12 col-lg-10">
                        <div class="row">
                            <!-- upper header -->
                            <div class="col-12" style="border-bottom-style: solid;border-bottom-color: #e7e7e7;border-bottom-width: 1px;box-shadow: 0px 2px 6px 1px rgba(0,0,0,0.09);z-index: 2;">
                                <div class="row">
                                    <div class="col-6 col-lg-1 my-auto pt-4">
                                        <button class="border-0 bg-transparent position-relative"><i class="bi bi-bell-fill fs-4 fw-bold text-primary"></i>
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">99+</span>
                                        </button>
                                    </div>
                                    <div class="offset-0 offset-lg-7 col-6 col-lg-4 text-end my-auto">
                                        <div class="col-12">
                                            <?php
                                            if ($_SESSION["student"]["payment_status"] == 3) {
                                            ?>
                                                <span class="text-capitalize text-primary"></span>
                                            <?php
                                            } else {
                                            ?>
                                                <span class="text-capitalize text-primary">Your trial will be expired in</span>
                                            <?php
                                            }
                                            ?>
                                            <span class="text-capitalize text-danger" id="counter"></span>
                                        </div>
                                        <div class="col-12">
                                            <span class="text-capitalize">Hi, <?php echo ($_SESSION["student"]["first_name"]); ?></span>
                                            <span class="badge rounded-pill text-white" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#346be0;">Student</span>
                                            <button class="border-0 bg-transparent ms-2 text-primary" onclick="studentSignout();"><i class="bi bi-power text-primary"></i> Logout</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- upper header -->
                            <div class="col-12 my-auto p-3" style="background-color: #e5fdff;z-index: 1;">
                                <span class="text-black fs-1"><i class="fs-1 bi bi-person-circle"></i>&nbsp;&nbsp;My Profile</span>
                            </div>
                            <div class="col-12 my-auto pt-2">
                                <!-- Bread crumb -->
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="studentDashboard.php" class="text-decoration-none">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">My Profile</li>
                                    </ol>
                                </nav>
                                <!-- Bread crumb -->
                            </div>
                            <!-- Profile content -->
                            <?php

                            ?>
                            <div class="col-12 p-3 pt-3">
                                <div class="row g-1 pb-3">
                                    <div class="offset-1 col-10 def-card p-4">
                                        <div class="col-12 d-flex flex-row justify-content-center align-items-center pt-2">
                                            <?php
                                            if ($studentProfileRownumber > 0) {
                                            ?>
                                                <img src="<?php echo ($studentProfileData["path"]); ?>" class="img-thumbnail border-0 p-2" id="image" style="max-width:150px;height: 150px;border-radius:100%;box-shadow: 0px 2px 3px 1px rgba(19, 70, 129, 0.5);" />
                                            <?php
                                            } else {
                                            ?>
                                                <img src="resources/images/user.svg" class="img-thumbnail border-0 p-2" id="image" style="max-width:150px;height: 150px;border-radius:100%;box-shadow: 0px 2px 3px 1px rgba(19, 70, 129, 0.5);" />
                                            <?php
                                            }
                                            ?>
                                            <div class="col-12 position-absolute bg-white text-center d-flex flex-row justify-content-center align-items-center" style="width: 38px;height: 38px;border-radius: 100%;margin-top:135px;box-shadow: 0px 2px 3px 1px rgba(19, 70, 129, 0.5);">
                                                <input type="file" id="imageUploader" class="d-none" />
                                                <label style="border-radius: 100%;" class="btn" onclick="changeProfileImage();" for="imageUploader" data-bs-toggle="tooltip" id="tooltip" data-bs-placement="right" title="Recomended Image Size: 150px &times; 150px" style="color: #34aedf;"><i class="bi bi-pencil-square fs-5 fw-bold text-black"></i></label>
                                                <script>
                                                    var exampleEl = document.getElementById("tooltip");
                                                    var tooltip = new bootstrap.Tooltip(exampleEl);
                                                </script>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center p-1 mt-2">
                                            <span class="badge rounded-pill text-white fs-5 mt-3 mb-2" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-image: linear-gradient(24deg, #3972eb, #59ccfa);">Student</span>
                                            <h1 class="text-capitalize fs-2" style="font-family: 'quicksand-bold';"><?php echo ($studentData["first_name"] . " " . $studentData["last_name"]); ?><?php if ($studentData["verify_status"] == "1") {
                                                                                                                                                                                                    ?>
                                                <i class="bi bi-check-circle-fill fs-4 fw-bold" data-bs-toggle="tooltip" id="tooltip" data-bs-placement="right" title="Verifed" style="color: #34aedf;"></i>
                                            <?php
                                                                                                                                                                                                    } ?>
                                            </h1>
                                            <h4 class="text-primary fs-5"><?php echo ($studentData["email"]); ?></h4>
                                        </div>
                                        <div class="col-12 mt-4">
                                            <div class="row g-1">
                                                <div class="col-12 col-lg-6 p-3">
                                                    <div class="col-12">
                                                        <span class="form-label" style="font-family:'quicksand-bold';">First Name</span>
                                                    </div>
                                                    <div class="col-12 d-grid">
                                                        <input type="text" class="def-input text-capitalize bg-white" id="fname" value='<?php echo ($studentData["first_name"]); ?>' />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 p-3">
                                                    <div class="col-12">
                                                        <span class="form-label text-capitalize" style="font-family:'quicksand-bold';">Last Name</span>
                                                    </div>
                                                    <div class="col-12 d-grid">
                                                        <input type="text" class="def-input text-capitalize bg-white" id="lname" value='<?php echo ($studentData["last_name"]); ?>' />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 p-3">
                                                    <div class="col-12">
                                                        <span class="form-label" style="font-family:'quicksand-bold';">Mobile</span>
                                                    </div>
                                                    <div class="col-12 d-grid">
                                                        <input type="text" class="def-input bg-white" id="mobile" value='<?php echo ($studentData["mobile"]); ?>' />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 p-3">
                                                    <div class="col-12">
                                                        <span class="form-label" style="font-family:'quicksand-bold';">Username</span>
                                                    </div>
                                                    <div class="col-12 d-grid">
                                                        <input type="text" class="def-input bg-white" value='<?php echo ($studentData["username"]); ?>' disabled />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 p-3">
                                                    <div class="col-12">
                                                        <span class="form-label" style="font-family:'quicksand-bold';">Date Of Birth</span>
                                                    </div>
                                                    <div class="col-12 d-grid">
                                                        <input type="date" class="def-input bg-white" value='<?php echo ($studentData["date_of_birth"]); ?>' id="date-of-birth" />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 p-3">
                                                    <div class="col-12">
                                                        <span class="form-label" style="font-family:'quicksand-bold';">Registered Date</span>
                                                    </div>
                                                    <div class="col-12 d-grid">
                                                        <input type="text" class="def-input bg-white" value='<?php echo ($studentData["joined_date"]); ?>' disabled />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 p-3">
                                                    <div class="col-12">
                                                        <span class="form-label" style="font-family:'quicksand-bold';">Email</span>
                                                    </div>
                                                    <div class="col-12 d-grid">
                                                        <input type="text" class="def-input bg-white" value='<?php echo ($studentData["email"]); ?>' disabled />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 p-3">
                                                    <div class="col-12">
                                                        <span class="form-label" style="font-family:'quicksand-bold';">Nationality</span>
                                                    </div>
                                                    <div class="col-12 d-grid">
                                                        <input type="text" class="def-input bg-white" value='<?php echo ($studentData["nationality"]); ?>' disabled />
                                                    </div>
                                                </div>
                                                <?php
                                                $studentHasAddressResultset = Database::search("SELECT * FROM `student_has_address` WHERE `student_email`='" . $studentData["email"] . "'");
                                                $studentHasAddressRownumber = $studentHasAddressResultset->num_rows;
                                                $studentHasAddressData = $studentHasAddressResultset->fetch_assoc();
                                                ?>
                                                <div class="col-12 col-lg-6 p-3">
                                                    <div class="col-12">
                                                        <span class="form-label" style="font-family:'quicksand-bold';">Address Line 01</span>
                                                    </div>
                                                    <div class="col-12 d-grid">
                                                        <?php
                                                        if (!empty($studentHasAddressData["line1"])) {
                                                        ?>
                                                            <input type="text" class="def-input bg-white" value='<?php echo ($studentHasAddressData["line1"]); ?>' id="line1" />
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <input type="text" class="def-input bg-white" id="line1" />
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 p-3">
                                                    <div class="col-12">
                                                        <span class="form-label" style="font-family:'quicksand-bold';">Address Line 02</span>
                                                    </div>
                                                    <div class="col-12 d-grid">
                                                        <?php
                                                        if (!empty($studentHasAddressData["line2"])) {
                                                        ?>
                                                            <input type="text" class="def-input bg-white" value='<?php echo ($studentHasAddressData["line2"]); ?>' id="line2" />
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <input type="text" class="def-input bg-white" id="line2" />
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 p-3">
                                                    <div class="col-12">
                                                        <span class="form-label" style="font-family:'quicksand-bold';">City</span>
                                                    </div>
                                                    <div class="col-12 d-grid">
                                                        <select class="def-input bg-white" id="city">
                                                            <option value="0">Select City</option>
                                                            <?php
                                                            $cityResultset = Database::search("SELECT * FROM `city`");
                                                            $cityRownumber = $cityResultset->num_rows;

                                                            for ($c = 0; $c < $cityRownumber; $c++) {
                                                                $cityData = $cityResultset->fetch_assoc();
                                                            ?>
                                                                <option class="text-primary" <?php
                                                                                                if ($studentHasAddressRownumber > 0) {
                                                                                                    if ($cityData["id"] == $studentHasAddressData["city_id"]) {
                                                                                                ?>selected<?php
                                                                                                        }
                                                                                                    }
                                                                                                            ?> value="<?php echo ($cityData["id"]); ?>"><?php echo ($cityData["name"]); ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 p-3">
                                                    <div class="col-12">
                                                        <span class="form-label" style="font-family:'quicksand-bold';">District</span>
                                                    </div>
                                                    <div class="col-12 d-grid">
                                                        <select class="def-input bg-white" id="district">
                                                            <option value="0">Select District</option>
                                                            <?php
                                                            $districtResultset = Database::search("SELECT * FROM `district`");
                                                            $districtRownumber = $districtResultset->num_rows;

                                                            for ($d = 0; $d < $districtRownumber; $d++) {
                                                                $districtData = $districtResultset->fetch_assoc();
                                                            ?>
                                                                <option class="text-primary" <?php
                                                                                                if ($districtData["id"] == $cityData["district_id"]) {
                                                                                                ?>selected<?php
                                                                                                        }
                                                                                                            ?> value="<?php echo ($districtData["id"]); ?>"><?php echo ($districtData["name"]); ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 p-3">
                                                    <div class="col-12">
                                                        <span class="form-label" style="font-family:'quicksand-bold';">Province</span>
                                                    </div>
                                                    <div class="col-12 d-grid">
                                                        <select class="def-input bg-white" id="province">
                                                            <option value="0">Select Province</option>
                                                            <?php
                                                            $provinceResultset = Database::search("SELECT * FROM `province`");
                                                            $provinceRownumber = $provinceResultset->num_rows;

                                                            for ($p = 0; $p < $provinceRownumber; $p++) {
                                                                $provinceData = $provinceResultset->fetch_assoc();
                                                            ?>
                                                                <option class="text-primary" <?php
                                                                                                if ($provinceData["id"] == $districtData["province_id"]) {
                                                                                                ?>selected<?php
                                                                                                        }
                                                                                                            ?> value="<?php echo ($provinceData["id"]); ?>"><?php echo ($provinceData["name"]); ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 p-3">
                                                    <div class="col-12">
                                                        <span class="form-label" style="font-family:'quicksand-bold';">Postal Code</span>
                                                    </div>
                                                    <div class="col-12 d-grid">
                                                        <?php
                                                        if (!empty($studentHasAddressData["postal_code"])) {
                                                        ?>
                                                            <input type="text" class="def-input bg-white" id="postalcode" value='<?php echo ($studentHasAddressData["postal_code"]); ?>' />
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <input type="text" class="def-input bg-white" id="postalcode" />
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 p-3">
                                                    <?php
                                                    $parentResultset = Database::search("SELECT * FROM `parent` WHERE `email`='" . $studentData["parent_email"] . "'");
                                                    $parentData = $parentResultset->fetch_assoc();
                                                    ?>
                                                    <div class="col-12">
                                                        <span class="form-label" style="font-family:'quicksand-bold';">Parent First Name</span>
                                                    </div>
                                                    <div class="col-12 d-grid">
                                                        <?php
                                                        if (!empty($parentData["first_name"])) {
                                                        ?>
                                                            <input type="text" class="def-input bg-white" value='<?php echo ($parentData["first_name"]); ?>' id="parent-first-name" />
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <input type="text" class="def-input bg-white" id="parent-first-name" />
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 p-3">
                                                    <div class="col-12">
                                                        <span class="form-label" style="font-family:'quicksand-bold';">Parent Last Name</span>
                                                    </div>
                                                    <div class="col-12 d-grid">
                                                        <?php
                                                        if (!empty($parentData["last_name"])) {
                                                        ?>
                                                            <input type="text" class="def-input bg-white" value='<?php echo ($parentData["last_name"]); ?>' id="parent-last-name" />
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <input type="text" class="def-input bg-white" id="parent-last-name" />
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 p-3">
                                                    <div class="col-12">
                                                        <span class="form-label" style="font-family:'quicksand-bold';">Gender</span>
                                                    </div>
                                                    <div class="col-12 d-grid">
                                                        <select class="def-input bg-white" disabled>
                                                            <?php
                                                            $genderResultset = Database::search("SELECT * FROM `gender` WHERE `id`='" . $studentData["gender_id"] . "'");
                                                            $genderData = $genderResultset->fetch_assoc();
                                                            ?>
                                                            <option class="text-primary"><?php echo ($genderData["name"]); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 p-3">
                                                    <div class="col-12">
                                                        <span class="form-label" style="font-family:'quicksand-bold';">Medium</span>
                                                    </div>
                                                    <div class="col-12 d-grid">
                                                        <select class="def-input bg-white" disabled>
                                                            <?php
                                                            $mediumResultset = Database::search("SELECT * FROM `medium` WHERE `id`='" . $studentData["medium_id"] . "'");
                                                            $mediumData = $mediumResultset->fetch_assoc();
                                                            ?>
                                                            <option class="text-primary"><?php echo ($mediumData["name"]); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-4 d-grid offset-3 offset-lg-4 mt-3 pb-3">
                                                    <button class="def-btn def-btn-primary text-white" onclick="updateStudentProfile();">Update Profile</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Profile content -->
                        </div>
                    </div>
                    <!-- Main Content area -->
                    <!-- toast message -->
                    <div class="col-12 d-none d-md-block d-lg-block">
                        <div class="toast-container bg-transparent position-fixed bottom-0 end-0 p-3">
                            <div id="liveToast" class="toast def-card border-0" style="background-color: #cdf1ff;" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header bg-transparent def-card ps-3 pe-3">
                                    <div class="col-2 justify-content-start">
                                        <i class="bi bi-x-circle-fill fs-4 text-warning justify-content-start" id="toast-icon"></i>
                                    </div>
                                    <div class="col-8 text-start ps-2 text-capitalize text-primary" style="font-family: 'quicksand-bold';" id="toast-body"></div>
                                    <div class="col-2 d-flex flex-row justify-content-end">
                                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- toast message -->
                </div>
            </div>
            <script src="bootstrap.bundle.js"></script>
            <script src="script.js"></script>
            </body>

    </html>
<?php
} else {
    header("Location:studentDashboard.php");
}
?>