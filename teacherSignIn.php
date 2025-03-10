<?php
if (isset($_GET["code"])) {
    $code = $_GET["code"];
    if ($code == "include") {
?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Teacher SignIn - Online Student Management System</title>
            <link rel="stylesheet" href="bootstrap.css" />
            <link rel="stylesheet" href="style.css" />
            <link rel="icon" type="image/x-icon" href="resources/images/favicon.ico" />
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
        </head>

        <body style="background-image: linear-gradient(24deg, #3972eb, #59ccfa);background-repeat: no-repeat;height: 100vh;">

            <div class="container-fluid">
                <div class="row">
                    <div class="offset-0 offset-lg-1 col-12 col-lg-10 pt-4 pt-lg-5">
                        <div class="row">
                            <div class="offset-lg-2 offset-1 col-10 col-lg-8">
                                <div class="row d-flex flex-row justify-content-center">
                                    <div class="col-2 col-lg-2 pt-2 pb-2 ps-2 mt-1 mt-lg-3 d-flex flex-row justify-content-end">
                                        <img class="img-fluid" src="resources/images/logo.png" style="height: 60px;" />
                                    </div>
                                    <div class="col-10 col-lg-10 d-flex flex-row align-items-center justify-content-start mt-1 mt-lg-3">
                                        <h1 class="text-white" style="font-family: 'barlow-bold';font-size:40px;text-shadow: 0px 3px 2px rgba(19, 70, 129, 0.3);">Online Student Management system</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="offset-lg-2 offset-1 col-10 col-lg-8 def-card pt-3 ps-2 pe-2 pb-3 mt-5">
                                <div class="row g-1">
                                    <div class="col-12 text-center border-bottom">
                                        <h2 class="pb-2">Teacher SignIn</h2>
                                    </div>
                                    <div class="col-12 p-2 mt-2">
                                        <div class="row">
                                            <div class="offset-0 offset-lg-1 col-12 col-lg-10 mt-2">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <span class="form-label fs-5">Username</span>
                                                    </div>
                                                    <div class="col-12 d-grid">
                                                        <input class="def-input" type="text" id="username" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="offset-0 offset-lg-1 col-12 col-lg-10 mt-2">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <span class="form-label fs-5">Password</span>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row g-2">
                                                            <div class="col-10 d-grid">
                                                                <input class="def-input" type="password" id="password" />
                                                            </div>
                                                            <div class="col-2 d-grid">
                                                                <button class="def-btn def-btn-primary" onclick="hiddenPassword();"><i class="bi bi-eye-slash-fill text-white" id="pass-icon"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="offset-0 offset-lg-1 col-12 col-lg-4 mt-2">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <span class="form-label fs-5">One-Time Code</span>
                                                    </div>
                                                    <div class="col-12 d-grid">
                                                        <input class="def-input" type="text" id="one-time-code" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="offset-0 offset-lg-1 col-12 col-lg-10 mt-2" style="height: 15px;">
                                                <span class="form-label" style="color: #f81919;font-size: 13px;" id="error-text"></span>
                                            </div>
                                            <div class="offset-0 offset-lg-4 col-12 col-lg-4 d-grid mt-3">
                                                <button class="def-btn def-btn-primary text-white" onclick="teacherFirstSignIn();">SignIn</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center fixed-bottom pb-3">
                                <span class="text-white" style="opacity: 0.9;">&copy; 2022 OSMS | All Rights Reserved</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script src="script.js"></script>
            <script src="bootstrap.bundle.js"></script>
        </body>

        </html>
    <?php
    } else {
        echo ("Something Went Wrong");
    }
} else {
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Teacher SignIn - Online Student Management System</title>
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="style.css" />
        <link rel="icon" type="image/x-icon" href="resources/images/favicon.ico" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    </head>

    <body style="background-image: linear-gradient(24deg, #3972eb, #59ccfa);background-repeat: no-repeat;height: 100vh;">

        <div class="container-fluid">
            <div class="row">
                <div class="offset-0 offset-lg-1 col-12 col-lg-10 pt-4 pt-lg-5">
                    <div class="row">
                        <div class="offset-lg-2 offset-1 col-10 col-lg-8">
                            <div class="row d-flex flex-row justify-content-center">
                                <div class="col-2 col-lg-2 pt-2 pb-2 ps-2 mt-1 mt-lg-3 d-flex flex-row justify-content-end">
                                    <img class="img-fluid" src="resources/images/logo.png" style="height: 60px;" />
                                </div>
                                <div class="col-10 col-lg-10 d-flex flex-row align-items-center justify-content-start mt-1 mt-lg-3">
                                    <h1 class="text-white" style="font-family: 'barlow-bold';font-size:40px;text-shadow: 0px 3px 2px rgba(19, 70, 129, 0.3);">Online Student Management system</h1>
                                </div>
                            </div>
                        </div>
                        <div class="offset-lg-2 offset-1 col-10 col-lg-8 def-card pt-3 ps-2 pe-2 pb-3 mt-5">
                            <div class="row g-1">
                                <div class="col-12 text-center border-bottom">
                                    <h2 class="pb-2">Teacher SignIn</h2>
                                </div>
                                <!-- Teacher signin content  -->
                                <div class="col-12 p-2 mt-2" id="techer-signin-content">
                                    <div class="row">
                                        <div class="offset-0 offset-lg-1 col-12 col-lg-10 mt-2">
                                            <div class="row">
                                                <div class="col-12">
                                                    <span class="form-label fs-5">Username</span>
                                                </div>
                                                <div class="col-12 d-grid">
                                                    <?php
                                                    if (isset($_COOKIE["username"])) {
                                                    ?>
                                                        <input class="def-input" type="text" value="<?php echo ($_COOKIE["username"]); ?>" id="username2" />
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <input class="def-input" type="text" id="username2" />
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="offset-0 offset-lg-1 col-12 col-lg-10 mt-2">
                                            <div class="row">
                                                <div class="col-12">
                                                    <span class="form-label fs-5">Password</span>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row g-2">
                                                        <div class="col-10 d-grid">
                                                            <?php
                                                            if (isset($_COOKIE["password"])) {
                                                            ?>
                                                                <input class="def-input" type="password" value="<?php echo ($_COOKIE["password"]); ?>" id="password2" />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <input class="def-input" type="password" id="password2" />
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="col-2 d-grid">
                                                            <button class="def-btn def-btn-primary" onclick="hiddenPassword2();"><i class="bi bi-eye-slash-fill text-white" id="pass-icon2"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="offset-0 offset-lg-1 col-12 col-lg-10 mt-2" style="height: 15px;">
                                            <span class="form-label" style="color: #f81919;font-size: 13px;" id="error-text2"></span>
                                        </div>
                                        <div class="offset-0 offset-lg-1 col-12 col-lg-10 mt-2">
                                            <div class="row pt-2">
                                                <div class="col-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="remember-me">
                                                        <label class="form-check-label" for="remember-me">Remember Me</label>
                                                    </div>
                                                </div>
                                                <div class="col-6 text-end">
                                                    <a href="#" class="link text-decoration-none" onclick="teacherPasswordVerify();">Forgot Password</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="offset-0 offset-lg-4 col-12 col-lg-4 d-grid mt-3">
                                            <button class="def-btn def-btn-primary text-white" onclick="teacherSignIn();">SignIn</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Teacher signin content -->
                                <!-- verify content -->
                                <div class="col-12 p-2 mt-2 d-none" id="verify">
                                    <div class="row">
                                        <div class="offset-0 offset-lg-1 col-5 col-md-6 col-lg-5 mt-2">
                                            <div class="row">
                                                <div class="col-12">
                                                    <span class="form-label fs-5">New Password</span>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row g-2">
                                                        <div class="col-10 d-grid">
                                                            <input class="def-input" type="password" id="password3" />
                                                        </div>
                                                        <div class="col-2 d-grid">
                                                            <button class="def-btn def-btn-primary" onclick="hiddenPassword3();"><i class="bi bi-eye-slash-fill text-white" id="pass-icon3"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-5 offset-1 offset-md-0 offset-lg-0 col-5 col-md-6 col-lg-5 mt-2">
                                            <div class="row">
                                                <div class="col-12">
                                                    <span class="form-label fs-5">Retype Password</span>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row g-2">
                                                        <div class="col-10 d-grid">
                                                            <input class="def-input" type="password" id="password4" />
                                                        </div>
                                                        <div class="col-2 d-grid">
                                                            <button class="def-btn def-btn-primary" onclick="hiddenPassword4();"><i class="bi bi-eye-slash-fill text-white" id="pass-icon4"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="offset-0 offset-lg-1 col-12 col-lg-10 d-grid mt-2">
                                            <span class="form-label fs-5">Enter Verification Code</span>
                                            <input class="def-input" type="text" id="verificationcode" placeholder="6 characters" />
                                        </div>
                                        <div class="offset-0 offset-lg-1 col-12 col-lg-10 pb-1">
                                            <div class="col-12 text-end pe-3 d-flex flex-row align-items-start justify-content-start" style="height: 15px;">
                                                <span class="form-label mt-1" style="color: #f81919;font-size: 13px;" id="error-text3"></span>
                                            </div>
                                        </div>
                                        <div class="offset-0 offset-lg-1 col-12 col-lg-10 d-grid mt-2 mt-lg-3">
                                            <button class="def-btn def-btn-primary text-white" onclick="teacherAddPasswordVerify();">Verify</button>
                                        </div>
                                        <div class="offset-0 offset-lg-1 col-12 col-lg-10 d-grid mt-2 mt-lg-3">
                                            <button class="def-btn def-btn-body text-black-50" onclick="changeView2();">Try Again</button>
                                        </div>
                                    </div>
                                    <!-- verify content -->
                                </div>
                            </div>
                            <div class="col-12 text-center fixed-bottom pb-3">
                                <span class="text-white" style="opacity: 0.9;">&copy; 2022 OSMS | All Rights Reserved</span>
                            </div>
                        </div>
                    </div>
                </div>
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

            <script src="script.js"></script>
            <script src="bootstrap.bundle.js"></script>
    </body>

    </html>
<?php
}
?>