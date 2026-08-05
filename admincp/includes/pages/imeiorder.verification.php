<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 22;
checkPagePermission($pageid);
if ($stype == "remote") {
    $whereserv = " `server`=2";
    $commonwhere = " and useasserver=2";
} else {
    if ($stype == "server") {
        $whereserv = " `server`=1";
        $commonwhere = " and useasserver=1";
    } else {
        $whereserv = " `server`=0";
        $commonwhere = " and useasserver=0";
    }
}
$servi = dquery("select id,service_name,colortag,API,API_ID from tbl_services_imei\nwhere 1=1  " . $commonwhere);
while ($r = mysqli_fetch_assoc($servi)) {
    $sname[$r["id"]] = $r;
}
$flag = 1;
$q = dquery("SHOW INDEX FROM tbl_order_imei");
while ($r = mysqli_fetch_assoc($q)) {
    if ($r["Key_name"] == "user_can_c") {
        $flag = 0;
    }
}
if ($flag == 1) {
    dquery("ALTER TABLE `tbl_order_imei` ADD INDEX ( `user_can_c` )");
}
$flag = 1;
$q = dquery("SHOW INDEX FROM tbl_order_imei");
while ($r = mysqli_fetch_assoc($q)) {
    if ($r["Key_name"] == "verified") {
        $flag = 0;
    }
}
if ($flag == 1) {
    dquery("ALTER TABLE `tbl_order_imei` ADD INDEX ( `verified` )");
}
$sql = dquery("SELECT  distinct service_id,ebay\nFROM `tbl_order_imei`  \nWHERE  (user_can_c =3 or user_can_c=4) and verified=1 \nand " . $whereserv . "\nORDER BY order_id DESC limit 250");
echo "    <style>\n        .boxes{\n            width: 10px;\n            height: 10px;\n            float:left;\n            margin-top: 4px;\n            margin-right: 4px;\n        }\n    </style>\n<div id=\"content\">\n<div id=\"content_padded\"> \n<h2>    \n    <span class=\"groupstabesheadertext\">Order for verification</span>\n  </h2><br />\n  \n<form id=\"newimeiorder\" name=\"\" method=\"post\">   \n";
echo "<table id=main_tbl><thead>\n              <tr>\n                <th>" . $LNG["service"] . "</th>\n                <th>" . $LNG["apicon"] . "</th>\n                <th>" . $LNG["order"] . "</th>\n                <th>" . $LNG["action"] . "</th>\n              </tr>\n            </thead>";
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<tr>\n<td><div class=\"boxes\" style=\"background-color:";
    echo $sname[$row["service_id"]]["colortag"];
    echo " \"></div>";
    echo $sname[$row["service_id"]]["service_name"];
    echo "</td>\n<td align=\"left\">";
    if ($sname[$row["service_id"]]["API_ID"]) {
        $s = mysqli_fetch_assoc(dquery("select value from tbl_apiservers\n     where gateway='" . $row["API"] . "' and setting='customname'"));
        $s1 = mysqli_fetch_assoc(dquery("select value from tbl_apiservers\n    where gateway='" . $row["API"] . "' and setting='name'"));
        echo $s["value"] . " " . $s1["value"];
    } else {
        echo "NA";
    }
    echo "</td>   \n<td align=\"left\">\n";
    echo mysqli_num_rows(dquery("SELECT order_id\nFROM `tbl_order_imei` WHERE (user_can_c =3 or user_can_c=4) and verified=1 \n  and service_id='" . $row["service_id"] . "'"));
    echo "</td>\n<td align=\"right\"> \n";
    if ($sname[$row["service_id"]]["API"]) {
        echo "<a class=\"\" onclick=\"javascript: \n    if(confirm('This service is now connected to API.Do you want to Continue')) { \n    getContect('#tab3','main2.php?page=viewimeiorder.verif&laoddefaultpage=imeiorder.verification.php";
        if ($stype == "server") {
            echo "&stype=" . $stype;
        }
        echo "','";
        echo $row["service_id"];
        echo "','','#tabcontent',true,'#main_loader'); \n    }\"  >";
        echo $LNG["vieworder"];
        echo "</a>   \n    ";
    } else {
        echo "<a class=\"\" \nonclick=\"getContect('#tab3','main2.php?page=viewimeiorder.verif&laoddefaultpage=imeiorder.verification.php";
        if ($stype == "server") {
            echo "&stype=" . $stype;
        }
        echo "','";
        echo $row["service_id"];
        echo "','','#tabcontent',true,'#main_loader');\"  >";
        echo $LNG["vieworder"];
        echo "</a>\n";
    }
    echo "</td>  \n</tr> \n";
}
echo "</table></fieldset><br/></form></div></div> ";
$fileverioncheck = "6.1.0";

?>