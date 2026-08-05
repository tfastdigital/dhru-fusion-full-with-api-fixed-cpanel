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
include_once ROOTDIR . "/includes/imeiservices.fun.php";
if ($_POST["status"]) {
    $status = 1;
} else {
    $status = 0;
}
if ($sendnotification && $config["slack_servicestat"]) {
    $emojica = "🆕";
    sendtoChannel($config["slack_servicestat"], urlencode(json_decode("\"" . $emojica . "\"") . " New Service " . "\n\n" . $servicename) . "&parse_mode=html");
}
if ($_POST["verification"]) {
    $verification = 1;
} else {
    $verification = 0;
}
if ($_POST["cancel"]) {
    $cancel = 1;
} else {
    $cancel = 0;
}
if ($servicename) {
    $servicename = str_replace("'", "", $servicename);
    if ($import) {
        $check = mysqli_num_rows(dquery("select * from tbl_services_imei\n         where service_name='" . $servicename . "'"));
        if ($check != 0) {
            echo "error:" . $LNG["servicename"] . " " . $LNG["already"] . " " . $LNG["exists"];
            exit;
        }
        $row = mysqli_fetch_assoc(dquery("select * from tbl_services_imei\n         where id='" . $import . "'"));
        unset($row["id"]);
        $ServiceArr = $row;
        $ServiceArr["service_name"] = $servicename;
        $newsid = addNewService($ServiceArr);
        $row = NULL;
        if ($newsid) {
            if ($useraccess) {
                $sql = dquery("UPDATE `tblUsers` SET                 `imei_services` = concat(`imei_services`,'," . $newsid . "')\n                 WHERE `imei_services`<>'ALL'");
            }
            echo "callfunction:editimeiservice:" . $newsid;
        } else {
            echo "error:" . $LNG["datanotsave"];
        }
    } else {
        $ServiceArr["service_name"] = str_replace("'", "", $servicename);
        $service_name = mysqli_fetch_assoc(dquery("SELECT service_name \n        FROM tbl_services_imei where id='" . $id . "'"));
        if ($servicename != $ServiceArr["service_name"]) {
            $check = mysqli_num_rows(dquery("select * from tbl_services_imei where service_name='" . $servicename . "'"));
        }
        if ($check != 0) {
            echo "error:" . $LNG["servicename"] . " " . $LNG["already"] . " " . $LNG["exists"];
            exit;
        }
        if (!$groupname) {
            echo "error:" . $LNG["group"] . " " . $LNG["name"] . " " . $LNG["mustbe"] . " " . $LNG["required"];
            exit;
        }
        $ServiceArr["group_id"] = $groupname;
        $ServiceArr["time"] = $time1 . " " . $timeref;
        $ServiceArr["credit"] = $credit;
        $ServiceArr["verifiable"] = $verification;
        $ServiceArr["usercan_cancel"] = $cancel;
        $ServiceArr["API"] = "unlockbase";
        $ServiceArr["status"] = 1;
        $ServiceArr["active"] = 1;
        $ServiceArr["newservice"] = 1;
        $ServiceArr["useasserver"] = $useasserver;
        $ServiceArr["lastupdatedtime"] = time();
        $newsid = addNewService($ServiceArr);
        if ($useasserver) {
            $ServiceField = "newserver_services";
        } else {
            $ServiceField = "imei_services";
        }
        if ($newsid) {
            echo "callfunction:editimeiservice:" . $newsid;
        } else {
            echo "error:" . $LNG["datanotsave"];
        }
    }
} else {
    echo "error:" . $LNG["service"] . " " . $LNG["name"] . " " . $LNG["mustbe"] . " " . $LNG["required"];
}
echo " ";

?>