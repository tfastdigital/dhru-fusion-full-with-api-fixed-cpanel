<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

include_once ROOTDIR . "/includes/products.fun.php";
include_once ROOTDIR . "/includes/clients.fun.inc.php";
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
if ($save) {
    include_once ROOTDIR . "/includes/mail.fun.php";
    if (is_array($ids)) {
        foreach ($ids as $b) {
            $key = $b;
            $OrderDtl = mysqli_fetch_assoc(dquery("select * from tbl_order_product where order_id='" . $key . "'"));
            dquery("update tbl_return_request set status='" . $status[$key] . "' where id='" . $id . "'");
            if ($OrderDtl) {
                $service = mysqli_fetch_assoc(dquery("select `service_name`,bundle,`template_id1` from `tbl_products` where `id`='" . $OrderDtl["service_id"] . "'"));
                $email_merge_fields["product"] .= "<br>\r\n" . $service["service_name"] . "<br>\r\n";
                $email_merge_fields["reason"] = $reason == 1 ? "Wrong item ordered" : $reason == 2 ? "Wrong description online" : $reason == 3 ? "Do not like the product" : $reason == 4 ? "Can't get it to work" : $reason == 5 ? "Manufacturer defect or DOA" : $reason == 6 ? "Damaged during shipping" : "Wrong item sent";
                $email_merge_fields["action"] = $action == 1 ? "Send replacement if within warranty" : $action == 2 ? "Repair and ship back" : $action == 3 ? "Give me a credit for future purchase" : "Other";
                $email_merge_fields["status"] = $retdt["status"] == 0 ? "Requested" : $retdt["status"] == 1 ? "Authorized" : $retdt["status"] == 2 ? "Declined" : $retdt["status"] == 3 ? "Completed" : "Canceled";
                $email_merge_fields["comment"] = $return_comment;
                $email_merge_fields["refid"] = $id;
                $email_merge_fields["address"] = nl2br($return_address);
                dquery("update tbl_return_request \n    set reason='" . $reason . "',action='" . $action . "',comment='" . $return_comment . "' where uid='" . $id . "'");
                if ($status[$key] == 3 && $price[$key] && $ptype[$key] == 1) {
                    addCredit($OrderDtl["user_id"], $price[$key], true, "", "Return Request Completed");
                }
            }
        }
        sendMail(70, $OrderDtl["user_id"], "", $email_merge_fields, true);
        echo "<div id='notification1' class='successbox'>Request updated successfully</div>";
    }
}
echo "<script>\nfunction setCompleted(val,ids){\n    if(val==3){\n       \$(\"#price_\"+ids).show();\n       \$(\"#ptype_\"+ids).show();\n    }else{\n       \$(\"#price_\"+ids).hide();\n       \$(\"#ptype_\"+ids).hide();\n    }\n}\n</script>\n<link rel=\"stylesheet\" href=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/x-main2.css\" />\n<form method=\"post\">\n<input type=\"hidden\" name=\"loaddefaultpage\"  value=\"";
echo $loaddefaultpage;
echo "\" />\n<input type=\"hidden\" name=\"id\"  value=\"";
echo $id;
echo "\" />\n<table id=\"main_tbl\" >\n<thead>\n<th>";
echo $LNG["product"];
echo "</th>\n<th>";
echo $LNG["price"];
echo "</th>\n<th>";
echo $LNG["shipping"];
echo " ";
echo $LNG["date"];
echo "</th>\n<th>";
echo $LNG["status"];
echo "</th>\n</thead>\n<tbody>\n";
$return = dquery("select * from tbl_return_request where uid='" . $id . "'");
while ($r = mysqli_fetch_assoc($return)) {
    $prod = dquery("SELECT *,\n        (SELECT service_name FROM tbl_products WHERE id=service_id) as service,reply_date,\n        (SELECT code FROM tbl_currencies where id=(select default_currency from tblUsers where id=user_id)) as code ,\n        (select value from tbl_shipping_services where id=gatway) as gatway\n         from tbl_order_product where order_id='" . $r["oid"] . "'");
    echo "\n    ";
    $flag = true;
    while ($det = mysqli_fetch_assoc($prod)) {
        if ($det["user_can_c"] == 4) {
            if (mysqli_num_rows(dquery("select * from tbl_return_request where uid='" . $id . "' and oid='" . $det["order_id"] . "'"))) {
            }
            $flag = false;
            echo "       <tr>\n<input type=\"hidden\" name=\"ids[";
            echo $det["order_id"];
            echo "]\" value=\"";
            echo $det["order_id"];
            echo "\" />\n       <td > ";
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
            echo "</td>\n       <td>\n<select name=\"status[";
            echo $det["order_id"];
            echo "]\" onchange=\"setCompleted(this.value,'";
            echo $r["id"];
            echo "');\">\n<option ";
            if ($r["status"] == 0) {
                echo "selected";
            }
            echo " value=\"0\">Requested</option>\n<option ";
            if ($r["status"] == 1) {
                echo "selected";
            }
            echo " value=\"1\">Authorized</option>\n<option ";
            if ($r["status"] == 2) {
                echo "selected";
            }
            echo " value=\"2\">Declined</option>\n<option ";
            if ($r["status"] == 3) {
                echo "selected";
            }
            echo " value=\"3\">Completed</option>\n<option ";
            if ($r["status"] == 4) {
                echo "selected";
            }
            echo " value=\"4\">Canceled</option>\n</select>   \n<select style=\"";
            if ($r["status"] != 3) {
                echo "display: none;";
            }
            echo "\" name=\"ptype[";
            echo $det["order_id"];
            echo "]\" id=\"ptype_";
            echo $r["id"];
            echo "\">\n    <option value=\"1\">Add to Credit balance</option>\n    <option value=\"2\">Manual Process</option>\n</select>   \n<input style=\"width: 50px;";
            if ($r["status"] != 3) {
                echo "display: none;";
            }
            echo "\" type=\"text\" id=\"price_";
            echo $r["id"];
            echo "\" name=\"price[";
            echo $det["order_id"];
            echo "]\" \nvalue=\"";
            echo $det["credit"] - $det["discount"];
            echo "\" />\n       </td>\n       </tr>\n    ";
        }
    }
    echo "\n";
}
$return = mysqli_fetch_assoc(dquery("select * from tbl_return_request where uid='" . $id . "'"));
echo "</tbody>\n</table>\n<br />\n<br />\n<table class=\"form\">\n<tr>\n<td class=\"fieldlable\">";
echo $LNG["reasonforreturn"];
echo "</td>\n<td class=\"fieldarea\">\n<select name=\"reason\">\n<option ";
if ($return["reason"] == 1) {
    echo "selected";
}
echo " value=\"1\" >Wrong item ordered</option>\n<option ";
if ($return["reason"] == 2) {
    echo "selected";
}
echo "  value=\"2\">Wrong description online</option>\n<option ";
if ($return["reason"] == 3) {
    echo "selected";
}
echo "  value=\"3\">Do not like the product</option>\n<option ";
if ($return["reason"] == 4) {
    echo "selected";
}
echo "  value=\"4\">Can't get it to work</option>\n<option ";
if ($return["reason"] == 5) {
    echo "selected";
}
echo "  value=\"5\">Manufacturer defect or DOA</option>\n<option ";
if ($return["reason"] == 6) {
    echo "selected";
}
echo "  value=\"6\">Damaged during shipping</option>\n<option ";
if ($return["reason"] == 7) {
    echo "selected";
}
echo "  value=\"7\">Wrong item sent</option>\n</select></td>\n</tr>\n<tr>\n<td class=\"fieldlable\">";
echo $LNG["whuliketodo"];
echo "</td>\n<td class=\"fieldarea\">\n<select name=\"action\">\n<option ";
if ($return["action"] == 1) {
    echo "selected";
}
echo "  value=\"1\" >Send replacement if within warranty</option>\n<option ";
if ($return["action"] == 2) {
    echo "selected";
}
echo "  value=\"2\">Repair and ship back</option>\n<option ";
if ($return["action"] == 3) {
    echo "selected";
}
echo "  value=\"3\">Give me a credit for future purchase</option>\n<option ";
if ($return["action"] == 4) {
    echo "selected";
}
echo "  value=\"4\">Other</option>\n</select></td>\n</tr>\n<tr>\n<td class=\"fieldlable\">";
echo $LNG["comments"];
echo "</td>\n<td class=\"fieldarea\">\n<textarea class=\"textarea large\" name=\"return_comment\">";
echo $return["comment"];
echo "</textarea></td>\n</tr>\n<tr>\n<td class=\"fieldlable\">";
echo $LNG["return"];
echo " ";
echo $LNG["address"];
echo "</td>\n<td class=\"fieldarea\">\n<textarea class=\"textarea large\" name=\"return_address\">";
echo $config["invoicepayto"];
echo "</textarea></td>\n</tr>\n<tr>\n<td></td>\n<td  align=\"left\"><input type=\"submit\" class=\"btn save\" name=\"save\" value=\"";
echo $LNG["update"];
echo " ";
echo $LNG["request"];
echo "\" /></td>\n</tr>\n</table>\n\n</form>";
$fileverioncheck = "6.1.0";

?>