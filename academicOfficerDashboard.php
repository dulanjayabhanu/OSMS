<?php
session_start();
require "connection.php";

if (isset($_SESSION["officer"])) {
    $officer = $_SESSION["officer"];
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Academic Officer Dashboard - Online Student Management System</title>
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="style.css" />
        <link rel="icon" type="image/x-icon" href="resources/images/favicon.ico" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    </head>

    <body>

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
                                    $officerProfileResultset = Database::search("SELECT * FROM `teacher_profile_image` WHERE `teacher_email`='" . $officer["email"] . "'");
                                    $officerProfileRownumber = $officerProfileResultset->num_rows;

                                    if ($officerProfileRownumber > 0) {
                                        $officerProfileData = $officerProfileResultset->fetch_assoc();
                                    ?>
                                        <div class="col-12 d-flex flex-row justify-content-center align-items-center p-1">
                                            <img src="<?php echo ($officerProfileData["path"]); ?>" class="img-thumbnail border-0" style="border-radius: 100%;height:120px;width:120px;box-shadow: 0px 2px 3px 1px rgba(19, 70, 129, 0.5);" />
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
                                <div class="col-12 text-center pb-2">
                                    <span class="text-white text-capitalize fs-5" data-bs-toggle="tooltip" id="tooltip" data-bs-placement="right" title="Verifed" style="font-family: 'quicksand-bold';"><?php echo ($officer["first_name"] . " " . $officer["last_name"]); ?><?php if ($officer["verify_status"] == "1") {
                                                                                                                                                                                                                                                                                ?>
                                        &nbsp;<i class="bi bi-patch-check-fill fs-6 fw-bold" style="color: #fff;"></i>
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
                                    <a class="fw-bold def-btn def-btn-primary-active text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="academicOfficerDashboard.php"><i class="bi bi-pencil-square fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;My Dashboard</a>
                                    <a class="fw-bold def-btn def-btn-primary text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="academicOfficerProfile.php"><i class="bi bi-person fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;My Profile</a>
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
                                    <span class="text-capitalize">Hi, <?php echo ($_SESSION["officer"]["first_name"]); ?></span>
                                    <span class="badge rounded-pill text-black" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#fbff00;">Academic Officer</span>
                                    <button class="border-0 bg-transparent ms-2 text-primary" onclick="officerSignout();"><i class="bi bi-power text-primary"></i> Logout</button>
                                </div>
                            </div>
                        </div>
                        <!-- upper header -->
                        <div class="col-12 my-auto p-3" style="background-color: #e5fdff;z-index: 1;">
                            <span class="text-black fs-1"><i class="fs-1 bi bi-speedometer2"></i>&nbsp;&nbsp;Dashboard</span>
                        </div>
                        <div class="col-12 my-auto pt-2">
                            <!-- Bread crumb -->
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="academicOfficerDashboard.php" class="text-decoration-none">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">My Dashboard</li>
                                </ol>
                            </nav>
                            <!-- Bread crumb -->
                        </div>
                        <!-- summary -->
                        <div class="col-12 p-3 pt-3">
                            <div class="row g-1">
                                <!-- summary card -->
                                <div class="col-12 p-3">
                                    <div class="card def-card border-0">
                                        <div class="row g-0">
                                            <div class="col-12 col-lg-2">
                                                <div class="col-12 d-flex flex-row justify-content-center align-items-center" style="height: 150px;">
                                                    <img src="resources/images/reading-student-svgrepo-com.svg" class="img-fluid" style="height: 120px;border-radius: 24px 24px 24px 24px;filter: invert(0.4);" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <?php
                                                $allStudentResultset = Database::search("SELECT * FROM `student`");
                                                $allStudentRownumber = $allStudentResultset->num_rows;
                                                ?>
                                                <div class="card-body text-center text-lg-start">
                                                    <h1 class="card-title text-black">Student</h1>
                                                    <p class="card-text fs-2 text-primary" style="font-family: 'quicksand-bold';" id="all-student"><?php
                                                                                                                                                    if ($allStudentRownumber < 10) {
                                                                                                                                                        echo ("0" . $allStudentRownumber);
                                                                                                                                                    } else {
                                                                                                                                                        echo ($allStudentRownumber);
                                                                                                                                                    } ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="offset-0 offset-lg-2 col-12 col-lg-5 p-3">
                                                <div class="row">
                                                    <div class="col-6 d-grid my-0 my-lg-5">
                                                        <button class="def-btn def-btn-primary text-white" onclick="showModal2();"><i class="bi bi-person-add text-white fs-4"></i>&nbsp;&nbsp;Register Student</button>
                                                    </div>
                                                    <div class="col-6 d-grid my-0 my-lg-5">
                                                        <button class="def-btn def-btn-success text-white" onclick="showModal3();"><i class="bi bi-person-fill-check text-white fs-4"></i>&nbsp;&nbsp;Verification Pool</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- summary card -->
                            </div>
                        </div>
                        <!-- summary -->
                        <div class="col-12 p-4 p-lg-4 pt-3">
                            <div class="row g-1">
                                <!-- Marks area -->
                                <div class="col-12 col-lg-7 p-3">
                                    <div class="def-card p-2">
                                        <div class="row">
                                            <div class="col-12 text-center pt-2 pb-2 border-bottom">
                                                <h2>Exam Marks Queue</h2>
                                            </div>
                                            <div class="col-12 p-2">
                                                <div class="row pt-5 ps-5 pe-5 pb-4" id="student-card-loader">
                                                    <?php
                                                    if (isset($_GET["page"])) {
                                                        $pageNo = $_GET["page"];
                                                    } else {
                                                        $pageNo = 1;
                                                    }

                                                    $assignmentIdResultset = Database::search("SELECT * FROM `answer_sheet` WHERE `status`='1'");
                                                    $assignmentIdData = $assignmentIdResultset->fetch_assoc();
                                                    $query = "SELECT * FROM `answer_sheet` WHERE `status`='1'";

                                                    $selectedResultset = Database::search($query);
                                                    $selectedRownumber = $selectedResultset->num_rows;

                                                    if ($selectedRownumber == 0) {
                                                    ?>
                                                        <!-- Marks empty card -->
                                                        <div class="col-12">
                                                            <div class="col-6 col-lg-12 pt-5 pb-5 def-card bg-white text-center">
                                                                <span>No Results</span>
                                                            </div>
                                                        </div>
                                                        <!-- Marks empty card -->
                                                        <?php
                                                    } else {
                                                        $resultsPerPage = 10;
                                                        $numberOfPage = ceil($selectedRownumber / $resultsPerPage);

                                                        $pageResults = ($pageNo - 1) * $resultsPerPage;
                                                        $selectedResultset = Database::search($query . " LIMIT " . $resultsPerPage . " OFFSET " . $pageResults);
                                                        $selectedRownumber = $selectedResultset->num_rows;

                                                        for ($x = 0; $x < $selectedRownumber; $x++) {
                                                            $selectedData = $selectedResultset->fetch_assoc();

                                                            $assignmentResultset = Database::search("SELECT * FROM `assignment` INNER JOIN `classroom` ON
                                                            assignment.classroom_id=classroom.id INNER JOIN `teacher` ON
                                                            classroom.teacher_email=teacher.email WHERE `assignment`.`id`='" . $selectedData["assignment_id"] . "'");
                                                            $assignmentData = $assignmentResultset->fetch_assoc();

                                                            $assignmentSrc = $assignmentData["name"];
                                                            $srcSplit = explode("/", $assignmentSrc);
                                                            $fileName = $srcSplit[2];
                                                            $newFileName = explode(".", $fileName);
                                                        ?>
                                                            <!-- Teacher card -->
                                                            <div class="col-lg-12 p-2">
                                                                <div class="col-12 p-1 def-card bg-white card-animate">
                                                                    <div class="row g-0">
                                                                        <div class="col-2 col-lg-2 d-flex flex-row justify-content-center align-items-center">
                                                                            <span><i class="bi bi-clipboard2-check-fill fs-1 text-primary"></i></span>
                                                                        </div>
                                                                        <div class="col-10 col-md-8 col-lg-8">
                                                                            <div class="card-body p-1">
                                                                                <h5 class="text-capitalize" style="font-family: 'quicksand-bold';color: #353535;"><?php echo ($newFileName[0]); ?></h5>
                                                                                <h6>Teacher : <span class="text-primary"><?php echo ($assignmentData["first_name"] . " " . $assignmentData["last_name"]); ?></span><br><span class="text-end" style="font-size:10px;color:#ff3f3f">Deadline : <?php echo (explode(" ", $assignmentData["deadline"])[0]); ?></span></h6>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 col-lg-1">
                                                                            <div class="row p-3 my-1">
                                                                                <div class="col-6 d-grid">
                                                                                    <button class="def-btn def-btn-danger" data-bs-toggle="tooltip" id="tooltip" data-bs-placement="right" title="Release Marks" onclick="releaseMarks('<?php echo ($selectedData['assignment_id']); ?>');"><i class="bi bi-megaphone-fill text-white fs-5"></i></button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Teacher card -->
                                                        <?php
                                                        }
                                                        ?>
                                                        <!-- Pagination -->
                                                        <div class="col-12 mt-2 p-2 mt-3 d-flex flex-row justify-content-center align-items-center">
                                                            <nav>
                                                                <ul class="pagination pagination-sm justify-content-center justify-content-lg-start ">
                                                                    <?php
                                                                    for ($z = 1; $z <= $numberOfPage; $z++) {
                                                                        if ($z == $pageNo) {
                                                                    ?>
                                                                            <li class="page-item active">
                                                                                <a href="<?php echo ("?page=" . $z); ?>" class="page-link" style="background-image: linear-gradient(24deg, #3972eb, #59ccfa);border: none;"><?php echo ($z); ?></a>
                                                                            </li>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <li class="page-item">
                                                                                <a href="<?php echo ("?page=" . $z); ?>" class="page-link text-black fw-bold"><?php echo ($z); ?></a>
                                                                            </li>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </ul>
                                                            </nav>
                                                        </div>
                                                        <!-- Pagination -->
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Marks area -->
                                <!-- Student detail area -->
                                <div class="col-12 col-lg-5 p-3">
                                    <div class="row ps-2 pe-2 pb-2">
                                        <div class="col-12 def-card">
                                            <div class="row" id="student-detail-loader">
                                                <?php
                                                $verifyStudents = 0;
                                                $unVerifyStudents = 0;

                                                for ($x = 0; $x < $allStudentRownumber; $x++) {
                                                    $studentData = $allStudentResultset->fetch_assoc();

                                                    if ($studentData["verify_status"] == 1) {
                                                        $verifyStudents += 1;
                                                    } else if ($studentData["verify_status"] == 2) {
                                                        $unVerifyStudents += 1;
                                                    }
                                                }

                                                ?>
                                                <div class="col-12 text-center pt-3 pb-2 border-bottom">
                                                    <h2>Student Summary</h2>
                                                </div>
                                                <div class="col-12 p-4 pe-4 mt-3 text-center text-lg-start">
                                                    <span class="fs-5 pb-2" style="font-family: 'quicksand-bold';">Verifed Students</span><br />
                                                    <div class="col-12 mt-2">
                                                        <span class="badge rounded-pill text-black fs-5" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#fbff00;">&nbsp;&nbsp;<?php if ($verifyStudents < 10) {
                                                                                                                                                                                                                                        echo ("0" . $verifyStudents);
                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                        echo ($verifyStudents);
                                                                                                                                                                                                                                    } ?>&nbsp;&nbsp;</span>
                                                    </div>
                                                </div>
                                                <div class="col-12 p-4 pe-4 text-center text-lg-start border-top">
                                                    <span class="fs-5 pb-2" style="font-family: 'quicksand-bold';">Unverifed Students</span><br />
                                                    <div class="col-12 mt-2">
                                                        <span class="badge rounded-pill text-white fs-5" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#27da77;">&nbsp;&nbsp;<?php if ($verifyStudents < 10) {
                                                                                                                                                                                                                                        echo ("0" . $unVerifyStudents);
                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                        echo ($unVerifyStudents);
                                                                                                                                                                                                                                    } ?>&nbsp;&nbsp;</span>
                                                    </div>
                                                </div>
                                                <?php

                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Student detail area -->
                                <!-- Student empty area -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- main content area -->
                <!-- Student invite modal -->
                <div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal2">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content def-card border-0" id="invite-modal-loader">
                            <div class="text-center pt-1 pb-2">
                                <h5 class="modal-title mt-2 fs-3">Invite Student</h5>
                            </div>
                            <div class="modal-body mt-2 pb-2">
                                <div class="row g-1 ps-2 pe-2 pb-3">
                                    <?php

                                    ?>
                                    <div class="col-12 col-lg-6 mt-1 pe-2 ps-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="form-label" style="font-family: 'quicksand-bold';">First Name</span>
                                            </div>
                                            <div class="col-12 d-grid">
                                                <input type="text" class="def-input bg-white" id="inv-first-name" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 mt-1 pe-2 ps-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="form-label" style="font-family: 'quicksand-bold';">Last Name</span>
                                            </div>
                                            <div class="col-12 d-grid pe-1">
                                                <input type="text" class="def-input bg-white" id="inv-last-name" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 mt-3 pe-2 ps-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="form-label" style="font-family: 'quicksand-bold';">Date Of Birth</span>
                                            </div>
                                            <div class="col-12 d-grid pe-1">
                                                <input type="date" class="def-input bg-white" id="inv-date-of-birth" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 mt-3 pe-2 ps-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="form-label" style="font-family: 'quicksand-bold';">Nationality</span>
                                            </div>
                                            <div class="col-12 d-grid">
                                                <input type="text" class="def-input bg-white" id="inv-nationality" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 mt-3 pe-2 ps-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="form-label" style="font-family: 'quicksand-bold';">Mobile</span>
                                            </div>
                                            <div class="col-12 d-grid">
                                                <input type="text" class="def-input bg-white" id="inv-mobile" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 mt-3 pe-2 ps-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="form-label" style="font-family: 'quicksand-bold';">Gender</span>
                                            </div>
                                            <div class="col-12 d-grid">
                                                <select class="def-input bg-white" id="inv-gender">
                                                    <option value="0">Select Gender</option>
                                                    <?php
                                                    $genderResultset = Database::search("SELECT * FROM `gender`");
                                                    $genderRownumber = $genderResultset->num_rows;

                                                    for ($g = 0; $g < $genderRownumber; $g++) {
                                                        $genderData = $genderResultset->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo ($genderData["id"]); ?>"><?php echo ($genderData["name"]); ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-3 pe-2 ps-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="form-label" style="font-family: 'quicksand-bold';">Email</span>
                                            </div>
                                            <div class="col-12 d-grid">
                                                <input type="Email" class="def-input bg-white" id="inv-email" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-3 pe-2 ps-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="form-label" style="font-family: 'quicksand-bold';">Parent/Guardian Email</span>
                                            </div>
                                            <div class="col-12 d-grid">
                                                <input type="Email" class="def-input bg-white" id="inv-parent-email" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 mt-3 pe-2 ps-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="form-label" style="font-family: 'quicksand-bold';">Included class</span>
                                            </div>
                                            <div class="col-12 d-grid">
                                                <select class="def-input bg-white" id="inv-class">
                                                    <option value="0">Select Class</option>
                                                    <?php
                                                    $classResultset = Database::search("SELECT * FROM `grade`");
                                                    $classRownumber = $classResultset->num_rows;

                                                    for ($c = 0; $c < $classRownumber; $c++) {
                                                        $classData = $classResultset->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo ($classData["id"]); ?>"><?php echo ($classData["name"]); ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 mt-3 pe-2 ps-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="form-label" style="font-family: 'quicksand-bold';">Medium</span>
                                            </div>
                                            <div class="col-12 d-grid">
                                                <select class="def-input bg-white" id="inv-medium">
                                                    <option value="0">Select Medium</option>
                                                    <?php
                                                    $mediumResultset = Database::search("SELECT * FROM `medium`");
                                                    $mediumRownumber = $mediumResultset->num_rows;

                                                    for ($m = 0; $m < $mediumRownumber; $m++) {
                                                        $mediumData = $mediumResultset->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo ($mediumData["id"]); ?>"><?php echo ($mediumData["name"]); ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 pt-1">
                                        <span style="font-size: 13px;color: #f81919" id="error-text-loader"></span>
                                    </div>
                                    <div class="col-12 pt-2">
                                        <span style="font-size: 13px;"><i class="bi bi-info-circle"></i>&nbsp;&nbsp;After sending the invitation, the student's <i style="font-size: 13px;" class="text-primary">username</i>, <i style="font-size: 13px;" class="text-primary">password</i> and<br /><i class="text-primary" style="font-size: 13px;">one-time code</i> will be <span class="text-primary">automatically generated</span> and sent to the respective student.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="def-btn def-btn-body text-black" type="button" data-bs-dismiss="modal">Cancle</button>
                                <button class="def-btn def-btn-primary text-white" type="button" onclick="sendStudentInvitation();">Send Invitation</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Student invite modal -->
                <!-- Student verification pool -->
                <div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal3">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content def-card border-0" id="verify-loader">
                            <div class="text-center pt-1 pb-2">
                                <h5 class="modal-title mt-2 fs-3">Student Verification Pool</h5>
                            </div>
                            <div class="modal-body mt-2 pb-2">
                                <div class="row g-1 ps-3 pe-3 pb-3" id="new_verify_student_loader">
                                    <div class="def-card p-2 bg-white mb-1">
                                        <div class="row">
                                            <div class="col-2 my-auto ps-3">
                                                <span style="font-family: 'quicksand-bold';">Profile</span><br />
                                            </div>
                                            <div class="col-4 my-auto">
                                                <span style="font-family: 'quicksand-bold';">Student Detail</span><br />
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
                                    $studentVerifyResultset = Database::search("SELECT * FROM `student` INNER JOIN `student_unique_code` ON
                                    student.email=student_unique_code.student_email WHERE `verify_status`='2'");
                                    $studentVerifyRownumber = $studentVerifyResultset->num_rows;

                                    if ($studentVerifyRownumber == 0) {
                                    ?>
                                        <!-- Student verify empty card -->
                                        <div class="def-card ps-3 pe-3 pt-5 pb-5 bg-white mb-2 text-center">
                                            <span>No Results</span>
                                        </div>
                                        <!-- Student verify empty card -->
                                        <?php
                                    } else {
                                        for ($v = 0; $v < $studentVerifyRownumber; $v++) {
                                            $studentVerifyData = $studentVerifyResultset->fetch_assoc();
                                        ?>
                                            <!-- Student verify card -->
                                            <div class="def-card p-3 bg-white mb-2">
                                                <div class="row">
                                                    <div class="col-2 bg-white d-flex flex-row justify-content-center align-items-center">
                                                        <?php
                                                        $studentVerifyProfileResultset = Database::search("SELECT * FROM `student_profile_image` WHERE `student_email`='" . $studentVerifyData["email"] . "'");
                                                        $studentVerifyProfileRownumber = $studentVerifyProfileResultset->num_rows;
                                                        if ($studentVerifyProfileRownumber > 0) {
                                                            $studentVerifyProfileData = $studentVerifyProfileResultset->fetch_assoc();
                                                        ?>
                                                            <img src="<?php echo ($studentVerifyProfileData["path"]); ?>" class="img-thumbnail border-0 p-1" style="border-radius: 100%;height:55px;width:60px;box-shadow: 0px 2px 3px 1px rgba(19, 70, 129, 0.5);background-size: contain;" />
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
                                                        <span style="font-family: 'quicksand-bold';"><?php echo ($studentVerifyData["first_name"] . " " . $studentVerifyData["last_name"]); ?></span><br />
                                                        <span class="text-primary" style="font-size: 11px;"><?php echo ($studentVerifyData["email"]); ?></span>
                                                    </div>
                                                    <div class="col-3 my-auto">
                                                        <?php
                                                        if ($studentVerifyData["status"] == 1) {
                                                        ?>
                                                            <span class="badge rounded-pill text-black fs-6 fw-light" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#fbff00;"><i class="bi bi-check"></i>&nbsp;Pending</span>
                                                        <?php
                                                        } else if ($studentVerifyData["status"] == 2) {
                                                        ?>
                                                            <span class="badge rounded-pill text-white fs-6 fw-light" style="font-family:'quicksand-regular';padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#2c99c4;"><i class="bi bi-check-all text-white"></i>&nbsp;Accepted</span>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="col-3 d-grid">
                                                        <?php
                                                        if ($studentVerifyData["status"] == 1 && $studentVerifyData["verify_status"] == 2) {
                                                        ?>
                                                            <button class="def-btn def-btn-body text-black-50" disabled><i class="bi bi-check-circle text-black-50"></i>&nbsp;Verify</button>
                                                        <?Php
                                                        } else {
                                                        ?>
                                                            <button class="def-btn def-btn-success text-white" onclick="verifyNewStudent('<?php echo ($studentVerifyData['email']); ?>');"><i class="bi bi-check-circle text-white"></i>&nbsp;Verify</button>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Student verify card -->
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="def-btn def-btn-primary text-white" type="button" data-bs-dismiss="modal">Done</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- student verification pool -->
                <!-- Toast message -->
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
                <!-- Toast message -->
            </div>
        </div>

        <script src="bootstrap.bundle.js"></script>
        <script src="script.js"></script>
    </body>

    </html>
<?php
} else {
    header("Location:academicOfficerSignIn.php");
}
?>