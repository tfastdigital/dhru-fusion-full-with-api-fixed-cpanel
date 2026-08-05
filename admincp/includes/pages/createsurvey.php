<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n";
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
echo "<script>\nfunction showHide(id){\n\tif(id.checked==false)\n\t{\n\t\tdocument.getElementById('customlength').style.display='none';\n\t\tdocument.getElementById('customimeiname').style.display='none';\n\t\tdocument.getElementById('customimeiinfo').style.display='none';\n\t}\n\telse\n\t{\n\t\tdocument.getElementById('customlength').style.display='table-row';\n\t\tdocument.getElementById('customimeiname').style.display='table-row';\n\t\tdocument.getElementById('customimeiinfo').style.display='table-row';\n            if(id.checked==true){\n            document.getElementById('imei').checked=false;\n        }\n\t}\n}\nfunction DeleteCustom(cid){\n    var answer = confirm('Are you sure to delete this item?');\n    if(answer)\n    {\n        DeleteItem (cid,'editimeiservice.delcustom','#frmedituser','#table_'+cid,'#notification','true','#main_loader');\n    }\n}\n\$(document).ready(function(){\n\t\$(\".toggle_container\").hide();\n\t\$(\"input.trigger\").click(function(){\n\t\t\$(this).toggleClass(\"active\").next().slideToggle(\"slow\");\n\t});\n});\n</script>\n<div id=\"notification\"></div>\n\n<div id=\"content\" style=\"width: 100%;!important \">\n<div id=\"content_padded\" style=\"width: 100%;!important \">\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Create Survey</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n\n<form method=\"post\" id=\"frms\">\n<table  class=\"form\" >\n<tbody>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["survey"];
echo " ";
echo $LNG["title"];
echo " </td>\n<td class=\"fieldarea\"><input type=\"text\"  class=\"txt medium\" name=\"title\"  /></td>\n</tr>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["survey"];
echo " ";
echo $LNG["detail"];
echo " </td>\n<td class=\"fieldarea\"><textarea class=\"txt large\" name=\"detail\"></textarea>\n</td>\n</tr>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["requiredcaptcha"];
echo " </td>\n<td class=\"fieldarea\">\n<input type=\"radio\" name=\"captcha\" value=\"1\" id=\"ec\" /> <label for=\"ec\">";
echo $LNG["yes"];
echo "</label>\n<input type=\"radio\" name=\"captcha\" value=\"0\" checked=\"checked\" id=\"ed\" /> <label for=\"ed\">";
echo $LNG["no"];
echo "</label>\n</td>\n</tr>\n\n</tbody></table>\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','survey','#frms','#notification','true','#main_loader');\"/></p>\n\n</form>\n\n</div></div>\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>