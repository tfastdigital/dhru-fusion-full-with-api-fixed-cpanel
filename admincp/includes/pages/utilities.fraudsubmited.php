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
echo "  \n<style>\n.form{margin-bottom: 4px !important;}\n</style>\n\n<div id=\"notification\"></div>\n\n<div id=\"content\">\n<div id=\"content_padded\">\n";
if ($submit) {
    $cnt = 0;
    foreach ($ids as $i) {
        $row = mysqli_fetch_assoc(dquery("select data from \n        tbl_fraud where id='" . $i . "'"));
        $post["registeredname"] = $licinfo["registeredname"];
        $post["email"] = $licinfo["email"];
        $post["ipn"] = $row["data"];
        $res = initCurl("http://fraudcage.com/api/submitcase", $post);
        $res = json_decode($res, true);
        if ($res["success"]) {
            $cnt++;
            dquery("update tbl_fraud set status='" . $res["success"]["caseid"] . "'\n           where id='" . $i . "'");
        }
    }
}
if ($cnt) {
    echo "    <div id=\"notification1\" class=\"successbox\">\n    ";
    echo $cnt;
    echo " Case submitted successfully</div>\n    ";
}
echo "\n<form method=\"post\">\n<table id=\"main_tbl\">\n<thead>\n  <tr>\n       \n        <th>";
echo $LNG["invoice"];
echo " </th>\n        <th>";
echo $LNG["client"];
echo "  ";
echo $LNG["name"];
echo "</th>\n        <th>";
echo $LNG["amount"];
echo " </th>\n        <th>Type</th>\n         <th>Case ID</th>\n  </tr>\n</thead>  \n<tbody>  \n";
$bann = dquery("SELECT *,(select concat(first_name,' ',last_name) as name\nfrom tblUsers where id=(select userid from tbl_invoices where \nid=invoiceid)) as client,(select total from tbl_invoices\nwhere id=invoiceid) as amount FROM tbl_fraud\nwhere status!=0");
while ($row = mysqli_fetch_assoc($bann)) {
    echo "        <tr>\n          <td>";
    echo $row["invoiceid"];
    echo "</td>\n        <td>";
    echo $row["client"];
    echo "</td> \n        <td>";
    echo $row["amount"];
    echo " </td>\n        <td>";
    echo $row["amount"];
    echo " </td>\n         <td><a target=\"_blank\" href=\"http://fraudcage.com/viewcase/";
    echo $row["status"];
    echo "\">";
    echo $row["status"];
    echo "</a></td>\n    </tr>\n";
}
echo "</tbody></table>\n</form>\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>