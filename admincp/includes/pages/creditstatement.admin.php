<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\r\n<div title=\"userfinance\" id=\"tutid\"></div>\r\n<div id=\"notification\"></div>\r\n<div id=\"content\">\r\n<div id=\"content_padded\">\r\n\r\n<div  class=\"groupstabes\">\r\n    <div class=\"clear\"></div>\r\n    ";
$cq = dquery("select * from tbl_currencies");
while ($rcq = mysqli_fetch_assoc($cq)) {
    $creditadd = mysqli_fetch_assoc(dquery("select sum(amount) as credit\r\n            from tbl_statement_user where adminid='" . $admn . "'\r\n            and description='+ Add Funds' \r\n            and uid in(select id from tblUsers where default_currency='" . $rcq["id"] . "')"));
    $creditrebate = mysqli_fetch_assoc(dquery("select sum(amount) as credit\r\n            from tbl_statement_user where adminid='" . $admn . "'\r\n            and description='Credit Rebated' \r\n            and uid in(select id from tblUsers where default_currency='" . $rcq["id"] . "')"));
    if ($creditadd["credit"] - $creditrebate["credit"] != 0) {
        echo "<span style='font-size:25px; cursor:pointer;margin-right:30px;' class=\"textred\">";
        echo $creditadd["credit"] - $creditrebate["credit"];
        echo " <small style='color:gray'> ";
        echo $rcq["code"];
        echo " </small> </span>\r\n            ";
    }
}
echo "<table id=\"main_tbl\" >\r\n\r\n<thead>\r\n  <tr class='nodrag'>\r\n        <th>";
echo $LNG["date"];
echo "</th>\r\n        <th>";
echo $LNG["description"];
echo " </th>\r\n        <th style=\"text-align:right; \">DR</th>\r\n        <th style=\"text-align: right; \">CR</th>\r\n  </tr>\r\n</thead>\r\n<tbody>\r\n    ";
$add = 0;
$rebate = 0;
$crq = dquery("select date,amount,description,type,(select username from tblUsers\r\n  where id=uid) as user,(select code from tbl_currencies where id=(select default_currency\r\n  from tblUsers where id=uid)) as code \r\n  \r\n  from tbl_statement_user\r\n  where adminid='" . $admn . "' \r\n  and (description='+ Add Funds' or description='Credit Rebated')");
while ($cr = mysqli_fetch_assoc($crq)) {
    echo "    <tr>\r\n        <td>";
    echo $cr["date"];
    echo "</td>\r\n        <td>";
    echo $cr["description"];
    echo " ";
    echo $cr["user"];
    echo "</td>\r\n        <td style=\"text-align: right;\">";
    echo $cr["type"] == "DR" ? $cr["amount"] : 0;
    echo " ";
    echo $cr["code"];
    echo "</td>\r\n        <td style=\"text-align: right;\">";
    echo $cr["type"] == "CR" ? $cr["amount"] : 0;
    echo " ";
    echo $cr["code"];
    echo "</td>\r\n    </tr>\r\n    ";
    if ($cr["type"] == "CR") {
        $add += $cr["amount"];
    } else {
        $rebate += $cr["amount"];
    }
}
echo "</tbody>\r\n\r\n</tfoot>\r\n</table>\r\n\r\n</div>\r\n";
$fileverioncheck = "6.1.0";

?>