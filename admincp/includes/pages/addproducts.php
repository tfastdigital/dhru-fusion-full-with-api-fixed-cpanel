<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>    \n.form{margin-bottom: 4px !important;}\n</style> \n\n<style>\n  .list{\n     background-color: #F9F9F9;\n     width: 350px;\n  }\n  .list:hover{\n     background-color: #EEEEEE;\n  }\n</style>\n<script>\n\n\$(document).ready(function() {\n    \$('#import').keyup(function() {\n         var vls=\$(this).val();\n         \$.post(\"includes/pages/search.product.php\", { val: vls},function(data) {\n                 \$('#productsear').show();\n                 \$('#productsear').html(data);\n          });\n    });\n});\nfunction setVLL(val){\n    var spl;\n    spl=val.split(\"--\");    \n    \$('#import').val(spl[1]);\n    \$('#hidd').val(spl[0]);\n    \$('#setthis').html('New Product Name');\n    \$('#productsear').hide();\n}\n</script>\n<script>\nfunction setthis(val){\n\tif(val!=\"\"){\n\t\tdocument.getElementById('setthis').innerHTML=\"New Product Name\";\n\t}\n}\n</script>\n";
$pageid = 361;
checkPagePermission($pageid);
include ROOTDIR . "/includes/products.fun.php";
$group = getProductGroup();
$grp = buildProductGrou(getProductGroupArray(), "", "dropdown", "groupname", $imeigroup["mid"]);
echo " \n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Add Product</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n  \n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\"><span id='setthis'>";
echo $LNG["productname"];
echo "</span> *</td>\n    <td class=\"fieldarea\"><input name=\"productname\"  value=\"\" type=\"text\"  class=\"txt long\"/>\n     </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["product"];
echo " ";
echo $LNG["listedin"];
echo " ";
echo $LNG["group"];
echo "</td>\n    <td class=\"fieldarea\">\n        ";
echo $grp;
echo "             \n   </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["price"];
echo " </td>\n    <td class=\"fieldarea\"><input name=\"credit\"  value=\"0\" type=\"text\"  class=\"txt small\" \n    onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/>\n    <span class=\"preforms\">";
echo $config["base_currency"];
echo "</span></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["description"];
echo "</td>\n    <td class=\"fieldarea\"><textarea name=\"retail_info\"></textarea></td>\n</tr>\n <tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\"><input value=\"";
echo $LNG["add"];
echo "\" id=\"btnoverview\" \n    class=\"btn save\" type=\"button\"  \n    onclick=\"SubmitForm ('#btnoverview','addproducts','#frm','#notification','true','#main_loader');\"/></td>\n</tr>\n</tbody>\n</table>\n</form> </div></div>\n\n \n</div></div>\n";
$fileverioncheck = "6.1.0";

?>