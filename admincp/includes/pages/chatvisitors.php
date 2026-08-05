<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require_once "../../../comm.php";
require_once "../../../includes/fun.inc.php";
require_once "../../includes/fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
echo "<script>\nfunction openPop(url,name){\n           newwindow=window.open(url,name,'height=500,width=550');\n\n}\n</script>\n\n<div style=\"padding: 0 10px;\">\n<span class=\"span-select\">\n <select id=\"position\" name=\"position\" onchange=\"changePosition(this.value)\">\n    <option value=\"\">Select Position</option>   \n    <option value=\"rightbottom\" ";
if ($config["livehelp_position"] == "rightbottom") {
    echo "selected";
}
echo ">Right Bottom</option>\n    <option value=\"leftbottom\" ";
if ($config["livehelp_position"] == "leftbottom") {
    echo "selected";
}
echo ">Left Bottom</option>    \n    </select>\n</span> \n \n <span class=\"span-select\">\n";
$admn = mysqli_fetch_assoc(dquery("select onlinestatus from tbl_admin where id='" . $_SESSION["adminid"] . "'"));
echo " \n    <select  name=\"status\" id=\"status\" onchange=\"changeStat(this.value)\">\n    <option value=\"available\" ";
if ($admn["onlinestatus"] == "available") {
    echo "selected";
}
echo ">Available</option>\n    <option value=\"invisible\" ";
if ($admn["onlinestatus"] == "invisible") {
    echo "selected";
}
echo ">Invisible</option>\n    <option value=\"away\" ";
if ($admn["onlinestatus"] == "away") {
    echo "selected";
}
echo ">Away</option>\n    </select>\n</span>\n\n\n\n<form id=\"newimeiorder\" name=\"\" method=\"post\" style=\"margin-top: 10px;\">\n<table id=\"main_tbl\" >\n<thead>\n  <tr>\n    <th><div align=\"left\">";
echo $LNG["ip"];
echo "</div></th>\n    <th>";
echo $LNG["country"];
echo "</th>\n    <th><div align=\"left\">";
echo $LNG["online"];
echo " ";
echo $LNG["time"];
echo "</div> </th>          \n    <th><div align=\"left\">";
echo $LNG["status"];
echo "</div> </th>\n    <th><div align=\"left\">";
echo $LNG["platform"];
echo "</div> </th>\n    <th><div align=\"left\">";
echo $LNG["browser"];
echo "</div> </th>\n    <th><div align=\"left\">";
echo $LNG["current"];
echo " ";
echo $LNG["page"];
echo "</div> </th>\n    <th><div align=\"left\">";
echo $LNG["referal"];
echo " ";
echo $LNG["link"];
echo "</div> </th>\n    <th><div align=\"left\">";
echo $LNG["invite"];
echo "</div> </th>\n  </tr>\n</thead>\n<tbody>\n";
include_once ROOTDIR . "/includes/geo.fun.php";
$sql = dquery("SELECT * FROM `tbl_visitors`");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "      <tr>\n            <td><a target=\"_blank\" style=\"text-decoration: none;\" href=\"#\"><a href=\"javascript: openPop('";
    echo $config["ip_location"];
    echo $row["ip"];
    echo "','IP Location');\">";
    echo $row["ip"];
    echo "</a> </a></td>\n            <td>";
    $login_country_code = ipToCountry($row["ip"]);
    echo "            <img style=\"vertical-align: middle;\" src=\"images/flags/";
    echo strtolower($login_country_code);
    echo ".png\" alt=\"";
    echo $login_country_code;
    echo "\" border=\"0\" />\n            ";
    $login_country = $login_country_code;
    echo "</td>\n            <td>";
    echo time() - $row["time"];
    echo " Sec</td>\n            <td>";
    echo $row["status"];
    echo "</td>\n            <td>";
    echo $row["os"];
    echo "</td>\n            <td>";
    echo $row["browser"];
    echo "</td>\n            <td>";
    echo "<a title='" . $row["title"] . "' href='" . urldecode($row["url"]) . "'  style='text-decoration: none;' target='_blank'>" . substr(urldecode($row["url"]), 0, 40) . "..." . "</a>";
    echo "</td>\n            <td>";
    if ($row["referalurl"]) {
        echo "<a  style='text-decoration: none;' href='" . urldecode($row["referalurl"]) . "' target='_blank'>" . substr(urldecode($row["referalurl"]), 0, 40) . "..." . "</a>";
    } else {
        echo "Direct";
    }
    echo "</td>\n            <td align=\"center\"><a href=\"javascript:void(0);\" onclick=\"inviteVisitor(";
    echo $row["id"];
    echo ");return false;\" name=\"\"><img border=\"0\" src=\"images/chat.jpg\" /></a></td> \n        </tr>\n";
}
echo "</tbody></table>\n</form>\n</div>\n<script></script>\n";
$fileverioncheck = "6.1.0";

?>