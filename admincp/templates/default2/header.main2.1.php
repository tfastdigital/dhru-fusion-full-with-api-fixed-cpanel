<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<!DOCTYPE html>\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n<meta http-equiv=\"content-type\"\tcontent=\"text/html; charset=";
echo $config["admincharset"];
echo "\" />\n<title>Dhru Fusion ";
echo $lite ? "lite" : "";
echo "</title>\n    ";
global $OnlyEcommerce;
global $versioncatch;
echo "<link rel=\"stylesheet\" href=\"templates/";
echo $admin_template;
echo "/css/style.css?v=";
echo $versioncatch;
echo "\" />\n<script src=\"http://code.jquery.com/jquery-latest.min.js?v=";
echo $versioncatch;
echo "\"  type=\"text/javascript\"></script>\n<script src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/main2.fun.js?v=";
echo $versioncatch;
echo "\" type=\"text/javascript\"></script>\n<script src=\"includes/js/validation.js?v=";
echo $versioncatch;
echo "\" type=\"text/javascript\"></script>\n<script src=\"includes/js/tablefilter.js?v=";
echo $versioncatch;
echo "\" type=\"text/javascript\"></script>\n\n<script type='text/javascript' src='includes/3rdparty/datagrid/scripts/dg.js?v=";
echo $versioncatch;
echo "'></script>\n<script type='text/javascript' src='includes/3rdparty/datagrid/languages/js/dg-en.js?v=";
echo $versioncatch;
echo "'></script>\n<script type='text/javascript' src='includes/3rdparty/datagrid/scripts/highlight.js?v=";
echo $versioncatch;
echo "'></script>\n    <link rel=\"stylesheet\" href='includes/3rdparty/datagrid/modules/jscalendar/skins/aqua/theme.css?v=";
echo $versioncatch;
echo "' />\n    <script type='text/javascript' src='includes/3rdparty/datagrid/modules/jscalendar/calendar.js?v=";
echo $versioncatch;
echo "'></script>\n<script type='text/javascript' src='includes/3rdparty/datagrid/modules/jscalendar/lang/calendar-en.js?v=";
echo $versioncatch;
echo "'></script>\n<script type='text/javascript' src='includes/3rdparty/datagrid/modules/jscalendar/calendar-setup.js?v=";
echo $versioncatch;
echo "'></script>\n<script type='text/javascript' src='includes/3rdparty/datagrid/scripts/dg_ajax.js?v=";
echo $versioncatch;
echo "'></script>\n\n<link rel=\"stylesheet\" href=\"templates/";
echo $_SESSION["admin_template"];
echo "/main2.css?v=";
echo $versioncatch;
echo "\" />\n\n<script>\n    toggleHidetabmenu();\n</script>\n\n</head>\n\n<body class=\"main3 ";
echo $_SESSION["admintheme"];
echo "\">\n  <div id=\"mainContent\">\n<div id=\"main_loader\" style=\"display: none;\">\n<div class=\"aProgress\"><div class=\"aBar slow\"></div><div class=\"aSpinner\"><div class=\"spinner-icon\"></div></div></div>            \n</div>\n<div id=\"iframeforedit2\"></div>";

?>