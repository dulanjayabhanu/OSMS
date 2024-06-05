<?php
session_start();
require "connection.php";
if ($_SESSION["adminUser"]) {
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Admin Panel - Online Student Management System</title>
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="style.css" />
        <link rel="icon" type="image/x-icon" href="resources/images/favicon.ico" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    </head>

    <body>

        <div class="container-fluid">
            <div class="row">
                <!-- side panel -->
                <div class="col-12 col-lg-2">
                    <div class="row" style="height: 100vh;">
                        <div class="col-12" style="background-image: linear-gradient(24deg, #3972eb, #59ccfa);background-repeat: no-repeat;">
                            <div class="row">
                                <div class="col-12 text-center pt-2">
                                    <h2 class="text-white" style="font-family: 'barlow-bold';">OSMS</h2>
                                </div>
                                <?php
                                $adminResultset = Database::search("SELECT * FROM `admin` WHERE `email`='" . $_SESSION["adminUser"]["email"] . "'");
                                $adminRnumber = $adminResultset->num_rows;
                                $adminData = $adminResultset->fetch_assoc();
                                $profileResultset = Database::search("SELECT * FROM `admin_profile_image` WHERE `admin_email`='" . $_SESSION["adminUser"]["email"] . "'");
                                $profileData = $profileResultset->fetch_assoc();

                                $studentResultset = Database::search("SELECT * FROM `student`");
                                $studentRownumber = $studentResultset->num_rows;
                                $teacherResultset = Database::search("SELECT * FROM `teacher` WHERE `user_type`='1'");
                                $teacherRownumber = $teacherResultset->num_rows;
                                $officerResultset = Database::search("SELECT * FROM `teacher` WHERE `user_type`='2'");
                                $officerRownumber = $officerResultset->num_rows;
                                $parentResultset = Database::search("SELECT * FROM `parent`");
                                $parentRownumber = $parentResultset->num_rows;
                                ?>
                                <div class="col-12 p-1">
                                    <div class="col-12 d-flex flex-row justify-content-center align-items-center">
                                        <img src="<?php echo ($profileData["path"]); ?>" class="img-thumbnail border-0" style="border-radius: 100%;height:120px;width:120px;box-shadow: 0px 2px 3px 1px rgba(19, 70, 129, 0.5);" />
                                    </div>
                                </div>
                                <div class="col-12 text-center pb-2">
                                    <span class="text-white text-capitalize fs-5" data-bs-toggle="tooltip" id="tooltip" data-bs-placement="right" title="Verifed" style="font-family: 'quicksand-bold';"><?php echo($_SESSION["adminUser"]["first_name"]." ".$_SESSION["adminUser"]["last_name"]); ?>&nbsp;<i class="bi bi-patch-check-fill fs-6 fw-bold" style="color: #fff;"></i></span>
                                    <script>
                                        var exampleEl = document.getElementById("tooltip");
                                        var tooltip = new bootstrap.Tooltip(exampleEl);
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 p-2 pb-2" style="background-color: #e5fdff;">
                            <div class="nav flex-column nav-pills mt-2" role="tablist" aria-orientation="vertical">
                                <nav class="nav flex-column gap-2 p-2">
                                    <a class="fw-bold def-btn def-btn-primary-active text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="adminPanel.php"><i class="bi bi-pencil-square fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;My Dashboard</a>
                                    <a class="fw-bold def-btn def-btn-primary text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="adminProfile.php"><i class="bi bi-person fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;My Profile</a>
                                    <a class="fw-bold def-btn def-btn-primary text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="#"><i class="bi bi-bell fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;Notifications</a>
                                    <a class="fw-bold def-btn def-btn-primary text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="manageTeachers.php"><i class="bi bi-easel fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;Teachers</a>
                                    <a class="fw-bold def-btn def-btn-primary text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="manageAcademicOfficers.php"><i class="bi bi-person-workspace fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;Academic Officers</a>
                                    <a class="fw-bold def-btn def-btn-primary text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="manageStudents.php"><i class="bi bi-people fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;Students</a>
                                    <a class="fw-bold def-btn def-btn-primary text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="checkResults.php"><i class="bi bi-clipboard2-check fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;Check Results</a>
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
                            <span class="text-black fs-1"><i class="fs-1 bi bi-speedometer2"></i>&nbsp;&nbsp;Dashboard</span>
                        </div>
                        <div class="col-12 my-auto pt-2">
                            <!-- Bread crumb -->
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="adminPanel.php" class="text-decoration-none">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">My Dashboard</li>
                                </ol>
                            </nav>
                            <!-- Bread crumb -->
                        </div>
                        <!-- summary -->
                        <div class="col-12 p-3 pt-3">
                            <div class="row g-1">
                                <!-- summary card -->
                                <div class="col-6 col-lg-4 p-2">
                                    <div class="card def-card border-0">
                                        <div class="row g-0">
                                            <div class="col-md-5">
                                                <div class="col-12 d-flex flex-row justify-content-center align-items-center" style="height: 150px;">
                                                    <img src="resources/images/reading-student-svgrepo-com.svg" class="img-fluid" style="height: 120px;border-radius: 24px 24px 24px 24px;filter: invert(0.4);" />
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="card-body text-center text-lg-start">
                                                    <h1 class="card-title text-black">Student</h1>
                                                    <p class="card-text fs-2 text-primary" style="font-family: 'quicksand-bold';"><?php if($studentRownumber < 10){
                                                        echo("0".$studentRownumber);
                                                    }else{
                                                        echo($studentRownumber);
                                                    } ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- summary card -->
                                <!-- summary card -->
                                <div class="col-6 col-lg-4 p-2">
                                    <div class="card def-card border-0">
                                        <div class="row g-0">
                                            <div class="col-md-5">
                                                <div class="col-12 d-flex flex-row justify-content-center align-items-center" style="height: 150px;">
                                                    <img src="resources/images/teacher-at-the-blackboard-svgrepo-com.svg" class="img-fluid" style="height: 120px;border-radius: 24px 24px 24px 24px;filter: invert(0.4);" />
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="card-body text-center text-lg-start">
                                                    <h1 class="card-title text-black">Teacher</h1>
                                                    <p class="card-text fs-2 text-primary" style="font-family: 'quicksand-bold';"><?php if($teacherRownumber < 10){
                                                        echo("0".$teacherRownumber);
                                                    }else{
                                                        echo($teacherRownumber);
                                                    } ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- summary card -->
                                <!-- summary card -->
                                <div class="col-6 col-lg-4 p-2">
                                    <div class="card def-card border-0">
                                        <div class="row g-0">
                                            <div class="col-md-5">
                                                <div class="col-12 d-flex flex-row justify-content-center align-items-center" style="height: 150px;">
                                                    <img src="resources/images/familiar-group-of-three-svgrepo-com.svg" class="img-fluid" style="height: 120px;border-radius: 24px 24px 24px 24px;filter: invert(0.4);" />
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="card-body text-center text-lg-start">
                                                    <h1 class="card-title">Parent</h1>
                                                    <p class="card-text fs-2 text-primary" style="font-family: 'quicksand-bold';"><?php if($parentRownumber < 10){
                                                        echo("0".$parentRownumber);
                                                    }else{
                                                        echo($parentRownumber);
                                                    } ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- summary card -->
                                <!-- summary card -->
                                <div class="col-6 col-lg-4 p-2">
                                    <div class="card def-card border-0">
                                        <div class="row g-0">
                                            <div class="col-md-5">
                                                <div class="col-12 d-flex flex-row justify-content-center align-items-center" style="height: 150px;">
                                                    <img src="resources/images/customer-service-svgrepo-com.svg" class="img-fluid" style="height: 110px;border-radius: 24px 24px 24px 24px;filter: invert(0.4);" />
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="card-body text-center text-lg-start">
                                                    <h1 class="card-title">Officer</h1>
                                                    <p class="card-text fs-2 text-primary" style="font-family: 'quicksand-bold';"><?php if($officerRownumber < 10){
                                                        echo("0".$officerRownumber);
                                                    }else{
                                                        echo($officerRownumber);
                                                    } ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- summary card -->
                                <!-- summary card -->
                                <div class="col-6 col-md-6 col-lg-4 p-2">
                                    <div class="card def-card border-0">
                                        <div class="row g-0">
                                            <div class="col-md-5">
                                                <div class="col-12 d-flex flex-row justify-content-center align-items-center" style="height: 150px;">
                                                    <img src="resources/images/email-mail-message-svgrepo-com.svg" class="img-fluid" style="height: 110px;border-radius: 24px 24px 24px 24px;filter: invert(0.4);" />
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="card-body text-center text-lg-start">
                                                    <h1 class="card-title">Message</h1>
                                                    <p class="card-text fs-2 text-primary" style="font-family: 'quicksand-bold';">20</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- summary card -->
                                <!-- summary card -->
                                <div class="col-6 col-md-6 col-lg-4 p-2">
                                    <div class="card def-card border-0">
                                        <div class="row g-0">
                                            <div class="col-md-4">
                                                <div class="col-12 d-flex flex-row justify-content-center align-items-center" style="height: 150px;">
                                                    <img src="resources/images/chart-svgrepo-com.svg" class="img-fluid" style="height: 100px;border-radius: 24px 24px 24px 24px;filter: invert(0.4);" />
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body text-center text-lg-start">
                                                    <h1 class="card-title">Attendance</h1>
                                                    <p class="card-text fs-2 text-primary" style="font-family: 'quicksand-bold';">20</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- summary card -->
                            </div>
                        </div>
                        <!-- summary -->
                    </div>
                </div>
                <!-- main content area -->
            </div>
        </div>

        <script src="bootstrap.bundle.js"></script>
        <script src="script.js"></script>
    </body>

    </html>
<?php
} else {
    header("Location:index.php");
}
?>