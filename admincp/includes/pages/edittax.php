<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once "includes/fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($save) {
    if ($taxname && $taxrate != "") {
        checkDemoMode(false);
        $data["level"] = trim($level);
        $data["name"] = trim($taxname);
        $data["state"] = trim($state);
        $data["country"] = trim($country);
        $data["taxrate"] = trim($taxrate);
        $data["gateway"] = trim($gateway);
        $data["fixedcharge"] = trim($fixedcharge);
        $db->update("tbl_tax", $data, "id=" . $id);
        echo "<div id=notification1 class=successbox>" . $LNG["datasavesuccessfully"] . "</div>";
    } else {
        echo "<div id=notification1 class=errorbox>" . $LNG["fieldblank"] . "</div>";
    }
}
$tax = mysqli_fetch_assoc(dquery("SELECT * FROM tbl_tax WHERE id='" . $id . "'"));
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<div id=\"accountinfo1\" class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $tax["name"];
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n  \n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["level"];
echo " </td>\n    <td class=\"fieldarea\">\n    <select name=\"level\">\n    <option value=\"1\" ";
if ($tax["level"] == 1) {
    echo "selected";
}
echo ">1</option>\n    <option value=\"2\" ";
if ($tax["level"] == 2) {
    echo "selected";
}
echo ">2</option>\n    </select>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["taxname"];
echo " </td>\n    <td class=\"fieldarea\">\n    <input type=\"text\" name=\"taxname\" value=\"";
echo $tax["name"];
echo "\"/>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["state"];
echo " </td>\n    <td class=\"fieldarea\">\n    <input type=\"text\" name=\"state\" value=\"";
echo $tax["state"];
echo "\"/> <small>";
echo $LNG["leaveblankforall"];
echo " ";
echo $LNG["state"];
echo "</small> \n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["country"];
echo " </td>\n    <td class=\"fieldarea\">\n       ";
echo getCountriesDropDown($tax["country"], "country", "", $LNG["all"] . " " . $LNG["country"]);
echo " \n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["gateway"];
echo " </td>\n    <td class=\"fieldarea\">\n    <select name='gateway' >\n    \t<option value=''>";
echo $LNG["all"];
echo " ";
echo $LNG["gateway"];
echo "</option>\n    ";
$sql = dquery("select * from tbl_paymentgateways where setting='name' group by gateway");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "\t\t<option ";
    if ($tax["gateway"] == $row["gateway"]) {
        echo "selected";
    }
    echo " value=\"";
    echo $row["gateway"];
    echo "\">\n\t\t";
    echo $row["value"];
    echo "</option>\n\t";
}
echo " \n    </select>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["taxrate"];
echo " % </td>\n    <td class=\"fieldarea\">\n   <input type=\"text\" name=\"taxrate\" value=\"";
echo $tax["taxrate"];
echo "\" />\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\"> Fixed Charge</td>\n    <td class=\"fieldarea\">\n        <input type=\"text\" name=\"fixedcharge\" value=\"";
echo $tax["fixedcharge"];
echo "\" />\n    </td>\n</tr>\n </tbody>\n</table>\n\n<div class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" name=\"save\" class=\"btn save\" type=\"submit\"  />\n</div>\n\n</form>\n\n\n</div></div></div></div>\n ";
$fileverioncheck = "6.1.0";

?>