<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require_once "../../../comm.php";
require_once "../../../includes/fun.inc.php";
require_once "../../includes/fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
echo "<!DOCTYPE HTML>\n<html>\n\n<head>\n    <meta http-equiv=\"content-type\" content=\"text/html\" />\n    \n    <link href=\"../../../includes/icons/menu-icon.css\" rel=\"stylesheet\" />\n        \n    <script>\n        function setIcon(val){\n            opener.document.getElementById('icon').value=val;\n            opener.document.getElementById('view-icon').className=val;\n            self.close();\n        }\n    </script>\n    \n    \n    <style>\n        i.icon{\n            font-size:50px;\n            border: #ccc solid 1px;\n            margin:10px;\n            text-align:center;\n            width:100px;\n            float:left;\n            cursor:pointer;\n            height:90px;\n        }\n    </style>\n\n</head>\n\n<body>\n\n    ";
$lines = @file("../../../includes/icons/menu-icon.css");
foreach ($lines as $line) {
    if (strpos($line, ":before") !== false && !strpos($line, "]:before")) {
        $class = str_replace(".", "", $line);
        $class = trim(str_replace(":before {", "", $class));
        echo "<i class='icon " . $class . "' onClick=\"setIcon('" . $class . "')\"> </i>";
    }
}
echo "    </body>\n\n</html>";
$fileverioncheck = "6.1.0";

?>