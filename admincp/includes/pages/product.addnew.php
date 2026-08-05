<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n  <style>\n  .list{\n     background-color: #F9F9F9;\n     width: 350px;\n  }\n  .list:hover{\n     background-color: #EEEEEE;\n\n  }\n  </style>\n<script>\n\n\$(document).ready(function() {\n\n    \$('#import').keyup(function() {\n        var vls=\$(this).val();\n                 \$.post(\"includes/pages/search.product.php\", { val: vls},function(data) {\n                 \$('#productsear').show();\n                 \$('#productsear').html(data);\n          });\n    });\n});\n\n\$(document).ready(function(){\n   \$('#axn').click(function(){\n        if(\$(this).is(':checked')){\n           \$('#uploading').show();\n           \$('#single').hide();\n        }\n        else{\n            \$('#uploading').hide();\n           \$('#single').show();\n        }\n   });\n});\n\n\nfunction setVLL(val){\n    var spl;\n    spl=val.split(\"--\");\n    \$('#import').val(spl[1]);\n    \$('#hidd').val(spl[0]);\n    \$('#setthis').html('New Product Name');\n    \$('#productsear').hide();\n}\n</script>\n<script>\nfunction setthis(val){\n\tif(val!=\"\"){\n\t\tdocument.getElementById('setthis').innerHTML=\"New Product Name\";\n\t}\n}\n</script>\n";
$pageid = 361;
checkPagePermission($pageid);
include ROOTDIR . "/includes/products.fun.php";
$group = getProductGroup();
$grp = buildProductGrou(getProductGroupArray(), "", "dropdown", "groupname", $imeigroup["mid"]);
echo "\n<div id=\"content\">\n<div id=\"content_padded\">\n\n\n\n\n\n<div id=\"notification\"></div>\n<div  class=\"groupstabes\" >\n  <h2>\n    <span class=\"groupstabesheadertext\">Add Product</span>\n  </h2>\n\n\n<div>\n    <input type=\"checkbox\" name=\"axn\" value=\"1\"  id=\"axn\"/> <label>Add services by file uploading</label>\n  </div><br />\n\n <div id=\"single\">\n\n  <div class=\"groupstabescontant\">\n\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\"><span id='setthis'>";
echo $LNG["productname"];
echo "</span> *</td>\n    <td class=\"fieldarea\"><input name=\"productname\"  value=\"\" type=\"text\" style=\"width: 200px;\" class=\"txt medium\"/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Check ";
echo $LNG["duplicate"];
echo " Product\n\n    <input type=\"hidden\" id=\"hidd\" name=\"hidd\" value=\"\" />\n    <input type=\"text\"  class=\"txt medium\" name=\"import\" style=\"width: 200px;\" id=\"import\" value=\"Search Product\"\n onfocus=\"if(this.value=='Search Product')value='';\"\n onblur=\"if(this.value=='')this.value='Search Product';\"\n     />\n    <div style=\"margin-left: 400px; z-index: 300; position:  absolute;\" id=\"productsear\"></div>\n     </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["product"];
echo " ";
echo $LNG["listedin"];
echo " ";
echo $LNG["group"];
echo "</td>\n    <td class=\"fieldarea\">\n        ";
echo $grp;
echo "   </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["status"];
echo "    </td>\n    <td class=\"fieldarea\">\n    <span><input type=\"checkbox\" class=\"onoff {labelOn: 'Active', labelOff: 'Inactive'}\" id=\"active\" name=\"status\" value=\"1\" checked=\"checked\"/><label for=\"active\"></label></span>\n\n    <small>(Do not show in Cart)</small>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["delivery"];
echo " ";
echo $LNG["time"];
echo " </td>\n    <td class=\"fieldarea\"><input name=\"time1\"  value=\"\" type=\"text\"  class=\"txt small\" onkeyup=\"return cFd(this,false)\" onblur=\"return cFd(this,true)\"/>\n    <select name=\"timeref\">\n    <option value=\"\">";
echo $LNG["select"];
echo "</option>\n        <option value=\"Minutes\">";
echo $LNG["minutes"];
echo "</option>\n        <option value=\"Hours\">";
echo $LNG["hours"];
echo "</option>\n        <option value=\"Weeks\">";
echo $LNG["weeks"];
echo "</option>\n        <option value=\"Days\">";
echo $LNG["days"];
echo "</option>\n        <option value=\"Months\">";
echo $LNG["months"];
echo "</option>\n        <option value=\"Instant\">";
echo $LNG["instant"];
echo "</option>\n    </select>\n\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["price"];
echo " </td>\n    <td class=\"fieldarea\"><input name=\"credit\"  value=\"0\" type=\"text\"  class=\"txt small\" onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/><span class=\"preforms\">";
echo $config["base_currency"];
echo "</span></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["availability"];
echo " ";
echo $LNG["on"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"availability_date\"   placeholder=\"yyyy-mm-dd\" id=\"to\"  type=\"text\"  class=\"txt medium datepicker\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">  &nbsp; </td>\n    <td class=\"fieldarea\">\n    <input type=\"checkbox\" name=\"bundle\" value=\"1\" id=\"bn\" /><label for=\"bn\"> ";
echo $LNG["product"];
echo "  ";
echo $LNG["bundle"];
echo "</label>\n    </td>\n</tr>\n\n</tbody>\n</table>\n\n<div class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["add"];
echo "\" id=\"btnoverview\" class=\"btn save\" type=\"button\"  onclick=\"SubmitForm ('#btnoverview','product.addnew','#frm','#notification','true','#main_loader');\"/>\n</div>\n\n</form> </div></div>\n</div>\n\n<div id=\"uploading\" style=\"display: none;\">\n\n";
if (isset($save)) {
    checkDemoMode(false);
    $flag = false;
    if ($_FILES["prod"]["error"] <= 0) {
        $row = 0;
        $skip = 0;
        $arr = [];
        if (($handle = fopen($_FILES["prod"]["tmp_name"], "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if (count($data) == 5 && $data[0] != "" && $data[2] != "") {
                    $flag = true;
                    $check = mysqli_num_rows(dquery("select * from tbl_products where service_name='" . $data[0] . "'"));
                    if ($check == 0) {
                        $row++;
                        $data[1] = trim($data[1]);
                        if ($data[1]) {
                            $grpid = dquery("select id from tbl_product_group\n                    where group_name='" . $data[1] . "'");
                            if (mysqli_num_rows($grpid)) {
                                $grpid = mysqli_fetch_assoc($grpid);
                                $ins["group_id"] = $grpid["id"];
                            } else {
                                $gr["group_name"] = $data[1];
                                $gr["active"] = 1;
                                $is = $db->insert("tbl_product_group", $gr);
                                $ins["group_id"] = $is;
                                $gr = NULL;
                            }
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
            }
            fclose($handle);
        }
        if ($flag) {
            echo "<div id='notification1' class='successbox'>" . $row . " Product inserted successfully<br />\n                  " . $skip . " Product skipped</div>";
        } else {
            echo "<div id='notification1' class='errorbox'>Invalid File format</div>";
        }
    } else {
        echo "<div id='notification1' class='errorbox'>Error in file upload</div>";
    }
}
echo "<div id=\"notification\"></div>\n\n<div  class=\"groupstabes\" >\n\n  <div class=\"groupstabescontant\">\n\n<form id=\"frm\" name=\"\" method=\"post\" enctype=\"multipart/form-data\">\n<input type=\"hidden\" name=\"defaultloadpage\" value=\"product.addnew.php\" />\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["upload"];
echo " ";
echo $LNG["file"];
echo " </td>\n    <td class=\"fieldarea\" colspan=\"2\">\n    <input type=\"file\" name=\"prod\" />\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["file"];
echo " ";
echo $LNG["format"];
echo "</td>\n    <td class=\"fieldarea\" colspan=\"2\">\n    <select name=\"type\">\n    <option value=\"1\">CSV</option>\n    </select>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">&nbsp;</td>\n    <td style=\"padding:10px\">\n\n        <p align=\"left\" ><strong>CSV File format example</strong><br />\n\"Product Name\",\"Group Name\",\"Price\",\"Time\",\"Stock\"\n<br /><br />\n<textarea readonly=\"\" cols=\"50\" style=\"height: 200px;\" rows=\"5\">\n\"Nokia N8\",\"Nokia\",\"400\",\"3 days\",\"40\"\n\"Samsung Galexy\",\"Samsung\",\"200\",\"5 days\",\"100\"\n</textarea>\n</p>\n\n    </td>\n</tr>\n</tbody>\n</table>\n\n<div class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["add"];
echo "\" name=\"save\" id=\"btnoverview\" class=\"btn save\" type=\"submit\" />\n</div>\n\n</form></div></div>\n\n</div>\n\n";
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
echo "\n\n</div></div>\n ";
$fileverioncheck = "6.1.0";

?>