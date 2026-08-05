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
require ROOTDIR . "/includes/invoice.fun.php";
require_once ROOTDIR . "/includes/products.fun.php";
$tempalte_ver["voucher"] = $config["voucher"];
global $_ClientsDetails;
$currentpage = "Retail Order";
$_nav = "<a href=\"" . _url("main") . "\">" . $lng_languag["home"] . "</a> / ";
$action = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $action);
$status = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $status);
$id = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $id);
$search = preg_replace("/[^0-9\\-a-zA-Z ]/i", "", $search);
$return = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $return);
$id = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $id);
$pagetitle = $lng_languag["retail"] . " " . $lng_languag["order"];
$_nav .= "<a href='" . _url("ordershopping") . "' >" . $lng_languag["retail"] . " " . $lng_languag["order"] . "</a> / ";
$templatefile = "client_shop";
$pageicon = "";
installclient($pagetitle, $pageicon, $breadcrumbnav);
$fileverioncheck = "6.1.0";
global $next;
global $pagelimit;
if ($standalone) {
    $tempalte_ver["standalone"] = true;
}
if ($actions) {
    $tempalte_ver["actions"] = $actions;
} else {
    $tempalte_ver["actions"] = $action;
}
if ($status) {
    $tempalte_ver["status"] = $status;
    $tempalte_ver["search"] = true;
}
if (!function_exists("getProducts")) {
    require_once ROOTDIR . "/includes/products.fun.php";
}
$tempalte_ver["retailorderlink"] = _url("widget/retailorder");
$tempalte_ver["id"] = $id;
if ($_SESSION["uid"]) {
    if ($id && $detail) {
        $tempalte_ver["token"] = generate_token("form");
        $tempalte_ver["ids"] = $id;
        $pagetitle = $lng_languag["order"] . " " . $lng_languag["detail"];
        $templatefile = "client_shoporderdetail";
        $pageicon = "";
        $id = descape($id);
        $sql = dquery("SELECT *,(select download_id from tbl_products         where id=service_id) as downloads,(select service_name from tbl_products where id=service_id) as service        ,reply_time,gatway,shipped_by,        (select image_link1 from tbl_products where id=service_id) as image_link1,                user_can_c,(select return_days from tbl_products WHERE id=service_id) as returns        FROM `tbl_order_product` WHERE md5(`invoiceid`)='" . $id . "'");
        while ($row = mysqli_fetch_assoc($sql)) {
            if ($row["user_can_c"] == 4 && $row["returns"]) {
                $time = time();
                $days = round(($time - $row["reply_time"]) / 86400);
                if ($days <= $row["returns"]) {
                    $row["days"] = true;
                }
            }
            $row["md5"] = md5($row["order_id"]);
            if ($row["shipped_by"]) {
                $gat = mysqli_fetch_assoc(dquery("select trackingurl from \n                    tbl_shipping_services where (id)='" . $row["gatway"] . "'"));
                if ($gat["trackingurl"]) {
                    $row["link"] = str_replace("[TID]", $row["shipped_by"], $gat["trackingurl"]);
                }
            }
            if ($row["downloads"]) {
                $arr = explode(",", $row["downloads"]);
                foreach ($arr as $v) {
                    $f = mysqli_fetch_assoc(dquery("select * from tbl_download where id='" . $v . "'"));
                    $f["ivnoice"] = $id;
                    $row["download_arr"][md5($v)] = $f;
                }
            }
            $row["image_link"] = $row["image_link1"];
            $tempalte_ver["items"][$row["order_id"]] = $row;
        }
        $gene = mysqli_fetch_assoc(dquery("SELECT *,(select md5(id) from tbl_invoices         where id=invoiceid) as invmd         FROM `tbl_order_product` WHERE md5(`invoiceid`)='" . $id . "'"));
        $tempalte_ver["orders"] = $gene;
        $porder = mysqli_fetch_assoc(dquery("SELECT *,(select (credit+total) from tbl_invoices \n         where id=invoiceid) as total\n        ,(select status from tbl_invoices where id=invoiceid) as pstatus\n        ,(select md5(id) from tbl_invoices where id=invoiceid) as invmd\n         FROM `tbl_order_product` where user_id='" . $_SESSION["uid"] . "' and md5(invoiceid)='" . $id . "'"));
        $tempalte_ver["order"] = $porder;
        $sub = dquery("select user_can_c from tbl_order_product where md5(invoiceid)='" . $id . "'");
        $stats = NULL;
        while ($subs = mysqli_fetch_assoc($sub)) {
            $stats[] = $subs["user_can_c"];
        }
        if ($stats) {
            $stats = array_unique($stats);
        }
        $buf = "";
        if ($stats) {
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
        }
        $tempalte_ver["order"]["allstatus"] = trim($buf, ",");
        installclient($pagetitle, $pageicon, $breadcrumbnav);
        if ($standalone) {
            $tempalte_ver["standalone"] = true;
            echo processSingleTemplate($templatefile);
            exit;
        }
        DisplayOutput($templatefile);
        exit;
    } else {
        if ($reorder && $id) {
            $sql = dquery("select * from tbl_order_product where md5(invoiceid)='" . $id . "'");
            while ($r = mysqli_fetch_assoc($sql)) {
                $qnts = mysqli_num_rows(dquery("select order_id from tbl_order_product\n        where service_id='" . $r["service_id"] . "' and md5(invoiceid)='" . $id . "'"));
                $serviceDetails = getProducts("", md5($r["service_id"]), "", "", "", "", "", "", "", "", "", "", "", "", "", $qnts);
                $data = NULL;
                if ($serviceDetails["credit"] == 0 && $serviceDetails["zeropriceaction"] == 3) {
                    $serviceDetails["credit"] = $r["credit"];
                    $amount = $serviceDetails["credit"];
                }
                $data["note"] = $r["note"];
                $data["comments"] = $r["comments"];
                $data["service_id"] = $r["service_id"];
                if ($_SESSION["system_default_currency"]["id"] != $_ClientsDetails["currency_id"]) {
                    $serviceDetails["purchase_cost"] = getPurchaseCost($_SESSION["system_default_currency"]["id"], $serviceDetails["id"], "shop");
                    if (!$serviceDetails["purchase_cost"]) {
                        $serviceDetails["purchase_cost"] = convertCurrency($serviceDetails["purchase_cost"], $_SESSION["system_default_currency"]["id"], $_ClientsDetails["currency_id"]);
                    }
                }
                $data["purchase_cost"] = $serviceDetails["purchase_cost"];
                $data["user_id"] = $_ClientsDetails["id"];
                $data["date"] = date("Y-m-d");
                $data["time"] = time();
                $data["user_can_c"] = 5;
                if ($serviceDetails["subscription"]) {
                    $data["subscribe"] = 1;
                    dquery("UPDATE tbl_subscribers set used=used+1 WHERE \n    \t\tservice_id='" . $serviceDetails["id"] . "' AND user_id='" . $_ClientsDetails["id"] . "'\n    \t\tAND type='tbl_products'");
                }
                $data["pass_key"] = md5(time() . $_ClientsDetails["id"] . time());
                $data["credit"] = $serviceDetails["credit"];
                $data["discount"] = $serviceDetails["discount"];
                $data["gift"] = $r["gift"];
                $data["gatway"] = $r["gatway"];
                $invitem = mysqli_fetch_assoc(dquery("select \n                                                shippingtax,qnt,warehouseid,\n                                                paymentmethod from \n                                                tbl_invoiceitems WHERE \n                                                md5(invoiceid)='" . $id . "' AND \n        relid='" . $r["relid"] . "'"));
                $paymentmethod = $invitem["paymentmethod"];
                $data["sh_email"] = $r["sh_email"];
                $data["sh_contact"] = $r["sh_contact"];
                $data["sh_firstname"] = $r["sh_firstname"];
                $data["sh_lastname"] = $r["sh_lastname"];
                $data["sh_address1"] = $r["sh_address1"];
                $data["sh_address2"] = $r["sh_address2"];
                $data["sh_city"] = $r["sh_city"];
                $data["sh_zip"] = $r["sh_zip"];
                $data["sh_state"] = $r["sh_state"];
                $data["sh_country"] = $r["sh_country"];
                if ($serviceDetails["wholesaleprice"]) {
                    $data["wholesale"] = 1;
                }
                $date = date("Y-m-d");
                if ($serviceDetails["stock_allow"] && $serviceDetails["stock"] < 1 && $serviceDetails["outofstock"] == 0 || $date < $serviceDetails["availability_date"] && $serviceDetails["outofstock"] == 0) {
                    $data["buyadvance"] = 1;
                }
                $data["ip"] = $_SERVER["REMOTE_ADDR"];
                $data["currency_id"] = $_ClientsDetails["currency_id"];
                if (!function_exists(checkCustomFields)) {
                    require_once ROOTDIR . "/includes/customfield.fun.inc.php";
                }
                $oids = "";
                for ($i = 1; $i <= $qnts; $i++) {
                    $order = $db->insert("tbl_order_product", $data);
                    $ordarr[] = $order;
                    $amount = $serviceDetails["credit"] - $serviceDetails["discount"];
                    $cust = dquery("select * from tbl_customfieldsvalues where relid='" . $r["order_id"] . "'");
                    while ($cstm = mysqli_fetch_assoc($cust)) {
                        $extraprice = getPriceFromCustomField($cstm["fieldid"], $cstm["value"], $_SESSION["currency"]);
                        $amount = $amount + $extraprice;
                        insert_query("tbl_customfieldsvalues", ["fieldid" => $cstm["fieldid"], "relid" => $order, "value" => $cstm["value"]]);
                    }
                    insert_query("tbl_invoiceitems", ["qnt" => $qnts, "userid" => $_SESSION["uid"], "type" => "Product", "relid" => $order, "description" => $serviceDetails["service_name"], "amount" => $amount, "taxed" => $serviceDetails["taxed"], "duedate" => "now()", "paymentmethod" => $paymentmethod, "shippingtax" => $invitem["shippingtax"], "warehouseid" => $invitem["warehouseid"]]);
                }
                unset($data);
            }
            $invoiceid = generateInvoice($_SESSION["uid"]);
            if (is_array($ordarr)) {
                foreach ($ordarr as $o) {
                    if ($o) {
                        dquery("UPDATE tbl_order_product set invoiceid='" . $invoiceid . "' where order_id='" . $o . "'");
                        $s = mysqli_fetch_assoc(dquery("select *,(select \n            service_name from tbl_products where id=service_id) as item,\n            (select username from tblUsers where id=user_id) as user,\n            (select email from tblUsers where id=user_id) as email\n            from tbl_order_product where order_id='" . $o . "'"));
                        $itms .= $s["item"] . "<br />";
                        $user = $s["user"] . " [ " . $s["email"] . " ]";
                        $shipper = $s["sh_firstname"] . " " . $s["sh_lastname"] . "<br />";
                        $shipper .= $s["sh_address1"] . "<br />";
                        $shipper .= $s["sh_address2"] . "<br />";
                        $shipper .= $s["sh_city"] . " " . $s["sh_zip"] . "<br />";
                        $shipper .= $s["sh_state"] . "<br />";
                        $shipper .= $s["sh_country"] . "<br />";
                        $shipper .= $s["sh_contact"] . "<br />";
                    }
                }
                require_once ROOTDIR . "/includes/mail.fun.php";
                $adminmessage = " New Shop order Placed <br />\n                      Details are <br /><br />\n                      =============================<br />\n                      Customer : " . $user . " <br />\n                      ---------------<br />\n                      Items : " . $itms . " \n                      ---------------<br />\n                      Shipping Address: <br />\n                      " . $shipper . "\n                      ";
                $to[0] = $config["config_admin_mail"];
                sendNotification("system", "New Shopping Order", $adminmessage, $to);
            }
            header("Location: " . _url("viewinvoice/id/" . md5($invoiceid)));
        }
        if ($return) {
            $pagetitle = $lng_languag["return"] . " " . $lng_languag["request"];
            $templatefile = "client_returnrequest";
            $pageicon = "";
            installclient($pagetitle, $pageicon, $breadcrumbnav);
            $row = mysqli_fetch_assoc(dquery("SELECT order_id,service_id,requestsend\n            ,reply_time,user_can_c,(select return_days from tbl_products WHERE id=service_id) as returns\n             FROM `tbl_order_product` WHERE md5(order_id)='" . $return . "' and user_id='" . $_SESSION["uid"] . "'"));
            $flag = false;
            if ($row["user_can_c"] == 4 && $row["returns"]) {
                $time = time();
                $days = round(($time - $row["reply_time"]) / 86400);
                if ($days <= $row["returns"]) {
                    $flag = true;
                }
            }
            if ($flag) {
                $tempalte_ver["ids"] = $return;
            } else {
                $templatefile = "client_accessdenied";
                $tempalte_ver["notification"]["error"] = $lng_languag["yournotallowed"];
            }
            if ($row["requestsend"]) {
                $templatefile = "client_accessdenied";
                $tempalte_ver["notification"]["success"] = $lng_languag["request"] . " " . $lng_languag["sended"];
            }
        } else {
            $tempalte_ver["actin"] = $action;
            $tempalte_ver["search"] = $search;
            if (!$status && isset($_SESSION["shopstat"])) {
                $status = $_SESSION["shopstat"];
            } else {
                if ($status) {
                    $_SESSION["shopstat"] = $status;
                }
            }
            $WHEREs = "";
            if ($search) {
                $WHEREs = " and (id in (select invoiceid from tbl_invoiceitems\n            where description like '%" . $search . "%')\n            \n            or id='" . $search . "'\n            )";
                $id = NULL;
            }
            if ($id) {
                $WHEREs .= " and id='" . $id . "'";
            }
            if (!$fromstart) {
                $fromstart = 0;
            }
            $tempalte_ver["fromstart"] = $fromstart;
            $limits = 10;
            $query = "select * from tbl_invoices\n        where userid='" . $_SESSION["uid"] . "' and  retail=1 " . $WHEREs . " LIMIT " . $fromstart . "," . $limits;
            $tempalte_ver["totalrows"] = mysqli_num_rows(dquery("select * from tbl_invoices\n        where userid='" . $_SESSION["uid"] . "' and retail=1 " . $WHEREs));
            $porder = dquery($query);
            while ($row = mysqli_fetch_assoc($porder)) {
                $Datas = $row;
                unset($row);
                $row["orderid"] = $Datas["id"];
                $row["invocielink"] = _url("viewinvoice/id/" . md5($Datas["id"]));
                $row["total"] = formatCurrency($Datas["total"], "", 2);
                $row["date"] = date("M d Y", $Datas["time"]);
                $row["time"] = date("h:i A", $Datas["time"]);
                $row["orderstatus"] = $Datas["orderstatus"];
                if ($Datas["orderstatus"] == "accepted") {
                    $row["orderstatus"] = "unshipped";
                }
                $row["paymentstatus"] = $Datas["status"];
                if ($Datas["onhold"] == 1 || $Datas["receivedamount"] == $Datas["total"] && $Datas["status"] == "Unpaid") {
                    $row["paymentstatus"] = $lng_languag["waitingapproval"];
                } else {
                    if ($Datas["status"] == "Unpaid" && 0 < $Datas["receivedamount"]) {
                        $row["paymentstatus"] = $lng_languag["partiallypaid"];
                    } else {
                        if ($Datas["status"] == "Unpaid") {
                            $row["paymentstatus"] = $lng_languag["waitingpayment"];
                        }
                    }
                }
                $q = dquery("select group_concat(order_id) as ids,\n(select service_name from tbl_products\nwhere id=service_id) as item,\n(select image_link1 from tbl_products\nwhere id=service_id) as image\n,(select sku from tbl_products\nwhere id=service_id) as sku,service_id ,shipped_by,status,note,tracking, credit,(select weight from tbl_products where id=service_id) as weight\nfrom tbl_order_product where invoiceid='" . $Datas["id"] . "' \ngroup by service_id order by order_id asc");
                $total = 0;
                $weights = 0;
                while ($r = mysqli_fetch_assoc($q)) {
                    $qnt = mysqli_num_rows(dquery("select order_id\n                            from tbl_order_product where service_id='" . $r["service_id"] . "'\n                            and invoiceid='" . $Datas["id"] . "'"));
                    $total += $r["credit"] * $qnt;
                    $weights += $r["weight"] * $qnt;
                    $Orders = explode(",", $r["ids"]);
                    $Custom = getCustomFields("product", $r["service_id"], $Orders[0]);
                    $buff = "";
                    foreach ($Custom as $cdetail) {
                        $buff .= $cdetail["name"] . ": " . $cdetail["rawvalue"] . " ,";
                    }
                    $Ship = mysqli_fetch_assoc(dquery("select `value` from tbl_shipping_services\n            where id='" . $r["shipped_by"] . "'"));
                    $row["items"][$r["service_id"]]["shipping"] = $Ship["value"];
                    $item = preg_replace("/[^0-9a-zA-Z-\\_]/i", "", str_replace(" ", "-", $r["item"]));
                    $row["items"][$r["service_id"]]["productlink"] = _url("product/" . $item . "?pid=" . $r["service_id"]);
                    $row["items"][$r["service_id"]]["trackinglink"] = $r["tracking"];
                    $row["items"][$r["service_id"]]["status"] = $r["status"] ? $r["status"] : "new";
                    if ($row["items"][$r["service_id"]]["status"] == "new") {
                        $row["items"][$r["service_id"]]["nstatus"] = 1;
                    } else {
                        if ($row["items"][$r["service_id"]]["status"] == "unshipped") {
                            $row["items"][$r["service_id"]]["nstatus"] = 2;
                        } else {
                            if ($row["items"][$r["service_id"]]["status"] == "dispatched") {
                                $row["items"][$r["service_id"]]["nstatus"] = 3;
                            } else {
                                $row["items"][$r["service_id"]]["nstatus"] = 4;
                            }
                        }
                    }
                    $row["items"][$r["service_id"]]["item"] = $r["item"];
                    $row["items"][$r["service_id"]]["sku"] = $r["sku"];
                    $row["items"][$r["service_id"]]["custom"] = $buff;
                    $row["items"][$r["service_id"]]["qnt"] = $qnt;
                    $row["items"][$r["service_id"]]["image"] = $r["image"];
                    $row["items"][$r["service_id"]]["weight"] = $weights . " Kg";
                }
                $tempalte_ver["productorderslist"][$Datas["id"]] = $row;
            }
            $pagelimit = 100 < $config["default_page_limit"] ? $config["default_page_limit"] : 100;
        }
        $tempalte_ver["neworder"] = _url("ordershopping/action/new");
        $tempalte_ver["shippedorder"] = _url("ordershopping/action/shipped");
        $tempalte_ver["token"] = generate_token("form");
        if ($standalone) {
            $tempalte_ver["standalone"] = true;
            echo processSingleTemplate($templatefile);
            exit;
        }
    }
} else {
    $_SESSION["afterloginredirect"] = $_SERVER["REQUEST_URI"];
    include_once ROOTDIR . "/includes/login.inc.php";
    installclient($pagetitle, $pageicon, $breadcrumbnav);
}
DisplayOutput($templatefile);
chkMd5sumsubpage();
class no
{
}

?>