<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"tabcontent\">\n";
include "client.head.php";
echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n\n";
$pageid = 61;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getClientsDetails($id);
$custom = getCustomFields("regis", $id, "");
echo "\n<div title=\"addnewclient\" id=\"tutid\"></div>\n<div id=\"notification\"></div>\n<div id=\"content\" class=\"mt-1\">\n<div id=\"\">\n<form id=\"frmaddclient\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n\n";
echo generate_token("form");
echo "\n\n<div class=\"floatleft\" style=\"width:48%;\">\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Account Information</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["username"];
echo " *</td>\n    <td class=\"fieldarea\"><input name=\"username\"  value=\"\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["password"];
echo " </td>\n    <td class=\"fieldarea\"><input name=\"password\"  value=\"\" type=\"password\"/><small>";
echo $LNG["blanktoauto"];
echo "</small> </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["registeredemail"];
echo " *</td>\n    <td class=\"fieldarea\"><input name=\"email\"  value=\"\" type=\"text\"  class=\"txt medium\" /></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["creditbalance"];
echo " </td>\n    <td class=\"fieldarea\"><input name=\"creditleft\"  value=\"0\"  type=\"text\"  class=\"txt small\"\n    onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/>\n\n";
$CurrencyList = getCurrencyCodeList();
echo "<select name=\"currency\">\n    ";
$query = "SELECT * FROM `tbl_currencies`";
$result = dquery($query);
while ($noticia = mysqli_fetch_assoc($result)) {
    echo "<option value=\"";
    echo $noticia["id"];
    echo "\" ";
    if ($config["base_currency"] == $noticia["code"]) {
        echo "selected";
    }
    echo " >";
    echo $noticia["code"];
    echo " - ";
    echo $CurrencyList[$noticia["code"]]["name"];
    echo "</option>\n";
}
echo "</select>\n &nbsp;&nbsp;&nbsp;\n    <span><input type=\"checkbox\" id=\"geninvoice\" name=\"geninvoice\"\n    checked=\"checked\"/><label for=\"geninvoice\">";
echo $LNG["geninvoice"];
echo "</label></span>\n\n    <span><input type=\"checkbox\" id=\"invpaid\" name=\"invpaid\" /><label for=\"invpaid\">";
echo $LNG["paid"];
echo "</label></span>\n\n\n\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["usertype"];
echo "</td>\n    <td class=\"fieldarea\">\n    <span><input type=\"radio\" id=\"user\" name=\"type\" value=\"0\" checked=\"checked\"/><label for=\"user\">";
echo $LNG["user"];
echo "</label></span>\n    <span><input type=\"radio\" id=\"reseller\" name=\"type\" value=\"1\" /><label for=\"reseller\">";
echo $LNG["reseller"];
echo "</label></span>\n    &nbsp;&nbsp;&nbsp;\n    <input  type=\"checkbox\" name=\"allowtransfer\" value=\"1\" id=\"allowtransfer\"/><label for=\"allowtransfer\">";
echo $LNG["allowtransfer"];
echo "</label>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["status"];
echo "</td>\n    <td class=\"fieldarea\">\n    <span><input type=\"radio\" id=\"active\" name=\"status\" value=\"0\" checked=\"checked\"/><label for=\"active\">";
echo $LNG["active"];
echo "</label></span>\n    <span><input type=\"radio\" name=\"status\" id=\"blocked\" value=\"1\" /><label for=\"blocked\">";
echo $LNG["blocked"];
echo "</label></span>\n    <span><input type=\"radio\" name=\"status\" id=\"inactive\" value=\"2\" /><label for=\"inactive\">";
echo $LNG["inactive"];
echo "</label></span>\n    </td>\n</tr>\n\n";
if (!$OnlyEcommerce) {
    echo "<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["servicesaccess"];
    echo "</td>\n    <td class=\"fieldarea\">\n";
    $services = explode(",", $config["default_service"]);
    if ($IsFileOnly) {
        echo "    <span><input type=\"checkbox\" name=\"fileaccess\" id=\"file\" value=\"1\" ";
        if ($config["default_service_file"]) {
            echo "checked";
        }
        echo "/><label for=\"file\">";
        echo $LNG["file"];
        echo "</label></span>\n";
    } else {
        echo "    <span><input type=\"checkbox\" name=\"imeiaccess\" id=\"imei\" value=\"1\" ";
        if ($config["default_service_imei"]) {
            echo "checked";
        }
        echo " /><label for=\"imei\">";
        echo $LNG["imei"];
        echo "</label></span>\n    <span><input type=\"checkbox\" name=\"fileaccess\" id=\"file\" value=\"1\" ";
        if ($config["default_service_file"]) {
            echo "checked";
        }
        echo "/><label for=\"file\">";
        echo $LNG["file"];
        echo "</label></span>\n    <span><input type=\"checkbox\" name=\"serveraccess\" id=\"server\" value=\"1\" ";
        if ($config["default_service_server"]) {
            echo "checked";
        }
        echo "/><label for=\"server\">";
        echo $LNG["server"];
        echo "</label></span>\n    <span><input type=\"checkbox\" name=\"remoteaccess\" id=\"remote\" value=\"1\" ";
        if ($config["default_service_remote"]) {
            echo "checked";
        }
        echo "/><label for=\"remote\">";
        echo $LNG["remote"];
        echo "</label></span>\n";
    }
    echo "\n</td>\n</tr>\n";
}
echo "\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["clientgroup"];
echo "</td>\n    <td class=\"fieldarea\">\n    <select name=\"clientgroup\">\n   <option value=\"0\">";
echo $LNG["default"];
echo "</option>\n   ";
$sql = dquery("select * from tbl_client_group where fee='' \norder by displayorder asc");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<option ";
    if ($row["id"] == $clientDetails["client_group"]) {
        echo "selected";
    }
    echo " value=\"";
    echo $row["id"];
    echo "\">";
    echo $row["groupname"];
    echo "</option>";
}
echo "   </select>\n    </td>\n</tr>\n\n\n\n";
if ($custom && $val["required"]) {
    echo "\n<tr>\n    <td class=\"fieldlabel\" colspan=\"2\"><strong>";
    echo $LNG["custom"];
    echo " ";
    echo $LNG["field"];
    echo "</strong></td>\n</tr>\n";
    foreach ($custom as $val) {
        if ($val["required"]) {
            echo "<tr><td class=\"fieldlabel\">";
            echo $val["name"];
            echo "</td><td class=\"fieldarea\"><span>";
            echo $val["input"];
            echo "</span></td></tr>\n";
        }
    }
}
echo "\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["language"];
echo "</td>\n    <td class=\"fieldarea\">";
echo getLanguageDropdown2();
echo "</td>\n\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["theme"];
echo "</td>\n    <td class=\"fieldarea\">\n   ";
echo getTemplatesDropDown();
echo "</td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\"><p align=\"left\"><input type=\"checkbox\" id=\"sendmail\"\n     name=\"sendmail\" checked=\"checked\"/><label for=\"sendmail\">Send this account details via email</label></p>\n</td>\n</tr>\n</table>\n\n\n</div></div>\n </div>\n\n\n<div class=\"floatright\" style=\"width:50%;\">\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Personal Information <small style=\"color: #ccc;\">[Optional]</small></span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["firstname"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"firstname\"  value=\"\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["lastname"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"lastname\"  value=\"\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["company"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"company\"  value=\"\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["address"];
echo "</td>\n    <td class=\"fieldarea\"><textarea name=\"address\"></textarea></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["address"];
echo "2</td>\n    <td class=\"fieldarea\"><textarea name=\"address2\"></textarea></td>\n</tr>\n<tr>\n\t\t<td class=\"fieldlabel\">";
echo $LNG["state"];
echo "</td>\n\t\t<td class=\"fieldarea\"><input name=\"state\"  value=\"\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["city"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"city\"  value=\"\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["zip"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"zip\"  value=\"\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["country"];
echo "</td>\n    <td class=\"fieldarea\">";
echo getCountriesDropDown();
echo "</td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["phonenumber"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"phonenumber\"  value=\"\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["newsletter"];
echo "</td>\n    <td class=\"fieldarea\">\n    <span><input type=\"radio\" id=\"newsactive\" name=\"newsletter\" value=\"1\" checked=\"checked\"/><label for=\"newsactive\">";
echo $LNG["active"];
echo "</label></span>\n    <span><input type=\"radio\" name=\"newsletter\" id=\"newsinactive\" value=\"0\"/><label for=\"newsinactive\">";
echo $LNG["inactive"];
echo "</label></span>\n    </td>\n</tr>\n</tbody>\n</table>\n  </div></div>\n</div>\n\n</td></tr></table>\n\n\n<p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["add"];
echo "\" id=\"btnaddclient\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddclient','addnewclient','#frmaddclient','#notification','true','#main_loader');\"/></p>\n</form>\n</div>\n<div class=\"clear\"></div>\n</div>\n</div></div>\n";
if (!$fusionlite && $config["wikihelp"]) {
    echo " <div class=\"help_icon\"><a href=\"https://support.dhru.com/Dhru-Fusion/article/Clients---Suppliers/?aid=29&pid=1&cid=5#add-new-client\" target=\"_blank\"><img src=\"images/help_icon.png\"/> Wiki Help</a></div> ";
}
$fileverioncheck = "6.1.0";

?>