<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n";
$pageid = 296;
checkPagePermission($pageid);
require ROOTDIR . "/includes/clients.fun.inc.php";
include "includes/3rdparty/editor/editor.php";
if ($code && ($prefix || $suffix) && $rate) {
    if (strlen($code) != 3) {
        echo "<div id=notification1 class=errorbox>Currency code should be 3 characters only</div>";
    } else {
        if (is_numeric($code)) {
            echo "<div id=notification1 class=errorbox>Currency code should not numeric </div>";
        } else {
            checkDemoMode(false);
            $data["code"] = $code;
            $data["prefix"] = $prefix;
            $data["suffix"] = $suffix;
            $data["rate"] = $rate;
            $data["format"] = $format;
            if (!mysqli_num_rows(dquery("select * from tbl_currencies where code='" . $code . "'"))) {
                if ($db->insert("tbl_currencies", $data)) {
                    echo "<div id=notification1 class=successbox>  " . $LNG["savesuccessfully"] . " </div>";
                } else {
                    echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
                }
            } else {
                echo "<div id=notification1 class=errorbox> " . $LNG["currency"] . " " . $LNG["code"] . " " . $LNG["already"] . " " . $LNG["exists"] . "</div>";
            }
        }
    }
} else {
    if ($save) {
        echo "<div id=notification1 class=errorbox> " . $LNG["fieldblank"] . " </div>";
    }
}
echo "\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"newpost\" name=\"newpost\" method=\"post\">\n<input type=\"hidden\" name=\"defaultpage\" value=\"addcurrency.php\" />\n";
echo generate_token("form");
echo "<table><tr><td width=\"50%\" valign=\"top\">\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\" width=\"150px\">";
echo $LNG["code"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n     <input type=\"text\"  class=\"txt small\" name=\"code\" value=\"\" />\n    </span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\" width=\"150px\">";
echo $LNG["prefix"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\"  class=\"txt small\" name=\"prefix\" value=\"\" />\n    </span></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\" width=\"150px\">";
echo $LNG["suffix"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n   <input type=\"text\"  class=\"txt small\" name=\"suffix\" value=\"\" />\n    </span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\" width=\"150px\">";
echo $LNG["format"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n        <select name=\"format\">\n            <option value=\"1\">1000.99</option>\n            <option value=\"2\">1,000.99</option>\n            <option value=\"3\">1,000,99</option>\n            <option value=\"4\">1,000</option>\n        </select>\n    </span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\" width=\"150px\">";
echo $LNG["rate"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n\t<input type=\"text\"  class=\"txt small\" name=\"rate\" value=\"\" />\n    </span></td>\n</tr>\n\n\n\n\n</tbody>\n</table>\n</td></tr></table>\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" name=\"save\" id=\"btnpost\" class=\"btn\" type=\"submit\"  /></p>\n</form>\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>