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
$error = "";
if ($customfield) {
    foreach ($customfield as $key => $value) {
        if (!$customfield[$key]["required"]) {
            $customfield[$key]["required"] = "";
        }
    }
    if (!$customfield[-1]["fieldname"]) {
        unset($customfield[-1]);
    }
    saveCustomFieldServicewise($key, $customfield);
} else {
    if ($id && $title) {
        $data["title"] = $title;
        $data["detail"] = $detail;
        $data["status"] = $status;
        $data["captcha"] = $captcha;
        $db->update("tbl_survey", $data, "id=" . $id);
        $data = NULL;
    } else {
        echo "error:" . $LNG["fieldblank"];
        exit;
    }
}
echo "success:" . $LNG["datasavesuccessfully"];

?>