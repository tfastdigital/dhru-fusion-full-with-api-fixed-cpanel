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
$row = mysqli_fetch_assoc(dquery("select username from tbl_supplier where id=" . $id));
echo "    \n <script>  \n    subheader2_txt('[";
echo $LNG["edit"];
echo " : ";
echo $row["username"];
echo "]');\n </script>\n <ul id=\"tabmenu\">\n    <li><a ";
if ($page == "editsupplier" || $page == "editsupplier.overview") {
    echo "class='tabmenu_active'";
}
echo "  onclick=\"getContect('#tab5','main2.php?page=editsupplier.overview','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab5\" >";
echo $LNG["overview"];
echo "</a></li> \n    <li><a onclick=\"getContect('#tab','main2.php?page=editsupplier.account','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["account"];
echo "</a></li> \n    <li><a onclick=\"getContect('#tab1','main2.php?page=editsupplier.profile','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
echo $LNG["profile"];
echo "</a></li> \n    <li><a onclick=\"getContect('#tab11','main2.php?page=editsupplier.loginlog','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab11\" >";
echo $LNG["login"];
echo " ";
echo $LNG["log"];
echo "</a></li> \n   \n  <li> <a id=\"tab2\" href=\"javascript:void(0)\">Allow Serivce</a>\n    <ul style=\"padding: 10px;\">  \n    ";
if (!$OnlyEcommerce) {
    if (!$IsFileOnly) {
        echo "    <li><a onclick=\"getContect('#tab2','main2.php?page=editsupplier.imei','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
        echo $LNG["imei"];
        echo "</a></li>\n        ";
    }
    echo "    <li><a onclick=\"getContect('#tab3','main2.php?page=editsupplier.file','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
    echo $LNG["file"];
    echo "</a></li>\n        ";
    if (!$IsFileOnly) {
        echo "    <li><a onclick=\"getContect('#tab4','main2.php?page=editsupplier.imei&newserver=1','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >";
        echo $LNG["server"];
        echo " (";
        echo $LNG["api"];
        echo " ";
        echo $LNG["support"];
        echo ")</a></li>\n    <li><a onclick=\"getContect('#tab5','main2.php?page=editsupplier.server','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab5\" >";
        echo $LNG["server"];
        echo "</a></li>\n    <li><a onclick=\"getContect('#tab6','main2.php?page=editsupplier.imei&newserver=2','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab6\" >";
        echo $LNG["remote"];
        echo "</a></li>\n\n    ";
    }
    if ($SUPPLIERSP && !$IsFileOnly) {
        echo " <li><a onclick=\"getContect('#tab2','main2.php?page=editsupplier.shop','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab7\" >";
        echo $LNG["shop"];
        echo "</a></li>\n";
    }
}
echo "     \n  </ul>\n  </li> \n     \n\n\n  \n";
if ($SUPPLIERSP && !$IsFileOnly) {
    echo "<li><a onclick=\"getContect('#tab73','main2.php?page=editsupplier.product','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab73\" >";
    echo $row["username"];
    echo "'s ";
    echo $LNG["product"];
    echo "</a></li>\n";
}
echo "    \n <li> <a id=\"tab71\" href=\"javascript:void(0)\">History</a>\n    <ul style=\"padding: 10px;\">  \n        ";
echo $ipage;
if (!$OnlyEcommerce) {
    if (!$IsFileOnly) {
        echo "        <li><a  onclick=\"getContect('#tab71','main2.php?page=editsupplier.imeihistory&id=";
        echo $id;
        echo "','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" >";
        echo $LNG["imeiservice"];
        echo " History</a></li>\n            ";
    }
    echo "        <li><a  onclick=\"getContect('#tab71','main2.php?page=editsupplier.filehistory&id=";
    echo $id;
    echo "','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\"  >";
    echo $LNG["fileservice"];
    echo " History</a></li>\n            ";
    if (!$IsFileOnly) {
        echo "        <li><a  onclick=\"getContect('#tab72','main2.php?page=editsupplier.imeihistory&server=1&id=";
        echo $id;
        echo "','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\"  >";
        echo $LNG["server"];
        echo " ";
        echo $LNG["history"];
        echo " (";
        echo $LNG["api"];
        echo ")</a></li>\n        <li><a  onclick=\"getContect('#tab71','main2.php?page=editsupplier.serverhistory&id=";
        echo $id;
        echo "','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\"  >";
        echo $LNG["serverlogservice"];
        echo " </a></li>\n        <li><a  onclick=\"getContect('#tab75','main2.php?page=editsupplier.imeihistory&server=2&id=";
        echo $id;
        echo "','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\"  >";
        echo $LNG["remote"] . " " . $LNG["service"];
        echo " </a></li>\n        ";
    }
}
if ($SUPPLIERSP && !$IsFileOnly) {
    echo "  <li><a  onclick=\"getContect('#tab71','main2.php?page=editsupplier.shophistory&id=";
    echo $id;
    echo "','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\"  >";
    echo $LNG["shop"];
    echo " History</a></li>\n";
}
echo "  </ul>\n</li>    \n \n  \n    <li><a ";
if ($page == "editsupplier.statement") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab75','main2.php?page=editsupplier.statement&id=";
echo $id;
echo "','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab75\" >";
echo $LNG["statement"];
echo "</a></li>\n";
if ($SUPPLIERSP) {
    echo " <li><a ";
    if ($defaultloadpage == "editsupplier.feedback.php") {
        echo "class='tabmenu_active'";
    }
    echo " \n    onclick=\"getContect('#tab61','main2.php?page=editsupplier.feedback','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab61\" >";
    echo $LNG["product"];
    echo " ";
    echo $LNG["feedback"];
    echo "</a></li>\n";
}
echo "\n<div style=\"clear: both;\"></div>\n</ul>\n  ";
$fileverioncheck = "6.1.0";

?>