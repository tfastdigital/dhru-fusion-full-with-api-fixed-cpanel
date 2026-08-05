<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("ADMIN", true);
define("DEFINE_DHRU_FILE", true);
require "../../../comm.php";
$flage = "true";
if ($display == "cart") {
    if (is_file(ROOTDIR . "/templates/" . $config["template"] . "/cart/" . $id . "/cartstylepreview.png")) {
        echo "<img src='../templates/" . $config["template"] . "/cart/" . $id . "/cartstylepreview.png'/>";
        $flage = false;
        exit;
    }
    echo "<div align=center> " . $LNG["no"] . "  " . $LNG["preview"] . "  " . $LNG["available"] . "</div>";
} else {
    if (is_file(ROOTDIR . "/templates/" . $id . "/images/preview.jpg")) {
        echo "<img src='../templates/" . $id . "/images/preview.jpg'/>";
        $flage = false;
        exit;
    }
    echo "<div align=center> " . $LNG["no"] . "  " . $LNG["preview"] . "  " . $LNG["available"] . "</div>";
}

?>