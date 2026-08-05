<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
$today = date("Y-m-d", time());
$yesterday = date("Y-m-d", time() - 86400);
$month = date("m", time());
$year = date("Y", time());
$defaultcurrency = mysqli_fetch_assoc(dquery("SELECT id from `tbl_currencies` where `default`='1'"));
if ($OnlyEcommerce) {
    $table = ["tbl_order_product"];
    $jointable = ["tbl_order_product,tbl_products\n  WHERE tbl_products.id=tbl_order_product.service_id"];
} else {
    if ($IsFileOnly) {
        $table = ["tbl_order_file"];
        $jointable = ["tbl_order_file,tbl_services_file WHERE tbl_services_file.id=tbl_order_file.service_id"];
    } else {
        $table = ["tbl_order_imei", "tbl_order_file", "tbl_order_server", "tbl_order_product", "tbl_order_remote"];
        $jointable = ["tbl_order_imei,tbl_services_imei WHERE\n     tbl_services_imei.id=tbl_order_imei.service_id", "tbl_order_file,tbl_services_file WHERE tbl_services_file.id=tbl_order_file.service_id", "tbl_order_server,tbl_server_log WHERE tbl_server_log.id=tbl_order_server.service_id", "tbl_order_product,tbl_products WHERE tbl_products.id=tbl_order_product.service_id", "tbl_order_remote,tbl_services_remote WHERE tbl_services_remote.id=tbl_order_remote.service_id"];
    }
}
foreach ($jointable as $key => $tbl) {
    if ($OnlyEcommerce) {
        $servicetbl = $LNG["shop"];
        $color = "#a4cc8a";
    } else {
        if ($key == 0) {
            $servicetbl = $LNG["imei"];
            $color = "#f0aa65";
        } else {
            if ($key == "1") {
                $servicetbl = $LNG["file"];
                $color = "#c4bfd9";
            } else {
                if ($key == "2") {
                    $servicetbl = $LNG["server"];
                    $color = "#90c0db";
                } else {
                    if ($key == "4") {
                        $servicetbl = $LNG["remote"];
                        $color = "#90c0db";
                    } else {
                        $servicetbl = $LNG["shop"];
                        $color = "#a4cc8a";
                    }
                }
            }
        }
    }
    if ($key == 0) {
        $tbl .= " and tbl_order_imei.server=0";
    } else {
        if ($key == 2) {
            $tbl = str_replace("tbl_order_server", "tbl_order_imei", $tbl);
            $tbl = str_replace("tbl_server_log", "tbl_services_imei", $tbl);
            $tbl .= " and tbl_order_imei.server=1";
        } else {
            if ($key == 4) {
                $tbl = str_replace("tbl_order_remote", "tbl_order_imei", $tbl);
                $tbl = str_replace("tbl_services_remote", "tbl_services_imei", $tbl);
                $tbl .= " and tbl_order_imei.server=2";
            }
        }
    }
    $serviceresult = dquery("SELECT count(service_id) as mtotal,service_id,service_name," . $key . " as \n    tbltype FROM " . $tbl . " and user_can_c='4' and user_id='" . $id . "' group by service_id order by count(service_id) DESC limit 0,10");
    if (mysqli_num_rows($serviceresult)) {
        echo "    <table cellspacing=\"0\" cellpadding=\"4\"  id=\"main_tbl\"  class=\"";
        echo $servicetbl;
        echo "\">\n        <thead>    \n            <tr><th align=\"left\" class=\"std\">";
        echo $servicetbl . " " . $LNG["service"];
        echo " ";
        echo $LNG["name"];
        echo "</th><th style=\"text-align: right;\">";
        echo $LNG["total"];
        echo " ";
        echo $LNG["order"];
        echo "</th><th></th> </tr>\n        </thead>\n        <tbody>\n";
        while ($servicerow = mysqli_fetch_assoc($serviceresult)) {
            echo "<tr><td align='left' class='std'>";
            echo substr($servicerow["service_name"], 0, 50);
            echo "</td>";
            echo "<td align=right><strong>" . $servicerow["mtotal"] . "</strong></td><td></td></tr>";
        }
        echo "</tbody></table>";
    }
}
echo " \n";
$fileverioncheck = "6.1.0";

?>