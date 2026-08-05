<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"tabcontent\">\n";
include "page.head.php";
include_once "includes/fun.inc.php";
$pageid = 335;
checkPagePermission($pageid);
echo "<script>\nfunction redirect(){\n    if(document.getElementById('addpage').value){\n        javascript:load_subpage('main2.php?page=newpage&newpage='+document.getElementById('addpage').value,'Add Page');\n    }else{\n        alert('Page Name Required');\n    }\n}\nfunction setDel(id){\n    if(confirm('Are you sure  want to remove Page?')){\n        reloadcurrent('viewpage',id+'&delete=true');\n    }\n}\n</script>\n\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<form id=\"newimeiorder\" name=\"\" method=\"post\">\n<table id=\"main_tbl\">\n            <thead>\n              <tr>\n                <th>";
echo $LNG["name"];
echo "</th>\n                <th>";
echo $LNG["status"];
echo " </th>\n                <th>";
echo $LNG["flag"];
echo "</th>\n                <th>";
echo $LNG["date"];
echo "</th>          \n                <th>";
echo $LNG["action"];
echo "</th>\n              </tr>\n            </thead>\n            <tbody>\n<tr class=\"\">\n<form id=\"newpage\" name=\"\" method=\"post\">\n    <td><input type=\"text\" align=\"right\" id=\"addpage\" name=\"addpage\" />&nbsp;</td> <td colspan=\"4\"><input type=\"button\" name=\"go\" value=\"Add\" onclick=\"redirect();\"/> </td> </tr>\n</form>\n";
if ($delete && $id) {
    dquery("DELETE FROM tbl_cms_pages WHERE `id`='" . $id . "'");
}
$sql = dquery("SELECT * FROM tbl_cms_pages order by id");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "        <tr>\n            <td><a style=\"\" class=\"\" href=\"javascript:load_subpage('main2.php?page=editpage&id=";
    echo $row["id"];
    echo "&up=";
    echo $row["id"];
    echo "','Edit Page')\">\n            ";
    echo $row["urlname"];
    echo "            </a></td>\n            <td>";
    echo $row["status"];
    echo "</td>\n            <td>\n            ";
    if ($row["login_req"]) {
        echo "<div style='background-color: red; width:10px; height: 10px;'></div>";
    }
    echo "            </td> \n            <td>";
    echo $row["publish_time"];
    echo "</td>\n            <td>\n             ";
    if ($row["id"] < 6) {
        echo "            ";
    } else {
        echo "            <span title=\"delete\"><input type=\"button\" title=\"delete\" class=\"button deletedata\" onclick=\"javascript: setDel('";
        echo $row["id"];
        echo "');\" value=\"";
        echo $LNG["delete"];
        echo "\" /></span>\n            ";
    }
    echo "           <span title=\"edit\"><input class=\"button editdata\" title=\"edit\" type=\"button\" onclick=\"javascript:load_subpage('main2.php?page=editpage&id=";
    echo $row["id"];
    echo "&up=";
    echo $row["id"];
    echo "','Edit Page')\" value=\"";
    echo $LNG["edit"];
    echo "\" /></span>             \n            </td>      \n        </tr>\n        ";
}
echo "\n</tbody></table>\n</form>\n\n  <fieldset style=\"float:left;margin:10px\">\n    <legend style=\"font: bold; color: #020031; font-size: medium;\">Flag</legend>\n    <table>\n    <tr><td><div style=\"background-color:#FF0000; width:10px; height:10px ;\"></div></td><td>Login required</td></tr>\n    </table>\n </fieldset>\n\n</div></div> \n";
if (!$fusionlite && $config["wikihelp"]) {
    echo " <div class=\"help_icon\"><a href=\"https://support.dhru.com/Dhru-Fusion/article/CMS---Blog/?aid=34&cid=5&pid=1\" target=\"_blank\"><img src=\"images/help_icon.png\"/> Wiki Help</a></div>";
}
echo "</div>";
$fileverioncheck = "6.1.0";

?>