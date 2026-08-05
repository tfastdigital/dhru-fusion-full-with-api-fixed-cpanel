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
echo "<ul id=\"tabmenu\" class=\"visible\">\n    <li><a ";
if ($page == "supplierlist") {
    echo "class=\"tabmenu_active\"";
}
echo " onclick=\"getContect('#tab1','main2.php?page=supplierlist','','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
echo $LNG["supplierlist"];
echo "</a></li>\n    <li><a ";
if ($page == "addnewsupplier") {
    echo "class=\"tabmenu_active\"";
}
echo " onclick=\"getContect('#tab2','main2.php?page=addnewsupplier','','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >+ ";
echo $LNG["addnewsupplier"];
echo "</a></li>    \n</ul>";
$fileverioncheck = "6.1.0";

?>