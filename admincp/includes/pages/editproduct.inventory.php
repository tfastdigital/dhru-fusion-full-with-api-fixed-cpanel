<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 348;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/products.fun.php";
$md5id = md5($id);
$productDetails = getProducts("", $md5id);
$cstock = mysqli_num_rows(dquery("select *,(select name from tbl_warehouse where id=wid)\nas warehouse ,(select username from tbl_admin where id=aid) as admin\nfrom tbl_serial_list where pid='" . $id . "' and transist='' and status=0"));
echo " \n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\"> \n<form id=\"frmedituser\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Stock</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n  \n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n     <td class=\"fieldlabel\">";
echo $LNG["purchase"];
echo " ";
echo $LNG["cost"];
echo " ";
echo $LNG["perunit"];
echo "</td>\n   <td class=\"fieldarea\"><input type=\"text\"  class=\"txt small\" disabled=\"true\" value=\"";
echo $productDetails["purchase_cost"];
echo "\" name=\"purchasecost\" onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/> <span class=\"preforms\">";
echo $config["base_currency"];
echo "</span> &nbsp;&nbsp;&nbsp;   <span><a href=\"javascript: load_subpage('main2.php?page=editproduct.purchasecost&id=";
echo $productDetails["id"];
echo "','Purhcase Cost');\">";
echo $LNG["set"];
echo " ";
echo $LNG["pricing"];
echo "</a></span></td> \n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["current"];
echo " ";
echo $LNG["stock"];
echo "</td>\n   <td class=\"fieldarea\"><input type=\"text\"  class=\"txt small\" disabled=\"\" \n   value=\"";
echo $cstock;
echo "\" name=\"currentstock\" onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/>\n&nbsp;   \n <span><a onclick=\"load_subpage('main2.php?page=pos.addstock&id=";
echo $productDetails["id"];
echo "','";
echo $LNG["add"];
echo " ";
echo $LNG["stock"];
echo "');\"> + ";
echo $LNG["add"];
echo " ";
echo $LNG["stock"];
echo "</a></span>\n &nbsp;|&nbsp;&nbsp; \n <span><a onclick=\"load_subpage('main2.php?page=stock&id=";
echo $productDetails["id"];
echo "','View Detail Stock');\" >View Stock</a></span>\n   </td> \n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["stock"];
echo " ";
echo $LNG["calculation"];
echo "</td>\n   <td class=\"fieldarea\"><input ";
if ($productDetails["stock_allow"] == "1") {
    echo "checked=checked";
}
echo " name=\"calculation\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" id=\"calculation1\"/><label for=\"calculation1\"></label></td> \n</tr>\n";
if ($productDetails["stock_allow"] == "1") {
    echo "<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["reorder"];
    echo " </td>\n   <td class=\"fieldarea\">\n   <input type=\"text\"  class=\"txt medium\"  value=\"";
    echo $productDetails["reorder_level"];
    echo "\" name=\"reorder_level\" onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/>\n   <br /><small>When your quantity lower than reorder level system will notify you.</small>\n   </td> \n</tr>\n";
}
echo "<tr>\n   <td class=\"fieldlabel\">";
echo $LNG["supplier"];
echo "</td>\n   <td class=\"fieldarea\">\n   <select name=\"bysupplier\">\n   <option>";
echo $LNG["select"];
echo "</option>\n   ";
$result = dquery("select id,username from tbl_supplier");
while ($row = mysqli_fetch_assoc($result)) {
    if ($productDetails["bysupplier"] == $row["id"]) {
        echo "<option value=" . $row["id"] . " selected>" . $row["username"] . "</option>";
    } else {
        echo "<option value=" . $row["id"] . " >" . $row["username"] . "</option>";
    }
}
echo "   </select> </td> \n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["manufacture"];
echo "</td>\n   <td class=\"fieldarea\"><select name=\"manufacture\"><option>";
echo $LNG["select"];
echo "</option>\n   ";
$result = dquery("select * from tbl_manufacture");
while ($row = mysqli_fetch_assoc($result)) {
    if ($productDetails["manufacture_id"] == $row["id"]) {
        echo "<option value=" . $row["id"] . " selected>" . $row["name"] . "</option>";
    } else {
        echo "<option value=" . $row["id"] . ">" . $row["name"] . "</option>";
    }
}
echo "   </select> <a class=\"default_dg_a2\" href=\"javascript:load_subpage('main2.php?page=manufacturewarehouse','Edit')\">";
echo $LNG["edit"];
echo " ";
echo $LNG["manufacture"];
echo "</a> </td> \n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["warehouse"];
echo "</td>\n   <td class=\"fieldarea\"><select name=\"warehouse\"><option>";
echo $LNG["select"];
echo "</option>\n   ";
$result = dquery("select * from tbl_warehouse");
while ($row1 = mysqli_fetch_assoc($result)) {
    if ($productDetails["warehouse_id"] == $row1["id"]) {
        echo "<option value=" . $row1["id"] . " selected>" . $row1["name"] . " [" . $row1["country"] . "]</option>";
    } else {
        echo "<option value=" . $row1["id"] . ">" . $row1["name"] . " [" . $row1["country"] . "]</option>";
    }
}
echo "   </select> <a class=\"default_dg_a2\" href=\"javascript:load_subpage('main2.php?page=manufacturewarehouse','Edit')\">";
echo $LNG["edit"];
echo " ";
echo $LNG["warehouse"];
echo "</a></td> \n</tr>\n</tbody>\n</table>\n\n</div></div>\n<p  class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnedituser','editproduct.inventory','#frmedituser','#notification','true','#main_loader');\"/></p>\n\n</form>\n\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>