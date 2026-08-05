<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"tabcontent\">\n<ul id=\"tabmenu\">\n<li><a href=\"main2.php?page=indexcontent&1=1&p=index\" id=\"tab22\"><strong>";
echo $LNG["mainindexcontent"];
echo " </strong></a></li>\n\n<li>\n<a  class=\"tabmenu_active\" href=\"javascript:void(0)\" onclick=\"javascript:void(0);\" id=\"tab23\"><strong>";
echo $LNG["contactus"];
echo " ";
echo $LNG["content"];
echo "  </strong></a>\n\n    <ul style=\"padding-left: 10px;\">\n       ";
$pageid = 540;
checkPagePermission($pageid);
if (!$files) {
    $files = $config["language"];
}
$handle = opendir("../" . $languagedirectorypath);
while (false !== ($file = readdir($handle))) {
    if ($file != "." && $file != ".." && $file != "") {
        $file = explode(".", $file);
        if ($file[0] && $file[1] == "txt") {
            echo "             <li><a href=\"main2.php?page=contactuscontent&files=";
            echo $file[0];
            echo "\"\n             id=\"tab23\" ";
            if ($file[0] == $files) {
                echo "class='tabmenu_active'";
            }
            echo ">";
            echo $file[0];
            echo "</a></li>\n         ";
        }
    }
}
echo "    </ul>\n\n    </li>\n\n</ul>\n\n\n";
require ROOTDIR . "/includes/clients.fun.inc.php";
include "includes/3rdparty/editor/editor.php";
if ($save) {
    if ($DEMOMODE) {
        echo "<div id=notification1 class=errorbox>This function not enabled in demo mode .</div>";
    } else {
        if (mysqli_num_rows(dquery("select * from tbl_custom_page\n        where type='contact' and language='" . $files . "'"))) {
            $data["content"] = $contents;
            $data["language"] = $files;
            if ($db->update("tbl_custom_page", $data, "type='contact' and language='" . $files . "'")) {
                echo "<div id=notification1 class=successbox>  " . $LNG["savesuccessfully"] . " </div>";
            }
        } else {
            $data["content"] = $contents;
            $data["language"] = $files;
            $data["type"] = "contact";
            if ($db->insert("tbl_custom_page", $data)) {
                echo "<div id=notification1 class=successbox>  " . $LNG["savesuccessfully"] . " </div>";
            }
        }
    }
}
if ($files) {
    $index = mysqli_fetch_assoc(dquery("SELECT  `content` \n       FROM `tbl_custom_page` WHERE `type`='contact' and language='" . $files . "'"));
} else {
    $index = mysqli_fetch_assoc(dquery("SELECT  `content` \n       FROM `tbl_custom_page` WHERE `type`='contact'"));
}
echo "\n<div id=\"content\"><div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\" action=\"main2.php?page=contactuscontent\">\n";
echo generate_token("form");
echo "<input type=\"hidden\" name=\"files\" value=\"";
echo $files;
echo "\" />\n<textarea name=\"contents\"  id=\"message\"  rows=\"15\" cols=\"150\">";
echo $index["content"];
echo "</textarea>\n\n<p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" name=\"save\" id=\"btnoverview\" class=\"btn\" type=\"submit\"  /></p>\n</form>\n</div></div>\n</div>\n\n\n<style>\n    iframe[id*=\"_ifr\"]{min-height:600px}\n</style>\n\n";
$fileverioncheck = "6.1.0";

?>