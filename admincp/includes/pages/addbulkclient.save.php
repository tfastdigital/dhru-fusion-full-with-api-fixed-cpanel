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
include ROOTDIR . "/includes/clients.fun.inc.php";
include ROOTDIR . "/includes/customfield.fun.inc.php";
$validator = NULL;
$bulkuser = explode("\n", $bulkuser);
$bulkpass = explode("\n", $bulkpassword);
$bulkemail = explode("\n", $bulkemail);
if (count($bulkuser) != count($bulkpass) || count($bulkpass) != count($bulkemail)) {
    echo "error: No. of User, Password or Email not match";
    exit;
}
$ERROR = [];
$SUCCESS = [];
foreach ($bulkuser as $k => $username) {
    $password = trim($bulkpass[$k]);
    $email = trim($bulkemail[$k]);
    $username = trim($username);
    if (trim($username)) {
        $validator["username"] = [$username, true];
        $validator["password"] = [$password, true];
        $validator["email"] = [$email, true];
        $validator["usertype"] = [$type, false];
        $validator["credit_transfer"] = [$allowtransfer, false];
        $validator["userstatus"] = [$status, false];
        $validator["imei_service_access"] = [$imeiaccess, false];
        $validator["file_service_access"] = [$fileaccess, false];
        $validator["server_log_access"] = [$serveraccess, false];
        $validator["shop_service_access"] = [$shopaccess, false];
        $validator["alow_remoteservices"] = [$remoteaccess, false];
        $validator["default_theme"] = [$template, false];
        $validator["language"] = [$language, false];
        $validator["currency"] = [$currency, false];
        $validator["admin_id"] = [$_SESSION["adminid"], false];
        $validator["clientgroup"] = [$clientgroup, false];
        $validator["is_registered"] = ["1", false];
        if ($error = validateProfiles($validator)) {
            $ERROR[$username] = $error;
        } else {
            if ($error = addNewUser($validator, "", "ADMIN")) {
                $ERROR[$username] = $error;
            } else {
                $result = dquery("select id from tblUsers where username='" . $username . "'");
                $row = mysqli_fetch_assoc($result);
                if (addCredit($row["id"], $creditleft, 0)) {
                }
                if ($type != "1" || addSellCredit($row["id"], $creditleft, 0)) {
                }
                $SUCCESS[$username] = (string) $username;
            }
        }
    }
}
if (0 < count($SUCCESS)) {
    echo "success: Account Created successfully - " . implode($SUCCESS, ", ");
    if (count($ERROR)) {
        echo "<br /><hr />";
        $buff = "";
        foreach ($ERROR as $user => $msg) {
            $buff .= $user . " - " . $msg . " <br />";
        }
        echo "Error: " . $buff;
    }
} else {
    echo "error:";
    if (count($ERROR)) {
        echo "";
        $buff = "";
        foreach ($ERROR as $user => $msg) {
            $buff .= $user . " - " . $msg . " <br />";
        }
        echo " " . $buff;
    }
}

?>