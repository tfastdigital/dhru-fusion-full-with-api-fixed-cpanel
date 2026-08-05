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
if (!$testtoemail) {
    echo "error: Test to email required";
    exit;
}
if (!preg_match("/([\\w\\-]+\\@[\\w\\-]+\\.[\\w\\-]+)/", trim($testtoemail))) {
    echo "error: Wrong email";
    exit;
}
if ($mail_type == "sendgrid") {
    $Json = [];
    $Json["personalizations"][0]["to"][]["email"] = $testtoemail;
    $Json["from"]["email"] = trim($config["config_admin_mail"]);
    $Json["subject"] = "Test email from SendGrid";
    if ($plaintext) {
        $Json["content"][0]["value"] = "Test email From SendGrid";
        $Json["content"][0]["type"] = "text/plain";
    } else {
        $Json["content"][0]["value"] = "Test email From SendGrid";
        $Json["content"][0]["type"] = "text/html";
    }
    $CURLheaders["HEADER"] = ["Authorization: Bearer " . $config["aggregatorapi"], "Content-Type: application/json"];
    $OUT = initCurl("https://api.sendgrid.com/v3/mail/send", "", $CURLheaders, $config["aggregatorapi"], $Json);
    if (!$OUT) {
        echo "success: Test Email sent";
    } else {
        $res = json_decode($OUT, true)["errors"][0]["message"];
        echo "error:" . $res;
    }
    exit;
}
if (is_file("Mail.php")) {
    require_once "Mail.php";
} else {
    include_once "../../includes/phpmailer.class.php";
}
$mail = new PHPMailer();
$mail->From = trim($config["config_admin_mail"]);
$mail->Subject = "Test Mail";
$mail->Body = "Test mail successfull";
if ($mail_type == "php") {
    $mail->Mailer = "mail";
    $mail->Body = "Test mail successfull sended by PHP mailing";
} else {
    if ($mail_type == "smtp") {
        $mail->IsSMTP();
        $mail->Host = trim($config["smtp_host"]);
        $mail->Port = trim($config["smtp_port"]);
        $mail->Hostname = $_SERVER["SERVER_NAME"];
        if ($config["smtp_enc"]) {
            $mail->SMTPSecure = "ssl";
        }
        if ($config["smtp_username"]) {
            $mail->SMTPAuth = true;
            $mail->Username = trim($config["smtp_username"]);
            $mail->Password = trim($config["smtp_password"]);
        }
        $mail->Body = "Test mail successfull sended by SMTP mailing";
        $mail->Sender = $mail->From;
    }
}
$mail->AltBody = "Mail Testing";
$emailcount = 0;
if ($testtoemail) {
    $mail->AddAddress($testtoemail);
} else {
    $mail->AddAddress($config["config_admin_mail"]);
}
if (!$mail->Send()) {
    echo "error: " . $mail->ErrorInfo;
} else {
    echo "success: Testing Mail send successfully";
}
$mail->ClearAddresses();

?>