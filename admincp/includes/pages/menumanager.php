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
echo "<script>\nfunction getDrag(){\n\t\n\$('#main_tbl').tableDnD({\n    onDrop: function(table, row) {\n       var serialized= \$.tableDnD.serialize();\n        \$.ajax({\n\t\t\ttype: 'POST',\n\t\t\turl: \"includes/pages/menu.order.save.php\",\n\t\t\tdata: serialized,\n\t\t\tsuccess: function(data) {\n\t\t\t\t \$(\"#notification1\").addClass('successbox');\n\t\t\t     \$(\"#notification1\").html(data).show();\n\t\t\t}\n\t\t});\n    }\n});\n\n}\n</script>\n<ul id=\"tabmenu\"> \n    <li><a  ";
if ($laoddefaultpage != "menumanagermain.php") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab22','main2.php?page=menumaster','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab22\" >";
echo $LNG["master"];
echo " ";
echo $LNG["navigation"];
echo "</a></li>\n    <li><a  ";
if ($laoddefaultpage == "menumanagermain.php") {
    echo "class='tabmenu_active'";
}
echo "   onclick=\"getContect('#tab','main2.php?page=menumanagermain','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["sub"];
echo " ";
echo $LNG["navigation"];
echo "</a></li> \n<div style=\"clear: both;\"></div>\n</ul>\n<div id=\"tabcontent\"> ";
if ($laoddefaultpage) {
    include $laoddefaultpage;
    $laoddefaultpage = NULL;
} else {
    include "menumaster.php";
}
echo "  </div>\n";
$fileverioncheck = "6.1.0";

?>