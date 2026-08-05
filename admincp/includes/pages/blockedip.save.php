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
if ($country) {
    $data["ip"] = $country;
    $data["country"] = 1;
    $db->insert("tbl_bannedips", $data);
    $data = NULL;
    echo "success:" . $LNG["countryblocked"];
}
if ($ips) {
    $ip = explode("\n", $ips);
    foreach ($ip as $i) {
        $value = explode("#", $i);
        if (preg_match("/^([0-9]{1,3}\\.){2}([0-9*]{1,3}\\.)[0-9*]{1,3}\$/", trim($value[0]))) {
            $data["ip"] = trim($value[0]);
            $data["reason"] = trim($value[1]);
            $data["expires"] = "0000:00:00 00:00:00";
            $db->insert("tbl_bannedips", $data);
            $data = NULL;
        } else {
            echo "error:" . $LNG["wrongip"];
            exit;
        }
    }
    echo "success:" . $LNG["datasavesuccessfully"];
}

?>