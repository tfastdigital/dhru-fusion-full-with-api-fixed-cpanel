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
echo "<ul id=\"tabmenu\">     \n    <li><a ";
if (!$defaultload) {
    echo "class=tabmenu_active";
}
echo " onclick=\"getContect('#tab1','main2.php?page=productfeaturelist','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
echo $LNG["product"];
echo " ";
echo $LNG["feature"];
echo " ";
echo $LNG["list"];
echo "</a></li> \n    <li><a ";
if ($defaultload == "productfeature.php") {
    echo "class=tabmenu_active";
}
echo " onclick=\"getContect('#tab2','main2.php?page=productfeature.add','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
echo $LNG["add"] . " / " . $LNG["edit"] . " " . $LNG["product"];
echo " ";
echo $LNG["feature"];
echo "</a></li>    \n<div style=\"clear: both;\"></div>\n</ul>\n\n";
$fileverioncheck = "6.1.0";

?>