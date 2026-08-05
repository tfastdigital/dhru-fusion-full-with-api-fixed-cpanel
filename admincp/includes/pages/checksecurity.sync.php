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
require_once ROOTDIR . "/" . $admindirpath . "/" . "includes/fun.inc.php";
require_once ROOTDIR . "/" . $admindirpath . "/includes/comm.inc.php";
if (!$_SESSION["adminid"] || $special == "7288729282") {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
ob_start();
checkSecurity("../../../");
$OUT = ob_get_contents();
ob_end_clean();
echo "    <style>\n        body {\n            font-family: arial;\n            color: gray;\n            font-size: 10px;\n        }\n\n        .header {\n            color: black;\n            font-weight: bolder;\n        }\n\n        .error {\n            color: #C60000;\n        }\n    </style>\n";
echo $OUT;
$fileverioncheck = "6.1.0";

?>