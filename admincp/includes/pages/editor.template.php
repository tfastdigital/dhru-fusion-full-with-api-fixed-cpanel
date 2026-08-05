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
$rt = mysqli_fetch_assoc(dquery("select * from tbl_templates where `id`='" . $file . "'"));
if (deregi("css/", $rt["tpl"])) {
    $arg = explode("/", $rt["tpl"]);
    $ctpl = file_get_contents("../templates/" . $template . "/" . $rt["tpl"], FILE_USE_INCLUDE_PATH);
    $path = "../templates/" . $template . "/css/ver/" . $arg . "txt";
} else {
    $ctpl = file_get_contents("../templates/" . $template . "/" . $rt["tpl"] . ".tpl", FILE_USE_INCLUDE_PATH);
    $path = "../templates/" . $template . "/ver/" . $rt["tpl"] . ".txt";
}
$cversion = "1.0";
if (is_file($path)) {
    $clog = file_get_contents($path, FILE_USE_INCLUDE_PATH);
    $clog = unserialize($clog);
    $cversion = $clog["version"];
}
$tlog = file("../templates/tlog.txt");
foreach ($tlog as $tl) {
    $te = explode("=", $tl);
    if (trim($te[1]) == $template) {
        $oversion = "1.0";
        $arg = end(explode("/", $rt["tpl"]));
        if (is_file("../templates/" . trim($te[0]) . "/cart/default/ver/" . $arg . ".txt")) {
            $clog = file_get_contents("../templates/" . trim($te[0]) . "/cart/default/ver/" . $arg . ".txt", FILE_USE_INCLUDE_PATH);
            $clog = unserialize($clog);
            $oversion = $clog["version"];
        } else {
            if (is_file("../templates/" . trim($te[0]) . "/cart/SingalPage/ver/" . $arg . ".txt")) {
                $clog = file_get_contents("../templates/" . trim($te[0]) . "/cart/SingalPage/ver/" . $arg . ".txt", FILE_USE_INCLUDE_PATH);
                $clog = unserialize($clog);
                $oversion = $clog["version"];
            } else {
                if (is_file("../templates/" . trim($te[0]) . "/cart/Steps/ver/" . $arg . ".txt")) {
                    $clog = file_get_contents("../templates/" . trim($te[0]) . "/cart/Steps/ver/" . $arg . ".txt", FILE_USE_INCLUDE_PATH);
                    $clog = unserialize($clog);
                    $oversion = $clog["version"];
                } else {
                    if (is_file("../templates/" . trim($te[0]) . "/css/ver/" . $arg . ".txt")) {
                        $clog = file_get_contents("../templates/" . trim($te[0]) . "/css/ver/" . $arg . ".txt", FILE_USE_INCLUDE_PATH);
                        $clog = unserialize($clog);
                        $oversion = $clog["version"];
                    } else {
                        if (is_file("../templates/" . trim($te[0]) . "/ver/" . $rt["tpl"] . ".txt")) {
                            $clog = file_get_contents("../templates/" . trim($te[0]) . "/ver/" . $rt["tpl"] . ".txt", FILE_USE_INCLUDE_PATH);
                            $clog = unserialize($clog);
                            $oversion = $clog["version"];
                        }
                    }
                }
            }
        }
    }
}
echo "\n<ul id=\"tabmenu\"> \n<li><a ";
if (!$laoddefaultpage) {
    echo "class='tabmenu_active'";
}
echo " \n            onclick=\"getContect('#tab','main2.php?page=currenttemplate&template=";
echo $template;
echo "&file=";
echo $file;
echo "','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["current"];
echo " ";
echo $LNG["template"];
echo "</a></li>\n             \n<li><a ";
if ($laoddefaultpage == "templatehistory.php") {
    echo "class='tabmenu_active'";
}
echo " \n            onclick=\"getContect('#tab12','main2.php?page=templatehistory&template=";
echo $template;
echo "&file=";
echo $file;
echo "','','','#tabcontent',true,'#main_loader');\" id=\"tab12\" >";
echo $LNG["template"];
echo " ";
echo $LNG["history"];
echo "</a></li>\n";
if ($oversion != $cversion) {
    echo "         \n<li><a ";
    if ($laoddefaultpage == "editor.newversion.php") {
        echo "class='tabmenu_active'";
    }
    echo " \n            onclick=\"getContect('#tab13','main2.php?page=editor.newversion&template=";
    echo $template;
    echo "&file=";
    echo $file;
    echo "','','','#tabcontent',true,'#main_loader');\" id=\"tab13\" >";
    echo $LNG["new"];
    echo " ";
    echo $LNG["version"];
    echo "</a></li>\n";
}
echo "            \n<div style=\"clear: both;\"></div>\n</ul>\n<div id=\"tabcontent\"> \n";
if ($laoddefaultpage) {
    include $laoddefaultpage;
    $laoddefaultpage = NULL;
} else {
    include "currenttemplate.php";
}
echo "  </div>\n \n";
$fileverioncheck = "6.1.0";

?>