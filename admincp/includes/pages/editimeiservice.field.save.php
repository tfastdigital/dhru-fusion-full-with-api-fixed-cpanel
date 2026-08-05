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
$data["model"] = $model;
$data["provider"] = $provider;
$data["network"] = $network;
$data["mep"] = $mep;
$data["PIN"] = $pin;
$data["KBH"] = $kbh;
$data["PRD"] = $prd;
$data["SN"] = $SN;
$data["SecRO"] = $SecRO;
$data["Type"] = $type;
$data["Reference"] = $reference;
$data["Locks"] = $locks;
$data["isalpha"] = $isalpha;
$data["imei_single"] = $imei;
$data["imei_bulk"] = $bulk;
$data["imei_custom"] = $custom;
$data["imei_custom_len"] = $customlength;
$data["maxlength"] = $maxlength;
$data["imei_custom_name"] = $customimeiname;
$data["imei_custom_info"] = $customimeiinfo;
$data["imeiregex"] = $imeiregex;
$data["listing"] = $listing;
$data["qnt"] = $qnt;
$data["qntoptions"] = $qntoptions;
$data["minqnt"] = $minqnt;
$data["maxqnt"] = $maxqnt;
$data["validateimei"] = $validateimei;
include_once ROOTDIR . "/includes/customfield.fun.inc.php";
$error = "";
foreach ($customfield as $key => $value) {
    if ($key != -1 && $value["required"] == "on" && !$value["fieldname"]) {
        echo "error: Custom Field name should not blank";
        exit;
    }
    if (!$customfield[$key]["required"]) {
        $customfield[$key]["required"] = "";
    }
    if (is_array($other[$key])) {
        foreach ($other[$key] as $k => $otherfieldname) {
            if (trim($otherfieldname)) {
                $customfield[$key]["fieldother"][] = $otherfieldname;
            }
        }
    }
}
if (!$customfield[-1]["fieldname"]) {
    unset($customfield[-1]);
}
saveCustomFieldServicewise($key, $customfield);
if ($db->update("tbl_services_imei", $data, "id=" . $id)) {
    echo "reload:" . $LNG["datasavesuccessfully"];
} else {
    echo "error:" . $error . " <li>" . $LNG["datanotsave"] . "</li>";
}

?>