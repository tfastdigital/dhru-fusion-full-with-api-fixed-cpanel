<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 76;
checkPagePermission($pageid);
if ($server) {
    $wherecond = " where useasserver='" . $server . "'";
} else {
    $wherecond = " where useasserver=0";
}
include ROOTDIR . "/includes/imeiservices.fun.php";
$group = getIMEIServiceGroup($server);
echo "<script>\nfunction setthis(val){\n\tif(val!=\"\"){\n\t\tdocument.getElementById('setthis').innerHTML=\"New Service Name\";\n\t}\n}\n\n\$(document).ready(function(){\n   \$('#axn').click(function(){\n        if(\$(this).is(':checked')){\n           \$('#file').show();\n           \$('#single').hide();\n        }else{\n           \$('#file').hide();\n           \$('#single').show();\n        }\n   });\n});\n\n</script>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <span class=\"groupstabesheadertext\">Add Service</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n  <div>\n    <input type=\"checkbox\" name=\"axn\" value=\"1\"  id=\"axn\"/>\n    <label>Add services by file uploading</label>\n  </div><br />\n\n<div id=\"single\">\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
if ($server) {
    echo "    <input type=\"hidden\" name=\"useasserver\" value=\"";
    echo $server;
    echo "\" />\n";
}
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\"><span id='setthis'>";
echo $LNG["servicename"];
echo " </span>*</td>\n    <td class=\"fieldarea\"><input name=\"servicename\"  value=\"\" type=\"text\"  class=\"txt medium\"/>\n    &nbsp;&nbsp;&nbsp;\n    <select name=\"import\" class=\"chosen\" onchange=\"setthis(this.value);\" style=\"width: 400px;\">\n    \t<option value=\"\">";
echo $LNG["select"];
echo "</option>\n    \t";
$sql = dquery("select id,service_name from \n            tbl_services_imei " . $wherecond . " order by service_name asc");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<option value='" . $row["id"] . "'>" . html_entity_decode($row["service_name"]) . "</option>";
}
echo "    </select>\n    <small>Auto set other settings from selected dropdown service</small>\n        <br />\n        ";
if ($config["slack_servicestat"]) {
    echo "<div class=\"mt-1\"> <label><input type=\"checkbox\" name=\"sendnotification\" value=\"1\" />Send notification to Telegram Channel  </label>\n</div>\n            ";
}
echo "    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["service"];
echo " ";
echo $LNG["listedin"];
echo " ";
echo $LNG["group"];
echo "</td>\n    <td class=\"fieldarea\"><select name=\"groupname\" class=\"chosen\">\n        ";
foreach ($group as $key => $value) {
    $value = $group[$key]["name"];
    if ($group[$key]["active"] == 0) {
        echo "<option value=" . $key . " class=textred>" . $value . "    (<font style=font-style: italic;>Inactive</font>)</option>";
    } else {
        echo "<option value=" . $key . ">" . html_entity_decode($value) . "</option>";
    }
}
echo "    </select> &nbsp; <a href=\"#\" data-target=\"addimeigroup\"\n    data-target-header=\"";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["group"];
echo "\"\n    onclick=\"AddnewInpopup(this,";
echo $server == 1 ? 1 : "";
echo ");\">";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["group"];
echo "</a>  </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["status"];
echo "</td>\n    <td class=\"fieldarea\">\n    <span><input type=\"checkbox\" class=\"onoff {labelOn: 'Active', labelOff: 'Inactive'}\" id=\"active\" name=\"status\" value=\"1\" checked=\"checked\"/><label for=\"active\"></label></span>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["sendforverification"];
echo "</td>\n    <td class=\"fieldarea\">\n        <span><input type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"vy\" name=\"verification\" value=\"1\" checked=\"checked\"/><label for=\"vy\"></label></span>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["usercancancelorder"];
echo "</td>\n    <td class=\"fieldarea\">\n        <span><input type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"cy\" name=\"cancel\" value=\"1\" checked=\"checked\"/><label for=\"cy\"></label></span>\n    </td>\n</tr>\n<!--\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["model"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"model\" value=\"1\" type=\"radio\" id=\"model1\"/><label for=\"model1\">";
echo $LNG["yes"];
echo "</label> <input name=\"model\" value=\"0\" type=\"radio\" id=\"model0\" checked=\"checked\"/><label for=\"model0\">";
echo $LNG["no"];
echo "</label></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["provider"];
echo "</td>\n    <td class=\"fieldarea\"><input  name=\"provider\" value=\"1\" type=\"radio\" id=\"provider1\"/><label for=\"provider1\">";
echo $LNG["yes"];
echo "</label> <input  name=\"provider\" value=\"0\" type=\"radio\" id=\"provider0\" checked=\"checked\"/><label for=\"provider0\">";
echo $LNG["no"];
echo "</label></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["network"];
echo "</td>\n    <td class=\"fieldarea\"><input  name=\"network\" value=\"1\" type=\"radio\" id=\"network1\"/><label for=\"network1\">";
echo $LNG["yes"];
echo "</label> <input  name=\"network\" value=\"0\" type=\"radio\" id=\"network0\" checked=\"checked\"/><label for=\"network0\">";
echo $LNG["no"];
echo "</label></td>\n</tr>\n-->\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["delivery"];
echo " ";
echo $LNG["time"];
echo " </td>\n    <td class=\"fieldarea\"><input name=\"time1\"  value=\"\" type=\"text\"  class=\"txt small\"  onkeyup=\"return cFd(this,false)\" onblur=\"return cFd(this,true)\"/>\n    <select name=\"timeref\">\n        <option value=\"Minutes\">";
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
echo "</option>\n    </select>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["credit"];
echo " </td>\n    <td class=\"fieldarea\"><input name=\"credit\"  value=\"0\" type=\"text\"  class=\"txt small\" onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/><span class=\"preforms\">";
echo $config["base_currency"];
echo "</span></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\"><input name=\"useraccess\" id=\"useraccess\"  value=\"1\" type=\"checkbox\"/><label for=\"useraccess\">";
echo $LNG["assign"];
echo " ";
echo $LNG["this"];
echo " ";
echo $LNG["service"];
echo " ";
echo $LNG["to"];
echo " ";
echo $LNG["user"];
echo "</label></td>\n</tr>\n\n </tbody>\n</table>\n\n<div class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["add"];
echo "\" id=\"btnoverview\" class=\"btn save\" type=\"button\"  onclick=\"SubmitForm ('#btnoverview','imeiservice.addnew','#frm','#notification','true','#main_loader');\"/></label>\n</div>\n\n</form>\n</div>\n\n<div id=\"file\" style=\"display: none;\">\n\n";
if (isset($save)) {
    checkDemoMode(false);
    if ($server) {
        $whereserver = " and useasserver=1";
        $wheregroup = " and server=1";
    } else {
        $whereserver = " and useasserver=0";
        $wheregroup = " and server=0";
    }
    $flag = false;
    if ($_FILES["prod"]["error"] <= 0) {
        $row = 0;
        $skip = 0;
        $arr = [];
        if (($handle = fopen($_FILES["prod"]["tmp_name"], "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if (count($data) == 4 && $data[0] != "" && $data[2] != "") {
                    $flag = true;
                    $check = mysqli_num_rows(dquery("select * from tbl_services_imei \n            where service_name='" . $data[0] . "' " . $whereserver));
                    if ($check == 0) {
                        $row++;
                        if ($data[1]) {
                            $grpid = dquery("select id from tbl_imei_group where group_name='" . $data[1] . "' " . $wheregroup);
                            if (mysqli_num_rows($grpid)) {
                                $grpid = mysqli_fetch_assoc($grpid);
                            } else {
                                $gr["group_name"] = $data[1];
                                $gr["active"] = 1;
                                if ($server) {
                                    $gr["server"] = 1;
                                }
                                $grpid["id"] = $db->insert("tbl_imei_group", $gr);
                                $gr = NULL;
                            }
                            $ins["group_id"] = $grpid["id"];
                        } else {
                            $grpid = dquery("select id from tbl_imei_group\n                    where group_name='Uncategorised' " . $wheregroup);
                            if (mysqli_num_rows($grpid)) {
                                $grpid = mysqli_fetch_assoc($grpid);
                            } else {
                                $gr["group_name"] = "Uncategorised";
                                $gr["active"] = 1;
                                if ($server) {
                                    $gr["server"] = 1;
                                }
                                $grpid["id"] = $db->insert("tbl_imei_group", $gr);
                                $gr = NULL;
                            }
                            $ins["group_id"] = $grpid["id"];
                        }
                        list($ins["service_name"], $ins["credit"], $ins["time"]) = $data;
                        $ins["active"] = 1;
                        if ($server) {
                            $ins["useasserver"] = 1;
                        }
                        $id = $db->insert("tbl_services_imei", $ins);
                        $PRICE = [];
                        $PRICE["serviceid"] = $id;
                        $PRICE["groupid"] = "base";
                        $PRICE["price"] = $data[2];
                        $PRICE["pricingqntid"] = 0;
                        $PRICE["currencyid"] = $_SESSION["system_default_currency"]["id"];
                        $db->insert("tbl_service_pricing", $PRICE);
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
            echo "<div id='notification1' class='successbox'>" . $row . " service inserted successfully<br />\n          " . $skip . " Service skipped</div>";
        } else {
            echo "<div id='notification1' class='errorbox'>Invalid File format</div>";
        }
    } else {
        echo "<div id='notification1' class='errorbox'>Error in file upload</div>";
    }
}
echo "<div id=\"notification\"></div>\n\n<div  class=\"groupstabes\" >\n\n  <div class=\"groupstabescontant\">\n\n<form id=\"frm\" name=\"\" method=\"post\" enctype=\"multipart/form-data\">\n<input type=\"hidden\" name=\"defaultpage\" value=\"imeiservice.addnew.php\" />\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["upload"];
echo " ";
echo $LNG["file"];
echo " </td>\n    <td class=\"fieldarea\" colspan=\"2\">\n    <input type=\"file\" name=\"prod\" />\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["file"];
echo " ";
echo $LNG["format"];
echo "</td>\n    <td class=\"fieldarea\" colspan=\"2\">\n    <select name=\"type\">\n        <option value=\"1\">CSV</option>\n    </select>\n    </td>\n\n</tr>\n\n<tr>\n    <td>\n\n    </td>\n    <td style=\"padding: 10px;\">\n        <strong>CSV File format example</strong><br />\n\"Service Name\",\"Group Name\",\"Price\",\"Time\"\n<br />\n<textarea readonly=\"\"  style=\"height: 200px;width:400px\" rows=\"5\">\n\"Blackberry Calculator (MEP 101)\",\"Blackberry\",\"100\",\"3 days\"\n\"Blackberry Calculator (MEP 102)\",\"Blackberry\",\"200\",\"5 days\"\n</textarea>\n    </td>\n</tr>\n\n</tbody>\n</table>\n\n<div class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["add"];
echo "\" name=\"save\" id=\"btnoverview\" class=\"btn save\" type=\"submit\" />\n</div>\n\n</form></div></div>\n\n</div>\n</div>\n\n\n";
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
        $sql = mysqli_fetch_assoc(dquery("select service_name from tbl_services_imei where id='" . $v . "'"));
        echo "<tr>\n<td>";
        echo $v;
        echo "</td>\n<td>";
        echo $sql["service_name"];
        echo "</td>\n<td><a onclick=\"javascript:redirectedit('editimeiservice', ";
        echo $v;
        echo ")\" >";
        echo $LNG["edit"];
        echo "</a></td>\n</tr>\n";
    }
    echo "</tbody>\n</table>\n";
}
echo "\n\n</div></div>\n\n ";
$fileverioncheck = "6.1.0";

?>