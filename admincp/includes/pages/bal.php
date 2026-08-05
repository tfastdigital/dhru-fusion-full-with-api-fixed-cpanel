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
if (!$year) {
    $year = 2015;
}
if ($uid) {
    $fund = 0;
    $user = mysqli_fetch_assoc(dquery("select * from tblUsers\n    where id='" . $uid . "'"));
    $sa = dquery("select * from tbl_statement_user \n    where ( description like '%Add Fund%' \n    or description like '%Credit Added%'\n    ) and uid='" . $uid . "' ");
    while ($rs = mysqli_fetch_assoc($sa)) {
        $fund += $rs["amount"];
    }
    $cost = 0;
    $completed = 0;
    $pending = 0;
    $sa = dquery("select credit,discount from tbl_order_imei\n    where user_id='" . $uid . "' and ( user_can_c=0 or user_can_c=1)");
    while ($rs = mysqli_fetch_assoc($sa)) {
        $pending += $rs["credit"] - $rs["discount"];
    }
    $sa = dquery("select credit,discount from tbl_order_file\n    where user_id='" . $uid . "' and ( user_can_c=0 or user_can_c=1)");
    while ($rs = mysqli_fetch_assoc($sa)) {
        $pending += $rs["credit"] - $rs["discount"];
    }
    $sa = dquery("select credit,discount from tbl_order_server\n    where user_id='" . $uid . "' and ( user_can_c=0 or user_can_c=1)");
    while ($rs = mysqli_fetch_assoc($sa)) {
        $pending += $rs["credit"] - $rs["discount"];
    }
    $sa = dquery("select credit,discount from tbl_order_product\n    where user_id='" . $uid . "' and ( user_can_c=0 or user_can_c=1)");
    while ($rs = mysqli_fetch_assoc($sa)) {
        $pending += $rs["credit"] - $rs["discount"];
    }
    $sa = dquery("select sum(credit) as credits,sum(discount) as discounts\n    from tbl_order_imei where user_id='" . $uid . "' and user_can_c=4");
    while ($rs = mysqli_fetch_assoc($sa)) {
        $cost += $rs["credits"] - $rs["discounts"];
        $completed += $rs["credits"] - $rs["discounts"];
    }
    $sa = dquery("select credit,discount from tbl_order_file\n    where user_id='" . $uid . "' and user_can_c=4\n    ");
    while ($rs = mysqli_fetch_assoc($sa)) {
        $cost += $rs["credit"] - $rs["discount"];
        $completed += $rs["credit"] - $rs["discount"];
    }
    $sa = dquery("select credit,discount from tbl_order_server\n    where user_id='" . $uid . "' and user_can_c=4");
    while ($rs = mysqli_fetch_assoc($sa)) {
        $cost += $rs["credit"] - $rs["discount"];
        $completed += $rs["credit"] - $rs["discount"];
    }
    $sa = dquery("select credit,discount from tbl_order_product\n    where user_id='" . $uid . "' and user_can_c=4");
    while ($rs = mysqli_fetch_assoc($sa)) {
        $cost += $rs["credit"] - $rs["discount"];
        $completed += $rs["credit"] - $rs["discount"];
    }
    $sa = dquery("select * from tbl_statement_user \n    where  description like '%Credit Transfer to%' uid='" . $uid . "'");
    while ($rs = mysqli_fetch_assoc($sa)) {
        $cost += $rs["amount"];
    }
    $sa = dquery("select * from tbl_statement_user \n    where  description like '%Credit Apply to Invoice%' uid='" . $uid . "'");
    while ($rs = mysqli_fetch_assoc($sa)) {
        $cost += $rs["amount"];
    }
}
echo "FUND : " . $fund;
echo "<table border=\"1\" style=\"width: 50%;\">\n    <tr>\n        <td>Completed Order</td>\n        <td align='right'>";
echo $completed;
echo "</td>\n    </tr>\n    <tr>\n        <td>Pending Order</td>\n        <td align='right'>";
echo $pending;
echo "</td>\n    </tr>\n    <tr>\n        <td>Credit Left</td>\n        <td align='right'>";
echo $user["credit_left"];
echo "</td>\n    </tr>\n     <tr>\n        <td>Total</td>\n        <td align='right'><strong>";
echo $paid = $completed + $pending + $user["credit_left"];
echo "</strong></td>\n    </tr>\n       <tr>\n        <td>Total Fund</td>\n        <td align='right'><strong>";
echo $fund;
echo "</strong></td>\n    </tr>\n    ";
if (0 < $paid - $fund) {
    echo "       <tr>\n        <td>Order Rejected Twice</td>\n        <td align='right'><strong>";
    echo $paid - $fund;
    echo "</strong></td>\n    </tr>\n    ";
} else {
    echo "     <tr>\n        <td>Order Not Refunded</td>\n        <td align='right'><strong>";
    echo $paid - $fund;
    echo "</strong></td>\n    </tr>\n    ";
}
echo "</table>";
$fileverioncheck = "6.1.0";

?>