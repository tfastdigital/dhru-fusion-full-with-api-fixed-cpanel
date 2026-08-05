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
if ($_POST["apiallow"]) {
    $apiallow = 1;
} else {
    $apiallow = 0;
}
$ip = explode("\n", $connectionallowapi);
$currect = false;
$buff = "";
foreach ($ip as $i) {
    $i = trim($i);
    if ($i) {
        if (preg_match("/^([0-9]{1,3}\\.){2}([0-9*]{1,3}\\.)[0-9*]{1,3}\$/", trim($i))) {
            $currect = true;
            $buff .= trim($i) . "\n";
        } else {
            echo "error:" . $i . " " . $LNG["wrongip"];
            exit;
        }
    }
}
$data["api_access"] = $apiallow;
$data["api_key"] = $apiaccesskey;
$data["api_ip"] = trim($buff);
if ($db->update("tblUsers", $data, "id=" . $id)) {
    logActivityGlobal("API Key " . $apiaccesskey . " assigned", "api", $id, "admin");
    if ($sendmail) {
        if (!function_exists(sendMail)) {
            include ROOTDIR . "/includes/mail.fun.php";
        }
        $mailmerge["apiaccesskey"] = $apiaccesskey;
        sendMail("11", $id, "", $mailmerge, true);
    }
    echo "success:" . $LNG["datasavesuccessfully"];
} else {
    echo "error:" . $LNG["datanotsave"];
}

?>