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
if ($username && $password && $email) {
    if (mysqli_num_rows(dquery("select id from tbl_supplier where username='" . $username . "'")) == 0) {
        if (!preg_match("/^([a-zA-Z0-9])+([\\.a-zA-Z0-9+_-])*@([a-zA-Z0-9_-])+(\\.[a-zA-Z0-9_-]+)*\\.([a-zA-Z]{2,6})\$/", $email)) {
            echo "error:" . $LNG["clientareaerroremailinvalid"];
        } else {
            $data["username"] = $username;
            $data["password"] = md5(md5($password) . "9486");
            $data["email"] = $email;
            $data["phone"] = $phone;
            $data["address"] = $address;
            $data["country"] = $country;
            $data["userstatus"] = $status;
            $data["ac_create_dt"] = time();
            $data["imei_service_access"] = $imeiaccess;
            $data["file_service_access"] = $fileaccess;
            $data["server_log_access"] = $serveraccess;
            $data["shop_service_access"] = $shopaccess;
            $data["remote_service_access"] = $remoteaccess;
            $data["admin"] = $_SESSION["adminid"];
            if ($sid = $db->insert("tbl_supplier", $data)) {
                mkdir("../../images/gallery/supplier/" . $username, 493);
                $veta["access_key"] = md5($sup["id"] . $username);
                $db->update("tbl_supplier", $veta, "id=" . $sid);
                if ($sendmail) {
                    require_once ROOTDIR . "/includes/mail.fun.php";
                    $email_merge_fields["username"] = $username;
                    $email_merge_fields["password_uncrypt"] = $password;
                    sendMail(9, "", "", $email_merge_fields, false, "", "", trim($sid));
                }
                echo "success:" . $LNG["datasavesuccessfully"];
            } else {
                echo "error:" . $LNG["datanotsave"];
            }
        }
    } else {
        echo "error:" . $LNG["usernameisexist"];
    }
} else {
    echo "error:" . $LNG["field"] . " " . $LNG["required"];
}

?>