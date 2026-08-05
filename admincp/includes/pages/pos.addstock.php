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
error_reporting(0);
if (!$s) {
    echo "<ul id=\"tabmenu\">\n<li><a ";
    if (!$loaddefault) {
        echo " class='tabmenu_active' ";
    }
    echo "onclick=\"getContect('#tab','main2.php?page=pos.addstock&s=ok','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\">";
    echo $LNG["add"];
    echo " ";
    echo $LNG["stock"];
    echo "</a></li>\n<li><a ";
    if ($loaddefault) {
        echo " class='tabmenu_active' ";
    }
    echo "onclick=\"getContect('#tab1','main2.php?page=pos.stockhistory','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\">";
    echo $LNG["stock"];
    echo " ";
    echo $LNG["history"];
    echo "</a></li>\n<div style=\"clear: both;\"></div>\n</ul>\n\n<div id=\"tabcontent\">\n";
}
dquery("ALTER TABLE `tbl_warehousestock` ADD `notes` TEXT NOT NULL");
$sql = mysqli_fetch_assoc(dquery("select service_name,bysupplier from tbl_products where id='" . $id . "'"));
echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n\n<script>\nfunction checkQnt()\n{\n    var ser=\$(\"#serial\").val();\n    ns=ser.split(\"\\n\");\n    if(ns.length>1 && \$(\"#qnt\").val()>1){\n        alert(\"Only one serial number allowed for quantity\");\n        return false;\n    }else{\n        return true;\n    }\n}\n\n\n</script>\n<script>\nfunction checkSer(){\n if(document.getElementById('serial').value!=''){\n    alert('Dont add stock while serial numbers added')\n   document.getElementById('stock').value='';\n }\n}\n</script>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $sql["service_name"];
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"pid\" value=\"";
echo $id;
echo "\" />\n";
echo generate_token("form");
echo "\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" style=\"min-width: 48%;\" >\n<tbody>\n\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["serialno"];
echo "</td>\n    <td class=\"fieldarea\">\n     <textarea cols=\"25\" name=\"serial\" id=\"serial\" rows=\"3\"></textarea>\n    </td>\n</tr>\n\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["qnt"];
echo "</td>\n    <td class=\"fieldarea\">\n        <input type=\"text\" name=\"qnt\" value=\"1\" id=\"qnt\" />\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["supplier"];
echo " </td>\n    <td class=\"fieldarea\">\n        <select name=\"sid\">\n        ";
$sup = dquery("select id,username from tbl_supplier");
while ($row = mysqli_fetch_assoc($sup)) {
    echo "<option ";
    if ($sql["bysupplier"] == $row["id"]) {
        echo "selected='selected'";
    }
    echo " value=\"";
    echo $row["id"];
    echo "\">";
    echo $row["username"];
    echo "</option>\n        ";
}
echo "        </select>\n\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["warehouse"];
echo " </td>\n    <td class=\"fieldarea\">\n        <select name=\"wid\">\n        ";
$sup = dquery("select * from tbl_warehouse");
while ($row = mysqli_fetch_assoc($sup)) {
    echo "<option ";
    if ($_SESSION["admwid"] == $row["id"]) {
        echo "selected";
    }
    echo " value=\"";
    echo $row["id"];
    echo "\">";
    echo $row["name"];
    echo "</option>\n        ";
}
echo "        </select>\n    </td>\n</tr>\n\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["stock"];
echo " ";
echo $LNG["date"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input type=\"text\"  class=\"txt medium datepicker\"  autocomplete=\"off\" name=\"date\"    value=\"";
echo date("Y-m-d");
echo "\" id=\"to\" />\n    </td>\n</tr>\n\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["bill"];
echo " ";
echo $LNG["date"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input type=\"text\"  class=\"txt medium datepicker\"  autocomplete=\"off\" name=\"bill_date\"    value=\"";
echo date("Y-m-d");
echo "\" id=\"from\" />\n    </td>\n</tr>\n\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["bill"];
echo " ";
echo $LNG["no"];
echo ".</td>\n    <td class=\"fieldarea\">\n    <input type=\"text\"  class=\"txt medium\" name=\"bill_no\"    value=\"\" />\n    </td>\n</tr>\n\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["note"];
echo "</td>\n    <td class=\"fieldarea\">\n        <textarea name=\"note\" class=\"textarea large\"></textarea>\n    </td>\n</tr>\n\n\n<tr>\n    <td  class=\"fieldlabel\">&nbsp;</td>\n    <td class=\"fieldarea\">\n<input value=\"+ ";
echo $LNG["add"];
echo " ";
echo $LNG["stock"];
echo "\" id=\"btnaddgroup\"\nclass=\"btn save\" type=\"button\"\nonclick=\"\nif(checkQnt()){\n\nSubmitForm ('#btnaddgroup','pos.addstock','#frm','#notification','true','#main_loader');\n\n}\n\"/>\n\n\n    </td>\n</tr>\n\n</tbody>\n</table>\n\n\n\n</form>\n</div></div>\n\n\n</div></div>\n";
if (!$s) {
    echo "</div>\n";
}
$fileverioncheck = "6.1.0";

?>