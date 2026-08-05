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
echo "<ul id=\"tabmenu\" class=\"visible\">\n    <li class=\"tabmenu-header\"><span>Submenu</span></li>\n    <span class=\"toggle-tabmenu\"><span>::</span><span style=\"margin-top:-5px;\">::</span></span>\n    <li><a ";
if ($page == "clientlist") {
    echo "class=\"tabmenu_active\"";
}
echo " onclick=\"getContect('#tab1','main2.php?page=clientlist','','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
echo $LNG["clientlist"];
echo "</a></li>\n    <li><a ";
if ($page == "addnewclient") {
    echo "class=\"tabmenu_active\"";
}
echo " onclick=\"getContect('#tab2','main2.php?page=addnewclient','','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >+ ";
echo $LNG["addnewclient"];
echo "</a></li>\n    <li><a ";
if ($page == "addbulkclient") {
    echo "class=\"tabmenu_active\"";
}
echo " onclick=\"getContect('#tab23','main2.php?page=addbulkclient','','','#tabcontent',true,'#main_loader');\" id=\"tab23\" >+ Add Bulk Client</a></li>\n";
if (!$OnlyEcommerce) {
    echo "     \n    <li><a ";
    if ($page == "clientgroup") {
        echo "class=\"tabmenu_active\"";
    }
    echo " onclick=\"getContect('#tab3','main2.php?page=clientgroup','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
    echo $LNG["clientgroup"];
    echo "</a></li>\n    <li><a ";
    if ($page == "updatemultipalclient") {
        echo "class=\"tabmenu_active\"";
    }
    echo " onclick=\"getContect('#tab4','main2.php?page=updatemultipalclient&clear=true','','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >";
    echo $LNG["update"];
    echo " ";
    echo $LNG["multipal"];
    echo " ";
    echo $LNG["account"];
    echo "</a></li>\n";
}
echo "    <li><a ";
if ($page == "blockmultipleclient") {
    echo "class=\"tabmenu_active\"";
}
echo " onclick=\"getContect('#tab6','main2.php?page=blockmultipleclient&clear=true','','','#tabcontent',true,'#main_loader');\" id=\"tab6\" >Block ";
echo $LNG["multipal"];
echo " ";
echo $LNG["account"];
echo "</a></li>\n\n    <li><a ";
if ($page == "guestlist") {
    echo "class=\"tabmenu_active\"";
}
echo " onclick=\"getContect('#tab5','main2.php?page=guestlist','','','#tabcontent',true,'#main_loader');\" id=\"tab5\" >";
echo $LNG["checkout"];
echo " ";
echo $LNG["as"];
echo " ";
echo $LNG["guest"];
echo "</a></li>\n  \n</ul>\n";
$fileverioncheck = "6.1.0";

?>