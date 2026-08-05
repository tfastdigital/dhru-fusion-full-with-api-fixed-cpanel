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
if ($department && $email) {
    $sql = dquery("select email from tbl_support_department where email='" . $email . "'");
    if (!mysqli_num_rows($sql)) {
        $data["department"] = $department;
        $data["email"] = $email;
        $data["login"] = $login;
        $data["status"] = $status;
        $data["info"] = $info;
        $data["livehelp"] = $help;
        $data["iconlink"] = $iconlink;
        if ($id = $db->insert("tbl_support_department", $data)) {
            if ($all) {
                dquery("UPDATE tbl_admin SET support_department=IF(support_department!='',CONCAT(support_department,','," . $id . ")," . $id . ")");
            }
            echo "success:" . $LNG["datasavesuccessfully"];
        } else {
            echo "error:" . $LNG["datanotsave"];
        }
    } else {
        echo "error:" . $LNG["email"] . " " . $LNG["already"] . " " . $LNG["exists"];
    }
} else {
    echo "error:" . $LNG["field"] . " " . $LNG["required"];
}

?>