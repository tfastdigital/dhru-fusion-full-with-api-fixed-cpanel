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
echo "<ul id=\"tabmenu\">\n    <li><a href=\"javascript:void(0)\" class=\"tabmenu_active\">Mass SMS</a></li>\n</ul>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n";
if (isset($send)) {
    checkDemoMode(false);
    if (!isset($_SESSION["CUST"])) {
        $_SESSION["CUST"] = $users;
        $_SESSION["TYPE"] = $type;
        $_SESSION["SUBSRC"] = $subscr;
        $_SESSION["PID"] = $pid;
        $_SESSION["INUSER"] = $inuser;
        $_SESSION["RSELLU"] = $resellersu;
        $_SESSION["dCLNTGRP"] = $clientgrp;
    }
    $pid = $_SESSION["PID"];
    if (!$start) {
        $sql = dquery("SELECT `id` FROM tbl_smstemplate WHERE `mass`='1'");
        if (mysqli_num_rows($sql)) {
            $oid = mysqli_fetch_assoc($sql);
            $data["name"] = "Mass SMS";
            $data["message"] = html_entity_decode($body);
            $data["mass"] = "1";
            $data["status"] = "1";
            $db->update("tbl_smstemplate", $data, "id=" . $oid["id"]);
            $load = $oid["id"];
            $data = NULL;
        } else {
            $data["name"] = "Mass SMS";
            $data["message"] = html_entity_decode($body);
            $data["mass"] = "1";
            $data["status"] = "1";
            $load = $db->insert("tbl_smstemplate", $data);
            $data = NULL;
        }
    } else {
        $sql = mysqli_fetch_assoc(dquery("SELECT * FROM tbl_smstemplate WHERE mass='1'"));
        $body = $sql["message"];
    }
    include_once ROOTDIR . "/includes/mail.fun.php";
    if ($load) {
        $tid = $load;
    } else {
        $tid = $sql["id"];
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
        $tot = dquery("SELECT `id`,`username`,`phonenumber` FROM tblUsers " . $WHERE . " and verified='1'");
        $sql = dquery("SELECT `id`,`username`,`phonenumber` FROM tblUsers " . $WHERE . " and verified='1' LIMIT " . $start . "," . $limit);
        while ($m = mysqli_fetch_assoc($sql)) {
        }
        $sql = mysqli_num_rows($tot);
        if ($start + $limit < $sql) {
            $start = $start + 25;
            echo "<div id='notification1' class='successbox'>  Your Batch is in Process wait for 15 Sec. <a href=\"javascript:redirectedit('sendSMS','&send&start=";
            echo $start;
            echo "&limit=";
            echo $limit;
            echo "')\">Click Here to go to Next Batch</a> </div>\n            ";
            sleep(15);
            echo "            <script>\n               redirectedit('sendSMS','&send&start='+";
            echo $start;
            echo ");\n            </script>\n           ";
        } else {
            unset($_SESSION["CUST"]);
            echo "            <script>\n               redirectedit('sendSMS','&send2&start='+";
            echo $start;
            echo ");\n            </script>\n           ";
        }
    } else {
        if ($_SESSION["CUST"] == 2) {
            $supllier = true;
            $tot = dquery("SELECT `id`,`username`,`phone` as phonenumber FROM tbl_supplier");
            $sql = dquery("SELECT `id`,`username`,`phone` as phonenumber FROM tbl_supplier LIMIT " . $start . "," . $limit);
        } else {
            $QUERY = "SELECT `id`,`username`,`email` FROM tblUsers WHERE \n\t\t\t\t\tid IN (" . $_SESSION["pickeduser"] . ")";
            $tot = dquery($QUERY);
            $sql = dquery($QUERY . "  LIMIT " . $start . "," . $limit);
        }
    }
    if ($m["phonenumber"]) {
        sendSMS($m["phonenumber"], $tid);
        echo "Username : " . $m["username"] . " " . $tid . " Phonenumber : " . $m["phonenumber"] . " <br/>";
    }
} else {
    echo "\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">SMS to Receipiant</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<form id=\"mails\" name=\"mails\" method=\"post\" >\n<script>\nfunction showPID(ob){\n var vals=ob.value;\n\tif(ob.checked && vals==5){\n\t\tdocument.getElementById('pid').style.display='';\n\t}else{\n\t\tdocument.getElementById('pid').style.display='none';\n\t}\n}\n</script>\n\n<table class=\"form\"  cellpadding=\"5\">\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["mail"];
    echo " ";
    echo $LNG["to"];
    echo "</td>\n    <td class=\"fieldarea\">\n        <input type=\"radio\" onclick='showPID(this)' id=\"ab\" name=\"users\"\n         value=\"1\" checked />\n        <label for=\"ab\">";
    echo $LNG["user"];
    echo "s</label>\n     ";
    if (!$OnlyEcommerce) {
        echo "      <input type=\"radio\" onclick='showPID(this)' id=\"cd\" name=\"users\" value=\"2\" />\n       <label for=\"cd\">";
        echo $LNG["supplier"];
        echo "</label>\n    ";
    }
    echo "      <input type=\"radio\" onclick='showPID(this)' id=\"abc\" name=\"users\" value=\"3\" />\n       <label for=\"abc\">";
    echo $LNG["pickeduser"];
    echo "</label>\n     &nbsp;&nbsp; <a href=\"javascript: load_subpage('includes/pages/pickuser.php','";
    echo $LNG["selict"] . " " . $LNG["user"];
    echo "')\">Pick User</a></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\" >\n    \t";
    echo $LNG["userstatus"];
    echo "    </td>\n    <td class=\"fieldarea\">\n       <input type=\"radio\" name=\"type\" id=\"uu\" value=\"3\" checked />\n        <label for=\"uu\">";
    echo $LNG["all"];
    echo " ";
    echo $LNG["user"];
    echo "</label>\n    \t<input type=\"radio\" id=\"ee\" name=\"type\" value=\"1\"  />\n        <label for=\"ee\">";
    echo $LNG["active"];
    echo " ";
    echo $LNG["user"];
    echo "</label>\n        <input type=\"radio\" id=\"dd\" name=\"type\" value=\"2\"  />\n        <label for=\"dd\">";
    echo $LNG["inactive"];
    echo " ";
    echo $LNG["user"];
    echo "</label>\n     </td>\n    </tr>\n";
    if (!$OnlyEcommerce) {
        echo "  <tr>\n    <td class=\"fieldlabel\" >\n    ";
        echo $LNG["client"];
        echo " ";
        echo $LNG["group"];
        echo "    </td>\n    <td class=\"fieldarea\">\n  <select name=\"clientgrp\" >\n  <option value=\"\">";
        echo $LNG["select_"];
        echo " ";
        echo $LNG["group"];
        echo "</option>\n  <option value=\"0\">";
        echo $LNG["default"];
        echo "</option>\n   ";
        $sql = dquery("select * from tbl_client_group order by displayorder asc");
        while ($row = mysqli_fetch_assoc($sql)) {
            echo "<option ";
            if ($row["id"] == $clientDetails["client_group"]) {
                echo "selected";
            }
            echo " value=\"";
            echo $row["id"];
            echo "\">";
            echo $row["groupname"];
            echo "</option>";
        }
        echo " </select> &nbsp; <a href=\"#\" data-target=\"clientgroup\" data-target-header=\"";
        echo $LNG["add"];
        echo " ";
        echo $LNG["new"];
        echo " ";
        echo $LNG["group"];
        echo "\" onclick=\"AddnewInpopup(this);\">";
        echo $LNG["add"];
        echo " ";
        echo $LNG["new"];
        echo " ";
        echo $LNG["group"];
        echo "</a>\n    </td>\n </tr>\n\n <tr>\n    <td class=\"fieldlabel\" >\n    &nbsp;\n    </td>\n    <td class=\"fieldarea\">\n    \t<input type=\"checkbox\" id=\"rts\" name=\"resellersu\" value=\"1\" checked=\"checked\" />\n        <label for=\"rts\">";
        echo $LNG["do"];
        echo " ";
        echo $LNG["not"];
        echo " ";
        echo $LNG["send"];
        echo "  ";
        echo $LNG["to"];
        echo "  ";
        echo $LNG["resellers"];
        echo "  ";
        echo $LNG["user"];
        echo "</label>\n    </td>\n </tr>\n";
    }
    echo "\n</table>\n<br/>\n\n";
    echo generate_token("form");
    echo "<table class=\"form\" cellpadding=\"5\">\n<tbody>\n\n\n\n\n";
    if (!$load) {
        echo "<tr>\n    <td class=\"fieldlabel\">";
        echo $LNG["body"];
        echo "</td>\n    <td class=\"fieldarea\"><textarea rows=\"5\" cols=\"40\" name='body' id=\"body\"></textarea></td>\n</tr>\n\n\n\n";
    } else {
        echo "<tr>\n    <td class=\"fieldlabel\">";
        echo $LNG["body"];
        echo "</td>\n    <td class=\"fieldarea\"><textarea rows=\"10\" cols=\"100\" name='body' id=\"body\">";
        echo $temp["message"];
        echo "</textarea></td>\n</tr>\n";
    }
    echo "\n</tbody></table>\n<p align=\"center\" class=\"fixedbtn\"><input type=\"submit\" name=\"send\"\nid=\"sendmai\" class=\"btn\"  value=\"";
    echo $LNG["send"];
    echo " ";
    echo $LNG["sms"];
    echo "\"  /></p>\n</form></div></div></div></div>\n";
}
$fileverioncheck = "6.1.0";

?>