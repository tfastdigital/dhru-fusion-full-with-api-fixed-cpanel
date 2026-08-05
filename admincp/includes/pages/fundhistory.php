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
echo "<div id=\"notification\"></div> \n<div id=\"content\">\n<div id=\"content_padded\">\n\n<form id=\"frmcleanup\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo " <table cellspacing=\"5\"  id=\"main_tbl\">\n<thead>\n<th>";
echo $LNG["user"];
echo "</th>\n<th>";
echo $LNG["amount"];
echo "</th>\n<th>";
echo $LNG["date"];
echo "</th>\n<th>";
echo $LNG["invoicestransid"];
echo "</th>\n</thead>\n<tbody>                        \n";
$result = dquery("SELECT tid,date,amount,(select username from tblUsers where id=uid) as user,\n(SELECT `code` FROM tbl_currencies WHERE tbl_currencies.id=(select default_currency from tblUsers where id='" . $id . "')) as code\n FROM  `tbl_store_fund_history` where sid='" . $id . "'");
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>\n        <td>" . $row["user"] . "</td>\n        <td>" . $row["amount"] . " " . $row["code"] . "</td>\n        <td>" . $row["date"] . "</td>\n        <td>" . $row["tid"] . "</td>\n        </tr>";
    }
}
echo "</tbody></table>\n</form></div></div> ";
$fileverioncheck = "6.1.0";

?>