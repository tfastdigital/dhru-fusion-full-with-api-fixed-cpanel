<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($action == "delete") {
}
$pageid = 412;
checkPagePermission($pageid);
licince\chkLitePlus();
licince\chklite();
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getClientsDetails($id);
if ($delete) {
    dquery("delete from tbl_subscribers where id='" . $delete . "'");
}
if ($clientDetails["userstatus"] != "0") {
    echo "<div id=\"notification1\" class=\"info\">";
    if ($clientDetails["userstatus"] == "1") {
        $status = $LNG["thisaccounthasbeen"] . " " . $LNG["blocked"];
    } else {
        if ($clientDetails["userstatus"] == "2") {
            $status = $LNG["thisaccounthasbeen"] . " " . $LNG["inactive"];
        }
    }
    echo "<span><strong>";
    echo $status;
    echo "</strong></span></div>";
}
echo "<script>\n\$(document).ready(function() {\n    \$('#imei').change(function() {\n        var str;\n\n        str = \$(this).val();\n\n         if(str!=''){\n                    \$.get(\"includes/pages/getSubprice.php\", { id: str, service: \"imei\" ,user:\"";
echo $id;
echo "\"},\n                     function(data){\n                        var substr = data.split('|');\n                        \$(\"#price\").html(substr[0]+\" ";
echo $clientDetails["currency"]["code"];
echo "\");\n                        \$(\"#days\").html(substr[1]+\" days\");\n                    });\n              \$(\"#file\").val(\"\");\n              \$(\"#server\").val(\"\");\n              \$(\"#product\").val(\"\");\n          }\n    });\n    \$('#file').change(function() {\n\n        var str;\n        str = \$(this).val();\n         if(str!=''){\n                    \$.get(\"includes/pages/getSubprice.php\", { id: str, service: \"file\" ,user:\"";
echo $id;
echo "\"},\n                     function(data){\n                        var substr = data.split('|');\n                        \$(\"#price\").html(substr[0]+\" ";
echo $clientDetails["currency"]["code"];
echo "\");\n                        \$(\"#days\").html(substr[1]+\" days\");\n                    });\n              \$('#imei').val(\"\");\n              \$('#server').val(\"\");\n              \$(\"#product\").val(\"\");\n          }\n    });\n    \$('#server').change(function() {\n        var str;\n\n        str = \$(this).val();\n\n         if(str!=''){\n                    \$.get(\"includes/pages/getSubprice.php\", { id: str, service: \"server\" ,user:\"";
echo $id;
echo "\"},\n                     function(data){\n                        var substr = data.split('|');\n                        \$(\"#price\").html(substr[0]+\" ";
echo $clientDetails["currency"]["code"];
echo "\");\n                        \$(\"#days\").html(substr[1]+\" days\");\n                    });\n              \$('#file').val(\"\");\n              \$('#imei').val(\"\");\n              \$(\"#product\").val(\"\");\n          }\n    });\n    \$('#product').change(function() {\n        var str;\n\n        str = \$(this).val();\n\n         if(str!=''){\n                    \$.get(\"includes/pages/getSubprice.php\", { id: str, service: \"product\" ,user:\"";
echo $id;
echo "\"},\n                     function(data){\n                        var substr = data.split('|');\n                        \$(\"#price\").html(substr[0]+\" ";
echo $clientDetails["currency"]["code"];
echo "\");\n                        \$(\"#days\").html(substr[1]+\" days\");\n                    });\n              \$('#file').val(\"\");\n              \$('#imei').val(\"\");\n              \$('#server').val(\"\");\n          }\n    });\n    \$('#account').click(function() {\n        var str;\n\n        str = \$(this).attr(\"checked\");\n       if(str){\n        \$('#hide').hide();\n       }else{\n        \$('#hide').show();\n       }\n    });\n\n});\n</script>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<div  class=\"groupstabes\">\n      <h2>\n        <span class=\"groupstabesheadertext\">";
echo $LNG["service"];
echo "s</span>\n      </h2>\n    <div class=\"groupstabescontant\">\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\"/>\n<div>\n<table class=\"form\">\n";
if (!$OnlyEcommerce) {
    if (!$IsFileOnly) {
        echo "<tr>\n    <td class=\"fieldlabel\">";
        echo $LNG["imei"];
        echo "</td><td class=\"fieldarea\">\n    <select name=\"imei\" id=\"imei\">\n    <option value=\"\">";
        echo $LNG["select"];
        echo "</option>\n    ";
        $sql = dquery("SELECT id,service_name FROM tbl_services_imei \nWHERE active='1' AND subscribe='1' and useasserver=0");
        while ($row = mysqli_fetch_assoc($sql)) {
            echo "    <option value=\"";
            echo $row["id"];
            echo "\">";
            echo $row["service_name"];
            echo "</option>\n    ";
        }
        echo "</select>\n    </td>\n</tr>\n";
    }
    echo "<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["file"];
    echo "</td><td class=\"fieldarea\">\n    <select name=\"file\" id=\"file\">\n    <option value=\"\">";
    echo $LNG["select"];
    echo "</option>\n    ";
    $sql = dquery("SELECT id,service_name FROM tbl_services_file WHERE active='1' AND subscribe='1'");
    while ($row = mysqli_fetch_assoc($sql)) {
        echo "    <option value=\"";
        echo $row["id"];
        echo "\">";
        echo $row["service_name"];
        echo "</option>\n    ";
    }
    echo "</select>\n    </td>\n</tr>\n\n";
    if (!$IsFileOnly) {
        echo "<tr>\n    <td class=\"fieldlabel\">";
        echo $LNG["server"];
        echo "</td><td class=\"fieldarea\">\n    <select name=\"server\" id=\"server\">\n    <option value=\"\">";
        echo $LNG["select"];
        echo "</option>\n    ";
        $sql = dquery("SELECT id,service_name FROM tbl_services_imei WHERE active='1' AND subscribe='1'\nand useasserver=1");
        while ($row = mysqli_fetch_assoc($sql)) {
            echo "    <option value=\"";
            echo $row["id"];
            echo "\">";
            echo $row["service_name"];
            echo "</option>\n";
        }
        echo "</select>\n    </td>\n</tr>\n";
    }
}
echo "\n";
if (!$IsFileOnly) {
    echo "<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["product"];
    echo "</td><td class=\"fieldarea\">\n<select name=\"product\" id=\"product\">\n    <option value=\"\">";
    echo $LNG["select"];
    echo "</option>\n    ";
    $sql = dquery("SELECT id,service_name FROM tbl_products WHERE active='1' AND subscribe='1'");
    while ($row = mysqli_fetch_assoc($sql)) {
        echo "    <option value=\"";
        echo $row["id"];
        echo "\">";
        echo $row["service_name"];
        echo "</option>\n    ";
    }
    echo "</select>\n    </td>\n</tr>\n";
}
echo "</table>\n </div>\n\n <div>\n\n<table>\n<tr>\n   <td class=\"fieldlabel\">";
echo $LNG["price"];
echo " </td>  <td class=\"fieldarea\"> <span id=\"price\" class=\"highlighted\"></span>     </td>\n</tr>\n<tr>\n   <td class=\"fieldlabel\">";
echo $LNG["period"];
echo " </td>  <td class=\"fieldarea\">  <span id=\"days\" class=\"highlighted\"></span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">  </td>\n    <td class=\"fieldarea\"><input type=\"checkbox\" name=\"account\" id=\"account\" value=\"1\" /><label for=\"account\">";
echo $LNG["payfromaccount"];
echo " Balance</label>\n        <span class=\"highlighted\">";
echo $LNG["creditleft"] . "&nbsp;&nbsp;" . $clientDetails["credit"]["total"] . "&nbsp;&nbsp;" . $clientDetails["currency"]["code"];
echo "</span>\n    </td>\n</tr>\n\n<tr id=\"hide\">\n    <td class=\"fieldlabel\">  </td>\n    <td class=\"fieldarea\"><span><input type=\"checkbox\" checked=\"checked\" id=\"geninvoice\" name=\"geninvoice\"/>\n        <label for=\"geninvoice\">";
echo $LNG["geninvoice"];
echo "</label></span>\n        <span><input type=\"checkbox\" checked=\"checked\" id=\"paid\" name=\"paid\"/>\n        <label for=\"paid\">";
echo $LNG["paid"];
echo "</label></span></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">  </td>\n  <td class=\"fieldarea\"><input value=\"";
echo $LNG["add"];
echo "\" id=\"btnedituser\" class=\"btn add\" type=\"button\"\n  onclick=\"SubmitForm ('#btnedituser','edituser.subscribe','#frmedituser','#notification','true','#main_loader','main2.php?page=edituser.subscription','";
echo $id;
echo "');\"/></td>\n</tr>\n</table>\n\n</div>\n<div class=\"clear\"></div>\n</form>\n</div></div></div>\n\n\n<div class=\"groupstabescontant\">\n";
$defaultcurrency = mysqli_fetch_assoc(dquery("SELECT id from `tbl_currencies` where `default`='1'"));
$result = dquery("SELECT id,user_id,\nCONCAT('<a href=\"javascript: redirectedit(\\'editimeiservice\\',',service_id,')\">',\n(select service_name from tbl_services_imei where id=service_id),'</a>') as service,\n(select service_name from tbl_services_imei where id=service_id) as serviced\n,status,subscribe_start,subscribe_end FROM tbl_subscribers WHERE user_id='" . $id . "' AND type='tbl_services_imei'");
echo "<form id=\"frmedituser\" name=\"\" method=\"post\" enctype=\"multipart/form-data\">\n";
echo generate_token("form");
echo "<table id=\"main_tbl\">\n<thead><tr>\n<th>";
echo $LNG["id"];
echo "</th>\n\n<th>";
echo $LNG["service"];
echo "</th>\n\n<th>";
echo $LNG["subscribed"];
echo " ";
echo $LNG["date"];
echo "</th>\n<th>";
echo $LNG["subscription"];
echo " ";
echo $LNG["end"];
echo "</th>\n<th>";
echo $LNG["remain"];
echo " ";
echo $LNG["days"];
echo "</th>\n<th>";
echo $LNG["status"];
echo "</th>\n<th>";
echo $LNG["action"];
echo "</th>\n</thead>\n<tbody>\n";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>\n<td>";
    echo $row["id"];
    echo "</td>\n\n<td>";
    echo $row["service"];
    echo "</td>\n\n<td>";
    echo date("Y-m-d", $row["subscribe_start"]);
    echo "</td>\n<td>";
    echo date("Y-m-d", $row["subscribe_end"]);
    echo "</td>\n<td>";
    $time = time();
    if (0 < ($row["subscribe_end"] - $time) / 86400) {
        echo intval(($row["subscribe_end"] - $time) / 86400);
    } else {
        echo "0";
    }
    echo "</td>\n<td>\n";
    if ($row["status"] == "active") {
        echo "<span class='textgreen'>Active</span>";
    } else {
        echo "<span class='textred'>" . ucfirst($row["status"]) . "</span>";
    }
    echo "</td>\n<td><a class=\"editdata\"\nhref=\"javascript: load_subpage('includes/pages/editsubscriber.php?id=";
    echo $row["id"];
    echo "','";
    echo $LNG["edit"];
    echo " ";
    echo $row["serviced"];
    echo "');\">";
    echo $LNG["edit"];
    echo "</a>\n <a class=\"deletedata\"\n href=\"javascript:\n if(confirm('Are you sure want to remove subscription ?')){\n     location.href='main2.php?page=edituser.subscription&id=";
    echo $id;
    echo "&action=delete&delete=";
    echo $row["id"];
    echo "';\n }\n \"> ";
    echo $LNG["delete"];
    echo " </a>\n</td>\n</tr>\n";
}
$result = dquery("SELECT id,user_id,\nCONCAT('<a href=\"javascript: redirectedit(\\'editfileservice\\',',service_id,')\">',\n(select service_name from tbl_services_file where id=service_id),'</a>') as service,\n(select service_name from tbl_services_imei where id=service_id) as serviced\n,status,subscribe_start,subscribe_end FROM tbl_subscribers WHERE user_id='" . $id . "' AND type='tbl_services_file'");
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>\n<td>";
    echo $row["id"];
    echo "</td>\n<td>";
    echo $row["service"];
    echo "</td>\n<td>";
    echo date("Y-m-d", $row["subscribe_start"]);
    echo "</td>\n<td>";
    echo date("Y-m-d", $row["subscribe_end"]);
    echo "</td>\n<td>";
    $time = time();
    if (0 < ($row["subscribe_end"] - $time) / 86400) {
        echo intval(($row["subscribe_end"] - $time) / 86400);
    } else {
        echo "0";
    }
    echo "</td>\n<td>\n";
    if ($row["status"] == "active") {
        echo "<span class='textgreen'>Active</span>";
    } else {
        echo "<span class='textred'>" . ucfirst($row["status"]) . "</span>";
    }
    echo "</td>\n\n<td><a class=\"editdata\" onclick=\"load_subpage('includes/pages/editsubscriber.php?id=";
    echo $row["id"];
    echo "','";
    echo $LNG["edit"];
    echo " ";
    echo $row["serviced"];
    echo "');\">";
    echo $LNG["edit"];
    echo "</a>\n  <a  class=\"deletedata\" href=\"javascript:\nif(confirm('Are you sure want to remove Subscription ?')){\n getContect('#tab16','main2.php?page=edituser.subscription&action=delete&delete=";
    echo $row["id"];
    echo "','";
    echo $row["id"];
    echo "','','#tabcontent',true,'#main_loader');\n}\n \"> ";
    echo $LNG["delete"];
    echo " </a>\n</td>\n</tr>\n";
}
$result = dquery("SELECT id,user_id,\nCONCAT('<a href=\"javascript: redirectedit(\\'editserverservice\\',',service_id,')\">',\n(select service_name from tbl_server_log where id=service_id),'</a>') as service,\n(select service_name from tbl_server_log where id=service_id) as serviced\n,\nstatus,subscribe_start,subscribe_end FROM tbl_subscribers WHERE user_id='" . $id . "' AND type='tbl_server_log'");
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>\n<td>";
    echo $row["id"];
    echo "</td>\n<td>";
    echo $row["service"];
    echo "</td>\n<td>";
    echo date("Y-m-d", $row["subscribe_start"]);
    echo "</td>\n<td>";
    echo date("Y-m-d", $row["subscribe_end"]);
    echo "</td>\n<td>";
    $time = time();
    if (0 < ($row["subscribe_end"] - $time) / 86400) {
        echo intval(($row["subscribe_end"] - $time) / 86400);
    } else {
        echo "0";
    }
    echo "</td>\n<td>\n";
    if ($row["status"] == "active") {
        echo "<span class='textgreen'>Active</span>";
    } else {
        echo "<span class='textred'>" . ucfirst($row["status"]) . "</span>";
    }
    echo "</td>\n<td><a class=\"editdata\" onclick=\"load_subpage('includes/pages/editsubscriber.php?id=";
    echo $row["id"];
    echo "','";
    echo $LNG["edit"];
    echo " ";
    echo $row["serviced"];
    echo "');\">";
    echo $LNG["edit"];
    echo "</a>\n  <a  class=\"deletedata\" href=\"javascript:\nif(confirm('Are you sure want to remove Subscription ?')){\n getContect('#tab16','main2.php?page=edituser.subscription&action=delete&delete=";
    echo $row["id"];
    echo "','";
    echo $row["id"];
    echo "','','#tabcontent',true,'#main_loader');\n}\n \"> ";
    echo $LNG["delete"];
    echo " </a>\n</td>\n</tr>\n";
}
$result = dquery("SELECT id,user_id,\n\nCONCAT('<a href=\"javascript: redirectedit(\\'editproduct\\',',service_id,')\">',\n(select service_name from tbl_products where id=service_id),'</a>') as service,\n(select service_name from tbl_products where id=service_id) as serviced\n\n,status,subscribe_start,subscribe_end FROM tbl_subscribers WHERE user_id='" . $id . "' AND type='tbl_products'");
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>\n<td>";
    echo $row["id"];
    echo "</td>\n<td>";
    echo $row["service"];
    echo "</td>\n<td>";
    echo date("Y-m-d", $row["subscribe_start"]);
    echo "</td>\n<td>";
    echo date("Y-m-d", $row["subscribe_end"]);
    echo "</td>\n<td>";
    $time = time();
    if (0 < ($row["subscribe_end"] - $time) / 86400) {
        echo intval(($row["subscribe_end"] - $time) / 86400);
    } else {
        echo "0";
    }
    echo "</td>\n<td>\n";
    if ($row["status"] == "active") {
        echo "<span class='textgreen'>Active</span>";
    } else {
        echo "<span class='textred'>" . ucfirst($row["status"]) . "</span>";
    }
    echo "</td>\n<td><a class=\"editdata\" onclick=\"load_subpage('includes/pages/editsubscriber.php?id=";
    echo $row["id"];
    echo "','";
    echo $LNG["edit"];
    echo " ";
    echo $row["serviced"];
    echo "');\">";
    echo $LNG["edit"];
    echo "</a>\n  <a class=\"deletedata\" href=\"javascript:\nif(confirm('Are you sure want to remove Subscription ?')){\n getContect('#tab16','main2.php?page=edituser.subscription&action=delete&delete=";
    echo $row["id"];
    echo "','";
    echo $row["id"];
    echo "','','#tabcontent',true,'#main_loader');\n}\n \"> ";
    echo $LNG["delete"];
    echo " </a>\n</td>\n</tr>\n";
}
echo "</tbody>\n</table>\n</form>\n\n";
if ($action == "delete") {
    echo "</div id=\"tabcontent\"> ";
}
echo "</div>\n<div id=\"page_info\" class=\"page_info\">\n\t<li>Subscribe any service/product and buy subscription package. User can use this service/product to purchase on specific duration without any cost.</li>\n</div>";
$fileverioncheck = "6.1.0";

?>