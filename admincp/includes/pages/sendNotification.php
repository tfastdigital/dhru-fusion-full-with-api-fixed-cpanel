<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 500;
checkPagePermission($pageid);
include_once ROOTDIR . "/comm.php";
include_once ROOTDIR . "/includes/clients.fun.inc.php";
echo "\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n";
if (isset($send)) {
    if ($title && $body) {
        if (!isset($_SESSION["CUST"])) {
            $_SESSION["CUST"] = $users;
            $_SESSION["TYPE"] = $type;
            $_SESSION["SUBSRC"] = $subscr;
            $_SESSION["PID"] = $pid;
            $_SESSION["INUSER"] = $inuser;
            $_SESSION["RSELLU"] = $resellersu;
            $_SESSION["BODY"] = $body;
            $_SESSION["TITLE"] = $title;
            $_SESSION["dCLNTGRP"] = $clientgrp;
        }
        if (!$start) {
            $start = 0;
        }
        $limit = 25;
        if ($_SESSION["CUST"] == 1) {
            if ($_SESSION["TYPE"] == 1) {
                $WHERE .= "WHERE `userstatus`='0'";
            } else {
                if ($_SESSION["TYPE"] == 2) {
                    $WHERE .= "WHERE `userstatus`!='0'";
                } else {
                    $WHERE .= "WHERE 1=1 ";
                }
            }
            if ($_SESSION["INUSER"] == 1) {
                $WHERE .= " AND ( `usertype`='0' OR `usertype`='1' )";
            } else {
                if ($_SESSION["INUSER"] == 2) {
                    $WHERE .= " AND `usertype`='3'";
                }
            }
            if ($_SESSION["RSELLU"]) {
                $WHERE .= " AND `usertype`!='3'";
            }
            if ($_SESSION["dCLNTGRP"] != "") {
                $WHERE .= " AND `client_group`='" . $_SESSION["dCLNTGRP"] . "'";
            }
            $tot = dquery("SELECT `id`,`username`,`gcmid` FROM tblUsers \n        " . $WHERE . " and verified='1' and gcmid!=''");
            $sql = dquery("SELECT `id`,`username`,`gcmid` FROM tblUsers\n         " . $WHERE . " and verified='1' and gcmid!='' LIMIT " . $start . "," . $limit);
            while ($m = mysqli_fetch_assoc($sql)) {
            }
            $sql = mysqli_num_rows($tot);
            if ($start + $limit < $sql) {
                $start = $start + 25;
                echo "<div id='notification1' class='successbox'>  Your Batch is in Process wait for 15 Sec. <a href=\"javascript:redirectedit('sendNotification','&send&start=";
                echo $start;
                echo "&limit=";
                echo $limit;
                echo "')\">Click Here to go to Next Batch</a> </div>\n            ";
                sleep(15);
                echo "            <script>\n               redirectedit('sendNotification','&send&start='+";
                echo $start;
                echo ");\n            </script>\n           ";
            } else {
                unset($_SESSION["CUST"]);
                echo "            <script>\n               redirectedit('sendNotification','&send2&start='+";
                echo $start;
                echo ");\n            </script>\n           ";
            }
        } else {
            $QUERY = "SELECT `id`,`username`,`gcmid` FROM tblUsers WHERE \n\t\t\t\t\tid IN (" . $_SESSION["pickeduser"] . ")";
            $tot = dquery($QUERY);
            $sql = dquery($QUERY . "  LIMIT " . $start . "," . $limit);
        }
        if ($m["gcmid"]) {
            sendGCM($m["gcmid"], $_SESSION["TITLE"], $_SESSION["BODY"]);
            echo "Username : " . $m["username"] . "  GCM : " . $m["gcmid"] . " <br/>";
        }
    }
} else {
    echo "\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Notification Receipiant</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n  <small>Notification sent to only users who are using Client App with this server</small>\n<form id=\"mails\" name=\"mails\" method=\"post\" >\n\n<table class=\"form\"  cellpadding=\"5\">\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["user"];
    echo "</td>\n    <td class=\"fieldarea\">\n    <input type=\"radio\" onclick='showPID(this)' id=\"ab\" name=\"users\" value=\"1\" checked />\n    <label for=\"ab\">";
    echo $LNG["user"];
    echo "s</label>\n    <input type=\"radio\" onclick='showPID(this)' id=\"abc\" name=\"users\" value=\"3\" />\n    <label for=\"abc\">";
    echo $LNG["pickeduser"];
    echo "</label>\n    &nbsp;&nbsp; <a href=\"javascript: load_subpage('includes/pages/pickgcm.php','";
    echo $LNG["selict"] . " " . $LNG["user"];
    echo "')\">Pick User</a></td>\n</tr>\n\n\n";
    if (!$OnlyEcommerce) {
        echo "  <tr>\n    <td class=\"fieldlabel\" >\n    ";
        echo $LNG["client"];
        echo " ";
        echo $LNG["group"];
        echo "    </td>\n    <td class=\"fieldarea\">\n  <select name=\"clientgrp\" >\n      <option value=\"\">";
        echo $LNG["select_"];
        echo " ";
        echo $LNG["group"];
        echo "</option>\n      <option value=\"0\">";
        echo $LNG["default"];
        echo "</option>\n       ";
        $sql = dquery("select * from tbl_client_group order by displayorder asc");
        while ($row = mysqli_fetch_assoc($sql)) {
            echo "<option ";
            if ($row["id"] == $clientDetails["client_group"]) {
                echo "selected";
            }
            echo "       value=\"";
            echo $row["id"];
            echo "\">";
            echo $row["groupname"];
            echo "</option>";
        }
        echo " </select>  </td>\n </tr>\n";
    }
    echo "\n</table>\n<br/>\n\n";
    echo generate_token("form");
    echo "<table class=\"form\" cellpadding=\"5\">\n<tbody>\n\n";
    if (!$load) {
        echo "<tr>\n    <td class=\"fieldlabel\">";
        echo $LNG["title"];
        echo "</td>\n    <td class=\"fieldarea\">\n    <input type=\"text\" size=\"55\" name=\"title\" value=\"\" />\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
        echo $LNG["body"];
        echo "</td>\n    <td class=\"fieldarea\"><textarea rows=\"5\" cols=\"60\" name='body' id=\"body\"></textarea></td>\n</tr>\n\n\n\n";
    } else {
        echo "<tr>\n    <td class=\"fieldlabel\">";
        echo $LNG["title"];
        echo "</td>\n    <td class=\"fieldarea\">\n    <input type=\"text\" size=\"55\" name=\"title\" value=\"\" />\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
        echo $LNG["body"];
        echo "</td>\n    <td class=\"fieldarea\"><textarea rows=\"5\" cols=\"60\" name='body' id=\"body\">";
        echo $temp["message"];
        echo "</textarea></td>\n</tr>\n";
    }
    echo "\n</tbody></table>\n<p align=\"center\" class=\"fixedbtn\"><input type=\"submit\" name=\"send\"\n id=\"sendmai\" class=\"btn\"  value=\"";
    echo $LNG["send"];
    echo " ";
    echo $LNG["notification"];
    echo "\"  /></p>\n</form></div></div></div></div>\n";
}
$fileverioncheck = "6.1.0";

?>