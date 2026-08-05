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
include "../../includes/3rdparty/google.translate.php";
if ($id) {
    $sql = mysqli_fetch_assoc(dquery("select message from tbl_smstemplate where id='" . $id . "'"));
    $sql["message"] = str_replace("{", "((", $sql["message"]);
    $sql["message"] = str_replace("}", "))", $sql["message"]);
    $sql["message"] = str_replace("\$", "_", $sql["message"]);
    $sql["message"] = nl2br($sql["message"]);
    if ($language != "English" && $language != "") {
        $outm = getTr($config["googlelanguageapi"], $language, $sql["message"]);
        $outm = str_replace("((", "{", $outm);
        $outm = str_replace("))", "}", $outm);
        $outm = str_replace("_", "\$", $outm);
        $outm = str_replace("<br />", "\n", $outm);
    }
    if ($outm) {
        echo $outm;
    }
}
$fileverioncheck = "6.1.0";

?>