<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n<script>\nfunction DeleteCustom(cid){\n    var answer = confirm('Are you sure to delete this item?');\n    if(answer)\n    {\n        DeleteItem (cid,'editimeiservice.delcustom','#frmedituser','#table_'+cid,'#notification','true','#main_loader');\n        \$(\"#\"+cid).hide();\n    }\n}\n\$(document).ready(function(){\n    \$('.fieldoptionimg').click(function(){\n        \$(this).children().toggleClass('open');\n       \$(this).next().toggleClass('childopen');\n    });\n});\n\nfunction showprice(val){\n    document.getElementById('show_'+val).style.display='';\n}\nfunction hideprice(val){\n    document.getElementById('show_'+val).style.display='none';\n}\nfunction showtab(ids){\n    \$(\"#show_\"+ids).toggle();\n}\n</script>\n\n<style>\n    .fieldoption{display: none;\n    background: none repeat scroll 0 0 #fafafa;\n    border: 1px solid #ccc;\n    border-radius: 3px;\n    display: none;\n    position: absolute;\n    }\n    .fieldoptionimg .close{background: url('templates/new/images/down_arr.png'); height:24px;width:30px;display: inline-block;}\n     .fieldoptionimg .open{background: url('templates/new/images/toparr.png'); height:24px;width:30px;display: inline-block;}\n     .childopen{display: block;}\n</style>\n\n\n";
$pageid = 347;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/apiserver.fun.php";
$serviceDetails = mysqli_fetch_assoc(dquery("SELECT API,API_ID FROM tbl_products WHERE id='" . $id . "' "));
include_once ROOTDIR . "/includes/products.fun.php";
$md5id = md5($id);
$prdocutDetails = getProducts("", $md5id);
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "<div class=\"groupstabes\"  style=\"position: relative;\">\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Custome Fields</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n<table id=\"main_tbl\">\n<thead>\n<tr>\n<th>";
echo $LNG["field"];
echo " ";
echo $LNG["type"];
echo "</th>\n<th>";
echo $LNG["name"];
echo "</th>\n<th>";
echo $LNG["description"];
echo "</th>\n<th>";
echo $LNG["fieldoptions"];
echo "</th>\n<th>";
echo $LNG["validation"];
echo "</th>\n<th>";
echo $LNG["required"];
echo "</th>\n<th align=\"right\">";
echo $LNG["action"];
echo "</th>\n</tr>\n</thead>\n\n\n    <tr  class=\"adddatarow nocheckboxchecked\">\n        <input type=\"hidden\" value=\"product\" name=\"customfield[-1][type]\"/>\n        <input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"customfield[-1][relid]\"/>\n        <td><select class=\"customfield\" name=\"customfield[-1][fieldtype]\">\n        <option value=\"text\">";
echo $LNG["text"];
echo "</option>\n        <option value=\"dropdown\">";
echo $LNG["dropdown"];
echo "</option>\n        <option value=\"radio\">";
echo $LNG["radio"];
echo "</option>\n        <option value=\"textarea\">";
echo $LNG["textarea"];
echo "</option>\n        <option value=\"tickbox\">";
echo $LNG["tickbox"];
echo "</option>\n        <option value=\"datepicker\">Datepicker</option>\n        <option value=\"time\">";
echo $LNG["time"];
echo "</option>\n        </select></td>\n        <td><input name=\"customfield[-1][fieldname]\" value=\"\" type=\"text\"/> * </td>\n        <td><input name=\"customfield[-1][description]\" value=\"\" type=\"text\" /></td>\n        <td><input  class='fieldoptions' name=\"customfield[-1][fieldoptions]\"  value=\"\" type=\"text\"/><br /> <small>";
echo $LNG["seperatedbycommas"];
echo "</small></td>\n        <td><input  class='regexpr' name=\"customfield[-1][regexpr]\" value=\"\" type=\"text\" /><br />  <small>";
echo $LNG["regularexpression"];
echo "  <a href=\"javascript:void(0)\">Help</a> </small></td>\n        <td><input value=\"on\" name=\"customfield[-1][required]\" id=\"required\" checked=\"checked\" type=\"checkbox\" /> <label for=\"required\"></label></td>\n        <td><span class=\"datagridbtn\"><input value=\"+ ";
echo $LNG["add"];
echo "\" id=\"btnaddgroup\" class=\"button add\" type=\"button\"\nonclick=\"SubmitForm ('#btnaddgroup','editimeiservice.field','#frmedituser','#notification','true','#main_loader','main2.php?page=editproduct.field','";
echo $id;
echo "');\"/> </span> </td>\n    </tr>\n\n\n";
include_once ROOTDIR . "/includes/customfield.fun.inc.php";
$row = getCustomfieldServicewise("product", $id);
if ($row) {
    $fullstring = $row[$key]["fieldname"];
    $parsed = get_string_between($fullstring, "value=\"", "\"");
    foreach ($row as $key => $value) {
        echo "    <tr class=\"nocheckboxchecked\"  id=\"";
        echo $key;
        echo "\">\n        <td>";
        echo $row[$key]["fieldtype"];
        echo "</td>\n        <td>";
        echo $row[$key]["fieldname"];
        echo "</td>\n        <td>";
        echo $row[$key]["description"];
        echo "</td>\n        <td>";
        echo $row[$key]["fieldoptions"];
        echo " <span class=\"fieldoptionimg\" title=\"Set Pricing\"> &nbsp;&nbsp;&nbsp; <div class=\"close\"><span class=\"preforms\">></span></div></span>\n        <div class=\"fieldoption\">\n            ";
        if ($row[$key]["configurable"]) {
            $fielddata = explode(",", $row[$key]["configurable"]);
            echo "<table class=form border=0 style='width:400px;' cellpadding=3 cellspacing=2><tbody>";
            foreach ($fielddata as $k => $d) {
                if (trim($d)) {
                    $cst = mysqli_fetch_assoc(dquery("select credit from tbl_customfieldconfig where cid='" . $key . "' and currency_id='" . $_SESSION["system_default_currency"]["id"] . "'"));
                    if ($cst["credit"]) {
                        $cdata = explode(",", $cst["credit"]);
                        if ($cdata[$k] == 0) {
                            $include = "checked='checked'";
                            $exclude = "";
                            $style = "display:none;";
                        } else {
                            $exclude = "checked='checked'";
                            $style = "";
                            $include = "";
                        }
                        $value = $cdata[$k];
                    } else {
                        $include = "checked='checked'";
                        $exclude = "";
                        $style = "display:none;";
                        $value = "";
                    }
                    echo "<tr><td><strong>" . $d . "</strong></td><td  align='left'><div align='left'>\n                                        <span> <input type='radio' " . $include . " name='customfieldc[" . $key . "][include][" . $d . "]' id='" . $key . $k . "'  onclick='hideprice(" . $key . $k . ")' value='0' /><label for='" . $key . $k . "' onclick='hideprice(" . $key . $k . ")'> Free </label></span> <span><input type='radio' onclick='showprice(" . $key . $k . ")' id='1_" . $key . $k . "' value='1' " . $exclude . " name='customfieldc[" . $key . "][include][" . $d . "]' /><label for='1_" . $key . $k . "' onclick='showprice(" . $key . $k . ")'>Paid </label> </span>    \n                                        &nbsp;&nbsp;&nbsp;&nbsp;<span id='show_" . $key . $k . "' style='" . $style . "'>  " . $_SESSION["system_default_currency"]["code"] . " <input type='text' style='width: 60px;' name='customfieldc[" . $key . "][price][" . $d . "]' value='" . $value . "' /></span>\n                                </div> </td></tr>";
                }
            }
            echo "</td></tr></tbody></table>";
        }
        echo "        </div>\n        </td>\n        <td>";
        echo $row[$key]["regexpr"];
        echo "</td>\n        <td>";
        echo $row[$key]["required"];
        echo "</td>\n        <td align=\"right\"><div align=\"right\"><input value=\"";
        echo $LNG["delete"];
        echo "\" id=\"";
        echo $key;
        echo "\" class=\"button delete deletedata\" type=\"button\"  onclick=\"DeleteCustom(";
        echo $key;
        echo ")\"/></div> </td>\n    </tr>\n    ";
    }
}
echo "</table>\n  </div>\n</div>\n\n<p  class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\"\nid=\"btnedituser\" class=\"btn\" type=\"button\"\nonclick=\"SubmitForm ('#btnedituser','editproduct.field','#frmedituser','#notification','true','#main_loader','main2.php?page=editproduct.field','";
echo $id;
echo "');\"/></p>\n\n</div>\n</div>\n</form>\n\n<div id=\"page_info\" class=\"page_info\">\n\t<li>Products custom field include/exclude price</li>\n</div> ";
$fileverioncheck = "6.1.0";
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

?>