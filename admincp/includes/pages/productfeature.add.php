<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<ul id=\"tabmenu\">\n    <li><a href=\"javascript:void(0);\" class=\"tabmenu_active\">Product Feature</a></li>\n</ul>\n";
$pageid = 465;
checkPagePermission($pageid);
echo "<script src=\"includes/js/jquery.ui.min.js\"></script>\n<link href=\"includes/css/ui/style.css\" rel=\"stylesheet\"/>\n<script>\nfunction QuickIn(val){\n    /*\n    if(val!='text'){\n        \$('.qif').hide();\n    }else{\n        \$('.qif').show();\n    }\n    */\n}\nfunction showHide(id){\n\tif(id.checked==false)\n\t{\n\t\tdocument.getElementById('customlength').style.display='none';\n\t\tdocument.getElementById('customimeiname').style.display='none';\n\t\tdocument.getElementById('customimeiinfo').style.display='none';\n\t}\n\telse\n\t{\n\t\tdocument.getElementById('customlength').style.display='table-row';\n\t\tdocument.getElementById('customimeiname').style.display='table-row';\n\t\tdocument.getElementById('customimeiinfo').style.display='table-row';\n\t}\n}\nfunction DeleteCustom(cid){\n    var answer = confirm('Are you sure to delete this item?');\n    if(answer)\n    {\n        DeleteItem (cid,'editproduct.delfeature','#frmedituser','#table_'+cid,'#notification','true','#main_loader');\n    }\n}\n\n\n\n</script>\n\n";
include_once ROOTDIR . "/includes/features.fun.php";
if ($addnew) {
    if ($customfield[-1]["fieldname"]) {
        foreach ($customfield as $key => $value) {
            if (!$customfield[$key]["required"]) {
                $customfield[$key]["required"] = "";
            }
        }
        if (!$customfield[-1]["fieldname"]) {
            unset($customfield[-1]);
        }
        saveFeaturesServicewise($key, $customfield);
        echo "<div id='notification1' class='successbox'>" . $LNG["datasavesuccessfully"] . "</div>";
    } else {
        echo "<div id='notification1' class='errorbox'>" . $LNG["fieldblank"] . "</div>";
    }
}
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<div class=\"groupstabes first\"  style=\"position: relative;\">\n  <h2>\n    <span class=\"groupstabesheadertext\">";
echo $LNG["add"];
echo " ";
echo $LNG["features"];
echo "</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<input type=\"hidden\" value=\"productfeature.add.php\" name=\"defaultpageload\"/>\n";
echo generate_token("form");
echo "\n<div class=\"\">\n<input type=\"hidden\" value=\"features\" name=\"customfield[-1][type]\"/>\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"customfield[-1][relid]\"/>\n <div>\n    <table class=\"form\" id=\"main_tbl\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n        <tbody>\n\n                <tr><td>";
echo $LNG["field"];
echo " ";
echo $LNG["type"];
echo "</td>\n                <td>";
echo $LNG["name"];
echo "</td>\n                <td>";
echo $LNG["description"];
echo "</td>\n                <td>";
echo $LNG["fieldoptions"];
echo "</td>\n                <td class=\"qif\">";
echo $LNG["quick"];
echo " Info</td>\n                   <th class=\"qif\">Show in Filter</th>\n                <td></td><td></td></tr>\n\n         <tr valign=\"top\" class=\"adddatarow\">\n                <td><select onchange=\"QuickIn(this.value);\" class=\"customfield\" name=\"customfield[-1][fieldtype]\"><option value=\"text\">";
echo $LNG["text"];
echo "</option><option value=\"dropdown\">";
echo $LNG["dropdown"];
echo "</option><option value=\"textarea\">";
echo $LNG["textarea"];
echo "</option><option value=\"tickbox\">";
echo $LNG["tickbox"];
echo "</option></select></td>\n                    <td><input name=\"customfield[-1][fieldname]\" value=\"\" type=\"text\"/> * </td>\n                    <td><input name=\"customfield[-1][description]\" value=\"\" type=\"text\" /></td>\n                    <td ><input name=\"customfield[-1][fieldoptions]\" value=\"\" type=\"text\" disabled=\"true\"  class=\"fieldoptions\"/><br /> <small>";
echo $LNG["seperatedbycommas"];
echo "</small></td>\n<td  class=\"qif\"><input name=\"customfield[-1][quickinfo]\"  value=\"1\"\n type=\"checkbox\" id=\"qif\" /><label for=\"qif\">";
echo $LNG["show"];
echo " </label>\n</td>\n <td><input name=\"customfield[-1][filter]\"  value=\"1\"\n type=\"checkbox\" id=\"fid\" /><label for=\"fid\">";
echo $LNG["yes"];
echo " </label>\n                    <td><select name=\"customfield[-1][relid]\">\n                        ";
$sql = dquery("select group_name,id from tbl_product_group where mid='0'");
while ($row = mysqli_fetch_assoc($sql)) {
    if ($customfield[-1]["relid"] == $row["id"]) {
        $selected = "selected='selected'";
    } else {
        $selected = "";
    }
    echo "<option value='" . $row["id"] . "' " . $selected . ">" . $row["group_name"] . "</option>";
}
echo "                        </select> <br /> <a href=\"#\" data-target=\"addproductgroup\" data-target-header=\"";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["product"];
echo " ";
echo $LNG["group"];
echo "\" onclick=\"AddnewInpopup(this);\">";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["product"];
echo " ";
echo $LNG["group"];
echo "</a>\n                    </td>\n                   <td class=\"fieldarea\"><input  type=\"submit\" class=\"btn add\" value=\"+ ";
echo $LNG["add"];
echo "\" name='addnew' /></td>\n                </tr>\n        </tbody>\n      </table>\n\n    </div>\n</div>\n<input type=\"hidden\" name=\"defaultload\" value=\"productfeature.php\"/>\n</form>\n\n</div>\n</div>\n\n <div class=\"groupstabes\">\n\n<h2>\n    <span class=\"groupstabesheadertext\">";
echo $LNG["features"];
echo " ";
echo $LNG["list"];
echo " </span>\n  </h2>\n<div class=\"groupstabescontant\">\n\n<form method=\"post\">\n    <input type=\"hidden\" value=\"productfeature.add.php\" name=\"defaultpageload\"/>\n    <select name=\"mastergroup\">\n        <option value=''>--Select--</option>\n            ";
$sql = dquery("select group_name,id from tbl_product_group where mid='0'");
while ($row = mysqli_fetch_assoc($sql)) {
    if ($mastergroup == $row["id"]) {
        $selected = "selected='selected'";
    } else {
        $selected = "";
    }
    echo "<option value='" . $row["id"] . "' " . $selected . " >" . $row["group_name"] . "</option>";
}
echo "    </select>\n    <input type=\"submit\" name=\"list\" value=\"";
echo $LNG["list"] . " " . $LNG["features"];
echo "\" />\n </form>\n <hr />\n";
if ($mastergroup) {
    $row = getFeaturesServicewise("features", $mastergroup);
    echo "<form id=\"frmsave\" name=\"\" method=\"post\">\n\n<table id=\"main_tbl\" cell-spacing=\"0\" cell-padding=\"0\">\n<thead>\n<tr>\n<th>";
    echo $LNG["field"];
    echo " ";
    echo $LNG["type"];
    echo "</th>\n<th>";
    echo $LNG["name"];
    echo "</th>\n<th>";
    echo $LNG["description"];
    echo "</th>\n<th>";
    echo $LNG["fieldoptions"];
    echo "</th>\n<th>";
    echo $LNG["order"];
    echo "</th>\n<th>";
    echo $LNG["quick"];
    echo " Info</th>\n<th>Show in Filter</th>\n<th>";
    echo $LNG["action"];
    echo "</th>\n</tr>\n</thead>\n";
    if ($row) {
        foreach ($row as $key => $value) {
            echo "    <tr>\n        <td>";
            echo $row[$key]["fieldtype"];
            echo "</td>\n        <td>";
            echo $row[$key]["fieldname"];
            echo "</td>\n        <td>";
            echo $row[$key]["description"];
            echo "</td>\n        <td>";
            echo $row[$key]["fieldoptions"];
            echo "</td>\n        <td>";
            echo $row[$key]["order"];
            echo "</td>\n        <td>\n        ";
            echo $row[$key]["quickinfo"];
            echo "        </td>\n        <td>\n        ";
            echo $row[$key]["filter"];
            echo "        </td>\n        <td><input value=\"";
            echo $LNG["delete"];
            echo "\" id=\"";
            echo $key;
            echo "\" class=\"button delete deletedata\" type=\"button\"  onclick=\"DeleteCustom(";
            echo $key;
            echo ")\"/></td>\n    </tr>\n    ";
        }
    }
    echo "</table>\n\n<div class=\"clear\"></div>\n\n<p align=\"left\"><input value=\"";
    echo $LNG["save"];
    echo "\" id=\"btnedituser\" class=\"btn save\" type=\"button\"  onclick=\"SubmitForm ('#btnedituser','productfeature.add','#frmsave','#notification','true','#main_loader');\"/></p>\n</form>\n";
}
echo "\n\n<dir style=\"clear: both;\"></dir>\n\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>