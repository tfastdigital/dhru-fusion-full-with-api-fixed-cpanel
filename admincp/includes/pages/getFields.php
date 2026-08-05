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
require "../../../comm.php";
require "../fun.inc.php";
require_once "../../includes/fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($_GET["type"] == "country") {
    echo "    <select name=\"pid\">\n    <option value=\"\">";
    echo $LNG["select"];
    echo "</option>  \n  ";
    if ($api) {
        $s = dquery("select * from tbl_provider where C_ID='" . $id . "' and api='" . $api . "'");
        while ($r = mysqli_fetch_assoc($s)) {
        }
        echo "    </select>\n  ";
    } else {
        $s = dquery("select * from tbl_provider where C_ID='" . $id . "'");
    }
    echo "    <option value=\"";
    echo $r["ID"];
    echo "\">";
    echo $r["Name"];
    echo "</option>\n    ";
} else {
    if ($_GET["type"] == "brand") {
        echo "    <select name=\"mid\">\n    <option value=\"\">";
        echo $LNG["select"];
        echo "</option>  \n  ";
        if ($api) {
            $s = dquery("select * from tbl_mobile where B_ID='" . $id . "' and api='" . $api . "'");
            while ($r = mysqli_fetch_assoc($s)) {
            }
            echo "    </select>\n  ";
        } else {
            $s = dquery("select * from tbl_mobile where B_ID='" . $id . "'");
        }
        echo "    <option value=\"";
        echo $r["ID"];
        echo "\">";
        echo $r["Name"];
        echo "</option>\n    ";
    }
}

?>