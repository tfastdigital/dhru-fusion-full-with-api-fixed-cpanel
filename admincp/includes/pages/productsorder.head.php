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
$pendingcnt = mysqli_num_rows(dquery("select id from tbl_invoices where \norderstatus='new' and status='Paid' and retail=1"));
$unshippedcnt = mysqli_num_rows(dquery("select id from tbl_invoices where orderstatus='accepted'\nand retail=1"));
echo "    <style>\n        .w3-badge{background-color:#000;color:#fff;display:inline-block;padding-left:8px;padding-right:8px;text-align:center}.w3-badge{border-radius:50%}\n        .w3-green{color:#fff!important;background-color:#4CAF50!important}\n    </style>\n    <ul id=\"tabmenu\">\n        <li><a  ";
if (!$status || $status == "pendings") {
    echo "class='tabmenu_active'";
}
echo "   onclick=\"getContect('#tab','main2.php?page=productsorder.pending&status=pendings','','','#tabcontent',true,'#main_loader');\" id=\"tab\" ><span class=\"w3-badge w3-green\">";
echo $pendingcnt;
echo "</span> ";
echo $LNG["pending"];
echo "</a>\n        </li>\n        <li><a ";
if ($status == "unshipped") {
    echo "class='tabmenu_active'";
}
echo "  onclick=\"getContect('#tab12','main2.php?page=productsorder.pending&status=unshipped','','','#tabcontent',true,'#main_loader');\" id=\"tab12\" ><span class=\"w3-badge w3-green\">";
echo $unshippedcnt;
echo "</span> ";
echo $LNG["packed"];
echo "</a></li>\n\n        <li><a   ";
if ($status == "all") {
    echo "class='tabmenu_active'";
}
echo "  onclick=\"getContect('#tab4','main2.php?page=productsorder.pending&status=all','','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >";
echo $LNG["all"];
echo " ";
echo $LNG["orders"];
echo "</a></li>\n\n\n        <div style=\"clear: both;\"></div>\n    </ul>  ";
if ($loaddefaultpage) {
    echo "    <div id=\"tabcontent\"> ";
    if ($loaddefaultpage) {
        include $loaddefaultpage;
        $loaddefaultpage = NULL;
    } else {
        include "productsorder.pending.php";
    }
    echo "  </div>\n    ";
    exit;
}
$fileverioncheck = "6.1.0";

?>