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
include_once "../../../comm.php";
require_once "../../includes/fun.inc.php";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n<meta http-equiv=\"content-type\" content=\"text/html; charset=";
echo $config["charset"];
echo "\" />\n<script src=\"../js/jquery.js\" type=\"text/javascript\"></script>\n<script src=\"../js/jquery.ui.min.js\"></script>\n<link href=\"../css/ui/style.css\" rel=\"stylesheet\"/>\n<script>\n\$(function() {\n\t\tvar dates = \$( \"#from\" ).datepicker({\n\t\t\tchangeMonth: true,\n            changeYear: true,\n            dateFormat:'yy-mm-dd', \n\t\t\tonSelect: function( selectedDate ) {\n\t\t\t\tvar option = this.id == \"from\" ? \"minDate\" : \"maxDate\",\n\t\t\t\t\tinstance = \$( this ).data( \"datepicker\" );\n\t\t\t\t\tdate = \$.datepicker.parseDate(\n\t\t\t\t\t\tinstance.settings.dateFormat ||\n\t\t\t\t\t\t\$.datepicker._defaults.dateFormat,\n\t\t\t\t\t\tselectedDate, instance.settings );\n\t\t\t\tdates.not( this ).datepicker( \"option\", option, date );\n\t\t\t}\n\t\t});\n});\n</script>\n</head>\n<body>\n";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($save && $to && $message && $subject) {
    checkDemoMode(false);
    $data["subject"] = $subject;
    $data["message"] = $message;
    $data["date"] = date("Y-m-d");
    $data["to"] = $to;
    $data["tid"] = rand(999, 999999);
    $data["from"] = $_SESSION["adminid"];
    $db->insert("tbl_message", $data);
    echo "<div id='notification1' class='successbox'>" . $LNG["message"] . " " . $LNG["send"] . " " . $LNG["successfully"] . "</div>";
} else {
    if ($save) {
        echo "<div id='notification1' class='errorbox'>" . $LNG["fieldblank"] . "</div>";
    }
}
echo "<link rel=\"stylesheet\" href=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/x-main2.css\" />\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td width=\"200px\" class=\"fieldlabel\">";
echo $LNG["send"];
echo " ";
echo $LNG["to"];
echo " </td>\n    <td class=\"fieldarea\">\n    <select name=\"to\">\n        <option value=\"\">";
echo $LNG["select"];
echo "</option>\n        ";
$sql = dquery("select username,id from tbl_admin \n        where id!='" . $_SESSION["adminid"] . "'");
while ($r = mysqli_fetch_assoc($sql)) {
    echo "            <option value=\"";
    echo $r["id"];
    echo "\">";
    echo $r["username"];
    echo "</option>\n        ";
}
echo "    </select>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["subject"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"subject\" value=\"\" /></td>\n</tr>\n<tr>\n    <td width=\"200px\" class=\"fieldlabel\">";
echo $LNG["message"];
echo " </td>\n    <td class=\"fieldarea\"><textarea name=\"message\" class=\"large\" rows=\"10\"></textarea></td>\n</tr>\n<tr>\n    <td></td>\n    <td><input type=\"submit\" class=\"btn save\" name=\"save\" value=\"";
echo $LNG["send"];
echo "\" /></td>\n</tr>\n</tbody>\n</table>\n</form>\n</body>\n</html>    ";
$fileverioncheck = "6.1.0";

?>