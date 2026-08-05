<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 63;
checkPagePermission($pageid);
include "includes/3rdparty/editor/editor.php";
echo "    <script language=\"JavaScript\">\n        function newWindow(file, window) {\n            msgWindow = open(file, window, 'scrollbars=yes,resizable=no,width=550,height=400');\n            if (msgWindow.opener == null) msgWindow.opener = self;\n        }\n\n        function DeleteCustom(cid) {\n            var answer = confirm('Are you sure want to delete this item?');\n            if (answer) {\n                DeleteItem(cid, 'editimeiservice.delcustom', '#frmpayg', '#table_' + cid, '#notification', 'true', '#main_loader');\n                \$(\"#\" + cid).hide();\n            }\n        }\n    </script>\n";
if ($_POST["action"] == "save" && isset($_POST["Deactivate"])) {
    dquery("DELETE FROM `tbl_paymentgateways` WHERE `gateway` = '" . $_POST["gateway"] . "'");
    echo "<p class=\"notification success\" >Payment Gateway Deactivated</p>";
}
$data_query = dquery("SELECT * FROM `tbl_paymentgateways`");
while ($data = mysqli_fetch_assoc($data_query)) {
    $GatewayValues[$data["gateway"]][$data["setting"]] = $data["value"];
}
$data_query = NULL;
$data_query = dquery("SELECT * FROM `tbl_currencies`");
while ($data = mysqli_fetch_assoc($data_query)) {
    $currencies[$data["id"]] = $data["code"];
}
$data_query = NULL;
$dh = opendir("../modules/gateways/");
while (false !== ($file = readdir($dh))) {
    if (substr($file, -4, 4) == ".php" && is_file("../modules/gateways/" . $file) && $file != "index.php" && $file != "") {
        $_getdirname = explode(".", $file);
        if ($gatewayicon[$gateway]) {
            saveSettings("gatewayicon" . $gateway . "", $gatewayicon[$gateway]);
        }
        if ($gatewayminlimit[$gateway]) {
            saveSettings("gatewayminlimit" . $gateway . "", $gatewayminlimit[$gateway]);
        }
        if ($gatewaymaxlimit[$gateway]) {
            saveSettings("gatewaymaxlimit" . $gateway . "", $gatewaymaxlimit[$gateway]);
        }
        $gwv_modulename = $_getdirname[0];
        require_once "../modules/gateways/" . $file;
        if ($GatewayValues[$gwv_modulename]["active"]) {
            $ActiveGateways[] = $gwv_modulename;
        } else {
            $DisabledGateways[] = $gwv_modulename;
            asort($DisabledGateways);
        }
        if (function_exists($gwv_modulename . "_config")) {
            $GatewayConfig[$gwv_modulename] = call_user_func($gwv_modulename . "_config");
        } else {
            $GatewayFieldDefines = [];
            $GatewayFieldDefines["name"] = ["Type" => "System", "Value" => $GATEWAYMODULE[$gwv_modulename . "visiblename"]];
            if ($GATEWAYMODULE[$gwv_modulename . "notes"]) {
                $GatewayFieldDefines["notes"] = ["Type" => "System", "Value" => $GATEWAYMODULE[$gwv_modulename . "notes"]];
            }
            call_user_func($gwv_modulename . "_activate");
            $GatewayConfig[$gwv_modulename] = $GatewayFieldDefines;
        }
    }
}
closedir($dh);
if ($_POST["action"] == "activate") {
    checkDemoMode(false);
    dquery("DELETE FROM `tbl_paymentgateways` WHERE `gateway` = '" . $gateway . "'");
    $data["gateway"] = $gateway;
    $data["setting"] = "active";
    $data["value"] = 1;
    $data["order"] = 0;
    $db->insert("tbl_paymentgateways", $data);
    $data["setting"] = "visible";
    $data["value"] = 1;
    $db->insert("tbl_paymentgateways", $data);
    $data["setting"] = "curcode";
    $data["value"] = "";
    $db->insert("tbl_paymentgateways", $data);
    $data["setting"] = "convertto";
    $data["value"] = "";
    $db->insert("tbl_paymentgateways", $data);
    foreach ($GatewayConfig[$gateway] as $key => $val) {
        $data["setting"] = $key;
        if ($key == "name" || $key == "notes") {
            $data["value"] = $val["Value"];
        } else {
            $data["value"] = "";
        }
        $db->insert("tbl_paymentgateways", $data);
    }
    $data = NULL;
    echo "<p class=\"notification success\" >" . $LNG["payment"] . " " . $LNG["gateway"] . " " . $LNG["activated"] . "</p>";
}
echo "    <div id=\"notification\"></div>\n";
if ($_POST["action"] == "save" && isset($_POST["Save"])) {
    $_POST["field"]["convertto"] = $_POST["field"]["curcode"];
    $_POST["field"]["curcode"] = $currencies[$_POST["field"]["curcode"]];
    if (!$_POST["field"]["hidewithdrawal"]) {
        $_POST["field"]["hidewithdrawal"] = 0;
    }
    if (!$_POST["field"]["kycforcheckout"]) {
        $_POST["field"]["kycforcheckout"] = 0;
    }
    if (!$_POST["field"]["hideaddfund"]) {
        $_POST["field"]["hideaddfund"] = 0;
    }
    foreach ($_POST["field"] as $setting => $value) {
        if (mysqli_num_rows(dquery("select * from tbl_paymentgateways where `setting`= '" . $setting . "' AND `gateway`= '" . $_POST["gateway"] . "'"))) {
            dquery("UPDATE `tbl_paymentgateways` SET `value`= '" . $value . "' WHERE `setting`= '" . $setting . "' AND `gateway`= '" . $_POST["gateway"] . "'");
        } else {
            dquery("INSERT INTO tbl_paymentgateways (setting,gateway,value) VALUES ('" . $setting . "','" . $_POST["gateway"] . "','" . $value . "')");
        }
    }
    echo "<div id=\"notification1\" class=\"successbox\" >" . $LNG["payment"] . " " . $LNG["gateway"] . " " . $LNG["changed"] . " " . $LNG["successfully"] . "</div>";
}
echo "<div id=\"content\">\n<div id=\"content_padded\">";
$data = NULL;
$data_query = dquery("SELECT * FROM `tbl_paymentgateways` WHERE `setting`='name' AND `gateway`='" . $id . "' ORDER BY `order`");
while ($data = mysqli_fetch_assoc($data_query)) {
    $data_query1 = dquery("SELECT * FROM `tbl_paymentgateways` WHERE `gateway`='" . $data["gateway"] . "'");
    while ($data1 = mysqli_fetch_assoc($data_query1)) {
        $gwv_database_val[$data1["setting"]] = $data1["value"];
    }
    $data_query1 = NULL;
    $data1 = NULL;
    echo "    <div  class=\"groupstabes\">\n        <h2>\n            <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n            <span class=\"groupstabesheadertext\">";
    echo $data["value"];
    echo "</span>&nbsp;\n            <font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n        </h2>\n        <div class=\"groupstabescontant\">\n            ";
    echo "<form id=\"form_" . $data["gateway"] . "\"  method=\"post\" >\n    <br />\n    \n    <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n    <tbody>\n\n    <input type=\"hidden\" name=\"action\" value=\"save\"><input type=\"hidden\" name=\"gateway\" value=\"" . $data["gateway"] . "\">";
    echo "<input type=\"hidden\" name=\"field[visible]\" value=\"\">";
    echo " <tr>\n    <td class=\"fieldlabel\" width=25%>" . $LNG["show"] . " " . $LNG["on"] . " " . $LNG["order"] . " " . $LNG["form"] . "</td>\n    <td class=\"fieldarea\">  <input value=\"1\" id=\"visible\" type=\"checkbox\" name=\"field[visible]\" size=\"40\" ";
    if ($gwv_database_val["visible"]) {
        echo " checked";
    }
    echo " /> <label for=\"visible\"></label> </td> </tr>   ";
    foreach ($GatewayConfig[$data["gateway"]] as $confname => $configoption) {
        $fieldvalue = $gwv_database_val[$confname];
        if ($confname == "name") {
            echo " <tr> <td class=\"fieldlabel\">" . $LNG["display"] . " " . $LNG["name"] . "</td> <td class=\"fieldarea\">  <input type=\"text\" name=\"field[name]\" size=\"40\" value=\"" . $fieldvalue . "\" /> </td> </tr>  ";
        } else {
            echo "<tr> <td class=\"fieldlabel\"> " . (ucfirst($configoption["Name"]) ? ucfirst($configoption["Name"]) : $confname) . "</td> <td class=\"fieldarea\"> ";
            if ($configoption["Type"] == "text") {
                echo "<input type=\"text\" name=\"field[" . $confname . "]\" size=\"" . $configoption["Size"] . "\" value=\"" . $gwv_database_val[$confname] . "\"> " . $configoption["Description"];
            } else {
                if ($configoption["Type"] == "yesno") {
                    echo "<input type=\"hidden\" name=\"field[" . $confname . "]\" value=\"\">";
                    echo "<input value=\"1\" type=\"checkbox\" id=\"" . $confname . "\" name=\"field[" . $confname . "]\"";
                    if ($fieldvalue) {
                        echo " checked";
                    }
                    echo "> <label for=\"" . $confname . "\">" . $confname . "</label> " . $configoption["Description"];
                } else {
                    if ($configoption["Type"] == "textarea") {
                        echo "<textarea style=\"width: 550px !important;\" name=\"field[" . $confname . "]\" cols=\"" . $configoption["Cols"] . "\" rows=\"" . $configoption["Rows"] . "\">" . $fieldvalue . "</textarea><br>" . $configoption["Description"];
                    } else {
                        if ($configoption["Type"] == "dropdown") {
                            echo "<select name=\"field[" . $confname . "]\">";
                            $options = explode(",", $configoption["Options"]);
                            foreach ($options as $value) {
                                echo "<option";
                                if ($value == $fieldvalue) {
                                    echo " selected";
                                }
                                echo ">" . $value . "</option>";
                            }
                            echo "</select>";
                        } else {
                            if ($configoption["Type"] == "encrypted") {
                                echo "<input type=\"password\" name=\"field[" . $confname . "]\"\n                  size=\"" . $configoption["Size"] . "\" value=\"" . $gwv_database_val[$confname] . "\"> " . $configoption["Description"];
                            } else {
                                if ($configoption["Description"] != "") {
                                    echo $configoption["Description"];
                                }
                            }
                        }
                    }
                }
            }
            if ($confname == "notes") {
                echo "<p>" . $gwv_database_val[$confname] . "</p>";
            }
            echo "</td> </tr> ";
        }
    }
    echo "<tr> <td class=\"fieldlabel\"> " . $LNG["convert"] . "" . $LNG["to"] . ", " . $LNG["for"] . " " . $LNG["processing"] . "</td> <td class=\"fieldarea\">  <select name=\"field[curcode]\" > ";
    foreach ($currencies as $cid => $currenc) {
        echo "<option value=\"" . $cid . "\"";
        if ($currenc == $gwv_database_val["curcode"]) {
            echo "SELECTED";
        }
        echo " >" . $currenc . "</option>";
    }
    $SELECT_ = $gwv_database_val["convertto"] == "DONOTPROCESS" ? "SELECTED" : "";
    echo " <option value='DONOTPROCESS' " . $SELECT_ . " >Use invoice currency</option> ";
    echo " </select>  <input type=\"hidden\" name=\"field[convertto]\"  value=\"1\" /> </td> </tr> \n\n            <tr>\n                <td class=\"fieldlabel\">";
    echo $LNG["gateway"];
    echo " ";
    echo $LNG["icon"];
    echo "</td>\n                <td class=\"fieldarea\"><input type=\"text\" class=\"txt large\"\n                                             name=\"gatewayicon[";
    echo $id;
    echo "]\" id=\"logolink\"\n                                             value=\"";
    echo $config["gatewayicon" . $id];
    echo "\"/>\n                    <input type=\"button\" class=\"addFromgallery\"\n                           value=\"";
    echo $LNG["addgallery"];
    echo "\" name=\"upload\"\n                           onClick=\"newWindow('includes/gallery.php?id=logolink', 'windowname1')\"/>\n                </td>\n            </tr>\n            <tr>\n                <td class=\"fieldlabel\">";
    echo $LNG["add"];
    echo " ";
    echo $LNG["fund"];
    echo " ";
    echo $LNG["minimum"];
    echo " ";
    echo $LNG["deposite"];
    echo " ";
    echo $LNG["limit"];
    echo "</td>\n                <td class=\"fieldarea\"><input type=\"text\" class=\"txt small\"\n                                             name=\"gatewayminlimit[";
    echo $id;
    echo "]\" id=\"minimumlimit\"\n                                             value=\"";
    echo $config["gatewayminlimit" . $id];
    echo "\"/>\n                </td>\n            </tr>\n            <tr>\n                <td class=\"fieldlabel\">";
    echo $LNG["add"];
    echo " ";
    echo $LNG["fund"];
    echo " ";
    echo $LNG["maximum"];
    echo " ";
    echo $LNG["deposite"];
    echo " ";
    echo $LNG["limit"];
    echo "</td>\n                <td class=\"fieldarea\"><input type=\"text\" class=\"txt small\"\n                                             name=\"gatewaymaxlimit[";
    echo $id;
    echo "]\" id=\"maximumlimit\"\n                                             value=\"";
    echo $config["gatewaymaxlimit" . $id];
    echo "\"/>\n                </td>\n            </tr>\n\n            <tr>\n                <td class=\"fieldlabel\"></td>\n                <td class=\"fieldarea\">\n                    <label>\n                        <input type=\"checkbox\"  name=\"field[kycforcheckout]\"\n                            ";
    if ($gwv_database_val["kycforcheckout"]) {
        echo "checked='checked'";
    }
    echo "                               value=\"1\" />\n                        KYC required for Checkout\n                    </label>\n                </td>\n            </tr>\n\n\n            <tr>\n                <td class=\"fieldlabel\"></td>\n                <td class=\"fieldarea\">\n                    <label>\n                     <input type=\"checkbox\"  name=\"field[hidewithdrawal]\"\n                            ";
    if ($gwv_database_val["hidewithdrawal"]) {
        echo "checked='checked'";
    }
    echo "                            value=\"1\" />\n                        Hide from Withdrawal\n                    </label>\n                </td>\n            </tr>\n            <tr>\n                <td class=\"fieldlabel\"></td>\n                <td class=\"fieldarea\">\n                    <label>\n                        <input type=\"checkbox\"\n                            ";
    if ($gwv_database_val["hideaddfund"]) {
        echo "checked";
    }
    echo "                               name=\"field[hideaddfund]\" value=\"1\" />\n                        Hide from Add Fund\n                    </label>\n                </td>\n            </tr>\n            ";
    echo "<td></td>\n        <td class=\"fieldarea\"><input type=\"submit\" name=\"Save\" class=\"btn save\" value=\"" . $LNG["save"] . "\" /> </td>\n    </tr>\n    </tbody>\n            </table> \n            <div style=\"float: right;\">\n            <input class=\"button button_remove\" type=\"submit\" class=\"button_remove\"\n             name=\"Deactivate\" value=\" " . $LNG["deactivated"] . "\" />\n            </div>          \n            </form><br /><br /><br /><br />\n        ";
    echo "                            <h2>\n                    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n                    <span class=\"groupstabesheadertext\">Custome Fields</span>\n                </h2>\n                <form method=\"post\" id=\"frmpayg\">\n                    <input type=\"hidden\" name=\"gid\" value=\"";
    echo $id;
    echo "\"/>\n                    <table id=\"main_tbl\">\n                        <thead>\n                        <tr>\n                            <th>";
    echo $LNG["field"];
    echo " ";
    echo $LNG["type"];
    echo "</th>\n                            <th>";
    echo $LNG["name"];
    echo "</th>\n                            <th>";
    echo $LNG["description"];
    echo "</th>\n                            <th>";
    echo $LNG["fieldoptions"];
    echo "</th>\n                            <th>";
    echo $LNG["validation"];
    echo "</th>\n                            <th>";
    echo $LNG["required"];
    echo "</th>\n                            <th align=\"right\">";
    echo $LNG["action"];
    echo "</th>\n                        </tr>\n                        </thead>\n                        <tr class=\"adddatarow nocheckboxchecked\">\n\n                            <td class=\"\">\n                                <input type=\"hidden\" value=\"";
    echo $id;
    echo "\" name=\"customfield[-1][type]\"/>\n                                <input type=\"hidden\" value=\"";
    echo $id;
    echo "\" name=\"customfield[-1][relid]\"/>\n                                <select class=\"customfield\" name=\"customfield[-1][fieldtype]\">\n                                    <option value=\"text\">";
    echo $LNG["text"];
    echo "</option>\n                                    <option value=\"dropdown\">";
    echo $LNG["dropdown"];
    echo "</option>\n                                    <option value=\"radio\">";
    echo $LNG["radio"];
    echo "</option>\n                                    <option value=\"textarea\">";
    echo $LNG["textarea"];
    echo "</option>\n                                    <option value=\"tickbox\">";
    echo $LNG["tickbox"];
    echo "</option>\n                                    <option value=\"datepicker\">Datepicker</option>\n                                    <option value=\"time\">";
    echo $LNG["time"];
    echo "</option>\n                                    <option value=\"encrypted\">";
    echo $LNG["encrypted"];
    echo "</option>\n                                </select></td>\n                            <td><input name=\"customfield[-1][fieldname]\" value=\"\" type=\"text\"/> *</td>\n                            <td><input name=\"customfield[-1][description]\" value=\"\" type=\"text\"/></td>\n                            <td><input class='fieldoptions' name=\"customfield[-1][fieldoptions]\" disabled=\"disabled\"\n                                       value=\"\" type=\"text\"/><br/>\n                                <small>";
    echo $LNG["seperatedbycommas"];
    echo "</small>\n                            </td>\n                            <td><input class='regexpr' name=\"customfield[-1][regexpr]\" value=\"\" type=\"text\"/><br/>\n                                <small>";
    echo $LNG["regularexpression"];
    echo " <a href=\"javascript:void(0)\">Help</a></small>\n                            </td>\n                            <td><input value=\"on\" name=\"customfield[-1][required]\" id=\"required\" checked=\"checked\"\n                                       type=\"checkbox\"/> <label for=\"required\"></label></td>\n                            <td><span class=\"datagridbtn\"><input value=\"+ ";
    echo $LNG["add"];
    echo "\" id=\"btnaddgroup\"\n                                                                 class=\"button add\" type=\"button\"\n                                                                 onclick=\"SubmitForm('#btnaddgroup','editpaymentgateway.field','#frmpayg','#notification1','true','#main_loader','main2.php?page=paymentgateway.edit','";
    echo $id;
    echo "');\"/> </span>\n                            </td>\n                        </tr>\n                    </table>\n\n                    <table id=\"main_tbl\">\n                        ";
    include_once ROOTDIR . "/includes/customfield.fun.inc.php";
    $row = getCustomfieldServicewise($id, $id);
    function get_string_between($string, $start, $end)
    {
        $string = " " . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) {
            return "";
        }
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
    if ($row) {
        $fullstring = $row[$key]["fieldname"];
        $parsed = get_string_between($fullstring, "value=\"", "\"");
        foreach ($row as $key => $value) {
            echo "                                <tr class=\"nocheckboxchecked\" id=\"";
            echo $key;
            echo "\">\n                                    <td>";
            echo $row[$key]["fieldtype"];
            echo "</td>\n                                    <td>";
            echo $row[$key]["fieldname"];
            echo "</td>\n                                    <td>";
            echo $row[$key]["description"];
            echo "</td>\n                                    <td>";
            echo $row[$key]["fieldoptions"];
            echo "                                        <span class=\"fieldoptionimg\" title=\"Set Pricing\"> &nbsp;&nbsp;&nbsp;\n <div class=\"close\"><span class=\"preforms\"></span></div></span></td>\n                                    <td>";
            echo $row[$key]["regexpr"];
            echo "</td>\n                                    <td>";
            echo $row[$key]["required"];
            echo "</td>\n                                    <td align=\"right\">\n                                        <div align=\"right\"><input value=\"";
            echo $LNG["delete"];
            echo "\"\n                                                                  id=\"";
            echo $key;
            echo "\" class=\"button delete deletedata\"\n                                                                  type=\"button\"\n                                                                  onclick=\"DeleteCustom(";
            echo $key;
            echo ")\"/></div>\n                                    </td>\n                                </tr>\n                                ";
        }
    }
    echo "                    </table>\n                    <br/>\n                    <input value=\"";
    echo $LNG["save"];
    echo "\"\n                           id=\"btnedituser\" class=\"btn\" type=\"button\"\n                           onclick=\"SubmitForm('#btnedituser','editpaymentgateway.field','#frmpayg','#notification','true','#main_loader','main2.php?page=paymentgateway.edit','";
    echo $id;
    echo "');\"/>\n\n                </form>\n                ";
}
$data_query = NULL;
echo "        </div>\n    </div></div>\n    </div>";
$fileverioncheck = "6.1.0";
function GatewayField($gateway, $type, $name, $defaultvalue, $friendlyname, $size, $description)
{
    global $GatewayFieldDefines;
    if ($type == "dropdown") {
        $options = $description;
        $description = "";
    } else {
        $options = "";
    }
    $GatewayFieldDefines[$name] = ["FriendlyName" => $friendlyname, "Type" => $type, "Size" => $size, "Description" => $description, "Value" => $defaultvalue, "Options" => $options];
}

?>