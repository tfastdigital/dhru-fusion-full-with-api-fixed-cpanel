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
if ($checkall) {
    unset($user);
    $result = dquery("select id from tblUsers where \n    usertype=0 or usertype=1");
    while ($row = mysqli_fetch_assoc($result)) {
        $user[$row["id"]] = $row["id"];
    }
}
if ($user) {
    if (!is_array($user)) {
        $user = explode(",", $user);
    }
    $imeiservice = $assignservices["imei"] ? 1 : 0;
    $fileservice = $assignservices["file"] ? 1 : 0;
    $serverservice = $assignservices["server"] ? 1 : 0;
    $remoteservice = $assignservices["remote"] ? 1 : 0;
    foreach ($user as $value) {
        dquery("update tblUsers set    \n                                imei_service_access='" . $imeiservice . "', \n                                file_service_access='" . $fileservice . "', \n                                server_log_access='" . $serverservice . "', \n                                alow_remoteservices='" . $remoteservice . "'   where id=" . $value);
    }
    echo "success: Service assigned ";
} else {
    echo "error:" . $LNG["user"] . " " . $LNG["not"] . "  " . $LNG["selected"] . " ";
}

?>