<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once "includes/fun.inc.php";
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
include_once ROOTDIR . "/includes/products.fun.php";
$md5id = md5($id);
if (isset($save)) {
    foreach ($gid as $k => $v) {
        $selgatway .= "," . $k;
    }
    $selgatway = trim($selgatway, ",");
    dquery("update tbl_products set othergroup='" . $selgatway . "' where id='" . $id . "'");
    echo "<div id='notification1'  class='successbox'>" . $LNG["datasavesuccessfully"] . "</div><br>";
}
$productDetails = getProducts("", $md5id);
$grp = buildProductGrou(getProductGroupArray(), "", "checkbox", "groupname", explode(",", $productDetails["othergroup"]));
echo "<style>\n    .rightalign {\n        text-align: left !important;\n    }\n</style>\n\n<script language=\"JavaScript\" type=\"text/javascript\">\nfunction loopSelected()\n{\n  var txtSelectedValuesObj = document.getElementById('selgatway');\n  var selectedArray = new Array();\n  var selObj = document.getElementById('gatway');\n  var i;\n  var count = 0;\n  for (i=0; i<selObj.options.length; i++) {\n        if (selObj.options[i].selected) {\n          selectedArray[count] = selObj.options[i].value;\n          count++;\n        }\n  }\n  txtSelectedValuesObj.value = selectedArray;\n}\n</script>\n\n<form id=\"frmnetwork\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n\n<div align=\"center\">\n<table id=\"main_tbl\">\n<tbody>\n";
echo $grp;
echo "</tbody></table>\n</div>\n \n<p class=\"fixedbtn\"><input name=\"save\" value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"btn save\" type=\"submit\" /></p>\n\n</form>\n<br /><br /> \n";
$fileverioncheck = "6.1.0";

?>