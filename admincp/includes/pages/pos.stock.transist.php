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
if ($accept) {
    checkDemoMode(false);
    $w = mysqli_fetch_assoc(dquery("select * from tbl_warehousestock\n    where id='" . $accept . "'"));
    $ins["status"] = 1;
    $db->update("tbl_warehousestock", $ins, "id='" . $accept . "'");
    $ins = NULL;
    dquery("update tbl_serial_list set transist='' where \n    transist='" . $w["time"] . "'");
    $ins["wid"] = $w["transferto"];
    $ins["pid"] = $w["pid"];
    $ins["stockin"] = $w["stockout"];
    $ins["transferby"] = $w["transferby"];
    $ins["time"] = time();
    $ins["status"] = 1;
    $ins["date"] = $w["date"];
    $db->insert("tbl_warehousestock", $ins);
    $ins = NULL;
}
echo $LNG["warehouse"];
echo " &nbsp;<select name=\"warehouse\" \nonchange=\"javascript: location.href='main2.php?page=pos.stock.transist&wid='+this.value\">\n<option value=\"\">-Select Warehouse-</option>\n";
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
echo $LNG["product"];
echo "</th>\n        <th>";
echo $LNG["qnt"];
echo "</th>\n        <th>Sent On</th>\n        <th>Appx. ";
echo $LNG["delivery"];
echo "</th>\n        <th>";
echo $LNG["notes"];
echo "</th>\n        <th>";
echo $LNG["received"];
echo "</th>\n  </tr>\n</thead> \n<tbody>  \n";
if ($wid) {
    $sql = dquery("SELECT * from tbl_warehousestock\nwhere transferby='Transport' and status=0 and transferto='" . $wid . "'");
    while ($row = mysqli_fetch_assoc($sql)) {
        $cur = mysqli_fetch_assoc(dquery("select service_name from \ntbl_products where id='" . $row["pid"] . "'"));
        echo "    <tr>\n        <td>";
        echo $cur["service_name"];
        echo "</td>\n        <td>";
        echo $row["stockout"];
        echo "</td>\n        <td>";
        echo date("Y-m-d H:i:s", $row["time"]);
        echo "</td>\n        <td>";
        echo $row["date"];
        echo "</td>\n        <td>";
        echo $row["notes"];
        echo "</td>\n        <td><a href=\"javascript: location.href='main2.php?page=pos.stock.transist&wid=";
        echo $wid;
        echo "&accept=";
        echo $row["id"];
        echo "'\">Accept</a></td>\n    </tr>\n";
    }
}
echo "</tbody></table>\n</form></div></div> \n";
$fileverioncheck = "6.1.0";

?>