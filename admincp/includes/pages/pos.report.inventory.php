<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<ul id=\"tabmenu\">\n    <li><a class=\"tabmenu_active\" href=\"#\">Inventory Report</a></li>\n</ul>\n";
$pageid = 491;
checkPagePermission($pageid);
licince\reqaddon("POS");
if (!$wid) {
    $w = mysqli_fetch_assoc(dquery("select mywarehouse from tbl_admin where id='" . $_SESSION["adminid"] . "'"));
    $wid = $w["mywarehouse"];
}
echo "\n<table class=\"form\">\n    <tr>\n        <td align=\"left\" class=\"fieldlabel\">\n";
echo $LNG["warehouse"];
echo " : \n<select name=\"warehouse\"  \nonchange=\"javascript: location.href='main2.php?page=pos.report.inventory&wid='+this.value\">\n";
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
echo "</select>\n        </td>\n        <td align=\"right\" class=\"fieldlabel\">\n            <form method=\"post\" style=\"float: right;\"> ";
echo $LNG["search"];
echo " ";
echo $LNG["product"];
echo " <input type=\"text\" name=\"search\" /> <input class=\"addFromgallery\" type=\"submit\" name=\"find\" value=\"";
echo $LNG["search"];
echo "\" /></form>\n        </td>       \n    </tr>\n</table> \n        \n\n\n\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<form id=\"replied\" name=\"replied\" method=\"post\" > \n";
echo generate_token("form");
echo "<table id=\"main_tbl\" >\n<thead>\n  <tr>\n        <th>";
echo $LNG["id"];
echo "</th>\n        <th>";
echo $LNG["item"];
echo " </th>\n        <th>";
echo $LNG["purchase"];
echo " ";
echo $LNG["cost"];
echo "</th>\n        <th>";
echo $LNG["selling"];
echo " ";
echo $LNG["cost"];
echo "</th>\n        <th>";
echo $LNG["current"];
echo " ";
echo $LNG["stock"];
echo "</th>\n        <th>";
echo $LNG["reorder"];
echo " </th>\n        <th>";
echo $LNG["supplier"];
echo " </th>\n  </tr>\n</thead> \n<tbody>  \n";
if ($find && $search) {
    $WHERE = " WHERE service_name LIKE '" . $search . "%' ";
} else {
    $WHERE = "";
}
$sql = dquery("SELECT id,service_name,stock,purchase_cost ,credit, reorder_level from\ntbl_products " . $WHERE . " order by id");
while ($row = mysqli_fetch_assoc($sql)) {
    $buff = "";
    $s = dquery("select username,id from tbl_supplier \n    where id=(select sid from tbl_stock_history where\n    pid='" . $row["id"] . "' LIMIT 1)");
    if (mysqli_num_rows($s)) {
        while ($r = mysqli_fetch_assoc($s)) {
            $buff .= " " . $r["username"];
        }
    }
    $buff = trim($buff, "|");
    $stock = mysqli_fetch_assoc(dquery("select sum(stockin) as stin,sum(stockout) as stout \n    from tbl_warehousestock where pid='" . $row["id"] . "' and wid='" . $wid . "'"));
    $row["stock"] = $stock["stin"] - $stock["stout"];
    $cstock = mysqli_num_rows(dquery("select *,(select name from tbl_warehouse where id=wid)\nas warehouse ,(select username from tbl_admin where id=aid) as admin\nfrom tbl_serial_list where pid='" . $row["id"] . "' and transist='' \n and wid='" . $wid . "' and status=0"));
    echo "    <tr>\n        <td>";
    echo $row["id"];
    echo "</td>\n        <td>";
    echo " " . $row["service_name"];
    echo "</td>\n        <td>";
    echo round($row["purchase_cost"], 2);
    echo "</td>\n        <td>";
    echo round($row["credit"], 2);
    echo "</td>\n        <td>";
    echo $cstock;
    echo "</td>\n        <td>";
    echo $row["reorder_level"];
    echo "</td>\n        <td>";
    echo $buff;
    echo "</td>\n    </tr>\n";
}
echo "</tbody></table>\n</form></div></div> \n";
$fileverioncheck = "6.1.0";

?>