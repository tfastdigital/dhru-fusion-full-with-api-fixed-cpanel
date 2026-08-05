<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$mobilebrowser) {
    echo "        <link   href=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/x-main2-new.css?v=";
    echo $versioncatch;
    echo "\" rel=\"stylesheet\">\n        ";
}
echo "\n\n";
$urow = mysqli_fetch_assoc(dquery("select username,affiliate,usertype\n     from tblUsers where id='" . $id . "'"));
$query = "SELECT (SELECT sum( total ) FROM `tbl_invoices` WHERE STATUS = 'Paid' AND userid ='" . $id . "') AS paid_total,(SELECT count( * ) FROM `tbl_invoices` WHERE STATUS = 'Paid' AND userid ='" . $id . "') AS paid_rows,\n                (SELECT sum( total ) FROM `tbl_invoices` WHERE STATUS = 'Unpaid' AND userid ='" . $id . "') AS unpaid_total,(SELECT count( * ) FROM `tbl_invoices` WHERE STATUS = 'Unpaid' AND userid ='" . $id . "') AS unpaid_rows,\n                (SELECT sum( total ) FROM `tbl_invoices` WHERE STATUS = 'Cancelled' AND userid ='" . $id . "') AS cancelled_total,(SELECT count( * ) FROM `tbl_invoices` WHERE STATUS = 'Cancelled' AND userid ='" . $id . "') AS cancelled_rows,\n                (SELECT sum( total ) FROM `tbl_invoices` WHERE STATUS = 'Refunded' AND userid ='" . $id . "') AS refunded_total,(SELECT count( * ) FROM `tbl_invoices` WHERE STATUS = 'Refunded' AND userid ='" . $id . "') AS refunded_rows";
$result = dquery($query);
if ($row = mysqli_fetch_assoc($result)) {
    $paid["paid_total"] = $row["paid_total"];
    $tp = mysqli_fetch_assoc(dquery("SELECT sum( amountin ) as tp\n    FROM tbl_transaction WHERE (SELECT STATUS FROM tbl_invoices WHERE id = invoiceid) = 'Unpaid'\n    AND userid = '" . $id . "'"));
    $unpaid["unpaid_total"] = $row["unpaid_total"] - $tp["tp"];
    $paid["paid_rows"] = $row["paid_rows"];
    $unpaid["unpaid_rows"] = $row["unpaid_rows"];
}
$query = "SELECT (SELECT sum( total ) FROM `tbl_invoices` WHERE STATUS = 'Paid' AND userid ='" . $id . "' AND adminid!='') AS paid_total,(SELECT count( * ) FROM `tbl_invoices` WHERE STATUS = 'Paid' AND userid ='" . $id . "' AND adminid!='') AS paid_rows,\n                (SELECT sum( total ) FROM `tbl_invoices` WHERE STATUS = 'Unpaid' AND userid ='" . $id . "' AND adminid!='') AS unpaid_total,(SELECT count( * ) FROM `tbl_invoices` WHERE STATUS = 'Unpaid' AND userid ='" . $id . "' AND adminid!='') AS unpaid_rows";
$result = dquery($query);
if ($row = mysqli_fetch_assoc($result)) {
    $apaid["paid_total"] = $row["paid_total"];
    $totunp = mysqli_fetch_assoc(dquery("select \n    sum(amountin) as paidi from tbl_transaction where invoiceid IN (select id from tbl_invoices \n    WHERE status='Unpaid' AND userid='" . $id . "' and adminid!='')"));
    $aunpaid["unpaid_total"] = $row["unpaid_total"] - $totunp["paidi"];
    $apaid["paid_rows"] = $row["paid_rows"];
    $aunpaid["unpaid_rows"] = $row["unpaid_rows"];
}
if (!$OnlyEcommerce) {
    $query = "SELECT (SELECT count( * ) FROM tbl_order_imei \n    where user_id='" . $id . "' and `server`=0) AS total, \n    (SELECT count( * ) as available FROM tbl_order_imei \n    WHERE user_can_c =4 and user_id='" . $id . "'  and `server`=0) AS available";
    $result = dquery($query);
    if ($row = mysqli_fetch_assoc($result)) {
        $imei["total"] = $row["total"];
        $imei["available"] = $row["available"];
    }
    $query = "SELECT (SELECT count( * ) FROM tbl_order_file where user_id='" . $id . "') AS total,\n     (SELECT count( * ) as available FROM tbl_order_file WHERE user_can_c =4 and user_id='" . $id . "') AS available";
    $result = dquery($query);
    if ($row = mysqli_fetch_assoc($result)) {
        $file["total"] = $row["total"];
        $file["available"] = $row["available"];
    }
    $query = "SELECT (SELECT count(*) FROM tbl_order_imei\n    where user_id='" . $id . "' and `server`=1) AS total, \n    (SELECT count( * ) as available FROM tbl_order_imei\n    WHERE user_can_c =4 and user_id='" . $id . "' and `server`=1) AS available";
    $result = dquery($query);
    if ($row = mysqli_fetch_assoc($result)) {
        $server["total"] = $row["total"];
        $server["available"] = $row["available"];
    }
    $query = "SELECT (SELECT count(*) FROM tbl_order_imei\n    where user_id='" . $id . "' and `server`=2) AS total, \n    (SELECT count( * ) as available FROM tbl_order_imei\n    WHERE user_can_c =4 and user_id='" . $id . "' and `server`=1) AS available";
    $result = dquery($query);
    if ($row = mysqli_fetch_assoc($result)) {
        $remote["total"] = $row["total"];
        $remote["available"] = $row["available"];
    }
    $query = "SELECT (SELECT count(*) FROM tbl_order_product\n    where user_id='" . $id . "') AS total, \n    (SELECT count( * ) as available FROM tbl_order_product\n    WHERE user_can_c =4 and user_id='" . $id . "') AS available";
    $result = dquery($query);
    if ($row = mysqli_fetch_assoc($result)) {
        $other["total"] = $row["total"];
        $other["available"] = $row["available"];
    }
}
echo "    <script>\n        subheader2_txt('[";
echo $LNG["edit"];
echo " : ";
echo $urow["username"];
echo "]');\n    </script>\n    <div title=\"editclient\" id=\"tutid\"></div>\n\n\n<div class=\"sidemenu-bar\">\n\n<div class=\"pt-4 border-bottom pb-3\">\n\n    <div class=\"text-center\">\n\n        ";
$color = ["#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50", "#f1c40f", "#e67e22", "#e74c3c", "#95a5a6", "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d"];
$initial = substr($urow["username"], 0, 2);
$charIndex = ord($initial) - 65;
$colorIndex = $charIndex % 19;
echo "\n        <div class=\"m-auto\" style=\"text-transform: uppercase;font-size: 30px;background:";
echo $color[$colorIndex];
echo ";color:white;border-radius:50%;width:70px;text-align: center;height: 70px;align-items: center;display: flex;justify-content: center;\">\n            ";
echo substr($urow["username"], 0, 2);
echo "        </div>\n\n        <h5 class=\"text-center\"><span> ";
echo $urow["username"];
echo " </span></h5>\n\n    </div>\n</div>\n\n\n    <ul id=\"tabmenu\">\n        <li><a ";
if ($page == "edituser" || $page == "edituser.overview") {
    echo "class='tabmenu_active'";
}
echo "  onclick=\"getContect('#tab','main2.php?page=edituser.overview','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["overview"];
echo "</a></li>\n        <li><a onclick=\"getContect('#tab1','main2.php?page=edituser.accountfinancial','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
echo $LNG["financial"];
echo "</a></li>\n\n        <li><a onclick=\"getContect('#tab2','main2.php?page=edituserprofile&p=personal','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab2\" > ";
echo $LNG["profile"];
echo " </a></li>\n        <li><a onclick=\"getContect('#tab21','main2.php?page=edituserprofile&p=account','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\"  id=\"tab21\" >";
echo $LNG["permission"];
echo "</a></li>\n\n        <li>\n            <a onclick=\"getContect('#tab81','main2.php?page=edituser.invoice&id=";
echo $id;
echo "&proforma=1','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab81\" >";
echo $LNG["proforma"] . " " . $LNG["invoice"];
echo "</a>\n        </li>\n        <li><a onclick=\"getContect('#tab82','main2.php?page=edituser.invoice&id=";
echo $id;
echo "','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab82\" >";
echo $LNG["invoice"];
echo "</a></li>\n\n\n        ";
if (!$OnlyEcommerce) {
    echo "            <li><a onclick=\"getContect('#tab3','main2.php?page=edituser.apisettings','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
    echo $LNG["api"];
    echo "</a></li>\n        ";
}
echo "\n\n        <li><a   onclick=\"getContect('#tab4','main2.php?page=edituser.loginiprange','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >Bind ";
echo $LNG["login"];
echo "</a></li>\n        ";
if ($IsFileOnly) {
    echo "            <li><a onclick=\"getContect('#tab11','main2.php?page=edituser.fileservice','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\">";
    echo $LNG["fileservice"];
    echo "</a></li>\n            ";
}
if (!$OnlyEcommerce && !$IsFileOnly) {
    echo "            <li><a onclick=\"getContect('#tab111','dist/#/clientpricing/";
    echo $id;
    echo "/imei','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader','','','',true);\" id=\"tab111\">";
    echo $LNG["imeiservice"];
    echo " ";
    echo $LNG["pricing"];
    echo " </a></li>\n            <li><a onclick=\"getContect('#tab121','main2.php?page=edituser.fileservice','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab121\">";
    echo $LNG["fileservice"];
    echo " ";
    echo $LNG["pricing"];
    echo " </a></li>\n            <li><a onclick=\"getContect('#tab131','dist/#/clientpricing/";
    echo $id;
    echo "/server','";
    echo $id;
    echo "','1','#tabcontent',true,'#main_loader','','','',true);\" id=\"tab131\">";
    echo $LNG["serverlogservice"];
    echo " ";
    echo $LNG["pricing"];
    echo " </a></li>\n            <li><a onclick=\"getContect('#tab133','dist/#/clientpricing/";
    echo $id;
    echo "/remote','";
    echo $id;
    echo "','1','#tabcontent',true,'#main_loader','','','',true);\" id=\"tab133\">";
    echo $LNG["remote"];
    echo " ";
    echo $LNG["service"];
    echo " ";
    echo $LNG["pricing"];
    echo " </a></li>\n            ";
}
if ($IsFileOnly) {
    echo "            <li><a onclick=\"getContect('#tab121','main2.php?page=edituser.fileorder','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\"  >";
    echo $LNG["file"];
    echo " ";
    echo $LNG["order"];
    echo "</a></li>\n            ";
} else {
    if (!$OnlyEcommerce) {
        echo "                    <li><a onclick=\"getContect('#tab211','main2.php?page=edituser.imeiorder','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab211\">";
        echo $LNG["imei"];
        echo " ";
        echo $LNG["order"];
        echo " <span class=\"badge badge-success\">";
        echo $imei["available"];
        echo "/";
        echo $imei["total"];
        echo "</span> </a></li>\n                    <li><a onclick=\"getContect('#tab221','main2.php?page=edituser.fileorder','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\"  id=\"tab221\">";
        echo $LNG["file"];
        echo " ";
        echo $LNG["order"];
        echo " <span class=\"badge badge-success\">";
        echo $file["available"];
        echo "/";
        echo $file["total"];
        echo "</span> </a></li>\n                    <li><a onclick=\"getContect('#tab231','main2.php?page=edituser.imeiorder&newserver=1','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\"  id=\"tab231\">";
        echo $LNG["server"];
        echo " ";
        echo $LNG["order"];
        echo " <span class=\"badge badge-success\">";
        echo $server["available"];
        echo "/";
        echo $server["total"];
        echo "</span> </a></li>\n                    <li><a onclick=\"getContect('#tab435','main2.php?page=edituser.imeiorder&newserver=2','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\"  id=\"tab435\">";
        echo $LNG["remote"];
        echo " ";
        echo $LNG["order"];
        echo " <span class=\"badge badge-success\">";
        echo $remote["total"];
        echo "</span></a></li>\n                    ";
    }
    echo "        <li><a onclick=\"getContect('#tab121','main2.php?page=edituser.productorder','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\"  id=\"tab129\">";
    echo $LNG["products"];
    echo " <span class=\"badge badge-success\">";
    echo $other["available"];
    echo "/";
    echo $other["total"];
    echo "</span></a></li>\n                ";
}
echo "<!--\n            <li><a onclick=\"getContect('#pos','main2.php?page=pos.device&uid=',\n                        '','','#tabcontent',true,'#main_loader');\"\n                   id=\"pos\">POS Devices</a></li>\n\n            -->\n\n\n\n        \n        \n        <li><a ";
if ($page == "edituser.mailhistory") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab9','main2.php?page=edituser.mailhistory&id=";
echo $id;
echo "','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab9\" >";
echo $LNG["mail"];
echo "</a></li>\n        <li><a ";
if ($page == "edituser.statement") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab13','main2.php?page=edituser.statement&id=";
echo $id;
echo "','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab13\" >";
echo $LNG["statement"];
echo "</a></li>\n        ";
if ($urow["usertype"] == 1) {
    echo "            <li><a ";
    if ($page == "edituser.rstatement") {
        echo "class='tabmenu_active'";
    }
    echo "                        onclick=\"getContect('#tab143','main2.php?page=edituser.rstatement&id=";
    echo $id;
    echo "','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab143\" >";
    echo $LNG["reseller"];
    echo " ";
    echo $LNG["statement"];
    echo "</a></li>\n            ";
}
echo "        <li><a ";
if ($page == "edituser.subscription") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab16','main2.php?page=edituser.subscription','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab16\" >";
echo $LNG["subscription"];
echo "</a></li>\n        ";
if ($urow["affiliate"]) {
    echo "            <li><a onclick=\"getContect('#tab71','main2.php?page=edituser.affiliate&id=";
    echo $id;
    echo "','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab71\" >";
    echo $LNG["affiliate"] . " " . $LNG["history"];
    echo "</a></li>\n            <li><a onclick=\"getContect('#tab72','main2.php?page=edituser.payout&id=";
    echo $id;
    echo "','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab72\" >";
    echo $LNG["affiliate"] . " " . $LNG["payout"];
    echo "</a></li>\n            ";
}
echo "        <li><a ";
if ($page == "edituser.activity") {
    echo "class='tabmenu_active'";
}
echo "                    onclick=\"getContect('#tab166','main2.php?page=edituser.activity','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab166\" >";
echo $LNG["activity"];
echo " ";
echo $LNG["log"];
echo "</a></li>\n        ";
if ($urow["usertype"] == 1) {
    $cnt = mysqli_num_rows(dquery("select id from tblUsers\n    where reseller_id='" . $id . "'"));
    echo "            <li><a\n                        onclick=\"getContect('#tab167','main2.php?page=clientlist&reseller=";
    echo $id;
    echo "',\n                                '";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\"\n                        id=\"tab167\" > ";
    echo $LNG["users"];
    echo " <span class=\"badge badge-success\">";
    echo $cnt;
    echo "</span> </a></li>\n            ";
}
if (!$_SESSION["department"]) {
    $_SESSION["department"] = 0;
}
$tw = mysqli_num_rows(dquery("select * from tbl_support_tickets\nwhere uid='" . $id . "' and (sid='4' or sid='1') AND did IN (" . $_SESSION["department"] . ") \ngroup by tid"));
$to = mysqli_num_rows(dquery("select * from tbl_support_tickets\nwhere uid='" . $id . "' and (sid='1') AND did IN (" . $_SESSION["department"] . ") \ngroup by tid"));
$tr = mysqli_num_rows(dquery("select * from tbl_support_tickets\nwhere uid='" . $id . "' and (sid='5') AND did IN (" . $_SESSION["department"] . ") \ngroup by tid"));
$ta = mysqli_num_rows(dquery("select * from tbl_support_tickets\nwhere uid='" . $id . "' and (sid='3') AND did IN (" . $_SESSION["department"] . ") \ngroup by tid"));
$tc = mysqli_num_rows(dquery("select * from tbl_support_tickets\nwhere uid='" . $id . "' and (sid='2') AND did IN (" . $_SESSION["department"] . ") \ngroup by tid"));
if ($tw || $to || $tr || $ta || $tc) {
    if ($tw) {
        echo "                <li><a onclick=\"getContect('#tabticketw1','main2.php?page=support.open&id=4&uid=";
        echo $id;
        echo "',\n                                    '4','','#tabcontent',true,'#main_loader');\"\n                            id=\"tabticketw1\" >";
        echo $LNG["waiting"];
        echo " ";
        echo $LNG["tickets"];
        echo "  <span class=\"badge badge-success\">";
        echo $tw;
        echo "</span> </a></li>\n                ";
    }
    if ($to) {
        echo "                <li><a onclick=\"getContect('#tabticketw2','main2.php?page=support.open&id=1&uid=";
        echo $id;
        echo "',\n                                    '1','','#tabcontent',true,'#main_loader');\"\n                            id=\"tabticketw2\" >";
        echo $LNG["open"];
        echo " ";
        echo $LNG["tickets"];
        echo "   <span class=\"badge badge-success\">";
        echo $to;
        echo "</span></a></li>\n                ";
    }
    if ($tr) {
        echo "                <li><a  onclick=\"getContect('#tabticketw3','main2.php?page=support.open&id=5&uid=";
        echo $id;
        echo "',\n                                    '5','','#tabcontent',true,'#main_loader');\"\n                            id=\"tabticketw3\" >";
        echo $LNG["customer"];
        echo " ";
        echo $LNG["reply"];
        echo " ";
        echo $LNG["tickets"];
        echo "   <span class=\"badge badge-success\">";
        echo $tr;
        echo "</span></a></li>\n                ";
    }
    if ($ta) {
        echo "                <li><a onclick=\"getContect('#tabticketw4','main2.php?page=support.open&id=3&uid=";
        echo $id;
        echo "',\n                                    '3','','#tabcontent',true,'#main_loader');\"\n                            id=\"tabticketw4\" >";
        echo $LNG["answered"];
        echo " ";
        echo $LNG["tickets"];
        echo "   <span class=\"badge badge-success\">";
        echo $ta;
        echo "</span></a></li>\n                ";
    }
    if ($tc) {
        echo "                <li><a onclick=\"getContect('#tabticketw5','main2.php?page=support.open&id=2&uid=";
        echo $id;
        echo "',\n                                    '2','','#tabcontent',true,'#main_loader');\"\n                            id=\"tabticketw5\" >";
        echo $LNG["closed"];
        echo " ";
        echo $LNG["tickets"];
        echo "   <span class=\"badge badge-success\">";
        echo $tc;
        echo "</span></a></li>\n                ";
    }
}
echo "        <li><a onclick=\"getContect('#emailp','main2.php?page=edituser.emailpreference&uid=";
echo $id;
echo "',\n                    '";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\"\n               id=\"emailp\" >Email Preference</a></li>\n\n        <li><a onclick=\"getContect('#return','main2.php?page=edituser.order.return&uid=";
echo $id;
echo "',\n                    '";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\"\n               id=\"return\" >Return Requested</a></li>\n\n        <li><a onclick=\"getContect('#reward','main2.php?page=edituser.point&uid=";
echo $id;
echo "',\n                    '";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\"\n               id=\"reward\" >";
echo $LNG["reward"];
echo " ";
echo $LNG["points"];
echo "</a></li>\n\n        <li><a onclick=\"getContect('#fundtra','main2.php?page=fundtransferreport&uid=";
echo $id;
echo "',\n                    '";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\"\n               id=\"fundtra\" >";
echo $LNG["fund"];
echo " ";
echo $LNG["transfer"];
echo " ";
echo $LNG["history"];
echo "</a></li>\n\n\n        <li><a onclick=\"getContect('#loginlog','main2.php?page=edituser.log&id=";
echo $id;
echo "',\n                    '";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\"\n               id=\"loginlog\" >";
echo $LNG["login"];
echo "  ";
echo $LNG["log"];
echo "</a></li>\n\n        <li><a onclick=\"getContect('#notes','main2.php?page=edituser.notes&id=";
echo $id;
echo "',\n                    '";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\"\n               id=\"notes\" >";
echo $LNG["notes"];
echo "</a></li>\n\n\n\n    </ul>\n\n</div>\n";
$fileverioncheck = "6.1.0";

?>