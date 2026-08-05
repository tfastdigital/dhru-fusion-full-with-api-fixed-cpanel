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
if ($status) {
    checkDemoMode(false);
    $data["status"] = $status;
    $data["color"] = $color;
    if ($db->update("tbl_support_status", $data, "id='" . $id . "'")) {
        echo "<div id=notification1 class=successbox> " . $LNG["datasave"] . " " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
}
$cntr = mysqli_fetch_assoc(dquery("SELECT * FROM tbl_support_status WHERE id='" . $id . "'"));
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td   class=\"fieldlabel\">";
echo $LNG["ticket"];
echo " ";
echo $LNG["status"];
echo "</td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"status\" value=\"";
echo $cntr["status"];
echo "\" /></td>\n</tr>\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["color"];
echo "</td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"color\" value=\"";
echo $cntr["color"];
echo "\" /></td>\n</tr>\n \n</tbody>\n</table>\n\n<div class=\"fixedbtn\">\n     <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn save\" type=\"submit\"  onclick=\"SubmitForm ('#btnaddgroup','editstatus','#frm','#notification','true','#main_loader');\"/>\n</div>\n\n</form></div></div>";
$fileverioncheck = "6.1.0";

?>