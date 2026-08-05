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
include_once ROOTDIR . "/includes/customfield.fun.inc.php";
foreach ($customfield as $key => $value) {
    if (!$customfield[$key]["required"]) {
        $customfield[$key]["required"] = "";
    }
    if (!$customfield[$key]["enc"]) {
        $customfield[$key]["enc"] = "";
    }
    if ($customfieldc[$key]["include"]) {
        $buf = [];
        $cnt = 0;
        $dnt = 0;
        foreach ($customfieldc[$key]["include"] as $k => $v) {
            $cnt++;
            if ($v) {
                $buf[] = $customfieldc[$key]["price"][$k];
            } else {
                $buf[] = 0;
                $dnt++;
            }
        }
        if ($cnt != $dnt) {
            $buf = implode(",", $buf);
            $sql = dquery("select * from tbl_customfieldconfig\n           where cid='" . $key . "' and currency_id='" . $_SESSION["system_default_currency"]["id"] . "'");
            if (mysqli_num_rows($sql)) {
                dquery("UPDATE tbl_customfieldconfig set credit='" . $buf . "'\n                 where cid='" . $key . "' \n                 and currency_id='" . $_SESSION["system_default_currency"]["id"] . "'");
            } else {
                $data["cid"] = $key;
                $data["currency_id"] = $_SESSION["system_default_currency"]["id"];
                $data["credit"] = $buf;
                $db->insert("tbl_customfieldconfig", $data);
                $data = NULL;
            }
        } else {
            dquery("delete from tbl_customfieldconfig where cid='" . $key . "'");
        }
    }
}
if (!$customfield[-1]["fieldname"]) {
    unset($customfield[-1]);
}
saveCustomFieldServicewise($key, $customfield);
echo "reload:" . $LNG["datasavesuccessfully"];

?>