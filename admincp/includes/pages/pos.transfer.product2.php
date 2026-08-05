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
require_once "../../../includes/products.fun.php";
$search = $_POST["val"];
if ($search != "") {
    $sql = dquery("select DISTINCT pid,serial,(select service_name from tbl_products where id=pid) \n    as service from tbl_serial_list where serial LIKE '" . $search . "%' and status='0' GROUP BY pid");
    if (mysqli_num_rows($sql)) {
        while ($row = mysqli_fetch_assoc($sql)) {
            $stock = getWarehouseStock($_SESSION["WAREHOUSEF"], $row["pid"]);
            if (0 < $stock && $row["service"]) {
                echo "<li><a style='text-decoration:none;' class='" . $row["serial"] . "' onclick='setVLL(" . $row["serial"] . ")'>" . $row["service"] . " - " . $row["serial"] . "</a></li>";
            }
        }
    }
}
$fileverioncheck = "6.1.0";

?>