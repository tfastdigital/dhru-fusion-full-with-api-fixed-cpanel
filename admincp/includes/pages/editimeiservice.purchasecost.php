<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
include_once ROOTDIR . "/includes/imeiservices.fun.php";
if ($saver && $purchasecost) {
    checkDemoMode(false);
    if ($purchase) {
        foreach ($purchase as $k => $v) {
            if ($v) {
                if (mysqli_num_rows(dquery("select id from tbl_purchase_cost \n                        where cid='" . $k . "' and sid='" . $id . "' and type='imei'"))) {
                    $data["price"] = $v;
                    $db->update("tbl_purchase_cost", $data, "sid='" . $id . "' and type='imei' and cid='" . $k . "'");
                    $data = NULL;
                } else {
                    $data["price"] = $v;
                    $data["cid"] = $k;
                    $data["sid"] = $id;
                    $data["type"] = "imei";
                    $db->insert("tbl_purchase_cost", $data);
                    $data = NULL;
                }
            }
        }
    }
    $data["purchase_cost"] = formatCurrency2($purchasecost);
    if ($db->update("tbl_services_imei", $data, "id=" . $id)) {
        echo "<div id='notification1' class='successbox' >" . $LNG["datasavesuccessfully"] . "</div>";
    }
} else {
    if ($saver) {
        echo "<div id='notification1' class='errorbox' >Default Currency should not blank</div>";
    }
}
$md5id = md5($id);
$imeiserviceDetails = getIMEIServices("", $md5id);
$row = mysqli_fetch_assoc(dquery("select credit,API,API_ID,promotiondis \nfrom tbl_services_imei where id=" . $id));
$gate = mysqli_fetch_assoc(dquery("select * from tbl_apiserversservices\nwhere gateway='" . $row["API"] . "' and id='" . $row["API_ID"] . "'"));
$apis = mysqli_fetch_assoc(dquery("select value from \ntbl_apiservers where gateway='" . $row["API"] . "' and setting='currency'"));
echo "\n<link rel=\"stylesheet\" href=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/x-main2.css\" />\n<script src=\"../js/jquery.js\" language=\"javascript\"></script>\n<script src=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/js/x-main2.fun.js\" language=\"javascript\"></script>\n<script>\n    function autoUpdate()\n    {\n        if(\$('#autoupdate').is(\":checked\")){\n            \$.post( \"includes/pages/pocost.php?po=\"+\$(\".purchasecost\").val(), function( data ) {\n\n                pricy=data.split('_');\n                for (var i = 0; i < pricy.length; i++) {\n                   pris=pricy[i].split(\"=\");\n                   \$(\".po\"+pris[0]).val(pris[1]);\n                }\n            });\n        }\n    }\n</script>\n<form id=\"frmnetwork\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<input type=\"hidden\" value=\"true\" name=\"curs\" />\n";
echo generate_token("form");
echo "\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["service"];
echo " ";
echo $LNG["price"];
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n\n<table class=\"form\">\n\n<tr>\n<td class=\"fieldlabel\">";
echo $config["base_currency"];
echo "*</td><td class=\"fieldarea\"><input type=\"text\"  class=\"txt small purchasecost\"  name=\"purchasecost\" value=\"";
echo $imeiserviceDetails["purchase_cost"];
echo "\" /></td><td></td>\n</tr>\n";
if ($gate["credits"]) {
    echo "<tr>\n    <td class=\"fieldlabel\">Price from API</td>\n    <td class=\"fieldarea\">";
    echo $gate["credits"] . " " . $apis["value"];
    echo "</td>\n</tr>\n";
}
echo "    <tr>\n        <td class=\"fieldlabel\"></td>\n        <td class=\"fieldarea\"><label><input type=\"checkbox\" name=\"autoupdate\"\nonclick=\"autoUpdate();\"\nvalue=\"1\" id=\"autoupdate\" />Auto Update Other Currency Price</label></td>\n    </tr>\n</table>\n</div></div>\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["manage"];
echo " ";
echo $LNG["other"];
echo " ";
echo $LNG["currency"];
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n\n<table class=\"form\">\n\n\n";
$sql = dquery("select id,code from tbl_currencies WHERE `default`='0'");
while ($row = mysqli_fetch_assoc($sql)) {
    $price = getPurchaseCost($row["id"], $imeiserviceDetails["id"], "imei");
    echo "<tr>\n     <td class=\"fieldlabel\">";
    echo $row["code"];
    echo "</td>\n     <td class=\"fieldarea\">\n<input type=\"text\"  class=\"txt small po";
    echo $row[code];
    echo "\"  value=\"";
    echo $price;
    echo "\" name=\"purchase[";
    echo $row["id"];
    echo "]\" onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/> </td><td></td>\n</tr>\n";
}
echo " </table>\n</div></div>\n\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" name=\"saver\" id=\"btnedituser\" class=\"btn save\" type=\"submit\" /></p>\n\n</form>";
$fileverioncheck = "6.1.0";

?>