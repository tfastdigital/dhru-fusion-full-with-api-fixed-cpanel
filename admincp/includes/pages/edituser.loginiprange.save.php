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
include "../../includes/clients.fun.inc.php";
$error = "";
if ($allowcountry) {
    $U = mysqli_fetch_assoc(dquery("select allowedcountry from tblUsers where id='" . $id . "'"));
    $cntr = json_decode($U["allowedcountry"], true);
    $NewArr = [];
    foreach ($cntr as $c) {
        $NewArr[$c] = $c;
    }
    $NewArr[$allowcountry] = $allowcountry;
    $cntr = json_encode($NewArr);
    dquery("update tblUsers set allowedcountry='" . $cntr . "' where id='" . $id . "'");
}
if ($ips) {
    $ip = explode("\n", $ips);
    $currect = false;
    $buff = "";
    foreach ($ip as $i) {
        $i = trim($i);
        if ($i) {
            if (preg_match("/^([0-9]{1,3}\\.){2}([0-9*]{1,3}\\.)[0-9*]{1,3}\$/", $i)) {
                $currect = true;
                $buff .= trim($i) . "\n";
            } else {
                echo "error:" . $i . " " . $LNG["wrongip"];
                exit;
            }
        }
    }
    if ($currect) {
        $data["ip_range"] = trim($buff);
        $data["login_country"] = $login_country;
        $db->update("tblUsers", $data, "id=" . $id);
        echo "reload:" . $LNG["datasavesuccessfully"];
    }
} else {
    $data["ip_range"] = "";
    if ($login_country) {
        $data["login_country"] = $login_country;
    }
    $db->update("tblUsers", $data, "id=" . $id);
    echo "reload:" . $LNG["datasavesuccessfully"];
}

?>