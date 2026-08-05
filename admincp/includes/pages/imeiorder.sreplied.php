<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 137;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/clients.fun.inc.php";
include_once ROOTDIR . "/includes/imeiservices.fun.php";
if (!$limitinc) {
    $pagelimit = 100;
} else {
    $pagelimit = $limitinc;
}
if ($finder) {
    if ($search != "" && $service) {
        $where = "and service_id='" . $service . "' and imei like '" . $search . "'";
    } else {
        if ($search != "") {
            $where = "and imei like '" . $search . "'";
        } else {
            if ($service) {
                $where = "and service_id='" . $service . "'";
            }
        }
    }
}
if ($config["orderdisplay"] == 2) {
    $orderby = " ORDER BY order_id ASC";
} else {
    $orderby = " ORDER BY order_id DESC";
}
$where .= " and useasserver=1";
$q = dquery("select order_id,service_id,ebay,imei,retail_shop,tmp_status,\r\n(select service_name from tbl_services_imei where id=service_id) as service,\r\nreseller_id,TRUNCATE(reseller_credit,2) as reseller_credit,\r\n(SELECT (SELECT code from tbl_currencies\r\nwhere tbl_currencies.id=(select default_currency \r\nfrom tblUsers where tblUsers.id=user_id)\r\n   ) ) as codes,\r\nTRUNCATE(reseller_discount,2) as reseller_discount,\r\ndate,TRUNCATE(credit,2) as credit,TRUNCATE(discount,2) as discount,\r\n(select username from tblUsers where id=user_id) as username from \r\ntbl_order_imei where user_can_c='1' " . $where . "  " . $orderby . " limit " . $pagelimit);
$_SESSION["once_accepted"] = true;
if ($extract) {
    if (!isset($show)) {
        if ($sservice) {
            $QUER = "and service_id='" . $sservice . "'";
        }
        $order = dquery("SELECT `order_id` FROM `tbl_order_imei`\r\n                               WHERE  `user_can_c`='1' " . $QUER);
        while ($rows = mysqli_fetch_assoc($order)) {
            $_order[] = $rows["order_id"];
        }
        if ($_order) {
            $order = implode(",", $_order);
            $_SESSION["tmp_orders"] = $order;
        } else {
            $order = $_SESSION["tmp_orders"];
        }
    } else {
        $order = $_SESSION["tmp_orders"];
    }
    $laoddefaultpage = "quickreply.php";
    echo "    <div id=\"tabcontent\">\r\n    ";
    include "quickacceptedorder.php";
    exit;
}
echo "<div id=\"notification\"></div>\r\n<div id=\"content\">\r\n<div id=\"content_padded\">\r\n\r\n <h2 style=\"float:left\">\r\n    <span class=\"groupstabesheadertext\">Manual Reply</span>\r\n  </h2>\r\n\r\n<form method=\"post\" style=\"float: right;\">\r\n<input type=\"hidden\" name=\"loaddefaultpage\" value=\"imeiorder.replied.php\" />\r\n\r\n<select name=\"service\" id=\"sservice\">\r\n    <option value=\"\">Select Service</option>\r\n    ";
$sql = dquery("SELECT service_id,(SELECT service_name FROM tbl_services_imei WHERE id=service_id and useasserver=1) \r\n    AS service from tbl_order_imei where user_can_c='1' group by service_id");
while ($rows = mysqli_fetch_assoc($sql)) {
    if ($rows["service"]) {
        echo "    <option ";
        if ($service == $rows["service_id"]) {
            echo "selected";
        }
        echo "     value=\"";
        echo $rows["service_id"];
        echo "\" >";
        echo $rows["service"];
        echo "</option>\r\n    ";
    }
}
echo "</select>\r\n\r\n\r\n<input type=\"text\" name=\"search\" style=\"background: #f4f4f4;padding:7px;\" placeholder=\"Enter Server\"/>\r\n\r\n<input type=\"submit\" class=\"btn btn-primary\"  name=\"finder\" value=\"";
echo $LNG["search"];
echo "\" />\r\n\r\n\r\n<input type=\"button\" class=\"btn\"  name=\"extract\" style=\"float: right;margin-left:10px\"\r\nonclick=\"load_subpage('main2.php?page=imeiorder.replied&extract=true&sservice='+document.getElementById('sservice').value+'','";
echo $LNG["extractall"];
echo "');\" value=\"";
echo $LNG["extractall"];
echo "\" />\r\n\r\n\r\n</form>\r\n\r\n <div class=\"clear\"></div>\r\n\r\n\r\n<br />\r\n<script>\r\nfunction setReply(val)\r\n{\r\n    var len=document.replied.replies.length;\r\n\tfor(var i=0;i<len;i++)\r\n\t{\r\n        document.replied.replies[i].value=val;\r\n\t}\r\n}\r\n</script>\r\n\r\n<form id=\"replied\" name=\"replied\" method=\"post\" >\r\n";
echo generate_token("form");
echo "<table id=\"main_tbl\" >\r\n<thead>\r\n  <tr>\r\n\r\n        <th>";
echo $LNG["servicename"];
echo "</th>\r\n        <th>";
echo $LNG["date"];
echo " </th>\r\n        <th>";
echo $LNG["total"] . " " . $LNG["credit"];
echo "        <small>";
echo $LNG["user"];
echo "/";
echo $LNG["reseller"];
echo "</small></th>\r\n        <th>";
echo $LNG["username"];
echo " </th>\r\n\r\n        <th>";
echo $LNG["imei"];
echo " </th>\r\n        <th>\r\n        <select name=\"rpl\"    onchange=\"setReply(this.value);\">\r\n            <option value=\"\">-";
echo $LNG["reply"];
echo "-</option>\r\n            ";
$dt = explode("\n", $config["orderreplyword"]);
foreach ($dt as $d) {
    $d = trim($d);
    echo "                    <option value=\"";
    echo $d;
    echo "\">";
    echo $d;
    echo "</option>\r\n                ";
}
echo "        </select></th>\r\n        <th><input type=\"checkbox\"\r\n        id=\"rrj\" name=\"reject\"\r\n        onclick=\"RCheckAll(this);\" /><label for=\"rrj\">";
echo $LNG["reject"];
echo "</label>\r\n        </th>\r\n        <th>\r\n        <input type=\"checkbox\"\r\n        id=\"acrj\" name=\"reject\"\r\n        onclick=\"ACheckAll(this);\" /><label for=\"acrj\">New</label></th>\r\n        <th></th>\r\n  </tr>\r\n</thead>\r\n<tbody>\r\n";
while ($r = mysqli_fetch_assoc($q)) {
    echo "    <tr id=\"hide_";
    echo $r["order_id"];
    echo "\">\r\n        <td>";
    echo $r["service"];
    echo "</td>\r\n ";
    if (!$supplieraccess) {
        echo "        <td>";
        echo $r["date"];
        echo "</td>\r\n        <td>";
        echo $r["credit"] - $r["discount"];
        echo "        ";
        if ($r["reseller_id"]) {
            echo " / " . ($r["reseller_credit"] - $r["reseller_discount"]);
        }
        echo " ";
        echo $r["codes"];
        echo "</td>\r\n        <td>";
        echo $r["username"];
        echo "</td>\r\n ";
    }
    echo "        <td  title=\"";
    if ($r["ebay"]) {
        echo "Diect Order";
    }
    if ($r["retail_shop"]) {
        echo " Retail Order";
    }
    if ($r["tmp_status"] == 9) {
        echo " App Order";
    }
    echo "\">";
    if ($r["ebay"]) {
        echo " [D]";
    }
    if ($r["retail_shop"]) {
        echo " [R]";
    }
    if ($r["tmp_status"] == 9) {
        echo " [A]";
    }
    echo " ";
    echo $r["imei"];
    echo "</td>\r\n        <td style=\"position: relative\">\r\n        <input type=\"text\"   style=\"width:200px\"\r\n        id=\"replies\" class=\"rep_";
    echo $r["order_id"];
    echo "\"\r\n         name=\"reply[";
    echo $r["order_id"];
    echo "]\" /><input title=\"Clear\"  type=\"button\" style=\"background: transparent;min-width: 20px;margin-left: -36px;position: absolute;top: 9px;color: black;\"\r\n         onclick=\"javascript: \$('.rep_";
    echo $r["order_id"];
    echo "').val('');\" value=\"x\" /></td>\r\n        <td>\r\n        <input type=\"checkbox\" name=\"reject[";
    echo $r["order_id"];
    echo "]\"\r\n         class=\"reject\" value=\"";
    echo $r["order_id"];
    echo "\" /> <label></label>\r\n         </td>\r\n         <td>\r\n         <input type=\"checkbox\" name=\"accept[";
    echo $r["order_id"];
    echo "]\"\r\n         class=\"accept\" value=\"";
    echo $r["order_id"];
    echo "\" /><label></label> </td>\r\n         <td></td>\r\n    </tr>\r\n    ";
}
echo "</tbody></table>\r\n<div class=\"fixedbtn\">\r\n\r\n<input type=\"button\" name=\"replyorders\" id=\"replyorders\" class=\"btn\"  value=\"";
echo $LNG["reply"];
echo " ";
echo $LNG["selected"];
echo "\"\r\n onclick=\"SubmitForm ('#replyorders','imeireplied','#replied','#notification','true','#main_loader');\" >\r\n\r\n <div style=\"float: right;\">\r\n\r\n\r\nResults:\r\n";
if ($finder && ($search || $service)) {
    if ($search != "" && $service) {
        $shower = mysqli_num_rows(dquery("SELECT `order_id` FROM \r\n        `tbl_order_imei` WHERE `user_can_c`='1' and service_id='" . $service . "' and imei='" . $search . "'"));
    } else {
        if ($search != "") {
            $shower = mysqli_num_rows(dquery("SELECT `order_id` FROM \r\n        `tbl_order_imei` WHERE `user_can_c`='1' and imei='" . $search . "'"));
        } else {
            if ($service) {
                $shower = mysqli_num_rows(dquery("SELECT `order_id` FROM \r\n        `tbl_order_imei` WHERE `user_can_c`='1' and service_id='" . $service . "'"));
            }
        }
    }
} else {
    if ($pagelimit) {
        $shower = mysqli_num_rows(dquery("SELECT `order_id` FROM \r\n        `tbl_order_imei` WHERE `user_can_c`='1' limit " . $pagelimit));
    } else {
        $shower = mysqli_num_rows(dquery("SELECT `order_id` FROM \r\n        `tbl_order_imei` WHERE `user_can_c`='1'"));
    }
}
$tods = mysqli_num_rows(dquery("select order_id from tbl_order_imei \r\n                                    where user_can_c='1'"));
if ($shower < $tods) {
    echo $shower . "/" . $tods;
}
echo "\r\n &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n\r\nDisplay :\r\n<select name=\"limitinc\" onchange=\"location.href='main2.php?page=imeiorder&laoddefaultpage=imeiorder.replied.php&limitinc='+this.value+'&service='+document.getElementById('sservice').value+'&finder=true';\">\r\n    <option value=\"100\" ";
if ($limitinc == 100 || !$limitinc) {
    echo "selected";
}
echo ">100</option>\r\n    <option value=\"200\" ";
if ($limitinc == 200) {
    echo "selected";
}
echo ">200</option>\r\n    <option value=\"500\" ";
if ($limitinc == 500) {
    echo "selected";
}
echo ">500</option>\r\n    <option value=\"1000\" ";
if ($limitinc == 1000) {
    echo "selected";
}
echo ">1000</option>\r\n    <option value=\"9999\" ";
if ($limitinc == 9999) {
    echo "selected";
}
echo ">Show All</option>\r\n</select>\r\n\r\n</div>\r\n\r\n\r\n</div>\r\n</form></div></div>\r\n<script>\r\nfunction CheckAll()\r\n{\r\n\t\tvar i=document.replied.select.length;\r\n\t\tvar k;\r\n\t\tfor (k=0 ; k < i; k++)\r\n\t\t{\r\n\t\t\tif(document.replied.select[k].checked==true)\r\n\t\t\t{\r\n\t\t\t\tdocument.replied.select[k].checked=false;\r\n\t\t\t}\r\n\t\t\telse\r\n\t\t\t{\r\n\t\t\t\tdocument.replied.select[k].checked=true;\r\n\t\t\t}\r\n\t\t}\r\n}\r\nfunction ACheckAll(o)\r\n{\r\n        if(\$(o).is(\":checked\")){\r\n            \$('.accept').prop({'checked':true});\r\n        }\r\n        else{\r\n            \$('.accept').prop({'checked':false});\r\n        }\r\n\r\n}\r\nfunction RCheckAll(o)\r\n{\r\n\t\tif(\$(o).is(\":checked\")){\r\n            \$('.reject').prop({'checked':true});\r\n        }\r\n        else{\r\n            \$('.reject').prop({'checked':false});\r\n        }\r\n}\r\n</script>\r\n";
$fileverioncheck = "6.1.0";

?>