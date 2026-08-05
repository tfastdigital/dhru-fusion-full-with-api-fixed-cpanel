<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$info = mysqli_fetch_assoc(dquery("select howtoinfo from tbl_services_imei where id='" . $id . "'"));
echo "<form id=\"frmbrand\" name=\"\" method=\"post\" class=\"full-editor\">\n    <div id=\"notification\"></div>\n    <input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n    <input type=\"hidden\" value=\"\" base64encode=\"true\" name=\"tinyvalue\" id=\"tinyvalue\"/>\n    ";
echo generate_token("form");
echo "\n\n\n<textarea name=\"howtoinfo\" cols=\"50\" rows=\"6\"\n          id=\"message\">";
echo $info["howtoinfo"];
echo "</textarea>\n\n\n</form>\n\n<p class=\"fixedbtn\">\n    <button name=\"submit\" value=\"submit\" id=\"btnedituser2\" class=\"btn save\"\n            onclick=\"SubmitFormNew('#btnedituser2','editimeiservice.howto','#frmbrand','#notification','true','#main_loader');\">";
echo $LNG["save"];
echo " </button>\n\n\n</p>\n";
$fileverioncheck = "6.1.0";

?>