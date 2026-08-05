<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($save_token != sha1(session_id() . $_SESSION["adminid"] . ":SaveMe123122sds2")) {
    exit("error:invalid token");
}
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
include_once "../../includes/phpmailer.class.php";
$mail = new PHPMailer();
$mail->From = trim($config["config_admin_mail"]);
$mail->Subject = "Test Mail";
if ($mail_type2 == "php") {
    $mail->Mailer = "mail";
    $mail->Body = "Test mail successfull sended by PHP mailing";
} else {
    if ($mail_type2 == "smtp") {
        $mail->IsSMTP();
        $mail->Host = trim($config["smtp_host2"]);
        $mail->Port = trim($config["smtp_port2"]);
        $mail->Hostname = $_SERVER["SERVER_NAME"];
        if ($config["smtp_enc2"]) {
            $mail->SMTPSecure = "ssl";
        }
        if ($config["smtp_username2"]) {
            $mail->SMTPAuth = true;
            $mail->Username = trim($config["smtp_username2"]);
            $mail->Password = trim($config["smtp_password2"]);
        }
        $mail->Body = "Test mail successfull sended by SMTP mailing";
        $mail->Sender = $mail->From;
    }
}
$mail->AltBody = "Mail Testing";
$emailcount = 0;
$mail->AddAddress($config["config_admin_mail"]);
if (!$mail->Send()) {
    echo "error: " . $mail->ErrorInfo;
} else {
    echo "success: Testing Mail send successfully";
}
$mail->ClearAddresses();

?>