<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\r\n.form td a{text-decoration:none; display: block;}\r\n.form td a:hover{text-decoration:underline;}\r\n.fieldarea{text-align: center;}\r\ntable tr td{text-align: left;}\r\ntable tr:hover td{background: #f4f4f4;}\r\n.default_dg_table tr td, #main_tbl tr td{width:  auto !important;min-width: 30px;}\r\n</style>\r\n";
$pageid = 411;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/clients.fun.inc.php";
include_once DATAGRID_DIR . "comm.php";
echo "<div id=\"notification\"></div>\r\n<div id=\"content\">\r\n<div id=\"\">\r\n";
$month = ["01" => "January", "02" => "February", "03" => "March", "04" => "April", "05" => "May", "06" => "June", "07" => "July", "08" => "Augest", "09" => "September", "10" => "Octomber", "11" => "November", "12" => "December"];
foreach ($month as $k => $v) {
    if (date("m") < $k) {
        unset($month[$k]);
    }
}
if (!$year) {
    $year = date("Y");
}
if ($OnlyEcommerce) {
    $table = ["tbl_order_product"];
    $table_service = ["tbl_products"];
} else {
    if ($IsFileOnly) {
        $table = ["tbl_order_file"];
        $table_service = ["tbl_services_file"];
    } else {
        $table = ["tbl_order_imei", "tbl_order_file", "tbl_order_server", "tbl_order_product"];
        $table_service = ["tbl_services_imei", "tbl_services_file", "tbl_server_log", "tbl_products"];
    }
}
if (!$id) {
    $id = date("m");
}
$startcurrentmonth = mktime(0, 0, 0, $id, 1, $year);
$endcurrentmonth = mktime(0, 0, 0, $id, date("t", mktime(0, 0, 0, $id, 1, $year)), $year);
$startcurrentyear = mktime(0, 0, 0, 1, 1, $year);
$whereuser = "ac_create_dt>='" . $startcurrentmonth . "' AND '" . $endcurrentmonth . "'";
$whereorder = "time BETWEEN '" . $startcurrentmonth . "' AND '" . $endcurrentmonth . "'";
$whereincome = "time BETWEEN '" . $startcurrentmonth . "' AND '" . $endcurrentmonth . "'";
$whereinvoice = "time BETWEEN '" . $startcurrentmonth . "' AND '" . $endcurrentmonth . "'";
$wherefund = "time BETWEEN '" . $startcurrentmonth . "' AND '" . $endcurrentmonth . "'";
foreach ($table as $tbl) {
    $whers = "";
    if ($tbl == "tbl_order_imei") {
        $whers = " and `server`=0";
        $ptable = $tbl;
    } else {
        if ($tbl == "tbl_order_server") {
            $whers = " and `server`=1";
            $ptable = "tbl_order_imei";
        } else {
            $ptable = $tbl;
        }
    }
    $result = dquery("select count(*) as total,user_can_c  from " . $ptable . " where  " . $whereorder . " " . $whers . " group by user_can_c");
    while ($ord = mysqli_fetch_assoc($result)) {
        if (!$ord["total"]) {
            $order[$tbl][$ord["user_can_c"]] = "<span class=textwhite bold>" . $ord["total"] . "</label>";
        } else {
            $order[$tbl][$ord["user_can_c"]] = $ord["total"];
        }
    }
}
$result = dquery("select count(*) as total,userstatus from tblUsers where " . $whereuser . " group by userstatus");
while ($row = mysqli_fetch_assoc($result)) {
    $user[$row["userstatus"]] = $row["total"];
}
$active = 0;
$inactive = 0;
if ($user) {
    foreach ($user as $key => $value) {
        if ($key == "0") {
            $active = $value;
        } else {
            if ($key == "1" || $key == "2") {
                $inactive += $value;
            }
        }
    }
}
$registered = mysqli_fetch_assoc(dquery("select count(*) as total from tblUsers where " . $whereuser));
$is_registered = $registered["total"];
$defaultcurrency = mysqli_fetch_assoc(dquery("SELECT id from `tbl_currencies` where `default`='1'"));
foreach ($table as $tbl) {
    $result = dquery("select sum(credit-discount) as income,currency_id from " . $tbl . " where " . $whereincome . " and user_can_c='4' group by currency_id");
    $ctotal = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $income[$row["currency_id"]] += $row["income"];
    }
}
$query = "select sum(total) as unpaid_total,count(*) as unpaid_rows,default_currency FROM `tbl_invoices`,tblUsers WHERE status = 'Unpaid' and total>0 and `tbl_invoices`.userid=tblUsers.id and " . $whereinvoice . " group by default_currency";
$result = dquery($query);
while ($rowin = mysqli_fetch_assoc($result)) {
    $unpaidm[$rowin["default_currency"]] = $rowin["unpaid_rows"] . "(" . $rowin["unpaid_total"] . ")";
}
$query = "select sum(total) as unpaid_total,count(*) as unpaid_rows,\r\ndefault_currency FROM `tbl_invoices`,tblUsers WHERE status = 'Unpaid' \r\nand total>0 and `tbl_invoices`.userid=tblUsers.id and adminid!='' and " . $whereinvoice . " \r\ngroup by default_currency";
$result = dquery($query);
while ($rowin = mysqli_fetch_assoc($result)) {
    $unpaidma[$rowin["default_currency"]] = $rowin["unpaid_rows"] . "(" . $rowin["unpaid_total"] . ")";
}
$query = "select sum(total) as unpaid_total,count(*) as unpaid_rows,\r\ndefault_currency FROM `tbl_invoices`,tblUsers WHERE status = 'Unpaid' \r\nand total>0 and `tbl_invoices`.userid=tblUsers.id and adminid='' and " . $whereinvoice . " \r\ngroup by default_currency";
$result = dquery($query);
while ($rowin = mysqli_fetch_assoc($result)) {
    $unpaidmu[$rowin["default_currency"]] = $rowin["unpaid_rows"] . "(" . $rowin["unpaid_total"] . ")";
}
echo "<div class=\"floatleft\" style=\"width: 40%;\">\r\n<fieldset><legend style=\"border: none;padding:0\">\r\n<select name=\"selectedMonth\" onchange=\"javascript:reloadcurrent('utilities.systemsummarymain&year=";
echo $year;
echo "',this.value)\">\r\n    ";
foreach ($month as $key => $value) {
    if ($id == $key) {
        echo "<option value=" . $key . " selected>" . $value;
    } else {
        echo "<option value=" . $key . ">" . $value;
    }
    if ($key == date("m")) {
        echo " (" . $LNG["current"] . ")";
    }
    echo "</option>";
}
echo "</select>\r\n</legend>\r\n\r\n\r\n<table border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\" id=\"main_tbl\">\r\n<tr style=\"\">\r\n<td style=\"border-bottom: 1px solid #ccc;\"><h2>";
echo $LNG["orders"];
echo "        <span>(";
echo $month[$id] . "-" . $year;
echo ")</span></h2></td>\r\n";
if ($OnlyEcommerce) {
    echo "    <td width=\"15%\"  style=\"border-bottom:solid 2px  #a4cc8a;text-align: center !important;\">";
    echo $LNG["product"];
    echo "</td>\r\n    ";
} else {
    if (!$IsFileOnly) {
        echo "<td width=\"15%\" style=\"border-bottom:solid 2px #f0aa65;text-align: center;\">";
        echo $LNG["imei"];
        echo "</td>\r\n";
    }
    echo "<td width=\"15%\"  style=\"border-bottom:solid 2px  #c4bfd9;text-align: center;\">";
    echo $LNG["file"];
    echo "</td>\r\n";
    if (!$IsFileOnly) {
        echo "<td width=\"15%\"  style=\"border-bottom:solid 2px  #90c0db;text-align: center;\">";
        echo $LNG["server"];
        echo "</td>\r\n<td width=\"15%\"  style=\"border-bottom:solid 2px  #a4cc8a;text-align: center !important;\">";
        echo $LNG["product"];
        echo "</td>\r\n";
    }
}
echo "</tr>\r\n\r\n<tr><td width=\"40%\">";
echo $LNG["completed"];
echo "</td>\r\n";
if ($OnlyEcommerce) {
    echo "    <td>";
    echo $order["tbl_order_product"][4];
    echo "</td>\r\n    ";
} else {
    if (!$IsFileOnly) {
        echo "<td>";
        echo $order["tbl_order_imei"][4];
        echo "</td>\r\n";
    }
    echo "<td>";
    echo $order["tbl_order_file"][4];
    echo "</td>\r\n";
    if (!$IsFileOnly) {
        echo "<td>";
        echo $order["tbl_order_server"][4];
        echo "</td>\r\n<td>";
        echo $order["tbl_order_product"][4];
        echo "</td>\r\n";
    }
}
echo "</tr>\r\n<tr><td>";
echo $LNG["in"];
echo " ";
echo $LNG["inprocess"];
echo "</td>\r\n";
if (!$IsFileOnly) {
    echo "<td>";
    echo $order["tbl_order_imei"][0] + $order["tbl_order_imei"][1];
    echo "</td>\r\n";
}
echo "<td>";
echo $order["tbl_order_file"][0] + $order["tbl_order_file"][1];
echo "</td>\r\n";
if (!$IsFileOnly) {
    echo "<td>";
    echo $order["tbl_order_server"][0] + $order["tbl_order_server"][1];
    echo "</td>\r\n<td>";
    echo $order["tbl_order_product"][0] + $order["tbl_order_product"][1];
    echo "</td>\r\n";
}
echo "</tr>\r\n<tr><td>";
echo $LNG["rejected"];
echo "</td>\r\n";
if ($OnlyEcommerce) {
    echo "\r\n<td>";
    echo $order["tbl_order_product"][3];
    echo "</td>\r\n   ";
} else {
    if (!$IsFileOnly) {
        echo "<td>";
        echo $order["tbl_order_imei"][3];
        echo "</td>\r\n";
    }
    echo "<td>";
    echo $order["tbl_order_file"][3];
    echo "</td>\r\n";
    if (!$IsFileOnly) {
        echo "<td>";
        echo $order["tbl_order_server"][3];
        echo "</td>\r\n<td>";
        echo $order["tbl_order_product"][3];
        echo "</td>\r\n";
    }
}
echo "</tr>\r\n</table>\r\n\r\n<br />\r\n<table border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\"  id=\"main_tbl\">\r\n<tr><td colspan=\"2\" style=\"text-align: left !important;border-bottom: 1px solid #ccc;\"><h2>";
echo $LNG["user"];
echo " <span>(";
echo $month[$id] . "-" . $year;
echo ")</span></h2></td></tr>\r\n<tr><td width=\"40%\">";
echo $LNG["active"];
echo "</td><td>";
echo $active;
echo "</td></tr>\r\n<tr><td>";
echo $LNG["inactive"];
echo "</td><td>";
echo $inactive;
echo "</td></tr>\r\n<tr><td>";
echo $LNG["new"];
echo " ";
echo $LNG["registered"];
echo "</td><td>";
echo $is_registered;
echo "</td></tr>\r\n</table>\r\n\r\n<br />\r\n<table border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\"  id=\"main_tbl\">\r\n<tr><td colspan=\"2\" style=\"text-align: left !important;border-bottom: 1px solid #ccc;\"><h2>";
echo $LNG["completed"];
echo " ";
echo $LNG["order"];
echo " ";
echo $LNG["credit"];
echo " ";
echo $LNG["used"];
echo " <span>(";
echo $month[$id] . "-" . $year;
echo ")</span></h2></td></tr>\r\n";
$result = dquery("select code,id from tbl_currencies");
while ($row2 = mysqli_fetch_assoc($result)) {
    echo "<tr><td width=\"40%\">";
    echo $row2["code"];
    echo "</td><td>";
    echo $income[$row2["id"]];
    echo "</td></tr>\r\n";
}
echo "</table>\r\n\r\n<br />\r\n<table  border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\" id=\"main_tbl\">\r\n<tbody>\r\n<tr><td colspan=\"2\" style=\"border-bottom: 1px solid #ccc;text-align: left !important;padding:7px\"><h2>";
echo $LNG["unpaid"];
echo " ";
echo $LNG["invoice"];
echo " <span>(";
echo $month[$id] . "-" . $year;
echo ")</span></h2></td></tr>\r\n<tr>\r\n\r\n<td style=\"width: 50%;\">\r\n<table border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\"  id=\"main_tbl\">\r\n<tdead>\r\n<tr><td>";
echo $LNG["_by"];
echo " ";
echo $LNG["user"];
echo "</td><td></td></tr>\r\n</tdead>\r\n<tbody>\r\n";
$result = dquery("select code,id from tbl_currencies");
while ($row2 = mysqli_fetch_assoc($result)) {
    echo "<tr><td width=\"40%\">";
    echo $row2["code"];
    echo "</td><td>";
    echo $unpaidmu[$row2["id"]];
    echo "</td></tr>\r\n";
}
echo "</tbody>\r\n</table>\r\n</td>\r\n\r\n<td style=\"width: 50%;\">\r\n<table border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\"  id=\"main_tbl\">\r\n<tdead>\r\n<tr><td>";
echo $LNG["_by"];
echo " ";
echo $LNG["admin"];
echo "</td><td></td></tr>\r\n</tdead>\r\n<tbody>\r\n";
$result = dquery("select code,id from tbl_currencies");
while ($row2 = mysqli_fetch_assoc($result)) {
    echo "<tr><td width=\"40%\" align=\"left\">";
    echo $row2["code"];
    echo "</td><td>";
    echo $unpaidma[$row2["id"]];
    echo "</td></tr>\r\n";
}
echo "</tbody>\r\n</table>\r\n</td>\r\n\r\n\r\n</tr>\r\n\r\n</tbody></table>\r\n\r\n<!--\r\n<table  border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\r\n<tbody>\r\n<tr><td colspan=\"2\" ><h2>";
echo $LNG["credit"];
echo " ";
echo $LNG["sold"];
echo " <span>(";
echo $month[$id] . "-" . $year;
echo ")</span></h2></td></tr>\r\n";
$result = dquery("select code,id from tbl_currencies");
while ($row2 = mysqli_fetch_assoc($result)) {
    echo "<tr><td width=\"40%\">";
    echo $row2["code"];
    echo "</td><td>";
    echo $sold[$row2["id"]] - $rebet[$row2["id"]];
    echo "</td></tr>\r\n";
}
echo "\r\n</tbody></table>\r\n-->\r\n\r\n\r\n</fieldset>\r\n</div>\r\n\r\n<div class=\"floatleft\" style=\"width: 40%;\">\r\n\r\n<fieldset style=\"padding: 7px 20px;\"><legend style=\"padding:4px 15px;\">";
echo $LNG["total"];
echo " </legend>\r\n\r\n";
if ($IsFileOnly) {
    $table = ["tbl_order_file"];
    $table_service = ["tbl_services_file"];
} else {
    $table = ["tbl_order_imei", "tbl_order_file", "tbl_order_server", "tbl_order_product"];
    $table_service = ["tbl_services_imei", "tbl_services_file", "tbl_server_log", "tbl_products"];
}
foreach ($table as $tbl) {
    $result = dquery("select count(*) as total,user_can_c  from " . $tbl . " group by user_can_c");
    while ($ord = mysqli_fetch_assoc($result)) {
        if (!$ord["total"]) {
            $order[$tbl][$ord["user_can_c"]] = "<span class=textwhite bold>" . $ord["total"] . "</label>";
        } else {
            $order[$tbl][$ord["user_can_c"]] = $ord["total"];
        }
    }
}
$result = dquery("select count(*) as total,userstatus from tblUsers group by userstatus");
while ($row = mysqli_fetch_assoc($result)) {
    $user[$row["userstatus"]] = $row["total"];
}
$active = 0;
$inactive = 0;
if ($user) {
    foreach ($user as $key => $value) {
        if ($key == "0") {
            $active = $value;
        } else {
            if ($key == "1" || $key == "2") {
                $inactive += $value;
            }
        }
    }
}
$registered = mysqli_fetch_assoc(dquery("select count(*) as total from tblUsers"));
$is_registered = $registered["total"];
foreach ($table as $tbl) {
    $whers = "";
    if ($tbl == "tbl_order_imei") {
        $whers = " and `server`=0";
        $ptable = $tbl;
    } else {
        if ($tbl == "tbl_order_server") {
            $whers = " and `server`=1";
            $ptable = "tbl_order_imei";
        } else {
            $ptable = $tbl;
        }
    }
    $result = dquery("select sum(credit-discount) as income,currency_id from " . $ptable . " where user_can_c='4' " . $whers . " group by currency_id");
    while ($row3 = mysqli_fetch_assoc($result)) {
        $income1[$row3["currency_id"]] += $row3["income"];
    }
}
$query = "select sum(total) as unpaid_total,count(*) as unpaid_rows,default_currency FROM `tbl_invoices`,tblUsers WHERE status = 'Unpaid'  and total>0 and `tbl_invoices`.userid=tblUsers.id and  `tbl_invoices`.adminid!='' group by default_currency";
$result = dquery($query);
while ($rowin = mysqli_fetch_assoc($result)) {
    $unpaid[$rowin["default_currency"]] = $rowin["unpaid_rows"] . "(" . $rowin["unpaid_total"] . ")";
}
$query = "select sum(total) as unpaid_total,count(*) as unpaid_rows,\r\ndefault_currency FROM `tbl_invoices`,tblUsers WHERE status = 'Unpaid'  \r\nand total>0 and `tbl_invoices`.userid=tblUsers.id and adminid=''  \r\ngroup by default_currency";
$result = dquery($query);
while ($rowin = mysqli_fetch_assoc($result)) {
    $unpaidu[$rowin["default_currency"]] = $rowin["unpaid_rows"] . "(" . $rowin["unpaid_total"] . ")";
}
$query = "select sum(total) as unpaid_total,count(*) as unpaid_rows,default_currency FROM\r\n `tbl_invoices`,tblUsers WHERE status = 'Unpaid' and adminid!=''  and total>0 and \r\n `tbl_invoices`.userid=tblUsers.id  group by default_currency";
$result = dquery($query);
while ($rowin = mysqli_fetch_assoc($result)) {
    $unpaida[$rowin["default_currency"]] = $rowin["unpaid_rows"] . "(" . $rowin["unpaid_total"] . ")";
}
echo "\r\n\r\n<table border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\"  id=\"main_tbl\">\r\n<tr style=\"\">\r\n<td style=\"border-bottom: 1px solid #ccc;\">\r\n<h2>";
echo $LNG["orders"];
echo " <span>(";
echo $LNG["total"];
echo ")</span></h2></td>\r\n";
if (!$IsFileOnly) {
    echo "<td width=\"15%\" style=\"border-bottom:solid 2px  #f0aa65;text-align: center;\">";
    echo $LNG["imei"];
    echo "</td>\r\n";
}
echo "<td width=\"15%\" style=\"border-bottom:solid 2px  #c4bfd9;text-align: center;\">";
echo $LNG["file"];
echo "</td>\r\n";
if (!$IsFileOnly) {
    echo "<td width=\"15%\" style=\"border-bottom:solid 2px  #90c0db;text-align: center;\">";
    echo $LNG["server"];
    echo "</td>\r\n<td width=\"15%\" style=\"border-bottom:solid 2px  #a4cc8a;text-align: center !important;\">";
    echo $LNG["product"];
    echo "</td>\r\n";
}
echo "</tr>\r\n<tr><td width=\"40%\">";
echo $LNG["completed"];
echo " </td>\r\n";
if (!$IsFileOnly) {
    echo "<td style=\"text-align: center;\"><a href=\"javascript:load_fromsubpage('imeiorder.history&id=4','IMEI Completed Orders History');\">";
    echo $order["tbl_order_imei"][4];
    echo "</a></td>\r\n";
}
echo "<td  style=\"text-align: center;\"><a href=\"javascript:load_fromsubpage('fileorder.history&id=4','File Completed Orders History');\" >";
echo $order["tbl_order_file"][4];
echo "</a></td>\r\n";
if (!$IsFileOnly) {
    echo "<td><a href=\"javascript:load_fromsubpage('serverorder.history&id=4','Server Completed Orders History');\">";
    echo $order["tbl_order_server"][4];
    echo " </a></td>\r\n<td><a href=\"javascript:load_fromsubpage('productorder.history&id=4','Product Completed Orders History');\">";
    echo $order["tbl_order_product"][4];
    echo "</a></td>\r\n";
}
echo "</tr>\r\n<tr>\r\n<td>";
echo $LNG["in"];
echo " ";
echo $LNG["inprocess"];
echo "</td>\r\n";
if (!$IsFileOnly) {
    echo "<td><a href=\"javascript:load_fromsubpage('imeiorder.history&id=01','IMEI Inprocess Orders History');\">";
    echo $order["tbl_order_imei"][0] + $order["tbl_order_imei"][1];
    echo "</a></td>\r\n";
}
echo "<td><a href=\"javascript:load_fromsubpage('fileorder.history&id=01','File Inprocess Orders History');\">";
echo $order["tbl_order_file"][0] + $order["tbl_order_file"][1];
echo "</a></td>\r\n";
if (!$IsFileOnly) {
    echo "<td><a href=\"javascript:load_fromsubpage('serverorder.history&id=01','Server Inprocess Orders History');\">";
    echo $order["tbl_order_server"][0] + $order["tbl_order_server"][1];
    echo "</a></td>\r\n<td><a href=\"javascript:load_fromsubpage('productorder.history&id=01','Product Inprocess Orders History');\">";
    echo $order["tbl_order_product"][0] + $order["tbl_order_product"][1];
    echo "</a></td>\r\n";
}
echo "</tr>\r\n\r\n<tr>\r\n<td>";
echo $LNG["rejected"];
echo "</td>\r\n";
if (!$IsFileOnly) {
    echo "<td><a href=\"javascript:load_fromsubpage('imeiorder.history&id=3','IMEI Rejected Orders History');\">";
    echo $order["tbl_order_imei"][3];
    echo "</a></td>\r\n";
}
echo "<td><a href=\"javascript:load_fromsubpage('fileorder.history&id=3','File Rejected Orders History');\">";
echo $order["tbl_order_file"][3];
echo "</a></td>\r\n";
if (!$IsFileOnly) {
    echo "<td><a href=\"javascript:load_fromsubpage('serverorder.history&id=3','Server Rejected Orders History');\">";
    echo $order["tbl_order_server"][3];
    echo "</a></td>\r\n<td><a href=\"javascript:load_fromsubpage('productorder.history&id=3','Product Rejected Orders History');\">";
    echo $order["tbl_order_product"][3];
    echo "</a></td>\r\n";
}
echo "</tr>\r\n</table>\r\n\r\n<br />\r\n<table border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\"  id=\"main_tbl\">\r\n<tr><td colspan=\"2\" style=\"border-bottom: 1px solid #ccc;\"><h2>";
echo $LNG["user"];
echo " <span>(";
echo $LNG["total"];
echo ")</span></h2></td><td align=\"right\" width=\"10%\" style=\"border-bottom: 1px solid #ccc;\"><a onclick=\"javascript:load_fromsubpage('clientlist','Clients');\" style=\"font-size: 11px;color:#888\">";
echo $LNG["view"];
echo "</a></td></tr>\r\n<tr><td width=\"40%\">";
echo $LNG["active"];
echo "</td><td>";
echo $active;
echo "</td><td align=\"right\"><a onclick=\"javascript:load_fromsubpage('clientlist&id=active','Active Clients');\" style=\"font-size: 11px;color:#888\">";
echo $LNG["view"];
echo "</a></td></tr>\r\n<tr><td>";
echo $LNG["inactive"];
echo " / ";
echo $LNG["blocked"];
echo "</td><td>";
echo $inactive;
echo "</td><td align=\"right\"><a onclick=\"javascript:load_fromsubpage('clientlist&id=inactive','Inactive Clients');\" style=\"font-size: 11px;color:#888\">";
echo $LNG["view"];
echo "</a></td></tr>\r\n<tr><td>";
echo $LNG["total"];
echo " ";
echo $LNG["registered"];
echo "</td><td>";
echo $is_registered;
echo "</td><td align=\"right\"><a onclick=\"javascript:load_fromsubpage('clientlist','Total Registered');\" style=\"font-size: 11px;color:#888\">";
echo $LNG["view"];
echo "</a></td></tr>\r\n</table>\r\n\r\n<br />\r\n<table border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\"  id=\"main_tbl\">\r\n<tr><td colspan=\"2\" style=\"text-align: left !important;border-bottom: 1px solid #ccc;\"><h2>";
echo $LNG["completed"];
echo " ";
echo $LNG["order"];
echo " ";
echo $LNG["credit"];
echo " ";
echo $LNG["used"];
echo " <span>(";
echo $LNG["total"];
echo ")</span></h2></td></tr>\r\n";
$result = dquery("select code,id from tbl_currencies");
while ($row2 = mysqli_fetch_assoc($result)) {
    echo "<tr>\r\n<td width=\"40%\">";
    echo $row2["code"];
    echo " </td>\r\n<td>";
    echo $income1[$row2["id"]];
    echo "</td>\r\n</tr>\r\n";
}
echo "</table>\r\n\r\n<br />\r\n<table border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\"  id=\"main_tbl\">\r\n<tbody>\r\n<tr><td style=\"border-bottom: 1px solid #ccc;\"><h2>";
echo $LNG["unpaid"];
echo " ";
echo $LNG["invoice"];
echo "<span>(";
echo $LNG["total"];
echo ")</span></h2>\r\n</td><td align=\"right\" style=\"color: #888;font-size:11px;border-bottom: 1px solid #ccc;\" width=\"10%\">\r\n<a onclick=\"javascript:load_fromsubpage('unpaidinvoice','Unpaid Invoice By Clients');\">";
echo $LNG["view"];
echo "</a></td></tr>\r\n<tr>\r\n<td style=\"width: 50%;\">\r\n<table border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\"  id=\"main_tbl\">\r\n<tdead>\r\n<tr><td colspan=\"2\">";
echo $LNG["_by"];
echo " ";
echo $LNG["user"];
echo "</td><td></td></tr>\r\n</tdead>\r\n<tbody>\r\n";
$result = dquery("select code,id from tbl_currencies");
while ($row2 = mysqli_fetch_assoc($result)) {
    echo "<tr>\r\n<td width=\"40%\">";
    echo $row2["code"];
    echo "</td>\r\n<td>";
    echo $unpaidu[$row2["id"]];
    echo "</td>\r\n<td style=\"text-align: right;\"><a\r\nonclick=\"javascript:load_fromsubpage('unpaidinvoice&id=";
    echo $row2["id"];
    echo "','Unpaid Invoice By Clients');\" style=\"font-size: 11px;color:#888\">";
    echo $LNG["view"];
    echo "</a>\r\n</td></tr>\r\n";
}
echo "</tbody>\r\n</table>\r\n</td>\r\n<td style=\"width: 50%;\">\r\n<table border=\"0\" cellpadding=\"3\"\r\n cellspacing=\"2\" width=\"100%\" id=\"main_tbl\">\r\n<tdead>\r\n<tr><td colspan=\"2\" align=\"left\">";
echo $LNG["_by"];
echo " ";
echo $LNG["admin"];
echo "</td><td></td></tr>\r\n</tdead>\r\n<tbody>\r\n";
$result = dquery("select code,id from tbl_currencies");
while ($row2 = mysqli_fetch_assoc($result)) {
    echo "<tr><td width=\"40%\">\r\n";
    echo $row2["code"];
    echo "</td><td>";
    echo $unpaida[$row2["id"]];
    echo "</td>\r\n<td align=\"right\">\r\n<a onclick=\"javascript:load_fromsubpage('unpaidinvoice&id=";
    echo $row2["id"];
    echo "&bywhom=Admin','Unpaid Invoice By Admin');\" style=\"font-size: 11px;color:#888\">";
    echo $LNG["view"];
    echo "</a></td></tr>\r\n";
}
echo "</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n\r\n</tbody></table>\r\n<!--\r\n\r\n<table  border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\r\n<tbody>\r\n<tr><td colspan=\"2\" ><h2>";
echo $LNG["credit"];
echo " ";
echo $LNG["sold"];
echo " <span>(";
echo $LNG["total"];
echo ")</span></h2></td></tr>\r\n";
$result = dquery("select code,id from tbl_currencies");
while ($row2 = mysqli_fetch_assoc($result)) {
    echo "<tr><td width=\"40%\">";
    echo $row2["code"];
    echo "</td><td>";
    echo $sold[$row2["id"]] - $rebet[$row2["id"]];
    echo "</td></tr>\r\n";
}
echo "\r\n</tbody></table>\r\n-->\r\n</fieldset>\r\n</div>\r\n\r\n\r\n</div>\r\n</div>";
$fileverioncheck = "6.1.0";

?>