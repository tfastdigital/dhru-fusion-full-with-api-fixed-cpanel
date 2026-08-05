<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n";
if (isset($save)) {
    checkDemoMode(false);
    if ($_FILES["prod"]["error"] <= 0) {
        $row = 0;
        $skip = 0;
        $arr = [];
        if (($handle = fopen($_FILES["prod"]["tmp_name"], "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $check = mysqli_num_rows(dquery("select * from tbl_products where service_name='" . $data[0] . "'"));
                if ($check == 0) {
                    $row++;
                    if ($data[1]) {
                        $grpid = dquery("select id from tbl_product_group where group_name='" . $data[1] . "'");
                        if (mysqli_num_rows($grpid)) {
                            $grpid = mysqli_fetch_assoc($grpid);
                        } else {
                            $gr["group_name"] = $data[1];
                            $gr["active"] = 1;
                            $grpid["id"] = $db->insert("tbl_product_group", $gr);
                            $gr = NULL;
                        }
                        $ins["group_id"] = $grpid["id"];
                    } else {
                        $grpid = dquery("select id from tbl_product_group where group_name='Uncategorised'");
                        if (mysqli_num_rows($grpid)) {
                            $grpid = mysqli_fetch_assoc($grpid);
                        } else {
                            $gr["group_name"] = "Uncategorised";
                            $gr["active"] = 1;
                            $grpid["id"] = $db->insert("tbl_product_group", $gr);
                            $gr = NULL;
                        }
                        $ins["group_id"] = $grpid["id"];
                    }
                    list($ins["service_name"], $ins["credit"], $ins["time"], $ins["stock"]) = $data;
                    $ins["active"] = 1;
                    $id = $db->insert("tbl_products", $ins);
                    $ins = NULL;
                    $arr[] = $id;
                } else {
                    $skip++;
                }
            }
            fclose($handle);
        }
        echo "<div id='notification1' class='successbox'>" . $row . " Product inserted successfully<br />\n           " . $skip . " Product skipped</div>";
    } else {
        echo "<div id='notification1' class='errorbox'>Error in file upload</div>";
    }
}
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\" enctype=\"multipart/form-data\">\n<input type=\"hidden\" name=\"defaultloadpage\" value=\"product.bulkadd.php\" />\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\" width=\"30%\">";
echo $LNG["upload"];
echo " ";
echo $LNG["file"];
echo " </td>\n    <td class=\"fieldarea\">\n    <input type=\"file\" name=\"prod\" />\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\" width=\"30%\">";
echo $LNG["file"];
echo " ";
echo $LNG["format"];
echo "</td>\n    <td class=\"fieldarea\">\n    <select name=\"type\">\n    <option value=\"1\">CSV</option>\n    </select>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\" width=\"30%\">&nbsp;</td>\n    <td class=\"fieldarea\">\n<input value=\"";
echo $LNG["add"];
echo "\" name=\"save\" id=\"btnoverview\" class=\"btn\" type=\"submit\" />\n    </td>\n</tr>\n</tbody>\n</table>\n</form>\n<p align=\"left\" >CSV File format example<br />\n\"Product Name\",\"Group Name\",\"Credit\",\"Time\",\"Stock\"\n<br />\ne.g. <textarea>\"Nokia N8\",\"Nokia\",\"400\",\"3 days\",\"40\"\n\"Samsung Galexy\",\"Samsung\",\"200\",\"5 days\",\"100\"\n</textarea>\n</p>\n";
if (isset($save) && $arr) {
    echo "<table id=\"main_tbl\" style=\"display: ";
    echo $display;
    echo ";\"  class='sortable'>\n            <thead>\n              <tr>\n                <th>";
    echo $LNG["id"];
    echo "</th>\n                <th>";
    echo $LNG["service"];
    echo "</th>\n                <th><div align=\"left\">";
    echo $LNG["action"];
    echo "</div></th>\n              </tr>\n            </thead>\n            <tbody >\n";
    foreach ($arr as $v) {
        $sql = mysqli_fetch_assoc(dquery("select service_name from tbl_products where id='" . $v . "'"));
        echo "<tr>\n<td>";
        echo $v;
        echo "</td>\n<td>";
        echo $sql["service_name"];
        echo "</td>\n<td><a onclick=\"javascript:redirectedit('editproduct', ";
        echo $v;
        echo ")\" >";
        echo $LNG["edit"];
        echo "</a></td>\n</tr>\n";
    }
    echo "</tbody>\n</table>\n";
}
echo "</div></div>\n ";
$fileverioncheck = "6.1.0";

?>