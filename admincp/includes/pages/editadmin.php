<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
if (!$nottoload) {
    echo "<ul id=\"tabmenu\">\n <li><a class='tabmenu_active'\n     onclick=\"getContect('#tab1','main2.php?page=editadmin&nottoload=1&admn=";
    echo $admn;
    echo "','','','#tabcontent',true,'#main_loader');\" \n     id=\"tab1\" >My Account</a></li>\n     \n <li><a \n onclick=\"getContect('#tab2','main2.php?page=adminfund&admn=";
    echo $admn;
    echo "','','','#tabcontent',true,'#main_loader');\"\n  id=\"tab2\" >";
    echo $LNG["admin"];
    echo " ";
    echo $LNG["fund"];
    echo " Limit</a></li>\n \n \n <li><a  \n onclick=\"getContect('#tab3','main2.php?page=secondlogin&admn=";
    echo $admn;
    echo "','','','#tabcontent',true,'#main_loader');\"\n  id=\"tab3\" >Second Authentication</a></li>\n  \n<li><a  \nonclick=\"getContect('#tab4','main2.php?page=creditstatement.admin&admn=";
    echo $admn;
    echo "','','','#tabcontent',true,'#main_loader');\"\nid=\"tab4\" >";
    echo $LNG["credit"];
    echo " ";
    echo $LNG["statement"];
    echo "</a></li>\n\n\n<div style=\"clear: both;\"></div>\n</ul>  \n";
}
echo "<div id=\"tabcontent\">\n";
if ($defaultpage) {
    include $defaultpage;
} else {
    include "adminpassword.php";
    include "myaccount.php";
}
echo "</div>\n";
$fileverioncheck = "6.1.0";

?>