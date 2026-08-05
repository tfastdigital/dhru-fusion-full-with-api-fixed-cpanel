<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace ns;

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "./comm.php";
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
$id = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $id);
$disply = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $disply);
$tempalte_ver["disply"] = $disply;
if ($resells) {
    $tempalte_ver["resells"] = $resells;
}
if ($vieworder) {
    $action = $vieworder;
}
if ($actions) {
    $action = $actions;
}
if ($fromsucce) {
    $tempalte_ver["fromcallback"] = 1;
}
if ($_SESSION["uid"]) {
    global $_ClientsDetails;
    if ($action == "imei") {
        $currentpage = "vieworder";
        $_nav = "<a href=\"" . _url("main") . "\">" . $lng_languag["vieworder"] . "</a> / ";
        $pagetitle = $lng_languag["vieworder"];
        $_nav .= "<a href='" . _url("vieworder") . "' >" . $lng_languag["vieworder"] . "</a> / ";
        $templatefile = "client_vieworder";
        $pageicon = "";
        installclient($pagetitle, $pageicon, $breadcrumbnav);
        $id = descape($id);
        $sql = mysqli_fetch_assoc(dquery("SELECT order_id,(select service_name from tbl_services_imei\nwhere id=service_id) as service,time,qnt,`server`,user_can_c,service_id,user_id,retail_shop,imei,\n        credit,discount,time,model_id,provider_id,note,network_id,mep,PIN,KBH,PRD,Type,Reference,Locks,reply_time,sn,secro,reply,encnum,note,comments FROM \n        `tbl_order_imei` WHERE `order_id`='" . $id . "'"));
        if (!$sql["order_id"]) {
            $sql = mysqli_fetch_assoc(dquery("SELECT order_id,(select service_name from tbl_services_imei\nwhere id=service_id) as service,qnt,`server`,user_can_c,service_id,user_id,retail_shop,imei,\n            credit,discount,time,model_id,provider_id,note,network_id,mep,PIN,KBH,PRD,Type,Reference,Locks,reply_time,sn,secro,reply,encnum,note,comments FROM \n            `tbl_order_imei` WHERE encnum='" . $id . "'"));
        }
        $user = mysqli_fetch_assoc(dquery("SELECT `reseller_id`,`storeownerid` FROM \n        `tblUsers` WHERE `id`='" . $sql["user_id"] . "' "));
        if ($sql["user_id"] != $_SESSION["uid"]) {
            $tempalte_ver["errormsg"] = $lng_languag["logindiff"];
        }
        if ($_SESSION["uid"] == $sql["user_id"] || $user["reseller_id"] == $_ClientsDetails["id"] || $user["storeownerid"] == $_ClientsDetails["id"]) {
            include_once ROOTDIR . "/includes/imeiservices.fun.php";
            $tempalte_ver["datas"] = getOrdersIMEI("", "", "", "", "", "", "", "", "", "", $sql["order_id"]);
            $tempalte_ver["orderid"] = $sql["order_id"];
            $tempalte_ver["userid"] = $sql["user_id"];
            $tempalte_ver["service"] = $sql["service"];
            $tempalte_ver["imei"] = $sql["imei"];
            $tempalte_ver["qnt"] = $sql["qnt"];
            if ($config["encryptedorderid"]) {
                $tempalte_ver["encnum"] = $sql["encnum"] ? $sql["encnum"] : $sql["order_id"];
            } else {
                $tempalte_ver["encnum"] = $sql["order_id"];
            }
            if ($sql["server"]) {
                $tempalte_ver["server"] = 1;
            }
            $tempalte_ver["credit"] = $sql["credit"] - $sql["discount"];
            $tempalte_ver["date"] = $sql["time"];
            $tempalte_ver["reply_time"] = $sql["reply_time"];
            $tempalte_ver["reply"] = $sql["reply"];
            $tempalte_ver["note"] = $sql["note"];
            $tempalte_ver["comments"] = $sql["comments"];
            $serv = mysqli_fetch_assoc(dquery("SELECT `service_name`,retail_name,usercan_cancel,verifiable\n             FROM `tbl_services_imei` WHERE `id`='" . $sql["service_id"] . "' "));
            $tempalte_ver["service"] = $serv["service_name"];
            if (CLIENT && $serv["retail_name"] && $sql["retail_shop"]) {
                $tempalte_ver["service"] = $serv["retail_name"];
            }
            if ($sql["user_can_c"] == 0) {
                $tempalte_ver["status"] = $lng_languag["waitingaction"];
                $tempalte_ver["statusclass"] = "statusP";
            } else {
                if ($sql["user_can_c"] == 1) {
                    $tempalte_ver["status"] = $lng_languag["inprocess"];
                    $tempalte_ver["statusclass"] = "statusY";
                } else {
                    if ($sql["user_can_c"] == 3) {
                        $tempalte_ver["status"] = $lng_languag["rejected"];
                        $tempalte_ver["apirefid"] = $sql["apilogreferenceid"];
                        $tempalte_ver["statusclass"] = "statusR";
                    } else {
                        if ($sql["user_can_c"] == 4) {
                            $tempalte_ver["status"] = $lng_languag["success"];
                            $tempalte_ver["statusclass"] = "statusA";
                        }
                    }
                }
            }
            $tempalte_ver["comments"] = $sql["comments"];
            if ($sql["user_can_c"] == 0) {
                $time_diff = ceil((time() - $sql["time"]) / 60);
                if ($serv["usercan_cancel"] && $time_diff <= $config["usercan_cancel_order_within_min"] && $config["config_self_cancel"]) {
                    $_orderDtl[$sql["order_id"]]["action"] = "<form method='post' action='orders.php?action=imei&status=all'>\n                <input type='hidden' name='cancelorderid' value='" . md5($sql["order_id"]) . "'>\n                <input type='submit' name='cancel' class='btncancelorder link' value='" . $lng_languag["cancel"] . "'></form>";
                } else {
                    $_orderDtl[$sql["order_id"]]["action"] = $lng_languag["locked"];
                }
            } else {
                if ($sql["user_can_c"] == 1) {
                    $_orderDtl[$sql["order_id"]]["action"] = $lng_languag["locked"];
                } else {
                    if ($sql["verified"] == 0 && $serv["verifiable"] && $sql["user_can_c"] == 4) {
                        $time_diff = ceil((time() - $sql["reply_time"]) / 60);
                        if ($time_diff <= $config["usercan_verify_order_within_min"] || $config["usercan_verify_order_within_min"] == "") {
                            $_orderDtl[$sql["order_id"]]["actionnew"] = "<a data-target=\"#modalverification\" data-toggle=\"modal\" \n         href=\"" . _url("widget/verify/1/actions/imei/id/" . md5($sql["order_id"])) . "\">" . $lng_languag["verify"] . "</a>";
                            $_orderDtl[$sql["order_id"]]["action"] = "<form method='post' action='orders.php?" . $_SERVER["QUERY_STRING"] . "'>\n        <input type='hidden' name='verification' value='" . md5($sql["order_id"]) . "'>\n        <input type='submit' name='cancel' class='btncancelorder link' value='" . $lng_languag["verify"] . "'></form>";
                        } else {
                            $_orderDtl[$row["order_id"]]["action"] = "-";
                        }
                    } else {
                        if ($sql["verified"] == 1) {
                            $_orderDtl[$sql["order_id"]]["action"] = $lng_languag["inprocess"];
                        } else {
                            if ($sql["verified"] == 2) {
                                $_orderDtl[$sql["order_id"]]["action"] = $lng_languag["verified"];
                            } else {
                                $_orderDtl[$sql["order_id"]]["action"] = "-";
                            }
                        }
                    }
                }
            }
            $tempalte_ver["imeilist"] = $_orderDtl;
            if ($sql["sn"]) {
                $tempalte_ver["sn"] = $sql["sn"];
            }
            if ($sql["secro"]) {
                $tempalte_ver["secro"] = $sql["secro"];
            }
            if ($sql["model_id"]) {
                $serv = mysqli_fetch_assoc(dquery("SELECT `Name` FROM `tbl_mobile`\n                     WHERE `ID`='" . $sql["model_id"] . "' "));
                $tempalte_ver["model"] = $serv["Name"];
            }
            if ($sql["provider_id"]) {
                $serv = mysqli_fetch_assoc(dquery("SELECT `Name` FROM `tbl_provider`\n                     WHERE `ID`='" . $sql["provider_id"] . "' "));
                $tempalte_ver["provider"] = $serv["Name"];
            }
            if ($sql["provider_c_id"]) {
                $serv = mysqli_fetch_assoc(dquery("SELECT `Name` FROM `tbl_provider_country`\n                     WHERE `ID`='" . $sql["provider_c_id"] . "' "));
                $tempalte_ver["providercountry"] = $serv["Name"];
            }
            $serv = mysqli_fetch_assoc(dquery("SELECT `mep` FROM `tbl_mep`\n             WHERE `id`='" . $sql["mep"] . "' "));
            $tempalte_ver["mep"] = $serv["mep"];
            $tempalte_ver["pin"] = $sql["PIN"];
            $tempalte_ver["kbh"] = $sql["KBH"];
            $tempalte_ver["prd"] = $sql["PRD"];
            $tempalte_ver["type"] = $sql["Type"];
            $tempalte_ver["reference"] = $sql["Reference"];
            $tempalte_ver["locks"] = $sql["Locks"];
            include_once ROOTDIR . "/includes/customfield.fun.inc.php";
            $tempalte_ver["custom"] = getCustomFields("serviceimei", $sql["service_id"], $sql["order_id"], "on");
        }
    } else {
        if ($action == "file") {
            $currentpage = "vieworder";
            $_nav = "<a href=\"" . _url("main") . "\">" . $lng_languag["vieworder"] . "</a> / ";
            $pagetitle = $lng_languag["vieworder"];
            $_nav .= "<a href='" . _url("vieworder") . "' >" . $lng_languag["vieworder"] . "</a> / ";
            $templatefile = "client_vieworderfile";
            $pageicon = "";
            installclient($pagetitle, $pageicon, $breadcrumbnav);
            $id = descape($id);
            $sql = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_order_file` WHERE `order_id`='" . $id . "' "));
            $user = mysqli_fetch_assoc(dquery("SELECT `reseller_id`,`storeownerid` FROM `tblUsers` WHERE `id`='" . $sql["user_id"] . "' "));
            if ($_ClientsDetails["id"] == $sql["user_id"] || $user["reseller_id"] == $_ClientsDetails["id"] || $user["storeownerid"] == $_ClientsDetails["id"]) {
                $tempalte_ver["orderid"] = $sql["order_id"];
                $tempalte_ver["userid"] = $sql["user_id"];
                $tempalte_ver["file"] = $sql["file"];
                $tempalte_ver["credit"] = $sql["credit"] - $sql["discount"];
                $tempalte_ver["date"] = $sql["time"];
                $tempalte_ver["reply_time"] = $sql["reply_time"];
                $tempalte_ver["reply"] = $sql["reply"];
                $tempalte_ver["note"] = $sql["note"];
                $tempalte_ver["comments"] = $sql["comments"];
                if ($store) {
                    $tempalte_ver["store"] = true;
                }
                if (!function_exists("getOrdersFile")) {
                    require_once ROOTDIR . "/includes/fileservices.fun.php";
                }
                $tempalte_ver["filelist"] = getOrdersFile($status, "", "", md5($id));
                $tempalte_ver["filedtl"] = getCustomFields("servicefile", $sql["service_id"], $sql["order_id"], "on");
                $serv = mysqli_fetch_assoc(dquery("SELECT `service_name` FROM `tbl_services_file` WHERE `id`='" . $sql["service_id"] . "' "));
                $tempalte_ver["service"] = $serv["service_name"];
                if ($sql["user_can_c"] == 0) {
                    $tempalte_ver["status"] = $lng_languag["waitingaction"];
                    $tempalte_ver["statusclass"] = "statusP";
                } else {
                    if ($sql["user_can_c"] == 1) {
                        $tempalte_ver["status"] = $lng_languag["inprocess"];
                        $tempalte_ver["statusclass"] = "statusY";
                    } else {
                        if ($sql["user_can_c"] == 3) {
                            $tempalte_ver["status"] = $lng_languag["rejected"];
                            $tempalte_ver["statusclass"] = "statusR";
                        } else {
                            if ($sql["user_can_c"] == 4) {
                                $tempalte_ver["status"] = $lng_languag["success"];
                                $tempalte_ver["statusclass"] = "statusA";
                            }
                        }
                    }
                }
                $tempalte_ver["comments"] = $sql["comments"];
            }
        } else {
            if ($action == "server") {
                global $status;
                global $_ClientsDetails;
                $currentpage = "vieworder";
                $_nav = "<a href=\"" . _url("main") . "\">" . $lng_languag["vieworder"] . "</a> / ";
                $pagetitle = $lng_languag["vieworder"];
                $_nav .= "<a href='" . _url("vieworder") . "' >" . $lng_languag["vieworder"] . "</a> / ";
                $templatefile = "client_vieworderserver";
                $pageicon = "";
                installclient($pagetitle, $pageicon, $breadcrumbnav);
                $id = descape($id);
                $sql = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_order_server` WHERE `order_id`='" . $id . "' "));
                $user = mysqli_fetch_assoc(dquery("SELECT `reseller_id`,`storeownerid` FROM `tblUsers` WHERE `id`='" . $sql["user_id"] . "' "));
                if ($sql["user_id"] != $_SESSION["uid"]) {
                    $tempalte_ver["errormsg"] = $lng_languag["logindiff"];
                }
                if ($_ClientsDetails["id"] == $sql["user_id"] || $user["reseller_id"] == $_ClientsDetails["id"] || $user["storeownerid"] == $_ClientsDetails["id"]) {
                    $tempalte_ver["orderid"] = $sql["order_id"];
                    $tempalte_ver["userid"] = $sql["user_id"];
                    $tempalte_ver["server"] = $sql["server"];
                    $tempalte_ver["credit"] = $sql["credit"] - $sql["discount"];
                    $tempalte_ver["date"] = $sql["time"];
                    $tempalte_ver["reply_time"] = $sql["reply_time"];
                    $tempalte_ver["reply"] = $sql["reply"];
                    $tempalte_ver["note"] = $sql["note"];
                    $tempalte_ver["comments"] = $sql["comments"];
                    if ($store) {
                        $tempalte_ver["store"] = true;
                    }
                    if (!function_exists("getOrdersServer")) {
                        require_once ROOTDIR . "/includes/serverservices.fun.php";
                    }
                    $tempalte_ver["serverservicelist"] = getOrdersServer($status, "", "", md5($id));
                    $tempalte_ver["serverdtl"] = getCustomFields("serviceserver", $sql["service_id"], $sql["order_id"], "on");
                    $serv = mysqli_fetch_assoc(dquery("SELECT `service_name` FROM `tbl_server_log` WHERE `id`='" . $sql["service_id"] . "' "));
                    $tempalte_ver["service"] = $serv["service_name"];
                    if ($sql["user_can_c"] == 0) {
                        $tempalte_ver["status"] = $lng_languag["waitingaction"];
                        $tempalte_ver["statusclass"] = "statusP";
                    } else {
                        if ($sql["user_can_c"] == 1) {
                            $tempalte_ver["status"] = $lng_languag["inprocess"];
                            $tempalte_ver["statusclass"] = "statusY";
                        } else {
                            if ($sql["user_can_c"] == 3) {
                                $tempalte_ver["status"] = $lng_languag["rejected"];
                                $tempalte_ver["statusclass"] = "statusR";
                            } else {
                                if ($sql["user_can_c"] == 4) {
                                    $tempalte_ver["status"] = $lng_languag["success"];
                                    $tempalte_ver["statusclass"] = "statusA";
                                }
                            }
                        }
                    }
                    $tempalte_ver["comments"] = $sql["comments"];
                }
            } else {
                if ($action == "product") {
                    $currentpage = "vieworder";
                    $_nav = "<a href=\"" . _url("main") . "\">" . $lng_languag["vieworder"] . "</a> / ";
                    $pagetitle = $lng_languag["vieworder"];
                    $_nav .= "<a href='" . _url("vieworder") . "' >" . $lng_languag["vieworder"] . "</a> / ";
                    $templatefile = "client_vieworderproduct";
                    $pageicon = "";
                    installclient($pagetitle, $pageicon, $breadcrumbnav);
                    $id = descape($id);
                    $sql = dquery("SELECT *,(select service_name from tbl_products where id=service_id) as service\n        ,reply_time,gatway,shipped_by,\n        user_can_c,(select return_days from tbl_products WHERE id=service_id) as returns\n        FROM `tbl_order_product` WHERE `invoiceid`='" . $id . "'");
                    if ($sql["user_id"] != $_SESSION["uid"]) {
                        $tempalte_ver["errormsg"] = $lng_languag["logindiff"];
                        while ($row = mysqli_fetch_assoc($sql)) {
                        }
                        $gene = mysqli_fetch_assoc(dquery("SELECT *,(select md5(id) from tbl_invoices where id=invoiceid) as invmd\n         FROM `tbl_order_product` WHERE `invoiceid`='" . $id . "'"));
                        $tempalte_ver["orders"] = $gene;
                        $porder = mysqli_fetch_assoc(dquery("SELECT *,(select (credit+total) from tbl_invoices where id=invoiceid) as total\n        ,(select status from tbl_invoices where id=invoiceid) as pstatus\n        ,(select md5(id) from tbl_invoices where id=invoiceid) as invmd\n         FROM `tbl_order_product` where user_id='" . $_SESSION["uid"] . "' and invoiceid='" . $id . "'"));
                        $tempalte_ver["order"] = $porder;
                        $sub = dquery("select user_can_c from tbl_order_product\n             where invoiceid=" . $id);
                        $stats = NULL;
                        while ($subs = mysqli_fetch_assoc($sub)) {
                            $stats[] = $subs["user_can_c"];
                        }
                        $stats = array_unique($stats);
                        $buf = "";
                        foreach ($stats as $s) {
                            if ($s == 0) {
                                $buf .= "," . $lng_languag["new"];
                            } else {
                                if ($s == 1) {
                                    $buf .= "," . $lng_languag["inprocess"];
                                } else {
                                    if ($s == 3) {
                                        $buf .= "," . $lng_languag["rejected"];
                                    } else {
                                        if ($s == 4) {
                                            $buf .= "," . $lng_languag["sent"];
                                        } else {
                                            if ($s == 5) {
                                                $buf .= "," . $lng_languag["unpaid"];
                                            } else {
                                                if ($s == 6) {
                                                    $buf .= "," . $lng_languag["onhold"];
                                                } else {
                                                    if ($s == 7) {
                                                        $buf .= "," . $lng_languag["received"];
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $tempalte_ver["order"]["allstatus"] = trim($buf, ",");
                    }
                    if ($row["user_can_c"] == 4 && $row["returns"]) {
                        $time = time();
                        $days = round(($time - $row["reply_time"]) / 86400);
                        if ($days <= $row["returns"]) {
                            $row["days"] = $days;
                        }
                    }
                    $row["md5"] = md5($row["order_id"]);
                    if ($row["shipped_by"]) {
                        $gat = mysqli_fetch_assoc(dquery("select trackingurl from \n                    tbl_shipping_services where id='" . $row["gatway"] . "'"));
                        if ($gat["trackingurl"]) {
                            $row["link"] = str_replace("[TID]", $row["shipped_by"], $gat["trackingurl"]);
                        }
                    }
                    $tempalte_ver["items"][$row["order_id"]] = $row;
                }
            }
        }
    }
    $tempalte_ver["token"] = generate_token("form");
    echo processSingleTemplate($templatefile);
    chkMd5sumsubpage();
} else {
    echo "Session expired. Please relogin";
    exit;
}
class no
{
}

?>