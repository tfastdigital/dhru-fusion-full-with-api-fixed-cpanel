<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 39;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/clients.fun.inc.php";
include_once ROOTDIR . "/includes/fileservices.fun.php";
$fileServiceDetails = getFileServices("", "", "", true, true, "", "", "", "", "", "", "", 9999);
echo "\n    <style>\n        .boxes{\n            width: 10px;\n            height: 10px;\n            float:left;\n            margin-top: 4px;\n            margin-right: 4px;\n        }\n    </style>\n<div id=\"content\">\n<div id=\"content_padded\">\n <h2>    \n    <span class=\"groupstabesheadertext\">Orders for verification</span>\n  </h2>\n <br />\n<form id=\"newimeiorder\" name=\"\" method=\"post\">       \n";
$flag = 1;
$q = dquery("SHOW INDEX FROM tbl_order_file");
while ($r = mysqli_fetch_assoc($q)) {
    if ($r["Key_name"] == "user_can_c") {
        $flag = 0;
    }
}
if ($flag == 1) {
    dquery("ALTER TABLE `tbl_order_file` ADD INDEX ( `user_can_c` )");
}
$flag = 1;
$q = dquery("SHOW INDEX FROM tbl_order_file");
while ($r = mysqli_fetch_assoc($q)) {
    if ($r["Key_name"] == "verified") {
        $flag = 0;
    }
}
if ($flag == 1) {
    dquery("ALTER TABLE `tbl_order_file` ADD INDEX ( `verified` )");
}
$fileServiceDetailsKey = array_keys($fileServiceDetails);
if ($fileServiceDetailsKey) {
    foreach ($fileServiceDetailsKey as $group) {
        $show = false;
        foreach ($fileServiceDetails[$group] as $keys) {
            $cnts += mysqli_num_rows(dquery("SELECT `order_id` FROM `tbl_order_file` WHERE           (`user_can_c`='4') AND `verified`='1'  AND `service_id`='" . $keys["id"] . "'"));
        }
    }
}
if (!$cnts) {
    echo "<br /><div align='center'>No Order found</div>";
}
foreach ($fileServiceDetailsKey as $group) {
    $show = false;
    foreach ($fileServiceDetails[$group] as $keys) {
        $cnt = mysqli_num_rows(dquery("SELECT `order_id` FROM `tbl_order_file`        WHERE (`user_can_c`='4' )          AND `verified`='1'  AND `service_id`='" . $keys["id"] . "'"));
        if ($cnt) {
            $show = true;
        }
    }
    if ($show) {
        echo "<table id=main_tbl><thead>\n              <tr>\n                <th>" . $group . "</th>\n                <th>" . $LNG["order"] . "</th>\n                <th>" . $LNG["apicon"] . "</th>\n                <th>" . $LNG["action"] . "</th>\n              </tr>\n            </thead>";
        foreach ($fileServiceDetails[$group] as $keys) {
            $cnt = mysqli_num_rows(dquery("SELECT `order_id` FROM `tbl_order_file` \n        WHERE ( `user_can_c`='4' ) AND `verified`='1'   AND `service_id`='" . $keys["id"] . "'"));
            if ($cnt) {
                echo "<tr>\n<td><div class=\"boxes\" style=\"background-color: ";
                echo $keys["colortag"];
                echo "\"></div>";
                echo $keys["service_name"];
                echo "</td>\n<td>";
                echo $cnt;
                echo "</td>\n<td>";
                if ($keys["API"] != "") {
                    $api = mysqli_fetch_assoc(dquery("SELECT `value` FROM `tbl_apiservers` WHERE `gateway`='" . $keys["API"] . "' AND `setting`='name'"));
                    echo $api["value"];
                } else {
                    echo "No";
                }
                echo "</td> \n<td align=\"right\"> \n";
                if ($keys["API"] != "") {
                    echo "<a class=\"viewdata\" onclick=\"if(confirm('This service is now connected to API. Do you want to Continue')) { getContect('#tab3','main2.php?page=viewfileorder.verif&loaddefaultpage=fileorder.verification.php','";
                    echo $keys["id"];
                    echo "','','#tabcontent',true,'#main_loader'); }\"  >";
                    echo $LNG["vieworder"];
                    echo "</a></td>\n";
                } else {
                    echo "<a class=\"viewdata\" onclick=\"getContect('#tab3','main2.php?page=viewfileorder.verif&loaddefaultpage=fileorder.verification.php','";
                    echo $keys["id"];
                    echo "','','#tabcontent',true,'#main_loader');\"  >";
                    echo $LNG["vieworder"];
                    echo "</a></td>    \n";
                }
                echo "</tr> \n";
            }
        }
        echo "</table><br/>";
    }
}
unset($keys);
echo "</form></div></div> ";
$fileverioncheck = "6.1.0";

?>