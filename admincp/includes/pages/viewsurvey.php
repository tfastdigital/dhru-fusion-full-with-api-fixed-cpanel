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
echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n\n<div id=\"notification\"></div>\n\n<div id=\"content\" style=\"width: 100%;!important \">\n<div id=\"content_padded\" style=\"width: 100%;!important \">\n";
$sdet = mysqli_fetch_assoc(dquery("select * from tbl_survey_detail where id='" . $id . "'"));
$surv = mysqli_fetch_assoc(dquery("select * from tbl_survey where id='" . $sdet["srid"] . "'"));
echo "\n\n<form method=\"post\" id=\"frms\">\n<table class=\"form\" >\n<tbody>\n \n<tr>\n<td  style=\"width: 25% !important;\" class=\"fieldlabel\">";
echo $LNG["title"];
echo "</td>\n<td style=\"width: 1% !important;\">:</td>\n<td class=\"fieldarea\">";
echo $surv["title"];
echo "</td>\n</tr>\n\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["detail"];
echo "</td>\n<td style=\"width: 1% !important;\">:</td>\n<td class=\"fieldarea\">";
echo $surv["detail"];
echo "</td>\n</tr>\n\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["user"];
echo "</td>\n<td style=\"width: 1% !important;\">:</td>\n<td class=\"fieldarea\">";
echo $sdet["name"] . " [" . $sdet["email"] . "]";
echo "</td>\n</tr>\n\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["date"];
echo "</td>\n<td style=\"width: 1% !important;\">:</td>\n<td class=\"fieldarea\">";
echo $sdet["date"];
echo "</td>\n</tr>\n";
include_once ROOTDIR . "/includes/customfield.fun.inc.php";
$cst = getCustomFields("survey_" . $surv["id"], $surv["id"], $sdet["id"]);
if ($cst) {
    foreach ($cst as $custom) {
        if ($custom["value"]) {
            echo "<tr>\n<td class=\"fieldlabel\">";
            echo $custom["name"];
            echo " </td>\n<td style=\"width: 1% !important;\">:</td>\n<td class=\"fieldarea\">";
            echo $custom["value"];
            echo "</td>\n</tr>  \n        ";
        }
    }
}
echo "\n</tbody></table>\n</form>\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>