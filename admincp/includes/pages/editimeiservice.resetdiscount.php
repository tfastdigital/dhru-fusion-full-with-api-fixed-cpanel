<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 403;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/imeiservices.fun.php";
include_once ROOTDIR . "/includes/comm.inc.php";
$services = mysqli_fetch_assoc(dquery("select credit,useasserver from tbl_services_imei\nwhere id='" . $id . "'"));
$Userarr = [];
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n    <div id=\"content_padded\">\n        <script>\n            function filterGroup(val)\n            {\n                location.href='main2.php?page=editimeiservice&defaultloadpage=editimeiservice.resetdiscount.php&id=";
echo $id;
echo "&cgroup='+val;\n            }\n        </script>\n        ";
echo $LNG["client"];
echo " ";
echo $LNG["group"];
echo "        <select name=\"group\" onchange=\"filterGroup(this.value);\" >\n            <option value=\"\">Select</option>\n        ";
$q = dquery("select * from tbl_client_group");
while ($r = mysqli_fetch_assoc($q)) {
    $selected = "";
    if ($cgroup == $r["id"]) {
        $selected = "selected";
    }
    echo "                <option ";
    echo $selected;
    echo " value=\"";
    echo $r["id"];
    echo "\">";
    echo $r["groupname"];
    echo "</option>\n                ";
}
echo "        </select>\n        ";
$defaultcurrency = mysqli_fetch_assoc(dquery("SELECT id from `tbl_currencies` where `default`='1'"));
if ($cgroup) {
    $where = " and tblUsers.client_group='" . $cgroup . "'";
    $wheret = " and group_id='" . $cgroup . "'";
}
$result = dquery("SELECT user_id,username\n,(select groupname from tbl_client_group where id=client_group) as groupname\n,service_id,service_name,price,credit,default_currency FROM\n `tbl_discount_imei`,tbl_services_imei,tblUsers \n where tblUsers.id=tbl_discount_imei.user_id \n and tbl_services_imei.id=tbl_discount_imei.service_id\n  and service_id=" . $id . " and price!='0' " . $where);
echo "        <form id=\"frmedituser\" name=\"\" method=\"post\" enctype=\"multipart/form-data\">\n            <input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n            ";
echo generate_token("form");
echo "            <table id=\"main_tbl\">\n                <thead><tr><th>";
echo $LNG["username"];
echo "</th><th>";
echo $LNG["groupname"];
echo "</th>\n                    <th  width=\"80px\"><div align=\"center\">";
echo $_SESSION["system_default_currency"]["code"];
echo "</div></th>\n\n                    <th></th> </tr></thead>\n                <tbody>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>\n                    <td><a onclick=\"getContect('#tab14','main2.php?page=edituser.imeiservice','";
    echo $row["user_id"];
    echo "','','#tabcontent',true,'#main_loader');\">\n                            ";
    echo $row["username"];
    echo "</a></td><td>";
    echo $row["groupname"];
    echo "</td>\n\n                    <td></td>\n                    </tr>\n                    ";
}
$result = dquery("select  *,(select groupname from tbl_client_group\n    where id=group_id) as clientgroup from tbl_client_group_price\n    where service_id='" . $id . "' and discount!=0 and service_type='imei'\n    " . $wheret);
while ($r = mysqli_fetch_assoc($result)) {
    $u = dquery("select * from tblUsers where client_group='" . $r["group_id"] . "'");
    while ($ru = mysqli_fetch_assoc($u)) {
        $sql1 = dquery("SELECT * from `tbl_currencies` \n          order by `default` desc");
        while ($row1 = mysqli_fetch_assoc($sql1)) {
            if ($row1["id"] == $ru["default_currency"] && $ru["default_currency"] == $r["currency_id"] && !in_array($ru["id"], $Userarr)) {
                echo "                                <tr>\n                                    <td>";
                echo $ru["username"];
                echo "</td>\n                                    <td>";
                echo $r["clientgroup"];
                echo "</td>\n                                    <td><div align=\"center\">\n                                            ";
                if ($_SESSION["system_default_currency"]["id"] == $ru["default_currency"]) {
                    echo "                    <span style=\"text-decoration:line-through; color: #d1d1d1;\">";
                    echo $services["credit"];
                    echo "</span>\n                                                ";
                    $userdisco = mysqli_fetch_assoc(dquery("select discount,price\n                    from tbl_discount_imei where user_id='" . $ru["id"] . "' and \n                    service_id='" . $id . "'"));
                    $Price = getIMEIServicesNew("", md5($id), $ru[id], true, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", 1);
                    $credit = $Price["credit"];
                    if (!$userdisco["discount"]) {
                        $userdisco["discount"] = $r["discount"];
                    }
                    if (0 < $userdisco["price"]) {
                        echo $userdisco["price"];
                    } else {
                        echo round($credit, $precision);
                    }
                } else {
                    echo "        <span style=\"text-decoration:line-through;color: #d1d1d1;\">";
                    echo round($credit, 2);
                    echo "</span>\n                                                ";
                    $userdisco = mysqli_fetch_assoc(dquery("select discount,price\n            from tbl_discount_imei where user_id='" . $ru["id"] . "' and \n            service_id='" . $id . "'"));
                    $Price = getIMEIServicesNew("", md5($id), $ru[id], true, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", 1);
                    $credit = $Price["credit"];
                    if (!$userdisco["discount"]) {
                        $userdisco["discount"] = $r["discount"];
                    }
                    if (0 < $userdisco["price"]) {
                        echo $userdisco["price"];
                    } else {
                        echo round($credit, $precision);
                    }
                }
                echo "                                        </div>\n                                    </td>\n\n                                </tr>\n                                ";
            }
        }
    }
}
echo "                </tbody>\n            </table>\n\n\n        </form></div></div>\n<div id=\"page_info\" classs=\"page_info\">\n    <li>List all discounted user list currency wise</li>\n</div>";
$fileverioncheck = "6.1.0";
echo "<script>\n    \$( document ).ready(function() {\n        \$(\".colorpicker\").hide();\n    });\n\n</script>\n";

?>