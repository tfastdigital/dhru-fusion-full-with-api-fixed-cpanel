<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n";
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
$ban = mysqli_fetch_assoc(dquery("SELECT  * FROM `tbl_add_management` WHERE `p_id`='" . $_GET["p_id"] . "' and `type`='" . $type . "'"));
echo "<div id=\"tabcontent\">\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<form method=\"post\" id=\"frm\">\n<input type=\"hidden\" name=\"p_id\" value=\"";
echo $_GET["p_id"];
echo "\" />\n<input type=\"hidden\" name=\"type\" value=\"";
echo $_GET["type"];
echo "\" />\n<table style=\"width: 100%\">\n\t<tr><td valign=\"center\" style=\"width: 10%\"><span>";
echo $LNG["html"];
echo " ";
echo $LNG["code"];
echo "</span></td><td><textarea rows=\"20\" cols=\"2\" name=\"html_code\" style=\"width: 100%;margin: 0;padding: 0;\">";
echo $ban["html_code"];
echo "</textarea></td></tr>\n</table>\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnoverview\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnoverview','editadvertisement','#frm','#notification','true','#main_loader');\"/>\n</p>\n</form>\n</div></div>\n </div>";
$fileverioncheck = "6.1.0";

?>