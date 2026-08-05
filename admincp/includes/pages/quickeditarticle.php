<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
echo "    <style>\r\n        .glob {\r\n            background-color: #e9e9e9;\r\n            cursor: pointer;\r\n            display: inline-block;\r\n            height: 28px;\r\n            line-height: 26px;\r\n            vertical-align: middle;\r\n            width: 35px;\r\n            text-align: center;\r\n            font-size: 18px;\r\n        }\r\n    </style>\r\n\r\n    <div id=\"notification\"></div>\r\n    <div id=\"notification1\"></div>\r\n    <div id=\"content\">\r\n        <div id=\"content_padded\">\r\n\r\n            <script type=\"text/javascript\" src=\"includes/3rdparty/sort/jquery.tablednd.js\"></script>\r\n            <script>\r\n                function increase(id){\r\n                    var per=parseFloat(\$(\".incr\"+id).val());\r\n                    if(per>0){\r\n                        \$('.price'+id).each(function() {\r\n                            var tso=parseFloat(\$(this).val());\r\n                            if(tso>0){\r\n                                var iso=(tso*per)/100;\r\n                                \$(this).val((iso+tso).toFixed(2));\r\n                            }\r\n                        });\r\n                    }\r\n                }\r\n                function decrease(id){\r\n                    var per=parseFloat(\$(\".incr\"+id).val());\r\n                    if(per>0){\r\n                        \$('.price'+id).each(function() {\r\n                            var tso=parseFloat(\$(this).val());\r\n                            if(tso>0){\r\n                                var iso=(tso*per)/100;\r\n                                \$(this).val((tso-iso).toFixed(2));\r\n                            }\r\n                        });\r\n                    }\r\n                }\r\n                \$(document).ready(function() {\r\n                    \$('#main_tbl').tableDnD({\r\n                        onDrop: function(table, row) {\r\n                            var serialized= \$.tableDnD.serialize();\r\n                            \$.ajax({\r\n                                type: 'POST',\r\n                                url: \"includes/pages/article.order.save.php\",\r\n                                data: serialized,\r\n                                success: function(data) {\r\n                                    \$(\"#notification1\").addClass('successbox');\r\n                                    \$(\"#notification1\").html(data).show();\r\n                                }\r\n                            });\r\n                        }\r\n                    });\r\n                });\r\n            </script>\r\n            <form id=\"frmedituser\" name=\"\" method=\"post\" enctype=\"multipart/form-data\">\r\n\r\n                <input type=\"hidden\" value=\"";
echo $groups;
echo "\" name=\"groups\"/>\r\n                <input type=\"hidden\" name=\"showall\" value=\"";
echo $showallserv;
echo "\" />\r\n                <input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\r\n                ";
echo generate_token("form");
echo "\r\n                <table id=\"main_tbl\" style=\"display: ";
echo $display;
echo ";\"  class='sortable'>\r\n                    <thead>\r\n                    <tr style=\"cursor: default !important;\">\r\n                        <th> <input value=\"ALL\" class=\"check-all\" name=\"all_imei\" onClick=\"SetAllCheckBoxes(this)\" type=\"checkbox\" /><label></label></th>\r\n                        <th>\r\n                            <select name=\"category\" class=\"chosen\" onchange=\"javascript:reloadcurrent('knowledgebasemain','&loaddefaultpage=quickeditarticle.php&grpid='+this.value+'')\">\r\n                                ";
$sql = dquery("SELECT id,category FROM tbl_knowledgebasecat");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "                                        <option ";
    if ($_GET["grpid"] == $row["id"]) {
        echo "selected";
    }
    echo " value=\"";
    echo $row["id"];
    echo "\">";
    echo $row["category"];
    echo "</option>\r\n                                        ";
}
echo "                            </select>\r\n                        </th>\r\n\r\n                        <th></th>\r\n                    </tr>\r\n                    </thead>\r\n                    <tbody>\r\n                    ";
if (!$_GET["grpid"]) {
    $cat = mysqli_fetch_assoc(dquery("select id from tbl_knowledgebasecat limit 1"));
    $_GET["grpid"] = $cat["id"];
}
echo "                    ";
$aq = dquery("select * from tbl_knowledgebase where group_id='" . $_GET["grpid"] . "' order by displayorder asc");
while ($rp = mysqli_fetch_assoc($aq)) {
    echo "                        <tr id=\"";
    echo $rp["id"];
    echo "\">\r\n                            <td><input name=\"imei_check[";
    echo $rp["id"];
    echo "]\" ";
    echo $selected;
    echo " value=\"";
    echo $rp["id"];
    echo "\"\r\n                                       type=\"checkbox\" class=\"g_";
    echo $i;
    echo "\"/><label></label></td>\r\n                            <td><input type=\"text\" name=\"title[";
    echo $rp["id"];
    echo "]\" style=\"width: 500px\"\r\n                                       value='";
    echo html_entity_decode($rp["title"]);
    echo "' /></td>\r\n                            <td></td>\r\n                        </tr>\r\n                    ";
}
echo "                    </tbody>\r\n\r\n                </table>\r\n                <br/>\r\n                <p align=\"center\" class=\"fixedbtn\">\r\n\r\n<input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser1\"\r\nclass=\"btn\" type=\"button\"\r\nonclick=\"SubmitForm('#btnedituser1','quickeditarticle','#frmedituser','#notification','true','#main_loader');\"/>\r\n\r\n                </p>\r\n            </form>\r\n        </div></div>\r\n\r\n\r\n\r\n    <div id=\"page_info\" class=\"page_info\">\r\n        <li>Just Drag and drop to change postion of listing</li>\r\n    </div>\r\n\r\n";
$fileverioncheck = "6.1.0";

?>