<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n<script>\nfunction showHide(id){\n\tif(id.checked==false)\n\t{\n\t\tdocument.getElementById('customlength').style.display='none';\n\t\tdocument.getElementById('customimeiname').style.display='none';\n\t\tdocument.getElementById('customimeiinfo').style.display='none';\n\t}\n\telse\n\t{\n\t\tdocument.getElementById('customlength').style.display='table-row';\n\t\tdocument.getElementById('customimeiname').style.display='table-row';\n\t\tdocument.getElementById('customimeiinfo').style.display='table-row';\n\t}\n}\nfunction DeleteCustom(cid){\n    var answer = confirm('Are you sure to delete this item?');\n    if(answer)\n    {\n        DeleteItem (cid,'editimeiservice.delcustom','#frmedituser','#table_'+cid,'#notification','true','#main_loader');\n    }\n}\n\$(document).ready(function(){\n\t\$(\".toggle_container\").hide();\n\t\$(\"input.trigger\").click(function(){\n\t\t\$(this).toggleClass(\"active\").next().slideToggle(\"slow\");\n\t});\n});\n</script>\n\n";
$pageid = 348;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/products.fun.php";
$md5id = md5($id);
$productDetails = getProducts("", $md5id);
$height = explode(" ", $productDetails["height"]);
$depth = explode(" ", $productDetails["depth"]);
$width = explode(" ", $productDetails["width"]);
include_once ROOTDIR . "/includes/features.fun.php";
$qp = mysqli_fetch_assoc(dquery("select id from tbl_featuresvalues limit 1"));
if (!$qp["id"]) {
    dquery("ALTER TABLE `tbl_featuresvalues` \n        ADD `id` INT(11)\n     NOT NULL AUTO_INCREMENT PRIMARY KEY AFTER `value`");
}
echo "\n";
$mid = getMasterGroup($productDetails["group_id"]);
if ($addnew) {
    foreach ($customfield as $key => $value) {
        if (!$customfield[$key]["required"]) {
            $customfield[$key]["required"] = "";
        }
    }
    if (!$customfield[-1]["fieldname"]) {
        unset($customfield[-1]);
    }
    saveFeaturesServicewise($key, $customfield);
    echo "<div id='notification1' class='successbox'>" . $LNG["datasavesuccessfully"] . " <br /> (You can manage this feature by go Settings -> Product Features)  </div>";
}
echo "\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n\n\n<div style=\"float: left;width:49%\">\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Weight and Dimension</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["weight"];
echo "</td>\n<td class=\"fieldarea\"><input type=\"text\"  class=\"txt small\" value=\"";
echo $productDetails["weight"];
echo "\"  name=\"weight\" onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/> ";
echo $LNG["kg"];
echo "</td>\n</tr>\n\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["height"];
echo "</td>\n<td class=\"fieldarea\"><input type=\"text\"  class=\"txt small\" value=\"";
echo $height[0];
echo "\"\n     name=\"height\" onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/>\n                                         <select name=\"unit\" style=\"width: 70px;\">\n                                         <option ";
if ($height[1] == "Inch") {
    echo "selected";
}
echo ">";
echo $LNG["inch"];
echo "</option>\n                                        <option ";
if ($height[1] == "cm") {
    echo "selected";
}
echo ">";
echo $LNG["cm"];
echo "</option>\n                                        <option ";
if ($height[1] == "mm") {
    echo "selected";
}
echo ">";
echo $LNG["mm"];
echo "</option>\n                                        </select></td>\n</tr>\n\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["depth"];
echo "</td>\n<td class=\"fieldarea\"><input type=\"text\"  class=\"txt small\" value=\"";
echo $depth[0];
echo "\"   name=\"depth\"\n    onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/>\n<select name=\"unit1\" style=\"width: 70px;\">\n<option ";
if ($depth[1] == "Inch") {
    echo "selected";
}
echo ">";
echo $LNG["inch"];
echo "</option>\n<option ";
if ($depth[1] == "cm") {
    echo "selected";
}
echo ">";
echo $LNG["cm"];
echo "</option>\n<option ";
if ($depth[1] == "mm") {
    echo "selected";
}
echo ">";
echo $LNG["mm"];
echo "</option>\n</select></td>\n</tr>\n\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["width"];
echo "</td>\n<td class=\"fieldarea\"><input type=\"text\"  class=\"txt small\" value=\"";
echo $width[0];
echo "\"    name=\"width\"\nonkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/>\n<select name=\"unit2\" style=\"width: 70px;\">\n<option ";
if ($width[1] == "Inch") {
    echo "selected";
}
echo ">";
echo $LNG["inch"];
echo "</option>\n<option ";
if ($width[1] == "cm") {
    echo "selected";
}
echo ">";
echo $LNG["cm"];
echo "</option>\n<option ";
if ($width[1] == "mm") {
    echo "selected";
}
echo ">";
echo $LNG["mm"];
echo "</option>\n</select></td>\n</tr>\n\n<tr>\n<td class=\"fieldlabel\"></td>\n<td class=\"fieldarea\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"btn save\" type=\"button\"  onclick=\"SubmitForm ('#btnedituser','editproduct.features','#frmedituser','#notification','true','#main_loader');\"/></td>\n</tr>\n\n</tbody>\n</table>\n<div>\n    ";
echo $LNG["note"];
echo " : ";
echo $LNG["unitsusedforshippincost"];
echo "</div>\n</form>\n</div></div>\n</div>\n\n<script>\nfunction getOther(val){\n\tif(val=='Other'){\n\t\t\tdocument.getElementById('otherformat').style.display='';\n\t}else{\n\t\t    document.getElementById('otherformat').style.display='none';\n\t}\n}\nfunction getOther3(val){\n\tif(val=='Other'){\n\t\t\tdocument.getElementById('otheraudio_format').style.display='';\n\t}else{\n\t\t    document.getElementById('otheraudio_format').style.display='none';\n\t}\n}\nfunction QuickIn(val){\n    /*\n    if(val!='text'){\n        \$('.qif').hide();\n    }else{\n        \$('.qif').show();\n    }\n    */\n}\n</script>\n<div style=\"float: right;width:49%\">\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Types</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n<form id=\"frmforat\" name=\"\" method=\"post\">";
echo generate_token("form");
echo "<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<input type='hidden' name='formats' value='1' />\n\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["format"];
echo "</td>\n<td class=\"fieldarea\">\n <select name='format' onchange=\"getOther(this.value)\" >\n \t<option value=\"\">";
echo $LNG["select"];
echo "</option>\n \t<option value=\"Other\">Other</option>\n \t";
$sql = dquery("select DISTINCT format FROM tbl_products WHERE format!=''");
while ($row = mysqli_fetch_assoc($sql)) {
    echo " \t<option ";
    if ($productDetails["format"] == $row["format"]) {
        echo "selected";
    }
    echo " value=\"";
    echo $row["format"];
    echo "\">";
    echo $row["format"];
    echo "</option>\n \t";
}
echo " </select>\n <input type='text' name='otherformat' id='otherformat' style='display:none' />\n</td>\n</tr>\n\n<tr>\n<td class=\"fieldlabel\">ISBN</td>\n<td class=\"fieldarea\">\n<input type=\"text\"  class=\"txt medium\" name=\"isbn\" value=\"";
echo $productDetails["isbn"];
echo "\" /></td>\n</tr>\n\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["audio"];
echo "/";
echo $LNG["video"];
echo " ";
echo $LNG["format"];
echo "</td>\n<td class=\"fieldarea\">\n <select name='audio_format' onchange=\"getOther3(this.value)\" >\n \t<option value=\"\">";
echo $LNG["select"];
echo "</option>\n \t<option value=\"Other\">Other</option>\n \t";
$sql = dquery("select DISTINCT audio_format FROM tbl_products WHERE audio_format!=''");
while ($row = mysqli_fetch_assoc($sql)) {
    echo " \t<option ";
    if ($productDetails["audio_format"] == $row["audio_format"]) {
        echo "selected";
    }
    echo " value=\"";
    echo $row["audio_format"];
    echo "\">";
    echo $row["audio_format"];
    echo "</option>\n \t";
}
echo " </select>\n <input type='text' name='otheraudio_format' id='otheraudio_format' style='display:none' />\n</td>\n</tr>\n\n<tr>\n<td class=\"fieldlabel\"></td>\n<td class=\"fieldarea\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnfeature\" class=\"btn save\" type=\"button\"  onclick=\"SubmitForm ('#btnfeature','editproduct.features','#frmforat','#notification','true','#main_loader');\"/></td>\n</tr>\n\n</tbody>\n</table>\n</div>\n<div class=\"clear\"></div>\n</form>\n</div></div>\n\n<div style=\"clear: both;\"></div>\n<form id=\"frmaddfeature\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<input type=\"hidden\" value=\"editproduct.features.php\" name=\"defaultloadpage\"/>\n";
echo generate_token("form");
echo "\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Add New Features Field</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<input type=\"hidden\" value=\"features\" name=\"customfield[-1][type]\"/>\n<input type=\"hidden\" value=\"";
echo $mid;
echo "\" name=\"customfield[-1][relid]\"/>\n\n     <table id=\"main_tbl\">\n        <thead>\n        <tr>\n        <th>";
echo $LNG["field"];
echo " ";
echo $LNG["type"];
echo "</th>\n        <th>";
echo $LNG["name"];
echo "</th>\n        <th>";
echo $LNG["description"];
echo "</th>\n        <th>";
echo $LNG["fieldoptions"];
echo "</th>\n         <th class=\"qif\">";
echo $LNG["quick"];
echo " Info</th>\n          <th class=\"qif\">Show in Filter</th>\n        <th align=\"right\">";
echo $LNG["action"];
echo "</th>\n        </tr>\n        </thead>\n            <tr  class=\"adddatarow nocheckboxchecked\">\n                <td><select class=\"customfield\" onchange=\"QuickIn(this.value);\" name=\"customfield[-1][fieldtype]\"><option value=\"text\">";
echo $LNG["text"];
echo "</option><option value=\"dropdown\">";
echo $LNG["dropdown"];
echo "</option><option value=\"radio\">";
echo $LNG["radio"];
echo "</option><option value=\"textarea\">";
echo $LNG["textarea"];
echo "</option><option value=\"tickbox\">";
echo $LNG["tickbox"];
echo "</option></select></td>\n                <td><input name=\"customfield[-1][fieldname]\" value=\"\" type=\"text\"/> * </td>\n                <td><input name=\"customfield[-1][description]\" value=\"\" type=\"text\" /></td>\n                <td class=\"qif\"><input  class='fieldoptions'\n                 name=\"customfield[-1][fieldoptions]\" disabled=\"disabled\" value=\"\" type=\"text\"/><br /> <small>";
echo $LNG["seperatedbycommas"];
echo "</small></td>\n<td><input name=\"customfield[-1][quickinfo]\"  value=\"1\"\n type=\"checkbox\" id=\"qif\" /><label for=\"qif\">";
echo $LNG["show"];
echo " </label>\n</td>\n <td><input name=\"customfield[-1][filter]\"  value=\"1\"\n type=\"checkbox\" id=\"fid\" /><label for=\"fid\">";
echo $LNG["yes"];
echo " </label>\n</td>\n<td><span class=\"datagridbtn\"><input  type=\"submit\"\n value=\"";
echo $LNG["add"];
echo "\" name='addnew' /> </span> </td>\n            </tr>\n        </table>\n</div>\n</div>\n</form>\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Features</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n\n<form id=\"frmfeatures\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
$row = getFeatures("features", $mid, $id);
echo "    <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\">\n\n    <tbody>\n    ";
if ($row) {
    foreach ($row as $key => $value) {
        echo "        <tr><td class=\"fieldlabel\">";
        echo $value["name"];
        echo "</td><td class=\"fieldarea\" >";
        echo $value["input"];
        echo $value["description"];
        echo "</td></tr>\n        ";
    }
}
echo "\n\n        <tr>\n        <td class=\"fieldlabel\"></td>\n        <td class=\"fieldarea\" align=\"left\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btn\" class=\"btn save\" type=\"button\"  onclick=\"SubmitForm ('#btn','editproduct.features','#frmfeatures','#notification','true','#main_loader');\"/>\n        <input value=\"";
echo $LNG["edit"];
echo " ";
echo $LNG["features"];
echo "\" id=\"btn\" class=\"btn\" type=\"button\"  onclick=\"javascript:load_subpage('main2.php?page=productfeature', 'Edit Features');\"/>\n        </td>\n        </tr>\n   </tbody>\n\n    </table>\n</form>\n\n\n</div>\n</div></div>\n</div>\n";
$fileverioncheck = "6.1.0";

?>