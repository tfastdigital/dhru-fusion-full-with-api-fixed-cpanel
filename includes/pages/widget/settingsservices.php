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
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
$templatefile = "";
if ($actions == "IMEI") {
    require_once ROOTDIR . "/includes/imeiservices.fun.php";
    $pagetitle = $lng_languag["imeiservice"];
    $_nav .= "<a href='" . _url("widget/save/settingsservices/action/IMEI") . "' >" . $lng_languag["imeiservice"] . "</a> / ";
    $templatefile = "client_settings_services";
    $pageicon = "";
    installclient($pagetitle, $pageicon, $breadcrumbnav);
    $usersId = descape($usersId);
    $serviceDetails = getIMEIServicesNew("", "", $_SESSION["uid"], true);
    $tempalte_ver["servicelist"] = $serviceDetails;
    $tempalte_ver["token"] = generate_token("form");
    echo processSingleTemplate($templatefile);
} else {
    if ($actions == "file") {
        $pagetitle = $lng_languag["fileservice"];
        $_nav .= "<a href='" . _url("widget/save/settingsservices/action/file") . "' >" . $lng_languag["fileservice"] . "</a> / ";
        $templatefile = "client_settings_services";
        $pageicon = "";
        installclient($pagetitle, $pageicon, $breadcrumbnav);
        $usersId = descape($usersId);
        $serviceDetails = getALLFileServices();
        $tempalte_ver["servicelist"] = $serviceDetails;
        $tempalte_ver["token"] = generate_token("form");
        echo processSingleTemplate($templatefile);
    } else {
        if ($actions == "server") {
            require_once ROOTDIR . "/includes/imeiservices.fun.php";
            $pagetitle = $lng_languag["serverservice"];
            $_nav .= "<a href='" . _url("widget/save/settingsservices/action/server") . "' >" . $lng_languag["serverservice"] . "</a> / ";
            $templatefile = "client_settings_services";
            $pageicon = "";
            installclient($pagetitle, $pageicon, $breadcrumbnav);
            $usersId = descape($usersId);
            $serviceDetails = getIMEIServicesNew("", "", $_SESSION["uid"], true, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", 1);
            $tempalte_ver["servicelist"] = $serviceDetails;
            $tempalte_ver["token"] = generate_token("form");
            echo processSingleTemplate($templatefile);
        } else {
            if ($actions == "remote") {
                require_once ROOTDIR . "/includes/imeiservices.fun.php";
                $pagetitle = $lng_languag["serverservice"];
                $_nav .= "<a href='" . _url("widget/save/settingsservices/action/remote") . "' >" . $lng_languag["remote"] . " " . $lng_languag["service"] . "</a> / ";
                $templatefile = "client_settings_services";
                $pageicon = "";
                installclient($pagetitle, $pageicon, $breadcrumbnav);
                $usersId = descape($usersId);
                $serviceDetails = getIMEIServicesNew("", "", $_SESSION["uid"], true, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", 2);
                $tempalte_ver["servicelist"] = $serviceDetails;
                $tempalte_ver["token"] = generate_token("form");
                echo processSingleTemplate($templatefile);
            }
        }
    }
}

?>