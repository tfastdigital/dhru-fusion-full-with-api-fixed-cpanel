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
if (!$servicetype || $filter) {
    echo "    <ul id=\"tabmenu\">\n    <li><a ";
    if (!$servicetype || $servicetype == "imei") {
        echo "class='tabmenu_active'";
    }
    echo " onclick=\"getContect('#tab1','main2.php?page=dashboard.topservice&servicetype=imei&byorder=";
    echo $byorder;
    echo "&todays=";
    echo $todays;
    echo "','','','#tabcontent',true,'#main_loader');\" id=\"tab1\">IMEI</a></li>\n    <li><a ";
    if ($servicetype == "server") {
        echo "class='tabmenu_active'";
    }
    echo " onclick=\"getContect('#tab12','main2.php?page=dashboard.topservice&servicetype=server&byorder=";
    echo $byorder;
    echo "&todays=";
    echo $todays;
    echo "','','','#tabcontent',true,'#main_loader');\"\n             id=\"tab12\">Server</a></li>\n    <div style=\"clear: both;\"></div>\n    </ul>\n    <div id=\"tabcontent\">\n    ";
}
$WHEREST = " `server`=0";
if ($servicetype == "server") {
    $WHEREST = " `server`=1";
}
$today = date("Y-m-d", time());
$yesterday = date("Y-m-d", time() - 86400);
$month = date("m", time());
$year = date("Y", time());
if (!isset($_GET["filter"])) {
    $filter = 30;
}
if ($todays) {
    $_30days = date("Y-m-d");
} else {
    if (!$filter) {
        $date = mysqli_fetch_assoc(dquery("select `date` from tbl_order_imei order by order_id asc limit 1"));
        $_30days = $date["date"];
    } else {
        $_30days = date("Y-m-d", strtotime(date("Y-m-d", time()) . "-" . $filter . " day"));
    }
}
$cnt = 0;
if ($byorder) {
    $serviceresult = dquery("select service_id,count(order_id) as total,\n  (select service_name from tbl_services_imei\n  where id=service_id) as service from tbl_order_imei \n  where user_can_c='4' and " . $WHEREST . " and date>='" . $_30days . "'\n   group by service_id order by total desc limit 10");
} else {
    $serviceresult = dquery("select service_id,sum(credit-discount) as amounts,\n  (select service_name from tbl_services_imei\n  where id=service_id) as service from tbl_order_imei \n  where user_can_c='4' and " . $WHEREST . " and date>='" . $_30days . "'\n   group by service_id order by amounts desc limit 10");
}
if (mysqli_num_rows($serviceresult)) {
    echo "        <script>\n            function filterThis(val){\n                location.href='main2.php?page=dashboard.topservice&filter='+val+'&byorder=";
    echo $byorder;
    echo "&servicetype=";
    echo $servicetype;
    echo "';\n            }\n        </script>\n        <div style=\"float:right\" >\n            <select name=\"range\" onchange=\"filterThis(this.value);\">\n                <option value=\"30\" ";
    if ($filter == 30) {
        echo "selected";
    }
    echo ">1 Month</option>\n                <option value=\"90\" ";
    if ($filter == 90) {
        echo "selected";
    }
    echo ">3 Month</option>\n                <option value=\"180\" ";
    if ($filter == 180) {
        echo "selected";
    }
    echo ">6 Month</option>\n                <option value=\"365\" ";
    if ($filter == 365) {
        echo "selected";
    }
    echo ">1 Year</option>\n                <option value=\"\" ";
    if ($filter == "") {
        echo "selected";
    }
    echo ">All time</option>\n            </select>\n        </div>\n\n        <table cellspacing=\"0\" cellpadding=\"4\" id=\"main_tbl\"  class=\"IMEI\">\n            <thead>\n            <tr>\n                <th align=\"left\">";
    echo $LNG["service"];
    echo " ";
    echo $LNG["name"];
    echo "</th>\n                ";
    if (!$config["litedashboard"]) {
        echo "                    <th>";
        echo $LNG["last"];
        echo " ";
        echo $filter;
        echo " ";
        echo $LNG["days"];
        echo "</th>\n                    <th>";
        echo $LNG["yesterdays"];
        echo "</th>\n                    <th>";
        echo $LNG["todays"];
        echo "</th>\n                    ";
    }
    echo "                <th align=\"right\">";
    echo $LNG["total"];
    echo "                    ";
    if ($byorder) {
        echo $LNG["order"];
    } else {
        echo $LNG["income"];
    }
    echo "</th></tr>\n            </thead>\n\n            <tbody>";
    while ($servicerow = mysqli_fetch_assoc($serviceresult)) {
        $cnt++;
        if (10 >= $cnt) {
            echo "<tr><td align='left'>";
            echo substr($servicerow["service"], 0, 50);
            echo "</td>";
            if (!$config["litedashboard"]) {
                echo "                    <td>";
                $qd = mysqli_fetch_assoc(dquery("select count(order_id) as total from tbl_order_imei \n       where user_can_c='4' and (date between '" . $_30days . "' and '" . $today . "' ) and service_id='" . $servicerow["service_id"] . "'"));
                echo $qd["total"];
                echo "</td>\n                    <td>";
                $qd = mysqli_fetch_assoc(dquery("select count(order_id) as total from tbl_order_imei \n       where user_can_c='4' and (date = '" . $yesterday . "') and service_id='" . $servicerow["service_id"] . "'"));
                echo $qd["total"];
                echo "</td>\n                    <td>\n                        ";
                $qd = mysqli_fetch_assoc(dquery("select count(order_id) as total from tbl_order_imei \n       where user_can_c='4' and date='" . $today . "' and service_id='" . $servicerow["service_id"] . "'"));
                echo $qd["total"];
                echo "                    </td>\n                    ";
            }
            echo "                <td>";
            echo round($servicerow["total"] ? $servicerow["total"] : $servicerow["amounts"], 2);
            echo "</td>\n                </tr>\n                ";
        }
    }
    echo "            </tbody></table>\n        ";
} else {
    echo "<div id='notification1' class='info'>No Order Found</div>";
}
if (!$servicetype && !$filter) {
    echo "        </div>";
}
$fileverioncheck = "6.1.0";

?>