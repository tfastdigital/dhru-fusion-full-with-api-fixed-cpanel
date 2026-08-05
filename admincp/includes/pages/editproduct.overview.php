<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n<script>\n\nfunction getMyTempl(val){\n    \$.post('includes/pages/emailtempedit.php?action=imei&val='+val, function(data) {\n         \$('#editimail').html(data);\n    });\n}\nfunction getMyTempl2(val){\n    \$.post('includes/pages/emailtempedit.php?action=imei&val='+val, function(data) {\n         \$('#editimail2').html(data);\n    });\n}\n</script>\n<script>\nfunction resetDiscount(){\n    var answer = confirm('";
echo $LNG["areyousuretoresetdiscount"];
echo "');\n    if(answer)\n    {\n        SubmitForm ('#btnreset','editproduct.resetdiscount','#frm','#notification','true','#main_loader');\n    }\n}\n\nfunction showHide(id){\n\tif(id.checked==false)\n\t{\n\t\tdocument.getElementById('download').style.display='none';\n\t}\n\telse\n\t{\n\t\tdocument.getElementById('download').style.display='table-row';\n\t}\n}\n</script>\n<script language=\"JavaScript\">\nfunction newWindow(file,window)\n {msgWindow=open(file,window,'scrollbars=yes,resizable=no,width=550,height=400');\n    if (msgWindow.opener == null) msgWindow.opener = self;\n }\n</script>\n";
$pageid = 346;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/products.fun.php";
$group = getProductGroup();
$md5id = md5($id);
$productDetails = getProducts("", $md5id);
$happyhours = getProducthappyhours($id);
$grp = buildProductGrou(getProductGroupArray(), "", "dropdown", "groupname", $productDetails["group_id"]);
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<form id=\"frm\" name=\"\" method=\"post\">\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <span class=\"groupstabesheadertext\">Basic Settings</span> <span style=\"float: right;color:#ddd\">\n<a  class='default_dg_a2' href=\"javascript:load_subpage('main2.php?page=editproduct.seo&id=";
echo $id;
echo "','";
echo $LNG["seo"];
echo " ";
echo $LNG["options"];
echo "');\">  ";
echo $LNG["seo"];
echo " ";
echo $LNG["options"];
echo " </a>\n &nbsp;&nbsp;&nbsp;&nbsp;\n<a target=\"_blank\" style=\"font-weight: normal;\"\nhref=\"";
echo _url("product/" . preg_replace("/[^a-zA-Z0-9\\-]/", "", str_replace(" ", "-", $productDetails["service_name"])) . "?pid=" . $productDetails["id"], true);
echo "\">\nView as Client</a>\n</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n\n";
echo generate_token("form");
echo "\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["status"];
echo "    <small>(Do not show in Cart)</small> </td>\n    <td class=\"fieldarea\">\n    <span><input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\"  id=\"active\" name=\"status\" value=\"1\" ";
if ($productDetails["status"] == "1") {
    echo "checked";
}
echo "/><label for=\"active\"></label></span>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">POS </td>\n    <td class=\"fieldarea\">\n    <span><input type=\"checkbox\"\n    class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\"\n     id=\"actived\" name=\"pos\" value=\"1\"\n     ";
if ($productDetails["pos"] == "1") {
    echo "checked";
}
echo "/><label for=\"actived\"></label></span>\n    </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["servicename"];
echo " *</td>\n    <td class=\"fieldarea\"><input name=\"servicename\"  value=\"";
echo $productDetails["service_name"];
echo "\" type=\"text\"  class=\"txt large\"/> <span class='default_dg_a2'><a onclick=\"load_subpage('main2.php?page=editproduct.info&id=";
echo $id;
echo "','";
echo $LNG["product"];
echo " ";
echo $LNG["information"];
echo "');\">";
echo $LNG["product"];
echo " ";
echo $LNG["information"];
echo "</a></span>  <span style=\"font-weight: bold;\"><a onclick=\"load_subpage('main2.php?page=editproduct.imagelink&id=";
echo $id;
echo "','";
echo $LNG["images"] . " / " . $LNG["videos"];
echo "');\">";
echo $LNG["images"] . " / " . $LNG["videos"];
echo "</a></span></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["service"];
echo " ";
echo $LNG["listedin"];
echo " ";
echo $LNG["group"];
echo "</td>\n    <td class=\"fieldarea\">\n        ";
echo $grp;
echo "  <span><a onclick=\"load_subpage('main2.php?page=editproduct.othergroup&id=";
echo $id;
echo "','";
echo $LNG["additionalcat"];
echo "');\">";
echo $LNG["additionalcat"];
echo "</a></span>\n  <small>Products listed in these group also</small>\n\n</td>\n</tr>\n";
if ($productDetails["time"]) {
    $time = explode(" ", $productDetails["time"]);
}
echo "<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["price"];
echo " </td>\n    <td class=\"fieldarea\"><input name=\"credit\"  value=\"";
echo $productDetails["credit_admin"];
echo "\"\n     type=\"text\"  class=\"txt small\" onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/>\n    <span class=\"preforms\">";
echo $config["base_currency"];
echo "</span> &nbsp;&nbsp;&nbsp;\n    <span class=\"textgreen\" style=\"font-weight: bold;\"><a onclick=\"load_subpage('main2.php?page=editproduct.managecurrency&id=";
echo $id;
echo "','";
echo $LNG["manage"];
echo " ";
echo $LNG["other"];
echo " ";
echo $LNG["currency"];
echo "');\">";
echo $LNG["manage"];
echo " ";
echo $LNG["other"];
echo " ";
echo $LNG["currency"];
echo "</a> </span> <span style=\"font-weight: bold;\"><a onclick=\"load_subpage('main2.php?page=editproduct.wholesale&id=";
echo $id;
echo "','";
echo $LNG["wholesaleprice"];
echo "');\">";
echo $LNG["wholesaleprice"];
echo "</a></span> </td>\n</tr>\n\n<tr>\n     <td class=\"fieldlabel\">";
echo $LNG["affiliate"];
echo " ";
echo $LNG["commission"];
echo "</td>\n   <td class=\"fieldarea\">\n<input name=\"affiliate_comission\" value=\"";
echo $productDetails["affiliate_comission"];
echo "\"\ntype=\"text\"  class=\"txt small\" id=\"ret1\"/>   <span class=\"preforms\"> %</span></td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["delivery"];
echo " ";
echo $LNG["time"];
echo " </td>\n      <td class=\"fieldarea\"><input name=\"time1\"  value=\"";
echo $time[0];
echo "\" type=\"text\"  class=\"txt small\" onkeyup=\"return cFd(this,false)\" onblur=\"return cFd(this,true)\"/>\n    <select name=\"timeref\">\n        <option value=\"\">";
echo $LNG["select"];
echo "</option>\n        <option value=\"Minutes\" ";
if ($time[1] == "Minutes") {
    echo "selected";
}
echo ">";
echo $LNG["minutes"];
echo "</option>\n        <option value=\"Hours\" ";
if ($time[1] == "Hours") {
    echo "selected";
}
echo ">";
echo $LNG["hours"];
echo "</option>\n        <option value=\"Weeks\" ";
if ($time[1] == "Weeks") {
    echo "selected";
}
echo ">";
echo $LNG["weeks"];
echo "</option>\n        <option value=\"Days\" ";
if ($time[1] == "Days") {
    echo "selected";
}
echo ">";
echo $LNG["days"];
echo "</option>\n        <option value=\"Months\" ";
if ($time[1] == "Months") {
    echo "selected";
}
echo ">";
echo $LNG["months"];
echo "</option>\n        <option value=\"Instant\" ";
if ($time[1] == "Instant") {
    echo "selected";
}
echo ">";
echo $LNG["instant"];
echo "</option>\n    </select>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["tax"];
echo " Applicable</td>\n    <td class=\"fieldarea\"><input ";
if ($productDetails["taxed"] == "1") {
    echo "checked=checked";
}
echo " name=\"taxed\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" id=\"te\"/><label for=\"te\"></label></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["viewers"];
echo " </td>\n    <td class=\"fieldarea\"><input name=\"viewer\"  value=\"";
echo $productDetails["viewer"];
echo "\" type=\"text\"  class=\"txt small\"/></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["return"];
echo " ";
echo $LNG["validity"];
echo " </td>\n    <td class=\"fieldarea\"><input name=\"return_days\"  value=\"";
echo $productDetails["return_days"];
echo "\" type=\"text\"  class=\"txt small\"/> ";
echo $LNG["days"];
echo "<br />\n    <small>";
echo $LNG["return"];
echo " ";
echo $LNG["within"];
echo " ";
echo $LNG["days"];
echo " ";
echo $LNG["after"];
echo " ";
echo $LNG["shipping"];
echo "</small>\n    </td>\n\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\" >Can ";
echo $LNG["cancelorder"];
echo " ?</td>\n    <td class=\"fieldarea\">\n    <span>\n    <input type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\"  id=\"cy\" name=\"cancel\" value=\"1\" ";
if ($productDetails["usercan_cancel"] == "1") {
    echo "checked";
}
echo "/><label for=\"cy\"></label></span>\n    <small>";
echo $LNG["usercancelorder"];
echo "</small>\n    </td>\n</tr>\n<tr>\n   <td class=\"fieldlabel\"> ";
echo $LNG["custom"];
echo " html</td>\n   <td class=\"fieldarea\"><textarea name=\"customhtml\" cols=\"55\" >";
echo $productDetails["customhtml"];
echo "</textarea></td>\n</tr>\n<tr>\n   <td class=\"fieldlabel\"> ";
echo $LNG["navigation"];
echo " ";
echo $LNG["icon"];
echo "</td>\n   <td class=\"fieldarea\">\n<input type=\"text\"  class=\"txt large\" value=\"";
echo $productDetails["nav_icon"];
echo "\"\nname=\"nav_icon\" id=\"imagelink1\" />\n <input value=\"";
echo $LNG["add"];
echo " ";
echo $LNG["from"];
echo " ";
echo $LNG["gallery"];
echo "\"\n  type=\"button\" class=\"addFromgallery\" name=\"add\"\n  onclick=\"newWindow('includes/gallery.php?id=imagelink1', 'windowname1')\"/>\n   </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\"> </td>\n    <td class=\"fieldarea\"><a class='default_dg_a2' href=\"javascript:load_subpage('main2.php?page=editproduct.related&id=";
echo $id;
echo "','";
echo $LNG["related"];
echo " ";
echo $LNG["product"];
echo "')\">Related Products / Accessories</a></td>\n</tr>\n<tr>\n   <td class=\"fieldlabel\">SKU</td>\n   <td class=\"fieldarea\"><input name=\"sku\"  value=\"";
echo $productDetails["sku"];
echo "\" type=\"text\"  class=\"txt medium\"/> </td>\n</tr>\n<!--\n<tr>\n   <td class=\"fieldlabel\">EAN</td>\n   <td class=\"fieldarea\"><input name=\"ean\"  value=\"";
echo $productDetails["ean"];
echo "\" type=\"text\"  class=\"txt medium\"/> </td>\n</tr>\n-->\n</table>\n</div></div>\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Advance Settings</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n<table class=\"form\">\n<tr>\n    <td class=\"fieldlabel\">is this ";
echo $LNG["best"];
echo " ";
echo $LNG["selling"];
echo "?</td>\n   <td class=\"fieldarea\"><input ";
if ($productDetails["hot"] == "1") {
    echo "checked=checked";
}
echo "    name=\"hot\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"hot1\"/><label for=\"hot1\"></label></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["showhomepage"];
echo " ? </td>\n   <td class=\"fieldarea\"><input ";
if ($productDetails["show_onhome"] == "1") {
    echo "checked=checked";
}
echo " name=\"showhomepage\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"hote\"/><label for=\"hote\"></label></td>\n</tr>\n\n<tr>\n   <td class=\"fieldlabel\">";
echo $LNG["product"];
echo " ";
echo $LNG["review"];
echo " </td>\n   <td class=\"fieldarea\">\n   <input ";
if ($productDetails["review"] == "1") {
    echo "checked=checked";
}
echo " name=\"review\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" id=\"reve\"/><label for=\"reve\"></label></td>\n</tr>\n<tr>\n   <td class=\"fieldlabel\">";
echo $LNG["dailydeal"];
echo "</td>\n   <td class=\"fieldarea\">\n   <input ";
if ($productDetails["daily_deal"] == "1") {
    echo "checked=checked";
}
echo " name=\"daily_deal\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" id=\"deve\"/><label for=\"deve\"></label></td>\n</tr>\n<tr>\n   <td class=\"fieldlabel\">";
echo $LNG["lucky"];
echo " ";
echo $LNG["draw"];
echo "</td>\n   <td class=\"fieldarea\">\n   <input ";
if ($productDetails["draw"] == "1") {
    echo "checked=checked";
}
echo " name=\"draw\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" id=\"drwve\"/><label for=\"drwve\"></label></td>\n</tr>\n<tr>\n   <td class=\"fieldlabel\">";
echo $LNG["product"];
echo " ";
echo $LNG["condition"];
echo "</td>\n   <td class=\"fieldarea\">\n   <input ";
if ($productDetails["product_type"] == "1") {
    echo "checked=checked";
}
echo " name=\"product_type\" value=\"1\" type=\"radio\" id=\"peve\"/><label for=\"peve\">";
echo $LNG["new"];
echo "</label>\n   <input ";
if ($productDetails["product_type"] == "2") {
    echo "checked=checked";
}
echo " name=\"product_type\" value=\"2\" type=\"radio\" id=\"pevd\"/><label for=\"pevd\">";
echo $LNG["refurbished"];
echo "</label>\n   <input ";
if ($productDetails["product_type"] == "3") {
    echo "checked=checked";
}
echo " name=\"product_type\" value=\"3\" type=\"radio\" id=\"pevu\"/><label for=\"pevu\">";
echo $LNG["used"];
echo "</label></td>\n\n</tr>\n<tr>\n   <td class=\"fieldlabel\">";
echo $LNG["callfrpricing"];
echo "</td>\n   <td class=\"fieldarea\">\n   <input ";
if ($productDetails["callfrpricing"] == "1") {
    echo "checked=checked";
}
echo "    name=\"callfrpricing\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" id=\"ecp\"/><label for=\"ecp\"></label></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["availability"];
echo " ";
echo $LNG["on"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"availability_date\" id=\"to\" value=\"";
echo $productDetails["availability_date"];
echo "\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["outstockaction"];
echo "</td>\n    <td class=\"fieldarea\">\n        <select name=\"outofstock\">\n        \t<option value='0' ";
if ($productDetails["outofstock"] == 0) {
    echo "selected";
}
echo ">Buy in Advance</option>\n        \t<option value='2' ";
if ($productDetails["outofstock"] == 2) {
    echo "selected";
}
echo ">Signup for Notification</option>\n        </select>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["zeropriceaction"];
echo "</td>\n    <td class=\"fieldarea\">\n        <select name=\"zeropriceaction\">\n        \t<option value='1' ";
if ($productDetails["zeropriceaction"] == 1) {
    echo "selected";
}
echo ">Allow Add to Cart</option>\n        \t<option value='2' ";
if ($productDetails["zeropriceaction"] == 2) {
    echo "selected";
}
echo ">Don't Allow Add to Cart</option>\n        \t<option value='3' ";
if ($productDetails["zeropriceaction"] == 3) {
    echo "selected";
}
echo ">Ask Customer to Enter Price</option>\n        </select>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["minimum"];
echo " ";
echo $LNG["quantity"];
echo "</td>\n    <td class=\"fieldarea\">\n        <input type='text' class=\"txt small\" name='minqnt'  value=\"";
echo $productDetails["minqnt"];
echo "\" />\n        <small>";
echo $LNG["qntshouldbe0"];
echo "</small>\n    </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["maximum"];
echo " ";
echo $LNG["quantity"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input type='text' class=\"txt small\" name='maxqnt' value=\"";
echo $productDetails["maxqnt"];
echo "\" />\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\">\n   <input type=\"checkbox\"  ";
if ($productDetails["bundle"]) {
    echo "checked=checked";
}
echo " name=\"bundle\" value=\"1\" id=\"bn\" /><label for=\"bn\"> ";
echo $LNG["product"];
echo "  ";
echo $LNG["bundle"];
echo "</label>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\"><input type=\"checkbox\"  id=\"snw\"\n    ";
if ($productDetails["virtual"]) {
    echo "checked=checked";
}
echo " name=\"virtual\" value=\"1\"/>\n    <label for=\"snw\">Virtual product, No shipping</label>\n\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\"><input type=\"checkbox\"  onclick=\"showHide(this);\" id=\"dnw\"\n    ";
if ($productDetails["download_link"]) {
    echo "checked=checked";
}
echo " name=\"download_check\"/>\n    <label for=\"dnw\">";
echo $LNG["isthisadownloadableproduct"];
echo " or Send Link By Email </label>\n    <small>e.g. Software products are downloadable products</small>\n    </td>\n</tr>\n\n<tr id=\"download\" style=\"";
if (!$productDetails["download_link"]) {
    echo "display: none;";
}
echo "\">\n    <td class=\"fieldlabel\">";
echo $LNG["downloadlink"];
echo " </td>\n    <td class=\"fieldarea\"><input name=\"downloadlink\"\n     value=\"";
echo $productDetails["download_link"];
echo "\" type=\"text\"  class=\"txt large\" id=\"download_link\"  />\n\n     ";
echo $LNG["or"];
echo "\n     <input type=\"button\" value=\"";
echo $LNG["assign"];
echo " ";
echo $LNG["from"];
echo " ";
echo $LNG["download"];
echo "s\"\n      name=\"downloadids\" onclick=\"javascript: load_subpage('main2.php?page=downloadlist&id=";
echo $productDetails["id"];
echo "','Assing From Files')\" />\n     </td>\n</tr>\n\n";
$result = dquery("select id,title from tbl_knowledgebase");
echo "<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["related"];
echo " ";
echo $LNG["knowledgebase"];
echo " ";
echo $LNG["artical"];
echo "</td>\n    <td class=\"fieldarea\"><select name=\"faq\">\n    <option value=\"\">";
echo $LNG["select"];
echo "</option>\n";
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row["id"] == $productDetails["faq_id"]) {
            echo "<option value=" . $row["id"] . " selected>" . $row["title"] . "</option>";
        } else {
            echo "<option value=" . $row["id"] . ">" . $row["title"] . "</option>";
        }
    }
}
echo "    </select></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["new"];
echo " ";
echo $LNG["order"];
echo " ";
echo $LNG["notification"];
echo " ";
echo $LNG["to"];
echo " ";
echo $LNG["email"];
echo " </td><td class=\"fieldarea\">\n    <input name=\"notificationmail\"  value=\"";
echo $productDetails["notification_mail"];
echo "\" type=\"text\"  class=\"txt medium\"/>\n    <small>Send order notification email other than admin. If its disable then admin and other supplier will not get emails. ";
echo $LNG["email"];
echo " ";
echo $LNG["seperated"];
echo " ";
echo $LNG["by"];
echo " ";
echo $LNG["commas"];
echo "</small></td></tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["order"];
echo " ";
echo $LNG["successfull"];
echo " ";
echo $LNG["mail"];
echo " </td>\n    <td class=\"fieldarea\">\n    <select name=\"template1\" onchange=\"javascript: getMyTempl(this.value);\">\n    <option value=\"\">";
echo $LNG["select"];
echo "</option>\n    ";
$e = dquery("select * from tbl_emailtemplates where `type`='product'");
while ($row = mysqli_fetch_assoc($e)) {
    if ($productDetails["template_id1"] == $row["id"]) {
        $selected = "selected";
    } else {
        $selected = "";
    }
    if ($row["name"] != "") {
        echo "<option value='" . $row["id"] . "' " . $selected . " >" . $row["name"] . "</option>";
    }
}
echo "    </select> <span id=\"editimail\">\n    </span>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["order"];
echo " ";
echo $LNG["reject"];
echo " ";
echo $LNG["mail"];
echo "</td>\n    <td class=\"fieldarea\">\n    <select name=\"template2\" onchange=\"javascript: getMyTempl2(this.value);\">\n    <option value=\"\">";
echo $LNG["select"];
echo "</option>\n     ";
$e = dquery("select * from tbl_emailtemplates where `type`='product'");
while ($row = mysqli_fetch_assoc($e)) {
    if ($productDetails["template_id2"] == $row["id"]) {
        $selected = "selected";
    } else {
        $selected = "";
    }
    if ($row["name"] != "") {
        echo "<option value='" . $row["id"] . "' " . $selected . " >" . $row["name"] . "</option>";
    }
}
echo "    </select> <span id=\"editimail2\">\n    </span></td>\n</tr>\n";
if ($ebay) {
}
echo "<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["reset"];
echo " ";
echo $LNG["discount"];
echo "</td>\n    <td class=\"fieldarea\"><span><input value=\"";
echo $LNG["resetdiscount"];
echo "\" id=\"btnreset\" class=\"btn\" type=\"button\"  onclick=\"resetDiscount();\"/> </span></td>\n</tr>\n\n</tbody>\n</table>\n\n\n<div class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnoverview\" class=\"btn save\" type=\"button\"  onclick=\"SubmitForm ('#btnoverview','editproduct.overview','#frm','#notification','true','#main_loader');\"/>\n    ";
if ($happyhours) {
    echo "            <div style=\"position: absolute;left:40%;top:10px;color:green;font-weight: bold;\">";
    echo $LNG["serviceunderhappyhours"];
    echo "</div>\n        ";
}
echo "\n    <input style=\"float: right;\" onclick=\"load_subpage ('main2.php?page=editproduct.remove&id=";
echo $id;
echo "','";
echo $LNG["remove"];
echo " ";
echo $LNG["service"];
echo "' );\" id=\"btnoverview\" name=\"delete\" class=\"button_remove\" value=\"Remove Service\"  type=\"button\"/>\n</div>\n\n</div></div>\n\n</form>\n\n</div></div>\n<div id=\"page_info\" class=\"page_info\">\n\t<li>This page allows you to update service details</li>\n\t<li>Verification and cancel order set the order verification and order cancelation after place order from user</li>\n</div>\t";
$fileverioncheck = "6.1.0";

?>