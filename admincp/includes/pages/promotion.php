<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n";
$pageid = 445;
checkPagePermission($pageid);
echo "\n<div id=\"notification\"></div>\n<div id=\"content\" style=\"width: 100%;!important \">\n<div id=\"content_padded\" style=\"width: 100%;!important \">\n\n<form method=\"post\" id=\"frms\">\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["promotional"];
echo " ";
echo $LNG["name"];
echo "</td>\n<td class=\"fieldarea\"><input type=\"text\" id=\"names\" name=\"name\" />\n - <input type=\"text\" name=\"nos\" id=\"nos\" style=\"width: 50px;\" size=\"10\" />&nbsp;<input type=\"button\" class=\"addFromgallery\" name=\"generate\" value=\"Generate\" onclick=\"gencode()\" /> <br />\n<small>Common Name e.g. NEWYEAR - No# extension </small>  </td>\n</tr>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["promotion"];
echo " ";
echo $LNG["list"];
echo "</td>\n<td class=\"fieldarea\"><textarea name=\"code\" id=\"code\" rows=\"5\"></textarea>\n <small> ";
echo $LNG["morethanonekey"];
echo " </small></td>\n</tr>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["amount"];
echo "</td>\n<td class=\"fieldarea\"><input type=\"text\" name=\"credit\"   />\n<select name=\"type\">\n <option value=\"0\">";
echo $LNG["fixed"];
echo " ";
echo $LNG["amount"];
echo "</option>\n <option value=\"1\">";
echo $LNG["percentage"];
echo " (%)</option>\n</select></td>\n</tr>\n\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["noofuse"];
echo "</td>\n<td class=\"fieldarea\"><input type=\"text\" name=\"used\" /> <small>";
echo $LNG["noofuseinfo"];
echo "</small></td>\n</tr>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["validity"];
echo "</td>\n<td class=\"fieldarea\"><input type=\"text\" name=\"from\"  class=\"datepicker\"  autocomplete=\"off\" id=\"from\" /> ";
echo $LNG["to"];
echo " <input class=\"datepicker\"  autocomplete=\"off\"  type=\"text\" name=\"to\" id=\"to\" /></td>\n</tr>\n<tr id=\"cur\">\n<td class=\"fieldlabel\">";
echo $LNG["currency"];
echo "</td>\n<td class=\"fieldarea\">\n<select name=\"currency\">\n";
$currency = dquery("SELECT code, id FROM tbl_currencies");
while ($row = mysqli_fetch_assoc($currency)) {
    echo " <option value=\"";
    echo $row["id"];
    echo "\">";
    echo $row["code"];
    echo "</option>\n ";
}
echo "</select>\n <br /><br />\n <input type=\"checkbox\" name=\"newsignup\" value=\"1\"  id=\"newsignup\" />\n <label for=\"newsignup\">On New Signup Only</label>\n\n </td>\n</tr>\n</tbody></table>\n\n<br /><br /><br />\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["applyif"];
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table>\n<tr>\n<td valign=\"top\">\n<fieldset style=\"padding:10px\"><legend style=\"padding: 5px 10px;\"><input type='checkbox' name='applydisc' value='1' id='appe'  /> <label for='appe'>";
echo $LNG["orderexxcedsof"];
echo "</label><br>\n</legend>&nbsp;&nbsp;&nbsp;<input type='text' name='subtotal' id='subtotal'  style=\"border: #ddd solid 1px;\" /><br/></fieldset>\n</td>\n\n<td>\n<fieldset style=\"padding:10px\"><legend style=\"padding:5px 10px;\">\n<input type='checkbox' name='applyserv' value='1' id='appd'  />\n<label for='appd'>";
echo $LNG["cartcontains"];
echo "</label>\n</legend>&nbsp;&nbsp;&nbsp;\n";
if (!$OnlyEcommerce) {
    echo "<input type='text' id='imei' name='imei' style=\"border: #ddd solid 1px;\"  />\n<input type='button' name='browseimei' class=\"addFromgallery\" value='Browse IMEI'\nonclick=\"window.open('includes/pages/imeilist.php',\n\t  'windowname1',\n\t  'width=400, height=400');\n\t   return false;\" /><br/><br/>\n&nbsp;&nbsp;&nbsp;<input type='text' name='server' id='server' style=\"border: #ddd solid 1px;\"  /><input type='button' name='browseserver' class=\"addFromgallery\" value='Browse Server'\nonclick=\"window.open('includes/pages/serverlist.php',\n\t  'windowname1',\n\t  'width=400, height=400');\n\t   return false;\" /><br/><br/>\n";
}
echo "&nbsp;&nbsp;&nbsp;<input type='text' name='product' id='product' style=\"border: #ddd solid 1px;\"  /><input type='button' name='browseproduct' class=\"addFromgallery\" value='Browse Products'\nonclick=\"window.open('includes/pages/productlist.php',\n\t  'windowname1',\n\t  'width=400, height=400');\n\t   return false;\" />\n</fieldset>\n</td>\n</tr>\n</table>\n</div></div>\n\n<p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\"\nclass=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','promotion','#frms','#notification','true','#main_loader');\"/></p>\n\n</form>\n<br /><br />\n\n</div>\n</div>\n<script>\nfunction clearbuff(val){\n\tif(val=='appe'){\n\t\tdocument.getElementById('imei').value=\"\";\n\t\tdocument.getElementById('server').value=\"\";\n\t\tdocument.getElementById('product').value=\"\";\n\t}else if(val=='appd'){\n\t\tdocument.getElementById('subtotal').value=\"\";\n\t}\n}\nfunction gencode(){\n    var cnt=document.getElementById('nos').value;\n   \tvar name=document.getElementById('names').value;\nif(name && cnt)   \t{\n    var length=4;\n    var buf='';\n    var chars = '123456789ABCDEFGHIJKLMNPQRSTUVWXTZ'.split('');\n    for(var j=0;j<cnt;j++){\n\n        if (! length) {\n            length = Math.floor(Math.random() * chars.length);\n        }\n\n        var str = '';\n        for (var i = 0; i < length; i++) {\n            str += chars[Math.floor(Math.random() * chars.length)];\n        }\n          if(buf!=''){\n            buf=buf+\"\\r\\n\"+name+\"-\"+str;\n          }else { buf=name+\"-\"+str; }\n\n    }\n\n    document.getElementById('code').value=buf;\n\t}else{\n\t\talert('Promotion Name and extension should not blank');\n\t}\n}\n</script>";
$fileverioncheck = "6.1.0";

?>