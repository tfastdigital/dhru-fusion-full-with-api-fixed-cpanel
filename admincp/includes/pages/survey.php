<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 516;
checkPagePermission($pageid);
echo "<ul id=\"tabmenu\">\n <li><a ";
if (!$laoddefaultpage == "listsurvey.php") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab1','main2.php?page=createsurvey','','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
echo $LNG["create"];
echo " ";
echo $LNG["survey"];
echo "</a></li>\n <li><a ";
if ($laoddefaultpage == "listsurvey.php") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab2','main2.php?page=listsurvey','','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
echo $LNG["list"];
echo " ";
echo $LNG["survey"];
echo "</a></li>\n<div style=\"clear: both;\"></div>\n</ul>  \n<div id=\"tabcontent\">\n";
if ($laoddefaultpage) {
    include $laoddefaultpage;
} else {
    include "createsurvey.php";
}
echo "</div>";
$fileverioncheck = "6.1.0";

?>