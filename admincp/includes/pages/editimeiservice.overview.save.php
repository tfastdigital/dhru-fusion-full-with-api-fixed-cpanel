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
dquery("update tbl_service_status set status=0 where serviceid='" . $id . "' and groupid!='retail'");
foreach ($status as $groupsnm => $vals) {
    if ($vals == 1) {
        if (mysqli_num_rows(dquery("select servicestatusid from tbl_service_status\n    where groupid='" . $groupsnm . "' and serviceid='" . $id . "'"))) {
            dquery("update tbl_service_status set status=1 where groupid='" . $groupsnm . "'\n        and serviceid='" . $id . "'");
        } else {
            dquery("insert into tbl_service_status (groupid,serviceid,status)\n            values ('" . $groupsnm . "','" . $id . "','1')");
        }
    }
}
if ($sendnotification && $config["slack_servicestat"]) {
    $srvrarr = explode("#", $servicename);
    if ($srvrarr[1]) {
        $servicename1 = "<b>" . $srvrarr[0] . "#</b>" . $srvrarr[1];
    } else {
        $servicename1 = $servicename;
    }
    if ($status["base"] == 0) {
        $emojica = "🔴";
        sendtoChannel($config["slack_servicestat"], urlencode(json_decode("\"" . $emojica . "\"") . " Service Inactive" . "\n\n" . $servicename1) . "&parse_mode=html");
    } else {
        $emojica = "🔵";
        sendtoChannel($config["slack_servicestat"], urlencode(json_decode("\"" . $emojica . "\"") . " Service Active" . "\n\n" . $servicename1) . "&parse_mode=html");
    }
}
if ($ebaycode) {
    $ebaycode = str_replace(" ", "", $ebaycode);
    $ebc = explode(",", $ebaycode);
    $ebc = array_unique($ebc);
    $flag = false;
    foreach ($ebc as $e) {
        if ($e) {
            $num = dquery("select ebay_code from tbl_services_imei where (ebay_code LIKE '" . $e . "'\n            or ebay_code LIKE '" . $e . ",%' or ebay_code LIKE '%," . $e . "' or ebay_code LIKE '%," . $e . ",%') and (  id!='" . $id . "')");
            if (mysqli_num_rows($num)) {
                $flag = true;
                if ($flag) {
                    echo "error:" . $LNG["ebayused"];
                    exit;
                }
                if (isset($ebc)) {
                    $data["ebay_code"] = implode(",", $ebc);
                }
            }
        }
    }
} else {
    $data["ebay_code"] = "";
}
if (isset($features)) {
    $data["features"] = implode(",", $features);
}
$karrr = [];
$knowl = explode(",", html_entity_decode($knowledgebase));
foreach ($knowl as $kart) {
    $kart = str_replace("__", ",", $kart);
    $knowledeid = mysqli_fetch_assoc(dquery("select id from tbl_knowledgebase\nwhere title='" . $kart . "'"));
    $karrr[$knowledeid["id"]] = $knowledeid["id"];
}
if (0 < count($karrr)) {
    $data["knowledgebase"] = implode(",", $karrr);
}
$data["knowledgebaseas"] = $knowledgebaseas;
$data["hideguest"] = $hideguest;
$data["free"] = $free;
$data["colortag"] = $colortag;
$data["channelid"] = $telegramchannel;
$data["verificationdays"] = $verificationdays;
$data["priceslack"] = $priceslack;
$data["orderslack"] = $orderslack;
if ($status == 0) {
}
$data["service_name"] = html_entity_decode(str_replace("'", "", $servicename));
$data["group_id"] = $groupname;
$data["time"] = $time1 . " " . $timeref;
$data["service_type"] = $servicetype;
$data["maxresponsetime"] = $maxresponsetime;
$row = mysqli_fetch_assoc(dquery("select credit from tbl_services_imei\n where id=" . $id));
if ($row["credit"] != $credit) {
    $success = $LNG["credit"] . " " . $LNG["changed"] . " " . $LNG["resetdiscount"];
    $success .= "<li>" . $LNG["please"] . "  " . $LNG["manage"] . " " . $LNG["other"] . " " . $LNG["currency"] . " </li>";
}
$data["autoreply"] = $autoreply;
$data["autoreplycompleted"] = $autoreplycompleted;
$data["autorejectduplicate"] = $autorejectduplicate;
$data["verifiable"] = $verification;
$data["smsnotification"] = $smsnotification;
$data["usercan_cancel"] = $cancel;
$data["icon_link"] = $iconlink;
$data["download_link"] = $downloadlink;
$data["faq_id"] = $faq;
$data["notification_mail"] = $notificationmail;
$data["template_id1"] = $template1;
$data["template_id2"] = $template2;
$data["notificationemail"] = $notificationemail;
$data["newservice"] = 0;
$data["lastupdatedtime"] = time();
$data["lasteditedby"] = $_SESSION["adminid"];
if ($db->update("tbl_services_imei", $data, "id=" . $id)) {
    echo "success:<li>" . $LNG["datasavesuccessfully"] . "</li><li>" . $success . "</li>";
} else {
    echo "error:" . $LNG["datanotsave"];
}
echo " ";

?>