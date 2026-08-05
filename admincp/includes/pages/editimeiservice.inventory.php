<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

licince\chklite();
$pageid = 209;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/imeiservices.fun.php";
$md5id = md5($id);
$imeiserviceDetails = getIMEIServices("", $md5id);
$gate = mysqli_fetch_assoc(dquery("select * from tbl_apiserversservices\nwhere gateway='" . $row["API"] . "' and id='" . $row["API_ID"] . "'"));
$apis = mysqli_fetch_assoc(dquery("select value from \ntbl_apiservers where gateway='" . $row["API"] . "' and setting='currency'"));
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n    <script>\n        function autoUpdate()\n        {\n            if(\$('#autoupdate').is(\":checked\")){\n                \$.post( \"includes/pages/pocost.php?po=\"+\$(\".purchasecost\").val(), function( data ) {\n\n                    pricy=data.split('_');\n                    for (var i = 0; i < pricy.length; i++) {\n                        pris=pricy[i].split(\"=\");\n                        \$(\".po\"+pris[0]).val(pris[1]);\n                    }\n                });\n            }\n        }\n    </script>\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "\n<div  class=\"groupstabes first\" >\n  <h2>\n    <span class=\"groupstabesheadertext\">Inventory</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n     <td class=\"fieldlabel\">";
echo $LNG["purchase"];
echo " ";
echo $LNG["cost"];
echo " ";
echo $LNG["perunit"];
echo "</td>\n     <td class=\"fieldarea\"><input type=\"text\"  class=\"txt small\"\n value=\"";
echo $imeiserviceDetails["purchase_cost"];
echo "\" class=\"purchasecost\"\n      name=\"purchasecost\" onkeyup=\"return cF(this,false)\"\n       onblur=\"return cF(this,true)\"/>\n<span class=\"preforms\">";
echo $_SESSION["system_default_currency"]["code"];
echo "</span>\n </td>\n</tr>\n\n";
$sql = dquery("select id,code from tbl_currencies WHERE `default`='0'");
while ($row = mysqli_fetch_assoc($sql)) {
    $price = getPurchaseCost($row["id"], $imeiserviceDetails["id"], "imei");
    echo "    <tr>\n        <td class=\"fieldlabel\">";
    echo $LNG["purchase"];
    echo " ";
    echo $LNG["cost"];
    echo " ";
    echo $LNG["perunit"];
    echo "</td>\n        <td class=\"fieldarea\">\n            <input type=\"text\"  class=\"txt small po";
    echo $row[code];
    echo "\"  value=\"";
    echo $price;
    echo "\" name=\"purchase[";
    echo $row["id"];
    echo "]\" onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/>\n\n            ";
    echo $row["code"];
    echo "        </td><td></td>\n    </tr>\n    ";
}
echo "\n<tr>\n   <td class=\"fieldlabel\">";
echo $LNG["current"];
echo " ";
echo $LNG["stock"];
echo "</td>\n   <td class=\"fieldarea\"><input type=\"text\"  class=\"txt small\"\n   value=\"";
echo $imeiserviceDetails["stock"];
echo "\" name=\"currentstock\"\n   onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/></td>\n</tr>\n\n<tr>\n   <td class=\"fieldlabel\">";
echo $LNG["stock"];
echo " ";
echo $LNG["calculation"];
echo "</td>\n   <td class=\"fieldarea\"><input ";
if ($imeiserviceDetails["stock_allow"] == "1") {
    echo "checked=checked";
}
echo "   name=\"calculation\" value=\"1\" type=\"checkbox\"\n   class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"calculation1\"/>\n   <label for=\"calculation1\"></label></td>\n</tr>\n\n</tbody>\n</table>\n</div></div>\n\n<p class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"button_save\" type=\"button\"  onclick=\"SubmitForm ('#btnedituser','editimeiservice.inventory','#frmedituser','#notification','true','#main_loader');\"/>\n</p>\n</form>\n\n</div>\n</div>";
$fileverioncheck = "6.1.0";
echo "<script>\n    \$( document ).ready(function() {\n        \$(\".colorpicker\").hide();\n    });\n\n</script>\n\n";

?>