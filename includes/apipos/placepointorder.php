<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
require_once ROOTDIR . "/includes/imeiservices.fun.php";
$checkParameter[] = "serviceid";
$checkParameter[] = "qnt";
$apiresults = checkParameters($checkParameter);
if (!$apiresults["ERROR"]) {
    $ServiceID = $apiresults["serviceid"];
    $Qnt = $apiresults["qnt"];
    $qnt = $Qnt;
    $model_id = $parameters["modelid"];
    $mep = $parameters["mep"];
    $provider_id = $parameters["providerid"];
    $PIN = $parameters["PIN"];
    $KBH = $parameters["KBH"];
    $PRD = $parameters["PRD"];
    $SN = $parameters["SN"];
    $note = $notes = $parameters["notes"];
    if ($customfield) {
        $customfield = base64_decode($customfield);
        $bbc = json_decode($customfield, true);
        $customfield = $bbc;
    }
    $SecRO = $parameters["SecRO"];
    $Type = $parameters["Type"];
    $Reference = $parameters["Reference"];
    $imei_mobile = $parameters["imei"];
    global $model_id;
    global $provider_id;
    global $note;
    global $notes;
    global $PIN;
    global $KBH;
    global $PRD;
    global $mep;
    global $SN;
    global $SecRO;
    global $Type;
    global $Reference;
    global $imei_mobile;
    global $qnt;
    $_SESSION["uid"] = $UserDetails["id"];
    global $customfield;
    $serviceDetails = getIMEIServicesNew("", md5($ServiceID), $UserDetails["id"], true, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", $Qnt);
    $id = $serviceDetails["id"];
    global $id;
    $serviceDetails["reqredfield"]["customimeiname"] = $serviceDetails["imei_custom_name"];
    if ($error = placeOrderIMEIvalidation($serviceDetails["reqredfield"], true, "", $serviceDetails, true)) {
        $apiresults["ERROR"][] = ["message" => " " . strip_tags($error)];
    }
    if (!$apiresults["ERROR"]) {
        $msg = creditProcessIMEI($UserDetails, $serviceDetails, "", true);
        $out = explode(":", strip_tags($msg));
        if (trim($out[0]) == "error") {
            $apiresults["ERROR"][] = ["message" => " " . $out[1]];
        } else {
            dquery("UPDATE tbl_order_imei SET posterminalid='" . $TerminalDetail["posterminalid"] . "' \n            ORDER BY order_id desc limit 1");
            $orderid = trim($out[2]);
            $result = mysqli_fetch_assoc(dquery("select reply,note,credit,qnt,verifydata,date from tbl_order_imei where order_id='" . $orderid . "'"));
            if ($result["verifydata"]) {
                $result["verifydata"] = json_decode($result["verifydata"], true);
            }
            if (count($result["verifydata"]) == 1) {
                unset($result["verifydata"]);
            }
            $soldkey = mysqli_fetch_assoc(dquery("select expiredon from tbl_swkey\nwhere tbl_swkey.id=(select keyid from tbl_used_key where orderid='" . $orderid . "' limit 1)"));
            $apiresults["SUCCESS"][] = ["message" => "Order Placed Successfully", "Order Details" => $out[1], "date" => $result["date"], "service" => $serviceDetails["service_name"], "howtoinfo" => $serviceDetails["howtoinfo"], "orderid" => $orderid, "expiredon" => $soldkey["expiredon"], "qnt" => $result["qnt"], "note" => $result["note"], "code" => $result["reply"], "credit" => $result["credit"], "codearr" => $result["verifydata"]];
        }
    }
}

?>