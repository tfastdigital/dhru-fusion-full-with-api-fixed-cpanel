<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "./comm.php";
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
$currentpage = "placeorderimei";
$_nav = "<a href=\"" . _url("main") . "\">" . $lng_languag["dashboard"] . "</a> / ";
$action = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $action);
$status = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $status);
$sid = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $sid);
if ($action && $sid) {
    $tempalte_ver["action"] = $action;
    $tempalte_ver["sid"] = $sid;
}
if ($action == "remote") {
    $action = "imei";
    $serverservice = 2;
    $tempalte_ver["serverorder"] = $serverservice;
}
if ($action == "server") {
    $action = "imei";
    $serverservice = 1;
    $tempalte_ver["serverorder"] = $serverservice;
}
if (!$parentid) {
    $parentid = 1011;
}
$tempalte_ver["getimeidetaillink"] = _url("widget/getServicedetailsIMEI");
$tempalte_ver["imeiorderhistorylink"] = _url("orders/action/imei/status/all");
$tempalte_ver["serverorderhistorylink"] = _url("orders/action/server/status/all");
$tempalte_ver["remoteorderhistorylink"] = _url("orders/action/remote/status/all");
$tempalte_ver["directorderlink"] = _url("widget/placedirectimei");
$tempalte_ver["rewardplaceorder"] = _url("widget/placeorderimei/forreward/1");
$tempalte_ver["placeorderlink"] = _url("widget/placeorderimei");
$tempalte_ver["serviceinfoimeilink"] = _url("widget/getServiceInfoIMEI");
$tempalte_ver["ordernotes"] = $config["ordernotes"];
$tempalte_ver["ordercomments"] = $config["ordercomments"];
$tempalte_ver["orderemail"] = $config["orderemail"];
$tempalte_ver["orderno"] = $config["orderno"];
$sql = dquery("select id,assigned_brand from tbl_services_imei");
while ($row = mysqli_fetch_assoc($sql)) {
    if ($row["assigned_brand"] != "") {
        $brandarr = explode(",", $row["assigned_brand"]);
        foreach ($brandarr as $b) {
            $br = mysqli_fetch_assoc(dquery("select Name from tbl_model_brand where ID='" . $b . "'"));
            $uniquebrand[$b] = $br["Name"];
        }
    } else {
        if ($row["assigned_brand"] == "") {
        }
    }
}
$iser = mysqli_fetch_assoc(dquery("select imei_services from tblUsers where\n                 id='" . $_SESSION["uid"] . "'"));
if (!trim($iser["imei_services"])) {
    $iser["imei_services"] = 99999;
}
if ($iser["imei_services"] == "ALL") {
    $qi = dquery("select group_id from tbl_services_imei  group by group_id");
    while ($rqi = mysqli_fetch_assoc($qi)) {
    }
    if (!$grparr) {
        $grparr = "999999";
    } else {
        $grparr = implode(",", $grparr);
    }
    $gid = dquery("select id,group_name from tbl_imei_group where active=1\n    and id in (" . $grparr . ") order by display_order");
    while ($rgid = mysqli_fetch_assoc($gid)) {
        $tempalte_ver["grouparr"][$rgid["id"]] = $rgid["group_name"];
    }
    $tempalte_ver["brandarr"] = $uniquebrand;
    if ($config["placeordertype"]) {
        $tempalte_ver["ordertype"] = $config["placeordertype"];
    }
    $tempalte_ver["infopos"] = $config["infopos"];
    if ($_SESSION["uid"]) {
        if ($action == "file") {
            $pagetitle = $lng_languag["placeorderfile"];
            $_nav .= "<a href='" . _url("resellerplaceorder/action/file") . "' >" . $lng_languag["placeorderfile"] . "</a> / ";
            $templatefile = "client_order_file";
            $tempalte_ver["rightmenu"] = true;
            $pageicon = "";
            installclient($pagetitle, $pageicon, $breadcrumbnav);
            require_once "includes/fileservices.fun.php";
            $tempalte_ver["fileservicelist"] = getFileServices($group, "", $_SESSION["uid"], true);
            $serviceDetails = getFileServices("", $id, $_SESSION["uid"], true, "", "", "", "", "", 9898989);
            if ($placeorder) {
                global $erroring;
                if (!placeOrderFilevalidation($serviceDetails)) {
                    if (!$tempalte_ver["notification"]["error"]) {
                        $tempalte_ver["notification"]["error"] = $erroring;
                    }
                } else {
                    if (!creditProcessFile($serviceDetails)) {
                    }
                }
            }
            if ($_ClientsDetails["verified"]) {
                $tempalte_ver["responseno"] = $_ClientsDetails["phonenumber"];
            }
            $tempalte_ver["smsgateway"] = $config["smsgateway"];
            if ($_ClientsDetails["access"]["fileservice"] != 1) {
                $templatefile = "client_accessdenied";
                $tempalte_ver["notification"]["error"] = $lng_languag["yournotallowed"];
            }
        } else {
            if ($action == "reward") {
                $pagetitle = $lng_languag["placeorderreward"];
                $_nav .= "<a href='" . _url("resellerplaceorder/action/reward") . "' >" . $lng_languag["placeorderreward"] . "</a> / ";
                $templatefile = "client_order_reward";
                $pageicon = "";
                installclient($pagetitle, $pageicon, $breadcrumbnav);
                require_once "includes/imeiservices.fun.php";
                $tempalte_ver["imeiservicelist"] = getIMEIServicesNew($group, "", $_SESSION["uid"], true, "", "", "", "", "", "", "", "", 999999, "", "", "", "", "", "", "", 5);
                if (!$config["rewardpoint"]) {
                    $templatefile = "client_accessdenied";
                    $tempalte_ver["rightmenu"] = true;
                    $tempalte_ver["notification"]["error"] = $lng_languag["yournotallowed"];
                }
            } else {
                if ($serverservice) {
                    if ($serverservice == 2) {
                        $pagetitle = $lng_languag["placeorderremote"];
                        $_nav .= "<a href='" . _url("resellerplaceorder/action/remote") . "'>" . $lng_languag["placeorderremote"] . "</a> / ";
                    } else {
                        $pagetitle = $lng_languag["placeorderserver"];
                        $_nav .= "<a href='" . _url("resellerplaceorder/action/server") . "'>" . $lng_languag["placeorderserver"] . "</a> / ";
                    }
                } else {
                    $pagetitle = $lng_languag["placeorderimei"];
                    $_nav .= "<a href='" . _url("resellerplaceorder/action/imei") . "'>" . $lng_languag["placeorderimei"] . "</a> / ";
                }
                $templatefile = "client_order_imei";
                $pageicon = "";
                installclient($pagetitle, $pageicon, $breadcrumbnav);
                require_once "includes/imeiservices.fun.php";
                if ($searchby && ($model_id || $group)) {
                    if ($model_id) {
                        $tempalte_ver["imeiservicelist"] = getIMEIServices($group, "", $_SESSION["uid"], true, "", "", "", "", "", "", "", "", 999999, "", "", "", "", $model_id, "", "", $serverservice);
                    } else {
                        $tempalte_ver["imeiservicelist"] = getIMEIServices($group, "", $_SESSION["uid"], true, "", "", "", "", "", "", "", "", 999999, "", "", "", "", "", "", "", $serverservice);
                    }
                } else {
                    if ($_SESSION["template"] == "default6") {
                        $tempalte_ver["imeiservicelist"] = getIMEIServicesNew($group, "", $_SESSION["uid"], true, "", "", "", "", "", "", "", "", 999999, "", "", "", "", "", "", "", $serverservice);
                    } else {
                        $tempalte_ver["imeiservicelist"] = getIMEIServices($group, "", $_SESSION["uid"], true, "", "", "", "", "", "", "", "", 999999, "", "", "", "", "", "", "", $serverservice);
                    }
                }
                $tempalte_ver["actionlink"] = "includes/getdata/placeorderimei.php";
                if ($_ClientsDetails["verified"]) {
                    $tempalte_ver["responseno"] = $_ClientsDetails["phonenumber"];
                }
                if ($config["placeordertype"] == 2) {
                    if ($serverservice) {
                        $query = "SELECT `id`,`group_name`,description,imagelink,active FROM \n                `tbl_imei_group` WHERE `group_name`<>'' \n                and active='1' and `server`=1 ORDER BY `display_order` ASC";
                    } else {
                        $query = "SELECT `id`,`group_name`,description,imagelink,active FROM \n                `tbl_imei_group` WHERE `group_name`<>'' and active='1' ORDER BY `display_order` ASC";
                    }
                    $result = dquery($query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($_ClientsDetails["access"]["alow_imeiservices"] == "ALL") {
                            $q = dquery("select id,service_name from tbl_services_imei where group_id='" . $row["id"] . "'\n                     AND  active='1'");
                        } else {
                            if ($_ClientsDetails["access"]["alow_imeiservices"]) {
                                $q = dquery("select id,service_name from tbl_services_imei where group_id='" . $row["id"] . "'\n    AND `id` IN (" . $_ClientsDetails["access"]["alow_imeiservices"] . ")  and active='1'");
                            } else {
                                $q = dquery("select id,service_name from tbl_services_imei where group_id='" . $row["id"] . "'\n    AND `id` IN ('')  and active='1'");
                            }
                        }
                        if (mysqli_num_rows($q)) {
                            $verGid = $row["id"];
                            $_Group[$row["id"]]["name"] = $row["group_name"];
                            $_Group[$row["id"]]["imagelink"] = $row["imagelink"];
                        }
                    }
                    $tempalte_ver["imeigroup"] = $_Group;
                }
                $tempalte_ver["smsgateway"] = $config["smsgateway"];
                if ($serverservice == 1) {
                    if ($_ClientsDetails["access"]["serverlogservice"] != 1) {
                        $templatefile = "client_accessdenied";
                        $tempalte_ver["rightmenu"] = true;
                        $tempalte_ver["notification"]["error"] = $lng_languag["yournotallowed"];
                    }
                } else {
                    if ($_ClientsDetails["access"]["imeiservice"] != 1) {
                        $templatefile = "client_accessdenied";
                        $tempalte_ver["rightmenu"] = true;
                        $tempalte_ver["notification"]["error"] = $lng_languag["yournotallowed"];
                    }
                }
            }
        }
        $tempalte_ver["placeorderlink"] = _url("widget/placeorderimei");
        if ($standalone) {
            $tempalte_ver["token"] = generate_token("form");
            $tempalte_ver["standalone"] = true;
            echo processSingleTemplate($templatefile);
            exit;
        }
    } else {
        $_SESSION["afterloginredirect"] = $_SERVER["REQUEST_URI"];
        include "includes/login.inc.php";
        installclient($pagetitle, $pageicon, $breadcrumbnav);
    }
    $tempalte_ver["token"] = generate_token("form");
    $fileverioncheck = "6.1.0";
    DisplayOutput($templatefile);
    chkMd5sumsubpage();
} else {
    $qi = dquery("select group_id from tbl_services_imei where id in (" . $iser["imei_services"] . ")\n         group by group_id");
}
$grparr[] = $rqi["group_id"];

?>