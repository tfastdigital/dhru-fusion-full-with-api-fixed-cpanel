<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 469;
checkPagePermission($pageid);
echo "    <style>\n        .codetable{\n            display: none;\n        }\n    </style>\n    <script type=\"text/javascript\" src=\"includes/3rdparty/sort/jquery.tablednd.js\"></script>\n    <script>\n        \$('#main_tbl').tableDnD({\n            onDrop: function(table, row) {\n                var serialized= \$.tableDnD.serialize();\n                \$.ajax({\n                    type: 'POST',\n                    url: \"includes/pages/key.order.save.php\",\n                    data: serialized,\n                    success: function(data) {\n                        \$(\"#notification1\").addClass('successbox');\n                        \$(\"#notification1\").html(data).show();\n                    }\n                });\n            }\n        });\n    </script>\n    <script type=\"text/javascript\">\n        function submitKeyGroup(formId){\n            \$.post('includes/pages/editshipping.php?keygroup=true',\$(formId).serialize() , function (data, textStatus) {\n            });\n        }\n        function setGroupType(gvalue){\n\n            if(gvalue==2){\n                \$(\".codetable\").show();\n            }else{\n                \$(\".codetable\").hide();\n            }\n        }\n    </script>\n";
include_once "includes/fun.inc.php";
if ($add) {
    checkDemoMode(false);
    if ($type != 1 && ($codetable == "" || $codeimei == "" || $codereply == "")) {
        echo "<div id='notification1' class='errorbox'>" . $LNG["fieldblank"] . "</div>";
    } else {
        if ($group) {
            $data["group"] = $group;
            $data["codetable"] = $codetable;
            $data["codeimei"] = $codeimei;
            $data["codereply"] = $codereply;
            $data["exlcludestart"] = $exlcludestart;
            $data["exludeend"] = $exludeend;
            $data["replysprintf"] = $replysprintf;
            $data["autoreject"] = $autoreject;
            $db->insert("tbl_keygroup", $data);
            $data = NULL;
            echo "<div id='notification1' class='successbox'>" . $LNG["datasavesuccessfully"] . "</div>";
        } else {
            echo "<div id='notification1' class='errorbox'>" . $LNG["fieldblank"] . "</div>";
        }
    }
}
if ($delete) {
    checkDemoMode(false);
    echo "    <ul id=\"tabmenu\">\n        <li><a ";
    if (!$laoddefaultpage) {
        echo " class=\"tabmenu_active\" ";
    }
    echo " onclick=\"getContect('#tab2','main2.php?page=softwarekey.list','','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
    echo $LNG["reply"];
    echo " ";
    echo $LNG["list"];
    echo "</a></li>\n        <li><a  onclick=\"getContect('#tab1','main2.php?page=softwarekey','','','#tabcontent',true,'#main_loader');\" id=\"tab1\" > + ";
    echo $LNG["create"];
    echo " ";
    echo $LNG["reply"];
    echo "</a></li>\n        <li><a  ";
    if ($laoddefaultpage == "softwarekeygroup.php") {
        echo " class=\"tabmenu_active\" ";
    }
    echo " onclick=\"getContect('#tab3','main2.php?page=softwarekeygroup','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >  ";
    echo $LNG["auto"];
    echo " ";
    echo $LNG["reply"];
    echo " ";
    echo $LNG["group"];
    echo "</a></li>\n        <div style=\"clear: both;\"></div>\n    </ul>\n    <div id=\"tabcontent\">\n        ";
}
echo "<div id=\"content\">\n            <div id=\"content_padded\">\n                <div  class=\"groupstabes\" >\n                    <h2>\n                        <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n                        <span class=\"groupstabesheadertext\">Add Key Group</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n                    </h2>\n                    <div class=\"groupstabescontant\" style=\"width:50%; float:left\">\n\n                        <form id=\"gr\" name=\"\" method=\"post\">\n                            <input type=\"hidden\" name=\"laoddefaultpage\" value=\"softwarekeygroup.php\" />\n                            <table class=\"form\">\n                                <tr><td class=\"fieldlabel\">\n                                    </td>\n                                    <td class=\"fieldarea\">\n                                        <label><input type=\"radio\" name=\"type\" checked=\"checked\" onclick=\"setGroupType(this.value)\" value=\"1\" />";
echo $LNG["default"];
echo "</label>\n                                        &nbsp;&nbsp;&nbsp;\n                                        <label><input type=\"radio\"  name=\"type\" value=\"2\"  onclick=\"setGroupType(this.value)\" />";
echo $LNG["custom"];
echo " ";
echo $LNG["database"];
echo "</label>\n\n                                    </td></tr>\n\n\n\n\n                                <tr><td class=\"fieldlabel\">\n                                        ";
echo $LNG["group"];
echo " </td><td class=\"fieldarea\"><input type=\"text\"  name=\"group\" />\n                                    </td></tr>\n\n                                <tr class=\"codetable\"><td class=\"fieldlabel \">\n                                        ";
echo $LNG["database"];
echo " ";
echo $LNG["table"];
echo " ";
echo $LNG["name"];
echo "                                    </td><td class=\"fieldarea\"><input type=\"text\"  name=\"codetable\" />\n                                        <small>Database table must be inside your system database</small>\n                                    </td></tr>\n\n                                <tr class=\"codetable\"><td class=\"fieldlabel \">\n                                        ";
echo $LNG["table"];
echo " IMEI ";
echo $LNG["field"];
echo " </td>\n                                    <td class=\"fieldarea\"><input type=\"text\"  name=\"codeimei\" />\n                                        <small>This Field name used for IMEI comparision with  order. Make sure all IMEI's must be unique otherwise multiple matches conflicts.</small>\n                                    </td></tr>\n\n\n                                <tr class=\"codetable\"><td class=\"fieldlabel \">\n                                        ";
echo $LNG["table"];
echo " Reply/Code ";
echo $LNG["field"];
echo " </td>\n                                    <td class=\"fieldarea\"><input type=\"text\"  name=\"codereply\" />\n                                        <small>When IMEI matched with order's IMEI Code will be reply with this field value. If more than one IMEI match with order's IMEI then first match  will be replied automatically.</small>\n                                    </td></tr>\n\n                                <tr class=\"codetable\"><td class=\"fieldlabel \">\n                                        Exclude Starting Characters of IMEI</td>\n                                    <td class=\"fieldarea\"><input type=\"text\" size=\"3\"  name=\"exlcludestart\" />\n                                        <small>If you dont want to compare some starting characters e.g. 2 or 3 .</small>\n                                    </td></tr>\n                                <tr class=\"codetable\"><td class=\"fieldlabel \">\n                                        Exclude Ending Characters of IMEI</td>\n                                    <td class=\"fieldarea\"><input type=\"text\"  size=\"3\"  name=\"exlcludeend\" />\n                                        <small>If you dont want to compare some ending characters e.g. 1 or 4 .</small>\n                                    </td></tr>\n\n\n                                <tr class=\"codetable\"><td class=\"fieldlabel \">\n                                        Reply Code masking</td>\n                                    <td class=\"fieldarea\"><input type=\"text\"   name=\"replysprintf\" />\n\n                                        <small>Code1:****  Code 2:****[ where * is one character] (e.g.if reply is ABCDEFGH then  REPLY 1 : **** REPLY 2: **** (REPLY 1: ABCD REPLY 2: EFGH) )</small>\n                                    </td></tr>\n\n                                <tr class=\"codetable\"><td class=\"fieldlabel \">\n                                    </td>\n                                    <td class=\"fieldarea\">\n                                        <label><input type=\"checkbox\" name=\"autoreject\" value=\"1\"/>Auto Reject if Code not found</label>\n                                    </td></tr>\n\n                                <tr>\n                                    <td></td>\n                                    <td class=\"fieldarea\">\n                                        <input type=\"submit\" name=\"add\" class=\"btn add\" value=\"+ ";
echo $LNG["add"];
echo "\" />\n                                    </td>\n                                </tr>\n                            </table>\n                        </form>\n\n                    </div>\n                    <div  style=\"width:50%; float:left\" class=\"codetable\">\n                        <img style=\"width: 500px;\" src=\"images/autoreply.jpg\" />\n                    </div>\n                </div>\n                <div style=\"clear: both;\"></div>\n                <div  class=\"groupstabes\" >\n                    <h2>\n                        <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n                        <span class=\"groupstabesheadertext\">";
echo $LNG["key"];
echo " ";
echo $LNG["group"];
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n                    </h2>\n                    <div class=\"groupstabescontant\">\n<div id=\"notification1\"></div>\n                        <form id=\"frm\" name=\"\" method=\"post\">\n                            <table id=\"main_tbl\" >\n                                <tbody>\n                                <tr><th>";
echo $LNG["group"];
echo "</th>\n                                    <th>";
echo $LNG["stock"];
echo "</th>\n                                    <th>";
echo $LNG["used"];
echo "</th>\n                                    <th align=\"right\">Action</th></tr>\n                                ";
if ($delete && $id) {
    dquery("DELETE FROM tbl_keygroup WHERE `id`='" . $id . "'");
}
$sql = dquery("SELECT *,(select count(id) from tbl_swkey\n    where group_id=tbl_keygroup.id and used=0) as selled,(select count(id) from tbl_swkey\n    where group_id=tbl_keygroup.id and used=1) as used FROM tbl_keygroup\n    order by `displayorder` asc");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "                                    <tr id=\"";
    echo $row["id"];
    echo "\" title=\"Drag & Drop to Change Position\">\n                                        <td>\n                                            <input type=\"hidden\" name=\"id[]\" value=\"";
    echo $row["id"];
    echo "\" />\n                                            <input type=\"text\" class=\"txt large\" name=\"value[]\" value=\"";
    echo $row["group"];
    echo "\"/>\n                                        </td>\n                                        <td>\n                                            <a class=\"default_dg_a2 \" href=\"javascript:load_subpage('main2.php?page=softwarekey.list&filter=";
    echo $row["id"];
    echo "&stock=1','";
    echo $row["group"];
    echo "');\">";
    echo $row["selled"];
    echo "</a>\n                                        </td>\n                                        <td>\n                                            <a class=\"default_dg_a2 \" href=\"javascript:load_subpage('main2.php?page=softwarekey.list&filter=";
    echo $row["id"];
    echo "&used=1','";
    echo $row["group"];
    echo "');\">";
    echo $row["used"];
    echo "</a>\n                                        </td>\n                                        <td align=\"right\">\n                                            <a class=\"default_dg_a2 editdata\" href=\"javascript:load_subpage('main2.php?page=editautoreply&edit=";
    echo $row["id"];
    echo "','Edit Group');\"></a>\n                                            <a class=\"default_dg_a2 deletedata\" onclick=\"return confirm('Are you sure  want to remove key group ?');\" href=\"javascript:reloadcurrent('softwarekeygroup','";
    echo $row["id"];
    echo "&delete=true&laoddefaultpage=softwarekeygroup.php')\">";
    echo $LNG["delete"];
    echo "</a>\n                                        </td>\n                                    </tr>\n                                    ";
}
echo "</tbody></table>\n                        </form>\n                        <p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\"  onclick=\"submitKeyGroup('#frm');\"/></p>\n\n                    </div></div>  </div></div>\n        ";
if ($delete) {
    echo "    </div>\n    ";
}
$fileverioncheck = "6.1.0";

?>