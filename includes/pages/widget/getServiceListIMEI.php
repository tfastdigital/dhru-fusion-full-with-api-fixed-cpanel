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
require "../comm.php";
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
require_once ROOTDIR . "/includes/imeiservices.fun.php";
installclient($pagetitle, $pageicon, $breadcrumbnav);
$groupid = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $groupid);
$servicelist = getIMEIServices($groupid, "", $_ClientsDetails["id"], true, "", "", "", "", "", "", "", "", 9999999);
echo "    <option value=\"\">";
echo $lng_languag["select"];
echo "</option> \n";
foreach ($servicelist as $serv) {
    foreach ($serv as $s) {
        echo "    <option  \n    ";
        if ($s["credit"] - $s["discount"] < $s["credit"]) {
            echo "    class=\"discount_text\" \n    ";
        }
        echo "    value=\"";
        echo md5($s["id"]);
        echo "\">";
        echo $s["service_name"];
        echo "    -\n    ";
        echo $s["credit"] - $s["discount"];
        echo "    </option>\n    ";
    }
}

?>