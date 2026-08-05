<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
echo "<div class=\"date-fonts\" id=\"notification\"></div>\n<div class=\"content\">\n        <div class=\"panel\">\n        <form   method=\"post\" id=\"frmreplys\">\n<input type=\"hidden\" name=\"mobile\" value=\"true\" />\n";
echo generate_token("form");
echo "\n             <ol>\n\n                 <li class=\"field\">\n                 <label>";
echo $LNG["siteundermaintanance"];
echo ":</label>\n                    <ul class=\"group\">\n\n                        <li><label class=\"btn\"><input type=\"radio\" name=\"config_is_under_maintanance\" id=\"em\" value=\"1\" ";
if ($config["config_is_under_maintanance"]) {
    echo "checked";
}
echo " /> ";
echo $LNG["enable"];
echo "</label></li>\n                        <li><label class=\"btn\"><input type=\"radio\" name=\"config_is_under_maintanance\" id=\"dm\" value=\"0\" ";
if (!$config["config_is_under_maintanance"]) {
    echo "checked";
}
echo " /> ";
echo $LNG["disable"];
echo "</label></li>\n                    </ul>\n                </li>\n                <li class=\"field\">\n                    <label>";
echo $LNG["support"];
echo " ";
echo $LNG["ticket"];
echo ":</label>\n                    <ul class=\"group\">\n<li><label class=\"btn\"><input type=\"radio\" name=\"supportticketservice\" id=\"sqe\" value=\"1\" ";
if ($config["supportticketservice"]) {
    echo "checked";
}
echo "  />";
echo $LNG["enable"];
echo "</label></li>\n<li><label class=\"btn\"><input type=\"radio\" name=\"supportticketservice\" id=\"sqd\" value=\"0\" ";
if (!$config["supportticketservice"]) {
    echo "checked";
}
echo "  />";
echo $LNG["disable"];
echo "</label></li>\n                    </ul>\n                </li>\n                    <li class=\"field\">\n                    <label>\n<a class=\"btn\" id=\"btnsaved\" onclick=\"SubmitForm ('#btnsaved','m.settings','#frmreplys','#notification','false','');\" >";
echo $LNG["save"];
echo "</a>\n                    </label>\n                    </li>\n             </ol>\n        </form>\n        </div>\n</div>\n";

?>