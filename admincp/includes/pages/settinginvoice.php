<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n";
require ROOTDIR . "/includes/countries.php";
if ($invoice) {
    echo "<ul id=\"tabmenu\">\n    <li><a onclick=\"getContect('#tab','main2.php?page=settinggeneral','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
    echo $LNG["general"];
    echo "</a></li>\n    <li><a onclick=\"getContect('#tab2','main2.php?page=settingregistration','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
    echo $LNG["registration"];
    echo " / " . $LNG["profile"];
    echo "</a></li>\n    <li><a onclick=\"getContect('#tab3','main2.php?page=settinglocalisation','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
    echo $LNG["localisation"];
    echo "</a></li>\n    <li><a class='tabmenu_active'  onclick=\"getContect('#tab5','main2.php?page=settinginvoice','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab5\" >";
    echo $LNG["tax"];
    echo "</a></li>\n    <li><a onclick=\"getContect('#tab7','main2.php?page=settingorder','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab7\" >";
    echo $LNG["orders"];
    echo "</a></li>\n    <li><a onclick=\"getContect('#tab9','main2.php?page=recentmenu','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab9\" >";
    echo $LNG["quick"];
    echo " ";
    echo $LNG["access"];
    echo " ";
    echo $LNG["menu"];
    echo "</a></li>\n    <li><a onclick=\"getContect('#tab8','main2.php?page=settingappear','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab8\" >";
    echo $LNG["appearance"];
    echo "</a></li>\n    <li><a onclick=\"getContect('#tab11','main2.php?page=settingother','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab11\" >";
    echo $LNG["other"];
    echo "</a></li>\n<div style=\"clear: both;\"></div>\n</ul>\n<div id=\"tabcontent\">\n    ";
}
$pageid = 201;
checkPagePermission($pageid);
$sql = mysqli_fetch_assoc(dquery("select * from tbl_settings where attribute='config'"));
$config = unserialize($sql["value"]);
if ($id && $invoice) {
    dquery("delete from tbl_tax where id='" . $id . "'");
    echo "<div id='notification1' class='successbox'>" . $LNG["datadeletesuccessfully"] . "</div>";
}
echo "\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "\n<div   class=\"groupstabes first\" >\n      <h2>\n        <span class=\"groupstabesheadertext\">";
echo $LNG["tax"];
echo " ";
echo $LNG["settings"];
echo "</span>\n      </h2>\n      <div class=\"groupstabescontant\">\n\n<table class=\"form\">\n\n<tr>\n    <td   class=\"fieldlabel\">";
echo $LNG["taxapplicable"];
echo " </td>\n    <td class=\"fieldarea\">\n    <input type='checkbox' class=\"onoff {labelOn: 'Enable', labelOff: 'Disable', easing: 'easeOutBounce', duration: 500}\" name=\"taxenabled\" value=\"1\" id=\"hs\" ";
if ($config["taxenabled"]) {
    echo "checked";
}
echo " />\n    </td>\n</tr>\n</table>\n\n<table  border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\" class=\"form hs\">\n<tbody>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["tax"];
echo " ";
echo $LNG["type"];
echo "</td>\n    <td class=\"fieldarea\">\n  <input type='radio' name=\"taxtype\" value=\"Inclusive\" id=\"inc\" ";
if ($config["taxtype"] == "Inclusive") {
    echo "checked";
}
echo " />  <label for=\"inc\">Inclusive</label>\n  <input type='radio' name=\"taxtype\" value=\"Exclusive\" id=\"inc2\" ";
if ($config["taxtype"] == "Exclusive") {
    echo "checked";
}
echo " />  <label for=\"inc2\">Exclusive</label>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["invoicepayto"];
echo "  </td>\n    <td class=\"fieldarea\">\n    <textarea name=\"invoicepayto\" class=\"textarea large\"\n    style=\"height: 100px;\">";
echo $config["invoicepayto"];
echo "</textarea></td>\n</tr>\n\n</tbody>\n</table>\n<p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','invoicesetting','#frm','#notification','true','#main_loader');\"/>\n\n       </p>\n\n\n</div>\n</div>\n\n</form>\n\n<form id=\"addtax\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<div id=\"accountinfo1\" class=\"groupstabes hs\" >\n      <h2>\n        <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n        <span class=\"groupstabesheadertext\">";
echo $LNG["tax"];
echo " ";
echo $LNG["list"];
echo " </span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n      </h2>\n      <div class=\"groupstabescontant\">\n\n\n\n\n\n<table id=\"main_tbl\" >\n    <thead>\n      <tr>\n        <th>";
echo $LNG["taxname"];
echo "</th>\n        <th><div align=\"left\">";
echo $LNG["level"];
echo "</div> </th>\n        <th><div align=\"left\">";
echo $LNG["state"];
echo "</div> </th>\n        <th><div align=\"left\">";
echo $LNG["country"];
echo "</div> </th>\n        <th><div align=\"left\">";
echo $LNG["gateway"];
echo "</div> </th>\n        <th><div align=\"left\">";
echo $LNG["tax"];
echo " (%)</div> </th>\n        <th><div align=\"left\">";
echo $LNG["fixedcharge"];
echo "</div> </th>\n        <th><div align=\"right\">";
echo $LNG["action"];
echo "</div> </th>\n      </tr>\n    </thead>\n    <tbody>\n\n\n\n\n   <tr class=\"adddatarow\">\n    <td><input type=\"text\" name=\"taxname\" value=\"\" class=\"txt\"/> </td>\n       <td>\n            <select name=\"level\">\n                <option value=\"1\">1</option>\n                <option value=\"2\">2</option>\n            </select>\n        </td>\n       <td><input type=\"text\" name=\"state\" value=\"\" class=\"txt\"/><br /><small>";
echo $LNG["leaveblankforall"];
echo " ";
echo $LNG["state"];
echo "</small> </td>\n       <td> ";
echo getCountriesDropDown("", "country", "", $LNG["all"] . " " . $LNG["country"]);
echo "</td>\n       <td>\n        <select name='gateway'>\n    \t   <option value=''>";
echo $LNG["all"];
echo " ";
echo $LNG["gateway"];
echo "</option>\n            ";
$sql = dquery("select * from tbl_paymentgateways where setting='name' group by gateway");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "        \t\t<option value=\"";
    echo $row["gateway"];
    echo "\">";
    echo $row["value"];
    echo "</option>\n        \t";
}
echo "            </select>\n       </td>\n       <td><input type=\"text\" name=\"taxrate\" class=\"txt\"/></td>\n       <td><input type=\"text\"  name=\"fixedcharge\" class=\"text-200\"/></td>\n       <td><input value=\"+ ";
echo $LNG["add"];
echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','invoicetax','#addtax','#notification','true','#main_loader','main2.php?page=settinginvoice');\"/></td>\n   </tr>\n";
$sql = dquery("select *,(select value from tbl_paymentgateways \nWHERE gateway=tbl_tax.gateway and setting='name') as gats from tbl_tax");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "    <tr>\n    <td  style=\"cursor: pointer\" onclick=\"load_subpage('main2.php?page=edittax&id=";
    echo $row["id"];
    echo "', '";
    echo $LNG["edit"];
    echo "');\">";
    echo $row["name"];
    echo "</td>\n    <td>";
    echo $row["level"];
    echo "</td>\n    <td>";
    if ($row["state"]) {
        echo $row["state"];
    } else {
        echo "All State";
    }
    echo "</td>\n    <td>";
    if ($row["country"]) {
        echo $countries[$row["country"]];
    } else {
        echo "All Country";
    }
    echo "</td>\n    <td>";
    if ($row["gateway"]) {
        echo $row["gats"];
    } else {
        echo "All Gateway";
    }
    echo "</td>\n    <td>";
    echo $row["taxrate"];
    echo "</td>\n    <td>";
    echo $row["fixedcharge"];
    echo "</td>\n    <td align=\"right\" class=\"action\"><a href=\"javascript: void(0)\"\n    onclick=\"load_subpage('main2.php?page=edittax&id=";
    echo $row["id"];
    echo "', '";
    echo $LNG["edit"];
    echo "');\n      return false;\" class=\"editdata\">";
    echo $LNG["edit"];
    echo "</a>\n     <a onclick=\"return confirm('Are you sure want to remove Tax Rule?');\"  href=\"javascript:reloadcurrent('settinginvoice','";
    echo $row["id"];
    echo "&invoice=true')\" class=\"deletedata\">";
    echo $LNG["delete"];
    echo "</a></td>\n    </tr>\n";
}
echo "</form>\n    </tbody>\n</table>\n</div></div>\n</div>\n</div>\n ";
if ($invoice) {
    echo "    </div>\n";
}
echo "    ";
$fileverioncheck = "6.1.0";

?>