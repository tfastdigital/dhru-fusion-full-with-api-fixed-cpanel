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
require_once "./comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
$currentpage = "pendingorderimei";
$_nav = "<a href=\"" . _url("main") . "\">" . $lng_languag["dashboard"] . "</a> / ";
$action = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $action);
$status = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $status);
$usersId = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $usersId);
$serverservice = 0;
if ($action == "remote") {
    $action = "imei";
    $serverservice = 2;
}
if ($action == "newserver") {
    $action = "imei";
    $serverservice = 1;
}
if (!$action) {
    $action = "imei";
}
if (!$parentid) {
    $parentid = 1012;
}
if ($status != "pending" && $status != "available" && $status != "rejected" && $status != "all") {
    $status = "all";
}
$tempalte_ver["sts"] = $status;
if ($usersId && $withtab) {
    $uis = dquery("select id from tblUsers \n    where md5(id)='" . $usersId . "' and reseller_id='" . $_SESSION["uid"] . "'");
}
if ($_SESSION["uid"]) {
    if ($action == "file") {
        if (!function_exists("getFileServices")) {
            require_once ROOTDIR . "/includes/fileservices.fun.php";
        }
        $pagetitle = $lng_languag["pendingorder"];
        $templatefile = "client_ordersdtl_file";
        $pageicon = "";
        installclient($pagetitle, $pageicon, $breadcrumbnav);
        if ($cancelorderid) {
            if (cancelOrderFile($cancelorderid)) {
                $tempalte_ver["notification"]["success"] = $lng_languag["ordercancel"];
            } else {
                $tempalte_ver["notification"]["error"] = $lng_languag["alreadycanceled"];
            }
        }
        if ($status == "pending") {
            $pagetitle = $lng_languag["file"] . " " . $lng_languag["orders"];
            $_nav .= "<a href='" . _url("orders/action/file/status/" . $status) . "' >" . $lng_languag["file"] . " " . $lng_languag["orders"] . "</a> / ";
            $templatefile = "client_ordersdtl_file";
            $pageicon = "";
            installclient($pagetitle, $pageicon, $breadcrumbnav);
            $tempalte_ver["fileservicelist"] = getFileServices("", "", "", false, false);
            if ($uis) {
                $tempalte_ver["fileservicelist"] = getFileSearchService($uis["id"], "pending");
            } else {
                $tempalte_ver["fileservicelist"] = getFileSearchService($_SESSION["uid"], "pending");
            }
            $status = "pending";
            $tempalte_ver["status"] = $status;
            if ($uis) {
                $tempalte_ver["fileorderslist"] = getOrdersFile($status, $serviceid, $uis["id"]);
            } else {
                $tempalte_ver["fileorderslist"] = getOrdersFile($status, $serviceid, $_ClientsDetails["id"]);
            }
        } else {
            if ($status == "available") {
                $currentpage = "availableorderfile";
                $pagetitle = $lng_languag["file"] . " " . $lng_languag["orders"];
                $_nav .= "<a href='" . _url("orders/action/file/status/" . $status) . "' >" . $lng_languag["file"] . " " . $lng_languag["orders"] . "</a> / ";
                $templatefile = "client_ordersdtl_file";
                $pageicon = "";
                installclient($pagetitle, $pageicon, $breadcrumbnav);
                if (!function_exists("getFileServices")) {
                    require_once ROOTDIR . "/includes/fileservices.fun.php";
                }
                if ($verification && verifyOrderFile($verification)) {
                    $tempalte_ver["notification"]["success"] = $lng_languag["sentvarification"];
                }
                $tempalte_ver["fileservicelist"] = getFileServices("", "", "", false, false);
                if ($uis) {
                    $tempalte_ver["fileservicelist"] = getFileSearchService($uis["id"], "available");
                } else {
                    $tempalte_ver["fileservicelist"] = getFileSearchService($_SESSION["uid"], "available");
                }
                $status = "available";
                $tempalte_ver["status"] = $status;
                if ($uis) {
                    $tempalte_ver["fileorderslist"] = getOrdersFile($status, $serviceid, $uis["id"]);
                } else {
                    $tempalte_ver["fileorderslist"] = getOrdersFile($status, $serviceid, $_ClientsDetails["id"]);
                }
            } else {
                if ($status == "rejected") {
                    $currentpage = "rejectedorderfile";
                    $pagetitle = $lng_languag["file"] . " " . $lng_languag["orders"];
                    $_nav .= "<a href='" . _url("orders/action/file/status/" . $status) . "' >" . $lng_languag["file"] . " " . $lng_languag["orders"] . "</a> / ";
                    $templatefile = "client_ordersdtl_file";
                    $pageicon = "";
                    installclient($pagetitle, $pageicon, $breadcrumbnav);
                    if (!function_exists("getFileServices")) {
                        require_once ROOTDIR . "/includes/fileservices.fun.php";
                    }
                    $tempalte_ver["fileservicelist"] = getFileServices("", "", "", false, false);
                    if ($uis) {
                        $tempalte_ver["fileservicelist"] = getFileSearchService($uis["id"], "rejected");
                    } else {
                        $tempalte_ver["fileservicelist"] = getFileSearchService($_SESSION["uid"], "rejected");
                    }
                    $status = "rejected";
                    $tempalte_ver["status"] = $status;
                    if ($uis) {
                        $tempalte_ver["fileorderslist"] = getOrdersFile($status, $serviceid, $uis["id"]);
                    } else {
                        $tempalte_ver["fileorderslist"] = getOrdersFile($status, $serviceid, $_ClientsDetails["id"]);
                    }
                } else {
                    if ($status == "all") {
                        $currentpage = "allorderfile";
                        $pagetitle = $lng_languag["file"] . " " . $lng_languag["orders"];
                        $_nav .= "<a href='" . _url("orders/action/file/status/" . $status) . "' >" . $lng_languag["file"] . " " . $lng_languag["order"] . "</a> / ";
                        $templatefile = "client_ordersdtl_file";
                        $pageicon = "";
                        installclient($pagetitle, $pageicon, $breadcrumbnav);
                        if (!function_exists("getFileServices")) {
                            require_once ROOTDIR . "/includes/fileservices.fun.php";
                        }
                        if ($verification && verifyOrderFile($verification)) {
                            $tempalte_ver["notification"]["success"] = $lng_languag["sentvarification"];
                        }
                        $tempalte_ver["fileservicelist"] = getFileServices("", "", "", false, false);
                        if ($uis) {
                            $tempalte_ver["fileservicelist"] = getFileSearchService($uis["id"], $status);
                        } else {
                            $tempalte_ver["fileservicelist"] = getFileSearchService($_SESSION["uid"], $status);
                        }
                        $status = "all";
                        $tempalte_ver["status"] = $status;
                        if ($uis) {
                            $tempalte_ver["fileorderslist"] = getOrdersFile($status, $serviceid, $uis["id"]);
                        } else {
                            $tempalte_ver["fileorderslist"] = getOrdersFile($status, $serviceid, $_ClientsDetails["id"]);
                        }
                    }
                }
            }
        }
        if ($_ClientsDetails["access"]["fileservice"] != 1) {
            $templatefile = "client_accessdenied";
            $tempalte_ver["notification"]["error"] = $lng_languag["yournotallowed"];
        }
        $tmp = "";
        foreach ($tempalte_ver["fileorderslist"] as $k => $v) {
            $tmp .= "[" . strip_tags($v[order_id]) . ",'" . $v["service"] . "','" . strip_tags($v[status]) . "','" . addslashes($v[action]) . "'," . ($v["credit"] - $v["discount"]) . ",'" . $v["date"] . "','" . addslashes($v[reply]) . "'],";
        }
        $tempalte_ver["autorefreshlink"] = _url("orders/action/file/status/" . $status);
        $tempalte_ver["exportlink"] = _url("export/service/1");
        $tempalte_ver["newfileorderslist"] = "[" . trim($tmp, ",") . "]";
    } else {
        if ($action == "server") {
            if (!function_exists("getServerServices")) {
                require_once ROOTDIR . "/includes/serverservices.fun.php";
            }
            $pagetitle = $lng_languag["pendingorder"];
            $templatefile = "client_ordersdtl_server";
            $pageicon = "";
            installclient($pagetitle, $pageicon, $breadcrumbnav);
            if ($cancelorderid) {
                if (cancelOrderServer($cancelorderid)) {
                    $tempalte_ver["notification"]["success"] = $lng_languag["ordercancel"];
                } else {
                    $tempalte_ver["notification"]["error"] = $lng_languag["alreadycanceled"];
                }
            }
            if ($status == "pending") {
                $pagetitle = " Server " . $lng_languag["orders"];
                $_nav .= "<a href='" . _url("orders/action/newserver/status/" . $status) . "' >" . $pagetitle . "</a> / ";
                $templatefile = "client_ordersdtl_server";
                $pageicon = "";
                installclient($pagetitle, $pageicon, $breadcrumbnav);
                $tempalte_ver["serverservicelist"] = getServerServices("", "", "", false, false);
                if ($uis) {
                    $tempalte_ver["serverservicelist"] = getServerSearchService($uis["id"], "pending");
                } else {
                    $tempalte_ver["serverservicelist"] = getServerSearchService($_SESSION["uid"], "pending");
                }
                $status = "pending";
                $tempalte_ver["status"] = $status;
                if ($uis) {
                    $tempalte_ver["serverorderslist"] = getOrdersServer($status, $serviceid, $uis["id"]);
                } else {
                    $tempalte_ver["serverorderslist"] = getOrdersServer($status, $serviceid, $_ClientsDetails["id"]);
                }
            } else {
                if ($status == "available") {
                    $currentpage = "availableorderserver";
                    $pagetitle = " Server " . $lng_languag["orders"];
                    $_nav .= "<a href='" . _url("orders/action/newserver/status/" . $status) . "' >" . $pagetitle . "</a> / ";
                    $templatefile = "client_ordersdtl_server";
                    $pageicon = "";
                    installclient($pagetitle, $pageicon, $breadcrumbnav);
                    if (!function_exists("getServerServices")) {
                        require_once ROOTDIR . "/includes/serverservices.fun.php";
                    }
                    if ($verification && verifyOrderServer($verification)) {
                        $tempalte_ver["notification"]["success"] = $lng_languag["sentvarification"];
                    }
                    $tempalte_ver["serverservicelist"] = getServerServices("", "", "", false, false);
                    if ($uis) {
                        $tempalte_ver["serverservicelist"] = getServerSearchService($uis["id"], "available");
                    } else {
                        $tempalte_ver["serverservicelist"] = getServerSearchService($_SESSION["uid"], "available");
                    }
                    $status = "available";
                    $tempalte_ver["status"] = $status;
                    if ($uis) {
                        $tempalte_ver["serverorderslist"] = getOrdersServer($status, $serviceid, $uis["id"]);
                    } else {
                        $tempalte_ver["serverorderslist"] = getOrdersServer($status, $serviceid, $_ClientsDetails["id"]);
                    }
                } else {
                    if ($status == "rejected") {
                        $currentpage = "rejectedorderserver";
                        $pagetitle = "Server" . $lng_languag["orders"];
                        $_nav .= "<a href='" . _url("orders/action/newserver/status/" . $status) . "' >" . $pagetitle . "</a> / ";
                        $templatefile = "client_ordersdtl_server";
                        $pageicon = "";
                        installclient($pagetitle, $pageicon, $breadcrumbnav);
                        if (!function_exists("getServerServices")) {
                            require_once ROOTDIR . "/includes/serverservices.fun.php";
                        }
                        $tempalte_ver["serverservicelist"] = getServerServices("", "", "", false, false);
                        if ($uis) {
                            $tempalte_ver["serverservicelist"] = getServerSearchService($uis["id"], "rejected");
                        } else {
                            $tempalte_ver["serverservicelist"] = getServerSearchService($_SESSION["uid"], "rejected");
                        }
                        $status = "rejected";
                        $tempalte_ver["status"] = $status;
                        if ($uis) {
                            $tempalte_ver["serverorderslist"] = getOrdersServer($status, $serviceid, $uis["id"]);
                        } else {
                            $tempalte_ver["serverorderslist"] = getOrdersServer($status, $serviceid, $_ClientsDetails["id"]);
                        }
                    } else {
                        if ($status == "all") {
                            $currentpage = "allorderserver";
                            $pagetitle = $lng_languag["server"] . " " . $lng_languag["orders"];
                            $_nav .= "<a href='" . _url("orders/action/newserver/status/" . $status) . "' >" . $lng_languag["server"] . " " . $lng_languag["orders"] . "</a> / ";
                            $templatefile = "client_ordersdtl_server";
                            $pageicon = "";
                            installclient($pagetitle, $pageicon, $breadcrumbnav);
                            if (!function_exists("getServerServices")) {
                                require_once ROOTDIR . "/includes/serverservices.fun.php";
                            }
                            if ($verification && verifyOrderServer($verification)) {
                                $tempalte_ver["notification"]["success"] = $lng_languag["sentvarification"];
                            }
                            $tempalte_ver["serverservicelist"] = getServerServices("", "", "", false, false);
                            if ($uis) {
                                $tempalte_ver["serverservicelist"] = getServerSearchService($uis["id"], $status);
                            } else {
                                $tempalte_ver["serverservicelist"] = getServerSearchService($_SESSION["uid"], $status);
                            }
                            $status = "all";
                            $tempalte_ver["status"] = $status;
                            if ($uis) {
                                $tempalte_ver["serverorderslist"] = getOrdersServer($status, $serviceid, $uis["id"]);
                            } else {
                                $tempalte_ver["serverorderslist"] = getOrdersServer($status, $serviceid, $_ClientsDetails["id"]);
                            }
                        }
                    }
                }
            }
            if ($_ClientsDetails["access"]["serverlogservice"] != 1) {
                $templatefile = "client_accessdenied";
                $tempalte_ver["notification"]["error"] = $lng_languag["yournotallowed"];
            }
            $tempalte_ver["autorefreshlink"] = _url("orders/action/newserver/status/" . $status);
            $tempalte_ver["exportlink"] = _url("export/service/1/serverservice/2");
        } else {
            if ($action == "advance") {
                $pagetitle = $lng_languag["advance"] . " " . $lng_languag["order"] . " " . $lng_languag["history"];
                $_nav .= "<a href='" . _url("orders/action/product/status/" . $status) . "' >" . $lng_languag["advance"] . " " . $lng_languag["order"] . " " . $lng_languag["history"] . "</a>";
                $templatefile = "client_order_advance";
                $pageicon = "";
                installclient($pagetitle, $pageicon, $breadcrumbnav);
                $tempalte_ver["advanceorderlink"] = _url("widget/getadvanceorder/1/");
            } else {
                if ($action == "product") {
                    if (!function_exists("getProducts")) {
                        require_once ROOTDIR . "/includes/products.fun.php";
                    }
                    if ($status == "pending") {
                        $pagetitle = $lng_languag["pendingorder"];
                        $_nav .= "<a href='" . _url("orders/action/product/status/" . $status) . "' >" . $lng_languag["pendingorder"] . "</a> / ";
                        $templatefile = "client_ordersdtl_product";
                        $pageicon = "";
                        installclient($pagetitle, $pageicon, $breadcrumbnav);
                        if ($cancelorderid) {
                            if (cancelOrderProduct($cancelorderid)) {
                                $tempalte_ver["notification"]["success"] = $lng_languag["ordercancel"];
                            } else {
                                $tempalte_ver["notification"]["error"] = $lng_languag["alreadycanceled"];
                            }
                        }
                        $tempalte_ver["productservicelist"] = getProducts("", "", "", false, false);
                        $tempalte_ver["productservicelist"] = getProductSearchService($_SESSION["uid"], "pending");
                        $status = "pending";
                        $tempalte_ver["status"] = $status;
                        $tempalte_ver["productorderslist"] = getOrdersProduct($status, $serviceid, $_ClientsDetails["id"]);
                    } else {
                        if ($status == "available") {
                            $currentpage = "availableorderproduct";
                            $pagetitle = $lng_languag["availableorder"];
                            $_nav .= "<a href='" . _url("orders/action/product/status/" . $status) . "' >" . $lng_languag["availableorder"] . "</a> / ";
                            $templatefile = "client_ordersdtl_product";
                            $pageicon = "";
                            installclient($pagetitle, $pageicon, $breadcrumbnav);
                            if (!function_exists("getProducts")) {
                                require_once ROOTDIR . "/includes/products.fun.php";
                            }
                            $tempalte_ver["productservicelist"] = getProducts("", "", "", false, false);
                            $tempalte_ver["productservicelist"] = getProductSearchService($_SESSION["uid"], "available");
                            $status = "available";
                            $tempalte_ver["status"] = $status;
                            $tempalte_ver["productorderslist"] = getOrdersProduct($status, $serviceid, $_ClientsDetails["id"]);
                        } else {
                            if ($status == "rejected") {
                                $currentpage = "rejectedorderproduct";
                                $pagetitle = $lng_languag["rejectedorder"];
                                $_nav .= "<a href='" . _url("orders/action/product/status/" . $status) . "' >" . $lng_languag["rejectedorder"] . "</a> / ";
                                $templatefile = "client_ordersdtl_product";
                                $pageicon = "";
                                installclient($pagetitle, $pageicon, $breadcrumbnav);
                                if (!function_exists("getProducts")) {
                                    require_once ROOTDIR . "/includes/products.fun.php";
                                }
                                $tempalte_ver["productservicelist"] = getProducts("", "", "", false, false);
                                $tempalte_ver["productservicelist"] = getProductSearchService($_SESSION["uid"], "rejected");
                                $status = "rejected";
                                $tempalte_ver["status"] = $status;
                                $tempalte_ver["productorderslist"] = getOrdersProduct($status, $serviceid, $_ClientsDetails["id"]);
                            }
                        }
                    }
                } else {
                    if (!function_exists("getIMEIServices")) {
                        require_once ROOTDIR . "/includes/imeiservices.fun.php";
                    }
                    if ($bulkids && $verifyreason) {
                        $verifyids = explode(",", trim($bulkids, ","));
                        foreach ($verifyids as $veriyid => $verifydata) {
                            if (verifyOrderIMEI(md5($verifydata), "", $verifyreason, $attachment)) {
                                $tempalte_ver["notification"]["success"] = $lng_languag["sentvarification"];
                            }
                        }
                    }
                    $pagetitle = $lng_languag["imei"] . " " . $lng_languag["orders"];
                    if ($cancelorderid) {
                        $_nav .= "<a href='" . _url("orders/action/imei/status/" . $status) . "' >" . $pagetitle . "</a> / ";
                        $templatefile = "client_ordersdtl_imei";
                        $pageicon = "";
                        installclient($pagetitle, $pageicon, $breadcrumbnav);
                        if (cancelOrderIMEI($cancelorderid)) {
                            $tempalte_ver["notification"]["success"] = $lng_languag["ordercancel"];
                        } else {
                            $tempalte_ver["notification"]["error"] = $lng_languag["alreadycanceled"];
                        }
                    }
                    if ($status == "pending") {
                        $_nav .= "<a href='" . _url("orders/action/imei/status/" . $status) . "' >" . $pagetitle . "</a> / ";
                        $templatefile = "client_ordersdtl_imei";
                        $pageicon = "";
                        installclient($pagetitle, $pageicon, $breadcrumbnav);
                        $tempalte_ver["imeiservicelist"] = getIMEIServices("", "", "", false, false, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", $serverservice);
                        if ($serverservice) {
                            $tempalte_ver["imeiservicelist"] = getIMEISearchService($_SESSION["uid"], "pending", $serverservice);
                        } else {
                            $tempalte_ver["imeiservicelist"] = getIMEISearchService($_SESSION["uid"], "pending");
                        }
                        $status = "pending";
                        $tempalte_ver["status"] = $status;
                        $tempalte_ver["imeiorderslist"] = getOrdersIMEI($status, $serviceid, $_ClientsDetails["id"], "", "", "", $serverservice, "", $searchvalue, 0);
                    } else {
                        if ($status == "available") {
                            $currentpage = "availableorderimei";
                            if ($serverservice == 2) {
                                $pagetitle = $lng_languag["remote"] . " " . $lng_languag["orders"];
                                $_nav .= "<a href='" . _url("orders/action/imei") . "' >" . $lng_languag["remote"] . " " . $lng_languag["orders"] . "</a> / ";
                            } else {
                                if ($serverservice == 1) {
                                    $pagetitle = $lng_languag["server"] . " " . $lng_languag["orders"];
                                    $_nav .= "<a href='" . _url("orders/action/imei/status/" . $status) . "' >" . $pagetitle . "</a> / ";
                                } else {
                                    $pagetitle = " IMEI " . $lng_languag["orders"];
                                    $_nav .= "<a href='" . _url("orders/action/imei/status/" . $status) . "' >" . $pagetitle . "</a> / ";
                                }
                            }
                            $templatefile = "client_ordersdtl_imei";
                            $pageicon = "";
                            installclient($pagetitle, $pageicon, $breadcrumbnav);
                            if (!function_exists("getIMEIServices")) {
                                require_once ROOTDIR . "/includes/imeiservices.fun.php";
                            }
                            if ($verification) {
                                if ($_FILES["attachment"]["error"] <= 0) {
                                    $SIZE = filesize($_FILES["attachment"]["tmp_name"]);
                                    list($width, $height, $type, $attr) = getimagesize($_FILES["attachment"]["tmp_name"]);
                                    if ($type < 4 && 0 < $type && $SIZE <= 512000) {
                                        $attachment = $_FILES["attachment"];
                                    }
                                }
                                $details = nl2br(strip_tags($details));
                                if (verifyOrderIMEI($verification, "", $details, $attachment)) {
                                    $tempalte_ver["notification"]["success"] = $lng_languag["sentvarification"];
                                }
                            }
                            $tempalte_ver["imeiservicelist"] = getIMEIServices("", "", "", false, false, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", $serverservice);
                            if (0 < $serverservice) {
                                $tempalte_ver["imeiservicelist"] = getIMEISearchService($_SESSION["uid"], "available", $serverservice);
                            } else {
                                $tempalte_ver["imeiservicelist"] = getIMEISearchService($_SESSION["uid"], "available");
                            }
                            $status = "available";
                            $tempalte_ver["status"] = $status;
                            $tempalte_ver["imeiorderslist"] = getOrdersIMEI($status, $serviceid, $_ClientsDetails["id"], "", "", "", $serverservice, "", $searchvalue, 0);
                        } else {
                            if ($status == "rejected") {
                                $currentpage = "rejectedorderimei";
                                if (0 < $serverservice) {
                                    $pagetitle = $lng_languag["rejected"] . " " . $lng_languag["server"] . " " . $lng_languag["orders"];
                                    $_nav .= "<a href='" . _url("orders/action/imei/status/" . $status) . "' >" . $lng_languag["server"] . " " . $lng_languag["orders"] . "</a> / ";
                                } else {
                                    $pagetitle = $lng_languag["rejected"] . " IMEI " . $lng_languag["orders"];
                                    $_nav .= "<a href='" . _url("orders/action/imei/status/" . $status) . "' >" . $lng_languag["imei"] . " " . $lng_languag["orders"] . "</a> / ";
                                }
                                $templatefile = "client_ordersdtl_imei";
                                $pageicon = "";
                                installclient($pagetitle, $pageicon, $breadcrumbnav);
                                if (!function_exists("getIMEIServices")) {
                                    require_once ROOTDIR . "/includes/imeiservices.fun.php";
                                }
                                $tempalte_ver["imeiservicelist"] = getIMEIServices("", "", "", false, false, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", $serverservice);
                                if (0 < $serverservice) {
                                    $tempalte_ver["imeiservicelist"] = getIMEISearchService($_SESSION["uid"], "rejected", $serverservice);
                                } else {
                                    $tempalte_ver["imeiservicelist"] = getIMEISearchService($_SESSION["uid"], "rejected");
                                }
                                $status = "rejected";
                                $tempalte_ver["status"] = $status;
                                $tempalte_ver["imeiorderslist"] = getOrdersIMEI($status, $serviceid, $_ClientsDetails["id"], "", "", "", $serverservice, "", $searchvalue, 0);
                            } else {
                                if ($status == "all") {
                                    $currentpage = "allimeiorder";
                                    if ($serverservice == 2) {
                                        $pagetitle = $lng_languag["remote"] . " " . $lng_languag["orders"];
                                        $_nav .= "<a href='" . _url("orders/action/remote/status/" . $status) . "' >" . $pagetitle . "</a> / ";
                                    } else {
                                        if ($serverservice == 1) {
                                            $pagetitle = $lng_languag["server"] . " " . $lng_languag["orders"];
                                            $_nav .= "<a href='" . _url("orders/action/newserver/status/" . $status) . "' >" . $pagetitle . "</a> / ";
                                        } else {
                                            $pagetitle = " IMEI " . $lng_languag["orders"];
                                            $_nav .= "<a href='" . _url("orders/action/imei/status/" . $status) . "' >" . $pagetitle . "</a> / ";
                                        }
                                    }
                                    $templatefile = "client_ordersdtl_imei";
                                    $pageicon = "";
                                    installclient($pagetitle, $pageicon, $breadcrumbnav);
                                    if (!function_exists("getIMEIServices")) {
                                        require_once ROOTDIR . "/includes/imeiservices.fun.php";
                                    }
                                    if ($verification && verifyOrderIMEI($verification)) {
                                        $tempalte_ver["notification"]["success"] = $lng_languag["sentvarification"];
                                    }
                                    $tempalte_ver["imeiservicelist"] = getIMEIServices("", "", "", false, false, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", $serverservice);
                                    if (0 < $serverservice) {
                                        $tempalte_ver["imeiservicelist"] = getIMEISearchService($_SESSION["uid"], $status, $serverservice);
                                    } else {
                                        $tempalte_ver["imeiservicelist"] = getIMEISearchService($_SESSION["uid"], $status);
                                    }
                                    $status = "all";
                                    $tempalte_ver["status"] = $status;
                                    $tempalte_ver["imeiorderslist"] = getOrdersIMEI($status, $serviceid, $_ClientsDetails["id"], "", "", "", $serverservice, "", $searchvalue, 0);
                                    if ($searchvalue) {
                                        $ib = explode("\n", $searchvalue);
                                        foreach ($ib as $is) {
                                            $tmsp = explode(",", $is);
                                            foreach ($tmsp as $bcs) {
                                                if (trim($bcs)) {
                                                    $imeis[] = trim($bcs);
                                                }
                                            }
                                        }
                                    }
                                    $NewArr = [];
                                    foreach ($tempalte_ver["imeiorderslist"] as $kc => $ordr) {
                                        foreach ($imeis as $i => $s) {
                                            if ($s == $ordr["imei"]) {
                                                $NewArr[$kc] = $ordr;
                                            }
                                        }
                                    }
                                    if (count($imeis)) {
                                        $tempalte_ver["imeiorderslist"] = $NewArr;
                                    }
                                }
                            }
                        }
                    }
                    if ($serverservice == 2) {
                        if ($_ClientsDetails["access"]["remoteservice"] != 1) {
                            $templatefile = "client_accessdenied";
                            $tempalte_ver["notification"]["error"] = $lng_languag["yournotallowed"];
                        }
                    } else {
                        if ($serverservice == 1) {
                            if ($_ClientsDetails["access"]["serverlogservice"] != 1) {
                                $templatefile = "client_accessdenied";
                                $tempalte_ver["notification"]["error"] = $lng_languag["yournotallowed"];
                            }
                        } else {
                            if ($_ClientsDetails["access"]["imeiservice"] != 1) {
                                $templatefile = "client_accessdenied";
                                $tempalte_ver["notification"]["error"] = $lng_languag["yournotallowed"];
                            }
                        }
                    }
                }
            }
        }
    }
    if ($serverservice == 2) {
        $type = 4;
    } else {
        if ($serverservice == 1) {
            $type = 3;
        } else {
            if ($action == "imei") {
                $type = 1;
            } else {
                if ($action == "file") {
                    $type = 2;
                }
            }
        }
    }
    $tempalte_ver["exportlink"] = _url("export/service/1/type/" . $type . "/serverservice/" . $serverservice);
    $tempalte_ver["autorefreshlink"] = _url("orders/action/imei/status/" . $status);
    $tempalte_ver["serverservice"] = $serverservice;
    if ($serverservice == 2) {
        $tempalte_ver["searchaction"] = _url("orders/action/remote/status/" . $status) . (0 < $serverservice ? "/serverservice/" . $serverservice : "");
    } else {
        if ($serverservice == 1) {
            $tempalte_ver["searchaction"] = _url("orders/action/newserver/status/" . $status) . (0 < $serverservice ? "/serverservice/" . $serverservice : "");
        } else {
            $tempalte_ver["searchaction"] = _url("orders/action/imei/status/" . $status) . (0 < $serverservice ? "/serverservice/" . $serverservice : "");
        }
    }
    if ($standalone) {
        $tempalte_ver["token"] = generate_token("form");
        $tempalte_ver["standalone"] = true;
        echo processSingleTemplate($templatefile);
        exit;
    }
    if ($withtab && $usersId) {
        $tempalte_ver["token"] = generate_token("form");
        $tempalte_ver["withtab"] = true;
        $q = dquery("select imei_service_access,file_service_access,server_log_access \n        from tblUsers where md5(id)='" . $usersId . "' and reseller_id='" . $_SESSION["uid"] . "'");
        if (mysqli_num_rows($q)) {
            $dr = mysqli_fetch_assoc($q);
            $tempalte_ver["myuser"]["imeiservice"] = $dr["imei_service_access"];
            $tempalte_ver["myuser"]["fileservice"] = $dr["file_service_access"];
            $tempalte_ver["myuser"]["serverservice"] = $dr["server_log_access"];
            $templatefile = "client_reseller_usersorder";
            echo processSingleTemplate($templatefile);
            exit;
        }
        $templatefile = "client_accessdenied";
        echo processSingleTemplate($templatefile);
        exit;
    }
} else {
    $_SESSION["afterloginredirect"] = $_SERVER["REQUEST_URI"];
    include_once "includes/login.inc.php";
    installclient($pagetitle, $pageicon, $breadcrumbnav);
}
$tempalte_ver["advanceexportlink"] = _url("downloadfiles/action/exports");
if ($serverservice == 2) {
    $type = 4;
} else {
    if ($serverservice == 1) {
        $type = 3;
    } else {
        if ($action == "imei") {
            $type = 1;
        } else {
            if ($action == "file") {
                $type = 2;
            }
        }
    }
}
$tempalte_ver["viewexportlink"] = _url("downloadfiles/action/exports/type/" . $type . "/id/1/status/" . $status);
if ($serverservice == 1) {
    $action = "newserver";
} else {
    if ($serverservice == 2) {
        $action = "remote";
    }
}
$tempalte_ver["statuslink"] = _url("orders/action/" . $action);
$tempalte_ver["themelink"] = _url("widget/save/settings/action/themesettings");
$tempalte_ver["token"] = generate_token("form");
$fileverioncheck = "6.1.0";
DisplayOutput($templatefile);
chkMd5sumsubpage();

?>