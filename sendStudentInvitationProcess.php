<?php
require "connection.php";

require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$dateOfBirth = $_POST["dateOfBirth"];
$mobile = $_POST["mobile"];
$gender = $_POST["gender"];
$email = $_POST["email"];
$class = $_POST["class"];
$medium = $_POST["medium"];
$parentEmail = $_POST["parentEmail"];
$nationality = $_POST["nationality"];

$studentResultset = Database::search("SELECT * FROM `student` WHERE `email`='" . $email . "'");
$studentRownumber = $studentResultset->num_rows;

$classRoomResultset = Database::search("SELECT * FROM `classroom` WHERE `student_email`='" . $email . "'");
$classRoomRownumber = $classRoomResultset->num_rows;

$parentResultset = Database::search("SELECT * FROM `parent` WHERE `email`='" . $parentEmail . "'");
$parentRownumber = $parentResultset->num_rows;

$teacherResultset = Database::search("SELECT `teacher_email` FROM `teacher_has_subject` WHERE `grade_id`='" . $class . "'");
$teacherRownumber = $teacherResultset->num_rows;

if ($studentRownumber == 1) {
    echo ("This student email is already in use");
} else if ($classRoomRownumber == 1) {
} else if ($parentRownumber == 1) {
    echo ("This parent/guardian email is already in use");
} else if ($teacherRownumber == 0 && $class != 0) {
    echo ("There is currently no teacher assigned for this class");
} else {
    $studentData = $studentResultset->fetch_assoc();
    $classRoomData = $classRoomResultset->fetch_assoc();
    $teacherData = $teacherResultset->fetch_assoc();

    if (empty($firstname)) {
        echo ("Please enter student's first name");
    } else if (empty($lastname)) {
        echo ("Please enter student's last name");
    } else if (strlen($firstname) > 50) {
        echo ("Student's first name should be <50 characters");
    } else if (strlen($lastname) > 50) {
        echo ("Student's last name should be <50 characters");
    } else if (empty($dateOfBirth)) {
        echo ("Please enter student's date of birth");
    }else if (empty($nationality)) {
        echo ("Please enter student's nationality");
    }else if (strlen($nationality) > 20) {
        echo ("Student's email should be <20 characters");
    } else if (empty($email)) {
        echo ("Please enter student's email address");
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo ("Invalid student's email address");
    } else if (strlen($email) > 100) {
        echo ("Student's email should be <100 characters");
    } else if (empty($parentEmail)) {
        echo ("Please enter parent/guardian email address");
    } else if (!filter_var($parentEmail, FILTER_VALIDATE_EMAIL)) {
        echo ("Invalid parent/guardian email address");
    } else if (strlen($parentEmail) > 100) {
        echo ("Parent/guardian email should be <100 characters");
    } else if ($parentEmail == $email) {
        echo ("Parent/guardian and student can not use the same email");
    } else if (empty($mobile)) {
        echo ("Please enter student's mobile");
    } else if (strlen($mobile) != 10) {
        echo ("Student's mobile must have 10 characters");
    } else if (!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/", $mobile)) {
        echo ("Invalied mobile number");
    } else if ($gender == 0) {
        echo ("Please select student's gender");
    } else if ($class == 0) {
        echo ("Please select a class");
    } else if ($medium == 0) {
        echo ("Please select a medium");
    } else {
        function generateUniqId($startNum, $idLenght)
        {
            $uniqId = uniqid();
            $newUniqId = substr($uniqId, intval($startNum), intval($idLenght));
            return $newUniqId;
        }

        $userName = $firstname . substr($lastname, 0, 3) . generateUniqId(6, 4);
        $password = generateUniqId(2, 8);
        $oneTimeCode = generateUniqId(8, 5);

        $datetime = new DateTime();
        $timezone = new DateTimeZone("Asia/Colombo");
        $datetime->setTimezone($timezone);
        $date = $datetime->format("Y-m-d H:i:s");

        $currentYear = date("Y");

        Database::insertUpdateDelete("INSERT INTO `parent` (`email`) VALUES ('" . $parentEmail . "')");

        Database::insertUpdateDelete("INSERT INTO `student` (`email`,`password`,`first_name`,`last_name`,`date_of_birth`,`mobile`,`joined_date`,`block_status`,`verify_status`,`username`,`nationality`,`gender_id`,`medium_id`,`parent_email`,`payment_status`) 
            VALUES ('" . $email . "','" . $password . "','" . $firstname . "','" . $lastname . "','" . $dateOfBirth . "','" . $mobile . "','" . $date . "','1','2','" . $userName . "','" . $nationality . "','" . $gender . "','" . $medium . "','" . $parentEmail . "','2')");

        Database::insertUpdateDelete("INSERT INTO `student_unique_code` (`name`,`student_email`,`status`) VALUES ('" . $oneTimeCode . "','" . $email . "','1')");

        Database::insertUpdateDelete("INSERT INTO `classroom` (`year`,`grade_id`,`teacher_email`,`student_email`) VALUES ('".$currentYear."','" . $class . "','" . $teacherData["teacher_email"] . "','" . $email . "')");

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'dulanjayaedu@gmail.com';
        $mail->Password = 'kutwgcxdoczbdlcu';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('dulanjayaedu@gmail.com', 'OSMS');
        $mail->addReplyTo('dulanjayaedu@gmail.com', 'OSMS');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Notice that you are registered as a student in the online student management system';
        $bodyContent = '<div style="font-family: "Arial";font-size: 15px;text-align: justify;">
            <span style="text-transform: capitalize;">Hello ' . $firstname . ',</span><br/><br/>
            <p style="text-align: justify;">The purpose of this message is to inform you that you have been registered as a student in the online student management system. Click the button below to sign in to the system.</p><br/>
            <div style="padding-top: 18px;padding-bottom: 4px;">
                <span>Username&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- </span>
                <span style="background-image: linear-gradient(24deg, #3971eb79, #59ccfa6c);border-radius: 14px;padding:4px;">&nbsp;&nbsp;' . $userName . '&nbsp;</span><br/>
            </div>
            <div style="padding-top: 6px;padding-bottom: 4px;">
                <span>Password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- </span>
                <span style="background-image: linear-gradient(24deg, #3971eb79, #59ccfa6c);border-radius: 14px;padding:4px;">&nbsp;&nbsp;' . $password . '&nbsp;&nbsp;</span><br/>
            </div>
            <div style="padding-top: 6px;padding-bottom: 25px;">
                <span>One-time Code&nbsp;&nbsp;- </span>
                <span style="background-image: linear-gradient(24deg, #3971eb79, #59ccfa6c);border-radius: 14px;padding:4px;">&nbsp;&nbsp;' . $oneTimeCode . '&nbsp;</span><br/>
            </div>
            <a href="http://localhost/osms/studentSignIn.php?code=include" style="border-radius: 24px;padding-top: 8px;padding-bottom: 8px;padding-left: 15px;padding-right: 15px;background-color:#3972eb; color: #fff;font-family: "Arial";font-weight: bold;">Accept Invitation</a>
            <div style="margin-top: 25px;">
                <p style="text-align: justify;">Important : To sign in to this online student management system, you must provide the username, password and one-time code provided above. (You can change the username later. Also, the one-time code 
                expires in 15 hours.) Once you log into the system correctly and an academic officer verifies you, you can use the system.</p>
                <p>Thank You,<br>The OSMS</p>
            </div>
        </div>';
        $mail->Body = $bodyContent;

        if (!$mail->send()) {
            Database::insertUpdateDelete("DELETE FROM `classroom` WHERE `student_email`='" . $email . "' AND `year`='".$currentYear."' AND `teacher_email`='" . $teacherData["teacher_email"] . "'");
            Database::insertUpdateDelete("DELETE FROM `student_unique_code` WHERE `student_email`='" . $email . "'");
            Database::insertUpdateDelete("DELETE FROM `student` WHERE `email`='" . $email . "'");
            Database::insertUpdateDelete("DELETE FROM `parent` WHERE `email`='" . $parentEmail . "'");
            echo ("Invitation sending failed");
        } else {
            echo ("success");
        }
    }
}
