<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"tabcontent\">\n<ul id=\"tabmenu\">\n\n<li><a class=\"tabmenu_active\" href=\"javascript:void(0)\" onclick=\"javascript:void(0);\" id=\"tab22\"><strong>";
echo $LNG["mainindexcontent"];
echo " </strong></a>\n    <ul style=\"padding-left: 10px;\">         \n       ";
if (!$files) {
    $files = $config["language"];
}
$handle = opendir("../" . $languagedirectorypath);
while (false !== ($file = readdir($handle))) {
    if ($file != "." && $file != ".." && $file != "") {
        $file = explode(".", $file);
        if ($file[0] && $file[1] == "txt") {
            echo "                         <li><a href=\"main2.php?page=indexcontent&files=";
            echo $file[0];
            echo "\"\n                         id=\"tab22\" ";
            if ($file[0] == $files) {
                echo "class='tabmenu_active'";
            }
            echo ">";
            echo $file[0];
            echo "</a></li>\n         ";
        }
    }
}
echo "    </ul>\n</li>\n<li>\n<a  href=\"main2.php?page=contactuscontent&p=contact\" id=\"tab23\"><strong>";
echo $LNG["contactus"];
echo " ";
echo $LNG["content"];
echo " <span style=\"float: right;\"> &raquo; </span></strong></a></li>\n    <!--\n<li>\n\n<a  href=\"main2.php?page=closeaccontent&p=closeac\" id=\"tab24\"><strong>";
echo $LNG["close"];
echo " ";
echo $LNG["account"];
echo " ";
echo $LNG["terms"];
echo " <span style=\"float: right;\"> &raquo; </span></strong></a></li>\n-->\n</ul>\n";
$pageid = 86;
checkPagePermission($pageid);
require ROOTDIR . "/includes/clients.fun.inc.php";
include "includes/3rdparty/editor/editor.php";
if ($save) {
    if ($DEMOMODE) {
        echo "<div id=notification1 class=errorbox>This function not enabled in demo mode .</div>";
    } else {
        if (mysqli_num_rows(dquery("select * from tbl_custom_page\n            where type='index' and language='" . $files . "'"))) {
            $data["content"] = $contents;
            $data["language"] = $files;
            if ($db->update("tbl_custom_page", $data, "type='index' and language='" . $files . "'")) {
                echo "<div id=notification1 class=successbox>  " . $LNG["savesuccessfully"] . " </div>";
            }
        } else {
            $data["content"] = $contents;
            $data["language"] = $files;
            $data["type"] = "index";
            if ($db->insert("tbl_custom_page", $data)) {
                echo "<div id=notification1 class=successbox>  " . $LNG["savesuccessfully"] . " </div>";
            }
        }
    }
}
echo "\n<div id=\"content\"><div id=\"content_padded\">\n\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<input type=\"hidden\" name=\"files\" value=\"";
echo $files;
echo "\" />\n\n";
if ($files) {
    $index = mysqli_fetch_assoc(dquery("SELECT  `content` \n       FROM `tbl_custom_page` WHERE `type`='index' and language='" . $files . "'"));
} else {
    $index = mysqli_fetch_assoc(dquery("SELECT  `content` \n       FROM `tbl_custom_page` WHERE `type`='index'"));
}
echo "\n\n\n<textarea name=\"contents\"  id=\"message\"  rows=\"15\" cols=\"150\">";
echo $index["content"];
echo "</textarea>\n\n<p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" \nname=\"save\" id=\"btnoverview\" class=\"btn\" type=\"submit\"  /></p>\n</form>\n\n</div></div>\n\n<style>\n    iframe[id*=\"_ifr\"]{min-height:600px}\n</style>\n\n";
if (!$fusionlite && $config["wikihelp"]) {
    echo "<div class=\"help_icon\"><a href=\"https://support.dhru.com/Dhru-Fusion/article/CMS---Blog/?aid=34&pid=1&cid=5#main-index-content\" target=\"_blank\"><img src=\"images/help_icon.png\"/> Wiki Help</a></div>";
}
echo "</div>";
$fileverioncheck = "6.1.0";

?>