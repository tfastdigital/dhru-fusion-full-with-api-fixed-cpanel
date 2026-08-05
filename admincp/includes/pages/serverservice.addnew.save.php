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
if ($_POST["status"]) {
    $status = 1;
} else {
    $status = 0;
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
    if ($import) {
        $check = mysqli_num_rows(dquery("select * from tbl_server_log where service_name='" . $servicename . "'"));
        if ($check != 0) {
            echo "error:" . $LNG["servicename"] . " " . $LNG["already"] . " " . $LNG["exists"];
            exit;
        }
        $row = mysqli_fetch_assoc(dquery("select * from tbl_server_log where id='" . $import . "'"));
        $row["id"] = NULL;
        $row["service_name"] = $servicename;
        $newsid = $db->insert("tbl_server_log", $row);
        $row = NULL;
        if ($newsid) {
            if ($useraccess) {
                $sql = dquery("UPDATE `tblUsers` SET `server_logs` = concat(`server_logs`,'," . $newsid . "') WHERE `server_logs`<>'ALL'");
            }
            echo "callfunction:editserverservice:" . $newsid;
        } else {
            echo "error:" . $LNG["datanotsave"];
        }
    } else {
        $data["service_name"] = $servicename;
        $service_name = mysqli_fetch_assoc(dquery("SELECT service_name FROM tbl_server_log where id='" . $id . "'"));
        if ($servicename != $service_name["service_name"]) {
            $check = mysqli_num_rows(dquery("select * from tbl_server_log where service_name='" . $servicename . "'"));
        }
        if ($check != 0) {
            echo "error:" . $LNG["servicename"] . " " . $LNG["already"] . " " . $LNG["exists"];
            exit;
        }
        if (!$groupname) {
            echo "error:" . $LNG["group"] . " " . $LNG["name"] . " " . $LNG["mustbe"] . " " . $LNG["required"];
            exit;
        }
        $data["group_id"] = $groupname;
        $data["time"] = $time1 . " " . $timeref;
        $data["credit"] = $credit;
        $data["verifiable"] = $verification;
        $data["usercan_cancel"] = $cancel;
        $data["active"] = $status;
        $newsid = $db->insert("tbl_server_log", $data);
        if ($newsid) {
            if ($useraccess) {
                $sql = dquery("UPDATE `tblUsers` SET `server_logs` = concat(`server_logs`,'," . $newsid . "') WHERE `server_logs`<>'ALL'");
            }
            echo "callfunction:editserverservice:" . $newsid;
        } else {
            echo "error:" . $LNG["datanotsave"];
        }
    }
} else {
    echo "error:" . $LNG["service"] . " " . $LNG["name"] . " " . $LNG["mustbe"] . " " . $LNG["required"];
}
echo " ";

?>