function showToast() {
    var toastLiveExample = document.getElementById('liveToast');
    var toast = new bootstrap.Toast(toastLiveExample);
    toast.show();
}

var newModal;

function showModal1() {
    var modal = document.getElementById("modal1");
    newModal = new bootstrap.Modal(modal);
    newModal.show();
}

var newModal2;

function showModal2() {
    var modal = document.getElementById("modal2");
    newModal2 = new bootstrap.Modal(modal);
    newModal2.show();
}

var newModal3;

function showModal3() {
    var modal = document.getElementById("modal3");
    newModal3 = new bootstrap.Modal(modal);
    newModal3.show();
}

function hiddenPassword() {
    var passowrd = document.getElementById("password");
    var passIcon = document.getElementById("pass-icon");

    if (passowrd.type == "password" & passowrd.value != "") {
        passowrd.type = "text";
        passIcon.classList = "bi bi-eye-fill text-white";
    } else if (passowrd.type == "text") {
        passowrd.type = "password";
        passIcon.classList = "bi bi-eye-slash-fill text-white";
    }
}

function hiddenPassword2() {
    var passowrd = document.getElementById("password2");
    var passIcon = document.getElementById("pass-icon2");

    if (passowrd.type == "password" & passowrd.value != "") {
        passowrd.type = "text";
        passIcon.classList = "bi bi-eye-fill text-white";
    } else if (passowrd.type == "text") {
        passowrd.type = "password";
        passIcon.classList = "bi bi-eye-slash-fill text-white";
    }
}

function hiddenPassword3() {
    var passowrd = document.getElementById("password3");
    var passIcon = document.getElementById("pass-icon3");

    if (passowrd.type == "password" & passowrd.value != "") {
        passowrd.type = "text";
        passIcon.classList = "bi bi-eye-fill text-white";
    } else if (passowrd.type == "text") {
        passowrd.type = "password";
        passIcon.classList = "bi bi-eye-slash-fill text-white";
    }
}

function hiddenPassword4() {
    var passowrd = document.getElementById("password4");
    var passIcon = document.getElementById("pass-icon4");

    if (passowrd.type == "password" & passowrd.value != "") {
        passowrd.type = "text";
        passIcon.classList = "bi bi-eye-fill text-white";
    } else if (passowrd.type == "text") {
        passowrd.type = "password";
        passIcon.classList = "bi bi-eye-slash-fill text-white";
    }
}

function showAddNewCard() {
    var addNewLoader1 = document.getElementById("add-new-loader1");
    var addNewLoader2 = document.getElementById("add-new-loader2");

    addNewLoader1.classList.toggle("d-none");
    addNewLoader2.classList.toggle("d-none");
}

function adminVerification() {
    var email = document.getElementById("email");

    var form = new FormData();
    form.append("email", email.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                changeView();
            } else {
                var errorText = document.getElementById("error-text1");
                errorText.innerHTML = "* " + text;
            }
        }
    };

    request.open("POST", "adminVerificationProcess.php", true);
    request.send(form);
}

function changeView() {
    var sendVerification = document.getElementById("send-verification");
    var verify = document.getElementById("verify");

    sendVerification.classList.toggle("d-none");
    verify.classList.toggle("d-none");
}

function changeView2() {
    var teacherSigninContent = document.getElementById("techer-signin-content");
    var verify = document.getElementById("verify");

    teacherSigninContent.classList.toggle("d-none");
    verify.classList.toggle("d-none");
}

function verify() {
    var verificationcode = document.getElementById("verificationcode");

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                window.location = "adminPanel.php";
            } else {
                var errorText = document.getElementById("error-text2");
                errorText.innerHTML = "* " + text;
            }
        }
    };

    request.open("GET", "verifyProcess.php?vcode=" + verificationcode.value, true);
    request.send();
}

function changeProfileImage() {
    var imageUploader = document.getElementById("imageUploader");

    imageUploader.onchange = function() {
        var filecount = imageUploader.files.length;
        if (filecount == 1) {
            var file = this.files[0];
            var url = window.URL.createObjectURL(file);

            document.getElementById("image").src = url;
        }
    };
}

function updateProfile() {
    var fname = document.getElementById("fname");
    var lname = document.getElementById("lname");
    var mobile = document.getElementById("mobile");
    var imageUploader = document.getElementById("imageUploader");

    var form = new FormData();
    form.append("fname", fname.value);
    form.append("lname", lname.value);
    form.append("mobile", mobile.value);
    form.append("image", imageUploader.files[0]);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "profile updated") {
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = text;
                showToast();
            } else {
                document.getElementById("toast-icon").classList = "bi bi-exclamation-circle-fill fs-4 text-warning justify-content-start";
                document.getElementById("toast-body").innerHTML = text;
                showToast();
            }
        }
    };

    request.open("POST", "updateProfileProcess.php", true);
    request.send(form);
}

function viewTeacherDetail(email) {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            var teacherDetailLoader = document.getElementById("teacher-detail-loader");
            teacherDetailLoader.innerHTML = text;
        }
    };

    request.open("GET", "viewTeacherDetailProcess.php?email=" + email, true);
    request.send();
}

function viewOfficerDetail(email) {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            var officerDetailLoader = document.getElementById("officer-detail-loader");
            officerDetailLoader.innerHTML = text;
        }
    };

    request.open("GET", "viewOfficerDetailProcess.php?email=" + email, true);
    request.send();
}

function loadClassAndSubject(email) {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            var editeModelLader = document.getElementById("edite-modal-loader");
            editeModelLader.innerHTML = text;
            showModal1();
        }
    };

    request.open("GET", "loadClassAndSubjectProcess.php?email=" + email, true);
    request.send();
}

function saveAddNewCard(email) {
    var grade = document.getElementById("grade");
    var subject = document.getElementById("subject");

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            var subjectCard = document.createElement("div");
            subjectCard.classList = "col-6 col-md-4 col-lg-3 p-2";
            subjectCard.innerHTML = text;
            var subjectCardLoader = document.getElementById("class-and-subject-card-loader");
            subjectCardLoader.appendChild(subjectCard);
        }
    };

    request.open("GET", "saveAddNewCardProcess.php?subject=" + subject.value + "&grade=" + grade.value + "&email=" + email, true);
    request.send();
}

function loadTeachers() {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            var subjectCardLoader = document.getElementById("teacher-card-loader");
            subjectCardLoader.innerHTML = text;
            document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
            document.getElementById("toast-body").innerHTML = 'New Changes Added';
            newModal.hide();
            showToast();
        }
    };

    request.open("GET", "loadTeachersProcess.php", true);
    request.send();
}

function loadOfficers() {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            var subjectCardLoader = document.getElementById("officer-card-loader");
            subjectCardLoader.innerHTML = text;
            document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
            document.getElementById("toast-body").innerHTML = 'New Changes Added';
            newModal.hide();
            showToast();
        }
    };

    request.open("GET", "loadOfficersProcess.php", true);
    request.send();
}

function removeClassAndSubjectCard(id) {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            var classAndSubjectCardLoader = document.getElementById("class-and-subject-card-loader");
            classAndSubjectCardLoader.innerHTML = text;
        }
    };

    request.open("GET", "removeClassAndSubjectProcess.php?id=" + id, true);
    request.send();
}

function blockTeacher(email) {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "teacher blocked") {
                var blockBtn = document.getElementById("block-btn");
                blockBtn.classList = "def-btn def-btn-success text-white";
                blockBtn.innerHTML = "<i class='bi bi-check2-circle text-white'></i>&nbsp;&nbsp;Unblock";

            } else if (text == "teacher unblocked") {
                var blockBtn = document.getElementById("block-btn");
                blockBtn.classList = "def-btn def-btn-danger text-white";
                blockBtn.innerHTML = "<i class='bi bi-exclamation-circle text-white'></i>&nbsp;&nbsp;Block";
            } else {
                document.getElementById("toast-icon").classList = "bi bi-exclamation-circle-fill fs-4 text-warning justify-content-start";
                document.getElementById("toast-body").innerHTML = text;
                showToast();
            }
        }
    };

    request.open("GET", "blockTeacherProcess.php?email=" + email, true);
    request.send();
}

function blockOfficer(email) {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "officer blocked") {
                var blockBtn = document.getElementById("block-btn");
                blockBtn.classList = "def-btn def-btn-success text-white";
                blockBtn.innerHTML = "<i class='bi bi-check2-circle text-white'></i>&nbsp;&nbsp;Unblock";

            } else if (text == "officer unblocked") {
                var blockBtn = document.getElementById("block-btn");
                blockBtn.classList = "def-btn def-btn-danger text-white";
                blockBtn.innerHTML = "<i class='bi bi-exclamation-circle text-white'></i>&nbsp;&nbsp;Block";
            } else {
                document.getElementById("toast-icon").classList = "bi bi-exclamation-circle-fill fs-4 text-warning justify-content-start";
                document.getElementById("toast-body").innerHTML = text;
                showToast();
            }
        }
    };

    request.open("GET", "blockOfficerProcess.php?email=" + email, true);
    request.send();
}

function teacherSearch() {
    var searchText = document.getElementById("search-text");
    var searchBy = document.getElementById("search-by");

    var form = new FormData();
    form.append("searchText", searchText.value);
    form.append("searchBy", searchBy.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            var teacherSearchResultLoader = document.getElementById("teacher-search-result-loader");
            teacherSearchResultLoader.innerHTML = text;
        }
    };

    request.open("POST", "teacherSearchProcess.php", true);
    request.send(form);
}

function officerSearch() {
    var searchText = document.getElementById("search-text");
    var searchBy = document.getElementById("search-by");

    var form = new FormData();
    form.append("searchText", searchText.value);
    form.append("searchBy", searchBy.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            var teacherSearchResultLoader = document.getElementById("officer-search-result-loader");
            teacherSearchResultLoader.innerHTML = text;
        }
    };

    request.open("POST", "officerSearchProcess.php", true);
    request.send(form);
}

function sendTeacherInvitation() {
    var firstname = document.getElementById("inv-first-name");
    var lastname = document.getElementById("inv-last-name");
    var email = document.getElementById("inv-email");
    var mobile = document.getElementById("inv-mobile");
    var gender = document.getElementById("inv-gender");

    var form = new FormData();
    form.append("firstname", firstname.value);
    form.append("lastname", lastname.value);
    form.append("email", email.value);
    form.append("mobile", mobile.value);
    form.append("gender", gender.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                newModal2.hide();
                loadTeachers();
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = "Invitation Sent To The Teacher";
                showToast();
            } else {
                errorTextLoader = document.getElementById("error-text-loader");
                errorTextLoader.innerHTML = "*&nbsp;" + text;
            }
        }
    };

    request.open("POST", "sendTeacherInvitationProcess.php", true);
    request.send(form);
}

function sendOfficerInvitation() {
    var firstname = document.getElementById("inv-first-name");
    var lastname = document.getElementById("inv-last-name");
    var email = document.getElementById("inv-email");
    var mobile = document.getElementById("inv-mobile");
    var gender = document.getElementById("inv-gender");

    var form = new FormData();
    form.append("firstname", firstname.value);
    form.append("lastname", lastname.value);
    form.append("email", email.value);
    form.append("mobile", mobile.value);
    form.append("gender", gender.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                loadOfficers();
                newModal2.hide();
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = "Invitation Sent To The Academic Officer";
                showToast();
            } else {
                errorTextLoader = document.getElementById("error-text-loader");
                errorTextLoader.innerHTML = "*&nbsp;" + text;
            }
        }
    };

    request.open("POST", "sendOfficerInvitationProcess.php", true);
    request.send(form);
}

function verifyNewTeacher(email) {
    var form = new FormData();
    form.append("email", email);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                loadVerifyNewTeacher();
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = "The Teacher Verified";
                showToast();
            } else {
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = "The Teacher Verified";
                showToast();
            }
        }
    };

    request.open("POST", "verifyNewTeacherProcess.php", true);
    request.send(form);
}

function loadVerifyNewTeacher() {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            var newVerifyTeacherLoader = document.getElementById("new_verify_teacher_loader");
            newVerifyTeacherLoader.innerHTML = text;
        }
    };

    request.open("GET", "loadVerifyNewTeacherProcess.php", true);
    request.send();
}

function verifyNewOfficer(email) {
    var form = new FormData();
    form.append("email", email);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                loadVerifyNewOfficer();
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = "The Academic Officer Verified";
                showToast();
            } else {
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = "The Academic Officer Verified";
                showToast();
            }
        }
    };

    request.open("POST", "verifyNewOfficerProcess.php", true);
    request.send(form);
}

function loadVerifyNewOfficer() {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            var newVerifyTeacherLoader = document.getElementById("new_verify_officer_loader");
            newVerifyTeacherLoader.innerHTML = text;
        }
    };

    request.open("GET", "loadVerifyNewOfficerProcess.php", true);
    request.send();
}

function teacherFirstSignIn() {
    var username = document.getElementById("username");
    var password = document.getElementById("password");
    var oneTimeCode = document.getElementById("one-time-code");

    var form = new FormData();
    form.append("username", username.value);
    form.append("password", password.value);
    form.append("oneTimecode", oneTimeCode.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                window.location = "teacherDashboard.php";
            } else {
                var errorText = document.getElementById("error-text");
                errorText.innerHTML = "* " + text;
            }
        }
    };

    request.open("POST", "teacherFirstSigninProcess.php", true);
    request.send(form);

}

function officerFirstSignIn() {
    var username = document.getElementById("username");
    var password = document.getElementById("password");
    var oneTimeCode = document.getElementById("one-time-code");

    var form = new FormData();
    form.append("username", username.value);
    form.append("password", password.value);
    form.append("oneTimecode", oneTimeCode.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                window.location = "academicOfficerDashboard.php";
            } else {
                var errorText = document.getElementById("error-text");
                errorText.innerHTML = "* " + text;
            }
        }
    };

    request.open("POST", "officerFirstSigninProcess.php", true);
    request.send(form);

}

function teacherSignIn() {
    var username = document.getElementById("username2");
    var password = document.getElementById("password2");
    var rememberMe = document.getElementById("remember-me");

    var form = new FormData();
    form.append("username", username.value);
    form.append("password", password.value);
    form.append("rememberme", rememberMe.checked);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                window.location = "teacherDashboard.php";
            } else {
                var errorText = document.getElementById("error-text2");
                errorText.innerHTML = "* " + text;
            }
        }
    };

    request.open("POST", "teacherSigninProcess.php", true);
    request.send(form);

}

function officerSignIn() {
    var username = document.getElementById("username2");
    var password = document.getElementById("password2");
    var rememberMe = document.getElementById("remember-me");

    var form = new FormData();
    form.append("username", username.value);
    form.append("password", password.value);
    form.append("rememberme", rememberMe.checked);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                window.location = "academicOfficerDashboard.php";
            } else {
                var errorText = document.getElementById("error-text2");
                errorText.innerHTML = "* " + text;
            }
        }
    };

    request.open("POST", "officerSigninProcess.php", true);
    request.send(form);

}

function teacherPasswordVerify() {
    var username = document.getElementById("username2");

    var form = new FormData();
    form.append("username", username.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                changeView2();
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = "Verification Code Sent To Your Email";
                showToast();
            } else {
                var errorText = document.getElementById("error-text2");
                errorText.innerHTML = "* " + text;
            }
        }
    };

    request.open("POST", "teacherVerificationCodeSendProcess.php", true);
    request.send(form);
}

function officerPasswordVerify() {
    var username = document.getElementById("username2");

    var form = new FormData();
    form.append("username", username.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                changeView2();
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = "Verification Code Sent To Your Email";
                showToast();
            } else {
                var errorText = document.getElementById("error-text2");
                errorText.innerHTML = "* " + text;
            }
        }
    };

    request.open("POST", "officerVerificationCodeSendProcess.php", true);
    request.send(form);
}

function teacherAddPasswordVerify() {
    var username = document.getElementById("username2");
    var password3 = document.getElementById("password3");
    var password4 = document.getElementById("password4");
    var verificationCode = document.getElementById("verificationcode");

    var form = new FormData();
    form.append("username", username.value);
    form.append("newPassword", password3.value);
    form.append("retypePassword", password4.value);
    form.append("verificationCode", verificationCode.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                changeView2();
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = "Password Changed";
                showToast();
            } else {
                var errorText = document.getElementById("error-text3");
                errorText.innerHTML = "* " + text;
            }
        }
    };

    request.open("POST", "teacherChangePasswordProcess.php", true);
    request.send(form);
}

function officerAddPasswordVerify() {
    var username = document.getElementById("username2");
    var password3 = document.getElementById("password3");
    var password4 = document.getElementById("password4");
    var verificationCode = document.getElementById("verificationcode");

    var form = new FormData();
    form.append("username", username.value);
    form.append("newPassword", password3.value);
    form.append("retypePassword", password4.value);
    form.append("verificationCode", verificationCode.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                changeView2();
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = "Password Changed";
                showToast();
            } else {
                var errorText = document.getElementById("error-text3");
                errorText.innerHTML = "* " + text;
            }
        }
    };

    request.open("POST", "officerChangePasswordProcess.php", true);
    request.send(form);
}

function sendStudentInvitation() {
    var firstname = document.getElementById("inv-first-name");
    var lastname = document.getElementById("inv-last-name");
    var dateOfBirth = document.getElementById("inv-date-of-birth");
    var mobile = document.getElementById("inv-mobile");
    var gender = document.getElementById("inv-gender");
    var email = document.getElementById("inv-email");
    var clz = document.getElementById("inv-class");
    var medium = document.getElementById("inv-medium");
    var parentEmail = document.getElementById("inv-parent-email");
    var nationality = document.getElementById("inv-nationality");

    var form = new FormData();

    form.append("firstname", firstname.value);
    form.append("lastname", lastname.value);
    form.append("dateOfBirth", dateOfBirth.value);
    form.append("mobile", mobile.value);
    form.append("gender", gender.value);
    form.append("email", email.value);
    form.append("parentEmail", parentEmail.value);
    form.append("class", clz.value);
    form.append("medium", medium.value);
    form.append("nationality", nationality.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                newModal2.hide();
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = "Invitation Sent To The Student";
                showToast();
            } else {
                var errorTextLoader = document.getElementById("error-text-loader");
                errorTextLoader.innerHTML = "* " + text;
            }
        }
    };

    request.open("POST", "sendStudentInvitationProcess.php", true);
    request.send(form);
}

function loadAllStudents() {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            var allStudent = document.getElementById("all-student");
            allStudent.innerHTML = text;
        }
    };

    request.open("GET", "loadAllStudentsProcess.php", true);
    request.send();
}

function loadSummaryStudents() {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            var studentDetailLoader = document.getElementById("student-detail-loader");
            studentDetailLoader.innerHTML = text;
        }
    };

    request.open("GET", "loadSummaryStudentsProcess.php", true);
    request.send();
}

function verifyNewStudent(email) {
    var form = new FormData();
    form.append("email", email);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                loadVerifyNewStudent();
                loadAllStudents();
                loadSummaryStudents();
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = "Student Verified";
                showToast();
            } else {
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = text;
                showToast();
            }
        }
    };

    request.open("POST", "verifyNewStudentProcess.php?email=" + email, true);
    request.send(form);
}

function loadVerifyNewStudent() {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            var newVerifyStudentLoader = document.getElementById("new_verify_student_loader");
            newVerifyStudentLoader.innerHTML = text;
        }
    };

    request.open("GET", "loadVerifyNewStudentProcess.php", true);
    request.send();
}

function updateOfficerProfile() {
    var fname = document.getElementById("fname");
    var lname = document.getElementById("lname");
    var mobile = document.getElementById("mobile");
    var imageUploader = document.getElementById("imageUploader");

    var form = new FormData();
    form.append("fname", fname.value);
    form.append("lname", lname.value);
    form.append("mobile", mobile.value);
    form.append("image", imageUploader.files[0]);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "profile updated") {
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = text;
                showToast();
            } else {
                document.getElementById("toast-icon").classList = "bi bi-exclamation-circle-fill fs-4 text-warning justify-content-start";
                document.getElementById("toast-body").innerHTML = text;
                showToast();
            }
        }
    };

    request.open("POST", "updateOfficerProfileProcess.php", true);
    request.send(form);
}

function studentFirstSignIn() {
    var username = document.getElementById("username");
    var password = document.getElementById("password");
    var oneTimeCode = document.getElementById("one-time-code");

    var form = new FormData();
    form.append("username", username.value);
    form.append("password", password.value);
    form.append("oneTimecode", oneTimeCode.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                window.location = "studentDashboard.php";
            } else {
                var errorText = document.getElementById("error-text");
                errorText.innerHTML = "* " + text;
            }
        }
    };

    request.open("POST", "studentFirstSigninProcess.php", true);
    request.send(form);
}

function studentPasswordVerify() {
    var username = document.getElementById("username2");

    var form = new FormData();
    form.append("username", username.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                changeView2();
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = "Verification Code Sent To Your Email";
                showToast();
            } else {
                var errorText = document.getElementById("error-text2");
                errorText.innerHTML = "* " + text;
            }
        }
    };

    request.open("POST", "studentVerificationCodeSendProcess.php", true);
    request.send(form);
}

function studentAddPasswordVerify() {
    var username = document.getElementById("username2");
    var password3 = document.getElementById("password3");
    var password4 = document.getElementById("password4");
    var verificationCode = document.getElementById("verificationcode");

    var form = new FormData();
    form.append("username", username.value);
    form.append("newPassword", password3.value);
    form.append("retypePassword", password4.value);
    form.append("verificationCode", verificationCode.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                changeView2();
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = "Password Changed";
                showToast();
            } else {
                var errorText = document.getElementById("error-text3");
                errorText.innerHTML = "* " + text;
            }
        }
    };

    request.open("POST", "studentChangePasswordProcess.php", true);
    request.send(form);
}

function studentSignIn() {
    var username = document.getElementById("username2");
    var password = document.getElementById("password2");
    var rememberMe = document.getElementById("remember-me");

    var form = new FormData();
    form.append("username", username.value);
    form.append("password", password.value);
    form.append("rememberme", rememberMe.checked);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                window.location = "studentDashboard.php";
            } else {
                var errorText = document.getElementById("error-text2");
                errorText.innerHTML = "* " + text;
            }
        }
    };

    request.open("POST", "studentSigninProcess.php", true);
    request.send(form);

}

function changeFileView() {
    var doc = document.getElementById("doc");
    var fileUploader = document.getElementById("fileUploader");
    var updatedfile = document.getElementById("updatedfile");
    var fileName = document.getElementById("file-name");
    var docIcon = document.getElementById("doc-icon");

    doc.onchange = function() {
        if (doc.files.length > 0) {
            fileUploader.classList.toggle("d-none");
            updatedfile.classList.toggle("d-none");
            var fileType = doc.files[0].type;
            if (fileType == "application/pdf") {
                docIcon.classList = "bi bi-filetype-pdf fs-1";
                document.getElementById("error-text-loader2").innerHTML = "";
            } else if (fileType == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
                docIcon.classList = "bi bi-filetype-docx fs-1";
                document.getElementById("error-text-loader2").innerHTML = "";
            } else if (fileType == "text/plain") {
                docIcon.classList = "bi bi-filetype-txt fs-1";
                document.getElementById("error-text-loader2").innerHTML = "";
            } else {
                changeFileViewBack();
                document.getElementById("error-text-loader2").innerHTML = "* Unsupported File Type";
            }
            fileName.innerHTML = doc.files[0].name;
        }
    };
}

function changeFileView1() {
    var doc = document.getElementById("doc1");
    var fileUploader = document.getElementById("fileUploader1");
    var updatedfile = document.getElementById("updatedfile1");
    var fileName = document.getElementById("file-name1");
    var docIcon = document.getElementById("doc-icon1");

    doc.onchange = function() {
        if (doc.files.length > 0) {
            fileUploader.classList.toggle("d-none");
            updatedfile.classList.toggle("d-none");
            var fileType = doc.files[0].type;
            if (fileType == "application/pdf") {
                docIcon.classList = "bi bi-filetype-pdf fs-1";
                document.getElementById("error-text-loader1").innerHTML = "";
            } else if (fileType == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
                docIcon.classList = "bi bi-filetype-docx fs-1";
                document.getElementById("error-text-loader1").innerHTML = "";
            } else if (fileType == "text/plain") {
                docIcon.classList = "bi bi-filetype-txt fs-1";
                document.getElementById("error-text-loader1").innerHTML = "";
            } else {
                changeFileViewBack();
                document.getElementById("error-text-loader1").innerHTML = "* Unsupported File Type";
            }
            fileName.innerHTML = doc.files[0].name;
        }
    };
}

function changeFileViewBack1() {
    var fileUploader = document.getElementById("fileUploader1");
    var updatedfile = document.getElementById("updatedfile1");
    fileUploader.classList.toggle("d-none");
    updatedfile.classList.toggle("d-none");
}

function changeFileViewBack() {
    var fileUploader = document.getElementById("fileUploader");
    var updatedfile = document.getElementById("updatedfile");
    fileUploader.classList.toggle("d-none");
    updatedfile.classList.toggle("d-none");
}

function uploadAssignment() {
    var subject = document.getElementById("assignment-subject");
    var clz = document.getElementById("assignment-class");
    var deadline = document.getElementById("deadline");
    var doc = document.getElementById("doc");

    var form = new FormData();
    form.append("subject", subject.value);
    form.append("class", clz.value);
    form.append("deadline", deadline.value);
    form.append("doc", doc.files[0]);
    form.append("type", "1");

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "Assignment Uploaded") {
                newModal3.hide();
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = text;
                showToast();
            } else {
                document.getElementById("error-text-loader2").innerHTML = "*&nbsp;" + text;
            }
        }
    };

    request.open("POST", "assignmentUpload.php", true);
    request.send(form);
}

function uploadLesson() {
    var subject = document.getElementById("lesson-subject");
    var clz = document.getElementById("lesson-class");
    var doc = document.getElementById("doc1");

    var form = new FormData();
    form.append("subject", subject.value);
    form.append("class", clz.value);
    form.append("doc", doc.files[0]);
    form.append("type", "2");

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "Lesson Note Uploaded") {
                newModal2.hide();
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = text;
                showToast();
            } else {
                document.getElementById("error-text-loader1").innerHTML = "*&nbsp;" + text;
            }
        }
    };

    request.open("POST", "lessonUpload.php", true);
    request.send(form);
}

function updateTeacherProfile() {
    var fname = document.getElementById("fname");
    var lname = document.getElementById("lname");
    var mobile = document.getElementById("mobile");
    var imageUploader = document.getElementById("imageUploader");

    var form = new FormData();
    form.append("fname", fname.value);
    form.append("lname", lname.value);
    form.append("mobile", mobile.value);
    form.append("image", imageUploader.files[0]);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "profile updated") {
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = text;
                showToast();
            } else {
                document.getElementById("toast-icon").classList = "bi bi-exclamation-circle-fill fs-4 text-warning justify-content-start";
                document.getElementById("toast-body").innerHTML = text;
                showToast();
            }
        }
    };

    request.open("POST", "updateTeacherProfileProcess.php", true);
    request.send(form);
}

function lessonDetail(subject) {
    var form = new FormData();
    form.append("subject", subject);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            var studentCardLoader = document.getElementById("student-card-loader2");
            studentCardLoader.innerHTML = text;
        }
    };

    request.open("POST", "lessonLoadProcess.php", true);
    request.send(form);
}

function loadLessonModal(docSrc) {
    var form = new FormData();
    form.append("docSrc", docSrc);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            var lessonModalLoader = document.getElementById("lesson-modal-loader");
            lessonModalLoader.innerHTML = text;
            showModal2();
        }
    };

    request.open("POST", "loadLessonModalProcess.php", true);
    request.send(form);
}

function assignmentDetail(subject) {
    var form = new FormData();
    form.append("subject", subject);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            var studentCardLoader = document.getElementById("student-card-loader2");
            studentCardLoader.innerHTML = text;
        }
    };

    request.open("POST", "assignmentLoadProcess.php", true);
    request.send(form);
}

function updateStudentProfile() {
    var fname = document.getElementById("fname");
    var lname = document.getElementById("lname");
    var mobile = document.getElementById("mobile");
    var dateOfBirth = document.getElementById("date-of-birth");
    var line1 = document.getElementById("line1");
    var line2 = document.getElementById("line2");
    var city = document.getElementById("city");
    var district = document.getElementById("district");
    var province = document.getElementById("province");
    var postalcode = document.getElementById("postalcode");
    var parentFirstName = document.getElementById("parent-first-name");
    var parentLastName = document.getElementById("parent-last-name");
    var imageUploader = document.getElementById("imageUploader");

    var form = new FormData();
    form.append("fname", fname.value);
    form.append("lname", lname.value);
    form.append("dateOfBirth", dateOfBirth.value);
    form.append("line1", line1.value);
    form.append("line2", line2.value);
    form.append("city", city.value);
    form.append("district", district.value);
    form.append("province", province.value);
    form.append("postalCode", postalcode.value);
    form.append("parentFirstName", parentFirstName.value);
    form.append("parentLastName", parentLastName.value);
    form.append("mobile", mobile.value);
    form.append("image", imageUploader.files[0]);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "profile updated") {
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = text;
                showToast();
            } else {
                document.getElementById("toast-icon").classList = "bi bi-exclamation-circle-fill fs-4 text-warning justify-content-start";
                document.getElementById("toast-body").innerHTML = text;
                showToast();
            }
        }
    };

    request.open("POST", "updateStudentProfileProcess.php", true);
    request.send(form);
}

function loadAssignmentUploadModal(id) {
    var input = document.createElement("input");
    input.value = id;
    input.id = "assignment-id";
    input.classList = "d-none";
    document.getElementById("assignmentUploadLoader").appendChild(input);
    showModal3();
}

function uploadAnswers() {
    var doc = document.getElementById("doc1");
    var assignmentId = document.getElementById("assignment-id");

    var form = new FormData();
    form.append("doc", doc.files[0]);
    form.append("assignmentId", assignmentId.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "Answer Sheet Uploaded") {
                newModal3.hide();
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = text;
                showToast();
            } else {
                document.getElementById("error-text-loader1").innerHTML = "*&nbsp;" + text;
            }
        }
    };

    request.open("POST", "uploadAnswerProcess.php", true);
    request.send(form);
}

function loadCheckMarks(id) {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            var loadCheckMarkLoader = document.getElementById("load-check-marks-loader");
            loadCheckMarkLoader.innerHTML = text;
            showModal1();
        }
    };

    request.open("GET", "loadCheckMarksProcess.php?id=" + id, true);
    request.send();
}

function submitMarks(id, marks) {
    var assignmentMarks = document.getElementById(marks);

    var form = new FormData();
    form.append("marks", assignmentMarks.value);
    form.append("id", id);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "Marks Added") {
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = text;
                showToast();
            } else {
                document.getElementById("error-text-loader4").innerHTML = "*&nbsp;" + text;
            }
        }
    };

    request.open("POST", "submitMarksProcess.php", true);
    request.send(form);
}

function sendMarks(id) {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "Sent Marks To Academic Officer") {
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = text;
                showToast();
            } else {
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = text;
                showToast();
            }
        }
    };

    request.open("GET", "sendMarksProcess.php?id=" + id, true);
    request.send();
}

function releaseMarks(id) {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "Marks Released") {
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = text;
                showToast();
            } else {
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = text;
                showToast();
            }
        }
    };

    request.open("GET", "releaseMarksProcess.php?id=" + id, true);
    request.send();
}

function payNow(email) {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;

            var obj = JSON.parse(text);

            var id = obj["id"];
            var email1 = obj["email"];
            var amount = obj["amount"];

            if (text == "1") {
                alert("Please SignIn or SignUp");
                window.location = "studentDashboard.php";
            } else if (text == "2") {
                alert("Please Update Your Profile First");
                window.location = "studentProfile.php";
            } else {
                // Payment completed. It can be a successful failure.
                payhere.onCompleted = function onCompleted(orderId) {
                    saveInvoice(id, email, amount);
                    console.log("Payment completed. OrderID:" + orderId);
                    // Note: validate the payment and show success or failure page to the customer
                };

                // Payment window closed
                payhere.onDismissed = function onDismissed() {
                    // Note: Prompt user to pay again or show an error page
                    console.log("Payment dismissed");
                };

                // Error occurred
                payhere.onError = function onError(error) {
                    // Note: show an error page
                    console.log("Error:" + error);
                };

                // Put the payment variables here
                var payment = {
                    "sandbox": true,
                    "merchant_id": "1221943", // Merchant ID
                    "return_url": "http://localhost/osms/studentDashboard.php", // Important
                    "cancel_url": "http://localhost/osms/studentDashboard.php", // Important
                    "notify_url": "http://sample.com/notify",
                    "order_id": obj["id"],
                    "items": "Yearly Payment",
                    "amount": amount,
                    "currency": "LKR",
                    "first_name": obj["first_name"],
                    "last_name": obj["last_name"],
                    "email": email1,
                    "phone": obj["mobile"],
                    "address": obj["address"],
                    "city": obj["city"],
                    "country": "Sri Lanka",
                    "delivery_address": obj["address"],
                    "delivery_city": obj["city"],
                    "delivery_country": "Sri Lanka",
                    "custom_1": "",
                    "custom_2": ""
                };

                // Show the payhere.js popup, when "PayHere Pay" is clicked
                // document.getElementById('payhere-payment').onclick = function(e) {
                payhere.startPayment(payment);
                // };
            }
        }
    };

    request.open("GET", "payNowProcess.php?email=" + email, true);
    request.send();
}

function saveInvoice(id, email, amount) {

    var form = new FormData();
    form.append("email", email);
    form.append("amount", amount);
    form.append("id", id);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                window.location.reload();
            } else {
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = text;
                showToast();
            }
        }
    };

    request.open("POST", "saveInvoiceProcess.php", true);
    request.send(form);
}

var timeStarter;

function timeCounter() {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "00 Days : 00 Hours : 00 Minutes : 0 Seconds") {
                clearInterval(timeStarter);
                window.location.reload();
            }
            document.getElementById("counter").innerHTML = "&nbsp;" + text;
        }
    };

    request.open("GET", "timeCounterProcess.php", true);
    request.send();
}

function timeCounterCaller() {
    timeStarter = setInterval(timeCounter, 1000);
}

function adminSignout() {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                window.location.reload();
            } else {
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = text;
                showToast();
            }

        }
    };

    request.open("GET", "adminSignOut.php", true);
    request.send();
}

function officerSignout() {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                window.location.reload();
            } else {
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = text;
                showToast();
            }

        }
    };

    request.open("GET", "academicOfficerSignOut.php", true);
    request.send();
}

function teacherSignout() {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                window.location.reload();
            } else {
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = text;
                showToast();
            }

        }
    };

    request.open("GET", "teacherSignOut.php", true);
    request.send();
}

function studentSignout() {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                window.location.reload();
            } else {
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = text;
                showToast();
            }

        }
    };

    request.open("GET", "studentSignOut.php", true);
    request.send();
}

function searchStudent() {
    var stname = document.getElementById("stname");
    var grade = document.getElementById("grade");

    var form = new FormData();
    form.append("stname", stname.value);
    form.append("grade", grade.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            document.getElementById("student-card-loader").innerHTML = text;
        }
    };

    request.open("POST", "searchStudentProcess.php", true);
    request.send(form);
}

function upgradeClass(email) {
    var grade = document.getElementById("upgrade-class");

    var form = new FormData();
    form.append("email", email);
    form.append("grade", grade.value);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = "Student Grade Upgraded";
                showToast();
            } else {
                document.getElementById("toast-icon").classList = "bi bi-check-circle-fill fs-4 text-success justify-content-start";
                document.getElementById("toast-body").innerHTML = text;
                showToast();
            }
        }
    };

    request.open("POST", "upgradeClassProcess.php", true);
    request.send(form);
}

var gradeUpdaer;

function studentGradeUpdateChecker() {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "success") {
                clearInterval(gradeUpdaer);
                window.location.reload();
            }
        }
    };

    request.open("GET", "studentGradeUpdateChecker.php", true);
    request.send();
}

function studentGradeUpdateCheckerStart() {
    gradeUpdaer = setInterval(studentGradeUpdateChecker, 100);
}

function searchMarks() {
    var assignmentName = document.getElementById("assignment-name");
    var assignmentID = document.getElementById("assignment-id");
    var grade = document.getElementById("grade");

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var text = request.responseText;
            document.getElementById("result-card-loader").innerHTML = text;
        }
    };

    request.open("GET", "searchMarksProcess.php?name=" + assignmentName.value + "&id=" + assignmentID.value + "&grade=" + grade.value);
    request.send();
}