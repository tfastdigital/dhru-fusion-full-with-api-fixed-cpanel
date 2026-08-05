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
if (!isset($_SESSION["uid"])) {
    exit;
}
$id = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $id);
$next = preg_replace("/[^0-9.]/i", "", $next);
$pagelimit = preg_replace("/[^0-9.]/i", "", $pagelimit);
if ($_REQUEST["actions"]) {
    $action = $_REQUEST["actions"];
}
if ($_SESSION["uid"] && $id) {
    if ($action == "overview") {
        $pagetitle = $lng_languag["overview"];
        $_nav .= "<a href='" . _url("reseller/action/myuser") . "' >" . $lng_languag["overview"] . "</a> / ";
        $templatefile = "client_reseller_overview";
        $pageicon = "";
        installclient($pagetitle, $pageicon, $breadcrumbnav);
        $id = descape($id);
        $Uis = mysqli_fetch_assoc(dquery("select id from tblUsers where md5(id)='" . $id . "'"));
        $Ruser = getClientsDetails($Uis["id"]);
        $tempalte_ver["Ruser"] = $Ruser;
        $qt1 = mysqli_fetch_assoc(dquery("select sum(amount) as total from tbl_reseller_payout\n        where userid='" . $Uis["id"] . "' and reseller='" . $_SESSION["uid"] . "' and status='CR'"));
        $tempalte_ver["paytotal"] = $qt1["total"];
        $qt2 = mysqli_fetch_assoc(dquery("select sum(amount) as total from tbl_reseller_payout\n        where userid='" . $Uis["id"] . "' and reseller='" . $_SESSION["uid"] . "' and status='DR'"));
        $tempalte_ver["paypaid"] = $qt2["total"];
        $tempalte_ver["paypending"] = $qt1["total"] - $qt2["total"];
        $tempalte_ver["imeiorder"] = mysqli_num_rows(dquery("select order_id from tbl_order_imei \n        where user_id='" . $Uis["id"] . "' and user_can_c='4' and `server`=0"));
        $tempalte_ver["fileorder"] = mysqli_num_rows(dquery("select order_id from tbl_order_file \n        where user_id='" . $Uis["id"] . "' and user_can_c='4'"));
        $tempalte_ver["serverorder"] = mysqli_num_rows(dquery("select order_id from tbl_order_imei \n        where user_id='" . $Uis["id"] . "' and user_can_c='4'  and `server`=1"));
        $tempalte_ver["userid"] = $Uis["id"];
        $tempalte_ver["changestatlink"] = _url("widget/save/reseller/action/changestat");
        $tempalte_ver["resetpasslink"] = _url("widget/save/reseller/action/resetpass");
        $tempalte_ver["changepasslink"] = _url("widget/save/reseller/action/changepassword");
    } else {
        if ($action == "statement") {
            $pagetitle = $lng_languag["statement"];
            $_nav .= "<a href='" . _url("reseller/action/myuser") . "' >" . $lng_languag["statement"] . "</a> / ";
            $templatefile = "client_reseller_payout";
            $pageicon = "";
            installclient($pagetitle, $pageicon, $breadcrumbnav);
            $id = descape($id);
            $Uis = mysqli_fetch_assoc(dquery("select id from tblUsers where md5(id)='" . $id . "'"));
            $query = "SELECT * FROM `tbl_reseller_payout` WHERE md5(userid)='" . $id . "' \nORDER BY `id`";
            $result = dquery($query);
            $tot_result = mysqli_num_rows($result);
            generatePaginate($query);
            while ($row = mysqli_fetch_assoc($result)) {
                $_orderDtl[$row["id"]]["id"] = $row["id"];
                if ($row["date"]) {
                    $_orderDtl[$row["id"]]["date"] = date("Y-m-d", $row["date"]);
                }
                $_orderDtl[$row["id"]]["note"] = $row["note"];
                $_orderDtl[$row["id"]]["status"] = $row["status"];
                $_orderDtl[$row["id"]]["amount"] = $row["amount"];
            }
            $tempalte_ver["userid"] = $Uis["id"];
            $tempalte_ver["statement"] = $_orderDtl;
            $tempalte_ver["reselleruseraddpaylink"] = _url("widget/save/reseller/action/addpay");
        }
    }
    $tempalte_ver["token"] = generate_token("form");
    echo processSingleTemplate($templatefile);
}

?>