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
include_once ROOTDIR . "/includes/products.fun.php";
include_once ROOTDIR . "/includes/mail.fun.php";
if ($accept) {
    checkDemoMode(false);
    $rs = mysqli_fetch_assoc(dquery("select * from tbl_return_request where id='" . $accept . "'"));
    $OrderDtl = mysqli_fetch_assoc(dquery("select * from tbl_order_product where order_id='" . $rs["oid"] . "'"));
    $reason = $rs["reason"];
    $action = $rs["action"];
    $return_comment = $rs["comment"];
    $returnid = $rs["uid"];
    $return_address = nl2br($config["invoicepayto"]);
    if ($OrderDtl) {
        $service = mysqli_fetch_assoc(dquery("select `service_name`,bundle,`template_id1` \n            from `tbl_products` where `id`='" . $OrderDtl["service_id"] . "'"));
        $email_merge_fields["product"] .= "<br>\r\n" . $service["service_name"] . "<br>\r\n";
        $email_merge_fields["reason"] = $reason == 1 ? "Wrong item ordered" : $reason == 2 ? "Wrong description online" : $reason == 3 ? "Do not like the product" : $reason == 4 ? "Can't get it to work" : $reason == 5 ? "Manufacturer defect or DOA" : $reason == 6 ? "Damaged during shipping" : "Wrong item sent";
        $email_merge_fields["action"] = $action == 1 ? "Send replacement if within warranty" : $action == 2 ? "Repair and ship back" : $action == 3 ? "Give me a credit for future purchase" : "Other";
        $email_merge_fields["comment"] = $return_comment;
        $email_merge_fields["refid"] = $returnid;
        $email_merge_fields["address"] = nl2br($return_address);
    }
    dquery("update tbl_order_product set request='1' where order_id='" . $rs["oid"] . "'");
    dquery("update tbl_return_request set sendbyuid='0' where id='" . $accept . "'");
    sendMail(70, $OrderDtl["user_id"], "", $email_merge_fields, true);
    echo "<div id='notification1' class='successbox'>Request sent successfully</div>";
}
if ($save) {
    checkDemoMode(false);
    if (is_array($ids)) {
        foreach ($ids as $b) {
            $OrderDtl = mysqli_fetch_assoc(dquery("select * from tbl_order_product where order_id='" . $key . "'"));
        }
    }
    $returnid = $OrderDtl["invoceiid"] . rand(99, 992929);
    if (is_array($ids)) {
        foreach ($ids as $b) {
            $key = $b;
            $OrderDtl = mysqli_fetch_assoc(dquery("select * from tbl_order_product where order_id='" . $key . "'"));
            if ($OrderDtl) {
                $service = mysqli_fetch_assoc(dquery("select `service_name`,bundle,`template_id1` from `tbl_products` where `id`='" . $OrderDtl["service_id"] . "'"));
                $email_merge_fields["product"] .= "<br>\r\n" . $service["service_name"] . "<br>\r\n";
                $email_merge_fields["reason"] = $reason == 1 ? "Wrong item ordered" : $reason == 2 ? "Wrong description online" : $reason == 3 ? "Do not like the product" : $reason == 4 ? "Can't get it to work" : $reason == 5 ? "Manufacturer defect or DOA" : $reason == 6 ? "Damaged during shipping" : "Wrong item sent";
                $email_merge_fields["action"] = $action == 1 ? "Send replacement if within warranty" : $action == 2 ? "Repair and ship back" : $action == 3 ? "Give me a credit for future purchase" : "Other";
                $email_merge_fields["comment"] = $return_comment;
                $email_merge_fields["refid"] = $returnid;
                $email_merge_fields["address"] = nl2br($return_address);
            }
            $data["oid"] = $b;
            $data["date"] = date("Y-m-d");
            $data["uid"] = $returnid;
            $data["reason"] = $reason;
            $data["action"] = $action;
            $data["comment"] = $return_comment;
            $db->insert("tbl_return_request", $data);
            $data = NULL;
            dquery("update tbl_order_product set request='1' where order_id='" . $b . "'");
        }
        sendMail(70, $OrderDtl["user_id"], "", $email_merge_fields, true);
        echo "<div id='notification1' class='successbox'>Request sent successfully</div>";
    }
}
$prod = dquery("SELECT *,\n        (SELECT service_name FROM tbl_products WHERE id=service_id) as service,reply_date,\n        (SELECT code FROM tbl_currencies where id=(select default_currency from tblUsers where id=user_id)) as code ,\n        (select value from tbl_shipping_services where id=gatway) as gatway\n         from tbl_order_product where invoiceid='" . $id . "' and request!='1' order by order_id");
echo "<form method=\"post\">\n<input type=\"hidden\" name=\"loaddefaultpage\"  value=\"";
echo $loaddefaultpage;
echo "\" />\n<table id=\"main_tbl\" >\n<thead>\n<th width=\"10%\">";
echo $LNG["select_"];
echo "</th>\n<th width=\"50%\">";
echo $LNG["product"];
echo "</th>\n<th>";
echo $LNG["price"];
echo "</th>\n<th>";
echo $LNG["shipping"];
echo " ";
echo $LNG["date"];
echo "</th>\n</thead>\n<tbody>\n    ";
$flag = true;
while ($det = mysqli_fetch_assoc($prod)) {
    if ($det["user_can_c"] == 4) {
        $flag = false;
        echo "       <tr>\n       <td><input type=\"checkbox\" name=\"ids[";
        echo $det["order_id"];
        echo "]\" value=\"";
        echo $det["order_id"];
        echo "\" /></td>\n       <td > ";
        echo $det["service"];
        echo " ";
        if ($det["bun"]) {
            echo " [<strong>" . $LNG["bundle"] . "</strong>]";
        }
        echo " ";
        if ($det["gift"]) {
            echo " [<strong>" . $LNG["gift"] . "</strong>]";
        }
        echo "       </td>\n       <td>";
        echo $det["credit"] - $det["discount"];
        echo " ";
        echo $det["code"];
        echo "</td>\n       <td>";
        echo $det["reply_date"];
        echo "</td>\n       </tr>\n    ";
    }
}
echo "</tbody>\n</table>\n";
if ($flag) {
    echo "<div align=center>No Sent item for return</div>";
} else {
    echo "<br />\n<br />\n<table class=\"form\">\n<tr>\n<td class=\"fieldlabel\">";
    echo $LNG["reasonforreturn"];
    echo "</td>\n<td class=\"fieldarea\">\n<select name=\"reason\">\n<option value=\"1\" >Wrong item ordered</option>\n<option value=\"2\" >Wrong description online</option>\n<option value=\"3\" >Do not like the product</option>\n<option value=\"4\" >Can't get it to work</option>\n<option value=\"5\" >Manufacturer defect or DOA</option>\n<option value=\"6\" >Damaged during shipping</option>\n<option value=\"7\" >Wrong item sent</option>\n</select></td>\n</tr>\n<tr>\n<td class=\"fieldlabel\">";
    echo $LNG["whuliketodo"];
    echo "</td>\n<td class=\"fieldarea\">\n<select name=\"action\">\n<option value=\"1\" >Send replacement if within warranty</option>\n<option value=\"2\" >Repair and ship back</option>\n<option value=\"3\" >Give me a credit for future purchase</option>\n<option value=\"4\" >Other</option>\n</select></td>\n</tr>\n<tr>\n<td class=\"fieldlabel\">";
    echo $LNG["comments"];
    echo "</td>\n<td class=\"fieldarea\">\n<textarea rows=\"3\" cols=\"60\" name=\"return_comment\"></textarea></td>\n</tr>\n<tr>\n<td class=\"fieldlabel\">";
    echo $LNG["return"];
    echo " ";
    echo $LNG["address"];
    echo "</td>\n<td class=\"fieldarea\">\n<textarea rows=\"3\" cols=\"60\" name=\"return_address\">";
    echo $config["invoicepayto"];
    echo "</textarea></td>\n</tr>\n</table>\n\n<div class=\"fixedbtn\">\n    <input type=\"submit\" name=\"save\" value=\"";
    echo $LNG["send"];
    echo " ";
    echo $LNG["request"];
    echo "\" />\n</div>\n\n";
}
echo "</form>\n";
$sql = dquery("select * from tbl_return_request where oid=(select order_id from \ntbl_order_product where invoiceid='" . $id . "' limit 1) and sendbyuid!='0'");
if (mysqli_num_rows($sql)) {
    echo "<br />\n<table id=\"main_tbl\" >\n<thead>\n<th width=\"10%\">";
    echo $LNG["date"];
    echo "</th>\n<th width=\"50%\">";
    echo $LNG["product"];
    echo "</th>\n<th>";
    echo $LNG["reason"];
    echo "</th>\n<th>";
    echo $LNG["shipping"];
    echo " ";
    echo $LNG["date"];
    echo "</th>\n<th>";
    echo $LNG["action"];
    echo "</th>\n</thead>\n<tbody>\n";
    while ($row = mysqli_fetch_assoc($sql)) {
        $prod = mysqli_fetch_assoc(dquery("select \n    (select service_name from tbl_products where id=service_id) product ,reply_date\n    from tbl_order_product where order_id='" . $row["oid"] . "'"));
        $reason = $row["reason"];
        $reason = $reason == 1 ? "Wrong item ordered" : $reason == 2 ? "Wrong description online" : $reason == 3 ? "Do not like the product" : $reason == 4 ? "Can't get it to work" : $reason == 5 ? "Manufacturer defect or DOA" : $reason == 6 ? "Damaged during shipping" : "Wrong item sent";
        echo "<tr>\n<td>";
        echo $row["date"];
        echo "</td>\n<td>";
        echo $prod["product"];
        echo "</td>\n<td>";
        echo $reason;
        echo "</td>\n<td>";
        echo $prod["reply_date"];
        echo "</td>\n<td><a href=\"javascript:redirectedit('editproductorder.return','";
        echo $id;
        echo "&accept=";
        echo $row["id"];
        echo "');\" >";
        echo $LNG["accept"];
        echo "</a></td>\n</tr>\n";
    }
    echo "</tbody>\n</table>\n";
}
$fileverioncheck = "6.1.0";

?>