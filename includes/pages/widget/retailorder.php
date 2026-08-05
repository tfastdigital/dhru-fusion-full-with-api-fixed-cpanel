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
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
require_once ROOTDIR . "/includes/clients.fun.inc.php";
if (!function_exists(checkCustomFields)) {
    require_once ROOTDIR . "/includes/customfield.fun.inc.php";
}
installclient($pagetitle, $pageicon, $breadcrumbnav);
$action = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $action);
$status = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $status);
$id = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $id);
$search = preg_replace("/[^0-9\\-a-zA-Z ]/i", "", $search);
$return = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $return);
$id = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $id);
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
$query = "select * from tbl_invoices\n        where userid='" . $_SESSION["uid"] . "' and retail=1 " . $WHEREs . " LIMIT " . $fromstart . "," . $limits;
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
        $row["paymentstatus"] = "Waiting for Approval";
    } else {
        if ($Datas["status"] == "Unpaid" && 0 < $Datas["receivedamount"]) {
            $row["paymentstatus"] = "Partially Paid";
        } else {
            if ($Datas["status"] == "Unpaid") {
                $row["paymentstatus"] = "Waiting Payment";
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
echo processSingleTemplate("client_shop_order_load");

?>