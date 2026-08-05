<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n#tabmenu{padding:0 10px !important;}\n</style>\n";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
echo "<ul id=\"tabmenu\">     \n    <li><a ";
if (!$laoddefaultpage) {
    echo "class='tabmenu_active'";
}
echo "  onclick=\"getContect('#tab1','main2.php?page=utilities.templateeditor','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
echo $LNG["template"];
echo " ";
echo $LNG["style"];
echo " ";
echo $LNG["editor"];
echo " </a></li> \n    <li><a ";
if ($laoddefaultpage) {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab2','main2.php?page=templatelist','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
echo $LNG["history"];
echo "</a></li>    \n<div style=\"clear: both;\"></div>\n</ul>\n<div id=\"notification\"></div>\n<div id=\"tabcontent\"> ";
if ($laoddefaultpage) {
    include $laoddefaultpage;
    $laoddefaultpage = NULL;
} else {
    include "utilities.templateeditor.php";
}
echo "  </div>";
$fileverioncheck = "6.1.0";

?>