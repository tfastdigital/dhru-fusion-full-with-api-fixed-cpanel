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
if ($mep && $apiid) {
    $named = explode("\n", $mep);
    foreach ($named as $N) {
        if (trim($N)) {
            $data["mep"] = $N;
            $data["api"] = $api;
            $data["apiid"] = $apiid;
            $db->insert("tbl_mep", $data);
        }
    }
    echo "reload:" . $LNG["datasavesuccessfully"];
} else {
    echo "error:" . $LNG["datanotsave"];
}

?>