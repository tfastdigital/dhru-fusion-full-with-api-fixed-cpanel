<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"notification\"></div>\r\n<div id=\"content\">\r\n    <div id=\"content_padded\">\r\n        To enable this automation features to run, make sure you set up a cron job to run <span style=\"color: red;font-weight: bold\">Every minute</span>. Create the following Cron Job using PHP | How to setup a Cron job in cPanel\r\n        ";
if ($start) {
    dquery("UPDATE tbl_mail_batch set status=0 where id='" . $start . "'");
}
if ($pause) {
    dquery("UPDATE tbl_mail_batch set status=1 where id='" . $pause . "'");
}
echo "        <div id=\"notificatin1\" class=\"info\">/usr/bin/wget -O - -q -t 1 ";
echo $config["site_address"];
echo "includes/cron2.php?action=backgroundmailqueue</div>\r\n    <table id=\"main_tbl\"  class='sorthis sortable'>\r\n        <thead>\r\n        <tr>\r\n            <th>";
echo $LNG["id"];
echo "</th>\r\n            <th>";
echo $LNG["date"];
echo "</th>\r\n            <th>";
echo $LNG["subject"];
echo "</th>\r\n            <th>";
echo $LNG["total"];
echo " Receivers</th>\r\n            <th>";
echo $LNG["completed"];
echo "</th>\r\n            <th>";
echo $LNG["status"];
echo "</th>\r\n            <th align=\"right\">";
echo $LNG["action"];
echo "</th>\r\n        </tr>\r\n        </thead>\r\n\r\n        <tbody>\r\n        ";
$q = dquery("select * from tbl_mail_batch order by id desc");
while ($r = mysqli_fetch_assoc($q)) {
    echo "            <tr>\r\n                <td>";
    echo $r["id"];
    echo "</td>\r\n                <td>";
    echo $r["date"];
    echo "</td>\r\n                <td>";
    echo $r["subject"];
    echo "</td>\r\n                <td>";
    echo $r["total"];
    echo "</td>\r\n                <td>";
    echo round(100 * $r["pending"] / $r["total"]);
    echo " %</td>\r\n                <td>";
    if ($r["status"] == 1) {
        echo "Pause";
    } else {
        if ($r["pending"] == $r["total"]) {
            echo "Completed";
        } else {
            if (0 < $r["pending"]) {
                echo "In Process";
            } else {
                echo "New";
            }
        }
    }
    echo "</td>\r\n                <td>\r\n                    ";
    if ($r["status"] == 1) {
        echo "                        <a href=\"main2.php?page=massmailmain&laoddefaultpage=massmailbatch.php&start=";
        echo $r["id"];
        echo "\">Start</a>\r\n                        ";
    } else {
        echo "                        <a href=\"main2.php?page=massmailmain&laoddefaultpage=massmailbatch.php&pause=";
        echo $r["id"];
        echo "\">Pause</a>\r\n                        ";
    }
    echo "                    | ";
    echo $LNG["download"];
    echo " ";
    echo $LNG["log"];
    echo "</td>\r\n            </tr>\r\n";
}
echo "        </tbody>\r\n    </table>\r\n</div>\r\n</div>\r\n</div>\r\n";
$fileverioncheck = "6.1.0";

?>