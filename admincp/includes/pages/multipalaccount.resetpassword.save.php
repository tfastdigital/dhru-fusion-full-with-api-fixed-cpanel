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
if ($group) {
    $WHERE .= " and client_group='" . $group . "'";
}
if ($statuss) {
    $WHERE .= " and userstatus='" . $statuss . "'";
}
if ($reseller) {
    $WHERE .= " and reseller_id='" . $reseller . "'";
}
if ($checkall) {
    unset($user);
    $result = dquery("select id from tblUsers where \n   ( usertype=0 or usertype=1 ) " . $WHERE);
    while ($row = mysqli_fetch_assoc($result)) {
        $user[$row["id"]] = $row["id"];
    }
}
global $passenc;
if ($user) {
    logActivityGlobal("Password update [" . $user . "]", "multipleaccount", "", "admin");
    if (!is_array($user)) {
        $user = explode(",", $user);
    }
    if ($sendmail) {
        if (!function_exists(sendMail)) {
            include_once ROOTDIR . "/includes/mail.fun.php";
        }
        foreach ($user as $value) {
            $password = createP("", "8");
            $data["password"] = md5(md5($password) . $passenc);
            $data["lastpassreset"] = time();
            if ($db->update("tblUsers", $data, "id=" . $value)) {
                $mailmerge["password"] = $password;
                sendMail("10", $value, "", $mailmerge, true);
            }
        }
        echo "success:" . $LNG["password"] . " " . $LNG["reset"] . " " . $LNG["successfully"] . " ";
    } else {
        foreach ($user as $value) {
            $password = createP("", "8");
            $data["password"] = md5(md5($password) . $passenc);
            $db->update("tblUsers", $data, "id=" . $value);
        }
        echo "success:" . $LNG["password"] . " " . $LNG["reset"] . " " . $LNG["successfully"] . " ";
    }
} else {
    echo "error:" . $LNG["user"] . " " . $LNG["not"] . "  " . $LNG["selected"] . " ";
}

?>