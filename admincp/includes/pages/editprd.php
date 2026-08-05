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
if ($mep && $prd != "") {
    checkDemoMode(false);
    $data["mep"] = $mep;
    $data["prd"] = $prd;
    if ($db->update("tbl_prd", $data, "id='" . $id . "'")) {
        echo "<div id=notification1 class=successbox> " . $LNG["datasave"] . " " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
}
$cntr = mysqli_fetch_assoc(dquery("SELECT * FROM tbl_prd WHERE id='" . $id . "'"));
echo "<link rel=\"stylesheet\" href=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/x-main2.css\" />\n<script src=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/js/x-main2.fun.js\" language=\"javascript\"></script>\n<div id=\"notification\"></div>\n<div  class=\"groupstabes\" style=\"padding: 30px;\">\n\n  <div class=\"groupstabescontant\">\n\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<h2>\n    <span class=\"groupstabesheadertext\">";
echo $cntr["prd"];
echo "</span>\n  </h2>\n\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<table class=\"form\">\n<tbody>\n\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["prd"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\"  class=\"txt medium\" name=\"prd\" value=\"";
echo $cntr["prd"];
echo "\" /></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["mep"];
echo "  </td>\n    <td class=\"fieldarea\">\n<input type=\"text\"  class=\"txt medium\" name=\"mep\" value=\"";
echo $cntr["mep"];
echo "\" />  </td>\n</tr>\n\n</tbody>\n</table>\n\n<div class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn save\" type=\"submit\"\n   onclick=\"SubmitForm ('#btnaddgroup','includes/page/editprd','#frm','#notification','true','#main_loader');\"/>\n</div>\n\n</form>\n\n\n</div></div></div></div>\n ";
$fileverioncheck = "6.1.0";

?>