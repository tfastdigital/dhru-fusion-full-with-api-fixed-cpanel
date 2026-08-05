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
require "../comm.php";
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
if (!isset($_SESSION["uid"])) {
    exit;
}
$grp = preg_replace("/[^0-9\\-a-zA-Z\\/\\(\\)_ ]/i", "", $grp);
if ($_SESSION["uid"]) {
    if ($action == "imei") {
        include_once ROOTDIR . "/includes/imeiservices.fun.php";
        $pagetitle = $lng_languag["imeiservice"];
        $_nav .= "<a href='/includes/resellerservice.php?action=imei' >" . $lng_languag["imeiservice"] . "</a> / ";
        $templatefile = "client_reseller_imeiservices";
        $pageicon = "";
        installclient($pagetitle, $pageicon, $breadcrumbnav);
        $serviceDetails = getIMEIServices("", "", $_ClientsDetails["id"], true, "", "", "", "", "", "", "", "", 1000, "", "", "", true);
        $tempalte_ver["imeiservicelist"] = $serviceDetails;
        if (!$grp) {
            foreach ($serviceDetails as $k => $v) {
                $grp = $k;
            }
        }
        $tempalte_ver["grp"] = $grp;
        $gid = mysqli_fetch_assoc(dquery("select id from tbl_imei_group\r\n where group_name='" . $grp . "'"));
        $tempalte_ver["gid"] = $gid["id"];
        $serviceDetails = getIMEIServices($gid["id"], "", $_ClientsDetails["id"], true, "", "", true, "", "", "", "", "", 1000, "", "", "", true);
        $tempalte_ver["iservicelist"] = $serviceDetails;
        $tempalte_ver["action_link"] = "includes/getdata/reseller.save.php?action=imeipricing&usersId=" . $usersId;
    } else {
        if ($action == "file") {
            include_once ROOTDIR . "/includes/fileservices.fun.php";
            $pagetitle = $lng_languag["fileservice"];
            $_nav .= "<a href='/includes/resellerservice.php?action=file' >" . $lng_languag["fileservice"] . "</a> / ";
            $templatefile = "client_reseller_fileservices";
            $pageicon = "";
            installclient($pagetitle, $pageicon, $breadcrumbnav);
            $serviceDetails = getFileServices("", "", $_ClientsDetails["id"], true, "", "", "", "", "", 1000, true);
            $tempalte_ver["imeiservicelist"] = $serviceDetails;
            $tempalte_ver["action_link"] = "includes/getdata/reseller.save.php?action=filepricing&usersId=" . $usersId;
        } else {
            if ($action == "remote") {
                include_once ROOTDIR . "/includes/imeiservices.fun.php";
                $pagetitle = $lng_languag["serverservice"];
                $_nav .= "<a href='/includes/resellerservice.php?action=remote' >" . $lng_languag["remote"] . " " . $lng_languag["service"] . "</a> / ";
                $templatefile = "client_reseller_serverservices";
                $pageicon = "";
                installclient($pagetitle, $pageicon, $breadcrumbnav);
                $serviceDetails = getIMEIServices("", "", $_ClientsDetails["id"], true, "", "", "", "", "", "", "", "", 1000, "", "", "", true, "", "", "", 2);
                $tempalte_ver["serverservicelist"] = $serviceDetails;
                if (!$grp) {
                    foreach ($serviceDetails as $k => $v) {
                        $grp = $k;
                    }
                }
                $tempalte_ver["grp"] = $grp;
                $gid = mysqli_fetch_assoc(dquery("select id from tbl_imei_group\r\n                where group_name='" . $grp . "'"));
                $tempalte_ver["gid"] = $gid["id"];
                $serviceDetails = getIMEIServices($gid["id"], "", $_ClientsDetails["id"], true, "", "", true, "", "", "", "", "", 1000, "", "", "", true, "", "", "", 2);
                $tempalte_ver["sservicelist"] = $serviceDetails;
            } else {
                if ($action == "server") {
                    include_once ROOTDIR . "/includes/imeiservices.fun.php";
                    $pagetitle = $lng_languag["serverservice"];
                    $_nav .= "<a href='/includes/resellerservice.php?action=server' >" . $lng_languag["serverservice"] . "</a> / ";
                    $templatefile = "client_reseller_serverservices";
                    $pageicon = "";
                    installclient($pagetitle, $pageicon, $breadcrumbnav);
                    $serviceDetails = getIMEIServices("", "", $_ClientsDetails["id"], true, "", "", "", "", "", "", "", "", 1000, "", "", "", true, "", "", "", 1);
                    $tempalte_ver["serverservicelist"] = $serviceDetails;
                    if (!$grp) {
                        foreach ($serviceDetails as $k => $v) {
                            $grp = $k;
                        }
                    }
                    $tempalte_ver["grp"] = $grp;
                    $gid = mysqli_fetch_assoc(dquery("select id from tbl_imei_group\r\n where group_name='" . $grp . "'"));
                    $tempalte_ver["gid"] = $gid["id"];
                    $serviceDetails = getIMEIServices($gid["id"], "", $_ClientsDetails["id"], true, "", "", true, "", "", "", "", "", 1000, "", "", "", true, "", "", "", 1);
                    $tempalte_ver["sservicelist"] = $serviceDetails;
                } else {
                    if ($action == "shop") {
                        $pagetitle = $lng_languag["setting"];
                        $_nav .= "<a href='reseller.php?action=shop' >" . $lng_languag["my"] . " " . $lng_languag["product"] . "</a> / ";
                        $templatefile = "client_reseller_product";
                        $pageicon = "";
                        installclient($pagetitle, $pageicon, $breadcrumbnav);
                        if (!function_exists("getProducts")) {
                            require ROOTDIR . "/includes/products.fun.php";
                        }
                        $tempalte_ver["myproduct"] = getProducts("", "", $_ClientsDetails["id"], true, "", "", "", "", "", "", "", 1000, "", true);
                        if ($config["reseller_can_setup_store"] != 1 || $_ClientsDetails["reseller_can_setupstore"] != 1) {
                            $templatefile = "client_accessdenied";
                            $tempalte_ver["notification"]["error"] = $lng_languag["yournotallowed"];
                        }
                        if (!$grp) {
                            foreach ($tempalte_ver["myproduct"] as $k => $v) {
                                $grp = $k;
                                $grp = explode("_", $grp);
                                $grp = $grp[0];
                            }
                        } else {
                            $tempalte_ver["grps"] = $grp;
                            $grp = explode("_", $grp);
                            $grp = $grp[0];
                        }
                        $tempalte_ver["grp"] = $grp;
                        $gid = mysqli_fetch_assoc(dquery("select id from tbl_product_group \r\n        where group_name='" . $grp . "'"));
                        $tempalte_ver["gid"] = $gid["id"];
                        $serviceDetails = getProducts($gid["id"], "", $_ClientsDetails["id"], true, "", "", "", "", "", "", "", 1000, "", true);
                        $tempalte_ver["pservicelist"] = $serviceDetails;
                    } else {
                        if ($action == "imeiorder") {
                            $pagetitle = $lng_languag["setting"];
                            $_nav .= "<a href='reseller.php?action=shop' >" . $lng_languag["my"] . " " . $lng_languag["product"] . "</a> / ";
                            $templatefile = "client_reseller_imeiorder";
                            $pageicon = "";
                            installclient($pagetitle, $pageicon, $breadcrumbnav);
                            $porder = dquery("SELECT order_id,date,credit,discount,(select resellerdisc from \r\ntbl_services_imei where id=service_id) as disc\r\n,(select username from tblUsers where id=user_id) as user\r\n,(select service_name from tbl_services_imei where id=service_id) as service\r\nFROM `tbl_order_imei` where \r\nreseller_id='" . $_SESSION["uid"] . "' and (select status from tbl_invoices where id=invoiceid)='Paid'");
                            while ($row = mysqli_fetch_assoc($porder)) {
                                $row["commission"] = formatCurrency(($row["credit"] - $row["discount"]) * $row["disc"] / 100);
                                $tempalte_ver["myorders"][] = $row;
                            }
                        } else {
                            if ($action == "serverorder") {
                                $pagetitle = $lng_languag["setting"];
                                $_nav .= "<a href='reseller.php?action=shop' >" . $lng_languag["my"] . " " . $lng_languag["product"] . "</a> / ";
                                $templatefile = "client_reseller_serverorder";
                                $pageicon = "";
                                installclient($pagetitle, $pageicon, $breadcrumbnav);
                                $porder = dquery("SELECT order_id,date,credit,discount,(select resellerdisc from \r\ntbl_server_log where id=service_id) as disc\r\n,(select username from tblUsers where id=user_id) as user\r\n,(select service_name from tbl_server_log where id=service_id) as service\r\nFROM `tbl_order_server` where \r\nreseller_id='" . $_SESSION["uid"] . "' and (select status from tbl_invoices where id=invoiceid)='Paid'");
                                while ($row = mysqli_fetch_assoc($porder)) {
                                    $row["commission"] = formatCurrency(($row["credit"] - $row["discount"]) * $row["disc"] / 100);
                                    $tempalte_ver["myorders"][] = $row;
                                }
                            } else {
                                if ($action == "shoporder") {
                                    $pagetitle = $lng_languag["setting"];
                                    $_nav .= "<a href='reseller.php?action=shop' >" . $lng_languag["my"] . " " . $lng_languag["product"] . "</a> / ";
                                    $templatefile = "client_reseller_shoporder";
                                    $pageicon = "";
                                    installclient($pagetitle, $pageicon, $breadcrumbnav);
                                    $query = "SELECT order_id,date,credit,discount,(select resellerdisc from \r\ntbl_products where id=service_id) as disc\r\n,(select username from tblUsers where id=user_id) as user\r\n,(select service_name from tbl_products where id=service_id) as service\r\nFROM `tbl_order_product` where \r\nreseller_id='" . $_SESSION["uid"] . "' and (select status from tbl_invoices where id=invoiceid)='Paid'\r\n  LIMIT " . $next . "," . $pagelimit;
                                    $porder = dquery($query);
                                    generatePaginate($query);
                                    while ($row = mysqli_fetch_assoc($porder)) {
                                        $row["commission"] = formatCurrency(($row["credit"] - $row["discount"]) * $row["disc"] / 100);
                                        $tempalte_ver["myorders"][] = $row;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    $tempalte_ver["token"] = generate_token("form");
    echo processSingleTemplate($templatefile);
} else {
    echo "<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>";
}

?>