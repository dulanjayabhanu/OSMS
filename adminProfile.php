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

        <title>Admin Profile - Online Student Management System</title>
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
                                ?>
                                <div class="col-12 p-1">
                                    <div class="col-12 d-flex flex-row justify-content-center align-items-center">
                                        <img src="<?php echo ($profileData["path"]); ?>" class="img-thumbnail border-0" style="border-radius: 100%;height:120px;width:120px;box-shadow: 0px 2px 3px 1px rgba(19, 70, 129, 0.5);" />
                                    </div>
                                </div>
                                <div class="col-12 text-center pb-2">
                                    <span class="text-white text-capitalize fs-5" data-bs-toggle="tooltip" id="tooltip" data-bs-placement="right" title="Verifed" style="font-family: 'quicksand-bold';"><?php echo ($adminData["first_name"] . " " . $adminData["last_name"]); ?>&nbsp;<i class="bi bi-patch-check-fill fs-6 fw-bold" style="color: #fff;"></i></span>
                                    <script>
                                        var exampleEl = document.getElementById("tooltip");
                                        var tooltip = new bootstrap.Tooltip(exampleEl);
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 p-2 pb-2">
                            <div class="nav flex-column nav-pills mt-2" role="tablist" aria-orientation="vertical">
                                <nav class="nav flex-column gap-2 p-2">
                                    <a class="fw-bold def-btn def-btn-primary text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="adminPanel.php"><i class="bi bi-pencil-square fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;My Dashboard</a>
                                    <a class="fw-bold def-btn def-btn-primary-active text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="adminProfile.php"><i class="bi bi-person fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;My Profile</a>
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
                                    <button class="border-0 bg-transparent ms-2 text-primary"><i class="bi bi-power text-primary"></i> Logout</button>
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
                                    <li class="breadcrumb-item"><a href="adminPanel.php" class="text-decoration-none">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">My Profile</li>
                                </ol>
                            </nav>
                            <!-- Bread crumb -->
                        </div>
                        <!-- Profile content -->
                        <div class="col-12 p-3 pt-3">
                            <div class="row g-1 pb-3">
                                <div class="offset-1 col-10 def-card p-4">
                                    <div class="col-12 d-flex flex-row justify-content-center align-items-center pt-2">
                                        <img src="<?php echo ($profileData["path"]); ?>" class="img-thumbnail border-0 p-2" id="image" style="max-width:150px;height: 150px;border-radius:100%;box-shadow: 0px 2px 3px 1px rgba(19, 70, 129, 0.5);" />
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
                                        <span class="badge rounded-pill text-white fs-5 mt-3 mb-2" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-image: linear-gradient(24deg, #3972eb, #59ccfa);">Admin</span>
                                        <h1 class="text-capitalize fs-2" style="font-family: 'quicksand-bold';"><?php echo ($adminData["first_name"] . " " . $adminData["last_name"]); ?>&nbsp;<i class="bi bi-patch-check-fill fs-4 fw-bold" data-bs-toggle="tooltip" id="tooltip" data-bs-placement="right" title="Verifed" style="color: #34aedf;"></i></h1>
                                        <h4 class="text-primary fs-5"><?php echo ($adminData["email"]); ?></h4>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <div class="row g-1">
                                            <div class="col-12 col-lg-6 p-3">
                                                <div class="col-12">
                                                    <span class="form-label" style="font-family:'quicksand-bold';">First Name</span>
                                                </div>
                                                <div class="col-12 d-grid">
                                                    <input type="text" class="def-input text-capitalize bg-white" id="fname" value='<?php echo ($adminData["first_name"]); ?>' />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 p-3">
                                                <div class="col-12">
                                                    <span class="form-label text-capitalize" style="font-family:'quicksand-bold';">Last Name</span>
                                                </div>
                                                <div class="col-12 d-grid">
                                                    <input type="text" class="def-input text-capitalize bg-white" id="lname" value='<?php echo ($adminData["last_name"]); ?>' />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 p-3">
                                                <div class="col-12">
                                                    <span class="form-label" style="font-family:'quicksand-bold';">Mobile</span>
                                                </div>
                                                <div class="col-12 d-grid">
                                                    <input type="text" class="def-input bg-white" id="mobile" value='<?php echo ($adminData["mobile"]); ?>' />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 p-3">
                                                <div class="col-12">
                                                    <span class="form-label" style="font-family:'quicksand-bold';">Registered Date</span>
                                                </div>
                                                <div class="col-12 d-grid">
                                                    <input type="text" class="def-input bg-white" value='<?php echo ($adminData["joined_date"]); ?>' disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 p-3">
                                                <div class="col-12">
                                                    <span class="form-label" style="font-family:'quicksand-bold';">Email</span>
                                                </div>
                                                <div class="col-12 d-grid">
                                                    <input type="text" class="def-input bg-white" value='<?php echo ($adminData["email"]); ?>' disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 p-3">
                                                <div class="col-12">
                                                    <span class="form-label" style="font-family:'quicksand-bold';">Gender</span>
                                                </div>
                                                <div class="col-12 d-grid">
                                                    <select class="def-input bg-white" disabled>
                                                        <?php
                                                        $genderResultset = Database::search("SELECT * FROM `gender` WHERE `id`='" . $adminData["gender_id"] . "'");
                                                        $genderData = $genderResultset->fetch_assoc();
                                                        ?>
                                                        <option class="text-primary"><?php echo ($genderData["name"]); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6 col-lg-4 d-grid offset-3 offset-lg-4 mt-3 pb-3">
                                                <button class="def-btn def-btn-primary text-white" onclick="updateProfile();">Update Profile</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Profile content -->
                    </div>
                </div>
                <!-- main content area -->
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
    header("Location:index.php");
}
?>