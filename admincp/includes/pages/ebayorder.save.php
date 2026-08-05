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
if ($sid && is_numeric($qnt) && 0 < $qnt && ($cid || $email)) {
    if (!preg_match("/^([a-zA-Z0-9])+([\\.a-zA-Z0-9+_-])*@([a-zA-Z0-9_-])+(\\.[a-zA-Z0-9_-]+)*\\.([a-zA-Z]{2,6})\$/", $email)) {
        echo "error:" . $LNG["clientareaerroremailinvalid"];
    } else {
        require_once ROOTDIR . "/includes/mail.fun.php";
        $uni = rand(999, 99999) . str_replace(",", "", $sid) . rand(999, 99999);
        $s = mysqli_fetch_assoc(dquery("select id,service_name \n        from tbl_services_imei where id='" . $sid . "'"));
        $data["email"] = $email;
        $data["sid"] = $sid;
        $data["cid"] = $_SESSION["system_default_currency"]["id"];
        $data["uid"] = $uni;
        $data["qnt"] = $qnt;
        $data["chargeable"] = $chargeable;
        $db->insert("tbl_private_order", $data);
        unset($data);
        $toemails[] = ["to" => $email];
        $email_merge_fields["service"] = $s["service_name"];
        $siteaddress = $config["site_address"];
        if ($config["config_ssl_allow"]) {
            $siteaddress = $config["config_ssl_allow"];
        }
        $email_merge_fields["link"] = _url("directorder/id/" . md5(sha1($uni)), true);
        sendMail(68, "", "", $email_merge_fields, true, "", "", "", $toemails);
        echo "success:" . $LNG["direct"] . " " . $LNG["order"] . " " . $LNG["generated"];
    }
} else {
    echo "error:" . $LNG["field"] . " " . $LNG["required"];
}

?>