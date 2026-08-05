<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
include_once "../../../comm.php";
require_once "../../includes/fun.inc.php";
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
if ($save) {
    checkDemoMode(false);
    if ($credit) {
        if ($apply == 1) {
            $total = $subtotal;
        } else {
            if ($apply == 2) {
                if (trim($imei) != "") {
                    $ptype = "imei";
                    $product = $imei;
                } else {
                    if (trim($server) != "") {
                        $ptype = "server";
                        $product = $server;
                    } else {
                        if (trim($product) != "") {
                            $ptype = "product";
                        }
                    }
                }
            }
        }
        $data["amount"] = $credit;
        $data["used"] = $used;
        $data["currency"] = $currency;
        $data["vali_start"] = $from;
        $data["vali_end"] = $to;
        $data["type"] = $type;
        $data["product"] = $product;
        $data["product_type"] = $ptype;
        $data["total"] = $total;
        $db->update("tbl_promotion", $data, "id=" . $id);
        echo "<div id='notification1' class='successbox'>" . $LNG["datasavesuccessfully"] . "</div>";
    } else {
        echo "<div id='notification1' class='errorbox'>" . $LNG["datanotsave"] . "</div>";
    }
}
$sql = mysqli_fetch_assoc(dquery("select *,DECODE(`code`,'9486') as cod from tbl_promotion where id='" . $id . "'"));
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n<meta http-equiv=\"content-type\" content=\"text/html; charset=";
echo $config["charset"];
echo "\" />\n<script src=\"../js/jquery.js\" type=\"text/javascript\"></script>\n<script src=\"../js/jquery.ui.min.js\"></script>\n<link href=\"../css/ui/style.css\" rel=\"stylesheet\"/>\n<script>\n\$(function() {\n\t\tvar dates = \$( \"#from\" ).datepicker({\n\t\t\tchangeMonth: true,\n            changeYear: true,\n            dateFormat:'yy-mm-dd',\n\t\t\tonSelect: function( selectedDate ) {\n\t\t\t\tvar option = this.id == \"from\" ? \"minDate\" : \"maxDate\",\n\t\t\t\t\tinstance = \$( this ).data( \"datepicker\" );\n\t\t\t\t\tdate = \$.datepicker.parseDate(\n\t\t\t\t\t\tinstance.settings.dateFormat ||\n\t\t\t\t\t\t\$.datepicker._defaults.dateFormat,\n\t\t\t\t\t\tselectedDate, instance.settings );\n\t\t\t\tdates.not( this ).datepicker( \"option\", option, date );\n\t\t\t}\n\t\t});\n\t\tvar dates = \$( \"#to\" ).datepicker({\n\t\t\tchangeMonth: true,\n            changeYear: true,\n            dateFormat:'yy-mm-dd',\n\t\t\tonSelect: function( selectedDate ) {\n\t\t\t\tvar option = this.id == \"to\" ? \"minDate\" : \"maxDate\",\n\t\t\t\t\tinstance = \$( this ).data( \"datepicker\" );\n\t\t\t\t\tdate = \$.datepicker.parseDate(\n\t\t\t\t\t\tinstance.settings.dateFormat ||\n\t\t\t\t\t\t\$.datepicker._defaults.dateFormat,\n\t\t\t\t\t\tselectedDate, instance.settings );\n\t\t\t\tdates.not( this ).datepicker( \"option\", option, date );\n\t\t\t}\n\t\t});\n\t});</script>\n\t<link rel=\"stylesheet\" href=\"../css/x-main2.css\" />\n\t</head>\n\t<bodY>\n<div id=\"notification\"></div>\n<div id=\"content\" style=\"width: 100%;!important \">\n<div id=\"content_padded\" style=\"width: 100%;!important \">\n\n<form method=\"post\" id=\"frms\">\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["promotional"];
echo " ";
echo $LNG["name"];
echo "</td>\n<td class=\"fieldarea\">\n";
echo $sql["cod"];
echo " </td>\n</tr>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["amount"];
echo "</td>\n<td class=\"fieldarea\"><input type=\"text\" name=\"credit\" style=\"width: 70px;\" value=\"";
echo $sql["amount"];
echo "\"  />\n<select name=\"type\" style=\"width: 140px !important;\">\n <option value=\"0\" ";
if (!$sql["type"]) {
    echo "selected";
}
echo ">";
echo $LNG["fixed"];
echo " ";
echo $LNG["amount"];
echo "</option>\n <option value=\"1\" ";
if ($sql["type"]) {
    echo "selected";
}
echo ">";
echo $LNG["percentage"];
echo " (%)</option>\n</select>\n</td>\n</tr>\n\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["noofuse"];
echo "</td>\n<td class=\"fieldarea\"><input type=\"text\" name=\"used\" style=\"width: 70px;\" value=\"";
echo $sql["used"];
echo "\" /> [<smal>";
echo $LNG["noofuseinfo"];
echo "</small>]</td>\n</tr>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["validity"];
echo "</td>\n<td class=\"fieldarea\"><input type=\"text\" name=\"from\" style=\"width: 70px;\"  id=\"from\" value=\"";
echo $sql["vali_start"];
echo "\"  />\n ";
echo $LNG["to"];
echo " <input style=\"width: 70px;\"  type=\"text\" name=\"to\" id=\"to\" value=\"";
echo $sql["vali_end"];
echo "\"  /></td>\n</tr>\n<tr id=\"cur\">\n<td class=\"fieldlabel\">";
echo $LNG["currency"];
echo "</td>\n<td class=\"fieldarea\">\n<select name=\"currency\" style=\"width: 140px !important;\">\n";
$currency = dquery("SELECT code, id FROM tbl_currencies");
while ($row = mysqli_fetch_assoc($currency)) {
    echo " <option ";
    if ($sql["currency"] == $row["id"]) {
        echo "selected";
    }
    echo " value=\"";
    echo $row["id"];
    echo "\">";
    echo $row["code"];
    echo "</option>\n ";
}
echo "</select>\n</td>\n</tr>\n\n</tbody></table>\n\n\n\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["applyif"];
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n<table>\n<tr>\n<td valign=\"top\">\n<fieldset style=\"padding-bottom: 75px\"><legend><input type='radio' name='apply' value='1' id='appe' onclick=\"clearbuff('appe');\" ";
if ($sql["total"] != "") {
    echo "checked='checked'";
}
echo "/> <label for='appe'>";
echo $LNG["orderexxcedsof"];
echo "</label><br>\n</legend>&nbsp;&nbsp;&nbsp;<input type='text' name='subtotal' id='subtotal' value=\"";
echo $sql["total"];
echo "\"/><br/></fieldset>\n</td>\n\n<td>\n<fieldset><legend><input type='radio' name='apply' value='2' id='appd' onclick=\"clearbuff('appd');\"  ";
if ($sql["product"] != "") {
    echo "checked='checked'";
}
echo "/> <label for='appd'>";
echo $LNG["cartcontains"];
echo "</label> <br>\n</legend>&nbsp;&nbsp;&nbsp;<input type='text' id='imei' name='imei' value=\"";
echo $sql["product_type"] == "imei" ? $sql["product"] : "";
echo "\" /><input type='button' name='browseimei' value='Browse IMEI'\nonclick=\"window.open('imeilist.php',\n\t  'windowname1',\n\t  'width=400, height=400');\n\t   return false;\" /><br>\n&nbsp;&nbsp;&nbsp;<input type='text' name='server' id='server' value=\"";
echo $sql["product_type"] == "server" ? $sql["product"] : "";
echo "\"/><input type='button' name='browseserver' value='Browse Server'\nonclick=\"window.open('serverlist.php',\n\t  'windowname1',\n\t  'width=400, height=400');\n\t   return false;\" /><br>\n&nbsp;&nbsp;&nbsp;<input type='text' name='product' id='product' value=\"";
echo $sql["product_type"] == "product" ? $sql["product"] : "";
echo "\"/><input type='button' name='browseproduct' value='Browse Products'\nonclick=\"window.open('productlist.php',\n\t  'windowname1',\n\t  'width=400, height=400');\n\t   return false;\" />\n</fieldset>\n</td>\n</tr>\n</table>\n</div></div>\n\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" name=\"save\" class=\"btn\" type=\"submit\" /></p>\n\n</form>\n<br /><br />\n\n</div>\n</div>\n<script>\nfunction clearbuff(val){\n\tif(val=='appe'){\n\t\tdocument.getElementById('imei').value=\"\";\n\t\tdocument.getElementById('server').value=\"\";\n\t\tdocument.getElementById('product').value=\"\";\n\t}else if(val=='appd'){\n\t\tdocument.getElementById('subtotal').value=\"\";\n\t}\n}\nfunction gencode(){\n    var cnt=document.getElementById('nos').value;\n   \tvar name=document.getElementById('names').value;\n    var length=4;\n    var buf='';\n    var chars = '123456789ABCDEFGHIJKLMNPQRSTUVWXTZ'.split('');\n    for(var j=0;j<cnt;j++){\n\n        if (! length) {\n            length = Math.floor(Math.random() * chars.length);\n        }\n\n        var str = '';\n        for (var i = 0; i < length; i++) {\n            str += chars[Math.floor(Math.random() * chars.length)];\n        }\n          if(buf!=''){\n            buf=buf+\"\\r\\n\"+name+\"-\"+str;\n          }else { buf=name+\"-\"+str; }\n\n    }\n\n    document.getElementById('code').value=buf;\n}\n</script>\n</bodY></html>";
$fileverioncheck = "6.1.0";

?>