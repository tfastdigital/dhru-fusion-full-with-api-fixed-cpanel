<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"notification\"></div>\n<div id=\"content\">\n    <div id=\"content_padded\">\n        ";
if ($remove && $id) {
    dquery("delete from tblPaymentAggregator where aggregatorid='" . $id . "'");
}
echo "<table id=\"main_tbl\" >\n    <thead>\n    <tr>\n        <th>";
echo $LNG["aggregator"];
echo " ";
echo $LNG["name"];
echo "</th>\n        <th><div align=\"left\">UIID</div> </th>\n        <th><div align=\"right\">Transaction</div> </th>\n        <th><div align=\"right\">";
echo $LNG["action"];
echo "</div> </th>\n    </tr>\n    </thead>\n    <tbody>\n\n\n    ";
$sql = dquery("select * from tblPaymentAggregator");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "        <tr>\n            <td>";
    echo $row["aggregatorname"];
    echo "</td>\n            <td>";
    echo $row["apikey"];
    echo "</td>\n            <td align=\"right\" >              <a href=\"javascript: void(0)\"  onclick=\"load_subpage('main2.php?page=aggregatortransaction&id=";
    echo $row["aggregatorid"];
    echo "', '";
    echo $LNG["transaction"];
    echo "');\n                    return false;\" class=\"\">";
    echo $LNG["view"];
    echo "</a>\n            </td>\n          <td align=\"right\" class=\"action\">\n\n              <a href=\"javascript: void(0)\"  onclick=\"load_subpage('main2.php?page=editpaymentaggregator&id=";
    echo $row["aggregatorid"];
    echo "', '";
    echo $LNG["edit"];
    echo "');\n                                                    return false;\" class=\"editdata\">";
    echo $LNG["edit"];
    echo "</a>\n                <a onclick=\"return confirm('Are you sure want to remove Aggregator?');\"  href=\"javascript:reloadcurrent('paymentaggregation&laoddefaultpage=aggregationlist.php','";
    echo $row["aggregatorid"];
    echo "&remove=true')\" class=\"deletedata\">";
    echo $LNG["delete"];
    echo "</a></td>\n        </tr>\n        ";
}
echo "    </tbody>\n</table>\n        ";
$Arr[2000] = "Signature Unverified";
$Arr[2001] = "Wrong Transaction id";
$Arr[2002] = "Wrong Amount";
$Arr[2005] = "Monthly limit completed";
$Arr[2006] = "Wrong UIID";
foreach ($Arr as $code => $error) {
    echo "            <div id=\"notification1\" class=\"info\">";
    echo $code . " : " . $error;
    echo "</div>\n            ";
}
echo "    </div>\n</div>\n";
$fileverioncheck = "6.1.0";

?>