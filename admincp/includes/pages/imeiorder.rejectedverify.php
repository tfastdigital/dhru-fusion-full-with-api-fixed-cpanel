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
if ($stype == "remote") {
    $whereserv = " `server`='2'";
    $commonwhere = " and useasserver=2";
} else {
    if ($stype == "server") {
        $whereserv = " `server`='1'";
        $commonwhere = " and useasserver=1";
    } else {
        $whereserv = " `server`='0'";
        $commonwhere = " and useasserver=0";
    }
}
$q = dquery("select order_id,service_id,apierror,ebay,verifydata,imei,retail_shop,tmp_status,\r\n(select service_name from tbl_services_imei where id=service_id) as service,\r\nIF(\r\n(select value from tbl_apiservers where gateway=`ORDERAPI` and setting='customname')!='',\r\nconcat(\r\n(select value from tbl_apiservers where gateway=`ORDERAPI` and setting='customname'),' [',\r\n(select value from tbl_apiservers where gateway=`ORDERAPI` and setting='name'),']'\r\n),\r\n(select value from tbl_apiservers where gateway=`ORDERAPI` and setting='name') \r\n) as service1,\r\n(select colortag from tbl_services_imei where id=service_id) as colortag,\r\nreseller_id,TRUNCATE(reseller_credit,2) as reseller_credit,\r\n(SELECT (SELECT code from tbl_currencies\r\nwhere tbl_currencies.id=(select default_currency \r\nfrom tblUsers where tblUsers.id=user_id)   ) ) as codes,\r\nTRUNCATE(reseller_discount,2) as reseller_discount,\r\nIF(qnt=0,1,qnt) as qnt,\r\ndate,TRUNCATE(credit,2) as credit,TRUNCATE(discount,2) as discount,\r\n(select username from tblUsers where id=user_id) as username from \r\ntbl_order_imei where user_can_c='8' and " . $whereserv . " " . $where . "  " . $orderby . " limit " . $pagelimit);
$_SESSION["once_accepted"] = true;
echo "    <style>\r\n        textarea{\r\n            width: 150px !important;\r\n        }\r\n    </style>\r\n    <script>\r\n        function ConnectToAPI()\r\n        {\r\n            var orders='';\r\n            \$('.accept').each(function() {\r\n                if (\$(this).is(\":checked\")) {\r\n                    orders+=\$(this).attr('value')+',';\r\n                }\r\n            });\r\n            orders=orders.trim(\",\");\r\n            if(orders){\r\n                \$.post(\"includes/pages/checkorder.php?o=\" + orders, function (data, status) {\r\n                    var perform=true;\r\n                    if(data!='OK') {\r\n                        perform=false;\r\n                        if(confirm(\"Current selection contains more than one Service Are you sure want to Connect ?\")){\r\n                            perform=true;\r\n                        }\r\n                    }\r\n                    if(perform){\r\n                        load_subpage('main2.php?page=connectapi&o='+orders,'Connect API');\r\n                    }\r\n                });\r\n            }else{\r\n                alert(\"select at-least one order to connect with APi\");\r\n            }\r\n        }\r\n        function checkAll(){\r\n            if(\$(\"#checkall\").is(\":checked\"))\r\n            {\r\n                \$(\".accept\").prop('checked',true);\r\n            }else{\r\n                \$(\".accept\").prop('checked',false);\r\n            }\r\n        }\r\n    </script>\r\n    <style>\r\n        .tooltip {\r\n            position: relative;\r\n            display: inline-block;\r\n        }\r\n        .tooltip .tooltiptext {\r\n            visibility: hidden;\r\n            width: 180px;\r\n            background-color: white;\r\n            border: 1px solid #ccc;\r\n            color: #0a0a0a;\r\n            text-align: left;\r\n            padding: 5px 0;\r\n            font-size: 12px;\r\n            border-radius: 6px;\r\n            position: absolute;\r\n            z-index: 1;\r\n        }\r\n        .tooltip:hover .tooltiptext {\r\n            visibility: visible;\r\n        }\r\n        .boxes{\r\n            width: 10px;\r\n            height: 10px;\r\n            float:left;\r\n            margin-top: 4px;\r\n            margin-right: 4px;\r\n        }\r\n    </style>\r\n    <div id=\"notification\"></div>\r\n    <div id=\"content\">\r\n        <div id=\"content_padded\">\r\n\r\n            <h2 style=\"float:left\">\r\n                <span class=\"groupstabesheadertext\">Verify before Reject</span>\r\n            </h2>\r\n\r\n            <form method=\"post\" style=\"float: right;\">\r\n                <input type=\"hidden\" name=\"loaddefaultpage\" value=\"imeiorder.rejectedverify.php\" />\r\n                ";
if ($stype != "server" && $stype != "remote") {
    echo "                    <input type=\"text\" name=\"search\"  class=\"txt medium\"  placeholder=\"Enter IMEI Number\"/>\r\n                    ";
}
echo "                <input type=\"submit\" class=\"btn btn-primary\"  name=\"finder\" value=\"";
echo $LNG["search"];
echo "\" />\r\n            </form>\r\n            <div class=\"clear\"></div>\r\n            <br />\r\n            <script>\r\n                function setReply(val)\r\n                {\r\n                    var len=document.replied.replies.length;\r\n                    for(var i=0;i<len;i++)\r\n                    {\r\n                        document.replied.replies[i].value=val;\r\n                    }\r\n                }\r\n            </script>\r\n\r\n            <form id=\"replied\" name=\"replied\" method=\"post\" >\r\n                ";
echo generate_token("form");
echo "                <table id=\"main_tbl\" >\r\n                    <thead>\r\n                    <tr>\r\n                        <th>\r\n                            <lable><input type=\"checkbox\" value=\"1\" id=\"checkall\"\r\n                                          onclick=\"checkAll()\"  />All</lable>\r\n                        </th>\r\n                        <th>";
echo $LNG["id"];
echo "</th>\r\n                        <th>";
echo $LNG["servicename"];
echo "</th>\r\n                        <th>";
echo $LNG["date"];
echo " </th>\r\n                        <th>\r\n                            ";
if ($stype == "server" || $stype == "remote") {
    echo "                                ";
    echo $LNG["qnt"];
    echo "                                ";
} else {
    echo "                                ";
    echo $LNG["imei"];
    echo "                            ";
}
echo "                        </th>\r\n                        <th>";
echo $LNG["total"] . " " . $LNG["credit"];
echo "                            <small>";
echo $LNG["user"];
echo "/";
echo $LNG["reseller"];
echo "</small></th>\r\n                        <th>";
echo $LNG["username"];
echo " </th>\r\n                        <th>APi ";
echo $LNG["error"];
echo "</th>\r\n                        <th>";
echo $LNG["reply"];
echo "                        </th>\r\n                        <th><input type=\"checkbox\" id=\"rrj\" name=\"reject\"\r\n                                   onclick=\"RCheckAll(this);\" /><label for=\"rrj\">";
echo $LNG["reject"];
echo "</label>\r\n                        </th>\r\n                        <th></th>\r\n                    </tr>\r\n                    </thead>\r\n                    <tbody>\r\n                    ";
while ($r = mysqli_fetch_assoc($q)) {
    echo "                        <tr id=\"hide_";
    echo $r["order_id"];
    echo "\">\r\n                            <td style=\"max-width: 20px !important;\"><input type=\"checkbox\" style=\"max-width: 20px !important;\" class=\"accept\" name=\"accept[";
    echo $r["order_id"];
    echo "]\" value=\"";
    echo $r["order_id"];
    echo "\" /></td>\r\n                            <td> <a class=\"default_dg_a2 \" href=\"javascript:load_fromsubpage('edituser.editimeiorder&id=";
    echo $r["order_id"];
    echo "','";
    echo $stype == "server" ? "SERVER" : "IMEI";
    echo " #";
    echo $r["order_id"];
    echo "')\">";
    echo $r["order_id"];
    echo "</a> </td>        <td><div class=\"boxes\" style=\"background-color:";
    echo $r["colortag"];
    echo "\"></div>\r\n                                ";
    if ($stype == "server" || $stype == "remote") {
        echo "                                    <div class=\"tooltip\"> ";
        echo wordwrap($r["service"], 20, "<br />");
        echo "                                        <div class=\"tooltiptext\">\r\n                                            ";
        $custom = getCustomFields("serviceimei", $r["service_id"], $r["order_id"]);
        foreach ($custom as $c => $v) {
            if ($v[value]) {
                echo $v["name"] . " : " . $v["value"] . "<br />";
            }
        }
        echo "</div>\r\n                                    </div>\r\n                                    ";
    } else {
        echo wordwrap($r["service"], 150, "<br />");
    }
    echo "\r\n                            </td>\r\n                            ";
    if (!$supplieraccess) {
        echo "                                <td>";
        echo $r["date"];
        echo "</td>\r\n                                <td  title=\"";
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
        echo "                                    ";
        if ($stype == "server" || $stype == "remote") {
            echo "                                        ";
            echo $r["qnt"];
            echo "                                        ";
        } else {
            echo "                                        ";
            echo $r["imei"];
            echo "                                        ";
        }
        echo "                                </td>\r\n                                <td>";
        echo $r["credit"] - $r["discount"];
        echo "                                    ";
        if ($r["reseller_id"]) {
            echo " / " . ($r["reseller_credit"] - $r["reseller_discount"]);
        }
        echo " ";
        echo $r["codes"];
        echo "</td>\r\n                                <td>";
        echo $r["username"];
        echo "</td>\r\n                            ";
    }
    echo "                            ";
    $verify = json_decode($r["verifydata"], true);
    echo "                            <td>\r\n                                ";
    echo $r["apierror"];
    echo "                            </td>\r\n                            <td>\r\n                               <textarea  cols=\"10\" rows=\"3\"\r\n                                          id=\"replies\" class=\"rep_";
    echo $r["order_id"];
    echo "\"\r\n                                          name=\"reply[";
    echo $r["order_id"];
    echo "]\" >";
    echo $verify["message"];
    echo "</textarea></td>\r\n                            <td>\r\n                                <input type=\"checkbox\" name=\"reject[";
    echo $r["order_id"];
    echo "]\"\r\n                                       class=\"reject\" value=\"";
    echo $r["order_id"];
    echo "\" /> <label></label>\r\n                            </td>\r\n\r\n                            <td></td>\r\n                        </tr>\r\n                        ";
}
echo "                    </tbody></table>\r\n                <div class=\"fixedbtn\">\r\n                    <input type=\"button\" name=\"connecttoapi\" id=\"connecttoapi\" class=\"btn\"  value=\"";
echo $LNG["connect"];
echo " to APi\"\r\n                           onclick=\"ConnectToAPI();\" >\r\n                    <input type=\"button\" name=\"replyorders\" id=\"replyorders\" class=\"btn\"  value=\"";
echo $LNG["reply"];
echo " ";
echo $LNG["selected"];
echo "\"\r\n                           onclick=\"SubmitForm ('#replyorders','imeiverifyrejected','#replied','#notification','true','#main_loader');\" >\r\n\r\n\r\n                    <input type=\"button\" name=\"settonew\" id=\"settonew\" class=\"btn\"  value=\"";
echo $LNG["set"];
echo " Back ";
echo $LNG["new"];
echo "\"\r\n                           onclick=\"SubmitForm ('#settonew','imeisetbacknew','#replied','#notification','true','#main_loader');\" >\r\n\r\n\r\n                    <div style=\"float: right;\">\r\n                        Results:\r\n                        ";
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
echo "\r\n                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n\r\n                        Display :\r\n                        <select name=\"limitinc\" onchange=\"location.href='main2.php?page=imeiorder&laoddefaultpage=imeiorder.rejectedverify.php&limitinc='+this.value+'&service='+document.getElementById('sservice').value+'&finder=true';\">\r\n                            <option value=\"100\" ";
if ($limitinc == 100 || !$limitinc) {
    echo "selected";
}
echo ">100</option>\r\n                            <option value=\"200\" ";
if ($limitinc == 200) {
    echo "selected";
}
echo ">200</option>\r\n                            <option value=\"500\" ";
if ($limitinc == 500) {
    echo "selected";
}
echo ">500</option>\r\n                            <option value=\"1000\" ";
if ($limitinc == 1000) {
    echo "selected";
}
echo ">1000</option>\r\n                            <option value=\"9999\" ";
if ($limitinc == 9999) {
    echo "selected";
}
echo ">Show All</option>\r\n                        </select>\r\n\r\n                    </div>\r\n\r\n\r\n                </div>\r\n            </form></div></div>\r\n    <script>\r\n        function CheckAll()\r\n        {\r\n            var i=document.replied.select.length;\r\n            var k;\r\n            for (k=0 ; k < i; k++)\r\n            {\r\n                if(document.replied.select[k].checked==true)\r\n                {\r\n                    document.replied.select[k].checked=false;\r\n                }\r\n                else\r\n                {\r\n                    document.replied.select[k].checked=true;\r\n                }\r\n            }\r\n        }\r\n        function ACheckAll(o)\r\n        {\r\n            if(\$(o).is(\":checked\")){\r\n                \$('.accept').prop({'checked':true});\r\n            }\r\n            else{\r\n                \$('.accept').prop({'checked':false});\r\n            }\r\n\r\n        }\r\n        function RCheckAll(o)\r\n        {\r\n            if(\$(o).is(\":checked\")){\r\n                \$('.reject').prop({'checked':true});\r\n            }\r\n            else{\r\n                \$('.reject').prop({'checked':false});\r\n            }\r\n        }\r\n    </script>\r\n";
$fileverioncheck = "6.1.0";
function get_string_between($string, $start, $end)
{
    $string = " " . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) {
        return "";
    }
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

?>