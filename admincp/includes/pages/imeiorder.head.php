<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n    .badger{\n        width: 16px;\n        height: 16px;\n        background-color:red;\n        color:white;\n        float: left;\n        text-align: center;\n        border-radius: 5px 5px;\n        font-size: 12px;\n    }\n</style>\n<style>\n    .tooltipcolor{\n        color:orange;\n        position:relative\n    }\n    .tooltip {\n        position: relative;\n        display: inline-block;\n    }\n    .tooltip .tooltiptext {\n        visibility: hidden;\n        width: 420px;\n        background-color: black;\n        color: #fff;\n        text-align: center;\n        border-radius: 6px;\n        padding: 5px 0;\n        position: absolute;\n        z-index: 1;\n    }\n    .tooltip:hover .tooltiptext {\n        visibility: visible;\n    }\n</style>\n<ul id=\"tabmenu\">\n";
if (!$mobilebrowser) {
    echo "<li><a id=\"tab34\" ";
    if ($pg == "new") {
        echo "class='tabmenu_active'";
    }
    echo " onclick=\"javascript:void(0)\">\n    <strong>";
    echo $LNG["new"];
    echo " ";
    echo $LNG["order"];
    echo "</strong></a>\n    <ul style=\"padding-left: 10px;\">\n        <li><a\n        href=\"main2.php?page=imeiorder&laoddefaultpage=imeiapiverify.php&pg=new&stype=";
    echo $stype;
    echo "\"  >Verify for API</a></li>\n        <li><a   href=\"main2.php?page=imeiorder&laoddefaultpage=imeiquickaccept.php&pg=new&stype=";
    echo $stype;
    echo "\" id=\"tab33\" >";
    echo $LNG["quickaccept"];
    echo "</a></li>\n        <li><a   href=\"main2.php?page=imeiorder&laoddefaultpage=imeiorder.new.php&pg=new&stype=";
    echo $stype;
    echo "\" id=\"tab\" >";
    echo $LNG["manualaccept"];
    echo "</a></li>\n    </ul>\n</li>\n\n<li><a id=\"tab34\" ";
    if ($pg == "acc") {
        echo "class='tabmenu_active'";
    }
    echo "  onclick=\"javascript:void(0)\">\n    <strong>";
    echo $LNG["accepted"];
    echo " ";
    echo $LNG["order"];
    echo "</strong></a>\n    <ul style=\"padding-left: 10px;\">\n    <li><a  href=\"main2.php?page=imeiorder&laoddefaultpage=quickreply.php&pg=acc&stype=";
    echo $stype;
    echo "\" >";
    echo $LNG["quickreply"];
    echo "</a></li>\n    <li><a  href=\"main2.php?page=imeiorder&laoddefaultpage=imeiorder.replied.php&pg=acc&stype=";
    echo $stype;
    echo "\" >";
    echo $LNG["manualreply"];
    echo "</a></li>\n    ";
    if ($stype != "server") {
        echo "    <li><a href=\"main2.php?page=imeiorder&laoddefaultpage=imeiorder.bulk.php&pg=acc&stype=";
        echo $stype;
        echo "\" >";
        echo $LNG["bulkreply"];
        echo "</a></li>\n    ";
    }
    echo "   </ul>\n</li>\n    ";
    if ($stype == "remote") {
        $rcnt = mysqli_fetch_assoc(dquery("select count(order_id) as cnt from\n        tbl_order_imei where user_can_c='8' and `server`=2"));
    } else {
        if ($stype == "server") {
            $rcnt = mysqli_fetch_assoc(dquery("select count(order_id) as cnt from\n        tbl_order_imei where user_can_c='8' and `server`=1"));
        } else {
            $rcnt = mysqli_fetch_assoc(dquery("select count(order_id) as cnt from\n        tbl_order_imei where user_can_c='8' and `server`=0"));
        }
    }
    echo "\n<li>\n    <a href=\"main2.php?page=imeiorder&laoddefaultpage=imeiorder.rejectedverify.php&stype=";
    echo $stype;
    echo "\" id=\"tab55\">\n        ";
    if ($rcnt["cnt"]) {
        echo "            <span class=\"badger\" style=\"position: absolute;right: 0;top: 0;border-radius: 20px;\"> ";
        echo $rcnt["cnt"];
        echo "</span>\n        ";
    }
    echo $LNG["rejected"];
    echo " ";
    echo $LNG["verification"];
    echo " (APi)</a>\n</li>\n\n<li><a ";
    if ($laoddefaultpage == "imeiorder.verification.php") {
        echo "class='tabmenu_active'";
    }
    echo "href=\"main2.php?page=imeiorder&laoddefaultpage=imeiorder.verification.php&stype=";
    echo $stype;
    echo "\"  id=\"tab3\" >";
    echo $LNG["verificationorder"];
    echo "</a></li>\n<li><a id=\"tab9\" ";
    if ($pg == "hst") {
        echo "class='tabmenu_active'";
    }
    echo "  onclick=\"javascript:void(0)\"><strong>";
    echo $LNG["orderhistory"];
    echo " </strong></a>\n    <ul style=\"padding-left: 10px;\">\n        <li><a  href=\"main2.php?page=imeiorder&laoddefaultpage=imeiorder.history.php&pg=hst&year=";
    echo date("Y");
    echo "&stype=";
    echo $stype;
    echo "\">";
    echo date("Y");
    echo " (Current Year)</a></li>\n        <li><a  href=\"main2.php?page=imeiorder&laoddefaultpage=imeiorder.history.php&pg=hst&year=";
    echo date("Y") - 1;
    echo "&stype=";
    echo $stype;
    echo "\">";
    echo date("Y") - 1;
    echo "</a></li>\n        <li><a  href=\"main2.php?page=imeiorder&laoddefaultpage=imeiorder.history.php&pg=hst&year=";
    echo date("Y") - 2;
    echo "&stype=";
    echo $stype;
    echo "\">";
    echo date("Y") - 2;
    echo "</a></li>\n        <li><a  href=\"main2.php?page=imeiorder&laoddefaultpage=imeiorder.history.php&pg=hst&year=";
    echo date("Y") - 3;
    echo "&stype=";
    echo $stype;
    echo "\">";
    echo date("Y") - 3;
    echo "</a></li>\n        <li><a  href=\"main2.php?page=imeiorder&laoddefaultpage=imeiorder.history.php&pg=hst&year=";
    echo date("Y") - 4;
    echo "&stype=";
    echo $stype;
    echo "\">";
    echo date("Y") - 4;
    echo "</a></li>\n        <li><a  href=\"main2.php?page=imeiorder&laoddefaultpage=imeiorder.history.php&pg=hst&archive=1&stype=";
    echo $stype;
    echo "\">";
    echo $LNG["archive"];
    echo " ";
    echo $LNG["order"];
    echo "</a></li>\n    </ul>\n</li>\n\n<li><a ";
    if ($laoddefaultpage == "imeiorder.pending.php") {
        echo "class=tabmenu_active";
    }
    echo "href=\"main2.php?page=imeiorder&laoddefaultpage=imeiorder.pending.php&pg=new&stype=";
    echo $stype;
    echo "\" id=\"tab5\" >";
    echo $LNG["pending"];
    echo " ";
    echo $LNG["payment"];
    echo "</a></li>\n";
} else {
    echo "<li><a href=\"main2.php?page=imeiorder&laoddefaultpage=imeiapiverify.php&pg=new&stype=";
    echo $stype;
    echo "\" id=\"tab34\" >Verify for API</a></li>\n<li><a href=\"main2.php?page=imeiorder&laoddefaultpage=imeiquickaccept.php&pg=new&stype=";
    echo $stype;
    echo "\" id=\"tab33\" >";
    echo $LNG["quickaccept"];
    echo "</a></li>\n<li><a href=\"main2.php?page=imeiorder&laoddefaultpage=imeiorder.new.php&pg=new&stype=";
    echo $stype;
    echo "\" id=\"tab\" >";
    echo $LNG["manualaccept"];
    echo "</a></li>\n<li><a href=\"main2.php?page=imeiorder&laoddefaultpage=quickreply.php&pg=acc&stype=";
    echo $stype;
    echo "\"  id=\"tab111\" >";
    echo $LNG["quickreply"];
    echo "</a></li>\n<li><a href=\"main2.php?page=imeiorder&laoddefaultpage=imeiorder.replied.php&pg=acc&stype=";
    echo $stype;
    echo "\"  id=\"tab112\" >";
    echo $LNG["manualreply"];
    echo "</a></li>\n<li><a href=\"main2.php?page=imeiorder&laoddefaultpage=imeiorder.bulk.php&pg=acc&stype=";
    echo $stype;
    echo "\"  id=\"tab113\" >";
    echo $LNG["bulkreply"];
    echo "</a></li>\n\n    <li>\n        <a href=\"main2.php?page=imeiorder&laoddefaultpage=imeiorder.rejectedverify.php&stype=";
    echo $stype;
    echo "\" id=\"tab55\">\n            ";
    if ($rcnt["cnt"]) {
        echo "                <span class=\"badger\" style=\"position: absolute;right: 0;top: 0;border-radius: 20px;\"> ";
        echo $rcnt["cnt"];
        echo "</span>\n            ";
    }
    echo $LNG["rejected"];
    echo " ";
    echo $LNG["verification"];
    echo " (APi)</a>\n    </li>\n\n<li><a href=\"main2.php?page=imeiorder&laoddefaultpage=imeiorder.verification.php&stype=";
    echo $stype;
    echo "\"  id=\"tab114\" >";
    echo $LNG["verificationorder"];
    echo "</a></li>\n<li><a href=\"main2.php?page=imeiorder&laoddefaultpage=imeiorder.history.php&pg=hst&stype=";
    echo $stype;
    echo "&year=";
    echo date("Y");
    echo "\"  id=\"tab115\" >";
    echo date("Y");
    echo " (Current Year)</a></li>\n<li><a href=\"main2.php?page=imeiorder&laoddefaultpage=imeiorder.history.php&pg=hst&stype=";
    echo $stype;
    echo "&year=";
    echo date("Y") - 1;
    echo "\"  id=\"tab116\" >";
    echo date("Y") - 1;
    echo "</a></li>\n<li><a href=\"main2.php?page=imeiorder&laoddefaultpage=imeiorder.history.php&pg=hst&stype=";
    echo $stype;
    echo "&year=";
    echo date("Y") - 2;
    echo "\"  id=\"tab117\" >";
    echo date("Y") - 2;
    echo "</a></li>\n<li><a href=\"main2.php?page=imeiorder&laoddefaultpage=imeiorder.history.php&pg=hst&stype=";
    echo $stype;
    echo "&year=";
    echo date("Y") - 3;
    echo "\"  id=\"tab118\" >";
    echo date("Y") - 3;
    echo "</a></li>\n<li><a href=\"main2.php?page=imeiorder&laoddefaultpage=imeiorder.history.php&pg=hst&stype=";
    echo $stype;
    echo "&year=";
    echo date("Y") - 4;
    echo "\"  id=\"tab119\" >";
    echo date("Y") - 4;
    echo "</a></li>\n<li><a href=\"main2.php?page=imeiorder&laoddefaultpage=imeiorder.pending.php&pg=new&stype=";
    echo $stype;
    echo "\" id=\"tab5\" >";
    echo $LNG["pending"];
    echo " ";
    echo $LNG["payment"];
    echo "</a></li>\n";
}
echo "<div style=\"clear: both;\"></div>\n</ul>";
if (isset($_SESSION["once_accepted"]) && $loaddefaultpage) {
    echo "    <div id=\"tabcontent\"> ";
    if ($loaddefaultpage) {
        include $loaddefaultpage;
        $loaddefaultpage = NULL;
    } else {
        include "imeiquickaccept.php";
    }
    echo "  </div>\n    ";
    exit;
}
$fileverioncheck = "6.1.0";

?>