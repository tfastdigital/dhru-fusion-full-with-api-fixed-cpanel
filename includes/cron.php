<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("API", true);
error_reporting(0);
require "../comm.php";
if (!$autho && $a) {
    $autho = $a;
}
if (strpos($action, "fusionfile") !== false) {
    $service = "file";
}
if ($config["cron_password"] && $config["cron_password"] != $autho) {
    echo "Authentication failed <br/>" . $remote_ip;
    exit;
}
if ($config["seperatecron"]) {
    if (!stripos($action, "get") !== false && !stripos($action, "send") !== false && !stripos($action, "updateprice") !== false) {
        echo "Separated Cron command required <br />Please check Settings->APi Settings->Cron Settings";
        exit;
    }
} else {
    if (stripos($action, "get") !== false || stripos($action, "send") !== false) {
        echo "Separated Cron command not allowed <br />Please check Settings->APi Settings->Cron Settings";
        exit;
    }
}
$action = preg_replace("[^A-Za-z0-9_]", "", $action);
$apiserver = preg_replace("[^A-Za-z0-9_]", "", $apiserver);
$pid = new FusionCronProcess(ROOTDIR . "/" . $config["admin_directory"] . "/tmp/", $action);
if ($pid->already_running) {
    exit;
}
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/apiserver.fun.php";
require_once ROOTDIR . "/includes/customfield.fun.inc.php";
$sendlimitperround = preg_replace("[^0-9]", "", $sendlimitperround);
$getlimitperround = preg_replace("[^0-9]", "", $getlimitperround);
$add_query_file = "";
$testsendorder = 0;
$testgetorder = 0;
if ($action == "helpXXX") {
    exit;
}
if ($action != "") {
    $_action = explode("_", $action);
    list($action, $action_sendget) = $_action;
    $add_query = "and ( ORDERAPI='" . $action . "' or API='" . $action . "') ";
    $add_query_file = "and api='" . $action . "'";
    unset($_action);
} else {
    $add_query = "";
}
if (!$sendlimitperround) {
    $sendlimitperround = $config["cronsendbatchorder"] ? $config["cronsendbatchorder"] : 100;
}
if (!$getlimitperround) {
    $getlimitperround = $config["crongetbatchorder"] ? $config["crongetbatchorder"] : 100;
}
if (!$service) {
    $service = "imei";
}
$orderforsendorget = 0;
if (isset($action_sendget) && $action_sendget == "send" || $action_sendget == "") {
    if ($service == "imei") {
        $time = time();
        $query = dquery("SELECT tbl_order_imei.*,verifyforreject,tbl_services_imei.API,tbl_services_imei.API_ID,tbl_services_imei.service_name,tbl_services_imei.API_TYPEID,tbl_services_imei.imei_custom_name\n        FROM tbl_order_imei,tbl_services_imei\n        WHERE ( `fetchapitime` = '' or `fetchapitime` IS NULL or fetchapitime < " . $time . " ) and\n        user_can_c='0' and \n        ( (ORDERAPI!='' and ORDERAPI_ID!='' )\n        or (API!='' and API_ID!='')\n        )\n         and tbl_order_imei.service_id=tbl_services_imei.id " . $add_query . " and autosend=0 \n        LIMIT 0 , " . $sendlimitperround);
        global $email_merge_fields;
        if (mysqli_num_rows($query)) {
            $___sendnoticeclount = 1;
            unset($FUNVARBULK);
            $SendServer = "";
            while ($Data = mysqli_fetch_assoc($query)) {
                if ($Data["ORDERAPI"]) {
                    $Data["API"] = $Data["ORDERAPI"];
                    $Data["API_ID"] = $Data["ORDERAPI_ID"];
                }
                $FUNVAR = NULL;
                $FUNVAR["API"] = $Data["API"];
                $SendServer = $FUNVAR["API"];
                $FUNVAR["API_ID"] = $Data["API_ID"];
                $FUNVAR["API_TYPEID"] = $Data["API_TYPEID"];
                $FUNVAR["USERID"] = $Data["user_id"];
                $FUNVAR["SERVICEID"] = $Data["service_id"];
                $FUNVAR["ORDERID"] = $Data["order_id"];
                $FUNVAR["IMEI"] = $Data["imei"];
                $FUNVAR["IMEI_CUSTOM_NAME"] = $Data["imei_custom_name"];
                $FUNVAR["SERVICE_NAME"] = $Data["service_name"];
                $FUNVAR["SERVER"] = $Data["server"];
                $FUNVAR["QNT"] = $Data["qnt"];
                if ($Data["model_id"]) {
                    $FUNVAR["MODEL_ID"] = $Data["model_id"];
                    $MODEL = mysqli_fetch_assoc(dquery("SELECT * FROM tbl_mobile WHERE ID='" . $Data["model_id"] . "'"));
                    $FUNVAR["MODEL"] = $MODEL["Name"];
                    $FUNVAR["API_MODEL_ID"] = $MODEL["apiid"];
                    $BRAND = mysqli_fetch_assoc(dquery("SELECT * FROM tbl_model_brand WHERE ID='" . $MODEL["B_ID"] . "'"));
                    $FUNVAR["BRAND_ID"] = $BRAND["ID"];
                    $FUNVAR["BRAND"] = $BRAND["Name"];
                    $FUNVAR["API_BRAND_ID"] = $BRAND["apiid"];
                    unset($BRAND);
                    unset($MODEL);
                }
                if ($Data["provider_id"]) {
                    $FUNVAR["PROVIDER_ID"] = $Data["provider_id"];
                    $PROVIDER = mysqli_fetch_assoc(dquery("SELECT * FROM tbl_provider WHERE ID='" . $Data["provider_id"] . "'"));
                    $FUNVAR["PROVIDER"] = $PROVIDER["Name"];
                    $FUNVAR["API_PROVIDER_ID"] = $PROVIDER["apiid"];
                    $COUNTRY = mysqli_fetch_assoc(dquery("SELECT * FROM tbl_provider_country WHERE ID='" . $PROVIDER["C_ID"] . "'"));
                    $FUNVAR["PROVIDER_COUNTRY_ID"] = $COUNTRY["ID"];
                    $FUNVAR["PROVIDER_COUNTRY"] = $COUNTRY["Name"];
                    $FUNVAR["API_PROVIDER_COUNTRY_ID"] = $COUNTRY["apiid"];
                    $FUNVAR["API_PROVIDER_COUNTRY_NEW_MEP"] = $COUNTRY["mep_new"];
                    $FUNVAR["API_PROVIDER_COUNTRY_OLD_MEP"] = $COUNTRY["mep_old"];
                    unset($COUNTRY);
                    unset($PROVIDER);
                }
                if ($Data["network_id"]) {
                    $FUNVAR["NETWORK_ID"] = $Data["network_id"];
                    $NETWORK = mysqli_fetch_assoc(dquery("SELECT * FROM tbl_network WHERE ID='" . $Data["network_id"] . "'"));
                    $FUNVAR["NETWORK"] = $NETWORK["Name"];
                    $FUNVAR["API_NETWORK_ID"] = $NETWORK["apiid"];
                    unset($NETWORK);
                }
                if ($Data["mep"]) {
                    $FUNVAR["MEP_ID"] = $Data["mep"];
                    $MEP = mysqli_fetch_assoc(dquery("SELECT * FROM tbl_mep WHERE ID='" . $Data["mep"] . "'"));
                    $FUNVAR["MEP"] = $MEP["mep"];
                    $FUNVAR["API_MEP_ID"] = $MEP["apiid"];
                    unset($MEP);
                }
                $FUNVAR["PIN"] = $Data["PIN"];
                $FUNVAR["KBH"] = $Data["KBH"];
                $FUNVAR["PRD"] = $Data["PRD"];
                $FUNVAR["TYPE"] = $Data["Type"];
                $FUNVAR["REFERENCEe"] = $Data["Reference"];
                $FUNVAR["LOCKS"] = $Data["Locks"];
                $FUNVAR["CUSTOMFIELDS"] = getCustomFields("serviceimei", $FUNVAR["SERVICEID"], $Data["order_id"], "on");
                foreach ($FUNVAR["CUSTOMFIELDS"] as $fieldid => $fieldvalues) {
                    if (is_array($fieldvalues["mapping"])) {
                        foreach ($fieldvalues["mapping"] as $mapkey => $mapval) {
                            $fieldvalues["name"] = $mapval;
                            $FUNVAR["CUSTOMFIELDS"][] = $fieldvalues;
                        }
                    }
                }
                $FUNVAR["SN"] = $Data["SN"];
                $FUNVAR["SecRO"] = $Data["SecRO"];
                $FUNVAR["ICloudEmail"] = $Data["ICloudEmail"];
                $FUNVAR["ICloudPhone"] = $Data["ICloudPhone"];
                $apisaveddetails = loadApiModule($Data["API"], false);
                foreach ($apisaveddetails as $k => $v) {
                    $FUNVAR[$k] = $v;
                }
                if ($debug_output) {
                    echo "<h2>Send Order Array</h2>";
                    print_r($FUNVAR);
                    echo "<hr />";
                }
                if (file_exists(ROOTDIR . "/modules/apiserver/" . $Data["API"] . ".php")) {
                    require_once ROOTDIR . "/modules/apiserver/" . $Data["API"] . ".php";
                }
                $check_orderstatus = mysqli_fetch_assoc(dquery("SELECT order_id FROM tbl_order_imei WHERE user_can_c='0' and order_id='" . $Data["order_id"] . "' "));
                if ($check_orderstatus["order_id"] && function_exists($Data["API"] . "_send")) {
                    include_once ROOTDIR . "/includes/imeiservices.fun.php";
                    $FUNVAR["version"] = $config["version"];
                    if ($config["seperatecron"] && $apisaveddetails["bulk"]) {
                        foreach ($apisaveddetails as $k => $v) {
                            unset($FUNVAR[$k]);
                        }
                        $FUNVARBULK["orders"][$Data["order_id"]] = $FUNVAR;
                    } else {
                        $SEND = call_user_func($Data["API"] . "_send", $FUNVAR);
                        if ($SEND) {
                            $testsendorder++;
                            if (!$SEND["SUCCESS"]) {
                                $newapi = getNextAPi($Data["ORDERAPI"], $Data["ORDERAPI_ID"], $Data["service_id"], $Data["ORDERAPI_TYPEID"]);
                                if ($newapi["api_server"]) {
                                    apiLog($FUNVAR["API"], $SEND, "SUCCESS 2", $newapi[api_server_id], true, $Data["service_id"]);
                                    dquery("update tbl_order_imei set user_can_c=0,ORDERAPI='" . $newapi["api_server"] . "',ORDERAPI_ID='" . $newapi["api_server_id"] . "',ORDERAPI_TYPEID='" . $newapi["api_server_typeid"] . "' where order_id='" . $Data["order_id"] . "'");
                                }
                            }
                            if ($SEND["SUCCESS"]) {
                                if (!$SEND["ID"]) {
                                    $SEND["ID"] = $Data["imei"];
                                }
                                if ($SEND["CODES"]) {
                                    replySuccessIMEI(md5($Data["order_id"]), $SEND["CODES"], "", "", $FUNVAR["API"], "", "", $Data["order_id"]);
                                } else {
                                    $ctime = time();
                                    dquery("UPDATE tbl_order_imei \n                                    SET user_can_c='1',acceptedtime='" . $ctime . "',ex_oid='" . $SEND["ID"] . "' WHERE order_id='" . $Data["order_id"] . "'");
                                }
                                apiLog($FUNVAR["API"], $SEND, "SUCCESS", $FUNVAR["API_ID"], 1, $Data["service_id"]);
                            } else {
                                if (preg_match_all("/(invalid).*?(id)/i", $SEND["ERROR"], $math) || $SEND["ERROR"] == "CreditprocessError" || $SEND["ERROR"] == "Authentication Failed" || $SEND["ERROR"] == "Invalid IP Request" || $SEND["ERROR"] == "Service Not Active" || stripos($SEND["ERROR"], "enough credit") !== false || stripos($SEND["ERROR"], "required") !== false || stripos($SEND["ERROR"], "authentication") !== false || stripos($SEND["ERROR"], "not have enough") !== false || deregi("enough credit", $SEND["ERROR"]) || deregi("not have enough", $SEND["ERROR"]) || deregi("enough", $SEND["ERROR"]) || deregi("credits have", $SEND["ERROR"]) || deregi("enough credits", $SEND["MESSAGE"]) || deregi("not have enough", $SEND["MESSAGE"]) || deregi("credits have", $SEND["MESSAGE"]) || deregi("credits have been finished", $SEND["ERROR"])) {
                                    updateAPiServer($FUNVAR["API"], "LastError", $SEND["ERROR"]);
                                    if ($SEND["ERROR"] == "Service Not Active" || preg_match_all("/(invalid).*?(id)/i", $SEND["ERROR"], $math)) {
                                        if (!$config["dontdiscconect"] == 1) {
                                            $query = dquery("UPDATE `tbl_services_imei` SET `API` = '', `API_ID` = ''   WHERE `id` = " . $Data["service_id"] . " ");
                                            $adminmessage = "Service \"" . $Data["service_name"] . "\" Automatically  deactivated due to service no longer active on your  \"" . $apisaveddetails["name"] . " " . $apisaveddetails["customname"] . "\" ";
                                            if ($Data["API"]) {
                                                include_once ROOTDIR . "/includes/mail.fun.php";
                                                sendNotification("system", "Service disconnected from api", $adminmessage, $mailto);
                                                logActivity($adminmessage);
                                                dquery("UPDATE tbl_order_imei \n                                            SET\tORDERAPI_ID='',apierror='" . $adminmessage . "'  WHERE order_id='" . $Data["order_id"] . "'");
                                                unset($adminmessage);
                                            }
                                        }
                                    } else {
                                        $fetchapitime = strtotime("+6 hour");
                                        dquery("UPDATE tbl_order_imei SET \n                                    fetchapitime='" . $fetchapitime . "',apierror='" . $SEND["ERROR"] . ":" . $SEND["MESSAGE"] . "' WHERE \n                                    order_id='" . $Data["order_id"] . "'");
                                        apiLog($FUNVAR["API"], $SEND, $SEND[ERROR], $FUNVAR["API_ID"], 1, $Data["service_id"]);
                                        $adminmessage = "APi order #" . $Data["order_id"] . " not sent , due to " . $SEND[ERROR] . " on your  " . $apisaveddetails["name"] . " " . $apisaveddetails["customname"] . " <br /> <br /> Order will try to send again after next 6 hour  ";
                                        if ($___sendnoticeclount == 1) {
                                            include_once ROOTDIR . "/includes/mail.fun.php";
                                            sendNotification("system", "APi order not sent [" . $SEND["ERROR"] . "]", $adminmessage, $mailto);
                                            logActivity($adminmessage);
                                            sendMessenger($FUNVAR["name"], $Data["order_id"], $adminmessage);
                                            unset($adminmessage);
                                        }
                                        $___sendnoticeclount += 1;
                                    }
                                } else {
                                    $logid = apiLog($FUNVAR["API"], $SEND, "ERROR", $FUNVAR["API_ID"], 1, $Data["service_id"]);
                                    if ($Data["verifyforreject"]) {
                                        $VERIFY["message"] = $SEND["MESSAGE"];
                                        $VERIFY["API"] = $FUNVAR["API"];
                                        $VERIFY["apilogreferenceid"] = $logid;
                                        $verifydata = json_encode($VERIFY);
                                        dquery("UPDATE tbl_order_imei set user_can_c=8,verifydata='" . $verifydata . "',verifyreject=1 \n                                    where order_id='" . $Data["order_id"] . "'");
                                    } else {
                                        rejectIMEI(md5($Data["order_id"]), $SEND["MESSAGE"] . " ReferenceID " . $logid, "", "", $FUNVAR["API"], "", $Data["order_id"]);
                                    }
                                }
                            }
                        }
                        if ($debug_output) {
                            echo "<h2>_send : Call back Array</h2>";
                            displyOutput($SEND);
                            echo "<hr />";
                        }
                    }
                }
                unset($apisaveddetails);
            }
            if (is_array($FUNVARBULK)) {
                $FUNVARBULK = array_merge($apisaveddetails, $FUNVARBULK);
                $SEND = call_user_func($SendServer . "_send", $FUNVARBULK, true);
                foreach ($SEND as $k => $SEND) {
                    if ($SEND) {
                        $testsendorder++;
                        $Data = mysqli_fetch_assoc(dquery("SELECT \n                  order_id,service_id,imei,(select service_name from tbl_services_imei \n                  where id=service_id) as service_name FROM tbl_order_imei  WHERE order_id='" . $k . "'"));
                        if ($SEND["SUCCESS"]) {
                            if (!$SEND["ID"]) {
                                $SEND["ID"] = $Data["imei"];
                            }
                            if ($SEND["CODES"]) {
                                replySuccessIMEI(md5($Data["order_id"]), $SEND["CODES"], "", "", $apisaveddetails["apiservers"], "", "", $Data["order_id"]);
                            } else {
                                $ctime = time();
                                dquery("UPDATE tbl_order_imei \n                                    SET user_can_c='1',ex_oid='" . $SEND["ID"] . "',acceptedtime='" . $ctime . "' WHERE order_id='" . $Data["order_id"] . "'");
                            }
                            apiLog($apisaveddetails["apiservers"], $SEND, "SUCCESS", $apisaveddetails["id"], 1, $Data["service_id"]);
                        } else {
                            if (preg_match_all("/(invalid).*?(id)/i", $SEND["ERROR"], $math) || $SEND["ERROR"] == "CreditprocessError" || $SEND["ERROR"] == "Authentication Failed" || $SEND["ERROR"] == "Invalid IP Request" || $SEND["ERROR"] == "Service Not Active" || deregi("enough credits", $SEND["ERROR"]) || deregi("required", $SEND["ERROR"]) || deregi("authentication", $SEND["ERROR"]) || deregi("enough credits", $SEND["MESSAGE"]) || deregi("not have enough", $SEND["MESSAGE"]) || deregi("credits have", $SEND["MESSAGE"]) || deregi("not have enough", $SEND["ERROR"]) || deregi("credits have", $SEND["ERROR"]) || deregi("credits have been finished", $SEND["ERROR"])) {
                                updateAPiServer($apisaveddetails["apiservers"], "LastError", $SEND["ERROR"]);
                                if ($SEND["ERROR"] == "Service Not Active" || preg_match_all("/(invalid).*?(id)/i", $SEND["ERROR"], $math)) {
                                    if (!$config["dontdiscconect"] == 1) {
                                        $query = dquery("UPDATE `tbl_services_imei` SET `API` = '', `API_ID` = ''   WHERE `id` = " . $Data["service_id"] . " ");
                                        if ($Data["API"]) {
                                            $adminmessage = "Service \"" . $Data["service_name"] . "\" Automatically  deactivated due to service no longer active on your  \"" . $apisaveddetails["name"] . " " . $apisaveddetails["customname"] . "\" ";
                                            include_once ROOTDIR . "/includes/mail.fun.php";
                                            sendNotification("system", "Service disconnected from api", $adminmessage, $mailto);
                                            logActivity($adminmessage);
                                            dquery("UPDATE tbl_order_imei \n                                        SET\tORDERAPI_ID='',apierror='" . $adminmessage . "'  WHERE order_id='" . $Data["order_id"] . "'");
                                            unset($adminmessage);
                                        }
                                    }
                                } else {
                                    $fetchapitime = strtotime("+6 hour");
                                    dquery("UPDATE tbl_order_imei SET fetchapitime='" . $fetchapitime . "',apierror='" . $SEND["ERROR"] . ":" . $SEND["MESSAGE"] . "' WHERE \n                                    order_id='" . $Data["order_id"] . "'");
                                    apiLog($apisaveddetails["apiservers"], $SEND, "Not enough credit", $apisaveddetails["id"], true, $Data["service_id"]);
                                    $adminmessage = "APi order " . $Data["order_id"] . " not sent , due to " . $SEND[ERROR] . " on your  " . $apisaveddetails["name"] . " " . $apisaveddetails["customname"] . " <br /> <br /> Order will try to send again after next 6 hour  ";
                                    if ($___sendnoticeclount == 1) {
                                        include_once ROOTDIR . "/includes/mail.fun.php";
                                        sendNotification("system", "APi order not sent [" . $SEND["ERROR"] . "]", $adminmessage, $mailto);
                                        logActivity($adminmessage . "2");
                                        sendMessenger($FUNVAR["name"], $Data["order_id"], $adminmessage);
                                        unset($adminmessage);
                                    }
                                    $___sendnoticeclount += 1;
                                }
                            } else {
                                $logid = apiLog($apisaveddetails["apiservers"], $SEND, "ERROR", $apisaveddetails["id"], 1, $Data["service_id"]);
                                if ($Data["verifyforreject"]) {
                                    $VERIFY["message"] = $SEND["MESSAGE"];
                                    $VERIFY["API"] = $FUNVAR["API"];
                                    $VERIFY["apilogreferenceid"] = $apilogreferenceid;
                                    $verifydata = json_encode($VERIFY);
                                    dquery("UPDATE tbl_order_imei set user_can_c=8,verifydata='" . $verifydata . "',verifyreject=1 \n                                    where order_id='" . $Data["order_id"] . "'");
                                } else {
                                    rejectIMEI(md5($Data["order_id"]), $SEND["MESSAGE"] . " ReferenceID " . $logid, "", "", $apisaveddetails["apiservers"], "", $Data["order_id"]);
                                }
                            }
                        }
                    }
                }
            }
        }
    } else {
        if ($service == "file") {
            $query = dquery("SELECT tbl_order_file.*,tbl_services_file.API,tbl_services_file.API_ID\n        FROM tbl_services_file,tbl_order_file\n        WHERE user_can_c='0' and API!='' and API_ID!='' and service_id=id " . $add_query_file . "\n        LIMIT 0 , " . $sendlimitperround);
            global $email_merge_fields;
            while ($Data = mysqli_fetch_assoc($query)) {
                $FUNVAR = NULL;
                $FUNVAR["API"] = $Data["API"];
                $FUNVAR["API_ID"] = $Data["API_ID"];
                $FUNVAR["USERID"] = $Data["user_id"];
                $FUNVAR["SERVICEID"] = $Data["service_id"];
                $FUNVAR["ORDERID"] = $Data["order_id"];
                $FUNVAR["FILENAME"] = $Data["file"];
                if (file_exists(ROOTDIR . "/" . $donloaddirpath . "/" . $Data["file_enc"])) {
                    $fh = fopen(ROOTDIR . "/" . $donloaddirpath . "/" . $Data["file_enc"], "r");
                    $data = fread($fh, filesize(ROOTDIR . "/" . $donloaddirpath . "/" . $Data["file_enc"]));
                    fclose($fh);
                    $FUNVAR["FILEDATA"] = base64_encode($data);
                    if ($customfields = getCustomFields("servicefile", $FUNVAR["SERVICEID"], $Data["order_id"], "on")) {
                        $FUNVAR["CUSTOMFIELDS"] = $customfields;
                    }
                    $apisaveddetails = loadApiModule($Data["API"], false);
                    foreach ($apisaveddetails as $k => $v) {
                        $FUNVAR[$k] = $v;
                    }
                    unset($apisaveddetails);
                    if ($debug_output) {
                        echo "<h2>Send File Order Array</h2>";
                        print_r($FUNVAR);
                        echo "<hr />";
                    }
                    if (file_exists(ROOTDIR . "/modules/apiserver/" . $Data["API"] . ".php")) {
                        require_once ROOTDIR . "/modules/apiserver/" . $Data["API"] . ".php";
                    }
                    $check_orderstatus = mysqli_fetch_assoc(dquery("SELECT order_id FROM tbl_order_file WHERE user_can_c='0' and order_id='" . $Data["order_id"] . "' "));
                    if ($check_orderstatus["order_id"] && function_exists($Data["API"] . "_sendfile")) {
                        include_once ROOTDIR . "/includes/fileservices.fun.php";
                        $SEND = call_user_func($Data["API"] . "_sendfile", $FUNVAR);
                        if ($SEND) {
                            $testsendorder++;
                            if ($SEND["SUCCESS"]) {
                                if (!$SEND["ID"]) {
                                    $SEND["ID"] = $Data["order_id"];
                                }
                                $ctime = time();
                                dquery("UPDATE tbl_order_file SET user_can_c='1',ex_oid='" . $SEND["ID"] . "'\n                             WHERE order_id='" . $Data["order_id"] . "'");
                                apiLog($FUNVAR["API"], $SEND, "SUCCESS", $FUNVAR["API_ID"]);
                            } else {
                                $logid = apiLog($FUNVAR["API"], $SEND, "ERROR", $FUNVAR["API_ID"]);
                                rejectFile(md5($Data["order_id"]), $SEND["MESSAGE"] . " ReferenceID " . $logid, "", "", $FUNVAR["API"]);
                            }
                        }
                        if ($debug_output) {
                            echo "<h2>_sendfile : Call back Array</h2>";
                            displyOutput($SEND);
                            echo "<hr />";
                        }
                    }
                } else {
                    if ($debug_output) {
                        echo "<h2>Send File Order Array</h2>";
                        print_r($FUNVAR);
                        echo "Error : File Not Found<hr />";
                    }
                }
            }
        }
    }
}
if (isset($action_sendget) && $action_sendget == "get" || $action_sendget == "") {
    if ($service == "imei") {
        $fromcron = 1;
        unset($FUNVARBULK);
        $query = dquery("SELECT tbl_order_imei.*,tbl_services_imei.verifyforreject,tbl_services_imei.API,tbl_services_imei.API_ID\n        FROM tbl_order_imei,tbl_services_imei\n        WHERE user_can_c='1' and ( (ORDERAPI!='' and ORDERAPI_ID!='' )\n        or (API!='' and API_ID!='') )\n        and tbl_order_imei.service_id=tbl_services_imei.id " . $add_query . "\n        ORDER BY `tbl_services_imei`.`time` ASC\n        LIMIT 0 , " . $getlimitperround);
        if (mysqli_num_rows($query)) {
            $SendServer = "";
            while ($Data = mysqli_fetch_assoc($query)) {
                if ($Data["ORDERAPI"]) {
                    $Data["API"] = $Data["ORDERAPI"];
                    $Data["API_ID"] = $Data["ORDERAPI_ID"];
                }
                $FUNVAR = NULL;
                $FUNVAR["API"] = $Data["API"];
                $SendServer = $FUNVAR["API"];
                $FUNVAR["API_ID"] = $Data["API_ID"];
                $FUNVAR["USERID"] = $Data["user_id"];
                $FUNVAR["SERVICEID"] = $Data["service_id"];
                $FUNVAR["ORDERID"] = $Data["order_id"];
                $FUNVAR["IMEI"] = $Data["imei"];
                $FUNVAR["API_ORDER_ID"] = $Data["ex_oid"];
                $FUNVAR["SERVER"] = $Data["server"];
                $apisaveddetails = loadApiModule($Data["API"], false);
                foreach ($apisaveddetails as $k => $v) {
                    $FUNVAR[$k] = $v;
                }
                if ($debug_output) {
                    echo "<h2>Get Order Array</h2>";
                    print_r($FUNVAR);
                    echo "<hr />";
                }
                if (file_exists(ROOTDIR . "/modules/apiserver/" . $Data["API"] . ".php")) {
                    require_once ROOTDIR . "/modules/apiserver/" . $Data["API"] . ".php";
                }
                $check_orderstatus = mysqli_fetch_assoc(dquery("SELECT order_id,server \n                FROM tbl_order_imei WHERE user_can_c='1' and order_id='" . $Data["order_id"] . "' "));
                if ($check_orderstatus["order_id"] && function_exists($Data["API"] . "_get")) {
                    include_once ROOTDIR . "/includes/imeiservices.fun.php";
                    if ($config["seperatecron"] && $FUNVAR["bulkget"]) {
                        foreach ($apisaveddetails as $k => $v) {
                            unset($FUNVAR[$k]);
                        }
                        $FUNVARBULK["orders"][$Data["order_id"]] = $FUNVAR;
                    } else {
                        $SEND = call_user_func($Data["API"] . "_get", $FUNVAR);
                        if ($debug_output) {
                            echo "<h2>_get : Call back Array</h2>";
                            displyOutput($SEND);
                            echo "<hr />";
                        }
                        if ($SEND) {
                            if (!$SEND["SUCCESS"] && ($newapi = getNextAPi($Data["ORDERAPI"], $Data["ORDERAPI_ID"], $Data["service_id"], $Data["ORDERAPI_TYPEID"]))) {
                                apiLog($FUNVAR["API"], $SEND, "SUCCESS 1", $FUNVAR["API_ID"], "", $Data["service_id"], $check_orderstatus["server"]);
                                dquery("update tbl_order_imei set user_can_c=0,ORDERAPI='" . $newapi["api_server"] . "',ORDERAPI_ID='" . $newapi["api_server_id"] . "',ORDERAPI_TYPEID='" . $newapi["api_server_typeid"] . "' where order_id='" . $Data["order_id"] . "'");
                            } else {
                                if ($SEND["SUCCESS"]) {
                                    $testgetorder++;
                                    $apilogreferenceid = apiLog($FUNVAR["API"], $SEND, "SUCCESS", $FUNVAR["API_ID"], "", $Data["service_id"], $check_orderstatus["server"]);
                                    if ($SEND["CODES"]) {
                                        replySuccessIMEI(md5($Data["order_id"]), $SEND["CODES"], "", "", $FUNVAR["API"], $apilogreferenceid, "", $Data["order_id"]);
                                    }
                                    unset($apilogreferenceid);
                                } else {
                                    if (!$SEND["WATING"]) {
                                        $apilogreferenceid = apiLog($FUNVAR["API"], $SEND, "ERROR", $FUNVAR["API_ID"], "", $Data["service_id"], $check_orderstatus["server"]);
                                        if ($Data["verifyforreject"]) {
                                            $VERIFY["message"] = $SEND["MESSAGE"];
                                            $VERIFY["API"] = $FUNVAR["API"];
                                            $VERIFY["apilogreferenceid"] = $apilogreferenceid;
                                            $verifydata = json_encode($VERIFY);
                                            dquery("UPDATE tbl_order_imei set user_can_c=8,verifydata='" . $verifydata . "',verifyreject=1 \n                                    where order_id='" . $Data["order_id"] . "'");
                                        } else {
                                            rejectIMEI(md5($Data["order_id"]), $SEND["MESSAGE"], "", "", $FUNVAR["API"], $apilogreferenceid, $Data["order_id"]);
                                            unset($apilogreferenceid);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                logAdminActivity("6====");
            }
            logAdminActivity("2====");
            if (is_array($FUNVARBULK)) {
                $FUNVARBULK = array_merge($apisaveddetails, $FUNVARBULK);
                $SEND = call_user_func($SendServer . "_get", $FUNVARBULK, true);
                foreach ($SEND as $k => $SEND) {
                    logAdminActivity($SEND["SUCCESS"] . "====");
                    if ($SEND) {
                        if ($SEND["SUCCESS"]) {
                            $testgetorder++;
                            $apilogreferenceid = apiLog($apisaveddetails["apiservers"], $SEND, "SUCCESS", $apisaveddetails["id"], "", $Data["service_id"]);
                            if ($SEND["CODES"]) {
                                replySuccessIMEI(md5($k), $SEND["CODES"], "", "", $apisaveddetails["apiservers"], $apilogreferenceid, "", $k);
                            }
                            unset($apilogreferenceid);
                        } else {
                            if (!$SEND["WATING"]) {
                                $apilogreferenceid = apiLog($apisaveddetails["apiservers"], $SEND, "ERROR", $apisaveddetails["id"], "", $Data["service_id"]);
                                rejectIMEI(md5($k), $SEND["MESSAGE"], "", "", $apisaveddetails["apiservers"], $apilogreferenceid, $k);
                                unset($apilogreferenceid);
                            }
                        }
                    }
                }
            }
            if ($query) {
                replySuccessIMEI_sendmail();
            }
        }
    } else {
        if ($service == "file") {
            $query = dquery("SELECT tbl_order_file.*,tbl_services_file.API,tbl_services_file.API_ID\n        FROM tbl_services_file,tbl_order_file\n        WHERE user_can_c='1' and API!='' and API_ID!='' and service_id=id " . $add_query_file . "\n        LIMIT 0 , " . $sendlimitperround);
            global $email_merge_fields;
            while ($Data = mysqli_fetch_assoc($query)) {
                $FUNVAR = NULL;
                $FUNVAR["API"] = $Data["API"];
                $FUNVAR["API_ID"] = $Data["API_ID"];
                $FUNVAR["USERID"] = $Data["user_id"];
                $FUNVAR["SERVICEID"] = $Data["service_id"];
                $FUNVAR["ORDERID"] = $Data["order_id"];
                $FUNVAR["FILENAME"] = $Data["file"];
                $FUNVAR["API_ORDER_ID"] = $Data["ex_oid"];
                $apisaveddetails = loadApiModule($Data["API"], false);
                foreach ($apisaveddetails as $k => $v) {
                    $FUNVAR[$k] = $v;
                }
                unset($apisaveddetails);
                if ($debug_output) {
                    echo "<h2>Get File Order Array</h2>";
                    print_r($FUNVAR);
                    echo "<hr />";
                }
                if (file_exists(ROOTDIR . "/modules/apiserver/" . $Data["API"] . ".php")) {
                    require_once ROOTDIR . "/modules/apiserver/" . $Data["API"] . ".php";
                }
                $check_orderstatus = mysqli_fetch_assoc(dquery("SELECT order_id FROM tbl_order_file WHERE user_can_c='1' and order_id='" . $Data["order_id"] . "' "));
                if ($check_orderstatus["order_id"] && function_exists($Data["API"] . "_getfile")) {
                    include_once ROOTDIR . "/includes/fileservices.fun.php";
                    $SEND = call_user_func($Data["API"] . "_getfile", $FUNVAR);
                    if ($SEND) {
                        if ($SEND["SUCCESS"]) {
                            $testgetorder++;
                            if ($SEND["CODES"]) {
                                replySuccessFile(md5($Data["order_id"]), $SEND["CODES"], "", "", $FUNVAR["API"]);
                            }
                            apiLog($FUNVAR["API"], $SEND, "SUCCESS");
                        } else {
                            if (!$SEND["WATING"]) {
                                $logid = apiLog($FUNVAR["API"], $SEND, "ERROR");
                                rejectFile(md5($Data["order_id"]), $SEND["MESSAGE"] . "ReferenceID " . $logid, "", "", $FUNVAR["API"]);
                            }
                        }
                    }
                    if ($debug_output) {
                        echo "<h2>_getfile : Call back Array</h2>";
                        displyOutput($SEND);
                        echo "<hr />";
                    }
                }
            }
        }
    }
}
if (isset($action_sendget) && $action_sendget == "updateprice") {
    $log = new Log("apiautoprice");
    include_once ROOTDIR . "/includes/apiserver.fun.php";
    $updateonlyserviceprice = 1;
    $apisaveddetails = loadApiModule($action, false);
    require_once ROOTDIR . "/modules/apiserver/" . $action . ".php";
    $Res = syncApi($action, false, "services", "");
}
if (isset($_SESSION["adminid"]) && $test == 1) {
    echo "Cron execute successfully. Order Send :" . $testsendorder . " Order Get: " . $testgetorder;
    exit;
}
class FusionCronProcess
{
    protected $filename = NULL;
    public $already_running = false;
    public function __construct($directory, $apiserver)
    {
        if ($apiserver) {
            $apiserver = "." . $apiserver;
        }
        if (stripos($apiserver, "php") !== false) {
            exit;
        }
        $this->filename = $directory . "/" . basename($_SERVER["PHP_SELF"]) . $apiserver . ".pid";
        if (is_writable($this->filename) || is_writable($directory)) {
            if (file_exists($this->filename)) {
                $_pid = trim(file_get_contents($this->filename));
                $_pid = explode("-", $_pid);
                $pid = (int) $_pid[0];
                if (posix_kill($pid, 0) && $_pid[1] == $apiserver) {
                    $this->already_running = true;
                }
            }
            if (file_exists($this->filename)) {
                $_cur_time = time();
                $pid_time = filectime($this->filename) + 900;
                if ($pid_time < $_cur_time) {
                    unlink($this->filename);
                }
            }
            if (!$this->already_running) {
                $pid = getmypid();
                file_put_contents($this->filename, $pid . "-" . $apiserver);
            }
            unset($apiserver);
        } else {
            exit("ERROR #404");
        }
    }
    public function __destruct()
    {
        if (!$this->already_running && file_exists($this->filename) && is_writeable($this->filename)) {
            unlink($this->filename);
        }
    }
}
function sendMessenger($APIName, $OrderId, $adminmessage)
{
    global $config;
    if ($config["slack_apilowcredit"]) {
        $_cols[0]["titel"] = $APIName;
        $_cols[0]["text"] = "ORDER #" . $OrderId;
        SlackSendMsg($config["slack_apilowcredit"], strip_tags($adminmessage), "danger", $_cols, false);
    }
}
function getNextAPi($api, $api_id, $service_id, $typeid)
{
    global $db;
    $APis = [];
    $second = dquery("select * from tbl_services_imei_api \n    where sid='" . $service_id . "' and `auto`=1 order by sort,id asc");
    $First = [];
    while ($r = mysqli_fetch_assoc($second)) {
        $APis[$r["id"]] = $r;
        if (!$First) {
            $First = $r;
        }
    }
    $flagnext = false;
    foreach ($APis as $apiid => $apidetails) {
        if ($flagnext) {
            return $apidetails;
        }
        if ($apidetails["api_server"] == $api && $apidetails["api_server_id"] == $api_id && $apidetails["api_server_typeid"] == $typeid) {
            $flagnext = true;
        }
    }
    if (!$flagnext) {
        return $First;
    }
}

?>