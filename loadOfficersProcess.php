<?php
require "connection.php";

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