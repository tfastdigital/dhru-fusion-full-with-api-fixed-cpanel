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
echo " \n<div id=\"notification\"></div>\n\n<div id=\"content\">\n<div id=\"content_padded\">\n";
if ($delete) {
    foreach ($ids as $i) {
        dquery("delete from tbl_fraud \n        where id='" . $i . "'");
    }
}
if (!mysqli_num_rows(dquery("select * from tbl_fraud"))) {
    $gl = dquery("select * from tbl_gatewaylog where\n    data like '%unauthorized%' and gateway='paypal'");
    while ($rgl = mysqli_fetch_assoc($gl)) {
        $str = explode("=>", $rgl["data"]);
        foreach ($str as $c => $v) {
            if ($v1) {
                $OUT[end(explode(" ", $v1))] = trim(preg_replace("/\\W\\w+\\s*(\\W*)\$/", "\$1", $v));
            }
            $v1 = trim($v);
        }
        if ($OUT["custom"]) {
            $ipndata = enc(json_encode($OUT), 1523);
            if (!mysqli_num_rows(dquery("select * from tbl_fraud\n         where invoiceid='" . $_OUT["custom"] . "'"))) {
                dquery("insert into tbl_fraud\n             (invoiceid,data) values ('" . $OUT["custom"] . "','" . $ipndata . "')");
            }
        }
    }
}
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
echo "\n<form method=\"post\">\n<table id=\"main_tbl\">\n<thead>\n  <tr>\n        <th></th>\n        <th>";
echo $LNG["invoice"];
echo " </th>\n        <th>";
echo $LNG["client"];
echo "  ";
echo $LNG["name"];
echo "</th>\n        <th>";
echo $LNG["amount"];
echo " </th>\n        <th>Type</th>\n  </tr>\n</thead>  \n<tbody>  \n";
$bann = dquery("SELECT *,(select concat(first_name,' ',last_name) as name\nfrom tblUsers where id=(select userid from tbl_invoices where \nid=invoiceid)) as client,(select total from tbl_invoices\nwhere id=invoiceid) as amount FROM tbl_fraud\nwhere status=0");
while ($row = mysqli_fetch_assoc($bann)) {
    echo "        <tr>\n        <td><input type=\"checkbox\" name=\"ids[";
    echo $row["id"];
    echo "]\" value=\"";
    echo $row["id"];
    echo "\" /></td>\n        <td><a class=\"\" onclick=\"load_subpage('main2.php?page=edituser.editinvoice&id=";
    echo $row["invoiceid"];
    echo "','Edit Invoice [#";
    echo $row["invoiceid"];
    echo "]');\">";
    echo $row["invoiceid"];
    echo "</a></td>\n        <td>";
    echo $row["client"];
    echo "</td> \n        <td>";
    echo $row["amount"];
    echo " </td>\n        <td>Unauthorised</td>\n       \n    </tr>\n";
}
echo "</tbody></table>\n\n<img width=\"38\" height=\"22\" title=\"\" alt=\"With selected\" src=\"includes/3rdparty/datagrid/styles/default/images/arrow_ltr.png\" style=\"padding:0px; margin:0px 0 0 5px; border:0px;\">\n\n<input type=\"submit\" class=\"btn btn-primary\" name=\"submit\"\n value=\"Submit to Fraud Cage\" />\n \n <input type=\"submit\" class=\"btn delete\" name=\"delete\"\n onsubmit=\"return confirm('Are you sure want to Remove?');\"\n value=\"Delete\" />\n\n\n</form>\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>