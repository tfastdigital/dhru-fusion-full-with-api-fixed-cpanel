<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "./comm.php";
$flag = false;
if ($_SESSION["CART"]) {
    foreach ($_SESSION["CART"] as $cartdtl) {
        if ($cartdtl["type"] == "product") {
            $slq = mysqli_fetch_assoc(dquery("select virtual from tbl_products \r\n                                                        where id='" . $cartdtl["id"] . "'"));
            if (!$slq["virtual"]) {
                $flag = true;
            }
        }
    }
}
if ($flag) {
    global $curriers;
    if (!$curriers) {
        echo "required";
    }
}

?>