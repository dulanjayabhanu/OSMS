<?php
session_start();
require "connection.php";

if (isset($_SESSION["adminUser"])) {
    $admin = $_SESSION["adminUser"];
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Check Results - Online Student Management System</title>
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
                                    $adminProfileResultset = Database::search("SELECT * FROM `admin_profile_image` WHERE `admin_email`='" . $admin["email"] . "'");
                                    $adminProfileRownumber = $adminProfileResultset->num_rows;

                                    if ($adminProfileRownumber > 0) {
                                        $adminProfileData = $adminProfileResultset->fetch_assoc();
                                    ?>
                                        <div class="col-12 d-flex flex-row justify-content-center align-items-center p-1">
                                            <img src="<?php echo ($adminProfileData["path"]); ?>" class="img-thumbnail border-0" style="border-radius: 100%;height:120px;width:120px;box-shadow: 0px 2px 3px 1px rgba(19, 70, 129, 0.5);" />
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
                                    <span class="text-white text-capitalize fs-5" data-bs-toggle="tooltip" id="tooltip" data-bs-placement="right" title="Verifed" style="font-family: 'quicksand-bold';"><?php echo ($admin["first_name"] . " " . $admin["last_name"]); ?>&nbsp;<i class="bi bi-patch-check-fill fs-6 fw-bold" style="color: #fff;"></i></span>
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
                                    <a class="fw-bold def-btn def-btn-primary text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="adminPanel.php"><i class="bi bi-pencil-square fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;My Dashboard</a>
                                    <a class="fw-bold def-btn def-btn-primary text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="adminProfile.php"><i class="bi bi-person fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;My Profile</a>
                                    <a class="fw-bold def-btn def-btn-primary text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="#"><i class="bi bi-bell fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;Notifications</a>
                                    <a class="fw-bold def-btn def-btn-primary text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="manageTeachers.php"><i class="bi bi-easel fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;Teachers</a>
                                    <a class="fw-bold def-btn def-btn-primary text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="manageAcademicOfficers.php"><i class="bi bi-person-workspace fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;Academic Officers</a>
                                    <a class="fw-bold def-btn def-btn-primary text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="manageStudents.php"><i class="bi bi-people fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;Students</a>
                                    <a class="fw-bold def-btn def-btn-primary-active text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="checkResults.php"><i class="bi bi-clipboard2-check fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;Check Results</a>
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
                                    <span class="text-capitalize">Hi, <?php echo ($_SESSION["adminUser"]["first_name"]); ?></span>
                                    <span class="badge rounded-pill text-black" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#34e081;">Admin</span>
                                    <button class="border-0 bg-transparent ms-2 text-primary" onclick="adminSignout();"><i class="bi bi-power text-primary"></i> Logout</button>
                                </div>
                            </div>
                        </div>
                        <!-- upper header -->
                        <div class="col-12 my-auto p-3" style="background-color: #e5fdff;z-index: 1;">
                            <span class="text-black fs-1"><i class="fs-1 bi bi-clipboard2-check"></i>&nbsp;&nbsp;Check Results</span>
                        </div>
                        <div class="col-12 my-auto pt-2">
                            <!-- Bread crumb -->
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="adminPanel.php" class="text-decoration-none">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Check Results</li>
                                </ol>
                            </nav>
                            <!-- Bread crumb -->
                        </div>
                        <!-- main content -->
                        <div class="col-12 p-3 pt-3">
                            <div class="row g-0">
                                <div class="col-12 p-3">
                                    <div class="card def-card border-0 ps-5 pe-5 pb-4 pt-2">
                                        <div class="row">
                                            <div class="col-12 text-center pb-3 border-bottom">
                                                <span class="fs-3">Check Assignment Results</span>
                                            </div>
                                            <div class="col-12 col-lg-4 d-grid mt-0 mt-lg-4">
                                                <input type="text" class="def-input bg-body my-auto" placeholder="Search By Assignment Name..." id="assignment-name" />
                                            </div>
                                            <div class="col-12 col-lg-3 d-grid mt-2 mt-lg-4">
                                                <select class="def-input bg-body" id="grade">
                                                    <option value="0">Select Class</option>
                                                    <?php
                                                    $classroomResultset = Database::search("SELECT DISTINCT * FROM `classroom` INNER JOIN `grade` ON
                                                classroom.grade_id=grade.id");
                                                    $classroomRownumber = $classroomResultset->num_rows;

                                                    for ($c = 0; $c < $classroomRownumber; $c++) {
                                                        $classroomData = $classroomResultset->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo ($classroomData["grade_id"]) ?>"><?php echo ($classroomData["name"]); ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-12 col-lg-3 d-grid mt-2 mt-lg-4">
                                                <select class="def-input bg-body" id="assignment-id">
                                                    <option value="0">Select Assignment</option>
                                                    <?php
                                                    $assignmentResultset = Database::search("SELECT * FROM `assignment` WHERE `type`='1'");
                                                    $assignmentRownumber = $assignmentResultset->num_rows;

                                                    for ($c = 0; $c < $assignmentRownumber; $c++) {
                                                        $assignmentData = $assignmentResultset->fetch_assoc();
                                                        $assignmentSplit = explode("/", $assignmentData["name"]);
                                                        $assignmentFileName = explode(".", $assignmentSplit[2]);
                                                        $assignmentFileSplit = explode("_", $assignmentFileName[0]);
                                                        $assignmentName = $assignmentFileSplit[1]."/".$assignmentFileSplit[2]."-".$assignmentFileSplit[3];
                                                    ?>
                                                        <option value="<?php echo ($assignmentData["id"]) ?>"><?php echo ($assignmentName); ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-12 col-lg-2 d-grid mt-2 mt-lg-4">
                                                <button class="def-btn def-btn-primary text-white" onclick="searchMarks();"><i class="bi bi-search text-white fs-6"></i>&nbsp;&nbsp;Search Marks</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Student search area -->
                                <div class="col-12 p-3">
                                    <div class="def-card p-2">
                                        <div class="row">
                                            <div class="col-12 p-2">
                                                <div class="row ps-5 pe-5 pb-2 pt-2">
                                                    <!-- Student card -->
                                                    <div class="col-12 p-2 d-none d-lg-block">
                                                        <div class="col-12 p-3 def-card bg-white">
                                                            <div class="row">
                                                                <div class="col-12 col-lg-2 my-auto">
                                                                    <span style="font-family: 'quicksand-bold';">Name</span>
                                                                </div>
                                                                <div class="col-12 col-lg-3 my-auto">
                                                                    <span style="font-family: 'quicksand-bold';">Email</span>
                                                                </div>
                                                                <div class="col-12 col-lg-1 my-auto">
                                                                    <span style="font-family: 'quicksand-bold';">Class</span>
                                                                </div>
                                                                <div class="col-12 col-lg-3 d-grid mt-2 mt-lg-0">
                                                                    <span style="font-family: 'quicksand-bold';">Assignment</span>
                                                                </div>
                                                                <div class="col-12 col-lg-3 d-grid mt-2 mt-lg-0">
                                                                    <span style="font-family: 'quicksand-bold';">Marks</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Student card -->
                                                    <div class="row p-0 m-0" id="result-card-loader">
                                                        <!-- Student empty card -->
                                                        <div class="col-12 p-2">
                                                            <div class="col-12 pt-5 pb-5 def-card bg-white text-center">
                                                                <span>No Results</span>
                                                            </div>
                                                        </div>
                                                        <!-- Student empty card -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Student search area -->
                            </div>
                        </div>
                        <!-- main content -->
                    </div>
                </div>
            </div>
        </div>
        <!-- main content area -->
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
    header("Location:adminPanel.php");
}
?>