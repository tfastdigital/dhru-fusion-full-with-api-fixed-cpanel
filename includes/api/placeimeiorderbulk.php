<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$apiresults = NULL;
defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
if (!($JsonParameter = json_decode(base64_decode(trim($parameters)), true))) {
    $apiresultsbulk["ERROR"][] = ["MESSAGE" => "Parameter Not Valid for Bulk entry"];
}
$orderfrom = 1;
foreach ($JsonParameter as $key => $parameters) {
    $checkParameter[] = "ID";
    $checkParameter[] = "IMEI";
    $apiresults[$key] = checkParameters($checkParameter);
    if (!$apiresults[$key]["ERROR"]) {
        $parameters = $apiresults[$key];
        $sid = ($parameters["ID"] - 5) / 9;
        $id = md5(($parameters["ID"] - 5) / 9);
        $result = dquery("SELECT `order_id` FROM `tbl_order_imei` \r\n    WHERE `imei` = '" . $parameters["IMEI"] . "' AND `service_id`='" . $sid . "' AND `user_id`='" . $UserDetails["id"] . "' AND (`user_can_c`='0' OR `user_can_c`='1')  ");
        $isimeiavalable = mysqli_fetch_assoc($result);
        if ($isimeiavalable["order_id"] != "" && 2 <= $reqversion) {
            exit;
        }
        require_once ROOTDIR . "/includes/imeiservices.fun.php";
        $serviceDetails = getIMEIServices("", $id, $UserDetails["id"], true, false, "");
        $imei_custom = $imei_bulk = $parameters["IMEI"];
        $model_id = $parameters["MODELID"];
        $provider_id = $parameters["PROVIDERID"];
        $network_id = $parameters["NETWORKID"];
        $mep = $parameters["MEP"];
        $PIN = $parameters["PIN"];
        $KBH = $parameters["KBH"];
        $PRD = $parameters["PRD"];
        $Type = $parameters["TYPE"];
        $Reference = $parameters["REFERENCE"];
        $Locks = $parameters["LOCKS"];
        $SN = $parameters["SN"];
        $SecRO = $parameters["SecRO"];
        $customfields = getCustomFields("serviceimei", $sid, "", "on");
        if ($parameters["CUSTOMFIELD"]) {
            $parameters["CUSTOMFIELD"] = json_decode(base64_decode($parameters["CUSTOMFIELD"]), true);
        }
        foreach ($customfields as $value) {
            if ($value["required"] == "*") {
                $fieldvalueee = NULL;
                if (is_array($parameters["CUSTOMFIELD"])) {
                    $fieldvalueee = NULL;
                    foreach ($parameters["CUSTOMFIELD"] as $ks => $vs) {
                        if ($ks == $value["name"]) {
                            $fieldvalueee = $vs;
                        }
                    }
                }
                $customfileds[$value["id"]] = $fieldvalueee;
            }
        }
        $customfield = $customfileds;
        if ($error = placeOrderIMEIvalidation($serviceDetails["reqredfield"], true)) {
            $error = explode(":", $error);
            if ($error == "Service Not Active") {
                $errorno = "Service Not Active";
            } else {
                $errorno = "ValidationError123" . $isimeiavalable["order_id"];
            }
            $apiresultsbulk[$key]["ERROR"][] = ["MESSAGE" => $errorno, "FULL_DESCRIPTION" => strip_tags(str_replace("<li>", ",", $error[1]))];
        } else {
            if ($error = creditProcessIMEI($_ClientsDetails, $serviceDetails)) {
                $_status = explode(":", $error);
                if ($_status[0] == "success") {
                    $apiresultsbulk[$key]["SUCCESS"][] = ["MESSAGE" => "Order received", "REFERENCEID" => $_status[2]];
                } else {
                    $apiresultsbulk[$key]["ERROR"][] = ["MESSAGE" => "CreditprocessError", "FULL_DESCRIPTION" => $error];
                }
            }
        }
        unset($NewServiceDetails);
        unset($ServiceDetails);
    }
}
$apiresults = $apiresultsbulk;

?>