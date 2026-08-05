<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
require_once "../../configs/config.php";
$conn = mysqli_connect($config["server"], $config["user"], $config["pass"], $config["database"]);
if (!$conn) {
    exit("Connection failed: " . $conn->connect_error);
}
if (dquery("delete from tbl_settings where attribute='config'", $conn)) {
    echo "Settings fixed now again run installer to continue";
} else {
    echo "Error";
}
if ($_GET["action"] == "purchasecost") {
    require_once "../../comm.php";
    require_once "settings.inc.php";
    require_once "functions.inc.php";
    $db = new MySQLDump1();
    $db->connect($config["server"], $config["user"], $config["pass"], $config["database"]);
    require_once "../../includes/fun.inc.php";
    require_once "../../includes/invoice.fun.php";
    $sql = dquery("select purchase_cost,order_id,user_id from tbl_order_product", $conn);
    while ($row = mysqli_fetch_assoc($sql)) {
        $client = mysqli_fetch_assoc(dquery("select default_currency from tblUsers where id='" . $row["user_id"] . "'"));
        if ($_SESSION["system_default_currency"]["id"] != $client["default_currency"]) {
            $purcost = convertCurrency($row["purchase_cost"], $_SESSION["system_default_currency"]["id"], $client["default_currency"]);
            dquery("update tbl_order_product set purchase_cost='" . $purcost . "' where order_id='" . $row["order_id"] . "'", $conn);
        }
    }
    $sql = dquery("select purchase_cost,order_id,user_id from tbl_order_imei", $conn);
    while ($row = mysqli_fetch_assoc($sql)) {
        $client = mysqli_fetch_assoc(dquery("select default_currency from tblUsers where id='" . $row["user_id"] . "'"));
        if ($_SESSION["system_default_currency"]["id"] != $client["default_currency"]) {
            $purcost = convertCurrency($row["purchase_cost"], $_SESSION["system_default_currency"]["id"], $client["default_currency"]);
            dquery("update tbl_order_imei set purchase_cost='" . $purcost . "' where order_id='" . $row["order_id"] . "'", $conn);
        }
    }
    $sql = dquery("select purchase_cost,order_id,user_id from tbl_order_file", $conn);
    while ($row = mysqli_fetch_assoc($sql)) {
        $client = mysqli_fetch_assoc(dquery("select default_currency from tblUsers where id='" . $row["user_id"] . "'"));
        if ($_SESSION["system_default_currency"]["id"] != $client["default_currency"]) {
            $purcost = convertCurrency($row["purchase_cost"], $_SESSION["system_default_currency"]["id"], $client["default_currency"]);
            dquery("update tbl_order_file set purchase_cost='" . $purcost . "' where order_id='" . $row["order_id"] . "'", $conn);
        }
    }
    $sql = dquery("select purchase_cost,order_id,user_id from tbl_order_server", $conn);
    while ($row = mysqli_fetch_assoc($sql)) {
        $client = mysqli_fetch_assoc(dquery("select default_currency from tblUsers where id='" . $row["user_id"] . "'", $conn));
        if ($_SESSION["system_default_currency"]["id"] != $client["default_currency"]) {
            $purcost = convertCurrency($row["purchase_cost"], $_SESSION["system_default_currency"]["id"], $client["default_currency"]);
            dquery("update tbl_order_server set purchase_cost='" . $purcost . "' where order_id='" . $row["order_id"] . "'", $conn);
        }
    }
}

?>