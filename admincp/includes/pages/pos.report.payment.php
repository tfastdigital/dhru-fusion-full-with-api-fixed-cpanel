<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 490;
checkPagePermission($pageid);
licince\reqaddon("POS");
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n";
if (!$wid) {
    $w = mysqli_fetch_assoc(dquery("select mywarehouse from tbl_admin where id='" . $_SESSION["adminid"] . "'"));
    $wid = $w["mywarehouse"];
}
echo $LNG["warehouse"];
echo " &nbsp;<select name=\"warehouse\" \nonchange=\"javascript: location.href='main2.php?page=pos.report.payment&wid='+this.value\">\n";
$s = dquery("select id,name from tbl_warehouse");
while ($r = mysqli_fetch_assoc($s)) {
    echo "<option ";
    if ($wid != "" && $wid == $r["id"]) {
        echo "selected";
    }
    echo " value=\"";
    echo $r["id"];
    echo "\">";
    echo $r["name"];
    echo "</option>\n";
}
echo "</select>\n<br /><br />\n<form id=\"replied\" name=\"replied\" method=\"post\" > \n";
echo generate_token("form");
echo "<table id=\"main_tbl\" >\n<thead>\n  <tr>\n        <th>";
echo $LNG["payment"];
echo " ";
echo $LNG["type"];
echo "</th>\n        <th>";
echo $LNG["total"];
echo " </th>\n  </tr>\n</thead> \n<tbody>  \n";
$sql = dquery("SELECT gateway,value, (\n\nSELECT sum( total )\nFROM tbl_invoices\nWHERE paymentmethod = gateway\nAND STATUS = 'Paid' and pos='1' and warehouse='" . $wid . "'\n) AS totals\nFROM tbl_paymentgateways where setting='name'");
while ($row = mysqli_fetch_assoc($sql)) {
    $cur = mysqli_fetch_assoc(dquery("select value from tbl_paymentgateways where gateway='" . $row["gateway"] . "' \nand setting='curcode'"));
    echo "    <tr>\n        <td>";
    echo $row["value"];
    echo "</td>\n        <td>";
    echo $row["totals"];
    echo " ";
    echo $cur["value"];
    echo "</td>\n    </tr>\n";
}
echo "</tbody></table>\n</form></div></div> \n";
$fileverioncheck = "6.1.0";

?>