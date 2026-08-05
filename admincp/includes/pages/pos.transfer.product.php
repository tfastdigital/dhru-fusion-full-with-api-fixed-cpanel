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
if ($searialno) {
    $sql = mysqli_fetch_assoc(dquery("select DISTINCT pid,serial,\n    (select service_name from tbl_products where id=pid)\n     as service from tbl_serial_list where serial LIKE '" . $s . "' and status='0'\n     and wid='" . $_SESSION["WAREHOUSEF"] . "'"));
    echo $sql["pid"];
    exit;
}
if ($searialq) {
    if ($stype == 2) {
        $sql = mysqli_fetch_assoc(dquery("select DISTINCT pid,serial,\n        (select service_name from tbl_products where id=pid)\n        as service from tbl_serial_list where serial LIKE '" . $s . "' and status='1'\n        and wid='" . $_SESSION["WAREHOUSE"] . "'"));
        if ($sql["pid"]) {
            echo $sql["pid"];
        } else {
            echo "NOT";
        }
    } else {
        $sql = mysqli_fetch_assoc(dquery("select DISTINCT pid,serial,\n        (select service_name from tbl_products where id=pid)\n        as service from tbl_serial_list where serial LIKE '" . $s . "' and status='0'\n        and wid='" . $_SESSION["WAREHOUSE"] . "' and transist=''"));
        echo $sql["pid"];
        if (!$sql["pid"]) {
            if (mysqli_num_rows(dquery("select  DISTINCT pid,serial,\n            (select service_name from tbl_products where id=pid)\n             as service from tbl_serial_list where serial LIKE '" . $s . "' and status='0'"))) {
                echo "TELL";
            } else {
                if (!mysqli_num_rows(dquery("select  id from \n                tbl_products where id='" . $s . "'"))) {
                    echo "NOT";
                }
            }
        }
    }
    exit;
}
if ($search != "") {
    $sql = dquery("select id,service_name from tbl_products where service_name LIKE '" . $search . "%' and active='1'");
    while ($row = mysqli_fetch_assoc($sql)) {
        $stock = getWarehouseStock($_SESSION["WAREHOUSEF"], $row["id"]);
        if (0 < $stock) {
            echo "<li><a style='text-decoration:none;' class='" . $row["id"] . "' onclick='setVLL(" . $row["id"] . ")'>" . $row["service_name"] . "</a></li>";
        }
    }
}
$fileverioncheck = "6.1.0";

?>