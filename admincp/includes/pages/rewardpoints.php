<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n    .form{margin-bottom: 4px !important;}\n</style>\n";
$pageid = 32;
checkPagePermission($pageid);
$sql = mysqli_fetch_assoc(dquery("select * from tbl_settings where attribute='config'"));
$config = unserialize($sql["value"]);
if ($config["addfundpoints"]) {
    $Groupwise = json_decode($config["addfundpoints"], true);
}
getAllCurrency();
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n    <div id=\"content_padded\">\n        <form id=\"frm\" name=\"\" method=\"post\">\n            ";
echo generate_token("form");
echo "            <div>\n                <h2>\n                    <span class=\"groupstabesheadertext\">";
echo $LNG["reward"];
echo " ";
echo $LNG["points"];
echo "</span>\n                </h2>\n                <div class=\"groupstabescontant\">\n\n                    <table class=\"form\">\n\n                            <tr>\n<td class=\"fieldlabel\">";
echo $LNG["reward"];
echo "  ";
echo $LNG["system"];
echo "</td>\n<td class=\"fieldarea\">\n<input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\"\nname=\"rewardpoint\" value=\"1\" id=\"hs\" ";
if ($config["rewardpoint"]) {
    echo "checked";
}
echo "/><label for=\"hs\"></label>\n</td>\n                            </tr>\n\n                    </table>\n<br /><hr />\n<h2>\n    <span class=\"groupstabesheadertext\">";
echo $LNG["addfund"];
echo " ";
echo $LNG["reward"];
echo " ";
echo $LNG["points"];
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n</h2>\n                    <table id=\"main_tbl\">\n<tr>\n    <td><strong>Base</strong></td>\n    ";
foreach ($_SESSION["allcurrency"]["code"] as $code => $cdetail) {
    echo "        <td>1 ";
    echo $code;
    echo " = <input type=\"text\" name=\"clientgroup[base][";
    echo $cdetail["id"];
    echo "]\"\n        value=\"";
    echo $Groupwise["base"][$cdetail["id"]];
    echo "\" style=\"width:60px;\" /> <small>points</small></td>\n        ";
}
echo "</tr>\n";
$q = dquery("select id,groupname from tbl_client_group");
while ($r = mysqli_fetch_assoc($q)) {
    echo "<tr>\n    <td><strong>";
    echo $r["groupname"];
    echo "</strong></td>\n    ";
    foreach ($_SESSION["allcurrency"]["code"] as $code => $cdetail) {
        echo "        <td>1 ";
        echo $code;
        echo " = <input type=\"text\" name=\"clientgroup[";
        echo $r["id"];
        echo "][";
        echo $cdetail["id"];
        echo "]\"\n                   value=\"";
        echo $Groupwise[$r["id"]][$cdetail["id"]];
        echo "\" style=\"width:60px;\" /><small> points</small></td>\n    ";
    }
    echo "</tr>\n";
}
echo "                    </table>\n\n                </div>\n            </div>\n\n\n\n\n        </form>\n        <p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\"\n  id=\"btnaddgroup\" class=\"btn\" type=\"button\"\nonclick=\"SubmitForm ('#btnaddgroup','rewardpoints','#frm','#notification','true','#main_loader');\"/></p>\n    </div></div>";
$fileverioncheck = "6.1.0";

?>