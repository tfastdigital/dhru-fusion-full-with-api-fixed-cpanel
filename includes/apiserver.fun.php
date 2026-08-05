<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DHRUSOFT") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
function updateAPiServer($gateway, $setting, $value)
{
    if (!mysqli_num_rows(dquery("select * \n      from tbl_apiservers  WHERE `setting`= '" . $setting . "' AND  `gateway`= '" . $gateway . "'"))) {
        dquery("INSERT INTO tbl_apiservers\n       (gateway,setting,value) VALUES   ('" . $gateway . "','" . $setting . "','" . $value . "')");
    } else {
        dquery("UPDATE `tbl_apiservers` SET \n      `value`= '" . $value . "' WHERE `setting`= '" . $setting . "' AND `gateway`= '" . $gateway . "'");
    }
}
function syncApi($apiid = "", $displyOutput = true, $action = "accoutinfo", $deletbeforsync = false)
{
    $_t = "&nbsp;&nbsp;&nbsp;&nbsp;";
    if (!$apiid) {
        return false;
    }
    global $log;
    global $updateonlyserviceprice;
    $gsmportalversionreq = "5.2.3";
    apiSyncLog($apiid, "sync start");
    $apisaveddetails = loadApiModule($apiid);
    $apisaveddetails["gsmportalversionreq"] = $gsmportalversionreq;
    switch ($action) {
        case "accoutinfo":
            require_once ROOTDIR . "/modules/apiserver/" . $apiid . ".php";
            if (function_exists($apiid . "_accoutinfo")) {
                $accoutinfo = call_user_func($apiid . "_accoutinfo", $apisaveddetails);
                if ($accoutinfo["ERROR"]) {
                    updateapiserver($apiid, "LastError", $accoutinfo["ERROR"]);
                }
                $apiversion = $accoutinfo["apiversion"];
                unset($accoutinfo["apiversion"]);
                if ($accoutinfo["currency"]) {
                    $CUR = $accoutinfo["currency"];
                } else {
                    $CUR = substr(trim($accoutinfo["Credits available"]), -3);
                }
                if ($accoutinfo["scripttype"]) {
                    updateApiServerSetings($apiid, "scripttype", $accoutinfo["scripttype"]);
                }
                if (!is_numeric($CUR) && mysqli_num_rows(dquery("select id from tbl_currencies where code='" . $CUR . "'"))) {
                    if (!mysqli_num_rows(dquery("select * \n                    from tbl_apiservers WHERE `setting`= 'currency' AND `gateway`= '" . $apiid . "'"))) {
                        dquery("INSERT INTO tbl_apiservers\n                            (gateway,setting,value) VALUES  ('" . $apiid . "','currency','" . $CUR . "')");
                    } else {
                        dquery("UPDATE  tbl_apiservers\n                            SET value='" . $CUR . "' where gateway='" . $apiid . "' and setting='currency'");
                    }
                }
                if ($displyOutput) {
                    if ($updateonlyserviceprice) {
                        return $accoutinfo["Credits available"];
                    }
                    displyOutput($accoutinfo);
                }
                if ($accoutinfo["ERROR"]) {
                    displyOutput($accoutinfo["ERROR"]);
                    exit;
                }
                if ($apiversion) {
                    if (mysqli_num_rows(dquery("select * from tbl_apiservers\n                    WHERE `setting`= 'apiversion' AND `gateway`= '" . $apiid . "'"))) {
                        dquery("UPDATE `tbl_apiservers` SET \n                      `value`= '" . $apiversion . "' WHERE `setting`= 'apiversion'\n                       AND `gateway`= '" . $apiid . "'");
                    } else {
                        dquery("INSERT INTO tbl_apiservers\n                       (gateway,setting,value) VALUES \n                       ('" . $apiid . "','apiversion','" . $apiversion . "')");
                    }
                }
            }
            apiSyncLog($apiid, "account info");
            break;
        case "services":
            if (function_exists($apiid . "_services")) {
                $serviceArr = call_user_func($apiid . "_services", $apisaveddetails);
                if ($serviceArr["ERROR"]) {
                    updateapiserver($apiid, "LastError", $serviceArr["ERROR"]);
                    if ($updateonlyserviceprice) {
                        $log->Error($serviceArr);
                        $log->logEnd();
                        exit("error:" . $serviceArr["ERROR"]);
                    }
                    displyOutput($serviceArr);
                    unset($serviceArr);
                    exit;
                }
                saveApiServices($serviceArr, $apiid, $displyOutput, $apisaveddetails);
                unset($serviceArr);
            }
            apiSyncLog($apiid, "services");
            break;
        case "mobiles":
            if (function_exists($apiid . "_mobiles")) {
                $mobilesArr = call_user_func($apiid . "_mobiles", $apisaveddetails);
                saveApiMobiles($mobilesArr, $apiid, $displyOutput, $deletbeforsync);
                unset($mobilesArr);
            }
            break;
        case "provider":
            if (function_exists($apiid . "_provider")) {
                $providerArr = call_user_func($apiid . "_provider", $apisaveddetails);
                saveApiprovider($providerArr, $apiid, $displyOutput, $deletbeforsync);
                unset($providerArr);
            }
            break;
        case "mep":
            if (function_exists($apiid . "_mep")) {
                $mepArr = call_user_func($apiid . "_mep", $apisaveddetails);
                saveMep($mepArr, $apiid, $displyOutput, $deletbeforsync);
                unset($mepArr);
            }
            break;
        case "assign_networks":
            if (function_exists($apiid . "_assign_networks")) {
                $networksArr = call_user_func($apiid . "_assign_networks", $apisaveddetails);
                if ($networksArr) {
                    saveApiAssignnetworks($networksArr, $apiid, $displyOutput);
                }
                unset($networksArr);
            }
            break;
        case "assign_mobiles":
            if (function_exists($apiid . "_assign_mobiles")) {
                $apisaveddetails = loadApiModule($apiid, true);
                $apisaveddetails["gsmportalversionreq"] = $gsmportalversionreq;
                $assignmobilessArr = call_user_func($apiid . "_assign_mobiles", $apisaveddetails);
                displyOutput($assignmobilessArr);
                unset($assignmobilessArr);
            }
            break;
    }
}
function setupMyServer($apiid, $trunate = false, $trucateserver = false, $setupimei = false, $setupserver = false)
{
    $_t = "&nbsp;&nbsp;&nbsp;&nbsp;";
    displyOutput("Updating your server services");
    displyOutput("=============================================");
    if ($setupimei && $trunate) {
        dquery("DELETE FROM  `tbl_imei_credit` where service_id in (select id from tbl_services_imei\n        where useasserver=0)");
        dquery("DELETE FROM  `tbl_discount_imei` where service_id in (select id from tbl_services_imei\n        where useasserver=0)");
        dquery("DELETE FROM  `tbl_services_imei_api` where sid in (select id from tbl_services_imei\n        where useasserver=0)");
        dquery("DELETE FROM  `tbl_client_group_price` where service_id in (select id from tbl_services_imei\n        where useasserver=0) and service_type='imei'");
        dquery("DELETE FROM  `tbl_customfields` where relid in (select id from tbl_services_imei\n        where useasserver=0) and `type`='serviceimei'");
        dquery("DELETE FROM  `tbl_services_imei` WHERE useasserver=0");
        dquery("DELETE FROM  `tbl_imei_group`  WHERE server=0");
        displyOutput("Deleting all current IMEI service.....Ok");
    }
    if ($setupserver && $trucateserver) {
        dquery("DELETE FROM  `tbl_imei_credit` where service_id in (select id from tbl_services_imei\n        where useasserver=1)");
        dquery("DELETE FROM  `tbl_services_imei_api` where sid in (select id from tbl_services_imei\n        where useasserver=1)");
        dquery("DELETE FROM  `tbl_discount_imei` where service_id in (select id from tbl_services_imei\n        where useasserver=1)");
        dquery("DELETE FROM  `tbl_client_group_price` where service_id in (select id from tbl_services_imei\n        where useasserver=1) and service_type='imei'");
        dquery("DELETE FROM  `tbl_customfields` where relid in (select id from tbl_services_imei\n        where useasserver=1) and `type`='serviceimei'");
        dquery("DELETE FROM  `tbl_services_imei` WHERE useasserver=1");
        dquery("DELETE FROM  `tbl_imei_group`  WHERE server=1");
        displyOutput("Deleting all current  SERVER service.....Ok");
    }
    if ($setupimei) {
        $sql = dquery("SELECT * FROM `tbl_apiserversservices` WHERE `gateway`='" . $apiid . "' and `type` = 'Group'  and `servicetype`='' and useasserver=0");
        while ($Data = mysqli_fetch_assoc($sql)) {
            $grp = dquery("SELECT * FROM tbl_imei_group where group_name='" . $Data["name"] . "' and `server`=0");
            if (mysqli_num_rows($grp)) {
                $Data["name"] = $Data["name"] . " (duplicate_" . rand(1, 9) . ")";
            }
            displyOutput("Group :: " . $Data["name"]);
            $ins = NULL;
            $ins["server"] = $Data["useasserver"];
            $ins["group_name"] = $Data["name"];
            $ins["active"] = 1;
            $GroupID = insert_query("tbl_imei_group", $ins);
            $ins = NULL;
            $sql1 = dquery("SELECT * FROM `tbl_apiserversservices` WHERE `type` = 'Tool' and `guiid`='" . $Data["apiserverid"] . "'");
            while ($Data1 = mysqli_fetch_assoc($sql1)) {
                $grp = dquery("SELECT * FROM tbl_services_imei where service_name='" . $Data1["name"] . "' and useasserver=0");
                if (mysqli_num_rows($grp)) {
                    $Data1["name"] = $Data1["name"] . " (duplicate_" . rand(1, 9) . ")";
                }
                displyOutput($_t . " Service :: " . $Data1["name"]);
                setupMyServerTool($Data1, $GroupID, $apiid);
            }
        }
    }
    if ($setupserver) {
        $sql = dquery("SELECT * FROM `tbl_apiserversservices` WHERE `type` = 'Group' and `gateway`='" . $apiid . "' and `servicetype`='' and useasserver=1");
        while ($Data = mysqli_fetch_assoc($sql)) {
            $grp = dquery("SELECT * FROM tbl_imei_group where group_name='" . $Data["name"] . "' and `server`=1");
            if (mysqli_num_rows($grp)) {
                $Data["name"] = $Data["name"] . " (duplicate_" . rand(1, 9) . ")";
            }
            displyOutput("Group :: " . $Data["name"]);
            $ins = NULL;
            $ins["server"] = $Data["useasserver"];
            $ins["group_name"] = $Data["name"];
            $ins["active"] = 1;
            $GroupID = insert_query("tbl_imei_group", $ins);
            $ins = NULL;
            $sql1 = dquery("SELECT * FROM `tbl_apiserversservices` WHERE `type` = 'Tool' and `guiid`='" . $Data["apiserverid"] . "'");
            while ($Data1 = mysqli_fetch_assoc($sql1)) {
                $grp = dquery("SELECT * FROM tbl_services_imei where service_name='" . $Data1["name"] . "' and useasserver=1");
                if (mysqli_num_rows($grp)) {
                    $Data1["name"] = $Data1["name"] . " (duplicate_" . rand(1, 9) . ")";
                }
                displyOutput($_t . " Service :: " . $Data1["name"]);
                setupMyServerTool($Data1, $GroupID, $apiid);
            }
        }
    }
}
function setupMyServerTool($Data1, $GroupID, $apiid)
{
    global $db;
    $ins = NULL;
    $ins["imei_single"] = 1;
    $ins["imei_bulk"] = 1;
    $ins["active"] = 1;
    $ins["status"] = 1;
    $ins["useasserver"] = $Data1["useasserver"];
    $ins["qnt"] = $Data1["qnt"];
    $ins["qntoptions"] = $Data1["qntoptions"];
    $ins["minqnt"] = $Data1["minqnt"];
    $ins["maxqnt"] = $Data1["maxqnt"];
    $ins["service_name"] = html_entity_decode($Data1["name"]);
    $ins["credit"] = $Data1["credits"];
    $ins["time"] = $Data1["delivery"];
    $ins["group_id"] = $GroupID;
    $ins["apiserverid"] = $Data1["apiserverid"];
    $ins["info"] = html_entity_decode($Data1["message"]);
    $ins["usercan_cancel"] = 1;
    if ($Data1["requires_mobile"] == "Required" || $Data1["assigned_mobiles"] != "") {
        $ins["model"] = 1;
        $ins["assigned_brand"] = $Data1["assigned_brands"];
        $ins["assigned_model"] = $Data1["assigned_mobiles"];
    }
    if ($Data1["requires_network"] == "Required" || $Data1["assigned_network"] != "") {
        $ins["provider"] = 1;
        $ins["assigned_country"] = $Data1["assigned_country"];
        $ins["assigned_provider"] = $Data1["assigned_network"];
    }
    if ($Data1["requires_mep"] == "Required") {
        $ins["mep"] = 1;
        $ins["assigned_mep"] = $Data1["assigned_mep"];
    }
    if ($Data1["requires_type"] == "Required") {
        $ins["Requires_Type"] = 1;
    }
    if ($Data1["requires_locks"] == "Required") {
        $ins["Locks"] = 1;
    }
    if ($Data1["requires_pin"] == "Required") {
        $ins["PIN"] = 1;
    }
    if ($Data1["requires_kbh"] == "Required") {
        $ins["KBH"] = 1;
    }
    if ($Data1["requires_prd"] == "Required") {
        $ins["PRD"] = 1;
    }
    if ($Data1["requires_type"] == "Required") {
        $ins["Type"] = 1;
    }
    if ($Data1["requires_reference"] == "Required") {
        $ins["Reference"] = 1;
    }
    if ($Data1["requires_SN"] == "Required") {
        $ins["SN"] = 1;
    }
    if ($Data1["requires_SecRO"] == "Required") {
        $ins["SecRO"] = 1;
    }
    if ($Data1["imeifield"]) {
        $imeifield = json_decode($Data1["imeifield"], true);
        $ins["imei_bulk"] = $imeifield["bulk"];
        $ins["imei_custom"] = $imeifield["allow"];
        $ins["imei_custom_len"] = $imeifield["customlen"];
        $ins["custom_name"] = $imeifield["customname"];
        $ins["imeiregex"] = $imeifield["regex"];
        $ins["isalpha"] = $imeifield["isalpha"];
    }
    $ins["listing"] = $apiid;
    $ins["API"] = $apiid;
    $ins["API_ID"] = $Data1["id"];
    $ins["API_TYPEID"] = $Data1["type_id"];
    $ServiceID = insert_query("tbl_services_imei", $ins);
    if ($Data1["requires_custom"] != "") {
        $_requires_custom = json_decode($Data1["requires_custom"], true);
        foreach ($_requires_custom as $v) {
            $_add_custom[relid] = $ServiceID;
            $_add_custom[type] = $v[type];
            $_add_custom[fieldname] = $v[fieldname];
            $_add_custom[fieldtype] = $v[fieldtype];
            $_add_custom[description] = $v[description];
            $_add_custom[fieldoptions] = $v[fieldoptions];
            $_add_custom[regexpr] = $v[regexpr];
            $_add_custom[adminonly] = $v[adminonly];
            $_add_custom[required] = $v[required];
            $_add_custom[enc] = $v[enc];
            insert_query("tbl_customfields", $_add_custom);
            unset($_add_custom);
        }
    }
    $ins = NULL;
    return $ServiceID;
}
function saveApiAssignMobiles($MobilesArr, $apiid, $displyOutput = true, $Toolid = "", $type = "arry")
{
    if ($MobilesArr["ERROR"]) {
        displyOutput($MobilesArr);
        return false;
    }
    $_t = "&nbsp;&nbsp;&nbsp;&nbsp;";
    $_aasigned_networks = NULL;
    $_aasigned_country = NULL;
    $sqlqu = NULL;
    if ($MobilesArr) {
        if ($type == "arry") {
            foreach ($MobilesArr as $Mobile) {
                $MobileID = $Mobile["ID"];
                $sqlqu = mysqli_fetch_assoc(dquery("SELECT ID,B_ID FROM tbl_mobile WHERE apiid='" . $MobileID . "' and `api`='" . $apiid . "' "));
                $_aasigned_mobiles[] = $sqlqu["ID"];
                $_aasigned_brands[] = $sqlqu["B_ID"];
            }
            $_aasigned_mobiles = implode(",", array_unique($_aasigned_mobiles));
            $_aasigned_brands = implode(",", array_unique($_aasigned_brands));
            displyOutput("Assigned Brands for " . $Toolid);
            displyOutput("=============================================");
            displyOutput($_aasigned_brands);
            displyOutput("Assigned Models for " . $Toolid);
            displyOutput("=============================================");
            displyOutput($_aasigned_mobiles);
            dquery("UPDATE tbl_apiserversservices SET assigned_brands='" . $_aasigned_brands . "',\tassigned_mobiles='" . $_aasigned_mobiles . "' WHERE gateway='" . $apiid . "' and id='" . $Toolid . "'");
        } else {
            if ($type == "in") {
                $result = dquery("SELECT `ID`,`B_ID` FROM `tbl_mobile` WHERE `apiid` IN (" . $MobilesArr . ") and `api`='" . $apiid . "' ");
                while ($sqlqu = mysqli_fetch_assoc($result)) {
                    $_aasigned_mobiles[] = $sqlqu["ID"];
                    $_aasigned_brands[] = $sqlqu["B_ID"];
                }
                $_aasigned_mobiles = implode(",", array_unique($_aasigned_mobiles));
                $_aasigned_brands = implode(",", array_unique($_aasigned_brands));
                displyOutput("Assigned Brands for " . $Toolid);
                displyOutput("=============================================");
                displyOutput($_aasigned_brands);
                displyOutput("Assigned Models for " . $Toolid);
                displyOutput("=============================================");
                displyOutput($_aasigned_mobiles);
                dquery("UPDATE tbl_apiserversservices SET assigned_brands='" . $_aasigned_brands . "',\tassigned_mobiles='" . $_aasigned_mobiles . "' WHERE gateway='" . $apiid . "' and id='" . $Toolid . "'");
            }
        }
    }
}
function saveApiAssignnetworks($networksArr, $apiid, $displyOutput = true, $Toolid = "", $type = "arry")
{
    if ($networksArr["ERROR"]) {
    }
    $_t = "&nbsp;&nbsp;&nbsp;&nbsp;";
    if ($networksArr) {
        $sqlqu = NULL;
        if ($type == "arry") {
            foreach ($networksArr as $key => $Networks) {
                $api_id = $key;
                $_aasigned_networks = NULL;
                $_aasigned_country = NULL;
                foreach ($Networks as $Network) {
                    $NetworkID = $Network["ID"];
                    $sqlqu = mysqli_fetch_assoc(dquery("SELECT ID,C_ID FROM tbl_provider WHERE apiid='" . $NetworkID . "' and `api`='" . $apiid . "' "));
                    $_aasigned_networks[] = $sqlqu["ID"];
                    $_aasigned_country[] = $sqlqu["C_ID"];
                }
                $_aasigned_networks = implode(",", array_unique($_aasigned_networks));
                $_aasigned_country = implode(",", array_unique($_aasigned_country));
                displyOutput("Assigned Country for " . $Toolid);
                displyOutput("=============================================");
                displyOutput($_aasigned_country);
                displyOutput("Assigned Networks for " . $Toolid);
                displyOutput("=============================================");
                displyOutput($_aasigned_networks);
                dquery("UPDATE tbl_apiserversservices SET assigned_network='" . $_aasigned_networks . "',assigned_country='" . $_aasigned_country . "' WHERE gateway='" . $apiid . "' and id='" . $Toolid . "'");
            }
        } else {
            if ($type == "in") {
                $api_id = $key;
                $_aasigned_networks = NULL;
                $_aasigned_country = NULL;
                $result = dquery("SELECT `ID`,`C_ID` FROM `tbl_provider` WHERE `apiid` IN (" . $networksArr . ")  and `api`='" . $apiid . "' ");
                while ($sqlqu = mysqli_fetch_assoc($result)) {
                    $_aasigned_networks[] = $sqlqu["ID"];
                    $_aasigned_country[] = $sqlqu["C_ID"];
                }
                $_aasigned_networks = implode(",", array_unique($_aasigned_networks));
                $_aasigned_country = implode(",", array_unique($_aasigned_country));
                displyOutput("Assigned Country for " . $Toolid);
                displyOutput("=============================================");
                displyOutput($_aasigned_country);
                displyOutput("Assigned Networks for " . $Toolid);
                displyOutput("=============================================");
                displyOutput($_aasigned_networks);
                dquery("UPDATE tbl_apiserversservices SET assigned_network='" . $_aasigned_networks . "',assigned_country='" . $_aasigned_country . "' WHERE gateway='" . $apiid . "' and id='" . $Toolid . "'");
            }
        }
    }
}
function saveMep($mepArr, $apiid, $displyOutput = true, $delet = false)
{
    if ($mepArr["ERROR"]) {
    }
    $_t = "&nbsp;&nbsp;&nbsp;&nbsp;";
    global $db;
    if ($mepArr) {
        if ($delet) {
            dquery("TRUNCATE TABLE `tbl_mep`");
        }
        if ($displyOutput) {
            displyOutput("<br /><br />Updating MEP list");
            displyOutput("=============================================");
        }
        foreach ($mepArr as $MEPID => $MEP) {
            $sql = "SELECT `ID` FROM `tbl_mep` WHERE `apiid`='" . $MEPID . "' and `mep`='" . $MEP . "' and `api`='" . $apiid . "' ";
            $countRows = $db->query($sql);
            if (mysqli_num_rows($countRows) == 0) {
                $ins = NULL;
                $ins["mep"] = $MEP;
                $ins["api"] = $apiid;
                $ins["apiid"] = $MEPID;
                $db->insert("tbl_mep", $ins);
                $ins = NULL;
            }
            if ($displyOutput) {
                displyOutput($_t . " MEP :: " . $MEP);
            }
        }
    }
}
function saveApiprovider($providerArr, $apiid, $displyOutput = true, $delet = false)
{
    if ($providerArr["ERROR"]) {
    }
    $_t = "&nbsp;&nbsp;&nbsp;&nbsp;";
    global $db;
    if ($providerArr["Country"]) {
        if ($delet) {
            dquery("TRUNCATE TABLE `tbl_provider_country`");
            dquery("TRUNCATE TABLE `tbl_provider`");
        }
        if ($displyOutput) {
            displyOutput("<br /><br />Updating Country/Provider list");
            displyOutput("=============================================");
        }
        foreach ($providerArr["Country"] as $Country) {
            $Country_Name = htmlspecialchars($Country["Name"]);
            $countRows = dquery("SELECT `ID` FROM `tbl_provider_country` WHERE `Name`='" . $Country_Name . "' and `api`='" . $apiid . "' ");
            $_C_ID = mysqli_fetch_assoc($countRows);
            $_C_ID = $_C_ID["ID"];
            if (mysqli_num_rows($countRows) == 0) {
                $ins = NULL;
                $ins["Name"] = $Country_Name;
                $ins["api"] = $apiid;
                $ins["apiid"] = htmlspecialchars($Country["ID"]);
                $db->insert("tbl_provider_country", $ins);
                $ins = NULL;
                $_C_ID = mysqli_fetch_assoc(dquery("SELECT `ID` FROM `tbl_provider_country` WHERE `Name`='" . $Country_Name . "' and `api`='" . $apiid . "' "));
                $_C_ID = $_C_ID["ID"];
            }
            if ($displyOutput) {
                displyOutput("Country :: " . $Country_Name);
            }
            foreach ($Country["Network"] as $Network) {
                $Network_ID = htmlspecialchars($Network["ID"]);
                $Network_Name = htmlspecialchars($Network["Name"]);
                $sql = "SELECT `ID` FROM `tbl_provider` WHERE `apiid`='" . $Network_ID . "' and `C_ID`='" . $_C_ID . "' ";
                $countRows = $db->query($sql);
                if (mysqli_num_rows($countRows) == 0) {
                    $ins = NULL;
                    $ins["C_ID"] = $_C_ID;
                    $ins["Name"] = $Network_Name;
                    $ins["api"] = $apiid;
                    $ins["apiid"] = $Network_ID;
                    $db->insert("tbl_provider", $ins);
                    $ins = NULL;
                }
                if ($displyOutput) {
                    displyOutput($_t . " Network :: " . $Network_Name);
                }
            }
        }
    }
}
function saveApiMobiles($mobilesArr, $apiid, $displyOutput = true, $delet = false)
{
    if ($mobilesArr["ERROR"]) {
    }
    $_t = "&nbsp;&nbsp;&nbsp;&nbsp;";
    global $db;
    if ($mobilesArr["Brand"]) {
        if ($delet) {
            dquery("TRUNCATE TABLE `tbl_model_brand`");
            dquery("TRUNCATE TABLE `tbl_mobile`");
        }
        if ($displyOutput) {
            displyOutput("<br /><br />Updating Brand/Mobile list");
            displyOutput("=============================================");
        }
        foreach ($mobilesArr["Brand"] as $Brand) {
            $Brand_Name = htmlspecialchars($Brand["Name"]);
            $countRows = dquery("SELECT `ID` FROM `tbl_model_brand` WHERE `Name`='" . $Brand_Name . "' and `api`='" . $apiid . "' ");
            $_B_ID = mysqli_fetch_assoc($countRows);
            $_B_ID = $_B_ID["ID"];
            if (mysqli_num_rows($countRows) == 0) {
                $ins = NULL;
                $ins["Name"] = $Brand_Name;
                $ins["api"] = $apiid;
                $ins["apiid"] = htmlspecialchars($Brand["ID"]);
                $db->insert("tbl_model_brand", $ins);
                $ins = NULL;
                $_B_ID = mysqli_fetch_assoc(dquery("SELECT `ID` FROM `tbl_model_brand` WHERE `Name`='" . $Brand_Name . "' and `api`='" . $apiid . "' "));
                $_B_ID = $_B_ID["ID"];
            }
            if ($displyOutput) {
                displyOutput("Brand :: " . $Brand_Name);
            }
            if ($Brand["Mobile"]) {
                foreach ($Brand["Mobile"] as $Mobile) {
                    $Mobile_ID = htmlspecialchars($Mobile["ID"]);
                    $Mobile_Name = htmlspecialchars($Mobile["Name"]);
                    $sql = "SELECT `ID` FROM `tbl_mobile` WHERE `apiid`='" . $Mobile_ID . "' and `B_ID`='" . $_B_ID . "' ";
                    $countRows = $db->query($sql);
                    if (mysqli_num_rows($countRows) == 0) {
                        $ins = NULL;
                        $ins["B_ID"] = $_B_ID;
                        $ins["Name"] = $Mobile_Name;
                        $ins["api"] = $apiid;
                        $ins["apiid"] = $Mobile_ID;
                        $db->insert("tbl_mobile", $ins);
                        $ins = NULL;
                    }
                    if ($displyOutput) {
                        displyOutput($_t . " Mobile :: " . $Mobile_Name);
                    }
                }
            }
        }
    }
}
function saveApiServices($serviceArr, $apiid, $displyOutput = true, $apisaveddetails = "")
{
    if ($serviceArr["ERROR"]) {
        displyOutput($serviceArr);
        return false;
    }
    $_t = "&nbsp;&nbsp;&nbsp;&nbsp;";
    global $db;
    global $updateonlyserviceprice;
    global $log;
    global $precision;
    global $admindirpath;
    if ($updateonlyserviceprice) {
        $log->Debug("saveAPiServices Called");
        $ClientGroup = [];
        $cg = dquery("select * from tbl_client_group");
        while ($rc = mysqli_fetch_assoc($cg)) {
            $ClientGroup[$rc["id"]] = $rc["id"];
        }
        $CurrencyArr = [];
        $cg = dquery("select * from tbl_currencies where `default`=0");
        while ($rc = mysqli_fetch_assoc($cg)) {
            $CurrencyArr[$rc["id"]] = $rc["code"];
        }
        dquery("UPDATE tbl_apiserversservices set credittmp=credits\n         where flagprice=0 and gateway='" . $apiid . "'");
        $ApiToolIDArray = [];
        $SaveAsFile = [];
        $iFile = 0;
        foreach ($serviceArr["Group"] as $Group) {
            $SaveAsFile[$iFile]["group"] = $Group;
            foreach ($Group["Tool"] as $Tool) {
                $SaveAsFile[$iFile]["service"][] = $Tool;
                $where = "";
                $whereapiserver = "";
                if ($Tool["TypeID"]) {
                    $where = " and API_TYPEID='" . $Tool["TypeID"] . "'";
                    $whereapiserver = " and type_id='" . $Tool["TypeID"] . "'";
                }
                $ServiceType = 0;
                if ($Tool["ToolType"] == "REMOTE") {
                    $ServiceType = 2;
                } else {
                    if ($Tool["ToolType"] == "SERVER") {
                        $ServiceType = 1;
                    }
                }
                $whereapiserver .= " and useasserver='" . $ServiceType . "'";
                $ServiceID = mysqli_fetch_assoc(dquery("select id,retailincrease,retailincreaseby,apiincrease,apiincreasetype \nfrom tbl_services_imei where API='" . $apiid . "' and API_ID='" . $Tool["ID"] . "' " . $where));
                $ConnectedServiceID = $ServiceID["id"];
                $BasePrice = $apisaveddetails["baseprice"];
                $BasePriceBy = $apisaveddetails["basepriceby"];
                if ($ServiceID["apiincrease"]) {
                    $apisaveddetails["baseprice"] = $ServiceID["apiincrease"];
                    $apisaveddetails["basepriceby"] = $ServiceID["apiincreasetype"];
                }
                if ($ServiceID["retailincrease"]) {
                    $apisaveddetails["retailincrease"] = $ServiceID["retailincrease"];
                    $apisaveddetails["retailincreaseby"] = $ServiceID["retailincreaseby"];
                }
                $data["credits"] = $Tool["Credits"];
                $data["name"] = html_entity_decode(htmlspecialchars($Tool["Name"]));
                $db->update("tbl_apiserversservices", $data, "gateway='" . $apiid . "' and id='" . $Tool["ID"] . "' " . $whereapiserver);
                $data = NULL;
                if ($apisaveddetails["apiaddnewservice"] && daffectedrow() == 0) {
                    $Data1 = insertTool($apiid, $Group, $Tool, false, $_t, true);
                    $GroupID = mysqli_fetch_assoc(dquery("select id from tbl_imei_group \nwhere group_name='" . $Data1["group"] . "'"));
                    setupmyservertool($Data1, $GroupID["id"], $apiid);
                }
                $ApiToolIDArray[] = $Tool["ID"];
                $UPDATEFIELD = [];
                if ($apisaveddetails["apiservicename"]) {
                    $UPDATEFIELD["service_name"] = $Tool[Name];
                }
                if ($apisaveddetails["currency"]) {
                    if ($apisaveddetails["baseprice"] != "") {
                        $UPDATEFIELD["purchase_cost"] = $Tool["Credits"];
                        if ($apisaveddetails["currency"] != $_SESSION["system_default_currency"]["code"]) {
                            $UPDATEFIELD["purchase_cost"] = $Tool["Credits"];
                            $UPDATEFIELD["purchase_cost"] = convertCurrency($UPDATEFIELD["purchase_cost"], $apisaveddetails["currency"], $_SESSION["system_default_currency"]["code"], "", "code");
                        }
                        $NewPrice = $Tool["Credits"];
                        if ($apisaveddetails["basepriceby"] == "Fixed") {
                            $NewPrice += $apisaveddetails["baseprice"];
                        } else {
                            $NewPrice += round($Tool["Credits"] * $apisaveddetails["baseprice"] / 100, $precision);
                        }
                        if ($apisaveddetails["currency"] != $_SESSION["system_default_currency"]["code"]) {
                            $NewPrice = convertCurrency($NewPrice, $apisaveddetails["currency"], $_SESSION["system_default_currency"]["code"], "", "code");
                        }
                        $UPDATEFIELD["credit"] = $NewPrice;
                    }
                    if (0 < $apisaveddetails["retailincrease"]) {
                        $NewPrice = $Tool["Credits"];
                        if ($apisaveddetails["retailincreaseby"] == "Fixed") {
                            $NewPrice += $apisaveddetails["retailincrease"];
                        } else {
                            $NewPrice += round($Tool["Credits"] * $apisaveddetails["retailincrease"] / 100, $precision);
                        }
                        if ($apisaveddetails["currency"] != $_SESSION["system_default_currency"]["code"]) {
                            $NewPrice = convertCurrency($NewPrice, $apisaveddetails["currency"], $_SESSION["system_default_currency"]["code"], "", "code");
                        }
                        $UPDATEFIELD["retail_credit"] = $NewPrice;
                    }
                    foreach ($ClientGroup as $ClientGroupID) {
                        $ToolPrice = $UPDATEFIELD["credit"] ? $UPDATEFIELD["credit"] : $Tool["Credits"];
                        $rowg = mysqli_fetch_assoc(dquery("select * from tbl_group_api_price\n                          where service_id='" . $ConnectedServiceID . "' and group_id='" . $ClientGroupID . "'"));
                        $ClientGroupWiseID = $apisaveddetails["baseprice_" . $ClientGroupID];
                        $ClientGroupWiseBasePrice = $apisaveddetails["basepriceby_" . $ClientGroupID];
                        if ($rowg["id"]) {
                            $apisaveddetails["baseprice_" . $ClientGroupID] = $rowg["price"];
                            $apisaveddetails["basepriceby_" . $ClientGroupID] = $rowg["increaseby"];
                            dquery("DELETE FROM tbl_client_group_price WHERE service_id='" . $ConnectedServiceID . "'\n                            and group_id='" . $ClientGroupID . "' and service_type='imei'");
                        }
                        if ($apisaveddetails["baseprice_" . $ClientGroupID] != "") {
                            if ($apisaveddetails["baseprice_" . $ClientGroupID] == 0) {
                                dquery("delete from tbl_client_group_price\n                            where group_id='" . $ClientGroupID . "' and service_id='" . $ConnectedServiceID . "' and currency_id='" . $_SESSION["system_default_currency"]["id"] . "' and service_type='imei'");
                            } else {
                                $NewPrice = $Tool["Credits"];
                                if ($apisaveddetails["basepriceby_" . $ClientGroupID] == "Fixed") {
                                    $NewPrice += $apisaveddetails["baseprice_" . $ClientGroupID];
                                } else {
                                    $NewPrice += round($Tool["Credits"] * $apisaveddetails["baseprice_" . $ClientGroupID] / 100, $precision);
                                }
                                if ($apisaveddetails["currency"] != $_SESSION["system_default_currency"]["code"]) {
                                    if (!$UPDATEFIELD["credit"]) {
                                        $ToolPrice = convertCurrency($ToolPrice, $apisaveddetails["currency"], $_SESSION["system_default_currency"]["code"], "", "code");
                                    }
                                    $NewPrice = convertCurrency($NewPrice, $apisaveddetails["currency"], $_SESSION["system_default_currency"]["code"], "", "code");
                                }
                                $GroupDiscount = $ToolPrice - $NewPrice;
                                $GROUPDATA = NULL;
                                $GROUPDATA["group_id"] = $ClientGroupID;
                                $GROUPDATA["service_type"] = "imei";
                                $GROUPDATA["service_id"] = $ConnectedServiceID;
                                $GROUPDATA["discount"] = $GroupDiscount;
                                $GROUPDATA["currency_id"] = $_SESSION["system_default_currency"]["id"];
                                $GROUPDATA["price"] = round($NewPrice, 2);
                                $db->update("tbl_client_group_price", $GROUPDATA, "group_id='" . $ClientGroupID . "' and service_id='" . $ConnectedServiceID . "' and currency_id='" . $_SESSION["system_default_currency"]["id"] . "' and service_type='imei'");
                                if (!mysqli_num_rows(dquery("select group_id from tbl_client_group_price\n                            where group_id='" . $ClientGroupID . "' and service_id='" . $ConnectedServiceID . "' and currency_id='" . $_SESSION["system_default_currency"]["id"] . "' and service_type='imei'"))) {
                                    $db->insert("tbl_client_group_price", $GROUPDATA);
                                }
                                foreach ($CurrencyArr as $currencyid => $curdetail) {
                                    $OtherAmount = convertCurrency($ToolPrice - $GroupDiscount, $_SESSION["system_default_currency"]["id"], $currencyid);
                                    $CalcuAmount = convertCurrency($ToolPrice, $_SESSION["system_default_currency"]["id"], $currencyid);
                                    $Discount = round($CalcuAmount - $OtherAmount, 2);
                                    $GROUPDATA = NULL;
                                    $GROUPDATA["group_id"] = $ClientGroupID;
                                    $GROUPDATA["service_type"] = "imei";
                                    $GROUPDATA["days"] = "0";
                                    $GROUPDATA["service_id"] = $ConnectedServiceID;
                                    $GROUPDATA["discount"] = $Discount;
                                    $GROUPDATA["currency_id"] = $currencyid;
                                    $GROUPDATA["price"] = round($OtherAmount, 2);
                                    $db->update("tbl_client_group_price", $GROUPDATA, "group_id='" . $ClientGroupID . "' and service_id='" . $ConnectedServiceID . "' and currency_id='" . $currencyid . "' and service_type='imei'");
                                    if (!mysqli_num_rows(dquery("select group_id from tbl_client_group_price\n                           where group_id='" . $ClientGroupID . "' and service_id='" . $ConnectedServiceID . "' and currency_id='" . $currencyid . "' and service_type='imei'"))) {
                                        $db->insert("tbl_client_group_price", $GROUPDATA);
                                    }
                                }
                            }
                        }
                        $apisaveddetails["baseprice_" . $ClientGroupID] = $ClientGroupWiseID;
                        $apisaveddetails["basepriceby_" . $ClientGroupID] = $ClientGroupWiseBasePrice;
                    }
                }
                if (0 < count($UPDATEFIELD)) {
                    $log->Info("Service:" . implode(" | ", $UPDATEFIELD));
                    $db->update("tbl_services_imei", $UPDATEFIELD, "id='" . $ConnectedServiceID . "'");
                }
                $apisaveddetails["baseprice"] = $BasePrice;
                $apisaveddetails["basepriceby"] = $BasePriceBy;
            }
            $iFile++;
        }
        if ($apisaveddetails["apiinactiveservice"] && 0 < count($ApiToolIDArray)) {
            dquery("UPDATE tbl_services_imei set active=0,inactivebyapi=1\nwhere API='" . $apiid . "' and API_ID not in (" . implode(",", $ApiToolIDArray) . ")");
        }
        if ($apisaveddetails["apiinactiveservice"] && 0 < count($ApiToolIDArray)) {
            dquery("UPDATE tbl_services_imei set active=1,inactivebyapi=0\nwhere API='" . $apiid . "' and API_ID  in (" . implode(",", $ApiToolIDArray) . ")\nand inactivebyapi='1'");
        }
        return true;
    } else {
        dquery("DELETE FROM `tbl_apiserversservices` WHERE `gateway` = '" . $apiid . "'");
        $SaveAsFile = [];
        if ($serviceArr["Group"]) {
            if ($displyOutput) {
                displyOutput("Updating services list");
                displyOutput("=============================================");
            }
            $fCnt = 0;
            foreach ($serviceArr["Group"] as $Group) {
                $ServiceType = 0;
                if ($Group["GroupType"] == "REMOTE") {
                    $ServiceType = 2;
                } else {
                    if ($Group["GroupType"] == "SERVER") {
                        $ServiceType = 1;
                    }
                }
                $data = NULL;
                $data["gateway"] = $apiid;
                $data["type"] = "Group";
                $data["name"] = html_entity_decode(htmlspecialchars($Group["Name"]));
                $data["id"] = $Group["ID"];
                $data["useasserver"] = $ServiceType;
                $data["servicetype"] = $Group["servicetype"];
                if ($Group["servicetype"]) {
                    $__TYPE = " <strong>(File Service)</strong>";
                } else {
                    if ($Group["GroupType"] == "SERVER") {
                        $__TYPE = " <strong>(Server Service)</strong>";
                    } else {
                        if ($Group["GroupType"] == "REMOTE") {
                            $__TYPE = " <strong>(Remote Service)</strong>";
                        } else {
                            $__TYPE = NULL;
                        }
                    }
                }
                $SaveAsFile[$fCnt]["group"] = $data;
                $data = NULL;
                if ($displyOutput) {
                    displyOutput("Group :: " . html_entity_decode(htmlspecialchars($Group["Name"])) . $__TYPE);
                }
                $BulkTool = [];
                foreach ($Group["Tool"] as $Tool) {
                    $BulkTool[] = insertTool($apiid, $Group, $Tool, $displyOutput, $_t, "", true, $Groupid);
                    if ($displyOutput) {
                        displyOutput($_t . " Tool :: " . html_entity_decode(htmlspecialchars($Tool["Name"])) . " - " . $Tool["Credits"]);
                    }
                    $Tool["Message"] = utf8_encode($Tool["Message"]);
                    $SaveAsFile[$fCnt]["service"][] = $Tool;
                }
                $fCnt++;
            }
        }
        file_put_contents(ROOTDIR . "/" . $admindirpath . "/tmp/" . $apiid . ".json", json_encode($SaveAsFile));
    }
}
function insertTool($apiid, $Group, $Tool, $displyOutput, $_t, $returnarr = false, $bulkentry = false, $groupuid = "")
{
    global $db;
    $ServiceType = 0;
    if ($Tool["ToolType"] == "REMOTE") {
        $ServiceType = 2;
    } else {
        if ($Tool["ToolType"] == "SERVER") {
            $ServiceType = 1;
        }
    }
    $data = NULL;
    $data["gateway"] = $apiid;
    $data["type"] = "Tool";
    $data["name"] = html_entity_decode(htmlspecialchars($Tool["Name"]));
    $data["id"] = $Tool["ID"];
    $data["group"] = $Group["ID"];
    $data["credits"] = $Tool["Credits"];
    $output = preg_replace("/[^(\\x20-\\x7F)\\x0A\\x0D]*/", "", $Tool["Message"]);
    $data["useasserver"] = $ServiceType;
    $data["guiid"] = md5($apiid . $Tool["ID"] . $Tool["TypeID"] . $data["useasserver"]);
    $gr = mysqli_fetch_assoc(dquery("select suid from tbl_apiserversservices\n    where `type`='Tool' order by suid desc limit 1"));
    $data["suid"] = $gr["suid"] + 1;
    $data["message"] = htmlspecialchars($output);
    $data["delivery"] = $Tool["Delivery.Unit"];
    $data["imeifield"] = $Tool["Custom"];
    $data["qntoptions"] = $Tool["QntOptions"];
    $data["minqnt"] = $Tool["MinQnt"];
    $data["maxqnt"] = $Tool["MaxQnt"];
    $data["requires_network"] = $Tool["Requires.Network"];
    $data["requires_mobile"] = $Tool["Requires.Mobile"];
    $data["requires_provider"] = $Tool["Requires.Provider"];
    $data["requires_pin"] = $Tool["Requires.PIN"];
    $data["requires_kbh"] = $Tool["Requires.KBH"];
    $data["requires_mep"] = $Tool["Requires.MEP"];
    $data["requires_prd"] = $Tool["Requires.PRD"];
    $data["requires_reference"] = $Tool["Requires.Reference"];
    $data["requires_servicetag"] = $Tool["Requires.ServiceTag"];
    $data["requires_type"] = $Tool["Requires.Type"];
    $data["requires_locks"] = $Tool["Requires.Locks"];
    $data["requires_SN"] = $Tool["Requires.SN"];
    $data["requires_SecRO"] = $Tool["Requires.SecRO"];
    $data["servicetype"] = $Tool["servicetype"];
    $data["qnt"] = $Tool["QNT"];
    $data["type_id"] = $Tool["TypeID"];
    $data["requires_custom"] = $Tool["Requires.Custom"] ? json_encode($Tool["Requires.Custom"]) : "";
    if ($bulkentry) {
        return $data;
    }
    $db->insert("tbl_apiserversservices", $data);
    if ($returnarr) {
        return $data;
    }
    $data = NULL;
    if ($displyOutput) {
        displyOutput($_t . " Tool :: " . htmlspecialchars($Tool["Name"]) . " - " . $Tool["Credits"]);
        if ($Tool["Requires.Custom"]) {
            displyOutput(json_encode($Tool["Requires.Custom"]));
        }
    }
}
function displyOutput($output)
{
    ob_implicit_flush(true);
    ob_start();
    global $ERRORLOG;
    global $donotdisplayoutput;
    global $updateonlyserviceprice;
    if ($donotdisplayoutput) {
        if ($updateonlyserviceprice) {
            if ($output[ERROR]) {
                return "error:" . $output[ERROR];
            }
            return $output;
        }
        return true;
    }
    $_t = "&nbsp;&nbsp;&nbsp;&nbsp;";
    if (is_array($output)) {
        foreach ($output as $k => $v) {
            if ($k == "ERROR") {
                $ERRORLOG[] = $v;
            }
            echo "<span " . ($k == "ERROR" ? "class=\"error\" > " . $k : ">" . ucfirst($k)) . " => " . $v . "</span><br />";
            ob_flush();
            if (is_array($v)) {
                foreach ($v as $k1 => $v1) {
                    if ($k1 == "ERROR") {
                        $ERRORLOG[] = $v1;
                    }
                    echo $_t . " <span " . ($k1 == "ERROR" ? "class=\"error\"" . $k1 : $k1) . " => " . $v1 . "</span><br />";
                    ob_flush();
                    if (is_array($v1)) {
                        foreach ($v1 as $k2 => $v2) {
                            if ($k2 == "ERROR") {
                                $ERRORLOG[] = $v2;
                            }
                            echo $_t . $_t . " <span " . ($k2 == "ERROR" ? "class=\"error\"" . $k2 : $k2) . " => " . $v2 . "</span><br />";
                            ob_flush();
                            if (is_array($v2)) {
                                foreach ($v2 as $k3 => $v3) {
                                    if ($k3 == "ERROR") {
                                        $ERRORLOG[] = $v3;
                                    }
                                    echo $_t . $_t . $_t . " <span " . ($k3 == "ERROR" ? "class=\"error\"" . $k3 : $k3) . " => " . $v3 . "</span><br />";
                                    ob_flush();
                                    if (is_array($v3)) {
                                        foreach ($v3 as $k4 => $v4) {
                                            if ($k4 == "ERROR") {
                                                $ERRORLOG[] = $v4;
                                            }
                                            echo $_t . $_t . $_t . $_t . " <span " . ($k4 == "ERROR" ? "class=\"error\"" . $k4 : $k4) . " => " . $v4 . "</span><br />";
                                            ob_flush();
                                            if (is_array($v4)) {
                                                foreach ($v4 as $k5 => $v5) {
                                                    if ($k5 == "ERROR") {
                                                        $ERRORLOG[] = $v5;
                                                    }
                                                    echo $_t . $_t . $_t . $_t . " <span " . ($k5 == "ERROR" ? "class=\"error\"" . $k5 : $k5) . " => " . $v5 . "</span><br />";
                                                    ob_flush();
                                                    if (is_array($v5)) {
                                                        foreach ($v5 as $k6 => $v6) {
                                                            if ($k6 == "ERROR") {
                                                                $ERRORLOG[] = $v6;
                                                            }
                                                            echo $_t . $_t . $_t . $_t . " <span " . ($k6 == "ERROR" ? "class=\"error\"" . $k6 : $k6) . " => " . $v6 . "</span><br />";
                                                            ob_flush();
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    } else {
        echo $output . "<br />";
        ob_flush();
    }
    ob_end_flush();
}
function loadApiModule($gateway, $loadallservices = true)
{
    global $config;
    global $db;
    $gatewaypath = ROOTDIR . "/modules/apiserver/" . $gateway . ".php";
    if (file_exists($gatewaypath)) {
        require_once $gatewaypath;
        $GATEWAY = [];
        $GATEWAY["apiservers"] = $gateway;
        $result = select_query("tbl_apiservers", "", ["gateway" => $gateway]);
        while ($data = mysqli_fetch_assoc($result)) {
            $GATEWAY[$data["setting"]] = $data["value"];
        }
        if ($loadallservices) {
            $result = select_query("tbl_apiserversservices", "", ["gateway" => $gateway, "type" => "Tool"]);
            while ($data = mysqli_fetch_assoc($result)) {
                if (!($data["assigned_network"] || $data["assigned_country"] || $data["assigned_brands"] || $data["assigned_mobiles"])) {
                }
                $GATEWAY["services"][] = $data;
            }
        }
        $GATEWAY["companyname"] = $config["companyname"];
        if ($config["config_ssl_allow"]) {
            $GATEWAY["systemurl"] = $config["config_ssl_allow"];
        } else {
            $GATEWAY["systemurl"] = $config["site_address"];
        }
        return $GATEWAY;
    }
    exit("Invalid gateway module request....");
}
function apiServerDropdown($selected = "", $fieldname = "API", $servicetype = "", $server = "", $script = "")
{
    global $lng_languag;
    global $LNG;
    $foreignkeyvalue = "onchange=javascript:getapiServices(this.value,'#apiservicedropdown','true','#main_loader','" . $servicetype . "','" . $server . "'); ";
    $dropdowncode = "<select class=\"chosen\" id=\"apiservers\" name=\"" . $fieldname . "\" " . $foreignkeyvalue . " > <option value=\"\">" . $lng_languag["select"] . $LNG["none"] . "</option>";
    $result = select_query("tbl_apiservers", "gateway,value", ["setting" => "name"], "order", "ASC");
    while ($data = mysqli_fetch_assoc($result)) {
        $customname = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_apiservers` WHERE `setting`='customname' AND `gateway`='" . $data["gateway"] . "' "));
        if ($customname) {
            $customname = " (" . $customname["value"] . ") ";
        }
        $dropdowncode .= "<option value=\"" . $data["gateway"] . "\"";
        if ($data["gateway"] == $selected) {
            $dropdowncode .= " selected=\"selected\"";
        }
        $dropdowncode .= ">" . $data["value"] . $customname . "</option>";
    }
    $dropdowncode .= "</select>";
    return $dropdowncode;
}
function apiServicesDropdown($gateway = "", $selected = "", $fieldname = "API_ID", $service_type = "", $server = "", $selectedtype = "", $script = "")
{
    global $lng_languag;
    global $LNG;
    $dropdowncode = "<select " . $script . " class=\"chosen apiservs\" name=\"" . $fieldname . "\"> <optgroup label=\"Select\"> <option value=\"\">" . $lng_languag["select"] . $LNG["none"] . "</option></optgroup>";
    if ($server) {
        $useasserver = (string) $server;
    } else {
        $useasserver = "0";
    }
    $newfield = "";
    if ($selectedtype) {
        $newfield = $selected . "_" . $selectedtype;
    }
    $qgroup = dquery("select `name`,apiserverid,guiid,`id` from tbl_apiserversservices \n   where `type`='Group' and gateway='" . $gateway . "' \n   and useasserver='" . $useasserver . "'");
    while ($rg = mysqli_fetch_assoc($qgroup)) {
        $dropdowncode .= "<optgroup label=\"" . html_entity_decode($rg["name"]) . "\">";
        if ($service_type) {
            $result = dquery("select gateway,apiserverid,type_id,name,id,credits,(select `value` from \n        tbl_apiservers where tbl_apiservers.gateway=tbl_apiserversservices.gateway and tbl_apiservers.setting='currency') as curency\n        from \n        tbl_apiserversservices \n        where `type`=\"Tool\" and gateway=\"" . $gateway . "\" and servicetype=\"" . $service_type . "\"\n        and `group`=\"" . html_entity_decode($rg["id"]) . "\"\n        and useasserver=\"" . $useasserver . "\" order by `name` asc");
        } else {
            $result = dquery("select gateway,guiid,apiserverid,type_id,name,id,credits,(select `value` from \n        tbl_apiservers where tbl_apiservers.gateway=tbl_apiserversservices.gateway and tbl_apiservers.setting='currency') as curency\n        from \n        tbl_apiserversservices \n        where `type`=\"Tool\" and gateway=\"" . $gateway . "\" and servicetype=\"\"         and (`group`=\"" . str_replace("\"", "\\\"", html_entity_decode($rg["id"])) . "\"\n        or `group`=\"" . $rg["id"] . "\" \n        or `group`=\"" . str_replace("\"", "\\\"", html_entity_decode($rg["name"])) . "\"\n        or `group`=\"" . $rg["name"] . "\" \n        or guiid=\"" . $rg[apiserverid] . "\")\n        and useasserver=\"" . $useasserver . "\" order by `name` asc");
        }
        $guiid = false;
        while ($data = mysqli_fetch_assoc($result)) {
            if (8 < strlen($data["guiid"])) {
                $guiid = true;
            }
            $dropdowncode .= "<option value=\"" . $data["id"] . "_" . $data["type_id"] . "\"";
            if ($guiid) {
                if ($data["guiid"] == md5($gateway . $selected . $selectedtype . $useasserver)) {
                    $dropdowncode .= " selected=\"selected\"";
                }
            } else {
                if ($data["id"] == $selected || $data["id"] == $newfield) {
                    $dropdowncode .= " selected=\"selected\"";
                }
            }
            $dropdowncode .= " >" . html_entity_decode($data["name"]) . " - " . $data["credits"] . " " . $data["curency"] . "</option>";
        }
        $dropdowncode .= "</optgroup>";
    }
    $dropdowncode .= "</select>";
    return $dropdowncode;
}
function apiLog($gateway, $data, $result, $apiserviceid = "", $send = false, $serviceid = 0, $server = 0)
{
    global $FUNVAR;
    $orderdata = "";
    if ($FUNVAR["ORDERID"]) {
        $orderdata .= "OrderID => " . $FUNVAR["ORDERID"] . " ";
    }
    if ($FUNVAR["USERID"]) {
        $orderdata .= "UserID => " . $FUNVAR["USERID"] . " ";
    }
    if (is_array($data)) {
        $logdata = "";
        foreach ($data as $k => $v) {
            $logdata .= $k . " => " . $v . " ";
        }
    } else {
        $logdata = $data;
    }
    $apiname = "";
    if ($apiserviceid) {
        $apiq = mysqli_fetch_assoc(dquery("select `name` from tbl_apiserversservices\nwhere apiserverid='" . $gateway . "' and id='" . $apiserviceid . "'"));
        $apiname = $apiq["name"];
    }
    $connections = "";
    if ($serviceid) {
        $serv = mysqli_fetch_assoc(dquery("select `name` from \ntbl_apiserversservices where gateway='" . $gateway . "' and id=(select API_ID\nfrom tbl_services_imei where id='" . $serviceid . "') and useasserver='" . $server . "'"));
        $connections .= "Primary : " . $serv["name"] . " =>";
        $qc = dquery("select * from tbl_services_imei_api where sid='" . $serviceid . "' and auto=1 order by sort asc");
        for ($cnt = 1; $rc = mysqli_fetch_assoc($qc); $cnt++) {
            $serv = mysqli_fetch_assoc(dquery("select `name` from \ntbl_apiserversservices where gateway='" . $rc["api_server"] . "'\n and id='" . $rc["api_server_id"] . "'  and useasserver='" . $server . "'"));
            $connections .= " Next " . $cnt . ": " . $serv["name"] . " =>";
        }
    }
    $array = ["date" => "now()", "gateway" => $gateway, "orderid" => $FUNVAR["ORDERID"], "data" => $orderdata . $logdata, "apiserviceid" => $apiserviceid, "send" => $send ? 1 : 0, "connections" => $connections, "result" => $result];
    $insid = insert_query("tbl_apilog", $array);
    return $insid;
}
function obj2array($obj, $level = 0)
{
    $items = [];
    if (!is_object($obj)) {
        return $items;
    }
    $child = (array) $obj;
    if (1 < sizeof($child)) {
        foreach ($child as $aa => $bb) {
            if (is_array($bb)) {
                foreach ($bb as $ee => $ff) {
                    if (!is_object($ff)) {
                        $items[$aa][$ee] = $ff;
                    } else {
                        if (get_class($ff) == "SimpleXMLElement") {
                            $items[$aa][$ee] = amstore_xmlobj2array($ff, $level + 1);
                        }
                    }
                }
            } else {
                if (!is_object($bb)) {
                    $items[$aa] = $bb;
                } else {
                    if (get_class($bb) == "SimpleXMLElement") {
                        $items[$aa] = amstore_xmlobj2array($bb, $level + 1);
                    }
                }
            }
        }
    } else {
        if (0 < sizeof($child)) {
            foreach ($child as $aa => $bb) {
                if (!is_array($bb) && !is_object($bb)) {
                    $items[$aa] = $bb;
                } else {
                    if (is_object($bb)) {
                        $items[$aa] = amstore_xmlobj2array($bb, $level + 1);
                    } else {
                        foreach ($bb as $cc => $dd) {
                            if (!is_object($dd)) {
                                $items[$obj->getName()][$cc] = $dd;
                            } else {
                                if (get_class($dd) == "SimpleXMLElement") {
                                    $items[$obj->getName()][$cc] = amstore_xmlobj2array($dd, $level + 1);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    return $items;
}
function updateApiServerSetings($gateway, $setting, $value)
{
    if (!mysqli_num_rows(dquery("select * \n                    from tbl_apiservers WHERE `setting`= '" . $setting . "' AND `gateway`= '" . $gateway . "'"))) {
        dquery("INSERT INTO tbl_apiservers\n                       (gateway,setting,value) VALUES \n                       ('" . $gateway . "','" . $setting . "','" . $value . "')");
    } else {
        dquery("UPDATE  tbl_apiservers\n                        SET value='" . $value . "' where gateway='" . $gateway . "' and setting='" . $setting . "'");
    }
}

?>