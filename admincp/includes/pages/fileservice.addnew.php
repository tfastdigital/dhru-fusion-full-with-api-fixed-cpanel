<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n";
$pageid = 163;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/fileservices.fun.php";
$group = getFileServiceGroup();
echo "<script>\nfunction setthis(val){\n\tif(val!=\"\"){\n\t\tdocument.getElementById('setthis').innerHTML=\"New Service Name\";\n\t}\n}\n</script>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Add New Serice</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\"><span id='setthis'>";
echo $LNG["servicename"];
echo "</span> *</td>\n    <td class=\"fieldarea\"><input name=\"servicename\"  value=\"\" type=\"text\"  class=\"txt medium\"/>\n &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\t";
echo $LNG["duplicate"];
echo "    <select name=\"import\" onchange=\"setthis(this.value);\">\n    \t<option value=\"\">";
echo $LNG["select"];
echo "</option>\n    \t";
$sql = dquery("select id,service_name from tbl_services_file");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<option value='" . $row["id"] . "'>" . $row["service_name"] . "</option>";
}
echo "    </select>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["service"];
echo " ";
echo $LNG["listedin"];
echo " ";
echo $LNG["group"];
echo "</td>\n    <td class=\"fieldarea\"><select name=\"groupname\">\n        ";
foreach ($group as $key => $value) {
    $value = $group[$key]["name"];
    if ($group[$key]["active"] == 0) {
        echo "<option value=" . $key . " class=textred>" . $value . "    (<font style=font-style: italic;>Inactive</font>)</option>";
    } else {
        echo "<option value=" . $key . ">" . $value . "</option>";
    }
}
echo "    </select>\n     &nbsp; <a href=\"#\" data-target=\"addfilegroup\" data-target-header=\"";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["group"];
echo "\" onclick=\"AddnewInpopup(this);\">";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["group"];
echo "</a>\n     </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["status"];
echo "</td>\n    <td class=\"fieldarea\">\n    <span><input type=\"checkbox\" class=\"onoff {labelOn: 'Active', labelOff: 'Inactive'}\" id=\"active\" name=\"status\" value=\"1\" checked=\"checked\"/><label for=\"active\"></label></span>\n    </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["sendforverification"];
echo "</td>\n    <td class=\"fieldarea\">\n    <span><input type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"vy\" name=\"verification\" value=\"1\" checked=\"checked\"/><label for=\"vy\"></label></span>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["usercancancelorder"];
echo "</td>\n    <td class=\"fieldarea\">\n    <span><input type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"cy\" name=\"cancel\" value=\"1\" checked=\"checked\"/><label for=\"cy\"></label></span>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["reply"];
echo " ";
echo $LNG["type"];
echo "</td>\n    <td class=\"fieldarea\">\n    <span><input type=\"checkbox\" class=\"onoff {labelOn: 'File', labelOff: 'Text'}\" id=\"vty\" name=\"replytype\" value=\"1\" checked=\"checked\"/><label for=\"vty\"></label></span>\n    </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["delivery"];
echo " ";
echo $LNG["time"];
echo " </td>\n    <td class=\"fieldarea\"><input name=\"time1\"  value=\"\" type=\"text\"  class=\"txt small\" onkeyup=\"return cFd(this,false)\" onblur=\"return cFd(this,true)\"/>\n    <select name=\"timeref\">\n        <option value=\"Minutes\">";
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
echo "</label></td>\n</tr>\n\n</tbody>\n</table>\n\n\n<p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["add"];
echo "\" id=\"btnoverview\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnoverview','fileservice.addnew','#frm','#notification','true','#main_loader');\"/> </p>\n</div></div>\n</form>\n</div></div>\n ";
$fileverioncheck = "6.1.0";

?>