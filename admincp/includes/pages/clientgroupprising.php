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
echo "<ul id=\"tabmenu\">  \n\n";
if ($IsFileOnly) {
    echo "   <li><a id=\"tab2\" class='tabmenu_active'  onclick=\"getContect('#tab2','main2.php?page=filegroupprice','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\"  >";
    echo $LNG["fileserviceprising"];
    echo "</a></li>\n";
} else {
    echo "    <li><a id=\"tab1\"  class='tabmenu_active' onclick=\"getContect('#tab1','main2.php?page=imeigroupprice','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" >";
    echo $LNG["imeiserviceprising"];
    echo "</a></li>\n    <li><a id=\"tab2\" onclick=\"getContect('#tab2','main2.php?page=filegroupprice','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\"  >";
    echo $LNG["fileserviceprising"];
    echo "</a></li>\n    <li><a id=\"tab3\" onclick=\"getContect('#tab3','main2.php?page=servergroupprice','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\"  >";
    echo $LNG["serverlogserviceprising"];
    echo "</a></li>\n    <li><a id=\"tab4\" onclick=\"getContect('#tab4','main2.php?page=productgroupprice','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\"  >";
    echo $LNG["product"];
    echo " ";
    echo $LNG["pricing"];
    echo "</a></li>\n";
}
echo "      \n<div style=\"clear: both;\"></div>\n</ul>\n<div id=\"tabcontent\"> ";
if ($IsFileOnly) {
    include "filegroupprice.php";
} else {
    include "imeigroupprice.php";
}
echo "  </div>  ";
$fileverioncheck = "6.1.0";

?>