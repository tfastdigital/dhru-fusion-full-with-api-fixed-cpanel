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
$currentpage = "support";
$pagetitle = $lng_languag["track"] . " " . $lng_languag["order"];
$_nav = "<a href=\"index.php\">" . $lng_languag["home"] . "</a> / ";
$_nav .= "<a href=\"support.php\">" . $lng_languag["track"] . " " . $lng_languag["service"] . "</a>";
$templatefile = "trackservice";
$pageicon = "";
installclient($pagetitle, $pageicon, $breadcrumbnav);
$imei = preg_replace("/[^0-9\\n]/i", "", $imei);
$oid = preg_replace("/[^0-9]/i", "", $oid);
$imeiarr = explode("\n", $imei);
$user = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $user);
if (isset($view) && $token == sha1(session_id() . ":RopccsS33")) {
    if (!$pin) {
        $tempalte_ver["notification"]["error"] = "Field Required";
    } else {
        foreach ($imeiarr as $imei) {
            if ($imei != "" && is_numeric($imei) && 15 <= strlen($imei)) {
                if ($storeowner) {
                    $uis = $storeowner["userid"];
                    $pin = enc((string) $pin, "9486");
                    $sql = dquery("select order_id,imei,reply,user_can_c from tbl_order_imei \n                where imei='" . $imei . "'\n                and user_id in (select id from tblUsers where\n                master_pin='" . $pin . "' and (select reseller_id from tblUsers\n                where id=user_id)='" . $uis . "'");
                } else {
                    $pin = enc((string) $pin, "9486");
                    $sql = dquery("select order_id,imei,reply,user_can_c from tbl_order_imei \n                where imei='" . $imei . "'\n                and user_id in (select id from tblUsers where\n                master_pin='" . $pin . "')");
                }
                if (mysqli_num_rows($sql)) {
                    $data = mysqli_fetch_assoc($sql);
                    if ($data["user_can_c"] == 0) {
                        $buf = $lng_languag["new"];
                    } else {
                        if ($data["user_can_c"] == 1) {
                            $buf = $lng_languag["inprocess"];
                        } else {
                            if ($data["user_can_c"] == 3) {
                                $buf = $lng_languag["rejected"];
                                $tempalte_ver["reply"] = $data["reply"];
                            } else {
                                if ($data["user_can_c"] == 4) {
                                    $buf = $lng_languag["replied"];
                                    $tempalte_ver["reply"] = $data["reply"];
                                } else {
                                    if ($data["user_can_c"] == 5) {
                                        $buf = $lng_languag["unpaid"];
                                    }
                                }
                            }
                        }
                    }
                    $Details[$data["order_id"]]["status"] = $buf;
                    $Details[$data["order_id"]]["imei"] = $data["imei"];
                    $Details[$data["order_id"]]["reply"] = $data["reply"];
                    $tempalte_ver["flag"] = true;
                } else {
                    $tempalte_ver["notification"]["error"] = $lng_languag["invalidimei"] . " " . $imei;
                }
            } else {
                $tempalte_ver["notification"]["error"] = $lng_languag["invalidimei"] . " " . $imei . " ";
            }
        }
    }
}
if (isset($views) && $token == sha1(session_id() . ":RopccsS33")) {
    if (!$user) {
        $tempalte_ver["notification"]["error"] = "Field Required";
    } else {
        $oid = descape($oid);
        if ($storeowner) {
            $uis = $storeowner["userid"];
            $sql = dquery("SELECT *,(select service_name from tbl_products where id=service_id) as service\n            ,user_can_c\n            FROM `tbl_order_product` WHERE `invoiceid`='" . $oid . "'\n            and ((select username from tblUsers where id=user_id )='" . $user . "' or\n           (select email from tblUsers where id=user_id )='" . $user . "'\n           ) and (select reseller_id from tblUsers where id=user_id)='" . $uis . "'");
        } else {
            $sql = dquery("SELECT *,(select service_name from tbl_products where id=service_id) as service\n    ,user_can_c\n    FROM `tbl_order_product` WHERE `invoiceid`='" . $oid . "'\n    and ((select username from tblUsers where id=user_id )='" . $user . "' or\n           (select email from tblUsers where id=user_id )='" . $user . "')");
        }
        if (mysqli_num_rows($sql)) {
            $inv = dquery("select order_id,(select service_name from tbl_products where id=service_id) as\n         service,\n        user_can_c from tbl_order_product where invoiceid='" . $oid . "'\n           and ((select username from tblUsers where id=user_id )='" . $user . "' or\n           (select email from tblUsers where id=user_id )='" . $user . "'\n           )");
            while ($r = mysqli_fetch_assoc($inv)) {
                $Details[$r["order_id"]]["service"] = $r["service"];
                $s = $r["user_can_c"];
                if ($s == 0) {
                    $buf = $lng_languag["new"];
                } else {
                    if ($s == 1) {
                        $buf = $lng_languag["inprocess"];
                    } else {
                        if ($s == 3) {
                            $buf = $lng_languag["rejected"];
                        } else {
                            if ($s == 4) {
                                $buf = $lng_languag["sent"];
                            } else {
                                if ($s == 5) {
                                    $buf = $lng_languag["unpaid"];
                                } else {
                                    if ($s == 6) {
                                        $buf = $lng_languag["onhold"];
                                    } else {
                                        if ($s == 7) {
                                            $buf = $lng_languag["received"];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                $Details[$r["order_id"]]["status"] = $buf;
            }
            $tempalte_ver["invoiceid"] = $oid;
            $tempalte_ver["details"] = $Details;
        } else {
            $tempalte_ver["notification"]["error"] = $lng_languag["invalid"] . " " . $lng_languag["orderid"] . "  or Username";
        }
    }
}
$tempalte_ver["details"] = $Details;
$tempalte_ver["token"] = generate_token("form");
chkMd5sumsubpage();
$fileverioncheck = "6.1.0";
DisplayOutput($templatefile);
class no
{
}

?>