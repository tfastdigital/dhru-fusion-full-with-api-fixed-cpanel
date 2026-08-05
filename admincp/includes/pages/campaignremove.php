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
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($user) {
    if ($user == 1) {
        $where = " 1=1 ";
        if ($usertype) {
            $where .= " and usertype=" . $usertype;
        }
        if ($userstatus == 2) {
            $where .= " and userstatus=2";
        }
        if ($userstatus == 1) {
            $where .= " and userstatus=0";
        }
        if ($clientgroup) {
            $where .= " and client_group='" . $clientgroup . "'";
        }
        if ($unsubscriber) {
            $where .= " and news_letter=1";
        }
        $cnt = mysqli_num_rows(dquery("select id from tblUsers where " . $where));
    } else {
        $cnt = mysqli_num_rows(dquery("select id from tbl_newsletter"));
    }
    echo "Total Recipients :" . $cnt;
} else {
    if ($remove) {
        dquery("DELETE FROM tbl_campaign_users where campaignid='" . $remove . "'");
        dquery("DELETE FROM tbl_campaign where id='" . $remove . "'");
    }
}

?>