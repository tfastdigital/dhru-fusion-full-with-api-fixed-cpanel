<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
$today = date("Y-m-d", time());
$yesterday = date("Y-m-d", time() - 86400);
$month = date("m", time());
$year = date("Y", time());
$defaultcurrency = mysqli_fetch_assoc(dquery("SELECT id from `tbl_currencies` where `default`='1'"));
if ($IsFileOnly) {
    $table = ["tbl_order_file"];
} else {
    $table = ["tbl_order_imei", "tbl_order_file", "tbl_order_server", "tbl_order_product"];
}
$array = ["date='" . $today . "'", "MONTH(date)='" . $month . "' and YEAR(date)='" . $year . "'", "YEAR(date)='" . $year . "'"];
$jointable = ["tbl_order_product,tbl_products WHERE tbl_products.id=tbl_order_product.service_id"];
$_30days = date("Y-m-d", strtotime(date("Y-m-d", time()) . "-30 day"));
$condition = ["date>='" . $_30days . "' and (user_can_c='4')", "date='" . $yesterday . "'  and (user_can_c='4')", "date='" . $today . "' and (user_can_c='4')"];
foreach ($jointable as $key => $tbl) {
    $servicetbl = $LNG["shop"];
    $color = "#a4cc8a";
    $serviceresult = dquery("SELECT count(service_id) as mtotal,service_id,service_name," . $key . " as tbltype FROM " . $tbl . " and user_can_c='4' group by service_id order by count(service_id) DESC limit 0,10");
    if (mysqli_num_rows($serviceresult)) {
        echo "    <table cellspacing=\"0\" cellpadding=\"4\" id=\"deshbordsub\"  class=\"";
        echo $servicetbl;
        echo "\">\n        <thead>    \n            <tr><th align=\"left\"><strong>";
        echo $servicetbl . " " . $LNG["service"];
        echo " ";
        echo $LNG["name"];
        echo "</strong></th><th align=\"center\" width=\"70px\"><strong>";
        echo $LNG["last"];
        echo " 30 ";
        echo $LNG["days"];
        echo "</strong></th><th align=\"center\" width=\"70px\"><strong>";
        echo $LNG["yesterdays"];
        echo "</strong></th><th align=\"center\" width=\"70px\"><strong>";
        echo $LNG["todays"];
        echo "</strong></th><th align=\"right\" width=\"70px\"><strong>";
        echo $LNG["total"];
        echo " ";
        echo $LNG["order"];
        echo "</strong> </th></tr>\n        </thead>\n        <tbody>\n";
        while ($servicerow = mysqli_fetch_assoc($serviceresult)) {
            echo "<tr><td align='left'>";
            echo substr($servicerow["service_name"], 0, 50);
            echo "</td>";
            foreach ($condition as $c => $cnd) {
                $result = dquery("SELECT count(service_id) as total," . $key . " as tbltype," . $c . " as tblcnd FROM " . $tbl . " and " . $cnd . " and service_id=" . $servicerow["service_id"] . " group by service_id");
                $flag = "true";
                while ($ord = mysqli_fetch_assoc($result)) {
                    $_order1[$ord["tbltype"]][] = $ord;
                    echo "<td align=center>" . $ord["total"] . "</td>";
                    $flag = false;
                }
                if ($flag) {
                    echo "<td align=center><span class=textwhite bold> <strong>0</strong> </span></td>";
                }
            }
            echo "<td align=right><strong>" . $servicerow["mtotal"] . "</strong></td></tr>";
        }
        echo "</tbody></table>";
    }
}
echo " \n";
$fileverioncheck = "6.1.0";

?>