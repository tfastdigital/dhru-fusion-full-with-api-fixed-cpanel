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
$templatefile = "client_order_imei_getservicedetails";
installclient($pagetitle, $pageicon, $breadcrumbnav);
$serviceid = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $serviceid);
$brand = preg_replace("/[^0-9]/i", "", $brand);
$model = preg_replace("/[^0-9]/i", "", $model);
$country = preg_replace("/[^0-9]/i", "", $country);
$provider = preg_replace("/[^0-9]/i", "", $provider);
$forquickcheckout = preg_replace("/[^0-9A-Za-z]/i", "", $forquickcheckout);
if ($forquickcheckout) {
    $templatefile = "client_order_imei_getservicedetails_quick";
}
require_once ROOTDIR . "/includes/imeiservices.fun.php";
$tempalte_ver["smsgateway"] = $config["smsgateway"];
$tempalte_ver["direct"] = $direct;
$tempalte_ver["charge"] = $charge;
$tempalte_ver["ordernotes"] = $config["ordernotes"];
$tempalte_ver["ordercomments"] = $config["ordercomments"];
$tempalte_ver["orderemail"] = $config["orderemail"];
$tempalte_ver["orderno"] = $config["orderno"];
$tempalte_ver["min"] = $min;
$tempalte_ver["forquickcheckout"] = $forquickcheckout;
if ($cart) {
    $tempalte_ver["imeiservice"] = getIMEIServicesNew("", $serviceid, "", true, "", "", true);
} else {
    $tempalte_ver["imeiservice"] = getIMEIServicesNew("", $serviceid, $_SESSION["uid"], true);
}
if ($reward == 1) {
    $tempalte_ver["forreward"] = 1;
}
if ($_ClientsDetails["verified"]) {
    $tempalte_ver["responseno"] = $_ClientsDetails["phonenumber"];
}
$sid = $tempalte_ver["imeiservice"]["id"];
if ($config["averagedeliverytime"]) {
    $deliverycnt = 50;
    $time = 0;
    $q = dquery("select time,reply_time from tbl_order_imei where (user_can_c=3\n       or user_can_c=4) and service_id='" . $sid . "' order by order_id desc\n       limit " . $deliverycnt);
    while ($r = mysqli_fetch_assoc($q)) {
        $time += $r["reply_time"] - $r["time"];
    }
    if (60 < $time) {
        $time = $time / mysqli_num_rows($q);
        $tempalte_ver["averagetime"] = secondsToTime($time);
    }
}
$f = dquery("select * from tbl_review where lid!='' and \n(select service_id from tbl_order_imei where order_id=lid)='" . $sid . "' and status=1");
while ($rf = mysqli_fetch_assoc($f)) {
    $tempalte_ver["imeiservice"]["feedback"][$rf["id"]] = $rf;
}
if ($price) {
    $tempalte_ver["showprice"] = true;
}
$listing = $tempalte_ver["imeiservice"]["listing"];
if ($tempalte_ver["imeiservice"]["reqredfield"]["model"]) {
    if ($chosen) {
        echo "    <link rel=\"stylesheet\" href=\"includes/css/chosen.css\" />\n    <script src=\"includes/js/chosen.jquery.js\"></script>\n    <script type=\"text/javascript\">\n    jQuery(document).ready(function(){\n        jQuery(\".chosen\").data(\"placeholder\",\"Select Service...\").chosen();\n    });\n    </script>\n    ";
    }
    if ($tempalte_ver["imeiservice"]["reqredfield"]["assigned_brand"]) {
        $WHERE = "AND `ID` IN (" . $tempalte_ver["imeiservice"]["reqredfield"]["assigned_brand"] . ")";
    } else {
        $WHERE = "";
    }
    $result = dquery("SELECT `ID`,`Name` FROM `tbl_model_brand`\n     WHERE `api`='" . $listing . "' " . $WHERE);
    $tempalte_ver["brands"] = "<select name=\"brand\"  class=\"chosen\"\n    onchange=\"getModels(this.value,'" . $serviceid . "','#modelsdropdown',true,'#loader');\"><option value=\"\">" . $lng_languag["select"] . "</option>";
    while ($data = mysqli_fetch_assoc($result)) {
        if ($brand == $data["ID"]) {
            $sels = " selected='selected'";
        } else {
            $sels = " ";
        }
        $tempalte_ver["brands"] .= "<option value=\"" . $data["ID"] . "\" " . $sels . ">" . $data["Name"] . "</option>";
    }
    $tempalte_ver["brands"] .= "</select>";
    unset($WHERE);
}
if ($tempalte_ver["imeiservice"]["download_link"]) {
    $tempalte_ver["downloadlink"] = "<a  style='text-decoration:none;' href=" . $tempalte_ver["imeiservice"]["download_link"] . " target='_blank'><img align='middle'  height='14' width='14' src='images/save.png' border='0'>&nbsp;&nbsp;" . $lng_languag["downloadsoftware"] . "</a>";
}
if ($tempalte_ver["imeiservice"]["faq_id"]) {
    $tempalte_ver["knowledgebase"] = "<a  style='text-decoration:none;' href='knowledgebase.php?currentpage=knowledgebase&artical=" . $tempalte_ver["imeiservice"]["faq_id"] . "' target='_blank'><img  height='14' width='14' align='middle' src='images/help.png' border='0'>&nbsp;&nbsp;" . $lng_languag["servicehelp"] . "</a>";
}
if ($tempalte_ver["imeiservice"]["reqredfield"]["provider"]) {
    if ($tempalte_ver["imeiservice"]["reqredfield"]["assigned_country"]) {
        $WHERE = "AND `ID` IN (" . $tempalte_ver["imeiservice"]["reqredfield"]["assigned_country"] . ")";
    } else {
        $WHERE = "";
    }
    $result = dquery("SELECT `ID`,`Name` FROM `tbl_provider_country` WHERE `api`='" . $listing . "' " . $WHERE);
    $tempalte_ver["provider_countrys"] = "<select name=\"country\"   class=\"chosen\" onchange=\"getProvider(this.value,'" . $serviceid . "','#providerdropdown',true,'#loader');\"><option value=\"\">" . $lng_languag["select"] . "</option>";
    while ($data = mysqli_fetch_assoc($result)) {
        if ($data["ID"] == $country) {
            $selected = "selected='selected'";
        } else {
            $selected = "";
        }
        $tempalte_ver["provider_countrys"] .= "<option " . $selected . " value=\"" . $data["ID"] . "\">" . html_entity_decode($data["Name"]) . "</option>";
    }
    $tempalte_ver["provider_countrys"] .= "</select>";
    unset($WHERE);
}
if ($tempalte_ver["imeiservice"]["reqredfield"]["mep"]) {
    if ($tempalte_ver["imeiservice"]["reqredfield"]["assigned_mep"]) {
        $WHERE = "AND `id` IN (" . $tempalte_ver["imeiservice"]["reqredfield"]["assigned_mep"] . ")";
    } else {
        $WHERE = "";
    }
    $result = dquery("SELECT `id`,`mep` FROM `tbl_mep` WHERE `api`='" . $listing . "' " . $WHERE . " ORDER BY mep ASC");
    $tempalte_ver["meps"] = "<select name=\"mep\" class=\"chosen\" ><option value=\"\">" . $lng_languag["select"] . "</option>";
    while ($data = mysqli_fetch_assoc($result)) {
        $tempalte_ver["meps"] .= "<option value=\"" . $data["id"] . "\">" . $data["mep"] . "</option>";
    }
    $tempalte_ver["meps"] .= "</select>";
    unset($WHERE);
}
if (!function_exists("getCustomFields")) {
    require ROOTDIR . "/includes/customfield.fun.inc.php";
}
$tempalte_ver["cart"] = $cart;
$tempalte_ver["item"] = $tempalte_ver["imeiservice"]["id"];
$customfields = getCustomFields("serviceimei", $tempalte_ver["imeiservice"]["id"], "", "on");
foreach ($customfields as $value) {
    $tempalte_ver["customfields"][$value["name"]] = $value;
}
if ($data = mysqli_fetch_assoc(dquery("SELECT `info`,acceptterms,knowledgebase,knowledgebaseas,faq_id \n    FROM `tbl_services_imei` WHERE md5(id)='" . $serviceid . "'"))) {
    if ($data["knowledgebase"]) {
        $buff = "";
        $qk = dquery("select title,content from tbl_knowledgebase where id in (" . $data["knowledgebase"] . ")");
        while ($rk = mysqli_fetch_assoc($qk)) {
            $buff .= $rk["title"] . " <hr />";
            $buff .= html_entity_decode($rk["content"]) . "<br />";
        }
    } else {
        if ($data["faq_id"]) {
            $article = mysqli_fetch_assoc(dquery("select title,content from tbl_knowledgebase\nwhere id='" . $data["faq_id"] . "'"));
            $buff = "";
            if (!$data["knowledgebaseas"]) {
                $buff .= "<a href='" . _url("knowledgebase/article/" . $data[faq_id] . "/" . str_replace(" ", "-", $article["title"])) . ".html' target='_blank'>" . $article["title"] . "</a>";
            } else {
                $buff .= $article["title"] . " <hr />";
                $buff .= html_entity_decode($article["content"]);
            }
        }
    }
    if ($data["info"] || $buff) {
        $tempalte_ver["serviceinfo"] = html_entity_decode(nl2br($data["info"])) . "" . $buff . "";
    }
    if ($data["acceptterms"]) {
        $tempalte_ver["toc"] = true;
    }
}
$m = mysqli_fetch_assoc(dquery("select Name from tbl_mobile where ID='" . $model . "'"));
$b = mysqli_fetch_assoc(dquery("select Name from tbl_model_brand where ID='" . $brand . "'"));
$tempalte_ver["brandname"] = $b["Name"];
$tempalte_ver["modelname"] = $m["Name"];
$tempalte_ver["placeorderlink"] = _url("widget/placeorderimei");
$tempalte_ver["placerewardorderlink"] = _url("widget/placeorderimei/forreward/1");
$tempalte_ver["imeiorderhistorylink"] = _url("orders/action/imei/status/all");
$tempalte_ver["serverorderhistorylink"] = _url("orders/action/newserver/status/all");
$tempalte_ver["remoteorderhistorylink"] = _url("orders/action/remote/status/all");
echo processSingleTemplate($templatefile);
unset($tempalte_ver);

?>