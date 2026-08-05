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
if ($cont) {
    if ($layoutid) {
        $lay = mysqli_fetch_assoc(dquery("select  * from tbl_email_layout\r\nwhere id='" . $layoutid . "'"));
        $cont = str_replace(" ", "+", $cont);
        $_SESSION["preview"] = $lay["header"] . base64_decode($cont) . $lay["footer"];
    } else {
        $_SESSION["preview"] = base64_decode($cont);
    }
} else {
    echo "    <html>\r\n";
    $message = $_SESSION["preview"];
    include_once ROOTDIR . "/includes/smarty/Smarty.class.php";
    $smarty = new SmartyBC();
    $smarty->caching = 0;
    $smarty->compile_dir = ROOTDIR . "/" . $templatecompilerpath;
    $smarty->compile_id = md5($subject . $message);
    $smarty->assign("emailsubject", $subject);
    $smarty->assign("emailmessage", $message);
    echo html_entity_decode($message);
    echo "    </html>\r\n";
}

?>