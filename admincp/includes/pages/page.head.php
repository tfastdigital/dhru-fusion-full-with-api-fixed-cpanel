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
echo "<ul id=\"tabmenu\">\n    <li><a ";
if ($page == "viewpage") {
    echo "class=\"tabmenu_active\"";
}
echo " onclick=\"getContect('#tab1','main2.php?page=viewpage','','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
echo $LNG["custompages"];
echo "</a></li>\n</ul>";
$fileverioncheck = "6.1.0";

?>