<?php
session_start();
require "connection.php";

if (isset($_SESSION["student"])) {
    $student = $_SESSION["student"];

    if ($student["payment_status"] == 3) { //Paid version
?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <title>Student Dashboard - Online Student Management System</title>
            <link rel="stylesheet" href="bootstrap.css" />
            <link rel="stylesheet" href="style.css" />
            <link rel="icon" type="image/x-icon" href="resources/images/favicon.ico" />
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
        </head>

        <body onload="studentGradeUpdateCheckerStart();">

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
                                    <div class="col-12 text-center pb-2">
                                        <span class="text-white text-capitalize fs-5" data-bs-toggle="tooltip" id="tooltip" data-bs-placement="right" title="Verifed" style="font-family: 'quicksand-bold';"><?php echo ($student["first_name"] . " " . $student["last_name"]); ?><?php if ($student["verify_status"] == "1") {
                                                                                                                                                                                                                                                                                    ?>
                                            &nbsp;<i class="bi bi-check-circle-fill fs-6 fw-bold" style="color: #fff;"></i>
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
                                        <a class="fw-bold def-btn def-btn-primary-active text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="studentDashboard.php"><i class="bi bi-pencil-square fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;My Dashboard</a>
                                        <a class="fw-bold def-btn def-btn-primary text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="studentProfile.php"><i class="bi bi-person fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;My Profile</a>
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
                                        <span class="text-capitalize">Hi, <?php echo ($_SESSION["student"]["first_name"]); ?></span>
                                        <span class="badge rounded-pill text-white" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#346be0;">Student</span>
                                        <button class="border-0 bg-transparent ms-2 text-primary" onclick="studentSignout();"><i class="bi bi-power text-primary"></i> Logout</button>
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
                                        <li class="breadcrumb-item"><a href="studentDashboard.php" class="text-decoration-none">Home</a></li>
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
                                                <div class="col-12 col-lg-4">
                                                    <div class="card-body text-center text-lg-start">
                                                        <span class="text-black fs-1 text-capitalize fs-5" data-bs-toggle="tooltip" id="tooltip" data-bs-placement="right" title="Verifed"><?php echo ($student["first_name"] . " " . $student["last_name"]); ?><?php if ($student["verify_status"] == "1") {
                                                                                                                                                                                                                                                                ?>
                                                            &nbsp;<i class="bi bi-check-circle-fill fs-6 fw-bold" style="color: #fff;"></i>
                                                        <?php
                                                                                                                                                                                                                                                                } ?></span>
                                                        <?php
                                                        $studentClassResultset = Database::search("SELECT * FROM `classroom` WHERE `student_email`='" . $student["email"] . "'");
                                                        $studentClassData = $studentClassResultset->fetch_assoc();
                                                        $studentGradeResultset = Database::search("SELECT * FROM `grade` WHERE `id`='" . $studentClassData["grade_id"] . "'");
                                                        $studentGradeData = $studentGradeResultset->fetch_assoc();
                                                        ?>
                                                        <p class="card-text fs-2 text-primary" style="font-family: 'quicksand-bold';" id="all-student"><?php echo ($studentGradeData["name"]); ?></p>
                                                    </div>
                                                </div>
                                                <div class="offset-0 offset-lg-1 col-12 col-lg-4 p-3">
                                                    <div class="row">
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
                                    <!-- Subject area -->
                                    <div class="col-12 col-lg-6 p-3">
                                        <div class="def-card p-2">
                                            <div class="row">
                                                <div class="col-12 text-center pt-2 pb-2 border-bottom">
                                                    <h2>Subjects</h2>
                                                </div>
                                                <div class="col-12 p-2">
                                                    <div class="row pt-5 ps-5 pe-5 pb-4" id="student-card-loader1">
                                                        <?php
                                                        $subjectResultset = Database::search("SELECT * FROM `student_has_subject` INNER JOIN `classroom` ON
                                                    student_has_subject.student_email=classroom.student_email WHERE `student_has_subject`.`student_email`='" . $student["email"] . "'");
                                                        $subjectRownumber = $subjectResultset->num_rows;

                                                        if ($subjectRownumber < 1) {
                                                        ?>
                                                            <!-- Student empty card -->
                                                            <div class="col-12">
                                                                <div class="col-6 col-lg-12 pt-5 pb-5 def-card bg-white text-center">
                                                                    <span>No Results</span>
                                                                </div>
                                                            </div>
                                                            <!-- Student empty card -->
                                                            <?php
                                                        } else {
                                                            for ($x = 0; $x < $subjectRownumber; $x++) {
                                                                $subjectData = $subjectResultset->fetch_assoc();
                                                                $subjectNameResultset = Database::search("SELECT * FROM `subject` WHERE `id`='" . $subjectData["subject_id"] . "'");
                                                                $subjectNameData = $subjectNameResultset->fetch_assoc();
                                                            ?>
                                                                <!-- Subject card -->
                                                                <div class="col-lg-12 p-2">
                                                                    <div class="col-12 p-1 def-card bg-white card-animate">
                                                                        <div class="col-12 ps-2">
                                                                            <div class="card-body p-1">
                                                                                <div class="row">
                                                                                    <div class="col-12 pt-2 pe-2 pb-2 text-start text-md-center text-lg-start">
                                                                                        <h2 class="text-capitalize" style="font-family: 'quicksand-bold';color: #353535;"><?php echo ($subjectNameData["name"]); ?></h2>
                                                                                        <?php
                                                                                        $teacherResultset = Database::search("SELECT * FROM `teacher` WHERE `email`='" . $subjectData["teacher_email"] . "'");
                                                                                        $teacherData = $teacherResultset->fetch_assoc();
                                                                                        ?>
                                                                                        <h6>Teacher : <span class="text-primary"><?php echo ($teacherData["first_name"] . " " . $teacherData["last_name"]); ?></span></h6>
                                                                                    </div>
                                                                                    <div class="col-12">
                                                                                        <div class="row g-2 pt-2 pe-2 pb-2">
                                                                                            <div class="col-12 col-lg-6 d-grid">
                                                                                                <button class="def-btn def-btn-primary text-white" onclick="lessonDetail('<?php echo ($subjectData['subject_id']); ?>');"><i class="bi bi-file-earmark-richtext text-white fs-4"></i>&nbsp;&nbsp;Lesson Notes</button>
                                                                                            </div>
                                                                                            <div class="col-12 col-lg-6 d-grid">
                                                                                                <button class="def-btn def-btn-warning text-black" onclick="assignmentDetail('<?php echo ($subjectData['subject_id']); ?>');"><i class="bi bi-file-earmark-text text-black fs-4"></i>&nbsp;&nbsp;Assignments</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Subject card -->
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Subject area -->
                                    <!-- Lesson and assignment load area -->
                                    <div class="col-12 col-lg-6 p-3">
                                        <div class="def-card p-2">
                                            <div class="row">
                                                <div class="col-12 text-center pt-2 pb-2 border-bottom">
                                                    <h2>View Files</h2>
                                                </div>
                                                <div class="col-12 p-2">
                                                    <div class="row pt-5 ps-5 pe-5 pb-4" id="student-card-loader2">
                                                        <!-- Subject card -->
                                                        <div class="col-lg-12 p-2">
                                                            <div class="col-12 p-1 def-card bg-white card-animate">
                                                                <div class="col-12 ps-2">
                                                                    <div class="card-body p-1">
                                                                        <div class="row">
                                                                            <div class="col-12 pt-2 pe-2 pb-2 text-start text-md-center text-lg-start">
                                                                                <span class="badge rounded-pill text-black fs-4" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#cecece;width:30%;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="row g-2 pt-2 pe-2 pb-2">
                                                                                    <div class="col-12 col-lg-6 d-grid">
                                                                                        <button class="def-btn def-btn-success text-white">&nbsp;</button>
                                                                                    </div>
                                                                                    <div class="col-12 col-lg-6 d-grid">
                                                                                        <button class="def-btn def-btn-danger text-black">&nbsp;</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Subject card -->
                                                        <!-- Subject card -->
                                                        <div class="col-lg-12 p-2">
                                                            <div class="col-12 p-1 def-card bg-white card-animate">
                                                                <div class="col-12 ps-2">
                                                                    <div class="card-body p-1">
                                                                        <div class="row">
                                                                            <div class="col-12 pt-2 pe-2 pb-2 text-start text-md-center text-lg-start">
                                                                                <span class="badge rounded-pill text-black fs-4" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#cecece;width:30%;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="row g-2 pt-2 pe-2 pb-2">
                                                                                    <div class="col-12 col-lg-6 d-grid">
                                                                                        <button class="def-btn def-btn-success text-white">&nbsp;</button>
                                                                                    </div>
                                                                                    <div class="col-12 col-lg-6 d-grid">
                                                                                        <button class="def-btn def-btn-danger text-black">&nbsp;</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Subject card -->
                                                        <!-- Subject card -->
                                                        <div class="col-lg-12 p-2">
                                                            <div class="col-12 p-1 def-card bg-white card-animate">
                                                                <div class="col-12 ps-2">
                                                                    <div class="card-body p-1">
                                                                        <div class="row">
                                                                            <div class="col-12 pt-2 pe-2 pb-2 text-start text-md-center text-lg-start">
                                                                                <span class="badge rounded-pill text-black fs-4" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#cecece;width:30%;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="row g-2 pt-2 pe-2 pb-2">
                                                                                    <div class="col-12 col-lg-6 d-grid">
                                                                                        <button class="def-btn def-btn-success text-white">&nbsp;</button>
                                                                                    </div>
                                                                                    <div class="col-12 col-lg-6 d-grid">
                                                                                        <button class="def-btn def-btn-danger text-black">&nbsp;</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Subject card -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Lesson and assignment load area -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- main content area -->
                    <!-- Lesson view modal -->
                    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal2">
                        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content def-card border-0" id="lesson-modal-loader">
                                <div class="text-center pt-1 pb-1">
                                    <h5 class="modal-title mt-2 fs-3"></h5>
                                </div>
                                <div class="modal-body mt-2 pb-2">
                                    <div class="row g-1 ps-2 pe-2 pb-3">
                                        <embed style="height: 1000px;border-radius: 24px;" src="" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="def-btn def-btn-body text-black" type="button" data-bs-dismiss="modal"><i class="bi bi-fullscreen-exit fs-4 text-black"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Lesson view modal -->
                    <!-- Upload assignment modal -->
                    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal3">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content def-card border-0" id="invite-modal-loader">
                                <div class="text-center pt-1 pb-2">
                                    <h5 class="modal-title mt-2 fs-3">Upload Answers</h5>
                                </div>
                                <div class="modal-body mt-2 pb-2">
                                    <div class="row g-1 ps-2 pe-2 pb-3" id="assignmentUploadLoader">
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
                                    <button class="def-btn def-btn-primary text-white" type="button" onclick="uploadAnswers();">Upload Answer Sheet</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Upload assignment modal -->
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
    } else if ($student["payment_status"] == 2) { //Trail version
    ?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <title>Student Dashboard - Online Student Management System</title>
            <link rel="stylesheet" href="bootstrap.css" />
            <link rel="stylesheet" href="style.css" />
            <link rel="icon" type="image/x-icon" href="resources/images/favicon.ico" />
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
        </head>

        <body onload="showModal1(); timeCounterCaller();">

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
                                    </div>
                                    <div class="col-12 text-center pb-2">
                                        <span class="text-white text-capitalize fs-5" data-bs-toggle="tooltip" id="tooltip" data-bs-placement="right" title="Verifed" style="font-family: 'quicksand-bold';"><?php echo ($student["first_name"] . " " . $student["last_name"]); ?><?php if ($student["verify_status"] == "1") {
                                                                                                                                                                                                                                                                                    ?>
                                            &nbsp;<i class="bi bi-check-circle-fill fs-6 fw-bold" style="color: #fff;"></i>
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
                                        <a class="fw-bold def-btn def-btn-primary-active text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="studentDashboard.php"><i class="bi bi-pencil-square fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;My Dashboard</a>
                                        <a class="fw-bold def-btn def-btn-primary text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="studentProfile.php"><i class="bi bi-person fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;My Profile</a>
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
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="text-capitalize text-primary">Your trial will be expired in</span>
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
                            </div>
                            <!-- upper header -->
                            <div class="col-12 my-auto p-3" style="background-color: #e5fdff;z-index: 1;">
                                <span class="text-black fs-1"><i class="fs-1 bi bi-speedometer2"></i>&nbsp;&nbsp;Dashboard</span>
                            </div>
                            <div class="col-12 my-auto pt-2">
                                <!-- Bread crumb -->
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="studentDashboard.php" class="text-decoration-none">Home</a></li>
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
                                                <div class="col-12 col-lg-4">
                                                    <div class="card-body text-center text-lg-start">
                                                        <span class="text-black fs-1 text-capitalize fs-5" data-bs-toggle="tooltip" id="tooltip" data-bs-placement="right" title="Verifed"><?php echo ($student["first_name"] . " " . $student["last_name"]); ?><?php if ($student["verify_status"] == "1") {
                                                                                                                                                                                                                                                                ?>
                                                            &nbsp;<i class="bi bi-check-circle-fill fs-6 fw-bold" style="color: #fff;"></i>
                                                        <?php
                                                                                                                                                                                                                                                                } ?></span>
                                                        <?php
                                                        $studentClassResultset = Database::search("SELECT * FROM `classroom` WHERE `student_email`='" . $student["email"] . "'");
                                                        $studentClassData = $studentClassResultset->fetch_assoc();
                                                        $studentGradeResultset = Database::search("SELECT * FROM `grade` WHERE `id`='" . $studentClassData["grade_id"] . "'");
                                                        $studentGradeData = $studentGradeResultset->fetch_assoc();
                                                        ?>
                                                        <p class="card-text fs-2 text-primary" style="font-family: 'quicksand-bold';" id="all-student"><?php echo ($studentGradeData["name"]); ?></p>
                                                    </div>
                                                </div>
                                                <div class="offset-0 offset-lg-1 col-12 col-lg-4 p-3">
                                                    <div class="row">
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
                                    <!-- Subject area -->
                                    <div class="col-12 col-lg-6 p-3">
                                        <div class="def-card p-2">
                                            <div class="row">
                                                <div class="col-12 text-center pt-2 pb-2 border-bottom">
                                                    <h2>Subjects</h2>
                                                </div>
                                                <div class="col-12 p-2">
                                                    <div class="row pt-5 ps-5 pe-5 pb-4" id="student-card-loader1">
                                                        <?php
                                                        $subjectResultset = Database::search("SELECT * FROM `student_has_subject` INNER JOIN `classroom` ON
                                                    student_has_subject.student_email=classroom.student_email WHERE `student_has_subject`.`student_email`='" . $student["email"] . "'");
                                                        $subjectRownumber = $subjectResultset->num_rows;

                                                        if ($subjectRownumber < 1) {
                                                        ?>
                                                            <!-- Student empty card -->
                                                            <div class="col-12">
                                                                <div class="col-6 col-lg-12 pt-5 pb-5 def-card bg-white text-center">
                                                                    <span>No Results</span>
                                                                </div>
                                                            </div>
                                                            <!-- Student empty card -->
                                                            <?php
                                                        } else {
                                                            for ($x = 0; $x < $subjectRownumber; $x++) {
                                                                $subjectData = $subjectResultset->fetch_assoc();
                                                                $subjectNameResultset = Database::search("SELECT * FROM `subject` WHERE `id`='" . $subjectData["subject_id"] . "'");
                                                                $subjectNameData = $subjectNameResultset->fetch_assoc();
                                                            ?>
                                                                <!-- Subject card -->
                                                                <div class="col-lg-12 p-2">
                                                                    <div class="col-12 p-1 def-card bg-white card-animate">
                                                                        <div class="col-12 ps-2">
                                                                            <div class="card-body p-1">
                                                                                <div class="row">
                                                                                    <div class="col-12 pt-2 pe-2 pb-2 text-start text-md-center text-lg-start">
                                                                                        <h2 class="text-capitalize" style="font-family: 'quicksand-bold';color: #353535;"><?php echo ($subjectNameData["name"]); ?></h2>
                                                                                        <?php
                                                                                        $teacherResultset = Database::search("SELECT * FROM `teacher` WHERE `email`='" . $subjectData["teacher_email"] . "'");
                                                                                        $teacherData = $teacherResultset->fetch_assoc();
                                                                                        ?>
                                                                                        <h6>Teacher : <span class="text-primary"><?php echo ($teacherData["first_name"] . " " . $teacherData["last_name"]); ?></span></h6>
                                                                                    </div>
                                                                                    <div class="col-12">
                                                                                        <div class="row g-2 pt-2 pe-2 pb-2">
                                                                                            <div class="col-12 col-lg-6 d-grid">
                                                                                                <button class="def-btn def-btn-primary text-white" onclick="lessonDetail('<?php echo ($subjectData['subject_id']); ?>');"><i class="bi bi-file-earmark-richtext text-white fs-4"></i>&nbsp;&nbsp;Lesson Notes</button>
                                                                                            </div>
                                                                                            <div class="col-12 col-lg-6 d-grid">
                                                                                                <button class="def-btn def-btn-warning text-black" onclick="assignmentDetail('<?php echo ($subjectData['subject_id']); ?>');"><i class="bi bi-file-earmark-text text-black fs-4"></i>&nbsp;&nbsp;Assignments</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Subject card -->
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Subject area -->
                                    <!-- Lesson and assignment load area -->
                                    <div class="col-12 col-lg-6 p-3">
                                        <div class="def-card p-2">
                                            <div class="row">
                                                <div class="col-12 text-center pt-2 pb-2 border-bottom">
                                                    <h2>View Files</h2>
                                                </div>
                                                <div class="col-12 p-2">
                                                    <div class="row pt-5 ps-5 pe-5 pb-4" id="student-card-loader2">
                                                        <!-- Subject card -->
                                                        <div class="col-lg-12 p-2">
                                                            <div class="col-12 p-1 def-card bg-white card-animate">
                                                                <div class="col-12 ps-2">
                                                                    <div class="card-body p-1">
                                                                        <div class="row">
                                                                            <div class="col-12 pt-2 pe-2 pb-2 text-start text-md-center text-lg-start">
                                                                                <span class="badge rounded-pill text-black fs-4" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#cecece;width:30%;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="row g-2 pt-2 pe-2 pb-2">
                                                                                    <div class="col-12 col-lg-6 d-grid">
                                                                                        <button class="def-btn def-btn-success text-white">&nbsp;</button>
                                                                                    </div>
                                                                                    <div class="col-12 col-lg-6 d-grid">
                                                                                        <button class="def-btn def-btn-danger text-black">&nbsp;</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Subject card -->
                                                        <!-- Subject card -->
                                                        <div class="col-lg-12 p-2">
                                                            <div class="col-12 p-1 def-card bg-white card-animate">
                                                                <div class="col-12 ps-2">
                                                                    <div class="card-body p-1">
                                                                        <div class="row">
                                                                            <div class="col-12 pt-2 pe-2 pb-2 text-start text-md-center text-lg-start">
                                                                                <span class="badge rounded-pill text-black fs-4" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#cecece;width:30%;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="row g-2 pt-2 pe-2 pb-2">
                                                                                    <div class="col-12 col-lg-6 d-grid">
                                                                                        <button class="def-btn def-btn-success text-white">&nbsp;</button>
                                                                                    </div>
                                                                                    <div class="col-12 col-lg-6 d-grid">
                                                                                        <button class="def-btn def-btn-danger text-black">&nbsp;</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Subject card -->
                                                        <!-- Subject card -->
                                                        <div class="col-lg-12 p-2">
                                                            <div class="col-12 p-1 def-card bg-white card-animate">
                                                                <div class="col-12 ps-2">
                                                                    <div class="card-body p-1">
                                                                        <div class="row">
                                                                            <div class="col-12 pt-2 pe-2 pb-2 text-start text-md-center text-lg-start">
                                                                                <span class="badge rounded-pill text-black fs-4" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#cecece;width:30%;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="row g-2 pt-2 pe-2 pb-2">
                                                                                    <div class="col-12 col-lg-6 d-grid">
                                                                                        <button class="def-btn def-btn-success text-white">&nbsp;</button>
                                                                                    </div>
                                                                                    <div class="col-12 col-lg-6 d-grid">
                                                                                        <button class="def-btn def-btn-danger text-black">&nbsp;</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Subject card -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Lesson and assignment load area -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- main content area -->
                    <!-- Lesson view modal -->
                    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal2">
                        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content def-card border-0" id="lesson-modal-loader">
                                <div class="text-center pt-1 pb-1">
                                    <h5 class="modal-title mt-2 fs-3"></h5>
                                </div>
                                <div class="modal-body mt-2 pb-2">
                                    <div class="row g-1 ps-2 pe-2 pb-3">
                                        <embed style="height: 1000px;border-radius: 24px;" src="" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="def-btn def-btn-body text-black" type="button" data-bs-dismiss="modal"><i class="bi bi-fullscreen-exit fs-4 text-black"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Lesson view modal -->
                    <!-- Upload assignment modal -->
                    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal3">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content def-card border-0" id="invite-modal-loader">
                                <div class="text-center pt-1 pb-2">
                                    <h5 class="modal-title mt-2 fs-3">Upload Answers</h5>
                                </div>
                                <div class="modal-body mt-2 pb-2">
                                    <div class="row g-1 ps-2 pe-2 pb-3" id="assignmentUploadLoader">
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
                                    <button class="def-btn def-btn-primary text-white" type="button" onclick="uploadAnswers();">Upload Answer Sheet</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Upload assignment modal -->
                    <!-- Payment modal -->
                    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal1">
                        <div class="modal-dialog">
                            <div class="modal-content def-card border-0 p-1" id="submit-student-modal-loader" style="background-image: linear-gradient(24deg,#060af8, #59bafa);background-repeat: no-repeat;">
                                <div class="text-center pt-1">
                                    <h5 class="modal-title mt-2 fs-1 text-white" style="font-family: 'barlow-bold';">OSMS</h5>
                                    <div class="col-12 d-flex flex-row justify-content-center align-items-center">
                                        <img src="resources/images/logo.png" class="img-thumbnail bg-transparent border-0" style="height: 70px;" />
                                    </div>
                                </div>
                                <div class="modal-body pb-2">
                                    <div class="row g-1 ps-3 pe-3 pb-3">
                                        <div class="col-12 text-center pb-3">
                                            <?php
                                            $date = new DateTime($student["joined_date"]);
                                            date_add($date, date_interval_create_from_date_string("30 days"));
                                            $expireDateTime = new DateTime(date_format($date, "Y-m-d H:i:s"));
                                            $expireDate = $expireDateTime->format("Y-m-d");
                                            ?>
                                            <span class="text-white fs-5">Your first 30 days(1 month) are FREE. Your trial period will be expired on <span class="fs-5" style="color: #fbff00;font-family: 'barlow-bold';"><?php echo ($expireDate); ?></span></span>
                                        </div>
                                        <div class="col-12 pt-2">
                                            <div class="row">
                                                <div class="offset-2 col-4 d-grid">
                                                    <button class="def-btn def-btn-warning text-black" onclick="payNow('<?php echo ($_SESSION['student']['email']); ?>');">Pay Now</button>
                                                </div>
                                                <div class="col-4 d-grid">
                                                    <button class="def-btn def-btn-body text-black" type="button" data-bs-dismiss="modal" onclick="changeFileViewBack1();">Continue</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Payment modal -->
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

            <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
            <script src="bootstrap.bundle.js"></script>
            <script src="script.js"></script>
        </body>

        </html>
    <?php
    } else if ($student["payment_status"] == 4) { //Trail expire version
    ?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <title>Student Dashboard - Online Student Management System</title>
            <link rel="stylesheet" href="bootstrap.css" />
            <link rel="stylesheet" href="style.css" />
            <link rel="icon" type="image/x-icon" href="resources/images/favicon.ico" />
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
        </head>

        <body onload="showModal1();">

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
                                    </div>
                                    <div class="col-12 text-center pb-2">
                                        <span class="text-white text-capitalize fs-5" data-bs-toggle="tooltip" id="tooltip" data-bs-placement="right" title="Verifed" style="font-family: 'quicksand-bold';"><?php echo ($student["first_name"] . " " . $student["last_name"]); ?><?php if ($student["verify_status"] == "1") {
                                                                                                                                                                                                                                                                                    ?>
                                            &nbsp;<i class="bi bi-check-circle-fill fs-6 fw-bold" style="color: #fff;"></i>
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
                                        <a class="fw-bold def-btn def-btn-primary-active text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="#"><i class="bi bi-pencil-square fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;My Dashboard</a>
                                        <a class="fw-bold def-btn def-btn-primary text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="#"><i class="bi bi-person fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;My Profile</a>
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
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="text-capitalize text-primary">Your trial will be expired in</span>
                                                <span class="text-capitalize text-danger" id="counter">00Days : 00Hours : 00Minutes : 00Seconds</span>
                                            </div>
                                            <div class="col-12">
                                                <span class="text-capitalize">Hi, <?php echo ($_SESSION["student"]["first_name"]); ?></span>
                                                <span class="badge rounded-pill text-white" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#346be0;">Student</span>
                                                <button class="border-0 bg-transparent ms-2 text-primary" onclick="studentSignOut();"><i class="bi bi-power text-primary"></i> Logout</button>
                                            </div>
                                        </div>
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
                                        <li class="breadcrumb-item"><a href="studentDashboard.php" class="text-decoration-none">Home</a></li>
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
                                                <div class="col-12 col-lg-4">
                                                    <div class="card-body text-center text-lg-start">
                                                        <span class="text-black fs-1 text-capitalize fs-5" data-bs-toggle="tooltip" id="tooltip" data-bs-placement="right" title="Verifed"><?php echo ($student["first_name"] . " " . $student["last_name"]); ?><?php if ($student["verify_status"] == "1") {
                                                                                                                                                                                                                                                                ?>
                                                            &nbsp;<i class="bi bi-check-circle-fill fs-6 fw-bold" style="color: #fff;"></i>
                                                        <?php
                                                                                                                                                                                                                                                                } ?></span>
                                                        <?php
                                                        $studentClassResultset = Database::search("SELECT * FROM `classroom` WHERE `student_email`='" . $student["email"] . "'");
                                                        $studentClassData = $studentClassResultset->fetch_assoc();
                                                        $studentGradeResultset = Database::search("SELECT * FROM `grade` WHERE `id`='" . $studentClassData["grade_id"] . "'");
                                                        $studentGradeData = $studentGradeResultset->fetch_assoc();
                                                        ?>
                                                        <p class="card-text fs-2 text-primary" style="font-family: 'quicksand-bold';" id="all-student"><?php echo ($studentGradeData["name"]); ?></p>
                                                    </div>
                                                </div>
                                                <div class="offset-0 offset-lg-1 col-12 col-lg-4 p-3">
                                                    <div class="row">
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
                                    <!-- Subject area -->
                                    <div class="col-12 col-lg-6 p-3">
                                        <div class="def-card p-2">
                                            <div class="row">
                                                <div class="col-12 text-center pt-2 pb-2 border-bottom">
                                                    <h2>Subjects</h2>
                                                </div>
                                                <div class="col-12 p-2">
                                                    <div class="row pt-5 ps-5 pe-5 pb-4" id="student-card-loader1">
                                                        <?php
                                                        $subjectResultset = Database::search("SELECT * FROM `student_has_subject` INNER JOIN `classroom` ON
                                                    student_has_subject.student_email=classroom.student_email WHERE `student_has_subject`.`student_email`='" . $student["email"] . "'");
                                                        $subjectRownumber = $subjectResultset->num_rows;

                                                        if ($subjectRownumber < 1) {
                                                        ?>
                                                            <!-- Student empty card -->
                                                            <div class="col-12">
                                                                <div class="col-6 col-lg-12 pt-5 pb-5 def-card bg-white text-center">
                                                                    <span>No Results</span>
                                                                </div>
                                                            </div>
                                                            <!-- Student empty card -->
                                                            <?php
                                                        } else {
                                                            for ($x = 0; $x < $subjectRownumber; $x++) {
                                                                $subjectData = $subjectResultset->fetch_assoc();
                                                                $subjectNameResultset = Database::search("SELECT * FROM `subject` WHERE `id`='" . $subjectData["subject_id"] . "'");
                                                                $subjectNameData = $subjectNameResultset->fetch_assoc();
                                                            ?>
                                                                <!-- Subject card -->
                                                                <div class="col-lg-12 p-2">
                                                                    <div class="col-12 p-1 def-card bg-white card-animate">
                                                                        <div class="col-12 ps-2">
                                                                            <div class="card-body p-1">
                                                                                <div class="row">
                                                                                    <div class="col-12 pt-2 pe-2 pb-2 text-start text-md-center text-lg-start">
                                                                                        <h2 class="text-capitalize" style="font-family: 'quicksand-bold';color: #353535;"><?php echo ($subjectNameData["name"]); ?></h2>
                                                                                        <?php
                                                                                        $teacherResultset = Database::search("SELECT * FROM `teacher` WHERE `email`='" . $subjectData["teacher_email"] . "'");
                                                                                        $teacherData = $teacherResultset->fetch_assoc();
                                                                                        ?>
                                                                                        <h6>Teacher : <span class="text-primary"><?php echo ($teacherData["first_name"] . " " . $teacherData["last_name"]); ?></span></h6>
                                                                                    </div>
                                                                                    <div class="col-12">
                                                                                        <div class="row g-2 pt-2 pe-2 pb-2">
                                                                                            <div class="col-12 col-lg-6 d-grid">
                                                                                                <button class="def-btn def-btn-primary text-white"><i class="bi bi-file-earmark-richtext text-white fs-4"></i>&nbsp;&nbsp;Lesson Notes</button>
                                                                                            </div>
                                                                                            <div class="col-12 col-lg-6 d-grid">
                                                                                                <button class="def-btn def-btn-warning text-black"><i class="bi bi-file-earmark-text text-black fs-4"></i>&nbsp;&nbsp;Assignments</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Subject card -->
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Subject area -->
                                    <!-- Lesson and assignment load area -->
                                    <div class="col-12 col-lg-6 p-3">
                                        <div class="def-card p-2">
                                            <div class="row">
                                                <div class="col-12 text-center pt-2 pb-2 border-bottom">
                                                    <h2>View Files</h2>
                                                </div>
                                                <div class="col-12 p-2">
                                                    <div class="row pt-5 ps-5 pe-5 pb-4" id="student-card-loader2">
                                                        <!-- Subject card -->
                                                        <div class="col-lg-12 p-2">
                                                            <div class="col-12 p-1 def-card bg-white card-animate">
                                                                <div class="col-12 ps-2">
                                                                    <div class="card-body p-1">
                                                                        <div class="row">
                                                                            <div class="col-12 pt-2 pe-2 pb-2 text-start text-md-center text-lg-start">
                                                                                <span class="badge rounded-pill text-black fs-4" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#cecece;width:30%;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="row g-2 pt-2 pe-2 pb-2">
                                                                                    <div class="col-12 col-lg-6 d-grid">
                                                                                        <button class="def-btn def-btn-success text-white">&nbsp;</button>
                                                                                    </div>
                                                                                    <div class="col-12 col-lg-6 d-grid">
                                                                                        <button class="def-btn def-btn-danger text-black">&nbsp;</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Subject card -->
                                                        <!-- Subject card -->
                                                        <div class="col-lg-12 p-2">
                                                            <div class="col-12 p-1 def-card bg-white card-animate">
                                                                <div class="col-12 ps-2">
                                                                    <div class="card-body p-1">
                                                                        <div class="row">
                                                                            <div class="col-12 pt-2 pe-2 pb-2 text-start text-md-center text-lg-start">
                                                                                <span class="badge rounded-pill text-black fs-4" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#cecece;width:30%;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="row g-2 pt-2 pe-2 pb-2">
                                                                                    <div class="col-12 col-lg-6 d-grid">
                                                                                        <button class="def-btn def-btn-success text-white">&nbsp;</button>
                                                                                    </div>
                                                                                    <div class="col-12 col-lg-6 d-grid">
                                                                                        <button class="def-btn def-btn-danger text-black">&nbsp;</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Subject card -->
                                                        <!-- Subject card -->
                                                        <div class="col-lg-12 p-2">
                                                            <div class="col-12 p-1 def-card bg-white card-animate">
                                                                <div class="col-12 ps-2">
                                                                    <div class="card-body p-1">
                                                                        <div class="row">
                                                                            <div class="col-12 pt-2 pe-2 pb-2 text-start text-md-center text-lg-start">
                                                                                <span class="badge rounded-pill text-black fs-4" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#cecece;width:30%;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="row g-2 pt-2 pe-2 pb-2">
                                                                                    <div class="col-12 col-lg-6 d-grid">
                                                                                        <button class="def-btn def-btn-success text-white">&nbsp;</button>
                                                                                    </div>
                                                                                    <div class="col-12 col-lg-6 d-grid">
                                                                                        <button class="def-btn def-btn-danger text-black">&nbsp;</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Subject card -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Lesson and assignment load area -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- main content area -->
                    <!-- Payment modal -->
                    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal1">
                        <div class="modal-dialog">
                            <div class="modal-content def-card border-0 p-1" id="submit-student-modal-loader" style="background-image: linear-gradient(24deg,#060af8, #59bafa);background-repeat: no-repeat;">
                                <div class="text-center pt-1">
                                    <h5 class="modal-title mt-2 fs-1 text-white" style="font-family: 'barlow-bold';">OSMS</h5>
                                    <div class="col-12 d-flex flex-row justify-content-center align-items-center">
                                        <img src="resources/images/logo.png" class="img-thumbnail bg-transparent border-0" style="height: 70px;" />
                                    </div>
                                </div>
                                <div class="modal-body pb-2">
                                    <div class="row g-1 ps-3 pe-3 pb-3">
                                        <div class="col-12 text-center pb-3">
                                            <span class="text-white fs-5">Your first 30 days(1 month) trial period is over. You can use your student portal within this year by paying an amount of <span class="fs-5" style="color: #fbff00;font-family: 'barlow-bold';">2000 LKR</span></span>
                                        </div>
                                        <div class="col-12 pt-2">
                                            <div class="row">
                                                <div class="offset-4 col-4 d-grid">
                                                    <button class="def-btn def-btn-warning text-black" onclick="payNow('<?php echo ($_SESSION['student']['email']); ?>');">Pay Now</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Payment modal -->
                </div>
            </div>

            <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
            <script src="bootstrap.bundle.js"></script>
            <script src="script.js"></script>
        </body>

        </html>
    <?php
    } else if ($student["payment_status"] == 1) { //Yearly payment version
    ?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <title>Student Dashboard - Online Student Management System</title>
            <link rel="stylesheet" href="bootstrap.css" />
            <link rel="stylesheet" href="style.css" />
            <link rel="icon" type="image/x-icon" href="resources/images/favicon.ico" />
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
        </head>

        <body onload="showModal1();">

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
                                    </div>
                                    <div class="col-12 text-center pb-2">
                                        <span class="text-white text-capitalize fs-5" data-bs-toggle="tooltip" id="tooltip" data-bs-placement="right" title="Verifed" style="font-family: 'quicksand-bold';"><?php echo ($student["first_name"] . " " . $student["last_name"]); ?><?php if ($student["verify_status"] == "1") {
                                                                                                                                                                                                                                                                                    ?>
                                            &nbsp;<i class="bi bi-check-circle-fill fs-6 fw-bold" style="color: #fff;"></i>
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
                                        <a class="fw-bold def-btn def-btn-primary-active text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="#"><i class="bi bi-pencil-square fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;My Dashboard</a>
                                        <a class="fw-bold def-btn def-btn-primary text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="#"><i class="bi bi-person fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;My Profile</a>
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
                                        <span class="text-capitalize">Hi, <?php echo ($_SESSION["student"]["first_name"]); ?></span>
                                        <span class="badge rounded-pill text-white" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#346be0;">Student</span>
                                        <button class="border-0 bg-transparent ms-2 text-primary" onclick="studentSignOut();"><i class="bi bi-power text-primary"></i> Logout</button>
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
                                        <li class="breadcrumb-item"><a href="studentDashboard.php" class="text-decoration-none">Home</a></li>
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
                                                <div class="col-12 col-lg-4">
                                                    <div class="card-body text-center text-lg-start">
                                                        <span class="text-black fs-1 text-capitalize fs-5" data-bs-toggle="tooltip" id="tooltip" data-bs-placement="right" title="Verifed"><?php echo ($student["first_name"] . " " . $student["last_name"]); ?><?php if ($student["verify_status"] == "1") {
                                                                                                                                                                                                                                                                ?>
                                                            &nbsp;<i class="bi bi-check-circle-fill fs-6 fw-bold" style="color: #fff;"></i>
                                                        <?php
                                                                                                                                                                                                                                                                } ?></span>
                                                        <?php
                                                        $studentClassResultset = Database::search("SELECT * FROM `classroom` WHERE `student_email`='" . $student["email"] . "'");
                                                        $studentClassData = $studentClassResultset->fetch_assoc();
                                                        $studentGradeResultset = Database::search("SELECT * FROM `grade` WHERE `id`='" . $studentClassData["grade_id"] . "'");
                                                        $studentGradeData = $studentGradeResultset->fetch_assoc();
                                                        ?>
                                                        <p class="card-text fs-2 text-primary" style="font-family: 'quicksand-bold';" id="all-student"><?php echo ($studentGradeData["name"]); ?></p>
                                                    </div>
                                                </div>
                                                <div class="offset-0 offset-lg-1 col-12 col-lg-4 p-3">
                                                    <div class="row">
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
                                    <!-- Subject area -->
                                    <div class="col-12 col-lg-6 p-3">
                                        <div class="def-card p-2">
                                            <div class="row">
                                                <div class="col-12 text-center pt-2 pb-2 border-bottom">
                                                    <h2>Subjects</h2>
                                                </div>
                                                <div class="col-12 p-2">
                                                    <div class="row pt-5 ps-5 pe-5 pb-4" id="student-card-loader1">
                                                        <?php
                                                        $subjectResultset = Database::search("SELECT * FROM `student_has_subject` INNER JOIN `classroom` ON
                                                    student_has_subject.student_email=classroom.student_email WHERE `student_has_subject`.`student_email`='" . $student["email"] . "'");
                                                        $subjectRownumber = $subjectResultset->num_rows;

                                                        if ($subjectRownumber < 1) {
                                                        ?>
                                                            <!-- Student empty card -->
                                                            <div class="col-12">
                                                                <div class="col-6 col-lg-12 pt-5 pb-5 def-card bg-white text-center">
                                                                    <span>No Results</span>
                                                                </div>
                                                            </div>
                                                            <!-- Student empty card -->
                                                            <?php
                                                        } else {
                                                            for ($x = 0; $x < $subjectRownumber; $x++) {
                                                                $subjectData = $subjectResultset->fetch_assoc();
                                                                $subjectNameResultset = Database::search("SELECT * FROM `subject` WHERE `id`='" . $subjectData["subject_id"] . "'");
                                                                $subjectNameData = $subjectNameResultset->fetch_assoc();
                                                            ?>
                                                                <!-- Subject card -->
                                                                <div class="col-lg-12 p-2">
                                                                    <div class="col-12 p-1 def-card bg-white card-animate">
                                                                        <div class="col-12 ps-2">
                                                                            <div class="card-body p-1">
                                                                                <div class="row">
                                                                                    <div class="col-12 pt-2 pe-2 pb-2 text-start text-md-center text-lg-start">
                                                                                        <h2 class="text-capitalize" style="font-family: 'quicksand-bold';color: #353535;"><?php echo ($subjectNameData["name"]); ?></h2>
                                                                                        <?php
                                                                                        $teacherResultset = Database::search("SELECT * FROM `teacher` WHERE `email`='" . $subjectData["teacher_email"] . "'");
                                                                                        $teacherData = $teacherResultset->fetch_assoc();
                                                                                        ?>
                                                                                        <h6>Teacher : <span class="text-primary"><?php echo ($teacherData["first_name"] . " " . $teacherData["last_name"]); ?></span></h6>
                                                                                    </div>
                                                                                    <div class="col-12">
                                                                                        <div class="row g-2 pt-2 pe-2 pb-2">
                                                                                            <div class="col-12 col-lg-6 d-grid">
                                                                                                <button class="def-btn def-btn-primary text-white"><i class="bi bi-file-earmark-richtext text-white fs-4"></i>&nbsp;&nbsp;Lesson Notes</button>
                                                                                            </div>
                                                                                            <div class="col-12 col-lg-6 d-grid">
                                                                                                <button class="def-btn def-btn-warning text-black"><i class="bi bi-file-earmark-text text-black fs-4"></i>&nbsp;&nbsp;Assignments</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Subject card -->
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Subject area -->
                                    <!-- Lesson and assignment load area -->
                                    <div class="col-12 col-lg-6 p-3">
                                        <div class="def-card p-2">
                                            <div class="row">
                                                <div class="col-12 text-center pt-2 pb-2 border-bottom">
                                                    <h2>View Files</h2>
                                                </div>
                                                <div class="col-12 p-2">
                                                    <div class="row pt-5 ps-5 pe-5 pb-4" id="student-card-loader2">
                                                        <!-- Subject card -->
                                                        <div class="col-lg-12 p-2">
                                                            <div class="col-12 p-1 def-card bg-white card-animate">
                                                                <div class="col-12 ps-2">
                                                                    <div class="card-body p-1">
                                                                        <div class="row">
                                                                            <div class="col-12 pt-2 pe-2 pb-2 text-start text-md-center text-lg-start">
                                                                                <span class="badge rounded-pill text-black fs-4" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#cecece;width:30%;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="row g-2 pt-2 pe-2 pb-2">
                                                                                    <div class="col-12 col-lg-6 d-grid">
                                                                                        <button class="def-btn def-btn-success text-white">&nbsp;</button>
                                                                                    </div>
                                                                                    <div class="col-12 col-lg-6 d-grid">
                                                                                        <button class="def-btn def-btn-danger text-black">&nbsp;</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Subject card -->
                                                        <!-- Subject card -->
                                                        <div class="col-lg-12 p-2">
                                                            <div class="col-12 p-1 def-card bg-white card-animate">
                                                                <div class="col-12 ps-2">
                                                                    <div class="card-body p-1">
                                                                        <div class="row">
                                                                            <div class="col-12 pt-2 pe-2 pb-2 text-start text-md-center text-lg-start">
                                                                                <span class="badge rounded-pill text-black fs-4" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#cecece;width:30%;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="row g-2 pt-2 pe-2 pb-2">
                                                                                    <div class="col-12 col-lg-6 d-grid">
                                                                                        <button class="def-btn def-btn-success text-white">&nbsp;</button>
                                                                                    </div>
                                                                                    <div class="col-12 col-lg-6 d-grid">
                                                                                        <button class="def-btn def-btn-danger text-black">&nbsp;</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Subject card -->
                                                        <!-- Subject card -->
                                                        <div class="col-lg-12 p-2">
                                                            <div class="col-12 p-1 def-card bg-white card-animate">
                                                                <div class="col-12 ps-2">
                                                                    <div class="card-body p-1">
                                                                        <div class="row">
                                                                            <div class="col-12 pt-2 pe-2 pb-2 text-start text-md-center text-lg-start">
                                                                                <span class="badge rounded-pill text-black fs-4" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#cecece;width:30%;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="row g-2 pt-2 pe-2 pb-2">
                                                                                    <div class="col-12 col-lg-6 d-grid">
                                                                                        <button class="def-btn def-btn-success text-white">&nbsp;</button>
                                                                                    </div>
                                                                                    <div class="col-12 col-lg-6 d-grid">
                                                                                        <button class="def-btn def-btn-danger text-black">&nbsp;</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Subject card -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Lesson and assignment load area -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- main content area -->
                    <!-- Payment modal -->
                    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal1">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content def-card border-0 p-1" id="submit-student-modal-loader" style="background-image: linear-gradient(24deg,#060af8, #59bafa);background-repeat: no-repeat;">
                                <div class="text-center pt-1">
                                    <h5 class="modal-title mt-2 fs-1 text-white" style="font-family: 'barlow-bold';">OSMS</h5>
                                    <div class="col-12 d-flex flex-row justify-content-center align-items-center">
                                        <img src="resources/images/logo.png" class="img-thumbnail bg-transparent border-0" style="height: 100px;" />
                                    </div>
                                    <span class="text-white fs-5">Congratulation <?php echo ($_SESSION['student']['first_name'] . " " . $_SESSION['student']['last_name']); ?> !!!</span><br />
                                </div>
                                <div class="modal-body pb-2">
                                    <div class="row g-1 ps-3 pe-3 pb-3">
                                        <div class="col-12 text-center pb-3">
                                            <span class="text-white fs-5">Welcome to Grade <?php echo ($studentGradeData["name"]); ?>. You have to pay <span class="fs-5" style="color: #fbff00;">2000LKR</span> amount for this year to<br /> use your protal</span>
                                        </div>
                                        <div class="col-4 offset-4 d-grid pt-2">
                                            <button class="def-btn def-btn-warning text-black" onclick="payNow('<?php echo ($_SESSION['student']['email']); ?>');">Pay Now</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Payment modal -->
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

            <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
            <script src="bootstrap.bundle.js"></script>
            <script src="script.js"></script>
        </body>

        </html>
<?php
    }
} else {
    header("Location:studentSignIn.php");
}
?>