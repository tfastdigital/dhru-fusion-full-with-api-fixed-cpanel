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
$pendingcnt = mysqli_num_rows(dquery("select order_id from tbl_order_product \nwhere user_can_c='0'"));
$unshippedcnt = mysqli_num_rows(dquery("select order_id from tbl_order_product\n where user_can_c='1'"));
echo "<style>\n    .w3-badge{background-color:#000;color:#fff;display:inline-block;padding-left:8px;padding-right:8px;text-align:center}.w3-badge{border-radius:50%}\n    .w3-green{color:#fff!important;background-color:#4CAF50!important}\n</style>\n    <ul id=\"tabmenu\">\n<li><a  ";
if (($page == "productorder" || $page == "productorder.new") && $loaddefaultpage != "productorder.pending.php" && $loaddefaultpage != "productorder.replied.php" && $laoddefaultpage != "productorder.return.php" && $laoddefaultpage != "productorder.pending.php" && $laoddefaultpage != "productorder.replied.php") {
    echo "class='tabmenu_active'";
}
echo "  onclick=\"getContect('#tab','main2.php?page=productorder.history&status=pendings','','','#tabcontent',true,'#main_loader');\" id=\"tab\" ><span class=\"w3-badge w3-green\">";
echo $pendingcnt;
echo "</span> ";
echo $LNG["pending"];
echo "</a>\n</li> \n\n<li><a ";
if ($loaddefaultpage == "productorder.replied.php" || $laoddefaultpage == "productorder.replied.php") {
    echo "class='tabmenu_active'";
}
echo "  onclick=\"getContect('#tab12','main2.php?page=productorder.replied','','','#tabcontent',true,'#main_loader');\" id=\"tab12\" ><span class=\"w3-badge w3-green\">";
echo $unshippedcnt;
echo "</span> ";
echo $LNG["unshipped"];
echo "</a></li>\n <!--\n<li><a ";
if ($loaddefaultpage == "productorder.pending" || $loaddefaultpage == "productorder.pending.php" || $page == "productorder.pending" || $laoddefaultpage == "productorder.pending.php") {
    echo "class='tabmenu_active'";
}
echo "  onclick=\"getContect('#tab5','main2.php?page=productorder.pending','','','#tabcontent',true,'#main_loader');\" id=\"tab5\" >";
echo $LNG["unpaid"];
echo "</a></li>\n<li><a ";
if ($loaddefaultpage == "productorder.return" || $loaddefaultpage == "productorder.return.php" || $page == "productorder.return" || $laoddefaultpage == "productorder.return.php") {
    echo "class='tabmenu_active'";
}
echo "  onclick=\"getContect('#tab6','main2.php?page=productorder.return','','','#tabcontent',true,'#main_loader');\" id=\"tab6\" >";
echo $LNG["returns"];
echo "</a></li>\n-->\n<li><a ";
if ($loaddefaultpage == "productorder.history" || $loaddefaultpage == "productorder.history.php" || $page == "productorder.history" || $laoddefaultpage == "productorder.history.php") {
    echo "class='tabmenu_active'";
}
echo "  onclick=\"getContect('#tab4','main2.php?page=productorder.history','','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >";
echo $LNG["all"];
echo " ";
echo $LNG["orders"];
echo "</a></li>\n        <!--\n<li><a ";
if ($loaddefaultpage == "productdraw" || $loaddefaultpage == "productdraw.php") {
    echo "class='tabmenu_active'";
}
echo "  onclick=\"getContect('#tab8','main2.php?page=productdraw','','','#tabcontent',true,'#main_loader');\" id=\"tab8\" >";
echo $LNG["lucky"];
echo " ";
echo $LNG["draw"];
echo "  ";
echo $LNG["order"];
echo "</a></li>\n-->\n  \n<div style=\"clear: both;\"></div> \n</ul>  ";
if ($loaddefaultpage) {
    echo "    <div id=\"tabcontent\"> ";
    if ($loaddefaultpage) {
        include $loaddefaultpage;
        $loaddefaultpage = NULL;
    } else {
        include "productorder.new.php";
    }
    echo "  </div>\n    ";
    exit;
}
$fileverioncheck = "6.1.0";

?>