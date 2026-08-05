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
$search = $_POST["val"];
if ($fil) {
    $fil = trim($fil);
    $sql = dquery("select id,service_name,(select group_name from tbl_product_group\n     where id=group_id) as groups\n     from tbl_products where service_name LIKE '%" . $fil . "%' \n    limit 5");
    while ($row = mysqli_fetch_assoc($sql)) {
        if ($row["groups"]) {
            echo "<li class='list'><a style='text-decoration:none;' \n        class='" . $row["id"] . "' \n        onclick='setVLL(\"" . $row["id"] . "\")'>" . $row["service_name"] . " <small style=\"color:yellow;\">in " . $row["groups"] . "</small></a></li>";
        }
    }
} else {
    if ($search != "") {
        $sql = dquery("select id,service_name\n     from tbl_products where service_name LIKE '%" . $search . "%' and active='1' \n     and bysupplier='0' limit 4");
        while ($row = mysqli_fetch_assoc($sql)) {
            echo "<li class='list'><a style='text-decoration:none;' class='" . $row["id"] . "' onclick='setVLL(\"" . $row["id"] . "--" . $row["service_name"] . "\")'>" . $row["service_name"] . "</a></li>";
        }
    }
}
$fileverioncheck = "6.1.0";

?>