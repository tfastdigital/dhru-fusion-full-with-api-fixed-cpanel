<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 292;
checkPagePermission($pageid);
error_reporting(0);
include ROOTDIR . "/includes/clients.fun.inc.php";
echo "<ul id=\"tabmenu\">\n    <li><a class=\"tabmenu_active\" href=\"#\">Top User by Income</a></li>\n</ul>\n<div id=\"content\">\n<div id=\"content_padded\">\n<div id=\"accountinfo1\" class=\"groupstabes\" >\n \n";
$sql = dquery("select * from tbl_currencies");
while ($row = mysqli_fetch_assoc($sql)) {
    $u = dquery("SELECT userid,\nCONCAT( '<a class=\\'default_dg_a\\' href=\"javascript:load_fromsubpage(\\'edituser&id=',tblUsers.id,'\\',\\'',username,'\\')\">',username,'</a>' ) as user,\n\n(SELECT ac_create_dt FROM tblUsers WHERE id=userid ) as reg\n,\n(select prefix from tbl_currencies where tbl_currencies.id=(select default_currency from tblUsers where tblUsers.id=userid)) as pre\n,\n( SELECT sum( total ) FROM tbl_invoices AS s WHERE s.userid = f.userid and status='Paid' ) AS tot\n\n\n FROM tbl_invoices AS f  LEFT OUTER JOIN tblUsers ON f.userid = tblUsers.id WHERE \nSTATUS = 'Paid' and default_currency='" . $row["id"] . "'\nGROUP BY userid order by tot desc\nLIMIT 0 , 5");
    echo " <div style=\"float: left;margin-right:50px;width:300px;\">    \n    <table id=\"main_tbl\">\n    <thead><tr><th>";
    echo $row["code"];
    echo "</th><th></th></tr></thead>\n    <tbody>\n    ";
    while ($user = mysqli_fetch_assoc($u)) {
        echo "                \n        <tr> <td>";
        echo $user["user"];
        echo "</td><td>";
        echo $user["pre"];
        echo " ";
        echo $user["tot"];
        echo "</td> </tr>\n    ";
    }
    echo "                    \n                </tbody>\n    </table> \n    \n   </div> \n";
}
echo "</div>\n</div></div> ";
$fileverioncheck = "6.1.0";

?>