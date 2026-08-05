<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n<script src=\"includes/js/jquery.ui.min.js\"></script>\n<link href=\"includes/css/ui/style.css\" rel=\"stylesheet\"/>\n<style>\n  .list{\n     background-color: #F9F9F9;\n     width: 350px;\n  }\n  .list:hover{\n     background-color: #EEEEEE;\n  }\n  #productsear, #client {\n    background: none repeat scroll 0 0 #222222;\n    position: absolute;\n}\n#productsear li, #client li {\n    border-bottom: 1px solid #666666;\n    color: #ffffff !important;\n    list-style: outside none none;\n    padding: 5px;\n    background: transparent;\n}\n#productsear li a, #client li a{\n    color:white\n}\n.selected,.selectedc{background-color: orange;}\n</style>\n<script>\n\$(document).ready(function() {\n    \$('#import').keyup(function() {\n        var vls=\$(this).val();\n                 \$.post(\"includes/pages/search.product.php\", { val: vls},function(data) {\n                 \$('#productsear').show();\n                 \$('#productsear').html(data);\n          });\n    });\n});\nfunction setVLL(val){\n    var spl;\n    spl=val.split(\"--\");\n    \$('#import').val(spl[1]);\n    \$('#hidd').val(spl[0]);\n    \$('#setthis').html('New Product Name');\n    \$('#productsear').hide();\n}\n</script>\n<script>\nfunction setthis(val){\n\tif(val!=\"\"){\n\t\tdocument.getElementById('setthis').innerHTML=\"New Product Name\";\n\t}\n}\n</script>\n";
$pageid = 361;
checkPagePermission($pageid);
include ROOTDIR . "/includes/products.fun.php";
$group = getProductGroup();
$grp = buildProductGrou(getProductGroupArray(), "", "dropdown", "groupname", $imeigroup["mid"]);
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Add Product</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\"><span id='setthis'>";
echo $LNG["productname"];
echo "</span> *</td>\n    <td class=\"fieldarea\">\n\n    <input name=\"productname\" value=\"\" type=\"text\"  class=\"txt medium\" style=\"margin-right: 200px;\"/>  <div style=\"float: right;\"> Check ";
echo $LNG["duplicate"];
echo " Product\n    <input type=\"hidden\" id=\"hidd\" name=\"hidd\" value=\"\" />\n    <input type=\"text\"  class=\"txt medium\" name=\"import\" id=\"import\" value=\"Search Product\"\n onfocus=\"if(this.value=='Search Product')value='';\"\n onblur=\"if(this.value=='')this.value='Search Product';\" />\n    <div id=\"productsear\"></div>\n\n    </div>\n\n     </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["product"];
echo " ";
echo $LNG["listedin"];
echo " ";
echo $LNG["group"];
echo "</td>\n    <td class=\"fieldarea\">\n        ";
echo $grp;
echo "   </td>\n</tr>\n<input type=\"hidden\" name=\"status\" value=\"1\" />\n<input type=\"hidden\" name=\"pos\" value=\"1\" />\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["price"];
echo " </td>\n    <td class=\"fieldarea\"><input name=\"credit\"  value=\"0\" type=\"text\"  class=\"txt small\" onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/><span class=\"preforms\">";
echo $config["base_currency"];
echo "</span></td>\n</tr>\n\n\n <tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\"><input value=\"";
echo $LNG["add"];
echo "\"\n     id=\"btnoverview\" class=\"btn save\" type=\"button\"\n      onclick=\"SubmitForm ('#btnoverview','product.addnew','#frm','#notification','true','#main_loader');\"/></td>\n</tr>\n</tbody>\n</table>\n</form> </div></div>\n\n</div></div>";
$fileverioncheck = "6.1.0";

?>