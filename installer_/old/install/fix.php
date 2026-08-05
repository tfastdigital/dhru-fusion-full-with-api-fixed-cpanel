<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
require_once "../../comm.php";
require_once "settings.inc.php";
require_once "functions.inc.php";
$db = new MySQLDump1();
$db->connect($config["server"], $config["user"], $config["pass"], $config["database"]);
dquery("delete from tbl_settings where attribute='config'");
$conf = mysqli_fetch_assoc(dquery("select value from tbl_settings where attribute='config_backup'"));
dquery("insert into tbl_settings (`attribute`,`value`) values ('config','" . $conf["value"] . "')");
echo "Config is restored from backup... ";
if ($_GET["action"] == "purchasecost") {
    require_once "../../includes/fun.inc.php";
    require_once "../../includes/invoice.fun.php";
    $sql = dquery("select purchase_cost,order_id,user_id from tbl_order_product");
    while ($row = mysqli_fetch_assoc($sql)) {
        $client = mysqli_fetch_assoc(dquery("select default_currency from tblUsers where id='" . $row["user_id"] . "'"));
        if ($_SESSION["system_default_currency"]["id"] != $client["default_currency"]) {
            $purcost = convertCurrency($row["purchase_cost"], $_SESSION["system_default_currency"]["id"], $client["default_currency"]);
            dquery("update tbl_order_product set purchase_cost='" . $purcost . "' where order_id='" . $row["order_id"] . "'");
        }
    }
    $sql = dquery("select purchase_cost,order_id,user_id from tbl_order_imei");
    while ($row = mysqli_fetch_assoc($sql)) {
        $client = mysqli_fetch_assoc(dquery("select default_currency from tblUsers where id='" . $row["user_id"] . "'"));
        if ($_SESSION["system_default_currency"]["id"] != $client["default_currency"]) {
            $purcost = convertCurrency($row["purchase_cost"], $_SESSION["system_default_currency"]["id"], $client["default_currency"]);
            dquery("update tbl_order_imei set purchase_cost='" . $purcost . "' where order_id='" . $row["order_id"] . "'");
        }
    }
    $sql = dquery("select purchase_cost,order_id,user_id from tbl_order_file");
    while ($row = mysqli_fetch_assoc($sql)) {
        $client = mysqli_fetch_assoc(dquery("select default_currency from tblUsers where id='" . $row["user_id"] . "'"));
        if ($_SESSION["system_default_currency"]["id"] != $client["default_currency"]) {
            $purcost = convertCurrency($row["purchase_cost"], $_SESSION["system_default_currency"]["id"], $client["default_currency"]);
            dquery("update tbl_order_file set purchase_cost='" . $purcost . "' where order_id='" . $row["order_id"] . "'");
        }
    }
    $sql = dquery("select purchase_cost,order_id,user_id from tbl_order_server");
    while ($row = mysqli_fetch_assoc($sql)) {
        $client = mysqli_fetch_assoc(dquery("select default_currency from tblUsers where id='" . $row["user_id"] . "'"));
        if ($_SESSION["system_default_currency"]["id"] != $client["default_currency"]) {
            $purcost = convertCurrency($row["purchase_cost"], $_SESSION["system_default_currency"]["id"], $client["default_currency"]);
            dquery("update tbl_order_server set purchase_cost='" . $purcost . "' where order_id='" . $row["order_id"] . "'");
        }
    }
}

?>