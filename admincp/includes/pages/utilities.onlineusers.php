<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 8;
checkPagePermission($pageid);
echo "<ul id=\"tabmenu\">\n    <li><a href=\"javascript:void(0)\" class=\"tabmenu_active\">Online Users</a></li>\n</ul>\n<div id=\"notification\"></div> \n<div id=\"content\">\n<div id=\"content_padded\"> \n";
include ROOTDIR . "/includes/geo.fun.php";
echo "<form id=\"frmeuser\" name=\"frmeuser\" method=\"post\">\n";
echo generate_token("form");
echo "<input type=\"hidden\" value=\"";
echo $_SESSION["adminid"];
echo "\" name=\"id\"/>\n\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Online System Users</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n  \n<table id=\"main_tbl\">\n<thead>\n  <tr><th>";
echo $LNG["username"];
echo "</th><th>";
echo $LNG["livechat"];
echo "</th><th><div align=\"center\">";
echo $LNG["online"];
echo " ";
echo $LNG["since"];
echo "</div></th><th><div align=\"right\">";
echo $LNG["login"];
echo " ";
echo $LNG["ip"];
echo "</div></th>\n  </tr>\n</thead>\n<tbody>                          \n";
$result = dquery("SELECT username,last_login,last_login_ip,id,online_status from tblUsers where online_status='1'");
while ($row = mysqli_fetch_assoc($result)) {
    $diff = time() - $row["last_login"];
    $min = round($diff / 60);
    if (60 < $min) {
        $min = round($diff / 3600) . ":" . round($min % 60);
    } else {
        $min = "00:" . $min;
    }
    if ($config["live_chat"]) {
        echo "  \n      <tr><td><a class=\"default_dg_a2\" href=\"javascript:load_fromsubpage('edituser&id=";
        echo $row["id"];
        echo "','";
        echo $row["username"];
        echo "')\">";
        echo $row["username"];
        echo "</a></td><td><a href=\"javascript:void(0)\" onclick=\"javascript:chatWith('";
        echo $row["username"];
        echo "')\">";
        echo $LNG["open"];
        echo "</a></td><td align=\"center\">";
        echo $min;
        echo "</td><td align=\"right\"><a href=\"javascript: load_subpage('";
        echo $config["ip_location"] . $row["last_login_ip"] . $LNG["ip"] . $LNG["location"];
        echo ")\">";
        echo $row["last_login_ip"];
        echo "</a></td></tr>\n     ";
    } else {
        echo "   \n       <tr><td><a class=\"default_dg_a2\" href=\"javascript:load_fromsubpage('edituser&id=";
        echo $row["id"];
        echo "','";
        echo $row["username"];
        echo "')\">";
        echo $row["username"];
        echo "</a></td><td>";
        echo $LNG["inactive"];
        echo "</td><td align=\"center\">";
        echo $min;
        echo "</td><td align=\"right\"><a href=\"javascript: load_subpage('";
        echo $config["ip_location"] . $row["last_login_ip"] . $LNG["ip"] . $LNG["location"];
        echo ")\">";
        echo $row["last_login_ip"];
        echo "</a></td></tr>\n     ";
    }
}
echo "\n</tbody></table>\n</div></div>\n \n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Online Guest User</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n<table id=\"main_tbl\">\n<thead>\n    <tr>\n        <th><div align=\"left\">";
echo $LNG["ip"];
echo "</div></th>\n        <th>";
echo $LNG["country"];
echo " </th>\n        <th>";
echo $LNG["online"];
echo " ";
echo $LNG["time"];
echo "</th>                 \n  </tr>\n</thead>\n<tbody>                          \n";
$result = dquery("SELECT * from tbl_visitors");
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>\n    <td><a  style=\"text-decoration: none;\" href=\"javascript: load_subpage('";
    echo $config["ip_location"] . $row["ip"];
    echo "','";
    echo $LNG["ip"] . " " . $LNG["location"];
    echo "')\">";
    echo $row["ip"];
    echo "</a></td>\n    <td>";
    $login_country_code = ipToCountry($row["ip"]);
    echo "            <img style=\"vertical-align: middle;\" src=\"images/flags/";
    echo $login_country_code;
    echo ".png\" alt=\"";
    echo $login_country_code;
    echo "\" border=\"0\" />\n            ";
    echo $login_country = $login_country_code;
    echo "</td>\n    <td>";
    echo time() - $row["time"];
    echo " Sec time</td>            \n</tr>\n";
}
echo "\n</tbody></table>\n</div></div>\n";
licince\reqaddon("Live Chat");
echo "\n</div></div> ";
$fileverioncheck = "6.1.0";

?>