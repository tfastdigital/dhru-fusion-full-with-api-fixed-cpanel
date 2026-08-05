<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$checkParameter[] = "ID";
if (!$parameters["SERVER"]) {
    $checkParameter[] = "IMEI";
}
$apiresults = checkParameters($checkParameter);
$orderfrom = 1;
if (!$apiresults["ERROR"]) {
    $parameters2 = $parameters;
    $parameters = $apiresults;
    logAdminActivity($parameters["ID"] . "=_=");
    $sid = ($parameters["ID"] - 5) / 9;
    logAdminActivity($sid . "===");
    $id = md5(($parameters["ID"] - 5) / 9);
    $result = dquery("SELECT `order_id` FROM `tbl_order_imei` WHERE `imei` = '" . $parameters["IMEI"] . "' AND `service_id`='" . $sid . "' AND `user_id`='" . $UserDetails["id"] . "' AND (`user_can_c`='0' OR `user_can_c`='1')  ");
    $isimeiavalable = mysqli_fetch_assoc($result);
    if ($isimeiavalable["order_id"] != "" && 2 <= $reqversion && !$parameters["SERVER"]) {
        $apiresults["SUCCESS"][] = ["MESSAGE" => "Duplicate Order Found", "REFERENCEID" => $isimeiavalable[order_id]];
    } else {
        require ROOTDIR . "/includes/imeiservices.fun.php";
        if (!$parameters["SERVER"]) {
            $serviceDetails = getIMEIServices("", $id, $UserDetails["id"], true, false, "");
        } else {
            $serviceDetails = getIMEIServices("", $id, $UserDetails["id"], true, false, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", $parameters["SERVER"]);
        }
        $imei_custom = $imei_bulk = $parameters["IMEI"];
        if ($serviceDetails["qnt"]) {
            $qnt = $parameters["QNT"] ? $parameters["QNT"] : $parameters["QUANTITY"];
        } else {
            $qnt = 1;
        }
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
        } else {
            if (isset($parameters2["SERIAL_NUMBER"])) {
                $parameters2["Serial No"] = $parameters2[SERIAL_NUMBER];
            }
            if (isset($parameters2["USERTYPE"])) {
                $parameters2["User Type"] = $parameters2[USERTYPE];
            }
            $parameters["CUSTOMFIELD"] = $parameters2;
        }
        foreach ($customfields as $value) {
            if ($value["name"]) {
                $fieldvalueee = NULL;
                if (is_array($parameters["CUSTOMFIELD"])) {
                    $fieldvalueee = NULL;
                    foreach ($parameters["CUSTOMFIELD"] as $ks => $vs) {
                        if (strtolower($ks) == strtolower($value["name"]) || in_array($ks, $value["mapping"])) {
                            $fieldvalueee = $vs;
                        }
                    }
                }
                $customfileds[$value["id"]] = $fieldvalueee;
            }
        }
        $customfield = $customfileds;
        $time = time() + 30;
        $sql = "SELECT * from `tbl_order_imei` where `user_id`='" . $_ClientsDetails["id"] . "'\n        AND `imei`='" . $imei_custom . "' AND  (`user_can_c`=0 OR `user_can_c`=1 )        and time<" . $time;
        $countRows = dquery($sql);
        if (mysqli_num_rows($countRows) == 0 || $parameters["SERVER"]) {
            if ($error = placeOrderIMEIvalidation($serviceDetails["reqredfield"], true, "", $serviceDetails)) {
                $error = explode(":", $error);
                if (trim($error[1]) == "Service Not Active") {
                    $errorno = "Service Not Active";
                } else {
                    $errorno = "ValidationError123" . $isimeiavalable["order_id"];
                }
                $apiresults["ERROR"][] = ["MESSAGE" => $errorno, "FULL_DESCRIPTION" => strip_tags(str_replace("<li>", ",", $error[1]))];
            } else {
                if ($error = creditProcessIMEI($_ClientsDetails, $serviceDetails)) {
                    $_status = explode(":", $error);
                    if ($_status[0] == "success") {
                        $apiresults["SUCCESS"][] = ["MESSAGE" => "Order received", "REFERENCEID" => $_status[2]];
                    } else {
                        $apiresults["ERROR"][] = ["MESSAGE" => "CreditprocessError", "FULL_DESCRIPTION" => $error];
                    }
                }
            }
        } else {
            $OrderDetails = mysqli_fetch_assoc($sql);
            if (0 < $OrderDetails["order_id"]) {
                $apiresults["SUCCESS"][] = ["MESSAGE" => "Order received", "REFERENCEID" => $OrderDetails["order_id"]];
                $log = new Log("clientapi");
                $log->Info("Order reply success due to duplicate order found " . $OrderDetails["order_id"]);
                $log->logEnd();
            }
        }
    }
    unset($NewServiceDetails);
    unset($ServiceDetails);
}

?>