<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div title=\"dashboard\" id=\"tutid\">\r\n</div>\r\n";
$pageid = 298;
checkPagePermission($pageid);
if ($config["config_is_under_maintanance"]) {
    echo "    <div id=\"notification\" class=\"alert\">\r\n        ";
    echo $LNG["maintancemodeon"];
    echo "    </div>\r\n    ";
}
$lite = $WhiteLabel = $liteplus = $versioncatch = false;
$addons = [];
try {
    $results = "asd";
    if ($debug_output) {
        echo "<textarea cols=100 rows=20>";
        print_r($results);
        echo "</textarea>";
    }
    if ($results["status"] === "Active") {
        
        $_server_ip = isset($_SERVER["SERVER_ADDR"]) ? $_SERVER["SERVER_ADDR"] : $_SERVER["LOCAL_ADDR"];
      
        if ($results["item_id"] === "06d2db89-494c-463b-9e21-289991a74952") {
            $lite = true;
        } else {
            if ($results["item_id"] === "43") {
                $liteplus = true;
            }
        }
        foreach ($results["addons"] as $addondetail => $addondetail) {
            if ($addondetail["name"] == "White Label" && $addondetail["status"] == "Active") {
                $WhiteLabel = true;
            }
        }
        if ($results["addons"]) {
            $addons = $results["addons"];
        }
        if ($devmode) {
            $versioncatch = md5(time());
        } else {
            $versioncatch = $results["version"]["release"];
        }
    } else {
        throw new Exception("License is not active");
    }
} catch (Exception $e) {
    $_error = urlencode($e->getMessage());
    echo "<script type=\"text/javascript\"> window.location = \"update_lic.php?error=" . $_error . "\" </script>";
    header("location: update_lic.php?error=" . $_error);
    exit;
}
unset($results);
$defaultprogress = 3;
$today = date("Y-m-d", time());
$yesterday = date("Y-m-d", time() - 86400);
$month = date("m", time());
$pmonth = date("m", mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
$year = date("Y", time());
$pyear = date("Y") - 1;
$defaultcurrency = mysqli_fetch_assoc(dquery("SELECT id from `tbl_currencies` where `default`='1'"));
if (!$onlymerchant) {
    $allset = base64_encode($cntin . "-" . $cntia . "-" . $cntfn . "-" . $cntfa . "-" . $cntsn . "-" . $cntsa . "-" . $cnttckn . "-" . $cnttckw . "-" . $cntpn . "-" . $cntpa);
    $condition = ["totalorder" => "(1=1)", "totalnew" => " user_can_c='0'", "totalaccepted" => " user_can_c='1'", "todaystotal" => "date='" . $today . "' and (1=1)", "todaysnew" => "  date='" . $today . "' and user_can_c='0'", "todaysaccepted" => " date='" . $today . "' and user_can_c='1'", "todaysrejected" => " date='" . $today . "' and user_can_c='3'", "todayscompleted" => " reply_date='" . $today . "' and (user_can_c='4')", "verify" => "verified='1' and user_can_c='4'", "yestotal" => " date='" . $yesterday . "' and (1=1)", "yesaccepted" => " date='" . $yesterday . "' and user_can_c='1'", "yescompleted" => " reply_date='" . $yesterday . "' and ( user_can_c='4')", "frommonth" => "MONTH(date)='" . $month . "' and YEAR(date)='" . $year . "'", "fromyear" => "YEAR(date)='" . $year . "'"];
    $allset = $order["tbl_order_imei"]["totalnew"] . "-" . $order["tbl_order_imei"]["totalaccepted"] . "-" . $order["tbl_order_file"]["totalnew"] . "-" . $order["tbl_order_file"]["totalaccepted"] . "-" . $order["tbl_order_server"]["totalnew"] . "-" . $order["tbl_order_server"]["totalaccepted"] . "-" . $order["tbl_order_file"]["totalnew"] . "-" . $order["tbl_order_file"]["totalaccepted"] . "-" . $order["tbl_order_product"]["totalnew"] . "-" . $order["tbl_order_product"]["totalaccepted"];
    $vals = explode("-", $allset);
    $cntverifyapi = mysqli_num_rows(dquery("SELECT order_id\r\nFROM `tbl_order_imei` WHERE autosend=1 and user_can_c=0 and server=0"));
    $cntserverapiorder = mysqli_num_rows(dquery("select order_id from tbl_order_imei\r\nwhere server=1 and ORDERAPI_ID!='' and user_can_c=1 and time<" . $ordertime));
    $cntverifyapiserver = mysqli_num_rows(dquery("SELECT order_id\r\nFROM `tbl_order_imei` WHERE autosend=1 and user_can_c=0 and server=1"));
    $cntimeiapiorder = mysqli_num_rows(dquery("select order_id from tbl_order_imei\r\nwhere `server`=0 and ORDERAPI_ID!=''\r\nand user_can_c=1 and time<" . $ordertime));
}
echo "<div>\r\n    ";
if (!$onlymerchant) {
    if (!$mobilebrowser && !$OnlyEcommerce) {
        echo "                <div>\r\n                    <div class=\"graph\">\r\n\r\n                    </div>\r\n                </div>\r\n                ";
    }
} else {
    echo "        <div>\r\n            <div class=\"graph\">\r\n\r\n            </div>\r\n        </div>\r\n        ";
}
if ($onlymerchant) {
    echo "\r\n        <div style=\"display: flex;margin-top:20px\">\r\n            <div style=\"width:48%\">\r\n                <table  class=\"order-table\" id=\"main_tbl\">\r\n                    <tr>\r\n                        <th colspan=\"3\"  style=\"text-align: left !important;\"> Last 5 Fund Transfer </th>\r\n                    </tr>\r\n                    ";
    $q = dquery("select *,(select username from tblUsers where tblUsers.id=tbl_statement_user.uid) as user,(select\r\ncode from tbl_currencies where tbl_currencies.id=(select default_currency \r\nfrom tblUsers where id=uid)) as code from tbl_statement_user where stype='Transfer' order by id desc limit 5 ");
    while ($r = mysqli_fetch_assoc($q)) {
        echo "                        <tr>\r\n                            <td>";
        echo $r["date"];
        echo "</td>\r\n                            <td>";
        echo $r["user"];
        echo "</td>\r\n                            <td>";
        echo $r["amount"] . " " . $r["code"];
        echo "</td>\r\n                        </tr>\r\n                        ";
    }
    echo "                </table>\r\n            </div>\r\n\r\n            <div  style=\"width:48%;margin-left:auto\">\r\n\r\n                <table  class=\"order-table\" id=\"main_tbl\">\r\n                    <tr>\r\n                        <th colspan=\"3\" style=\"text-align: left !important;\"> Last 5 Add Fund</th>\r\n                    </tr>\r\n                    ";
    $q = dquery("select *,(select username from tblUsers where tblUsers.id=tbl_statement_user.uid) as user,(select\r\ncode from tbl_currencies where tbl_currencies.id=(select default_currency \r\nfrom tblUsers where id=uid)) as code from tbl_statement_user where description like '%Add Fund%' order by id desc limit 5 ");
    while ($r = mysqli_fetch_assoc($q)) {
        echo "                        <tr>\r\n                            <td>";
        echo $r["date"];
        echo "</td>\r\n                            <td>";
        echo $r["user"];
        echo "</td>\r\n                            <td>";
        echo $r["amount"] . " " . $r["code"];
        echo "</td>\r\n                        </tr>            ";
    }
    echo "                </table>\r\n            </div>\r\n\r\n        </div>\r\n        <div style=\"display: flex;margin-top:20px\">\r\n            <div  style=\"width:98%;margin-left:auto\">\r\n\r\n                <table  class=\"order-table\" id=\"main_tbl\">\r\n                    <tr>\r\n                        <th colspan=\"7\" style=\"text-align: left !important;\"> Last 10 Transaction</th>\r\n                    </tr>\r\n                    ";
    $q = dquery("select  *,from_unixtime(`time`,'%h:%i %p') as times,(select `value` from tbl_paymentgateways where setting='name'and tblWalletTransaction.gateway=tbl_paymentgateways.gateway) as gat,(select username from tblUsers where id=merchantid) as merchant,(select email from tblUsers where id=userid) as payer from tblWalletTransaction WHERE status='paid' order by transid desc limit 10");
    while ($r = mysqli_fetch_assoc($q)) {
        echo "                        <tr>\r\n                            <td>B_";
        echo $r["transid"];
        echo "</td>\r\n                            <td>";
        echo $r["date"];
        echo "</td>\r\n                            <td>";
        echo $r["times"];
        echo "</td>\r\n                            <td>";
        echo $r["gat"];
        echo "</td>\r\n                            <td>";
        echo $r["transactionid"];
        echo "</td>\r\n                            <td>";
        echo $r["merchant"];
        echo "</td>\r\n                            <td>";
        echo $r["payer"];
        echo "</td>\r\n                        </tr>            ";
    }
    echo "                </table>\r\n            </div>\r\n\r\n\r\n        </div>\r\n\r\n        ";
}
echo "\r\n    <div style=\"margin: 40px 0;\">\r\n        <div class=\"dcircle\">\r\n            ";
if (!$onlymerchant) {
    $table = ["tbl_order_imei", "tbl_order_file", "tbl_order_server", "tbl_order_product", "tbl_order_remote"];
    $defaultprogress = 3;
    $today = date("Y-m-d", time());
    $yesterday = date("Y-m-d", time() - 86400);
    $month = date("m", time());
    $pmonth = date("m", mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
    $year = date("Y", time());
    $pyear = date("Y") - 1;
    $startTime = mktime(0, 0, 0, date("m"), 1, date("Y"));
    $startYear = mktime(0, 0, 0, 1, 1, date("Y"));
    $condition = ["totalorder" => "(1=1) ", "totalnew" => " user_can_c=0", "totalaccepted" => " user_can_c=1", "todaystotal" => "date='" . $today . "'", "todaysnew" => " date='" . $today . "' and user_can_c=0", "todaysaccepted" => " date='" . $today . "' and user_can_c=1", "todaysrejected" => " date='" . $today . "' and user_can_c=3", "todayscompleted" => " reply_date='" . $today . "' and (user_can_c=4)", "verify" => "verified=1 and user_can_c=4 ", "yestotal" => " date='" . $yesterday . "'", "yesaccepted" => " date='" . $yesterday . "' and user_can_c=1", "yescompleted" => " reply_date='" . $yesterday . "' and ( user_can_c=4)", "frommonth" => "time>='" . $startTime . "'", "fromyear" => "time>='" . $startYear . "'"];
    foreach ($table as $tbl) {
        $allwhere = "";
        $dtbl = $tbl;
        if ($tbl == "tbl_order_imei") {
            $allwhere = " and `server`='0'  and service_id in (select id from tbl_services_imei where useasserver=0)";
        } else {
            if ($tbl == "tbl_order_server") {
                $dtbl = "tbl_order_imei";
                $allwhere = " and `server`='1'  and service_id in (select id from tbl_services_imei where useasserver=1)";
            } else {
                if ($tbl == "tbl_order_remote") {
                    $dtbl = "tbl_order_imei";
                    $allwhere = " and `server`='2'  and service_id in (select id from tbl_services_imei where useasserver=2)";
                }
            }
        }
        foreach ($condition as $key => $cnd) {
            $ord = mysqli_fetch_assoc(dquery("select count(*) as total from " . $dtbl . " where " . $cnd . " " . $allwhere));
            $order[$tbl][$key] = $ord["total"];
        }
    }
    echo "                <table style=\"text-align: center !important;\" class=\"order-table\">\r\n                    <tr>\r\n                        <td>\r\n                            <div class=\"panel-box\">\r\n                                <div onClick=\"javascript:load_fromsubpage('imeiorder','IMEI Order');\"\r\n                                     class=\"imei order-box\">\r\n                                    <a onClick=\"javascript:load_fromsubpage('imeiorder','IMEI Order');\">\r\n                                        IMEI ORDER\r\n                                    </a>\r\n                                </div>\r\n                                <div class=\"left\"\r\n                                     style=\"width: 50% !important; border-right: 1px solid rgba(255,255,255,0.1); box-sizing: border-box;\">\r\n                                    <a onClick=\"javascript:load_fromsubpage('imeiorder&id=2&laoddefaultpage=imeiquickaccept.php','";
    echo $LNG["imei"];
    echo " ";
    echo $LNG["new"];
    echo "');\">\r\n                                        <h3 style=\"color: #555\">\r\n                                            ";
    echo $order["tbl_order_imei"]["totalnew"];
    echo "                                        </h3>\r\n                                    </a>\r\n                                    <small> New </small>\r\n                                </div>\r\n                                <div class=\"left\" style=\"width: 50% !important;border-left: #eee solid 1px;\">\r\n                                    <a onClick=\"javascript:load_fromsubpage('imeiorder&id=1&laoddefaultpage=quickreply.php&pg=acc','IMEI ";
    echo $LNG["accepted"];
    echo "');\">\r\n                                        <h3 style=\"color: #555\">\r\n                                            ";
    echo $order["tbl_order_imei"]["totalaccepted"];
    echo "                                        </h3>\r\n                                    </a>\r\n                                    <small> Accepted </small>\r\n                                </div>\r\n                                <div class=\"clear\">\r\n                                </div>\r\n                                <ul class=\"requiredtodo\">\r\n                                    ";
    if ($cntverifyapi) {
        echo "                                        <li onClick=\"javascript:load_fromsubpage('imeiapiverify',\r\n 'Verify for APi');\">\r\n                                            <a class=\"left-right\">\r\n\t\t\t\t\t\t\t\t\t<span class=\"num\">\r\n\t\t\t\t\t\t\t\t\t";
        echo $cntverifyapi;
        echo "\t\t\t\t\t\t\t\t\t</span>\r\n                                                <div> APi Verification</div>\r\n                                            </a>\r\n                                        </li>\r\n                                        ";
    }
    echo "                                </ul>\r\n\r\n\r\n                            </div>\r\n\r\n\r\n                        </td>\r\n                        <td>\r\n                            <div class=\"panel-box\">\r\n                                <div onClick=\"javascript:load_fromsubpage('fileorder','File Order');\"\r\n                                     class=\"file order-box\">\r\n                                    <a onClick=\"javascript:load_fromsubpage('fileorder','File Order');\">\r\n                                        FILE ORDER\r\n                                    </a>\r\n                                </div>\r\n                                <div class=\"left\"\r\n                                     style=\"width: 50% !important; border-right: 1px solid rgba(255,255,255,0.1); box-sizing: border-box;\">\r\n                                    <a onClick=\"javascript:load_fromsubpage('fileorder&laoddefaultpage=filequickaccept.php','";
    echo $LNG["file"];
    echo " ";
    echo $LNG["new"];
    echo "');\">\r\n                                        <h3 style=\"color: #555\">\r\n                                            ";
    echo $order["tbl_order_file"]["totalnew"];
    echo "                                        </h3>\r\n                                    </a>\r\n                                    <small> New </small>\r\n                                </div>\r\n                                <div class=\"left\" style=\"width: 50% !important;border-left: #eee solid 1px;\">\r\n                                    <a onClick=\"javascript:load_fromsubpage('fileorder&laoddefaultpage=fileorder.quickreply.php','";
    echo $LNG["file"];
    echo " ";
    echo $LNG["accepted"];
    echo "');\">\r\n                                        <h3 style=\"color: #555\">\r\n                                            ";
    echo $order["tbl_order_file"]["totalaccepted"];
    echo "                                        </h3>\r\n                                    </a>\r\n                                    <small> Accepted </small>\r\n                                </div>\r\n                                <div class=\"clear\">\r\n                                </div>\r\n                                <ul class=\"requiredtodo\">\r\n                                    ";
    if ($vals[2]) {
        echo "                                        <li onClick=\"javascript:load_fromsubpage('fileorder&laoddefaultpage=filequickaccept.php','File Quick Accepted');\">\r\n                                            <a class=\"left-right\">\r\n\t\t\t\t\t\t\t\t\t<span class=\"num\">\r\n\t\t\t\t\t\t\t\t\t";
        echo $vals[2];
        echo "                                    </span>\r\n                                                <div>New Orders</div>\r\n                                            </a>\r\n                                        </li>\r\n                                        ";
    }
    if ($vals[3]) {
        echo "                                        <li onClick=\"javascript:load_fromsubpage('fileorder&laoddefaultpage=fileorder.repllied.php','File Replied');\">\r\n                                            <a class=\"left-right\">\r\n\t\t\t\t\t\t\t\t\t<span class=\"num\">\r\n\t\t\t\t\t\t\t\t\t";
        echo $vals[3];
        echo "                                    </span>\r\n                                                <div>Pending Orders</div>\r\n                                            </a>\r\n                                        </li>\r\n                                        ";
    }
    if ($cntfv) {
        echo "                                        <li onclick=\"javascript:load_fromsubpage('fileorder&laoddefaultpage=fileorder.verification.php','File Verification');\">\r\n                                            <a class=\"left-right\">\r\n\t\t\t\t\t\t\t\t\t<span class=\"num\">\r\n\t\t\t\t\t\t\t\t\t";
        echo $cntfv;
        echo "                                    </span>\r\n                                                <div>Waiting for verification</div>\r\n                                            </a>\r\n                                        </li>\r\n                                        ";
    }
    echo "                                </ul>\r\n                            </div>\r\n\r\n\r\n                        </td>\r\n                        <td>\r\n                            <div class=\"panel-box\">\r\n                                <div onClick=\"javascript:load_fromsubpage('imeiorder&stype=server','Server Order');\"\r\n                                     class=\"server order-box\">\r\n                                    <a onClick=\"javascript:load_fromsubpage('imeiorder&stype=server','Server Order');\">\r\n                                        SERVER ORDER\r\n                                    </a>\r\n                                </div>\r\n                                <div class=\"left\"\r\n                                     style=\"width: 50% !important; border-right: 1px solid rgba(255,255,255,0.1); box-sizing: border-box;\">\r\n                                    <a onClick=\"javascript:load_fromsubpage('imeiorder&id=1&laoddefaultpage=imeiquickaccept.php&stype=server','";
    echo $LNG["server"];
    echo " ";
    echo $LNG["new"];
    echo "');\">\r\n                                        <h3 style=\"color: #555\">\r\n                                            ";
    echo $order["tbl_order_server"]["totalnew"];
    echo "                                        </h3>\r\n                                    </a>\r\n                                    <small> New </small>\r\n                                </div>\r\n                                <div class=\"left\" style=\"width: 50% !important;border-left: #eee solid 1px;\">\r\n                                    <a onClick=\"javascript:load_fromsubpage('imeiorder&laoddefaultpage=quickreply.php&stype=server','";
    echo $LNG["server"];
    echo " ";
    echo $LNG["accepted"];
    echo "');\">\r\n                                        <h3 style=\"color: #555\">\r\n                                            ";
    echo $order["tbl_order_server"]["totalaccepted"];
    echo "                                        </h3>\r\n                                    </a>\r\n                                    <small> Accepted </small>\r\n                                </div>\r\n                                <div class=\"clear\">\r\n                                </div>\r\n                                <ul class=\"requiredtodo\">\r\n                                    ";
    if ($cntverifyapiserver) {
        echo "                                        <li onClick=\"javascript:load_fromsubpage('imeiapiverify&stype=server',\r\n 'Verify for APi');\">\r\n                                            <a class=\"left-right\">\r\n\t\t\t\t\t\t\t\t\t<span class=\"num\">\r\n\t\t\t\t\t\t\t\t\t";
        echo $cntverifyapiserver;
        echo "\t\t\t\t\t\t\t\t\t</span>\r\n                                                <div> APi Verification</div>\r\n                                            </a>\r\n                                        </li>\r\n                                        ";
    }
    if ($vals[4]) {
        echo "                                        <li onClick=\"javascript:load_fromsubpage('serverorder&laoddefaultpage=serverquickaccept.php','Server Quick Accepted');\">\r\n                                            <a class=\"left-right\">\r\n\t\t\t\t\t\t\t\t\t<span class=\"num\">\r\n\t\t\t\t\t\t\t\t\t";
        echo $vals[4];
        echo "                                    </span>\r\n                                                <div>New Orders</div>\r\n                                            </a>\r\n                                        </li>\r\n                                        ";
    }
    if ($vals[5]) {
        echo "                                        <li onClick=\"javascript:load_fromsubpage('serverorder&laoddefaultpage=serverorder.replied.php','Server Replied');\">\r\n                                            <a class=\"left-right\">\r\n\t\t\t\t\t\t\t\t\t<span class=\"num\">\r\n\t\t\t\t\t\t\t\t\t";
        echo $vals[5];
        echo "                                    </span>\r\n                                                <div>Pending Orders</div>\r\n                                            </a>\r\n                                        </li>\r\n                                        ";
    }
    if ($cntsv) {
        echo "                                        <li onclick=\"javascript:load_fromsubpage('imeiorder&laoddefaultpage=imeiorder.verification.php&stype=server','Server Verification');\">\r\n                                            <a class=\"left-right\">\r\n\t\t\t\t\t\t\t\t\t<span class=\"num\">\r\n\t\t\t\t\t\t\t\t\t";
        echo $cntsv;
        echo "                                    </span>\r\n                                                <div>Waiting for verification</div>\r\n                                            </a>\r\n                                        </li>\r\n                                        ";
    }
    if ($cntserverreview && !$OnlyEcommerce) {
        echo "                                        <li onClick=\"javascript:load_fromsubpage('utilities.review&laoddefaultpage=utilities.review_server.php&status=pending','Pending Server service review');\">\r\n                                            <a class=\"left-right\">\r\n\t\t\t\t\t\t\t\t\t<span class=\"num\">\r\n\t\t\t\t\t\t\t\t\t";
        echo $cntserverreview;
        echo "                                    </span>\r\n                                                <div>Service Feedback</div>\r\n                                            </a>\r\n                                        </li>\r\n                                        ";
    }
    if ($cntserverapiorder) {
        echo "                                        <li onClick=\"javascript:load_fromsubpage('imeiorder&laoddefaultpage=imeiorder.history.php&waiting=1&stype=server','Overdrive Client List');\">\r\n                                            <a class=\"left-right\">\r\n\t\t\t\t\t\t\t\t\t<span class=\"num\">\r\n\t\t\t\t\t\t\t\t\t";
        echo $cntserverapiorder;
        echo "                                    </span>\r\n                                                <div>Waiting api reply <span style=\"color:#666\">since 24 hr </span>\r\n                                                </div>\r\n                                            </a>\r\n                                        </li>\r\n                                        ";
    }
    echo "                                </ul>\r\n                            </div>\r\n                        </td>\r\n                        <td>\r\n                            <div class=\"panel-box\" style=\"margin-right: 0;\">\r\n                                <div onClick=\"javascript:load_fromsubpage('imeiorder&stype=remote','Remote Order');\"\r\n                                     class=\"shop order-box\">\r\n                                    <a onClick=\"javascript:load_fromsubpage('imeiorder&stype=remote','Remote Order');\">\r\n                                        REMOTE ORDER\r\n                                    </a>\r\n                                </div>\r\n                                <div class=\"left\"\r\n                                     style=\"width: 50% !important; border-right: 1px solid rgba(255,255,255,0.1); box-sizing: border-box;\">\r\n                                    <a onClick=\"javascript:load_fromsubpage('imeiorder&stype=remote&laoddefaultpage=imeiquickaccept.php','";
    echo $LNG["remote"];
    echo " ";
    echo $LNG["new"];
    echo "');\">\r\n                                        <h3 style=\"color: #555\">\r\n                                            ";
    echo $order["tbl_order_remote"]["totalnew"];
    echo "                                        </h3>\r\n                                    </a>\r\n                                    <small> New </small>\r\n                                </div>\r\n                                <div class=\"left\" style=\"width: 50% !important;border-left: #eee solid 1px;\">\r\n                                    <a onClick=\"javascript:load_fromsubpage('imeiorder&stype=remote&laoddefaultpage=quickreply.php','";
    echo $LNG["remote"];
    echo " ";
    echo $LNG["accepted"];
    echo "');\">\r\n                                        <h3 style=\"color: #555\">\r\n                                            ";
    echo $order["tbl_order_remote"]["totalaccepted"];
    echo "                                        </h3>\r\n                                    </a>\r\n                                    <small> Accepted </small>\r\n                                </div>\r\n                                <div class=\"clear\">\r\n                                </div>\r\n                                <ul class=\"requiredtodo\">\r\n                                    ";
    if ($vals[8]) {
        echo "                                        <li onClick=\"javascript:load_fromsubpage('imeiorder&stype=remote&loaddefaultpage=imeiorder.new.php&id=1','Remote New');\">\r\n                                            <a class=\"left-right\">\r\n\t\t\t\t\t\t\t\t\t<span class=\"num\">\r\n\t\t\t\t\t\t\t\t\t";
        echo $vals[8];
        echo "                                    </span>\r\n                                                <div>New orders</div>\r\n                                            </a>\r\n                                        </li>\r\n                                        ";
    }
    if ($vals[9]) {
        echo "                                        <li onClick=\"javascript:load_fromsubpage('imeiorder&stype=remote&loaddefaultpage=imeiorder.pending.php','Pending Remote orders');\">\r\n                                            <a class=\"left-right\">\r\n\t\t\t\t\t\t\t\t\t<span class=\"num\">\r\n\t\t\t\t\t\t\t\t\t";
        echo $vals[9];
        echo "                                    </span>\r\n                                                <div>Pending orders</div>\r\n                                            </a>\r\n                                        </li>\r\n                                        ";
    }
    echo "                                </ul>\r\n                            </div>\r\n                        </td>\r\n                        <!--\r\n                    <td>\r\n                        <div class=\"panel-box\" style=\"margin-right: 0;\">\r\n                            <div onClick=\"javascript:load_fromsubpage('productorder','Shop Order');\" class=\"shop order-box\">\r\n                                <a onClick=\"javascript:load_fromsubpage('productorder','Shop Order');\">\r\n                                    SHOP ORDER\r\n                                </a>\r\n                            </div>\r\n                            <div class=\"left\" style=\"width: 50% !important; border-right: 1px solid rgba(255,255,255,0.1); box-sizing: border-box;\">\r\n                                <a onClick=\"javascript:load_fromsubpage('productorder&laoddefaultpage=productorder.new.php','";
    echo $LNG["shop"];
    echo " ";
    echo $LNG["new"];
    echo "');\">\r\n                                    <h3 style=\"color: #555\">\r\n                                        ";
    echo $order["tbl_order_product"]["totalnew"];
    echo "                                    </h3>\r\n                                </a>\r\n                                <small> New </small>\r\n                            </div>\r\n                            <div class=\"left\" style=\"width: 50% !important;\">\r\n                                <a onClick=\"javascript:load_fromsubpage('productorder&laoddefaultpage=productorder.replied.php','";
    echo $LNG["shop"];
    echo " ";
    echo $LNG["accepted"];
    echo "');\">\r\n                                    <h3 style=\"color: #555\">\r\n                                        ";
    echo $order["tbl_order_product"]["totalaccepted"];
    echo "                                    </h3>\r\n                                </a>\r\n                                <small> Accepted </small>\r\n                            </div>\r\n                            <div class=\"clear\">\r\n                            </div>\r\n                            <ul class=\"requiredtodo\">\r\n                                ";
    if ($vals[8]) {
        echo "                                    <li onClick=\"javascript:load_fromsubpage('productorder&loaddefaultpage=productorder.new.php&id=1','Product New');\">\r\n                                        <a  class=\"left-right\">\r\n\t\t\t\t\t\t\t\t\t<span class=\"num\">\r\n\t\t\t\t\t\t\t\t\t";
        echo $vals[8];
        echo "                                    </span>  <div>New orders</div>\r\n                                        </a>\r\n                                    </li>\r\n                                    ";
    }
    if ($vals[9]) {
        echo "                                    <li onClick=\"javascript:load_fromsubpage('productorder&loaddefaultpage=productorder.pending.php','Pending Shop orders');\">\r\n                                        <a  class=\"left-right\">\r\n\t\t\t\t\t\t\t\t\t<span  class=\"num\">\r\n\t\t\t\t\t\t\t\t\t";
        echo $vals[9];
        echo "                                    </span>  <div>Pending orders</div>\r\n                                        </a>\r\n                                    </li>\r\n                                    ";
    }
    echo "                            </ul>\r\n                        </div>\r\n                    </td>\r\n                    -->\r\n                    </tr>\r\n                </table>\r\n                ";
}
echo "        </div>\r\n    </div>\r\n    <script>\r\n        \$(document).ready(function(){\r\n            \$.post('templates/";
echo $_SESSION["admin_template"];
echo "/dashboard.graph.php',function(data, success, textStatus) {\r\n                \$('.graph').html(data);\r\n            });\r\n        })\r\n    </script>\r\n    \r\n\r\n</div>\r\n<style>\r\n    .padding td{padding:5px;border:none;color:#676a6c}\r\n    .bd td{border-bottom:#ddd solid 1px}\r\n    .badge{font-size:14px;color:#808080;padding:5px;display:block;}\r\n    .padding .tb tr:hover td{background: #f4f4f4;}\r\n    .list-title{\r\n        margin-left: 20px;\r\n        color:#ccc;\r\n        font-size: 12px;\r\n    }\r\n    .requiredtodo{\r\n        list-style: none;\r\n        margin-top: 16px;\r\n        background: white;\r\n        margin-bottom: 0;\r\n        border-radius: 0 0 5px 5px;\r\n    }\r\n    .requiredtodo li {\r\n        text-align: left;\r\n        padding: 7px;\r\n        border-top: #eee solid 1px;\r\n    }\r\n    .dark .requiredtodo li {\r\n        border-top: #262a30 solid 1px;\r\n    }\r\n    .requiredtodo li:hover{\r\n        background: #eee;\r\n    }\r\n    .requiredtodo li:hover .num{\r\n        background: transparent;\r\n    }\r\n    .dark .requiredtodo li:hover{\r\n        background: #000;\r\n    }\r\n    .order-table td{\r\n        vertical-align: top;\r\n        width: 25%;\r\n    }\r\n    .num {\r\n        font-size: 14px;\r\n        min-width: 40px;\r\n        text-align: center;\r\n        margin-right: 10px;\r\n    }\r\n    .left-right div{\r\n        font-size: 14px;\r\n    }\r\n</style>\r\n";
$fileverioncheck = "6.1.0";

?>