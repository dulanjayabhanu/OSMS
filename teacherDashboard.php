<?php
session_start();
require "connection.php";

if (isset($_SESSION["teacher"])) {
    $teacher = $_SESSION["teacher"];
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Teacher Dashboard - Online Student Management System</title>
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
                                    <div class="col-12 d-flex flex-row justify-content-center align-items-center p-1">
                                    <?php
                                    $teacherProfileResultset = Database::search("SELECT * FROM `teacher_profile_image` WHERE `teacher_email`='" . $teacher["email"] . "'");
                                    $teacherProfileRownumber = $teacherProfileResultset->num_rows;

                                    if ($teacherProfileRownumber > 0) {
                                        $teacherProfileData = $teacherProfileResultset->fetch_assoc();
                                    ?>
                                        <div class="col-12 d-flex flex-row justify-content-center align-items-center p-1">
                                            <img src="<?php echo ($teacherProfileData["path"]); ?>" class="img-thumbnail border-0" style="border-radius: 100%;height:120px;width:120px;box-shadow: 0px 2px 3px 1px rgba(19, 70, 129, 0.5);" />
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
                                </div>
                                <div class="col-12 text-center pb-2">
                                    <span class="text-white text-capitalize fs-5" data-bs-toggle="tooltip" id="tooltip" data-bs-placement="right" title="Verifed" style="font-family: 'quicksand-bold';"><?php echo ($teacher["first_name"] . " " . $teacher["last_name"]); ?><?php if ($teacher["verify_status"] == "1") {
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
                                    <a class="fw-bold def-btn def-btn-primary-active text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="teacherDashboard.php"><i class="bi bi-pencil-square fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;My Dashboard</a>
                                    <a class="fw-bold def-btn def-btn-primary text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="teacherProfile.php"><i class="bi bi-person fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;My Profile</a>
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
                                    <span class="text-capitalize">Hi, <?php echo ($_SESSION["teacher"]["first_name"]); ?></span>
                                    <span class="badge rounded-pill text-white" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#ff3f3f;">Teacher</span>
                                    <button class="border-0 bg-transparent ms-2 text-primary" onclick="teacherSignout();"><i class="bi bi-power text-primary"></i> Logout</button>
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
                                    <li class="breadcrumb-item"><a href="teacherDashboard.php" class="text-decoration-none">Home</a></li>
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
                                                    <img src="resources/images/teacher-at-the-blackboard-svgrepo-com.svg" class="img-fluid" style="height: 120px;border-radius: 24px 24px 24px 24px;filter: invert(0.4);" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <?php
                                                $allClassRoomResultset = Database::search("SELECT * FROM `classroom` WHERE `teacher_email`='" . $teacher["email"] . "'");
                                                $allClassRoomRownumber = $allClassRoomResultset->num_rows;
                                                $classCounter = 0;

                                                for ($a = 0; $a < $allClassRoomRownumber; $a++) {
                                                    $allClassRoomData = $allClassRoomResultset->fetch_assoc();

                                                    $allClassResultset = Database::search("SELECT * FROM `grade` WHERE `id`='" . $allClassRoomData["grade_id"] . "'");
                                                    $allClassData = $allClassResultset->fetch_assoc();

                                                    if ($allClassRoomData["grade_id"] == $allClassData["id"]) {
                                                        $classCounter += 1;
                                                    }
                                                }
                                                ?>
                                                <div class="card-body text-center text-lg-start">
                                                    <h1 class="card-title text-black">Classes</h1>
                                                    <p class="card-text fs-2 text-primary" style="font-family: 'quicksand-bold';" id="all-student"><?php
                                                                                                                                                    if ($classCounter < 10) {
                                                                                                                                                        echo ("0" . $classCounter);
                                                                                                                                                    } else {
                                                                                                                                                        echo ($classCounter);
                                                                                                                                                    } ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="offset-0 offset-lg-1 col-12 col-lg-6 p-3">
                                                <div class="row">
                                                    <div class="col-6 d-grid my-0 my-lg-5">
                                                        <button class="def-btn def-btn-primary text-white" onclick="showModal2();"><i class="bi bi-file-earmark-richtext text-white fs-4"></i>&nbsp;&nbsp;Add New Lesson Note</button>
                                                    </div>
                                                    <div class="col-6 d-grid my-0 my-lg-5">
                                                        <button class="def-btn def-btn-warning" onclick="showModal3();"><i class="bi bi-file-earmark-text text-black fs-4"></i>&nbsp;&nbsp;Add New Assignment</button>
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
                                <!-- Teacher search area -->
                                <div class="col-12 p-3">
                                    <div class="def-card p-2">
                                        <div class="row">
                                            <div class="col-12 text-center pt-2 pb-2 border-bottom">
                                                <h2>Assignment Queue</h2>
                                            </div>
                                            <div class="col-12 p-2">
                                                <div class="row pt-5 ps-5 pe-5 pb-4" id="student-card-loader">
                                                    <?php
                                                    if (isset($_GET["page"])) {
                                                        $pageNo = $_GET["page"];
                                                    } else {
                                                        $pageNo = 1;
                                                    }

                                                    $teacherHasSubjectResultset1 = Database::search("SELECT * FROM `teacher_has_subject` WHERE `teacher_email`='" . $teacher["email"] . "'");
                                                    $teacherHasSubjectData1 = $teacherHasSubjectResultset1->fetch_assoc();
                                                    $query = "SELECT * FROM `assignment` WHERE `type`='1'";

                                                    $selectedResultset = Database::search($query);
                                                    $selectedRownumber = $selectedResultset->num_rows;

                                                    if ($selectedRownumber < 1) {
                                                    ?>
                                                        <!-- Teacher empty card -->
                                                        <div class="col-12">
                                                            <div class="col-6 col-lg-12 pt-5 pb-5 def-card bg-white text-center">
                                                                <span>No Results</span>
                                                            </div>
                                                        </div>
                                                        <!-- Teacher empty card -->
                                                        <?php
                                                    } else {
                                                        $resultsPerPage = 10;
                                                        $numberOfPage = ceil($selectedRownumber / $resultsPerPage);

                                                        $pageResults = ($pageNo - 1) * $resultsPerPage;
                                                        $selectedResultset = Database::search($query . " LIMIT " . $resultsPerPage . " OFFSET " . $pageResults);
                                                        $selectedRownumber = $selectedResultset->num_rows;

                                                        for ($x = 0; $x < $selectedRownumber; $x++) {
                                                            $selectedData = $selectedResultset->fetch_assoc();
                                                            $assignmentSrc = $selectedData["name"];
                                                            $srcSplit = explode("/", $assignmentSrc);
                                                            $fileName = $srcSplit[2];
                                                            $newFileName = explode(".", $fileName);
                                                        ?>
                                                            <!-- Teacher card -->
                                                            <div class="col-lg-12 p-2">
                                                                <div class="col-12 p-1 def-card bg-white card-animate">
                                                                    <div class="row g-0">
                                                                        <div class="col-2 col-lg-1 d-flex flex-row justify-content-center align-items-center">
                                                                            <span><i class="bi bi-clipboard2-check-fill fs-1 text-primary"></i></span>
                                                                        </div>
                                                                        <div class="col-10 col-md-8 col-lg-7">
                                                                            <div class="card-body p-1">
                                                                                <h5 class="text-capitalize" style="font-family: 'quicksand-bold';color: #353535;"><?php echo ($newFileName[0]); ?></h5>
                                                                                <h6>Teacher : <span class="text-primary"><?php echo ($teacher["first_name"] . " " . $teacher["last_name"]); ?></span><br><span class="text-end" style="font-size:10px;color:#ff3f3f">Deadline : <?php echo (explode(" ", $selectedData["deadline"])[0]); ?></span></h6>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 col-lg-4">
                                                                            <div class="row p-3 my-1">
                                                                                <div class="col-6 d-grid">
                                                                                    <button class="def-btn def-btn-success" data-bs-toggle="tooltip" id="tooltip" data-bs-placement="right" title="View Answers/ Check Marks" onclick="loadCheckMarks(<?php echo ($selectedData['id']); ?>);"><i class="bi bi-check-lg text-white fs-5"></i><span class="text-white" style="font-family: 'quicksand-bold';"> Answers</span></button>
                                                                                </div>
                                                                                <div class="col-6 d-grid">
                                                                                    <button class="def-btn def-btn-danger" data-bs-toggle="tooltip" id="tooltip" data-bs-placement="right" title="Submit Marks To The Academic Officer" onclick="sendMarks('<?php echo ($selectedData['id']); ?>');"><i class="bi bi-send-fill text-white fs-5"></i></button>
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
                                <!-- Teachers search area -->
                                <!-- Teacher empty area -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- main content area -->
                <!-- Add new lesson modal -->
                <div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal2">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content def-card border-0" id="invite-modal-loader">
                            <div class="text-center pt-1 pb-2">
                                <h5 class="modal-title mt-2 fs-3">Add New Lesson Note</h5>
                            </div>
                            <div class="modal-body mt-2 pb-2">
                                <div class="row g-1 ps-2 pe-2 pb-3">
                                    <?php

                                    ?>
                                    <div class="col-12 col-lg-6 mt-3 pe-2 ps-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="form-label" style="font-family: 'quicksand-bold';">Class</span>
                                            </div>
                                            <div class="col-12 d-grid pe-1">
                                                <select type="text" class="def-input bg-white" id="lesson-class">
                                                    <option value="0">Select Class</option>
                                                    <?php
                                                    $classRoomResultset = Database::search("SELECT DISTINCT `grade_id` FROM `classroom` WHERE `teacher_email`='" . $teacher["email"] . "'");
                                                    $classRoomRownumber = $classRoomResultset->num_rows;

                                                    for ($c = 0; $c < $classRoomRownumber; $c++) {
                                                        $classRoomData = $classRoomResultset->fetch_assoc();

                                                        $classResultset = Database::search("SELECT * FROM `grade` WHERE `id`='" . $classRoomData["grade_id"] . "'");
                                                        $classData = $classResultset->fetch_assoc();

                                                        if ($classRoomData["grade_id"] == $classData["id"]) {
                                                    ?>
                                                            <option value="<?php echo ($classData["id"]); ?>"><?php echo ($classData["name"]); ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 mt-3 pe-2 ps-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="form-label" style="font-family: 'quicksand-bold';">Subject</span>
                                            </div>
                                            <div class="col-12 d-grid pe-1">
                                                <select type="text" class="def-input bg-white" id="lesson-subject">
                                                    <option value="0">Select Subject</option>
                                                    <?php
                                                    $classRoomResultset2 = Database::search("SELECT DISTINCT `grade_id` FROM `classroom` WHERE `teacher_email`='" . $teacher["email"] . "'");
                                                    $classRoomRownumber2 = $classRoomResultset2->num_rows;

                                                    for ($c = 0; $c < $classRoomRownumber2; $c++) {
                                                        $classRoomData2 = $classRoomResultset2->fetch_assoc();

                                                        $teacherHasSubjectResultset = Database::search("SELECT * FROM `teacher_has_subject` WHERE `grade_id`='" . $classRoomData2["grade_id"] . "'");
                                                        $teacherHasSubjectData = $teacherHasSubjectResultset->fetch_assoc();

                                                        $subjectResultset = Database::search("SELECT * FROM `subject` WHERE `id`='" . $teacherHasSubjectData["subject_id"] . "'");
                                                        $subjectData = $subjectResultset->fetch_assoc();

                                                        if ($teacherHasSubjectData["subject_id"] == $subjectData["id"]) {
                                                    ?>
                                                            <option value="<?php echo ($subjectData["id"]); ?>"><?php echo ($subjectData["name"]); ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-3 p-2">
                                        <div class="col-12 def-card bg-body">
                                            <div class="col-12 p-5 text-center" id="fileUploader1">
                                                <label for="doc1" class="btn border-0"><i class="bi bi-plus-square-dotted fs-3" style="color: #353535;"></i></label></br>
                                                <span style="font-family: 'quicksand-bold';" style="color: #353535;">Add File</span>
                                                <input class="d-none" type="file" id="doc1" onclick="changeFileView1();" />
                                            </div>
                                            <div class="col-12 p-5 text-center d-none" id="updatedfile1">
                                                <span><i class="bi bi-file-earmark fs-1" id="doc-icon1" style="color: #353535;"></i></span></br>
                                                <span style="color: #353535;" id="file-name1"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 pt-1">
                                        <span style="font-size: 13px;color: #f81919" id="error-text-loader1"></span>
                                    </div>
                                    <div class="col-12 pt-2">
                                        <span style="font-size: 13px;"><i class="bi bi-info-circle"></i>&nbsp;&nbsp;PDF, DOCX and Text files only</span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="def-btn def-btn-body text-black" type="button" data-bs-dismiss="modal" onclick="changeFileViewBack1();">Cancle</button>
                                <button class="def-btn def-btn-primary text-white" type="button" onclick="uploadLesson();">Upload Lesson</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Add new lesson modal -->
                <!-- Add new assignment modal -->
                <div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal3">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content def-card border-0" id="invite-modal-loader">
                            <div class="text-center pt-1 pb-2">
                                <h5 class="modal-title mt-2 fs-3">Add New Assignment</h5>
                            </div>
                            <div class="modal-body mt-2 pb-2">
                                <div class="row g-1 ps-2 pe-2 pb-3">
                                    <?php

                                    ?>
                                    <div class="col-12 col-lg-6 mt-3 pe-2 ps-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="form-label" style="font-family: 'quicksand-bold';">Class</span>
                                            </div>
                                            <div class="col-12 d-grid pe-1">
                                                <select type="text" class="def-input bg-white" id="assignment-class">
                                                    <option value="0">Select Class</option>
                                                    <?php
                                                    $classRoomResultset = Database::search("SELECT * FROM `classroom` WHERE `teacher_email`='" . $teacher["email"] . "'");
                                                    $classRoomRownumber = $classRoomResultset->num_rows;

                                                    for ($c = 0; $c < $classRoomRownumber; $c++) {
                                                        $classRoomData = $classRoomResultset->fetch_assoc();

                                                        $classResultset = Database::search("SELECT * FROM `grade` WHERE `id`='" . $classRoomData["grade_id"] . "'");
                                                        $classData = $classResultset->fetch_assoc();

                                                        if ($classRoomData["grade_id"] == $classData["id"]) {
                                                    ?>
                                                            <option value="<?php echo ($classData["id"]); ?>"><?php echo ($classData["name"]); ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 mt-3 pe-2 ps-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="form-label" style="font-family: 'quicksand-bold';">Subject</span>
                                            </div>
                                            <div class="col-12 d-grid pe-1">
                                                <select type="text" class="def-input bg-white" id="assignment-subject">
                                                    <option value="0">Select Subject</option>
                                                    <?php
                                                    $classRoomResultset2 = Database::search("SELECT * FROM `classroom` WHERE `teacher_email`='" . $teacher["email"] . "'");
                                                    $classRoomRownumber2 = $classRoomResultset2->num_rows;

                                                    for ($c = 0; $c < $classRoomRownumber2; $c++) {
                                                        $classRoomData2 = $classRoomResultset2->fetch_assoc();

                                                        $teacherHasSubjectResultset = Database::search("SELECT * FROM `teacher_has_subject` WHERE `grade_id`='" . $classRoomData2["grade_id"] . "'");
                                                        $teacherHasSubjectData = $teacherHasSubjectResultset->fetch_assoc();

                                                        $subjectResultset = Database::search("SELECT * FROM `subject` WHERE `id`='" . $teacherHasSubjectData["subject_id"] . "'");
                                                        $subjectData = $subjectResultset->fetch_assoc();

                                                        if ($teacherHasSubjectData["subject_id"] == $subjectData["id"]) {
                                                    ?>
                                                            <option value="<?php echo ($subjectData["id"]); ?>"><?php echo ($subjectData["name"]); ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 mt-3 pe-2 ps-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="form-label" style="font-family: 'quicksand-bold';">Assignment Deadline</span>
                                            </div>
                                            <div class="col-12 d-grid pe-1">
                                                <input type="date" class="def-input bg-white" id="deadline" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-3 p-2">
                                        <div class="col-12 def-card bg-body">
                                            <div class="col-12 p-5 text-center" id="fileUploader">
                                                <label for="doc" class="btn border-0"><i class="bi bi-plus-square-dotted fs-3" style="color: #353535;"></i></label></br>
                                                <span style="font-family: 'quicksand-bold';" style="color: #353535;">Add File</span>
                                                <input class="d-none" type="file" id="doc" onclick="changeFileView();" />
                                            </div>
                                            <div class="col-12 p-5 text-center d-none" id="updatedfile">
                                                <span><i class="bi bi-file-earmark fs-1" id="doc-icon" style="color: #353535;"></i></span></br>
                                                <span style="color: #353535;" id="file-name"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 pt-1">
                                        <span style="font-size: 13px;color: #f81919" id="error-text-loader2"></span>
                                    </div>
                                    <div class="col-12 pt-2">
                                        <span style="font-size: 13px;"><i class="bi bi-info-circle"></i>&nbsp;&nbsp;PDF, DOCX and Text files only</span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="def-btn def-btn-body text-black" type="button" data-bs-dismiss="modal" onclick="changeFileViewBack();">Cancle</button>
                                <button class="def-btn def-btn-primary text-white" type="button" onclick="uploadAssignment();">Upload Assignment</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Add new assignment modal -->
                <!-- Submite student view modal -->
                <div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal1">
                    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content def-card border-0" id="submit-student-modal-loader">
                            <div class="text-center pt-1 pb-1">
                                <h5 class="modal-title mt-2 fs-3">Assignment Submite Student Details</h5>
                            </div>
                            <div class="modal-body mt-2 pb-2">
                                <div class="row g-1 ps-3 pe-3 pb-3">
                                    <div class="col-12">
                                        <div class="row d-none d-lg-block">
                                            <div class="def-card p-3 bg-white mb-2">
                                                <div class="row">
                                                    <div class="col-1 bg-white d-flex flex-row justify-content-center align-items-center">
                                                        <span style="font-family: 'quicksand-bold';">Profile</span>
                                                    </div>
                                                    <div class="col-1 my-auto">
                                                        <span style="font-family: 'quicksand-bold';">Name</span>
                                                    </div>
                                                    <div class="col-2 my-auto">
                                                        <span style="font-family: 'quicksand-bold';">Email</span>
                                                    </div>
                                                    <div class="col-2 my-auto">
                                                        <span class="ps-2" style="font-family: 'quicksand-bold';">Submite Date</span>
                                                    </div>
                                                    <div class="col-2 mt-3 mt-lg-0">
                                                        <span style="font-family: 'quicksand-bold';">Answer Sheet</span>
                                                    </div>
                                                    <div class="col-2 pt-3 pt-lg-0">
                                                        <span style="font-family: 'quicksand-bold';">Marks</span>
                                                    </div>
                                                    <div class="col-2 mt-3 mt-lg-0">
                                                        <span style="font-family: 'quicksand-bold';">Submit Marks</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" id="load-check-marks-loader"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="def-btn def-btn-primary text-white" type="button" data-bs-dismiss="modal">Done</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Submite student view modal -->
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
    header("Location:teacherSignIn.php");
}
?>