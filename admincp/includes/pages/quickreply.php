<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 369;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/clients.fun.inc.php";
include_once ROOTDIR . "/includes/imeiservices.fun.php";
include_once ROOTDIR . "/includes/customfield.fun.inc.php";
if (!$limitinc) {
    $pagelimit = 100;
} else {
    $pagelimit = $limitinc;
}
$Codes = [];
$c = dquery("select id,code from tbl_currencies");
while ($r = mysqli_fetch_assoc($c)) {
    $Codes[$r["id"]] = $r["code"];
}
echo "<style>\n    .autoaccept {\n        position: relative;\n        display: inline-block;\n    }\n    .autoaccept .autotext {\n        visibility: hidden;\n        width: 120px;\n        background-color: black;\n        color: #fff;\n        text-align: center;\n        padding: 5px 0;\n        border-radius: 6px;\n        position: absolute;\n        z-index: 1;\n    }\n    .autoaccept:hover .autotext {\n        visibility: visible;\n    }\n</style>\n    <script>\n        function requeorder(orderid){\n            \$.post(\"includes/pages/resetorderstat.php?orderid=\"+orderid, function(data, status){\n                \$(\".order\"+orderid).removeClass('fa');\n                \$(\".order\"+orderid).removeClass('fa-exclamation-triangle');\n                \$(\".order\"+orderid).removeClass('tooltipcolor');\n                \$(\".ts\"+orderid).remove();\n            });\n        }\n    </script>\n";
if ($finder) {
    if ($search != "" && $service) {
        $where = " service_id='" . $service . "' and imei like '" . $search . "'";
    } else {
        if ($search != "") {
            $where = " (imei like '" . $search . "' or user_id in (select\n            id from tblUsers where username like '" . $search . "') )";
        } else {
            if ($service) {
                $where = " service_id='" . $service . "'";
            }
        }
    }
    if ($user) {
        if ($where) {
            $where .= " and user_id='" . $user . "'";
        } else {
            $where .= "  user_id='" . $user . "'";
        }
    }
    if ($fromdate && $todate) {
        $where .= "  (date between '" . $fromdate . "' and '" . $todate . "')";
    }
    if (!$where) {
        $where .= "  1=1";
    }
} else {
    $where .= "  1=1";
}
if ($config["orderdisplay"] == 2) {
    $default_order_type = " ORDER BY order_id ASC";
} else {
    $default_order_type = " ORDER BY order_id DESC";
}
if ($stype == "remote") {
    $whereserv = " `server`=2";
    $wherecond = " `server`=2 and";
    $commonwhere = " and useasserver=2";
} else {
    if ($stype == "server") {
        $whereserv = " `server`=1";
        $wherecond = " `server`=1 and";
        $commonwhere = " and useasserver=1";
    } else {
        $whereserv = " `server`=0";
        $wherecond = " `server`=0 and";
        $commonwhere = " and useasserver=0";
    }
}
if ($stype == "server" || $stype == "remote") {
    $q = dquery("select order_id,\nIF(apierror!='' AND (user_can_c='0' or user_can_c='1' or  user_can_c='8')\n,concat('<i style=\"cursor:pointer;\" onclick=\"requeorder(',order_id,')\"  class=\"fa fa-exclamation-triangle  tooltipcolor order',order_id,'\">',order_id,'<span class=\"tooltiptext ts',order_id,'\"><strong>" . $LNG["apiprocessingerror"] . "</strong>',apierror,IF(user_can_c=0 or user_can_c=1,concat('<a style=\"color:white;font-size:12px;\" >Click  to Reset </a>'),''),'</span></i>'),order_id) as order2\n,reply,ebay,service_id,imei,\n (select service_name from tbl_services_imei where id=service_id) as service,\ndate,reseller_id,\n(SELECT GROUP_CONCAT(concat(fieldname,'=>',value) separator '<br />') from tbl_customfieldsvalues\nwhere servicetype='server'\nand relid=tbl_order_imei.order_id) as field,\n\nTRUNCATE(credit,2)  AS credit,\n(select default_currency\nfrom tblUsers where tblUsers.id=user_id) as codes,\n  TRUNCATE(discount,2) as discount,\n(select username from tblUsers where id=user_id) as username,\nIF(qnt=0,1,qnt) as qnt\n from tbl_order_imei where " . $wherecond . " user_can_c='1'  AND\n" . $where . " " . $default_order_type . " limit " . $pagelimit);
} else {
    $q = dquery("select order_id,\nIF(apierror!='' AND (user_can_c='0' or user_can_c='1' or  user_can_c='8')\n,concat('<i style=\"cursor:pointer;\" onclick=\"requeorder(',order_id,')\"  class=\"fa fa-exclamation-triangle  tooltipcolor order',order_id,'\">',order_id,'<span class=\"tooltiptext ts',order_id,'\"><strong>APi Error</strong>',apierror,IF(user_can_c=0 or user_can_c=1,concat('<a style=\"color:white;font-size:12px;\" >Click  to Reset </a>'),''),'</span></i>'),order_id) as order2\n,reply,ebay,service_id,imei,\n (select service_name from tbl_services_imei where id=service_id) as service,\ndate,reseller_id,\nTRUNCATE(credit,2)  AS credit,\n(select default_currency\nfrom tblUsers where tblUsers.id=user_id) as codes\n  ,TRUNCATE(discount,2) as discount,\n(select username from tblUsers where id=user_id) as username,\nIF(qnt=0,1,qnt) as qnt\n from tbl_order_imei where " . $wherecond . " user_can_c='1'  AND\n" . $where . " " . $default_order_type . " limit " . $pagelimit);
}
$_SESSION["once_accepted"] = true;
if ($extract) {
    if (!isset($show)) {
        if ($sservice) {
            $QUER .= "and service_id='" . $sservice . "'";
        }
        if ($user) {
            $QUER .= "and user_id='" . $user . "'";
        }
        $order = dquery("SELECT `order_id` FROM `tbl_order_imei` WHERE  `user_can_c`='1' " . $QUER);
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
    echo "    <div id=\"tabcontent\">\n    ";
    include "quickacceptedorder.php";
    exit;
}
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n\n";
if ($extract) {
    if ($stype == "remote") {
        $whereorder = " and `server`=2";
    } else {
        if ($stype == "server") {
            $whereorder = " and `server`=1";
        } else {
            $whereorder = " and `server`=0";
        }
    }
    $buf = "";
    $sql = dquery("SELECT `order_id`,`imei` FROM `tbl_order_imei`\n    where `user_can_c`='1' " . $whereorder . " order by order_id desc");
    while ($row = mysqli_fetch_assoc($sql)) {
        $buf .= $row["order_id"] . "  : " . $row["imei"] . "&#10;";
    }
    echo "<textarea style=\"width: 100%;\" rows=\"5\">\n";
    echo $buf;
    echo "</textarea>\n";
}
echo "<script>\nfunction setReply(val)\n{\n    try{\n        var len=\$(\"input[id='replies']\").length;\n        if(len==1){\n            document.replied.replies.value=val;\n        }\n    \tfor(var i=0;i<len;i++)\n    \t{\n            document.replied.replies[i].value=val;\n    \t}\n    }catch(es){\n    }\n}\n</script>\n<style>\n    .boxes{\n        width: 10px;\n        height: 10px;\n        float:left;\n        margin-top: 4px;\n        margin-right: 4px;\n    }\n</style>\n\n\n<form method=\"post\" >\n\n    <fieldset class=\"search-form mb-1\">\n        <legend>Quick Reply Search</legend>\n        <div class=\"d-flex flex-wrap\">\n            ";
$GROUPNAME = "";
echo "            <div style=\"flex-grow: 1\" class=\"mb-1\">\n            <select name=\"service\" id=\"sservice\" class=\"chosen\">\n                <option value=\"\">Select Service</option>\n                ";
$sql = dquery("SELECT service_id,(SELECT service_name FROM tbl_services_imei\n WHERE id=service_id  )\nAS service from tbl_order_imei where user_can_c='1' and " . $whereserv . " group by service_id");
while ($rows = mysqli_fetch_assoc($sql)) {
    echo "                    <option ";
    if ($service == $rows["service_id"]) {
        echo "selected";
    }
    echo " value=\"";
    echo $rows["service_id"];
    echo "\" >";
    echo $rows["service"];
    echo "</option>\n                    ";
}
echo "            </select>\n            </div>\n\n            <div  style=\"flex-grow: 1\" class=\"mb-1\">\n            <select name=\"user\" id=\"user_id\" class=\"chosen\">\n                <option value=\"\">-Select User-</option>\n                ";
$qd = dquery("select id,username from tblUsers\n where id in (select user_id  from tbl_order_imei where user_can_c='1' and " . $whereserv . ") order by username asc");
while ($rd = mysqli_fetch_assoc($qd)) {
    echo "                    <option ";
    if ($user == $rd["id"]) {
        echo "selected";
    }
    echo " value=\"";
    echo $rd["id"];
    echo "\">";
    echo $rd["username"];
    echo "</option>\n                    ";
}
echo "            </select>\n            </div>\n\n            <input type=\"hidden\" name=\"loaddefaultpage\" value=\"quickreply.php\" />\n\n            <div  class=\"mb-1\">\n            ";
if ($stype != "server" && $stype != "remote") {
    echo "                <input type=\"text\" class=\"txt mr-1\"  style=\"width: 200px\"  name=\"search\" placeholder=\"Search IMEI\" />\n                ";
}
echo "\n\n            <input type=\"text\"  class=\"txt datepicker mr-1\"   style=\"width: 150px\" name=\"fromdate\" value=\"\" placeholder=\"yyyy-mm-dd\" id=\"from\" />\n\n            <input type=\"text\"  class=\"txt    mr-1 datepicker\"   style=\"width: 150px\"   name=\"todate\" value=\"\" placeholder=\"yyyy-mm-dd\" id=\"to\" />\n\n            <input type=\"submit\" class=\"btn btn-primary\" name=\"finder\" value=\"";
echo $LNG["search"];
echo "\" />\n\n            <input type=\"button\" class=\"btn btn-info\" name=\"extract\"  onclick=\"load_subpage('main2.php?page=quickreply&extract=true&sservice='+document.getElementById('sservice').value+'&user='+document.getElementById('user_id').value,'";
echo $LNG["extractall"];
echo "');\" value=\"";
echo $LNG["extractall"];
echo "\" />\n\n            </div>\n\n        </div>\n\n\n\n    </fieldset>\n\n    <div class=\"text-muted text-right\">\n        <i> ";
echo $LNG["quickreplyinfo"];
echo " </i>\n\n        <select name=\"rpl\" class=\"ml-1\"  onchange=\"setReply(this.value);\">\n            <option value=\"\">";
echo $LNG["reply"];
echo " for all </option>\n            ";
$dt = explode("\n", $config["orderreplyword"]);
foreach ($dt as $d) {
    $d = trim($d);
    echo "                <option value=\"";
    echo $d;
    echo "\">";
    echo $d;
    echo "</option>\n                ";
}
echo "        </select>\n\n    </div>\n\n\n\n\n\n\n\n\n</form>\n<div class=\"clear\"></div>\n<br />\n<form id=\"replied\" name=\"replied\" method=\"post\" >\n";
echo generate_token("form");
echo "<table id=\"main_tbl\" class=\"quicksort\">\n<thead>\n  <tr>\n      <th>";
echo $LNG["id"];
echo "</th>\n        <th>";
echo $LNG["servicename"];
echo "</th>\n ";
if (!$supplieraccess) {
    echo "        <th>";
    echo $LNG["date"];
    echo " </th>\n\n     <th class=\"sorter-false\">";
    if ($stype == "server" || $stype == "remote") {
        echo $LNG["qnt"];
        echo "             ";
    } else {
        echo $LNG["imei"];
    }
    echo "     </th>\n     ";
    if ($stype == "server" || $stype == "remote") {
        echo "         <th>";
        echo $LNG["field"];
        echo "</th>\n         ";
    }
    echo "        <th>";
    echo $LNG["total"] . " " . $LNG["credit"];
    echo " <br /><small>";
    echo $LNG["user"];
    echo "/";
    echo $LNG["reseller"];
    echo "</small> </th>\n        <th>";
    echo $LNG["username"];
    echo " </th>\n ";
}
echo "\n        <th  class=\"sorter-false\">\n            Reply\n        </th>\n\n  </tr>\n</thead>\n<tbody>\n";
while ($Orders = mysqli_fetch_assoc($q)) {
    echo "    <tr id=\"hide_";
    echo $Orders["order_id"];
    echo "\" title=\"IMEI : ";
    echo $Orders["imei"];
    echo "\">\n        <td>\n            <div class=\"default_dg_a2 \" style=\"position:relative\" onclick=\"javascript:load_fromsubpage('edituser.editimeiorder&id=";
    echo $Orders["order_id"];
    echo "','";
    echo $stype == "server" ? "SERVER" : ($stype == "remote" ? "REMOTE" : "IMEI");
    echo " #";
    echo $Orders["order_id"];
    echo "')\">#";
    echo $Orders["order2"];
    echo "  </div>\n             </td>\n        <td><div class=\"boxes\" ></div>\n            ";
    if ($stype == "server" || $stype == "remote") {
        echo "                <i class=\"fa fa-exclamation-triangle  tooltipcolor\"> ";
        echo $Orders["service"];
        echo "                    <div class=\"tooltiptext\">\n                        ";
        $custom = getCustomFields("serviceimei", $Orders["service_id"], $Orders["order_id"]);
        foreach ($custom as $c => $v) {
            if ($v[value]) {
                echo $v["name"] . " : " . $v["value"] . "<br />";
            }
        }
        echo "</div>\n                </i>\n                ";
    } else {
        echo $Orders["service"];
    }
    echo "        </td>\n        <td class=\"nowrap\">";
    echo $Orders["date"];
    echo "</td>\n        <td  title=\"";
    if ($Orders["ebay"]) {
        echo "Diect Order";
    }
    if ($Orders["retail_shop"]) {
        echo " Retail Order";
    }
    if ($Orders["tmp_status"] == 9) {
        echo " App Order";
    }
    echo "\" >";
    if ($Orders["ebay"]) {
        echo " [D]";
    }
    if ($Orders["retail_shop"]) {
        echo " [R]";
    }
    if ($Orders["tmp_status"] == 9) {
        echo " [A]";
    }
    echo "            ";
    if ($stype == "server" || $stype == "remote") {
        echo $Orders["qnt"];
    } else {
        echo $Orders["imei"];
    }
    echo " </td>\n        ";
    if ($stype == "server" || $stype == "remote") {
        echo "            <td>";
        echo $Orders["field"];
        echo "</td>\n            ";
    }
    echo "        <td>";
    echo $Orders["credit"] - $Orders["discount"];
    echo " ";
    echo $Codes[$Orders["codes"]];
    echo "\n        </td>\n        <td>";
    echo $Orders["username"];
    echo "</td>\n\n        <td><input type=\"text\" style=\"width: 300px;\"  id=\"replies\"    value=\"\"\n         name=\"reply[";
    echo $Orders["order_id"];
    echo "]\" placeholder=\"Reply Code\" /></td>\n\n    </tr>\n";
}
echo "\n</tbody></table>\n\n<div class=\"fixedbtn\"><input type=\"button\" name=\"replyorders\" id=\"replyorders\" class=\"btn\"  value=\"";
echo $LNG["reply"];
echo " ";
echo $LNG["order"];
echo "\"\n onclick=\"SubmitForm ('#replyorders','quickreply','#replied','#notification','true','#main_loader');\"/>\n\n <div  style=\"float: right;\">\nResults:\n";
if ($finder && ($search || $service)) {
    if ($search != "" && $service) {
        $shower = mysqli_num_rows(dquery("SELECT `order_id` FROM\n        `tbl_order_imei` WHERE `user_can_c`='1' and service_id='" . $service . "' and imei='" . $search . "'"));
    } else {
        if ($search != "") {
            $shower = mysqli_num_rows(dquery("SELECT `order_id` FROM\n        `tbl_order_imei` WHERE `user_can_c`='1' and  imei='" . $search . "'"));
        } else {
            if ($service) {
                $shower = mysqli_num_rows(dquery("SELECT `order_id` FROM\n        `tbl_order_imei` WHERE `user_can_c`='1' and service_id='" . $service . "'"));
            }
        }
    }
} else {
    if ($pagelimit) {
        $shower = mysqli_num_rows(dquery("SELECT `order_id` FROM\n        `tbl_order_imei` WHERE `user_can_c`='1' limit " . $pagelimit));
    } else {
        $shower = mysqli_num_rows(dquery("SELECT `order_id` FROM\n        `tbl_order_imei` WHERE `user_can_c`='1'"));
    }
}
$tods = mysqli_num_rows(dquery("select order_id from tbl_order_imei where " . $wherecond . "\nuser_can_c='1'"));
if ($shower <= $tods) {
    echo $shower . "/" . $tods;
}
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\nDisplay :\n<select name=\"limitinc\" onchange=\"location.href='main2.php?page=imeiorder&laoddefaultpage=quickreply.php&limitinc='+this.value+'&service='+document.getElementById('sservice').value+'&finder=true';\">\n    <option value=\"100\" ";
if ($limitinc == 100 || !$limitinc) {
    echo "selected";
}
echo ">100</option>\n    <option value=\"200\" ";
if ($limitinc == 200) {
    echo "selected";
}
echo ">200</option>\n    <option value=\"500\" ";
if ($limitinc == 500) {
    echo "selected";
}
echo ">500</option>\n    <option value=\"1000\" ";
if ($limitinc == 1000) {
    echo "selected";
}
echo ">1000</option>\n    <option value=\"9999\" ";
if ($limitinc == 9999) {
    echo "selected";
}
echo ">Show All</option>\n</select>\n</div>\n\n</div>\n</form></div></div>\n<script>\nfunction CheckAll()\n{\n\t\tvar i=document.replied.select.length;\n\t\tvar k;\n\t\tfor (k=0 ; k < i; k++)\n\t\t{\n\t\t\tif(document.replied.select[k].checked==true)\n\t\t\t{\n\t\t\t\tdocument.replied.select[k].checked=false;\n\t\t\t}\n\t\t\telse\n\t\t\t{\n\t\t\t\tdocument.replied.select[k].checked=true;\n\t\t\t}\n\t\t}\n}\nfunction RCheckAll()\n{\n\t\tvar i=document.replied.reject.length;\n\t\tvar k;\n\t\tfor (k=0 ; k < i; k++)\n\t\t{\n\t\t\tif(document.replied.reject[k].checked==true)\n\t\t\t{\n\t\t\t\tdocument.replied.reject[k].checked=false;\n\t\t\t}\n\t\t\telse\n\t\t\t{\n\t\t\t\tdocument.replied.reject[k].checked=true;\n\t\t\t}\n\t\t}\n}\n</script>\n";
if ($extract) {
    echo "</div>\n";
}
echo "\n<br />\n";
$fileverioncheck = "6.1.0";

?>