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
require "comm.php";
require "includes/fun.inc.php";
require "includes/client.area.inc.php";
$currentpage = "placeorderimei";
$_nav = "<a href=\"main.php\">" . $lng_languag["home"] . "</a> / ";
$id = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $id);
$o = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $o);
$u = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $u);
$flag = false;
if ($u == "i") {
    $sql = dquery("select order_id,(select email from tblUsers \n    where id=user_id) as mail,service_id from tbl_order_imei where md5(order_id)='" . $o . "'");
    if (mysqli_num_rows($sql)) {
        $pagetitle = $lng_languag["feedback"];
        $_nav .= "<a href='feedback.php?u=i&o=" . $o . "' >" . $lng_languag["feedback"] . "</a> / ";
        $templatefile = "client_feedback_service";
        $pageicon = "";
        installclient($pagetitle, $pageicon, $breadcrumbnav);
        $data = mysqli_fetch_assoc($sql);
        $tempalte_ver["email"] = $data["mail"];
        $tempalte_ver["order"] = $o;
        $tempalte_ver["type"] = "imei";
    } else {
        $flag = true;
    }
    $sql = mysqli_fetch_assoc($sql);
    $sql = dquery("select * from tbl_review where (select service_id from tbl_order_imei\n    where md5(order_id)='" . $o . "')='" . $data["service_id"] . "'");
    if (mysqli_num_rows($sql)) {
        $flag = true;
    }
} else {
    if ($u == "f") {
        $sql = dquery("select order_id,(select email from tblUsers \n    where id=user_id) as mail,service_id from tbl_order_file where md5(order_id)='" . $o . "'");
        if (mysqli_num_rows($sql)) {
            $pagetitle = $lng_languag["feedback"];
            $_nav .= "<a href='feedback.php?u=f&o=" . $o . "' >" . $lng_languag["feedback"] . "</a> / ";
            $templatefile = "client_feedback_service";
            $pageicon = "";
            installclient($pagetitle, $pageicon, $breadcrumbnav);
            $data = mysqli_fetch_assoc($sql);
            $tempalte_ver["email"] = $data["mail"];
            $tempalte_ver["order"] = $o;
            $tempalte_ver["type"] = "file";
        } else {
            $flag = true;
        }
    } else {
        if ($u == "s") {
            $sql = dquery("select order_id,(select email from tblUsers \n    where id=user_id) as mail,service_id from tbl_order_server where md5(order_id)='" . $o . "'");
            if (mysqli_num_rows($sql)) {
                $pagetitle = $lng_languag["feedback"];
                $_nav .= "<a href='feedback.php?u=s&o=" . $o . "' >" . $lng_languag["feedback"] . "</a> / ";
                $templatefile = "client_feedback_service";
                $pageicon = "";
                installclient($pagetitle, $pageicon, $breadcrumbnav);
                $data = mysqli_fetch_assoc($sql);
                $tempalte_ver["email"] = $data["mail"];
                $tempalte_ver["order"] = $o;
                $tempalte_ver["type"] = "server";
            } else {
                $flag = true;
            }
            $sql = mysqli_fetch_assoc($sql);
            $sql = dquery("select * from tbl_review where (select service_id from tbl_order_server\n    where md5(order_id)='" . $o . "')='" . $data["service_id"] . "'");
            if (mysqli_num_rows($sql)) {
                $flag = true;
            }
        } else {
            if ($u == "c") {
                $sql = dquery("select order_id,(select email from tblUsers \n    where id=user_id) as mail,service_id from tbl_order_product where md5(order_id)='" . $o . "'");
                if (mysqli_num_rows($sql)) {
                    $pagetitle = $lng_languag["feedback"];
                    $_nav .= "<a href='feedback.php?u=c&o=" . $o . "' >" . $lng_languag["feedback"] . "</a> / ";
                    $templatefile = "client_feedback_service";
                    $pageicon = "";
                    installclient($pagetitle, $pageicon, $breadcrumbnav);
                    $data = mysqli_fetch_assoc($sql);
                    $tempalte_ver["email"] = $data["mail"];
                    $tempalte_ver["order"] = $o;
                    $tempalte_ver["type"] = "shop";
                } else {
                    $flag = true;
                }
                $sql = mysqli_fetch_assoc($sql);
                $sql = dquery("select * from tbl_review where (select service_id from tbl_order_product\n    where md5(order_id)='" . $o . "')='" . $data["service_id"] . "'");
                if (mysqli_num_rows($sql)) {
                    $flag = true;
                }
            } else {
                $sql = dquery("select service_id from tbl_order_product where md5(order_id)='" . $id . "' AND feedback='0'");
                if (!mysqli_num_rows($sql)) {
                    $id = false;
                }
                $pagetitle = $lng_languag["feedback"] . " " . $lng_languag["form"];
                $_nav .= "<a href='feedback.php' >" . $lng_languag["feedback"] . "</a> / ";
                $templatefile = "client_feedback";
                $pageicon = "";
                installclient($pagetitle, $pageicon, $breadcrumbnav);
                if ($id) {
                    $sql = mysqli_fetch_assoc($sql);
                    $sql = mysqli_fetch_assoc(dquery("select id,service_name,bysupplier from tbl_products \n        where id='" . $sql["service_id"] . "'"));
                    $tempalte_ver["service"] = $sql["service_name"];
                    $tempalte_ver["mdservice"] = $id;
                } else {
                    $flag = true;
                }
            }
        }
    }
}
if ($flag) {
    $templatefile = "client_accessdenied";
    $tempalte_ver["rightmenu"] = false;
    $tempalte_ver["notification"]["error"] = $lng_languag["yournotallowed"];
}
$tempalte_ver["token"] = generate_token("form");
chkMd5sumsubpage();
$fileverioncheck = "6.1.0";
DisplayOutput($templatefile);
class no
{
}

?>