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
if (is_file("../../../" . $languagedirectorypath . "/" . $config["language"] . ".txt")) {
    ob_start();
    include "../../../" . $languagedirectorypath . "/" . $config["language"] . ".txt";
    $lang_cont = ob_get_contents();
    ob_end_clean();
    eval($lang_cont);
    $orgirr = $lng_languag;
    foreach ($orgirr as $k => $v) {
        if (stripos($v, $val) !== false) {
            echo "<li onclick='javascript: setLangValue(\"" . $k . "\",\"" . $v . "\"); '>" . $v . "</li>";
        }
    }
}
$fileverioncheck = "6.1.0";

?>