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
$k = $midd;
$apir = explode("_", $k);
list($kAPI, $typeid) = $apir;
$apiserv = mysqli_fetch_assoc(dquery("select gateway from tbl_apiserversservices\r\n    where id='" . $kAPI . "' and gateway='" . $gateway . "'"));
$rowd = mysqli_fetch_assoc(dquery("select * from `tbl_apiserversservices`\r\n     where `id`='" . $kAPI . "' and `gateway`='" . $gateway . "' and type_id='" . $typeid . "'"));
$ServiceArr["service_name"] = $service[$k];
$ServiceArr["credit"] = $credit[$k];
$ServiceArr["group_id"] = $groups[$k];
$ServiceArr["status"] = 1;
$ServiceArr["active"] = 1;
$ServiceArr["API_ID"] = $kAPI;
$ServiceArr["API"] = $apiserv["gateway"];
$ServiceArr["qnt"] = $rowd["qnt"];
$ServiceArr["apiserverid"] = $rowd["apiserverid"];
$ServiceArr["qntoptions"] = $rowd["qntoptions"];
$ServiceArr["minqnt"] = $rowd["minqnt"];
$ServiceArr["maxqnt"] = $rowd["maxqnt"];
if ($rowd) {
    if ($rowd["requires_mobile"] == "Required") {
        $ServiceArr["model"] = 1;
    } else {
        $ServiceArr["model"] = 0;
    }
    if ($rowd["requires_provider"] == "Required") {
        $ServiceArr["provider"] = 1;
    } else {
        $ServiceArr["provider"] = 0;
    }
    if ($rowd["requires_mep"] == "Required") {
        $ServiceArr["mep"] = 1;
    } else {
        $ServiceArr["mep"] = 0;
    }
    if ($rowd["requires_prd"] == "Required") {
        $ServiceArr["PRD"] = 1;
    } else {
        $ServiceArr["PRD"] = 0;
    }
    if ($rowd["requires_reference"] == "Required") {
        $ServiceArr["Reference"] = 1;
    } else {
        $ServiceArr["Reference"] = 0;
    }
    if ($rowd["requires_kbh"] == "Required") {
        $ServiceArr["KBH"] = 1;
    } else {
        $ServiceArr["KBH"] = 0;
    }
    if ($rowd["requires_pin"] == "Required") {
        $ServiceArr["PIN"] = 1;
    } else {
        $ServiceArr["PIN"] = 0;
    }
    if ($rowd["requires_type"] == "Required") {
        $ServiceArr["Type"] = 1;
    } else {
        $ServiceArr["Type"] = 0;
    }
    if ($rowd["requires_locks"] == "Required") {
        $ServiceArr["Locks"] = 1;
    } else {
        $ServiceArr["Locks"] = 0;
    }
    if ($rowd["requires_SN"] == "Required") {
        $ServiceArr["SN"] = 1;
    } else {
        $ServiceArr["SN"] = 0;
    }
    if ($rowd["requires_SecRO"] == "Required") {
        $ServiceArr["SecRO"] = 1;
    } else {
        $ServiceArr["SecRO"] = 0;
    }
    $ServiceArr["assigned_country"] = $rowd["assigned_country"];
    $ServiceArr["assigned_brand"] = $rowd["assigned_brands"];
    $ServiceArr["assigned_model"] = $rowd["assigned_mobiles"];
    $ServiceArr["assigned_mep"] = $rowd["assigned_mep"];
    $ServiceArr["assigned_provider"] = $rowd["assigned_network"];
    $ServiceArr["listing"] = $rowd["gateway"];
    $ServiceArr["useasserver"] = $rowd["useasserver"];
    $ServiceArr["API_TYPEID"] = $rowd["type_id"];
}
$newsid = addNewService($ServiceArr);
if ($rowd["requires_custom"]) {
    $custom = json_decode($rowd["requires_custom"], true);
    foreach ($custom as $k => $field) {
        $CDATA["type"] = "serviceimei";
        $CDATA["relid"] = $newsid;
        $CDATA["fieldname"] = $field["fieldname"];
        $CDATA["fieldtype"] = $field["fieldtype"];
        $CDATA["fieldoptions"] = $field["fieldoptions"];
        $CDATA["required"] = $field["required"];
        $db->insert("tbl_customfields", $CDATA);
        $CDATA = NULL;
    }
}
$row = NULL;
foreach ($assign as $groupid) {
    $STATUSD["groupid"] = $groupid;
    $STATUSD["serviceid"] = $newsid;
    $STATUSD["status"] = 1;
    $db->insert("tbl_service_status", $STATUSD);
}
if ($assingtoall) {
}
$APID = $k;
$API = $apiserv["gateway"];
if (!mysqli_num_rows(dquery("select * from tbl_services_imei_api\r\n    where sid='" . $newsid . "' and api_server='" . $API . "' and api_server_id='" . $APID . "'"))) {
    $data = NULL;
    $data["api_server"] = $API;
    $data["api_server_id"] = $APID;
    $data["sid"] = $newsid;
    $data["apiserverid"] = $rowd["apiserverid"];
    $db->insert("tbl_services_imei_api", $data);
    $data = NULL;
}
$newarr[] = $newsid;
echo "success: New services created #" . implode(",", $newarr);

?>