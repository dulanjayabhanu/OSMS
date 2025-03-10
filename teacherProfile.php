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

        <title>Teacher Profile - Online Student Management System</title>
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
                                <?php
                                    $teacherResultset = Database::search("SELECT * FROM `teacher` WHERE `user_type`='1' AND `email`='".$teacher["email"]."'");
                                    $teacherData = $teacherResultset->fetch_assoc();
                                    ?>
                                <div class="col-12 text-center pb-2">
                                    <span class="text-white text-capitalize fs-5" data-bs-toggle="tooltip" id="tooltip" data-bs-placement="right" title="Verifed" style="font-family: 'quicksand-bold';"><?php echo ($teacherData["first_name"] . " " . $teacherData["last_name"]); ?><?php if ($teacherData["verify_status"] == "1") {
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
                                    <a class="fw-bold def-btn def-btn-primary text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="teacherDashboard.php"><i class="bi bi-pencil-square fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;My Dashboard</a>
                                    <a class="fw-bold def-btn def-btn-primary-active text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="teacherProfile.php"><i class="bi bi-person fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;My Profile</a>
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
                            <span class="text-black fs-1"><i class="fs-1 bi bi-person-circle"></i>&nbsp;&nbsp;My Profile</span>
                        </div>
                        <div class="col-12 my-auto pt-2">
                            <!-- Bread crumb -->
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="teacherDashboard.php" class="text-decoration-none">Home</a></li>
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
                                        if ($teacherProfileRownumber > 0) {
                                        ?>
                                            <img src="<?php echo ($teacherProfileData["path"]); ?>" class="img-thumbnail border-0 p-2" id="image" style="max-width:150px;height: 150px;border-radius:100%;box-shadow: 0px 2px 3px 1px rgba(19, 70, 129, 0.5);" />
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
                                        <span class="badge rounded-pill text-white fs-5 mt-3 mb-2" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-image: linear-gradient(24deg, #3972eb, #59ccfa);">Teacher</span>
                                        <h1 class="text-capitalize fs-2" style="font-family: 'quicksand-bold';"><?php echo ($teacherData["first_name"] . " " . $teacherData["last_name"]); ?>&nbsp;<i class="bi bi-patch-check-fill fs-4 fw-bold" data-bs-toggle="tooltip" id="tooltip" data-bs-placement="right" title="Verifed" style="color: #34aedf;"></i></h1>
                                        <h4 class="text-primary fs-5"><?php echo ($teacherData["email"]); ?></h4>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <div class="row g-1">
                                            <div class="col-12 col-lg-6 p-3">
                                                <div class="col-12">
                                                    <span class="form-label" style="font-family:'quicksand-bold';">First Name</span>
                                                </div>
                                                <div class="col-12 d-grid">
                                                    <input type="text" class="def-input text-capitalize bg-white" id="fname" value='<?php echo ($teacherData["first_name"]); ?>' />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 p-3">
                                                <div class="col-12">
                                                    <span class="form-label text-capitalize" style="font-family:'quicksand-bold';">Last Name</span>
                                                </div>
                                                <div class="col-12 d-grid">
                                                    <input type="text" class="def-input text-capitalize bg-white" id="lname" value='<?php echo ($teacherData["last_name"]); ?>' />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 p-3">
                                                <div class="col-12">
                                                    <span class="form-label" style="font-family:'quicksand-bold';">Mobile</span>
                                                </div>
                                                <div class="col-12 d-grid">
                                                    <input type="text" class="def-input bg-white" id="mobile" value='<?php echo ($teacherData["mobile"]); ?>' />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 p-3">
                                                <div class="col-12">
                                                    <span class="form-label" style="font-family:'quicksand-bold';">Registered Date</span>
                                                </div>
                                                <div class="col-12 d-grid">
                                                    <input type="text" class="def-input bg-white" value='<?php echo ($teacherData["joined_date"]); ?>' disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 p-3">
                                                <div class="col-12">
                                                    <span class="form-label" style="font-family:'quicksand-bold';">Email</span>
                                                </div>
                                                <div class="col-12 d-grid">
                                                    <input type="text" class="def-input bg-white" value='<?php echo ($teacherData["email"]); ?>' disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 p-3">
                                                <div class="col-12">
                                                    <span class="form-label" style="font-family:'quicksand-bold';">Gender</span>
                                                </div>
                                                <div class="col-12 d-grid">
                                                    <select class="def-input bg-white" disabled>
                                                        <?php
                                                        $genderResultset = Database::search("SELECT * FROM `gender` WHERE `id`='" . $teacherData["gender_id"] . "'");
                                                        $genderData = $genderResultset->fetch_assoc();
                                                        ?>
                                                        <option class="text-primary"><?php echo ($genderData["name"]); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6 col-lg-4 d-grid offset-3 offset-lg-4 mt-3 pb-3">
                                                <button class="def-btn def-btn-primary text-white" onclick="updateTeacherProfile();">Update Profile</button>
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
    header("Location:teacherSignIn.php");
}
?>