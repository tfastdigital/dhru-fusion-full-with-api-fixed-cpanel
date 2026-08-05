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
echo "\" />\n<script src=\"../js/jquery.js\" type=\"text/javascript\"></script>\n\n\n</head>\n<body>\n";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($save) {
    checkDemoMode(false);
    $data["name"] = $name;
    $data["email"] = $email;
    $data["comment"] = nl2br($comment);
    $data["date"] = $date;
    $data["status"] = $status;
    $db->update("tbl_review", $data, "id=" . $id);
    echo "<div id='notification1' class='successbox'>" . $LNG["datasavesuccessfully"] . "</div>";
}
$sql = mysqli_fetch_assoc(dquery("select * from tbl_review where id='" . $id . "'"));
if ($sql["sid"]) {
    $pro = mysqli_fetch_assoc(dquery("select service_name from tbl_services_imei where id='" . $sql["sid"] . "'"));
} else {
    $pro = mysqli_fetch_assoc(dquery("select service_name from tbl_products where id='" . $sql["pid"] . "'"));
}
echo "<link rel=\"stylesheet\" href=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/x-main2.css\" />\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["service"];
echo "/";
echo $LNG["product"];
echo " </td>\n    <td class=\"fieldarea\"> ";
echo $pro["service_name"];
echo "</td>\n</tr>\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["name"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\"  class=\"txt large\" name=\"name\" value=\"";
echo $sql["name"];
echo "\" /></td>\n</tr>\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["email"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\"  class=\"txt medium\" name=\"email\" value=\"";
echo $sql["email"];
echo "\" /></td>\n</tr>\n\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["date"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\"  placeholder=\"yyyy-mm-dd\" class=\"txt medium datepicker\" id=\"from\" name=\"date\" value=\"";
echo $sql["date"];
echo "\" /></td>\n</tr>\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["comments"];
echo " </td>\n    <td class=\"fieldarea\"><textarea name=\"comment\" class=\"textarea large\" rows=\"5\">";
echo $sql["comment"];
echo "</textarea></td>\n</tr>\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["ratings"];
echo " </td>\n    <td class=\"fieldarea\">";
echo $sql["rate"];
echo "</td>\n</tr>\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["status"];
echo " </td>\n    <td class=\"fieldarea radio\"><input type=\"radio\" ";
if ($sql["status"]) {
    echo "checked";
}
echo " name=\"status\" value=\"1\" id=\"ap\"/><label for=\"ap\">";
echo $LNG["approved"];
echo "</label>\n    <input type=\"radio\" ";
if (!$sql["status"]) {
    echo "checked";
}
echo " name=\"status\" value=\"0\" id=\"pe\"/><label for=\"pe\">";
echo $LNG["pending"];
echo "</label>\n    </td>\n</tr>\n</tbody>\n</table>\n\n<div class=\"fixedbtn\">\n    <input type=\"submit\" class=\"btn save\" name=\"save\" value=\"";
echo $LNG["save"];
echo "\" />\n</div>\n\n</form>\n</body>\n</html>    ";
$fileverioncheck = "6.1.0";

?>