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
    $result = dquery("select id from tblUsers where \n   ( usertype=0 or usertype=1 ) " . $WHERE);
    while ($row = mysqli_fetch_assoc($result)) {
        $user[$row["id"]] = $row["id"];
    }
}
if ($server_service_id) {
    if ($user) {
        if (!is_array($user)) {
            $user = explode(",", $user);
        }
        foreach ($user as $value) {
            if ($server_service_id == "ALL") {
                dquery("update tblUsers set newserver_services='" . $server_service_id . "' where id=" . $value);
            } else {
                $server_ids = mysqli_fetch_assoc(dquery("select newserver_services from tblUsers where id=" . $value));
                if ($server_ids["newserver_services"]) {
                    dquery("update tblUsers set newserver_services=IF(newserver_services='','" . $server_service_id . "',CONCAT(newserver_services,',','" . $server_service_id . "'))\n                        where id=" . $value . " and newserver_services<>'ALL' and ('" . $server_service_id . "' NOT IN (" . $server_ids["newserver_services"] . "))");
                } else {
                    dquery("update tblUsers set newserver_services='" . $server_service_id . "' where id='" . $value . "' and newserver_services<>'ALL'");
                }
            }
        }
        echo "success:" . $LNG["assign"] . " " . $LNG["server"] . " " . $LNG["service"] . " " . $LNG["successfully"] . " ";
    } else {
        echo "error:" . $LNG["user"] . " " . $LNG["not"] . "  " . $LNG["selected"] . " ";
    }
} else {
    echo "error:" . $LNG["service"] . " " . $LNG["not"] . "  " . $LNG["selected"] . " ";
}
echo " ";

?>