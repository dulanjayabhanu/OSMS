<?php
require "connection.php";

require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$email = $_POST["email"];
$mobile = $_POST["mobile"];
$gender = $_POST["gender"];

$officerResultset = Database::search("SELECT * FROM `teacher` WHERE `email`='" . $email . "' AND `user_type`='2'");
$officerRownumber = $officerResultset->num_rows;
$officerData = $officerResultset->fetch_assoc();

if ($officerRownumber == 1) {
    echo ("This email is already in use");
} else {
    if (empty($firstname)) {
        echo ("Please enter officer's first name");
    } else if (empty($lastname)) {
        echo ("Please enter officer's last name");
    } else if (strlen($firstname) > 50) {
        echo ("Officer's first name should be <50 characters");
    } else if (strlen($lastname) > 50) {
        echo ("Officer's last name should be <50 characters");
    } else if (empty($email)) {
        echo ("Please enter officer's email address");
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo ("Invalid officer's email address");
    } else if (strlen($email) > 100) {
        echo ("Officer's email should be <100 characters");
    } else if (empty($mobile)) {
        echo ("Please enter officer's mobile");
    } else if (strlen($mobile) != 10) {
        echo ("Officer's mobile must have 10 characters");
    } else if (!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/", $mobile)) {
        echo ("Invalied mobile number");
    } else if ($gender == 0) {
        echo ("Please select officer's gender");
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

        Database::insertUpdateDelete("INSERT INTO `teacher` (`email`,`password`,`first_name`,`last_name`,`mobile`,`joined_date`,`block_status`,`verify_status`,`gender_id`,`username`,`user_type`) 
        VALUES ('" . $email . "','" . $password . "','" . $firstname . "','" . $lastname . "','" . $mobile . "','" . $date . "','1','2','" . $gender . "','".$userName."','2')");

        Database::insertUpdateDelete("INSERT INTO `unique_code` (`name`,`teacher_email`,`status`) VALUES ('".$oneTimeCode."','".$email."','1')");

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = '';
        $mail->Password = '';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('', 'OSMS');
        $mail->addReplyTo('', 'OSMS');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'You have been invited to contribute as a Academic Officer to the OSMS';
        $bodyContent = '<div style="font-family: "Arial";font-size: 15px;text-align: justify;">
        <span style="text-transform: capitalize;">Hello '.$firstname.',</span><br/><br/>
        <p style="text-align: justify;">The purpose of this message is to inform you that you have been invited to contribute as a academic officer to the online student management system. To accept this invitation, click the button below.</p><br/>
        <div style="padding-top: 18px;padding-bottom: 4px;">
            <span>Username&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- </span>
            <span style="background-image: linear-gradient(24deg, #3971eb79, #59ccfa6c);border-radius: 14px;padding:4px;">&nbsp;&nbsp;'.$userName.'&nbsp;</span><br/>
        </div>
        <div style="padding-top: 6px;padding-bottom: 4px;">
            <span>Password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- </span>
            <span style="background-image: linear-gradient(24deg, #3971eb79, #59ccfa6c);border-radius: 14px;padding:4px;">&nbsp;&nbsp;'.$password.'&nbsp;&nbsp;</span><br/>
        </div>
        <div style="padding-top: 6px;padding-bottom: 25px;">
            <span>One-time Code&nbsp;&nbsp;- </span>
            <span style="background-image: linear-gradient(24deg, #3971eb79, #59ccfa6c);border-radius: 14px;padding:4px;">&nbsp;&nbsp;'.$oneTimeCode.'&nbsp;</span><br/>
        </div>
        <a href="http://localhost/osms/academicOfficerSignIn.php?code=include" style="border-radius: 24px;padding-top: 8px;padding-bottom: 8px;padding-left: 15px;padding-right: 15px;background-color:#3972eb; color: #fff;font-family: "Arial";font-weight: bold;">Accept Invitation</a>
        <div style="margin-top: 25px;">
            <p style="text-align: justify;">Important : To accept the invitation and start subscribing to this online student management system, you must provide the username, password and one-time code provided above. (Later you can change the username. Also, the One-Time Code will
                expire after 15 hours.) You can use the system after you log into the system in the correct way and the administrators verify you.</p>
            <p>Thank You,<br>The OSMS</p>
        </div>
    </div>';
        $mail->Body = $bodyContent;

        if (!$mail->send()) {
            Database::insertUpdateDelete("DELETE FROM `unique_code` WHERE `teacher_email`='".$email."'");
            Database::insertUpdateDelete("DELETE FROM `teacher` WHERE `email`='".$email."'");
            echo ("Invitation sending failed");
        } else {
            echo ("success");
        }
    }
}
