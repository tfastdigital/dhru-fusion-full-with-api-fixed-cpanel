<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<script>\n\$('#templatepreview').change(function() {\n    var str;\n    str = \$(this).val();\n     if(str!=''){\n                \$.get(\"includes/pages/gettemplatePreview.php\", {id: str},\n                 function(data){\n                    \$(\"#templateimage\").html(data);\n                });\n      }\n});\n\n\$('#carttpl').change(function() {\n    var str;\n    str = \$(this).val();\n     if(str!=''){\n                \$.get(\"includes/pages/gettemplatePreview.php?display=cart\", {id: str},\n                 function(data){\n                    \$(\"#templateimagecart\").html(data);\n                });\n      }\n});\n\n</script>\n\n";
$pageid = 283;
checkPagePermission($pageid);
$sql = mysqli_fetch_assoc(dquery("select * from tbl_settings where attribute='config'"));
$config = unserialize($sql["value"]);
echo "\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\" class=\"\">\n<form id=\"frm\" name=\"\" method=\"post\">\n\n    <div  class=\"groupstabes first\" >\n        <h2>\n            <span class=\"groupstabesheadertext\">Appearance</span>\n        </h2>\n\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["template"];
echo " </td>\n    <td class=\"fieldarea\">\n<select name=\"template\" id=\"templatepreview\" class=\"chosen\">\n";
$myDirectory = opendir(ROOTDIR . "/templates/");
while ($dir = readdir($myDirectory)) {
    $template = explode("_", $dir);
    if (is_dir(ROOTDIR . "/templates/" . $dir) && $dir != "." && $dir != ".." && $dir != "" && $dir != "livehelp" && $dir != ".DS_Store" && $dir != "mobile" && $template[0] != "store") {
        echo "            <option value=\"";
        echo $dir;
        echo "\" ";
        if ($config["template"] == $dir) {
            echo "selected";
        }
        echo " >";
        echo $dir;
        echo "</option>\n            ";
    }
}
closedir($myDirectory);
echo "</select>  &nbsp;&nbsp;&nbsp; <a href=\"javascript:load_fromsubpage('cloudtheme','Cloud Theme')\">More Theme...</a>\n\n\n<div id=\"templateimage\" style=\"display: block;margin-top:10px\"> <img src=\"../templates/";
echo $config["template"];
echo "/images/preview.jpg\" style=\"border: black solid 1px;\"/></div>\n\n  </td>\n\n</tr>\n\n\n<tr>\n    <td  class=\"fieldlabel\" valign=\"top\">";
echo $LNG["clientarea"];
echo " ";
echo $LNG["template"];
echo " [After Login]</td>\n    <td class=\"fieldarea\">\n<select name=\"template_afterlogin\" class=\"chosen\">\n<option value=\"\">";
echo $LNG["select"];
echo "</option>\n";
$myDirectory = opendir(ROOTDIR . "/templates/");
while ($dir = readdir($myDirectory)) {
    if (is_dir(ROOTDIR . "/templates/" . $dir)) {
        $template = explode("_", $dir);
        if ($dir != "." && $dir != ".." && $dir != "" && $dir != "livehelp" && $dir != ".DS_Store" && $dir != "mobile" && $template[0] != "store") {
            echo "            <option value=\"";
            echo $dir;
            echo "\" ";
            if ($config["template_afterlogin"] == $dir) {
                echo "selected";
            }
            echo " >";
            echo $dir;
            echo "</option>\n            ";
        }
    }
}
closedir($myDirectory);
if ($config["afterlogin_apply"]) {
    $isselected = "checked";
} else {
    $isselected = "";
}
echo "</select>    <input type=\"checkbox\" name=\"applys\" id=\"applys\" onClick=\"resetvalue(this)\" ";
echo $isselected;
echo " />\n<label for=\"applys\">";
echo $LNG["applyallafterlogin"];
echo "</label>\n<input type=\"hidden\" name=\"afterlogin_apply\" id=\"afterlogin\"\n value=\"";
echo $config["afterlogin_apply"];
echo "\" /></td>\n</tr>\n\n<!--\n<tr>\n    <td  class=\"fieldlabel\" valign=\"top\">";
echo $LNG["clientarea"];
echo " ";
echo $LNG["template"];
echo " [Mobile]</td>\n    <td class=\"fieldarea\">\n        <select name=\"template_mobile\" class=\"chosen\">\n            <option value=\"\">";
echo $LNG["select"];
echo "</option>\n            ";
$myDirectory = opendir(ROOTDIR . "/templates/");
while ($dir = readdir($myDirectory)) {
    if (is_dir(ROOTDIR . "/templates/" . $dir)) {
        $template = explode("_", $dir);
        if ($dir != "." && $dir != ".." && $dir != "" && $dir != "livehelp" && $dir != ".DS_Store" && $template[0] != "store") {
            echo "<option value=\"";
            echo $dir;
            echo "\" ";
            if ($config["template_mobile"] == $dir) {
                echo "selected";
            }
            echo " >";
            echo $dir;
            echo "</option>\n";
        }
    }
}
closedir($myDirectory);
echo "        </select> </td>\n</tr>\n-->\n<script>\nfunction resetvalue(ob){\n    if(ob.checked){\n        document.getElementById('afterlogin').value=1;\n    }else{\n        document.getElementById('afterlogin').value=0;\n    }\n}\n</script>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["cart"];
echo " ";
echo $LNG["style"];
echo "</td>\n    <td class=\"fieldarea\">\n<select name=\"carttpl\" id=\"carttpl\">\n<option value=\"\">";
echo $LNG["select"];
echo "</option>\n";
$myDirectory = opendir(ROOTDIR . "/templates/" . $config["template"] . "/cart/");
while ($dir = readdir($myDirectory)) {
    if (is_dir(ROOTDIR . "/templates/" . $config["template"] . "/cart/" . $dir) && $dir != "." && $dir != ".." && $dir != "" && $dir != ".DS_Store") {
        echo "                 <option value=\"";
        echo $dir;
        echo "\" ";
        if ($config["carttpl"] == $dir) {
            echo "selected";
        }
        echo " >";
        echo $dir;
        echo "</option>  ";
    }
}
closedir($myDirectory);
echo "</select>\n<small>PayPal Express Checkout available in only default cart style</small>\n\n\n </td>\n\n</tr>\n\n<tr>\n    <td></td>\n    <td class=\"fieldarea\"><div id=\"templateimagecart\"><img src=\"../templates/";
echo $config["template"];
echo "/cart/";
echo $config["carttpl"];
echo "/cartstylepreview.png\"  style=\"border: black solid 1px;\"/></div>\n </td>\n</tr>\n\n\n\n\n</tbody>\n</table>\n<p align=\"center\" class=\"fixedbtn\"> <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','settingappear','#frm','#notification','true','#main_loader');\"/>\n</p>\n\n    </div>\n\n</form>\n\n\n</div></div>\n ";
$fileverioncheck = "6.1.0";

?>