<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
include_once DATAGRID_DIR . "comm.php";
$pageid = 426;
checkPagePermission($pageid);
echo "<div id=\"content\">\n<div id=\"notification\"></div>\n<div id=\"content_padded\">\n<form method=\"post\" name=\"frmapi\" id=\"frmapi\">\n<table width=\"50%\" class=\"form\">\n";
$query = "select id,pagetitle from tbl_recent_pages";
$result = dquery($query);
$tr = 3;
while ($row = mysqli_fetch_assoc($result)) {
    $tr--;
    if ($tr == "2") {
        echo "<tr>";
    }
    $listing = mysqli_fetch_assoc(dquery("select listing from tbl_recent_menu where page_id=" . $row["id"] . " and admin_id=" . $_SESSION["adminid"]));
    echo "<td class=\"fieldlabel\">";
    echo $row["pagetitle"];
    echo "</td>\n<td class=\"fieldarea\"><input type=\"text\"  name=\"list[";
    echo $row["id"];
    echo "]\" value=\"";
    echo $listing["listing"];
    echo "\"/></td>\n";
    if ($tr == "0") {
        echo "</tr>";
        $tr = 3;
    }
}
echo "</table>\n<p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnrecentmenu\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnrecentmenu','recentmenu','#frmapi','#notification','true','#main_loader');\"/></p>\n</form>\n</div></div> ";
$fileverioncheck = "6.1.0";

?>