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
$id = preg_replace("/[^0-9a-zA-Z]/i", "", $id);
$sql = mysqli_fetch_assoc(dquery("select * from tbl_livehelp_conversation where id='" . $id . "'"));
$message = html_entity_decode(nl2br($message));
echo "\n <div class=\"title\" style=\"text-align: center;\">\n     <i>You have joined the chat conversation with  <span style=\"color: #fba400;\"> <strong>";
echo $sql["name"];
echo "</strong> <i class=\"fa fa-envelope\"></i> ";
echo $sql["email"];
echo " </span> at <span style=\"color: #29ab29;\"> ";
echo date("H:i:s A", $sql["time"]);
echo " </i> </span>  \n    <div style=\"padding: 10px;\">                 \n        <!--<strong>Department:</strong> ankur  <br />-->\n         <i> Subject </i> : <strong style=\"color: #0a0a0a;\"> ";
echo $sql["subject"];
echo "</strong>  \n    </div>\n</div>\n    \n    \n<div id=\"conversationMain\">\n        \n    <div id=\"conversation\" class=\"conversation\" style=\"padding: 20px;\">  </div>\n     \n</div>\n\n<div>\n<form id=\"frmchat\" method=\"post\"> \n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"chatid\" />\n<div style=\"position: fixed;  bottom: 0;left:0;right:0;\">\n    <table style=\"width: 100%;background: #f4f4f4;\">\n    <tr>\n        <td style=\"width: 100%;padding:10px 0 10px 10px\"><textarea id=\"message\" name=\"message\" style=\"height: 50px;width:100% \"></textarea></td>\n        <td style=\"padding: 10px;\"><input type=\"button\" id=\"send\" name=\"send\" value=\"Send\" onclick=\"SubmitCahtForm()\" style=\"width: 90px; height: 50px;\" /></td>\n    </tr>\n    </table>\n</div>\n</form>\n</div>\n \n";
$fileverioncheck = "6.1.0";

?>