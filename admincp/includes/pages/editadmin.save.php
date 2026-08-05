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
if ($admn) {
    $data = NULL;
    if ($password) {
        $data["password"] = md5(md5($password) . "9486");
    }
    $data["firstname"] = $firstname;
    $data["lastname"] = $lastname;
    $data["rejectorder"] = $rejectaftersuccess;
    $data["email"] = $email;
    $data["contact"] = $contact;
    $data["salesreport"] = $salesreport;
    if (!$mobile) {
        $data["credit"] = trim($credit);
        $data["group_id"] = $group_name;
        if ($admn != $_SESSION["adminid"]) {
            $data["status"] = $status;
        }
        $data["language"] = $language;
        $data["template"] = $template;
        $data["mywarehouse"] = $mywarehouse;
        if (in_array($pageid, explode(",", $_SESSION["page_access"]))) {
            if ($department) {
                foreach ($department as $key => $d) {
                    $buf .= $key . ",";
                }
                $buf = trim($buf, ",");
                $data["support_department"] = $buf;
            }
            $buf = NULL;
            if ($chatdepartment) {
                foreach ($chatdepartment as $key => $d) {
                    $buf .= $key . ",";
                }
                $buf = trim($buf, ",");
                $data["chatdepartment"] = $buf;
            }
        }
    }
    $data["signature"] = $signature;
    $_SESSION["admintheme"] = $theme;
    $data["theme"] = $_SESSION["admintheme"];
    $db->update("tbl_admin", $data, "id='" . $admn . "'");
    echo "success:" . $LNG["datasavesuccessfully"];
}

?>