<?php
session_start();
require "connection.php";

if (isset($_SESSION["adminUser"]["email"])) {
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Manage Academic Officers - Online Student Management System</title>
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
                                    <a class="fw-bold def-btn def-btn-primary text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="adminProfile.php"><i class="bi bi-person fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;My Profile</a>
                                    <a class="fw-bold def-btn def-btn-primary text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="#"><i class="bi bi-bell fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;Notifications</a>
                                    <a class="fw-bold def-btn def-btn-primary text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="manageTeachers.php"><i class="bi bi-easel fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;Teachers</a>
                                    <a class="fw-bold def-btn def-btn-primary-active text-decoration-none text-center text-lg-start text-capitalize text-white" aria-current="page" href="manageAcademicOfficers.php"><i class="bi bi-person-workspace fs-5 fw-bold text-white"></i>&nbsp;&nbsp;&nbsp;Academic Officers</a>
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
                                    <span class="text-capitalize">Hi, Dulnajaya</span>
                                    <span class="badge rounded-pill text-black" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#34e081;">Admin</span>
                                    <button class="border-0 bg-transparent ms-2 text-primary"><i class="bi bi-power text-primary"></i> Logout</button>
                                </div>
                            </div>
                        </div>
                        <!-- upper header -->
                        <div class="col-12 my-auto p-3" style="background-color: #e5fdff;z-index: 1;">
                            <span class="text-black fs-1"><i class="fs-1 bi-person-workspace"></i>&nbsp;&nbsp;Manage Academic Officers</span>
                        </div>
                        <div class="col-12 my-auto pt-2">
                            <!-- Bread crumb -->
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="adminPanel.php" class="text-decoration-none">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Manage Academic Officers</li>
                                </ol>
                            </nav>
                            <!-- Bread crumb -->
                        </div>
                        <div class="col-12 p-4 p-lg-4 pt-3">
                            <div class="row g-1">
                                <div class="offset-2 offset-md-3 offset-lg-8 col-4 col-md-3 col-lg-2 d-grid">
                                    <button class="def-btn def-btn-primary text-white" onclick="showModal2();"><i class="bi bi-person-add text-white fs-4"></i>&nbsp;&nbsp;Invite Officer</button>
                                </div>
                                <div class="col-4 col-md-3 col-lg-2 d-grid">
                                    <button class="def-btn def-btn-success text-white" onclick="showModal3();"><i class="bi bi-person-fill-check text-white fs-4"></i>&nbsp;&nbsp;Verification Pool</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 p-4 p-lg-4 pt-3">
                            <div class="row g-1">
                                <!-- Academic officer search area -->
                                <div class="col-12 col-lg-7 p-3">
                                    <div class="def-card p-2">
                                        <div class="row">
                                            <div class="col-12 text-center pt-2 pb-2 border-bottom">
                                                <h2>All Academic Officers</h2>
                                            </div>
                                            <!-- Search area -->
                                            <div class="col-12 pt-3">
                                                <div class="row g-0 g-md-1">
                                                    <div class="offset-0 offset-md-1 offset-lg-1 col-10 col-md-7 col-lg-7 ps-4 ps-md-0 ps-lg-0">
                                                        <div class="input-group mb-3">
                                                            <input type="text" class="def-input bg-white" aria-label="Text input with dropdown button" placeholder="Search by name..." style="width: 65%;" id="search-text">
                                                            <select class="def-btn def-btn-primary dropdown-toggle text-white" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 35%;" id="search-by">
                                                                <option value="0">Search By</option>
                                                                <option value="1">Verifed</option>
                                                                <option value="2">Unverifed</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-3 d-none d-md-block d-lg-block d-grid">
                                                        <button class="def-btn def-btn-primary text-white" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" onclick="officerSearch();"><i class="bi bi-search text-white"></i>&nbsp;&nbsp;Search</button>
                                                    </div>
                                                    <div class="col-2 d-block d-md-none d-lg-none">
                                                        <button class="def-btn def-btn-primary text-white" onclick="officerSearch();"><i class="bi bi-search text-white"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Search result load area -->
                                            <div class="col-12 ps-2 pe-2">
                                                <div class="row pt-5 ps-5 pe-5">
                                                    <div class="collapse" id="collapseExample">
                                                        <div class="col-12 mb-3">
                                                            <div class="row" id="officer-search-result-loader">
                                                                <div class="col-6 col-lg-12 pt-5 pb-5 def-card mb-3 bg-white text-center">
                                                                    <span>No Results</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <hr>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Search result load area -->
                                            <!-- Search area -->
                                            <div class="col-12 p-2">
                                                <div class="row pt-5 ps-5 pe-5" id="officer-card-loader">
                                                    <?php
                                                    if (isset($_GET["page"])) {
                                                        $pageNo = $_GET["page"];
                                                    } else {
                                                        $pageNo = 1;
                                                    }

                                                    $query = "SELECT * FROM `teacher` WHERE `user_type`='2'";

                                                    $officerResultset = Database::search($query);
                                                    $officerRownumber = $officerResultset->num_rows;

                                                    if ($officerRownumber < 1) {
                                                    ?>
                                                        <!-- Academic officer empty card -->
                                                        <div class="col-12 pb-3">
                                                            <div class="col-6 col-lg-12 pt-5 pb-5 def-card bg-white text-center">
                                                                <span>No Results</span>
                                                            </div>
                                                        </div>
                                                        <!-- Academic officer empty card -->
                                                        <?php
                                                    } else {
                                                        $resultsPerPage = 5;
                                                        $numberOfPage = ceil($officerRownumber / $resultsPerPage);

                                                        $pageResults = ($pageNo - 1) * $resultsPerPage;
                                                        $selectedResultset = Database::search($query . " LIMIT " . $resultsPerPage . " OFFSET " . $pageResults);
                                                        $selectedRownumber = $selectedResultset->num_rows;

                                                        for ($x = 0; $x < $selectedRownumber; $x++) {
                                                            $selectedData = $selectedResultset->fetch_assoc();
                                                            $officerProfileResultset = Database::search("SELECT * FROM `teacher_profile_image` WHERE `teacher_email`='" . $selectedData["email"] . "'");
                                                        ?>
                                                            <!-- Academic officer card -->
                                                            <div class="col-6 col-lg-12 p-2">
                                                                <div class="col-12 p-1 def-card bg-white card-animate" onclick="viewOfficerDetail('<?php echo ($selectedData['email']); ?>');">
                                                                    <div class="row g-0">
                                                                        <?php
                                                                        $officerProfileRownumber = $officerProfileResultset->num_rows;
                                                                        if ($officerProfileRownumber == 1) {
                                                                            $officerProfileData = $officerProfileResultset->fetch_assoc();
                                                                        ?>
                                                                            <div class="col-md-3 d-flex flex-row justify-content-start align-items-center">
                                                                                <img src="<?php echo ($officerProfileData["path"]); ?>" class="img-fluid p-2" style="height:90px;width:120px;border-radius: 24px;">
                                                                            </div>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <div class="col-md-3 d-flex flex-row justify-content-center align-items-center">
                                                                                <img src="resources/images/user.svg" class="img-fluid p-2" style="height:80px;border-radius: 24px;">
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <div class="col-md-9 ps-2">
                                                                            <div class="card-body p-1">
                                                                                <h5 class="card-title mt-1"><?php echo ($selectedData["first_name"] . " " . $selectedData["last_name"]);
                                                                                                            if ($selectedData["verify_status"] == 1) {
                                                                                                            ?>
                                                                                        <i class="bi bi-patch-check-fill fs-6 fw-bold" data-bs-toggle="tooltip" id="tooltip" data-bs-placement="right" title="Verifed Teacher" style="color: #27da77;"></i>
                                                                                    <?php
                                                                                                            }
                                                                                    ?>
                                                                                </h5>
                                                                                <h5 class="card-title fs-6 pb-2 text-primary"><?php echo ($selectedData["email"]); ?></i></h5>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Academic officer card -->
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
                                <!-- Academic officer search area -->
                                <!-- Academic officer empty detail area -->
                                <div class="col-12 col-lg-5 p-3">
                                    <div class="row ps-2 pe-2 pb-2">
                                        <div class="col-12 def-card">
                                            <div class="row" id="officer-detail-loader">
                                                <div class="col-12 text-center pt-2 pb-2 border-bottom">
                                                    <h2>Officer Detail</h2>
                                                </div>
                                                <div class="col-12 pt-3 pb-3 d-flex flex-row justify-content-center align-items-center">
                                                    <div class="col-12 p-3 bg-white d-flex flex-row justify-content-center align-items-center" style="border-radius: 100%;height:120px;width:120px;box-shadow: 0px 2px 3px 1px rgba(19, 70, 129, 0.5);">
                                                        <img src="resources/images/user.svg" class="img-fluid border-1" style="height:80px;width:80px;" />
                                                    </div>
                                                </div>
                                                <div class="col-12 text-center">
                                                    <span class="text-black text-capitalize fs-5" data-bs-toggle="tooltip" id="tooltip" data-bs-placement="right" title="Verifed" style="font-family: 'quicksand-bold';">Officer Name</span>
                                                </div>
                                                <div class="offset-4 col-4 d-grid pt-2 pb-1">
                                                    <button class="def-btn def-btn-danger text-white" disabled><i class="bi bi-exclamation-circle text-white"></i>&nbsp;&nbsp;Block</button>
                                                </div>
                                                <div class="col-12 ps-4 pe-4 mt-5 pb-3">
                                                    <div class="row g-1">
                                                        <div class="col-12 p-2">
                                                            <div class="row">
                                                                <div class="col-5">
                                                                    <span class="form-label" style="font-family: 'quicksand-bold';">First Name : </span>
                                                                </div>
                                                                <div class="col-7">
                                                                    <span class="badge rounded-pill" style="width:50%;padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-image: linear-gradient(24deg, #3972eb, #59ccfa);">&nbsp;</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 p-2">
                                                            <div class="row">
                                                                <div class="col-5">
                                                                    <span class="form-label" style="font-family: 'quicksand-bold';">Last Name : </span>
                                                                </div>
                                                                <div class="col-7">
                                                                    <span class="badge rounded-pill" style="width:50%;padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-image: linear-gradient(24deg, #3972eb, #59ccfa);">&nbsp;</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 p-2">
                                                            <div class="row">
                                                                <div class="col-5">
                                                                    <span class="form-label" style="font-family: 'quicksand-bold';">Mobile : </span>
                                                                </div>
                                                                <div class="col-7">
                                                                    <span class="badge rounded-pill" style="width:50%;padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-image: linear-gradient(24deg, #3972eb, #59ccfa);">&nbsp;</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 p-2">
                                                            <div class="row">
                                                                <div class="col-5">
                                                                    <span class="form-label" style="font-family: 'quicksand-bold';">Email : </span>
                                                                </div>
                                                                <div class="col-7">
                                                                    <span class="badge rounded-pill" style="width:50%;padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-image: linear-gradient(24deg, #3972eb, #59ccfa);">&nbsp;</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 p-2">
                                                            <div class="row">
                                                                <div class="col-5">
                                                                    <span class="form-label" style="font-family: 'quicksand-bold';">Registered Date : </span>
                                                                </div>
                                                                <div class="col-7">
                                                                    <span class="badge rounded-pill" style="width:50%;padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-image: linear-gradient(24deg, #3972eb, #59ccfa);">&nbsp;</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 p-2">
                                                            <div class="row">
                                                                <div class="col-5">
                                                                    <span class="form-label" style="font-family: 'quicksand-bold';">Address : </span>
                                                                </div>
                                                                <div class="col-7">
                                                                    <span class="badge rounded-pill" style="width:50%;padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-image: linear-gradient(24deg, #3972eb, #59ccfa);">&nbsp;</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 p-2">
                                                            <div class="row">
                                                                <div class="col-5">
                                                                    <span class="form-label" style="font-family: 'quicksand-bold';">Province : </span>
                                                                </div>
                                                                <div class="col-7">
                                                                    <span class="badge rounded-pill" style="width:50%;padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-image: linear-gradient(24deg, #3972eb, #59ccfa);">&nbsp;</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 p-2">
                                                            <div class="row">
                                                                <div class="col-5">
                                                                    <span class="form-label" style="font-family: 'quicksand-bold';">District : </span>
                                                                </div>
                                                                <div class="col-7">
                                                                    <span class="badge rounded-pill" style="width:50%;padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-image: linear-gradient(24deg, #3972eb, #59ccfa);">&nbsp;</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 p-2">
                                                            <div class="row">
                                                                <div class="col-5">
                                                                    <span class="form-label" style="font-family: 'quicksand-bold';">City : </span>
                                                                </div>
                                                                <div class="col-7">
                                                                    <span class="badge rounded-pill" style="width:50%;padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-image: linear-gradient(24deg, #3972eb, #59ccfa);">&nbsp;</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 p-2">
                                                            <div class="row">
                                                                <div class="col-5">
                                                                    <span class="form-label" style="font-family: 'quicksand-bold';">Postal Code : </span>
                                                                </div>
                                                                <div class="col-7">
                                                                    <span class="badge rounded-pill" style="width:50%;padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-image: linear-gradient(24deg, #3972eb, #59ccfa);">&nbsp;</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Academic officer empty area -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- main content area -->
                <!-- Academic officer invite modal -->
                <div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal2">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content def-card border-0" id="invite-modal-loader">
                            <div class="text-center pt-1 pb-2">
                                <h5 class="modal-title mt-2 fs-3">Invite Academic Officer</h5>
                            </div>
                            <div class="modal-body mt-2 pb-2">
                                <div class="row g-1 ps-2 pe-2 pb-3">
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
                                    <div class="col-12 pt-1">
                                        <span style="font-size: 13px;color: #f81919" id="error-text-loader"></span>
                                    </div>
                                    <div class="col-12 pt-2">
                                        <span style="font-size: 13px;"><i class="bi bi-info-circle"></i>&nbsp;&nbsp;After sending the invitation, the officer's <i style="font-size: 13px;" class="text-primary">username</i>, <i style="font-size: 13px;" class="text-primary">password</i> and<br /><i class="text-primary" style="font-size: 13px;">one-time code</i> will be <span class="text-primary">automatically generated</span> and sent to the respective Officer.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="def-btn def-btn-body text-black" type="button" data-bs-dismiss="modal">Cancle</button>
                                <button class="def-btn def-btn-primary text-white" type="button" onclick="sendOfficerInvitation();">Send Invitation</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Academic officer invite modal -->
                <!-- Academic officer verification pool -->
                <div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal3">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content def-card border-0" id="verify-loader">
                            <div class="text-center pt-1 pb-2">
                                <h5 class="modal-title mt-2 fs-3">Academic Officer Verification Pool</h5>
                            </div>
                            <div class="modal-body mt-2 pb-2">
                                <div class="row g-1 ps-3 pe-3 pb-3" id="new_verify_officer_loader">
                                    <div class="def-card p-2 bg-white mb-1">
                                        <div class="row">
                                            <div class="col-2 my-auto ps-3">
                                                <span style="font-family: 'quicksand-bold';">Profile</span><br />
                                            </div>
                                            <div class="col-4 my-auto">
                                                <span style="font-family: 'quicksand-bold';">Officer Detail</span><br />
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
                                    $OfficerVerifyResultset = Database::search("SELECT * FROM `teacher` INNER JOIN `unique_code` ON
                                    teacher.email=unique_code.teacher_email WHERE `user_type`='2' AND `verify_status`='2'");
                                    $OfficerVerifyRownumber = $OfficerVerifyResultset->num_rows;

                                    if ($OfficerVerifyRownumber == 0) {
                                    ?>
                                        <!-- Academic officer verify empty card -->
                                        <div class="def-card ps-3 pe-3 pt-5 pb-5 bg-white mb-2 text-center">
                                            <span>No Results</span>
                                        </div>
                                        <!-- Academic officer verify empty card -->
                                        <?php
                                    } else {
                                        for ($v = 0; $v < $OfficerVerifyRownumber; $v++) {
                                            $OfficerVerifyData = $OfficerVerifyResultset->fetch_assoc();
                                        ?>
                                            <!-- Academic officer verify card -->
                                            <div class="def-card p-3 bg-white mb-2">
                                                <div class="row">
                                                    <div class="col-2 bg-white d-flex flex-row justify-content-center align-items-center">
                                                        <?php
                                                        $OfficerVerifyProfileResultset = Database::search("SELECT * FROM `teacher_profile_image` WHERE `teacher_email`='" . $OfficerVerifyData["email"] . "'");
                                                        $OfficerVerifyProfileRownumber = $OfficerVerifyProfileResultset->num_rows;
                                                        if ($OfficerVerifyProfileRownumber > 0) {
                                                            $OfficerVerifyProfileData = $OfficerVerifyProfileResultset->fetch_assoc();
                                                        ?>
                                                            <img src="<?php echo ($OfficerVerifyProfileData["path"]); ?>" class="img-thumbnail border-0 p-1" style="border-radius: 100%;height:55px;width:60px;box-shadow: 0px 2px 3px 1px rgba(19, 70, 129, 0.5);background-size: contain;" />
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
                                                        <span style="font-family: 'quicksand-bold';"><?php echo ($OfficerVerifyData["first_name"] . " " . $OfficerVerifyData["last_name"]); ?></span><br />
                                                        <span class="text-primary" style="font-size: 11px;"><?php echo ($OfficerVerifyData["email"]); ?></span>
                                                    </div>
                                                    <div class="col-3 my-auto">
                                                        <?php
                                                        if ($OfficerVerifyData["status"] == 1) {
                                                        ?>
                                                            <span class="badge rounded-pill text-black fs-6 fw-light" style="padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#fbff00;"><i class="bi bi-check"></i>&nbsp;Pending</span>
                                                        <?php
                                                        } else if ($OfficerVerifyData["status"] == 2) {
                                                        ?>
                                                            <span class="badge rounded-pill text-white fs-6 fw-light" style="font-family:'quicksand-regular';padding-left: 11px;padding-right:11px;padding-top:4px;padding: bottom 4px;background-color:#2c99c4;"><i class="bi bi-check-all text-white"></i>&nbsp;Accepted</span>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="col-3 d-grid">
                                                        <?php
                                                        if ($OfficerVerifyData["status"] == 1 && $OfficerVerifyData["verify_status"] == 2) {
                                                        ?>
                                                            <button class="def-btn def-btn-body text-black-50" disabled><i class="bi bi-check-circle text-black-50"></i>&nbsp;Verify</button>
                                                            <?Php
                                                        } else {
                                                            ?>
                                                            <button class="def-btn def-btn-success text-white" onclick="verifyNewOfficer('<?php echo($OfficerVerifyData['email']); ?>');"><i class="bi bi-check-circle text-white"></i>&nbsp;Verify</button>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Academic officer verify card -->
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="def-btn def-btn-primary text-white" type="button" data-bs-dismiss="modal" onclick="loadOfficers();">Done</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Academic officer verification pool -->
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