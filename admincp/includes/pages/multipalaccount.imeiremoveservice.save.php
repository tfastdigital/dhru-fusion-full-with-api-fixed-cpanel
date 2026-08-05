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
if ($group) {
    $WHERE .= " and client_group='" . $group . "'";
}
if ($statuss) {
    $WHERE .= " and userstatus='" . $statuss . "'";
}
if ($reseller) {
    $WHERE .= " and reseller_id='" . $reseller . "'";
}
if ($checkall) {
    unset($user);
    $result = dquery("select id from tblUsers where \r\n   ( usertype=0 or usertype=1 ) " . $WHERE);
    while ($row = mysqli_fetch_assoc($result)) {
        $user[$row["id"]] = $row["id"];
    }
}
if ($imei_service_id) {
    if ($user) {
        if (!is_array($user)) {
            $user = explode(",", $user);
        }
        foreach ($user as $value) {
            if ($imei_service_id != "ALL") {
                $imei_ids = mysqli_fetch_assoc(dquery("select imei_services from tblUsers where id=" . $value));
                $arr = explode(",", $imei_ids["imei_services"]);
                $arr = array_values(array_diff($arr, [$imei_service_id]));
                $imei_ids = implode(",", $arr);
                dquery("update tblUsers set imei_services='" . $imei_ids . "' where id=" . $value . " and imei_services<>'ALL'");
            }
        }
        echo "success:" . $LNG["remove"] . " " . $LNG["imei"] . " " . $LNG["service"] . " " . $LNG["successfully"] . " ";
    } else {
        echo "error:" . $LNG["user"] . " " . $LNG["not"] . "  " . $LNG["selected"] . " ";
    }
} else {
    echo "error:" . $LNG["service"] . " " . $LNG["not"] . "  " . $LNG["selected"];
}

?>