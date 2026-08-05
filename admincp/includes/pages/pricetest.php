<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($getprice && $currecnyid) {
    include ROOTDIR . "/includes/imeiservices.fun.php";
    $Price = new ServicePrice($serviceid);
    $RES = $Price->getServicePricing($currecnyid, $qnt, $clientgroupid, $clientid);
    $cur = mysqli_fetch_assoc(dquery("select code from tbl_currencies where id='" . $currecnyid . "'"));
    echo "<div class='successbox success'>Unit Price :" . $RES . " " . $cur["code"] . "</div>";
} else {
    if ($getprice) {
        echo "<div class='errorbox error'>Currency Requried</div>";
    }
}
echo "<form method=\"post\">\r\n    <table class=\"form\">\r\n        <TR>\r\n            <td class=\"fieldlabel\">Service</td>\r\n            <td class=\"fieldarea\">\r\n<select name=\"serviceid\" class=\"chosen\" >\r\n\r\n    ";
$q = dquery("select id,service_name from tbl_services_imei");
while ($r = mysqli_fetch_assoc($q)) {
    $selected = "";
    if ($serviceid == $r["id"]) {
        $selected = "selected";
    }
    echo "        <option ";
    echo $selected;
    echo " value=\"";
    echo $r["id"];
    echo "\">";
    echo $r["service_name"];
    echo "</option>\r\n    ";
}
echo "</select>\r\n\r\n            </td>\r\n        </TR>\r\n        <TR>\r\n            <td class=\"fieldlabel\">Qnt</td>\r\n            <td class=\"fieldarea\">\r\n                <input type=\"text\" name=\"qnt\" value=\"";
echo $qnt ? $qnt : 1;
echo "\" placeholder=\"QNT\" size=\"3\" />\r\n            </td>\r\n        </TR>\r\n        <TR>\r\n            <td class=\"fieldlabel\">Client Group</td>\r\n            <td class=\"fieldarea\">\r\n                <select name=\"clientgroupid\">\r\n                    <option value=\"base\">Default Group</option>\r\n                    <option ";
if ($clientgroupid == "retail") {
    echo "selected";
}
echo " value=\"retail\">Retail User</option>\r\n                    ";
$q = dquery("select id,groupname from tbl_client_group");
while ($r = mysqli_fetch_assoc($q)) {
    $selected = "";
    if ($clientgroupid == $r["id"]) {
        $selected = "selected";
    }
    echo "                        <option ";
    echo $selected;
    echo " value=\"";
    echo $r["id"];
    echo "\">";
    echo $r["groupname"];
    echo "</option>\r\n                        ";
}
echo "                </select>\r\n            </td>\r\n        </TR>\r\n        <TR>\r\n            <td class=\"fieldlabel\">Currency </td>\r\n            <td class=\"fieldarea\">\r\n                <select name=\"currecnyid\">\r\n\r\n                    ";
$q = dquery("select id,code from tbl_currencies");
while ($r = mysqli_fetch_assoc($q)) {
    $selected = "";
    if ($currecnyid == $r["id"]) {
        $selected = "selected";
    }
    echo "                        <option  ";
    echo $selected;
    echo " value=\"";
    echo $r["id"];
    echo "\">";
    echo $r["code"];
    echo "</option>\r\n                        ";
}
echo "                </select>\r\n            </td>\r\n        </TR>\r\n        <!--\r\n        <TR>\r\n            <td class=\"fieldlabel\">Client</td>\r\n            <td class=\"fieldarea\">\r\n                <select name=\"clientid\">\r\n                    <option value=\"\">Select</option>\r\n\r\n                    ";
$q = dquery("select id,username from tblUsers");
while ($r = mysqli_fetch_assoc($q)) {
    $selected = "";
    if ($serviceid == $r["id"]) {
        $selected = "selected";
    }
    echo "                        <option ";
    echo $selected;
    echo " value=\"";
    echo $r["id"];
    echo "\">";
    echo $r["username"];
    echo "</option>\r\n                        ";
}
echo "                </select>\r\n            </td>\r\n        </TR>\r\n        -->\r\n        <tr>\r\n            <td></td>\r\n            <td>\r\n\r\n            </td>\r\n        </tr>\r\n    </table>\r\n    <p class=\"fixedbtn\">\r\n        <input type=\"submit\" name=\"getprice\"\r\n               value=\"Get Price\" />\r\n    </p>\r\n\r\n</form>\r\n";
$fileverioncheck = "6.1.0";

?>