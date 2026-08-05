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
licince\chkLitePlus();
licince\chklite();
$whereuf = "";
if ($uid) {
    $whereuf = "&uid=" . $uid;
}
if (!$edit) {
    echo "<ul id=\"tabmenu\">\n\t<li><a\n\t\t";
    if ($id == "4" || $page == "support.ticket" && !$laoddefaultpage) {
        echo "class=tabmenu_active";
    }
    echo "\t\tonclick=\"getContect('#tab2','main2.php?page=support.open";
    echo $whereuf;
    echo "','4','','#tabcontent',true,'#main_loader');\"\n\t\tid=\"tab2\">";
    echo $LNG["waiting"];
    echo " ";
    echo $LNG["ticket"];
    echo "</a></li>\n\t<li><a\n\t\t";
    if ($page == "support.open" && $id == "1") {
        echo "class=tabmenu_active";
    }
    echo "\t\tonclick=\"getContect('#tab1','main2.php?page=support.open";
    echo $whereuf;
    echo "','1','','#tabcontent',true,'#main_loader');\"\n\t\tid=\"tab1\">";
    echo $LNG["open"];
    echo " ";
    echo $LNG["ticket"];
    echo "</a></li>\n\t<li><a ";
    if ($id == "5") {
        echo "class=tabmenu_active";
    }
    echo "\t\tonclick=\"getContect('#tab5','main2.php?page=support.open";
    echo $whereuf;
    echo "','5','','#tabcontent',true,'#main_loader');\"\n\t\tid=\"tab5\">Customer-reply</a></li>\n\t<li><a ";
    if ($id == "3") {
        echo "class=tabmenu_active";
    }
    echo "\t\tonclick=\"getContect('#tab3','main2.php?page=support.open";
    echo $whereuf;
    echo "','3','','#tabcontent',true,'#main_loader');\"\n\t\tid=\"tab3\">";
    echo $LNG["answered"];
    echo " ";
    echo $LNG["ticket"];
    echo "</a></li>\n\t<li><a ";
    if ($id == "2") {
        echo "class=tabmenu_active";
    }
    echo "\t\tonclick=\"getContect('#tab4','main2.php?page=support.open";
    echo $whereuf;
    echo "','2','','#tabcontent',true,'#main_loader');\"\n\t\tid=\"tab4\">";
    echo $LNG["closed"];
    echo " ";
    echo $LNG["ticket"];
    echo "</a></li>\n    ";
    $sql = dquery("select * from tbl_support_status where id>4");
    while ($row = mysqli_fetch_assoc($sql)) {
        echo "    <li><a\n\t\tonclick=\"getContect('#tab";
        echo $row["id"];
        echo "','main2.php?page=support.open";
        echo $whereuf;
        echo "','";
        echo $row["id"];
        echo "','','#tabcontent',true,'#main_loader');\"\n\t\tid=\"tab";
        echo $row["id"];
        echo "\">";
        echo $row["status"];
        echo "</a></li>\n    ";
    }
    echo "     <div style=\"clear: both;\"></div>\n</ul>\n";
}
$fileverioncheck = "6.1.0";

?>