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
if ($API_ID) {
    $vals = explode("_", $API_ID);
    list($API_ID, $API_TYPE) = $vals;
}
$servicear = mysqli_fetch_assoc(dquery("select useasserver from tbl_services_imei\nwhere id='" . $id . "'"));
if ($API_ID2) {
    $data["API_ID"] = $API_ID2;
} else {
    $data["API_ID"] = $API_ID;
}
$data["apilower"] = $apilower;
$data["manualverification"] = $manualverification;
$data["key_selling"] = $key_selling;
$data["API"] = $API;
$data["rejectqnt"] = $rejectqnt;
$data["verifyforreject"] = $verifyforreject;
$row = mysqli_fetch_assoc(dquery("select * from `tbl_apiserversservices`\n where `id`='" . $data["API_ID"] . "' and `gateway`='" . $API . "'\n  and type_id='" . $API_TYPE . "'  and useasserver='" . $servicear["useasserver"] . "'"));
$data["apiserverid"] = $row["apiserverid"];
$data["lastupdatedtime"] = time();
if ($data["API_ID"]) {
    $data["API_TYPEID"] = $API_TYPE;
    if ($row) {
        if ($row["requires_mobile"] == "Required") {
            $data["model"] = 1;
        } else {
            $data["model"] = 0;
        }
        if ($row["requires_provider"] == "Required") {
            $data["provider"] = 1;
        } else {
            $data["provider"] = 0;
        }
        if ($row["requires_mep"] == "Required") {
            $data["mep"] = 1;
        } else {
            $data["mep"] = 0;
        }
        if ($row["requires_prd"] == "Required") {
            $data["PRD"] = 1;
        } else {
            $data["PRD"] = 0;
        }
        if ($row["requires_reference"] == "Required") {
            $data["Reference"] = 1;
        } else {
            $data["Reference"] = 0;
        }
        if ($row["requires_kbh"] == "Required") {
            $data["KBH"] = 1;
        } else {
            $data["KBH"] = 0;
        }
        if ($row["requires_pin"] == "Required") {
            $data["PIN"] = 1;
        } else {
            $data["PIN"] = 0;
        }
        if ($row["requires_type"] == "Required") {
            $data["Type"] = 1;
        } else {
            $data["Type"] = 0;
        }
        if ($row["requires_locks"] == "Required") {
            $data["Locks"] = 1;
        } else {
            $data["Locks"] = 0;
        }
        if ($row["requires_SN"] == "Required") {
            $data["SN"] = 1;
        } else {
            $data["SN"] = 0;
        }
        if ($row["requires_SecRO"] == "Required") {
            $data["SecRO"] = 1;
        } else {
            $data["SecRO"] = 0;
        }
        $data["assigned_country"] = $row["assigned_country"];
        $data["assigned_brand"] = $row["assigned_brands"];
        $data["assigned_model"] = $row["assigned_mobiles"];
        $data["assigned_mep"] = $row["assigned_mep"];
        $data["assigned_provider"] = $row["assigned_network"];
        $data["listing"] = $row["gateway"];
    }
}
$data["lasteditedby"] = $_SESSION["adminid"];
if ($db->update("tbl_services_imei", $data, "id=" . $id)) {
    $APID = $data["API_ID"];
    if ($APID) {
        dquery("update tbl_services_imei_api set auto='0' where sid='" . $id . "'");
        foreach ($auto as $autosid) {
            dquery("update tbl_services_imei_api set auto='1' where id='" . $autosid . "'");
        }
    }
    if (!mysqli_num_rows(dquery("select * from tbl_services_imei_api\n    where sid='" . $id . "' and api_server='" . $API . "' and api_server_id='" . $APID . "'\n    and api_server_typeid='" . $API_TYPE . "'"))) {
        $apiserverid = mysqli_fetch_assoc(dquery("select apiserverid\n        from tbl_apiserversservices WHERE\n         gateway='" . $API . "' and id='" . $APID . "' and type_id='" . $API_TYPE . "' \n         and useasserver='" . $servicear["useasserver"] . "'"));
        if ($APID) {
            $data = NULL;
            $data["api_server"] = $API;
            $data["api_server_id"] = $APID;
            $data["sid"] = $id;
            $data["apiserverid"] = $apiserverid["apiserverid"];
            $data["api_server_typeid"] = $API_TYPE;
            $db->insert("tbl_services_imei_api", $data);
            $data = NULL;
        }
    }
    echo "success:" . $LNG["datasavesuccessfully"];
    logActivityGlobal("IMEI Service [" . $id . "] API Connect to [" . $API . "] API Service Name [" . $API_ID2 . "] ", "editservice", "", "admin");
} else {
    echo "error:" . $LNG["datanotsave"];
}

?>