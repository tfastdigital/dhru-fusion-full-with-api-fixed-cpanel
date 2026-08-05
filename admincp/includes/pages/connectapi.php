<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 172;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/apiserver.fun.php";
$order = mysqli_fetch_assoc(dquery("select service_id,(select service_name from\r\ntbl_services_imei where id=service_id) as service from tbl_order_imei where \r\norder_id='" . $o . "'"));
$serviceDetails = mysqli_fetch_assoc(dquery("SELECT API,API_ID,useasserver FROM tbl_services_imei \r\nWHERE id='" . $order["service_id"] . "' "));
echo "<script>\r\nfunction connctTo(orders,API,API_ID2){\r\n    \$.post( \"includes/main.save.php?page=connectapi.save&orders=\"+orders+\"&API=\"+API+\"&API_ID2=\"+API_ID2, function( data ) {\r\n        alert(data);\r\n    });\r\n}\r\n</script>\r\n    <div  class=\"groupstabes \">\r\n\r\n        <h2 style=\"float: left;\">";
echo $LNG["order"];
echo " ";
echo $LNG["id"];
echo "#";
echo $o;
echo "</h2>\r\n\r\n        <h2 style=\"float: right\">";
echo $order["service"];
echo "</h2>\r\n\r\n        <hr />\r\n\r\n        <div class=\"groupstabescontant\">\r\n            <div id=\"notification\"></div>\r\n            <form method=\"post\" id=\"frmapi\">\r\n                <input type=\"hidden\" name=\"orders\" value=\"";
echo $o;
echo "\" />\r\n                <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\">\r\n                    <tbody>\r\n                    <tr>\r\n                        <td class=\"fieldlabel\">";
echo $LNG["connect"];
echo " ";
echo $LNG["api"];
echo "</td>\r\n                        <td class=\"fieldarea\">";
echo apiServerDropdown($serviceDetails["API"], "API", "", $serviceDetails["useasserver"] ? 1 : 0);
echo "</td>\r\n                    </tr>\r\n\r\n                    <tr>\r\n                        <td class=\"fieldlabel\">";
echo $LNG["api"];
echo " ";
echo $LNG["services"];
echo "</td>\r\n                        ";
$script = "onchange='loadCustom(this.value," . $id . ");'";
echo "                        <td class=\"fieldarea\"><div id=\"apiservicedropdown\" style=\"display: none;\"></div><span id=\"onloadapiservicedropdown\">";
echo apiServicesDropdown($serviceDetails["API"], $serviceDetails["API_ID"], "API_ID", "", $serviceDetails["useasserver"] ? 1 : 0, $serviceDetails["API_TYPEID"], $script);
echo "</span>\r\n                            <div class=\"customdisp\"></div>\r\n                        </td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>&nbsp;</td>\r\n                        <td><input type=\"button\" class=\"btn add\" name=\"connect\" value=\"";
echo $LNG["connect"];
echo " APi\"\r\n                        onclick=\"SubmitForm ('#btn','connectapi','#frmapi','#notification','true','#main_loader');\" /></td>\r\n                    </tr>\r\n                    </tbody>\r\n                </table>\r\n           </form>\r\n            <br/>\r\n            <br/>\r\n            <table>\r\n            ";
$api = dquery("select * from tbl_services_imei_api where sid='" . $order["service_id"] . "' order by sort asc");
while ($rapi = mysqli_fetch_assoc($api)) {
    $apiname = mysqli_fetch_assoc(dquery("select value from \r\n    tbl_apiservers where gateway='" . $rapi["api_server"] . "' and setting='name'"));
    $apiserv = mysqli_fetch_assoc(dquery("select `name`,credits from \r\n    tbl_apiserversservices where id='" . $rapi["api_server_id"] . "' and gateway='" . $rapi["api_server"] . "'"));
    $CustomName = "";
    if ($CustomName = mysqli_fetch_assoc(dquery("select * from\r\n        `tbl_apiservers` WHERE `gateway`='" . $rapi["api_server"] . "' \r\n        AND setting='customname'"))) {
        $CustomName = " (" . $CustomName["value"] . ")";
    }
    $Currency = mysqli_fetch_assoc(dquery("select * from\r\n    `tbl_apiservers` WHERE `gateway`='" . $rapi["api_server"] . "' \r\n    AND setting='currency'"));
    if (trim($apiname["value"])) {
        echo "                    <tr id=\"";
        echo $rapi["id"];
        echo "\">\r\n                        <td class=\"fieldlabel\">";
        echo $apiname["value"];
        echo " ";
        echo $CustomName;
        echo "                        <br />\r\n                            ";
        echo $apiserv["name"];
        echo " (";
        echo $apiserv["credits"];
        echo " ";
        echo $Currency["value"];
        echo ")\r\n                        </td>\r\n\r\n                        <td style=\"text-align: right;\" class=\"fieldlabel\">\r\n         <a href=\"javascript: connctTo('";
        echo $o;
        echo "','";
        echo $rapi["api_server"];
        echo "','";
        echo $rapi["api_server_id"];
        echo "')\">Connect</a>\r\n                        </td>\r\n                    </tr>\r\n                    ";
    }
}
echo "            </table>\r\n        </div></div>\r\n";
$fileverioncheck = "6.1.0";

?>