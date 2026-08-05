<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 101;
checkPagePermission($pageid);
if ($clearmonth) {
    if ($month == "ALL") {
        $time = time();
    } else {
        $time = strtotime(date("Y-m-d") . " -" . $month . " month");
    }
    if ($table) {
        foreach ($table as $t => $v) {
            if ($t == "tbl_invoices") {
                $date = date("Y-m-d", $time);
                $q = dquery("select id from tbl_invoices where date<'" . $date . "'");
                while ($r = mysqli_fetch_assoc($q)) {
                    dquery("delete from tbl_invoiceitems where invoiceid='" . $r["id"] . "'");
                    dquery("delete from tbl_invoices where id='" . $r["id"] . "'");
                }
            } else {
                if ($t == "tblUsers") {
                    dquery("DELETE FROM `" . $t . "`");
                } else {
                    if ($t == "tbl_services_imei") {
                        dquery("DELETE FROM `" . $t . "`");
                        dquery("DELETE FROM `tbl_imei_group`");
                        dquery("DELETE FROM `tbl_order_imei`");
                    } else {
                        if ($t == "tbl_services_file") {
                            dquery("DELETE FROM `" . $t . "`");
                            dquery("DELETE FROM `tbl_file_group`");
                            dquery("DELETE FROM `tbl_order_file`");
                        } else {
                            if ($t == "tbl_server_log") {
                                dquery("DELETE FROM `" . $t . "`");
                                dquery("DELETE FROM `tbl_server_group`");
                                dquery("DELETE FROM `tbl_order_server`");
                            } else {
                                if ($t == "tbl_products") {
                                    dquery("DELETE FROM `" . $t . "`");
                                    dquery("DELETE FROM `tbl_product_group`");
                                    dquery("DELETE FROM `tbl_order_product`");
                                } else {
                                    dquery("DELETE FROM `" . $t . "` WHERE time<" . $time);
                                }
                            }
                        }
                    }
                }
            }
        }
        echo "<div id='notification1' class='successbox'>Data cleared successfully</div>";
    }
}
echo "<script>\nfunction checkvalid()\n{\n    return confirm(\"Are you sure want to clear data?\");\n}\n</script>\n<div id=\"notification\"></div> \n<div id=\"content\">\n<div id=\"content_padded\">\n<div id=\"notification1\" class=\"info\">* Be careful to use this once fully deleted and can't be restored.</div>\n<form id=\"frmcleanup\" name=\"\" method=\"post\" onsubmit=\"return checkvalid();\">\n<input type=\"hidden\" name=\"loaddefaultpage\" value=\"cleardata.php\" />\n";
echo generate_token("form");
echo "<table id=\"main_tbl\">\n<thead>\n<tr>\n<th>&nbsp;</th><th>";
echo $LNG["tablename"];
echo "</th>\n<th>\n<div align=\"center\">";
echo $LNG["rows"];
echo "</div></th>\n<th><div align=\"right\">";
echo $LNG["size"];
echo " [MB]</div></th>\n</tr>\n</thead>\n<tbody> \n";
$database = mysqli_fetch_assoc(dquery("SELECT database() as db"));
if ($OnlyEcommerce) {
    $table = ["tbl_order_product", "tbl_statement_user", "tbl_statement_supplier", "tbl_invoices", "tblUsers", "tbl_products"];
} else {
    $table = ["tbl_order_imei", "tbl_order_file", "tbl_order_server", "tbl_order_product", "tbl_statement_user", "tbl_statement_supplier", "tbl_invoices", "tblUsers", "tbl_services_imei", "tbl_services_file", "tbl_server_log", "tbl_products"];
}
foreach ($table as $value) {
    $result = dquery("SHOW TABLE STATUS FROM " . $database["db"] . " \n    where name='" . $value . "'");
    $row = mysqli_fetch_assoc($result);
    $size = round($row["Data_length"] / 1048576, 3);
    echo "<tr><td><input type=checkbox value=1 name=table[" . $value . "]/>\n     </td><td>" . $value;
    if ($value == "tbl_order_imei") {
        echo "<br /><small>delete all IMEI service orders</small>";
    }
    if ($value == "tbl_order_file") {
        echo "<br /><small>delete all file service orders</small>";
    }
    if ($value == "tbl_order_server") {
        echo "<br /><small>delete all server service orders</small>";
    }
    if ($value == "tbl_statement_user") {
        echo "<br /><small>delete user's CR/DR statement</small>";
    }
    if ($value == "tbl_invoices") {
        echo "<br /><small> this will destroy all your accounting include all unpaid invoices</small>";
    }
    if ($value == "tbl_services_imei") {
        echo "<br /><small>delete imei services and all imei service orders  </small>";
    }
    if ($value == "tbl_services_file") {
        echo "<br /><small>delete file services and all file service orders  </small>";
    }
    if ($value == "tbl_server_log") {
        echo "<br /><small>delete server services and all server service orders  </small>";
    }
    if ($value == "tbl_products") {
        echo "<br /><small>delete products  and all products orders  </small>";
    }
    if ($value == "tblUsers") {
        echo "<br /><small>delete all users </small>";
    }
    echo "</td>\n    <td align=center>" . $row["Rows"] . "</td><td align=right>" . $size . "</td></tr>";
}
echo "</tbody></table>\n\n<img width=\"38\" height=\"22\" title=\"\" alt=\"With selected\" src=\"includes/3rdparty/datagrid/styles/default/images/arrow_ltr.png\" style=\"padding:0px; margin:0px 0 0 5px; border:0px;\">\n\n \n<select name=\"month\">\n    <option value=\"\"> Keep Data of Last Months</option>\n    ";
for ($i = 1; $i <= 12; $i++) {
    echo "<option value=\"";
    echo $i;
    echo "\">";
    echo $i;
    echo "</option>";
}
echo "    <option value=\"ALL\">ALL</option>\n</select>  \n \n<input type=\"submit\" name=\"clearmonth\" value=\"Clear Data\" />\n \n \n</form></div></div> ";
$fileverioncheck = "6.1.0";

?>