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
include_once ROOTDIR . "/includes/customfield.fun.inc.php";
if (!$limitinc) {
    $pagelimit = 100;
} else {
    $pagelimit = $limitinc;
}
echo "    <style>\n        .autoaccept {\n            position: relative;\n            display: inline-block;\n        }\n\n        /* Tooltip text */\n        .autoaccept .autotext {\n            visibility: hidden;\n            width: 120px;\n            background-color: black;\n            color: #fff;\n            text-align: center;\n            padding: 5px 0;\n            border-radius: 6px;\n\n            /* Position the tooltip text - see examples below! */\n            position: absolute;\n            z-index: 1;\n        }\n\n        /* Show the tooltip text when you mouse over the tooltip container */\n        .autoaccept:hover .autotext {\n            visibility: visible;\n        }\n    </style>\n";
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
$Codes = [];
$c = dquery("select id,code from tbl_currencies");
while ($r = mysqli_fetch_assoc($c)) {
    $Codes[$r["id"]] = $r["code"];
}
if ($stype == "remote") {
    $whereserv = " server=2";
    $commonwhere = " and useasserver=2";
} else {
    if ($stype == "server") {
        $whereserv = " server=1";
        $commonwhere = " and useasserver=1";
    } else {
        $whereserv = " server=0";
        $commonwhere = " and useasserver=0";
    }
}
if ($stype == "server" || $stype == "remote") {
    $q = dquery("select order_id,service_id,ebay,imei,retail_shop,tmp_status,\n(select service_name from tbl_services_imei where id=service_id) as service\n,(SELECT GROUP_CONCAT(concat(fieldname,'=>',value) separator '<br />') from tbl_customfieldsvalues\nwhere servicetype='server'\nand relid=tbl_order_imei.order_id) as field\n,\n(select default_currency\nfrom tblUsers where tblUsers.id=user_id)  as codes,\nIF(qnt=0,1,qnt) as qnt,\ndate,TRUNCATE(credit,2) as credit,TRUNCATE(discount,2) as discount,\n(select username from tblUsers where id=user_id) as username from\ntbl_order_imei where user_can_c='1' and " . $whereserv . " " . $where . "  " . $orderby . " limit " . $pagelimit);
} else {
    $q = dquery("select order_id,service_id,ebay,imei,retail_shop,tmp_status,\n(select service_name from tbl_services_imei where id=service_id) as service\n,\n(select default_currency\nfrom tblUsers where tblUsers.id=user_id)  as codes,\n\nIF(qnt=0,1,qnt) as qnt,\ndate,TRUNCATE(credit,2) as credit,TRUNCATE(discount,2) as discount,\n(select username from tblUsers where id=user_id) as username from\ntbl_order_imei where user_can_c='1' and " . $whereserv . " " . $where . "  " . $orderby . " limit " . $pagelimit);
}
$_SESSION["once_accepted"] = true;
if ($extract) {
    if (!isset($show)) {
        if ($sservice) {
            $QUER = "and service_id='" . $sservice . "'";
        }
        if ($stype == "server") {
            $order = dquery("SELECT `order_id` FROM `tbl_order_imei`\n                               WHERE  `user_can_c`='1' " . $QUER . " and `server`=1");
            while ($rows = mysqli_fetch_assoc($order)) {
            }
            if ($_order) {
                $order = implode(",", $_order);
                $_SESSION["tmp_orders"] = $order;
            } else {
                $order = $_SESSION["tmp_orders"];
            }
        } else {
            $order = dquery("SELECT `order_id` FROM `tbl_order_imei`\n                               WHERE  `user_can_c`='1' " . $QUER . "  and `server`=0");
        }
        $_order[] = $rows["order_id"];
    } else {
        $order = $_SESSION["tmp_orders"];
    }
    $laoddefaultpage = "quickreply.php";
    echo "    <div id=\"tabcontent\">\n    ";
    include "quickacceptedorder.php";
    exit;
}
echo "\n    <style>\n\n        .boxes{\n            width: 10px;\n            height: 10px;\n            float:left;\n            margin-top: 4px;\n            margin-right: 4px;\n        }\n    </style>\n    <div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n\n\n<form method=\"post\" class=\"mb-1\">\n\n    <fieldset class=\"search-form mb-1\">\n        <legend>Manual Reply Search</legend>\n        <div class=\"d-flex flex-wrap\">\n            ";
$GROUPNAME = "";
echo "            <div class=\"flex-grow-1 mb-1\">\n            <select name=\"service\" id=\"sservice\" class=\"chosen\">\n                <option value=\"\">Select Service</option>\n                ";
$sql = dquery("SELECT service_id,\n    (SELECT service_name FROM tbl_services_imei\n    WHERE id=service_id   )\n    AS service from tbl_order_imei\n    where user_can_c='1' and " . $whereserv . "  group by service_id");
while ($rows = mysqli_fetch_assoc($sql)) {
    if ($rows["service"]) {
        echo "                        <option ";
        if ($service == $rows["service_id"]) {
            echo "selected";
        }
        echo "                            value=\"";
        echo $rows["service_id"];
        echo "\" >";
        echo $rows["service"];
        echo "</option>\n                        ";
    }
}
echo "            </select>\n            </div>\n\n\n            <div>\n\n            <input type=\"hidden\" name=\"loaddefaultpage\" value=\"imeiorder.replied.php\" />\n            ";
if ($stype != "server" && $stype != "remote") {
    echo "                <input type=\"text\" class=\"txt mr-1\"  style=\"width: 150px\"  name=\"search\" placeholder=\"Search IMEI\" />\n                ";
}
echo "\n\n            <input type=\"submit\" class=\"btn btn-primary\" name=\"finder\" value=\"";
echo $LNG["search"];
echo "\" />\n\n            <input type=\"button\" class=\"btn\" name=\"extract\"\n                   onclick=\"load_subpage('main2.php?page=imeiorder.replied&extract=true";
if ($stype == "server") {
    echo "&stype=server";
} else {
    if ($stype == "remote") {
        echo "&stype=remote";
    }
}
echo "&sservice='+document.getElementById('sservice').value+'','";
echo $LNG["extractall"];
echo "');\" value=\"";
echo $LNG["extractall"];
echo "\" />\n\n            </div>\n\n        </div>\n\n\n\n    </fieldset>\n\n    <div class=\"text-muted text-right\">\n        <i> ";
echo $LNG["quickreplyinfo"];
echo " </i>\n\n        <select name=\"rpl\" class=\"ml-1\"  onchange=\"setReply(this.value);\">\n            <option value=\"\"> ";
echo $LNG["reply"];
echo " Code for all</option>\n            ";
$dt = explode("\n", $config["orderreplyword"]);
foreach ($dt as $d) {
    $d = trim($d);
    echo "                <option value=\"";
    echo $d;
    echo "\">";
    echo $d;
    echo "</option>\n                ";
}
echo "        </select>\n\n    </div>\n\n\n</form>\n <div class=\"clear\"></div>\n\n<script>\nfunction setReply(val)\n{\n    var len=document.replied.replies.length;\n\tfor(var i=0;i<len;i++)\n\t{\n        document.replied.replies[i].value=val;\n\t}\n}\n</script>\n\n<form id=\"replied\" name=\"replied\" method=\"post\" >\n";
echo generate_token("form");
echo "<table id=\"main_tbl\" class=\"quicksort\">\n<thead>\n  <tr>\n        <th>";
echo $LNG["id"];
echo "</th>\n        <th>";
echo $LNG["servicename"];
echo "</th>\n        <th>";
echo $LNG["date"];
echo " </th>\n      <th class=\"sorter-false\">\n          ";
if ($stype == "server" || $stype == "remote") {
    echo "              ";
    echo $LNG["qnt"];
    echo "              ";
} else {
    echo "              ";
    echo $LNG["imei"];
    echo "          ";
}
echo "      </th>\n      ";
if ($stype == "server" || $stype == "remote") {
    echo "          <th>";
    echo $LNG["field"];
    echo "</th>\n          ";
}
echo "        <th  class=\"sorter-false\">";
echo $LNG["total"] . " " . $LNG["credit"];
echo "        <small>(";
echo $LNG["user"];
echo "/";
echo $LNG["reseller"];
echo ")</small></th>\n        <th>";
echo $LNG["username"];
echo " </th>\n\n        <th  class=\"sorter-false\">\n            Reply\n        </th>\n        <th class=\"text-left sorter-false\"> <label for=\"rrj\"> <input type=\"checkbox\"\n        id=\"rrj\" name=\"reject\"\n        onclick=\"RCheckAll(this);\" />  ";
echo $LNG["reject"];
echo "</label>\n        </th>\n        <th  class=\"text-left sorter-false\">\n            <label  for=\"acrj\">\n        <input type=\"checkbox\"\n        id=\"acrj\" name=\"reject\"\n        onclick=\"ACheckAll(this);\" />  New</label></th>\n\n  </tr>\n</thead>\n<tbody>\n";
while ($r = mysqli_fetch_assoc($q)) {
    echo "    <tr id=\"hide_";
    echo $r["order_id"];
    echo "\">\n        <td> <a class=\"default_dg_a2 \" href=\"javascript:load_fromsubpage('edituser.editimeiorder&id=";
    echo $r["order_id"];
    echo "','";
    echo $stype == "server" ? "SERVER" : "IMEI";
    echo " #";
    echo $r["order_id"];
    echo "')\">#";
    echo $r["order_id"];
    echo "</a> </td>\n        <td><div class=\"boxes\" style=\"background-color:";
    echo $r["colortag"];
    echo "\"></div>\n            ";
    if ($stype == "server" || $stype == "remote") {
        echo "               <i class=\"fa fa-exclamation-triangle  tooltipcolor\"> ";
        echo $r["service"];
        echo "                   <div class=\"tooltiptext\">\n               ";
        $custom = getCustomFields("serviceimei", $r["service_id"], $r["order_id"]);
        foreach ($custom as $c => $v) {
            if ($v[value]) {
                echo $v["name"] . " : " . $v["value"] . "<br />";
            }
        }
        echo "</div>\n               </i>\n                ";
    } else {
        echo $r["service"];
    }
    echo "        </td>\n ";
    if (!$supplieraccess) {
        echo "        <td class=\"nowrap\">";
        echo $r["date"];
        echo "</td>\n     <td  title=\"";
        if ($r["ebay"]) {
            echo "Direct Order";
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
        echo "         ";
        if ($stype == "server" || $stype == "remote") {
            echo "             ";
            echo $r["qnt"];
            echo "             ";
        } else {
            echo "             ";
            echo $r["imei"];
            echo "             ";
        }
        echo "     </td>\n        ";
        if ($stype == "server" || $stype == "remote") {
            echo "            <td>";
            echo $r["field"];
            echo "</td>\n            ";
        }
        echo "        <td>";
        echo round($r["credit"] - $r["discount"], 2);
        echo "       ";
        echo $Codes[$r["codes"]];
        echo "</td>\n        <td>";
        echo $r["username"];
        echo "</td>\n ";
    }
    echo "\n        <td style=\"position: relative\">\n        <input type=\"text\"   style=\"width:200px\" placeholder=\"Reply Code\"\n        id=\"replies\" class=\"rep_";
    echo $r["order_id"];
    echo "\"\n         name=\"reply[";
    echo $r["order_id"];
    echo "]\" /><input title=\"Clear\"  type=\"button\" style=\"background: transparent;min-width: 20px;margin-left: -36px;position: absolute;top: 7px;color: black;\"\n         onclick=\"javascript: \$('.rep_";
    echo $r["order_id"];
    echo "').val('');\" value=\"X\" /></td>\n        <td class=\"text-left\">\n        <input type=\"checkbox\" name=\"reject[";
    echo $r["order_id"];
    echo "]\"\n         class=\"reject\" value=\"";
    echo $r["order_id"];
    echo "\" /> <label></label>\n         </td>\n         <td class=\"text-left\">\n         <input type=\"checkbox\" name=\"accept[";
    echo $r["order_id"];
    echo "]\"\n         class=\"accept\" value=\"";
    echo $r["order_id"];
    echo "\" /><label></label> </td>\n\n    </tr>\n    ";
}
echo "</tbody></table>\n<div class=\"fixedbtn\">\n\n<input type=\"button\" name=\"replyorders\" id=\"replyorders\" class=\"btn\"  value=\"";
echo $LNG["reply"];
echo " ";
echo $LNG["selected"];
echo "\"\n onclick=\"SubmitForm ('#replyorders','imeireplied','#replied','#notification','true','#main_loader');\" >\n\n <div style=\"float: right;\">\n\n\nResults:\n";
if ($finder && ($search || $service)) {
    if ($search != "" && $service) {
        $shower = mysqli_num_rows(dquery("SELECT `order_id` FROM\n        `tbl_order_imei` WHERE `user_can_c`='1' and service_id='" . $service . "' and imei='" . $search . "'"));
    } else {
        if ($search != "") {
            $shower = mysqli_num_rows(dquery("SELECT `order_id` FROM\n        `tbl_order_imei` WHERE `user_can_c`='1' and imei='" . $search . "'"));
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
$tods = mysqli_num_rows(dquery("select order_id from tbl_order_imei\n                                    where user_can_c='1'"));
if ($shower < $tods) {
    echo $shower . "/" . $tods;
}
echo "\n &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n\nDisplay :\n<select name=\"limitinc\" onchange=\"location.href='main2.php?page=imeiorder&laoddefaultpage=imeiorder.replied.php&limitinc='+this.value+'&service='+document.getElementById('sservice').value+'&finder=true';\">\n    <option value=\"100\" ";
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
echo ">Show All</option>\n</select>\n\n</div>\n\n\n</div>\n</form></div></div>\n<script>\nfunction CheckAll()\n{\n\t\tvar i=document.replied.select.length;\n\t\tvar k;\n\t\tfor (k=0 ; k < i; k++)\n\t\t{\n\t\t\tif(document.replied.select[k].checked==true)\n\t\t\t{\n\t\t\t\tdocument.replied.select[k].checked=false;\n\t\t\t}\n\t\t\telse\n\t\t\t{\n\t\t\t\tdocument.replied.select[k].checked=true;\n\t\t\t}\n\t\t}\n}\nfunction ACheckAll(o)\n{\n        if(\$(o).is(\":checked\")){\n            \$('.accept').prop({'checked':true});\n        }\n        else{\n            \$('.accept').prop({'checked':false});\n        }\n\n}\nfunction RCheckAll(o)\n{\n\t\tif(\$(o).is(\":checked\")){\n            \$('.reject').prop({'checked':true});\n        }\n        else{\n            \$('.reject').prop({'checked':false});\n        }\n}\n</script>\n";
$fileverioncheck = "6.1.0";

?>