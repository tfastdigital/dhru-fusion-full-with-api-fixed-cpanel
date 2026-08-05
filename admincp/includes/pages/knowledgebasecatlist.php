<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<script>\n\$(function () {\n    SelectChildren = function (element) {\n       if(\$(\"#\"+element).is(':checked')){\n            \$(\".\"+element).attr('checked',true);\n       }else{\n            \$(\".\"+element).attr('checked',false);\n       }      \n    }\n});\n</script>\n";
$pageid = 300;
checkPagePermission($pageid);
if ($remove && $id) {
    dquery("delete from tbl_knowledgebasecat where id='" . $id . "'");
}
echo "    \n<div id=\"notification\"></div> \n<div id=\"notification1\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<script type=\"text/javascript\" src=\"includes/3rdparty/sort/jquery.tablednd.js\"></script>\n<script>\n\$(document).ready(function() {\n    \$('#main_tbl').tableDnD({\n        onDrop: function(table, row) {\n           var serialized= \$.tableDnD.serialize();\n          \n            \$.ajax({\n    \t\t\ttype: 'POST',\n    \t\t\turl: \"includes/pages/knowledgebasecat.order.save.php\",\n    \t\t\tdata: serialized,\n    \t\t\tsuccess: function(data) {\n    \t\t\t\t \$(\"#notification1\").addClass('successbox');\n    \t\t\t     \$(\"#notification1\").html(data).show();\n    \t\t\t}\n    \t\t});\n        }\n    });\n});\n\n</script>\n\n<form id=\"frmedituser\" name=\"\" method=\"post\" enctype=\"multipart/form-data\">\n\n";
echo generate_token("form");
echo "<div class=\"\">\n<table id=\"main_tbl\" class='sortable'>\n            <thead>\n              <tr class='nodrag'>\n              \n                <th >";
echo $LNG["category"];
echo "</th>\n                <th >&nbsp;</th>\n              </tr>\n            </thead>\n           \n";
$q = dquery("select * from tbl_knowledgebasecat order by sort");
while ($r = mysqli_fetch_assoc($q)) {
    echo " \n<tr id=\"";
    echo $r["id"];
    echo "\" title=\"Drag & Drop to Change Position\">\n\n<td>";
    echo $r["category"];
    echo "</td>\n<td>\n<a  class='default_dg_a2 editdata'  href=\"javascript:redirectedit('editknowledgebasecat','";
    echo $r["id"];
    echo "');\">";
    echo $LNG["edit"];
    echo "</a>\n<a  class='deletedata'  href=\"javascript:\nif(confirm('Are you sure want to remove ?')){\nredirectedit('knowledgebasemain&loaddefaultpage=knowledgebasecatlist.php&remove=true','";
    echo $r["id"];
    echo "');\n}\n\">";
    echo $LNG["delete"];
    echo "</a>\n</td>\n</tr> \n";
}
echo "\n</table>\n</div>\n\n</form></div></div>\n";
$fileverioncheck = "6.1.0";

?>