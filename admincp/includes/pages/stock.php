<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<script type=\"text/javascript\" src=\"includes/js/highcharts.js\"></script>\n<!--[if IE]><script type=\"text/javascript\" src=\"includes/js/excanvas.compiled.js\"></script><![endif]-->\n<style>\n    #tabmenu{border-radius:0}\n</style>\n";
if (!$s) {
    echo "<ul id=\"tabmenu\"> \n<li><a class='tabmenu_active' onclick=\"getContect('#tab2','main2.php?page=stock&s=ok','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
    echo $LNG["stock"];
    echo "</a></li>\n<li><a onclick=\"getContect('#tab','main2.php?page=stockproduct.detail&s=ok','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
    echo $LNG["sold"];
    echo " ";
    echo $LNG["stock"];
    echo "</a></li> \n<li><a onclick=\"getContect('#tab1','main2.php?page=stockproduct.order','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
    echo $LNG["stock"];
    echo " ";
    echo $LNG["order"];
    echo "</a></li> \n   <div style=\"clear: both;\"></div>\n</ul>\n<br />\n<div id=\"tabcontent\">\n";
}
if ($delete && $ids) {
    checkDemoMode(false);
    foreach ($ids as $rid) {
        $dets = mysqli_fetch_assoc(dquery("select * from tbl_serial_list\n    where id='" . $rid . "'"));
        dquery("delete from tbl_serial_list \nwhere id='" . $rid . "'");
        $data = NULL;
        $data["qnt"] = 1;
        $data["wid"] = $dets["wid"];
        $data["pid"] = $dets["pid"];
        $data["date"] = date("Y-m-d");
        $data["time"] = time();
        $data["note"] = "Rebated By Admin";
        $data["status"] = "OUT";
        $data["remove"] = 1;
        $data["aid"] = $_SESSION["adminid"];
        if ($db->insert("tbl_stock_history", $data)) {
            $ins["wid"] = $dets["wid"];
            $ins["pid"] = $dets["pid"];
            $ins["stockout"] = 1;
            $db->insert("tbl_warehousestock", $ins);
            dquery("update tbl_products set stock=stock-1\n             where id='" . $dets["pid"] . "'");
        }
    }
}
$acc = mysqli_fetch_assoc(dquery("select access from tbl_admin_access_group\nwhere id=(select group_id from tbl_admin where id='" . $_SESSION["adminid"] . "')"));
$perms = explode(",", $acc["access"]);
echo "<form method=\"post\" onsubmit=\"return confirm('Are you sure want to remove ?');\" >\n<table id=\"main_tbl\" style=\"display: table;\">\n<thead><tr>\n<th style=\"width:10%;\">Serial No</th>\n<th style=\"width:10%;\">Date</th>\n<th style=\"width:10%;\">Added By</th>\n<th style=\"width:10%;\">";
echo $LNG["warehouse"];
echo "</th>\n \n</tr></thead>\n<tbody>\n";
$total = 0;
$gresult = dquery("select *,(select name from tbl_warehouse where id=wid)\nas warehouse ,(select username from tbl_admin where id=aid) as admin\nfrom tbl_serial_list where pid='" . $id . "' and transist='' and refund=0 \nand status=0");
while ($row = mysqli_fetch_assoc($gresult)) {
    $total++;
    echo " <tr>\n <td>\n  ";
    if (in_array(524, $perms)) {
        echo "      <input type=\"checkbox\" name=\"ids[";
        echo $row["id"];
        echo "]\" \n      value=\"";
        echo $row["id"];
        echo "\" />\n      ";
    }
    echo "  ";
    echo $row["serial"];
    echo "</td>\n  <td>";
    echo $row["date"];
    echo "</td>\n  <td>";
    echo $row["admin"];
    echo "</td>\n  <td>";
    echo $row["warehouse"];
    echo "</td>\n </tr>         \n";
}
echo "</tbody>\n<tfoot>\n<tr>\n<th colspan=\"4\"></th>\n</tr>\n<tr>\n<th colspan=\"4\" style=\"text-align: left !important;\" >";
echo $LNG["total"];
echo ": ";
echo $total;
echo "</th>\n</tr>\n</tfoot>\n</table>\n";
if (in_array(524, $perms)) {
    echo "<br />\n<input type=\"submit\" name=\"delete\" value=\"Remove\" />\n";
}
echo "</form>\n<br /><br /><br />\n\n";
if (mysqli_num_rows(dquery("select *,(select name from tbl_warehouse where id=wid)\nas warehouse \nfrom tbl_serial_list where pid='" . $id . "' and transist!=''"))) {
    echo "<h3>In-Transist Goods</h3>\n<table id=\"main_tbl\" >\n<thead><tr>\n<th style=\"width:10%;\">Serial No</th>\n<th style=\"width:10%;\">";
    echo $LNG["warehouse"];
    echo "</th>\n<th style=\"width:10%;\">Transfer Date</th>\n<th style=\"width:10%;\">Apx. Delivery</th>\n<th style=\"width:10%;\">Note</th>\n</tr></thead>\n<tbody>\n";
    $total = 0;
    $gresult = dquery("select *,(select name from tbl_warehouse where id=wid)\nas warehouse \nfrom tbl_serial_list where pid='" . $id . "' and transist!=''");
    while ($row = mysqli_fetch_assoc($gresult)) {
        $ware = mysqli_fetch_assoc(dquery("select * from tbl_warehousestock\n    where time='" . $row["transist"] . "'"));
        $total++;
        echo " <tr>\n <td>";
        echo $row["serial"];
        echo "</td>\n <td>";
        echo $row["warehouse"];
        echo "</td>\n <td>";
        echo $ware["date"];
        echo "</td>\n <td>";
        echo date("Y-m-d", $ware["time"]);
        echo "</td>\n <td>";
        echo $ware["notes"];
        echo "</td>\n </tr>         \n";
    }
    echo "</tbody>\n<tfoot>\n<tr>\n<th colspan=\"5\" ></th>\n</tr>\n<tr>\n<th colspan=\"5\" style=\"text-align: left !important;\" >\n";
    echo $LNG["total"];
    echo ": ";
    echo $total;
    echo "</th>\n</tr>\n</tfoot>\n</table>\n\n";
}
if (mysqli_num_rows(dquery("select *,(select name from tbl_warehouse where id=wid)\nas warehouse \nfrom tbl_serial_list where pid='" . $id . "' and refund='1' and status=0"))) {
    echo "<h3>Refunded Goods</h3>\n<table id=\"main_tbl\" >\n<thead><tr>\n<th style=\"width:10%;\">Serial No</th>\n<th style=\"width:10%;\">";
    echo $LNG["warehouse"];
    echo "</th>\n<th style=\"width:10%;\">Note</th>\n</tr></thead>\n<tbody>\n";
    $total = 0;
    $gresult = dquery("select *,(select name from tbl_warehouse where id=wid)\nas warehouse \nfrom tbl_serial_list where pid='" . $id . "' and status=0 and refund=1");
    while ($row = mysqli_fetch_assoc($gresult)) {
        $total++;
        echo " <tr>\n <td>";
        echo $row["serial"];
        echo "</td>\n <td>";
        echo $row["warehouse"];
        echo "</td>\n <td>";
        echo $ware["notes"];
        echo "</td>\n </tr>         \n";
    }
    echo "</tbody>\n<tfoot>\n<tr>\n<th colspan=\"5\" ></th>\n</tr>\n<tr>\n<th colspan=\"5\" style=\"text-align: left !important;\" >\n";
    echo $LNG["total"];
    echo ": ";
    echo $total;
    echo "</th>\n</tr>\n</tfoot>\n</table>\n<br /><br />\n";
}
if (!$s) {
    echo "</div>\n";
}
$fileverioncheck = "6.1.0";

?>