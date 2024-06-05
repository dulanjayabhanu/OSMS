<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin SignIn - Online Student Management System</title>
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" type="image/x-icon" href="resources/images/favicon.ico" />
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
                    <div class="offset-lg-2 offset-1 col-10 col-lg-8 def-card p-5 mt-5">
                        <div class="row g-1">
                            <div class="col-12 text-center border-bottom">
                                <h2 class="pb-2">Admin SignIn</h2>
                            </div>
                            <!-- send verification content -->
                            <div class="col-12 p-2 mt-2" id="send-verification">
                                <div class="row">
                                    <div class="col-12">
                                        <span class="form-label fs-5">Email</span>
                                        <div class="col-12 col-md-12 col-lg-8 text-end pe-3 d-flex flex-row align-items-start justify-content-end" style="height: 15px;">
                                            <span class="form-label" style="color: #f81919;font-size: 11px;" id="error-text1"></span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-8 d-grid mt-2">
                                        <input class="def-input" type="email" placeholder="ex : john@gmail.com" id="email"/>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-4 d-grid mt-2">
                                        <button class="def-btn def-btn-primary text-white" onclick="adminVerification();">Send Verification Code</button>
                                    </div>
                                </div>
                            </div>
                            <!-- send verification content -->
                            <!-- verify content -->
                            <div class="col-12 p-2 mt-2 d-none" id="verify">
                                <div class="row">
                                    <div class="col-12 text-center text-lg-start">
                                        <span class="form-label fs-5">Enter Verification Code</span>
                                        <div class="col-12 text-end pe-3 d-flex flex-row align-items-start justify-content-end" style="height: 15px;">
                                            <span class="form-label" style="color: #f81919;font-size: 11px;" id="error-text2"></span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-12 d-grid mt-2">
                                        <input class="def-input" type="text" id="verificationcode" placeholder="6 characters"/>
                                    </div>
                                    <div class="col-12 col-lg-6 d-grid mt-2 mt-lg-3">
                                        <button class="def-btn def-btn-primary text-white" onclick="verify();">Verify</button>
                                    </div>
                                    <div class="col-12 col-lg-6 d-grid mt-2 mt-lg-3">
                                        <button class="def-btn def-btn-body text-black-50" onclick="changeView();">Try Again</button>
                                    </div>
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
    </div>

    <script src="script.js"></script>
    <script src="bootstrap.bundle.js"></script>
</body>

</html>