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
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
if (!isset($_SESSION["uid"])) {
    exit;
}
if ($actions) {
    $action = $actions;
}
$templatefile = "client_settings_package";
if ($type == "shop") {
    $pagetitle = $lng_languag["products"];
    $_nav .= "<a href='" . _url("widget/settingsservices/a/action/subscription/type/shop") . "' >" . $lng_languag["products"] . "</a> / ";
    $pageicon = "";
    installclient($pagetitle, $pageicon, $breadcrumbnav);
    $sql = dquery("select id,service_name from tbl_products where active='1' and subscribe='1'");
    while ($row = mysqli_fetch_assoc($sql)) {
        $serviceDetails[$row["id"]] = $row;
    }
    $tempalte_ver["shopservicelist"] = $serviceDetails;
    $sql = dquery("SELECT id,service_id,user_id,(select service_name from \n                   tbl_products where id=service_id) as service,status,subscribe_start,subscribe_end \n                   FROM tbl_subscribers WHERE user_id='" . $_SESSION["uid"] . "' AND type='tbl_products'");
    while ($row = mysqli_fetch_assoc($sql)) {
        $time = time();
        $row["stat"] = $row["status"];
        if (0 < ($row["subscribe_end"] - $time) / 86400) {
            $row["days"] = intval(($row["subscribe_end"] - $time) / 86400);
        } else {
            $row["days"] = 0;
        }
        if ($row["status"] == "active") {
            $row["status"] = "<span class='textgreen'>Active</span>";
        } else {
            $row["status"] = "<span class='textred'>" . ucfirst($row["status"]) . "</span>";
        }
        $uid = $_SESSION["uid"];
        $sid = $row["service_id"];
        $cur = mysqli_fetch_assoc(dquery("SELECT default_currency FROM \n                            tblUsers WHERE id='" . $uid . "'"));
        $serv = mysqli_fetch_assoc(dquery("SELECT subscribe_credit,subscribe_days \n                        FROM tbl_products where id='" . $sid . "'"));
        $table = "tbl_products";
        $price = subscribeCurrency($sid, $table, $cur["default_currency"]);
        $row["price"] = $price;
        $row["subscribe_start"] = date("Y-m-d", $row["subscribe_start"]);
        $row["subscribe_end"] = date("Y-m-d", $row["subscribe_end"]);
        $tempalte_ver["subscription"][$row["id"]] = $row;
    }
    $tempalte_ver["getpricelink"] = _url("widget/getSubprice");
} else {
    if ($type == "file") {
        $pagetitle = $lng_languag["fileservice"];
        $_nav .= "<a href='" . _url("widget/settingsservices/a/action/subscription/type/file") . "' >" . $lng_languag["fileservice"] . "</a> / ";
        $pageicon = "";
        installclient($pagetitle, $pageicon, $breadcrumbnav);
        $sql = dquery("select id,service_name from tbl_services_file where active='1' and subscribe='1'");
        while ($row = mysqli_fetch_assoc($sql)) {
            $serviceDetails[$row["id"]] = $row;
        }
        $tempalte_ver["fileservicelist"] = $serviceDetails;
        $sql = dquery("SELECT id,service_id,user_id,(select service_name from \n                   tbl_services_file where id=service_id) as service,status,subscribe_start,subscribe_end \n                   FROM tbl_subscribers WHERE user_id='" . $_SESSION["uid"] . "' AND type='tbl_services_file'");
        while ($row = mysqli_fetch_assoc($sql)) {
            $time = time();
            $row["stat"] = $row["status"];
            if (0 < ($row["subscribe_end"] - $time) / 86400) {
                $row["days"] = intval(($row["subscribe_end"] - $time) / 86400);
            } else {
                $row["days"] = 0;
            }
            if ($row["status"] == "active") {
                $row["status"] = "<span class='textgreen'>Active</span>";
            } else {
                $row["status"] = "<span class='textred'>" . ucfirst($row["status"]) . "</span>";
            }
            $uid = $_SESSION["uid"];
            $sid = $row["service_id"];
            $cur = mysqli_fetch_assoc(dquery("SELECT default_currency FROM \n                            tblUsers WHERE id='" . $uid . "'"));
            $serv = mysqli_fetch_assoc(dquery("SELECT subscribe_credit,subscribe_days \n                        FROM tbl_services_file where id='" . $sid . "'"));
            $table = "tbl_services_file";
            $price = subscribeCurrency($sid, $table, $cur["default_currency"]);
            $row["price"] = $price;
            $row["subscribe_start"] = date("Y-m-d", $row["subscribe_start"]);
            $row["subscribe_end"] = date("Y-m-d", $row["subscribe_end"]);
            $tempalte_ver["subscription"][$row["id"]] = $row;
        }
        $tempalte_ver["getpricelink"] = _url("widget/getSubprice");
    } else {
        if ($type == "server") {
            $pagetitle = $lng_languag["serverservice"];
            $_nav .= "<a href='" . _url("widget/settingsservices/a/action/subscription/type/server") . "' >" . $lng_languag["serverservice"] . "</a> / ";
            $pageicon = "";
            installclient($pagetitle, $pageicon, $breadcrumbnav);
            $sql = dquery("select id,service_name from tbl_services_imei \n                where active='1' and subscribe='1' and useasserver=1");
            while ($row = mysqli_fetch_assoc($sql)) {
                $serviceDetails[$row["id"]] = $row;
            }
            $tempalte_ver["servicelist"] = $serviceDetails;
            $sql = dquery("SELECT id,service_id,user_id,\n                (select service_name from \n                tbl_services_imei where id=service_id) as service\n                ,status,subscribe_start,subscribe_end \n                FROM tbl_subscribers WHERE user_id='" . $_SESSION["uid"] . "'\n                AND `type`='tbl_services_imei'\n                AND service_id in (select id from tbl_services_imei\n                    where useasserver=1)");
            while ($row = mysqli_fetch_assoc($sql)) {
                $time = time();
                $row["stat"] = $row["status"];
                if (0 < ($row["subscribe_end"] - $time) / 86400) {
                    $row["days"] = intval(($row["subscribe_end"] - $time) / 86400);
                } else {
                    $row["days"] = 0;
                }
                if ($row["status"] == "active") {
                    $row["status"] = "<span class='textgreen'>Active</span>";
                } else {
                    $row["status"] = "<span class='textred'>" . ucfirst($row["status"]) . "</span>";
                }
                $uid = $_SESSION["uid"];
                $sid = $row["service_id"];
                $cur = mysqli_fetch_assoc(dquery("SELECT default_currency FROM \n                            tblUsers WHERE id='" . $uid . "'"));
                $serv = mysqli_fetch_assoc(dquery("SELECT subscribe_credit,subscribe_days \n                        FROM tbl_services_imei where id='" . $sid . "'"));
                $table = "tbl_services_imei";
                $price = subscribeCurrency($sid, $table, $cur["default_currency"]);
                $row["price"] = $price;
                $row["subscribe_start"] = date("Y-m-d", $row["subscribe_start"]);
                $row["subscribe_end"] = date("Y-m-d", $row["subscribe_end"]);
                $tempalte_ver["subscription"][$row["id"]] = $row;
            }
            $tempalte_ver["getpricelink"] = _url("widget/getSubprice");
        } else {
            if ($type == "imei") {
                $pagetitle = $lng_languag["imeiservice"];
                $_nav .= "<a href='" . _url("widget/settingsservices/a/action/subscription/type/imei") . "' >" . $lng_languag["imeiservice"] . "</a> / ";
                $pageicon = "";
                installclient($pagetitle, $pageicon, $breadcrumbnav);
                $sql = dquery("select id,service_name from tbl_services_imei\n                where active='1' and subscribe='1' and useasserver=0");
                while ($row = mysqli_fetch_assoc($sql)) {
                    $serviceDetails[$row["id"]] = $row;
                }
                $tempalte_ver["servicelist"] = $serviceDetails;
                $sql = dquery("SELECT id,service_id,user_id,(select service_name from \n                   tbl_services_imei where id=service_id) as service,status,subscribe_start,subscribe_end \n                   FROM tbl_subscribers WHERE user_id='" . $_SESSION["uid"] . "'\n                    AND `type`='tbl_services_imei'\n                    and service_id in (select id from tbl_services_imei\n                    where useasserver=0)");
                while ($row = mysqli_fetch_assoc($sql)) {
                    $time = time();
                    $row["stat"] = $row["status"];
                    if (0 < ($row["subscribe_end"] - $time) / 86400) {
                        $row["days"] = intval(($row["subscribe_end"] - $time) / 86400);
                    } else {
                        $row["days"] = 0;
                    }
                    if ($row["status"] == "active") {
                        $row["status"] = "<span class='textgreen'>Active</span>";
                    } else {
                        $row["status"] = "<span class='textred'>" . ucfirst($row["status"]) . "</span>";
                    }
                    $uid = $_SESSION["uid"];
                    $sid = $row["service_id"];
                    $cur = mysqli_fetch_assoc(dquery("SELECT default_currency FROM \n                            tblUsers WHERE id='" . $uid . "'"));
                    $serv = mysqli_fetch_assoc(dquery("SELECT subscribe_credit,subscribe_days \n                        FROM tbl_services_imei where id='" . $sid . "'"));
                    $table = "tbl_services_imei";
                    $price = subscribeCurrency($sid, $table, $cur["default_currency"]);
                    $row["price"] = $price;
                    $row["subscribe_start"] = date("Y-m-d", $row["subscribe_start"]);
                    $row["subscribe_end"] = date("Y-m-d", $row["subscribe_end"]);
                    $tempalte_ver["subscription"][$row["id"]] = $row;
                }
                $tempalte_ver["getpricelink"] = _url("widget/getSubprice");
            }
        }
    }
}
$tempalte_ver["buynowlink"] = _url("widget/save/settings/action/subscription/type/" . $type);
$tempalte_ver["token"] = generate_token("form");
echo processSingleTemplate($templatefile);
echo " ";

?>