<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$OnlyEcommerce = true;
include_once ROOTDIR . "/comm.php";
include_once ROOTDIR . "/includes/clients.fun.inc.php";
if ($load) {
    $temp = mysqli_fetch_assoc(dquery("SELECT * FROM tbl_emailtemplates \n    WHERE id='" . $load . "'"));
    if (!$temp["plaintext"]) {
        include "includes/3rdparty/editor/editor.php";
    }
} else {
    include "includes/3rdparty/editor/editor.php";
}
$_SESSION["fromail"] = true;
$pageid = 334;
checkPagePermission($pageid);
define("MASSMAIL", true);
echo "    <script>\n        function loopSelected()\n        {\n            var txtSelectedValuesObj = document.getElementById('selected');\n            var selectedArray = new Array();\n            var selObj = document.getElementById('imei');\n            var i;\n            var count = 0;\n            for (i=0; i<selObj.options.length; i++) {\n                if (selObj.options[i].selected) {\n                    selectedArray[count] = selObj.options[i].value;\n                    count++;\n                }\n            }\n            txtSelectedValuesObj.value = selectedArray;\n        }\n        function mailpreview()\n        {\n            var con=tinyMCE.get('message').getContent();\n\n            \$.post( \"includes/pages/preview.php?cont=\"+btoa(con)+'&layoutid='+\$('#layoutid').val(), function( data ) {\n\n                window.open('includes/pages/preview.php?id=";
echo time();
echo "',\n                    'Preview',\n                    'width=600, height=400');\n            });\n        }\n    </script>\n    <div id=\"notification\"></div>\n    <div id=\"content\">\n        <div id=\"content_padded\">\n            ";
if ($send2 && $config["mail_sending_type"] == 1) {
    echo "<div id='notification1' class='successbox'>" . $LNG["mail"] . " Sending through " . $LNG["sheduled"] . " " . $LNG["mail"] . "</div>";
}
if ($sendbackground) {
    checkDemoMode(false);
    $data = NULL;
    $data["subject"] = $subject;
    if ($plain == "on") {
        $data["message"] = strip_tags(html_entity_decode($body));
    } else {
        $data["message"] = html_entity_decode($body);
    }
    $data["date"] = date("Y-m-d");
    $data["mailserver"] = $mailserv;
    $data["batch"] = $batch;
    $data["layout"] = $layoutid;
    if ($users == 1) {
        if ($type == 1) {
            $WHERE .= "WHERE `userstatus`='0'";
        } else {
            if ($type == 2) {
                $WHERE .= "WHERE `userstatus`!='0'";
            } else {
                $WHERE .= "WHERE 1=1 ";
            }
        }
        if ($subscr == 3) {
            $WHERE .= " AND `news_letter`='0'";
        } else {
            if ($subscr == 1) {
                $WHERE .= " AND `news_letter`='1'";
            } else {
                $WHERE .= "";
            }
        }
        if ($inuser == 1) {
            $WHERE .= " AND ( `usertype`='0' OR `usertype`='1' )";
        } else {
            if ($inuser == 2) {
                $WHERE .= " AND `usertype`='3'";
            }
        }
        if ($resellersu) {
            $WHERE .= " AND `usertype`!='3'";
        }
        if ($clientgrp != "") {
            $WHERE .= " AND `client_group`='" . $clientgrp . "'";
        }
        $WHERE .= " and guest=0";
        $tot = "SELECT `id`,`username`,`email` FROM\n        tblUsers " . $WHERE;
    } else {
        if ($users == 2) {
            $supllier = true;
            $tot = "SELECT `id`,`username`,`email` FROM tbl_supplier";
        } else {
            if ($users == 4) {
                $newsletter = true;
                $tot = "SELECT `id`,`name`,`email` FROM tbl_newsletter where active='1' AND pid=''";
            } else {
                if ($users == 8) {
                    $tot = "SELECT `id`,`username`,`email` \n        FROM tblUsers where  client_group in (" . $gid . ") and userstatus=0";
                    $sql = "SELECT `id`,`username`,`email` \n        FROM tblUsers where  client_group IN (" . $gid . ")  and userstatus=0 LIMIT " . $start . "," . $limit;
                } else {
                    if ($users == 5) {
                        $newsletter = true;
                        $tot = "SELECT `id`,`name`,`email` FROM tbl_newsletter where active='1' AND ( pid LIKE '" . $pid . "' \n\t\t\t\t\t\t\t\t\t\t\t\t\tOR pid LIKE '" . $pid . ",%'\n\t\t\t\t\t\t\t\t\t\t\t\t\tOR pid LIKE '%," . $pid . "'\n\t\t\t\t\t\t\t\t\t\t\t\t\tOR pid LIKE '%," . $pid . ",%')";
                    } else {
                        $QUERY = "SELECT `id`,`username`,`email` FROM tblUsers WHERE \n\t\t\t\t\tid IN (" . $_SESSION["pickeduser"] . ")";
                        $tot = $QUERY;
                    }
                }
            }
        }
    }
    $data["users"] = $tot;
    $data["total"] = mysqli_num_rows(dquery($tot));
    $batchid = $db->insert("tbl_mail_batch", $data);
    echo "<div id='notification1' class='successbox'>Background process created #";
    echo $batchid;
    echo "</div> ";
}
if (isset($send)) {
    checkDemoMode(false);
    if ($frommail == "" || !preg_match("/^([a-zA-Z0-9])+([\\.a-zA-Z0-9+_-])*@([a-zA-Z0-9_-])+(\\.[a-zA-Z0-9_-]+)*\\.([a-zA-Z]{2,6})\$/", $frommail)) {
    }
    if (!isset($_SESSION["CUST"])) {
        $_SESSION["CUST"] = $users;
        $_SESSION["TYPE"] = $type;
        $_SESSION["SUBSRC"] = $subscr;
        $_SESSION["PID"] = $pid;
        $_SESSION["GID"] = $gid;
        $_SESSION["INUSER"] = $inuser;
        $_SESSION["RSELLU"] = $resellersu;
        $_SESSION["CLNTGRP"] = $clientgrp;
        $_SESSION["batch"] = $batch;
        $_SESSION["layoutid"] = $layoutid;
    }
    $pid = $_SESSION["PID"];
    $gid = $_SESSION["GID"];
    if (!$start) {
        if ($savetemplate != "") {
            $data["type"] = "newsletter";
            $data["subject"] = $subject;
            $data["message"] = html_entity_decode($body);
            $data["name"] = $savetemplate;
            $data["fromname"] = $fromname;
            $data["fromemail"] = $frommail;
            $data["mailserv"] = $mailserv;
            $data["custom"] = 1;
            $data["layoutid"] = $layoutid;
            if ($plain == "on") {
                $data["plaintext"] = 1;
            }
            $load = $db->insert("tbl_emailtemplates", $data);
            $data = NULL;
        } else {
            $sql = dquery("SELECT `id` FROM tbl_emailtemplates \n            WHERE `newsletter_default`='1'");
            if (mysqli_num_rows($sql)) {
                $oid = mysqli_fetch_assoc($sql);
                $data["type"] = "newsletter";
                $data["subject"] = $subject;
                $data["message"] = html_entity_decode($body);
                $data["fromname"] = $fromname;
                $data["fromemail"] = $frommail;
                $data["newsletter_default"] = "1";
                $data["mailserv"] = $mailserv;
                $data["name"] = "Default";
                $data["layoutid"] = $layoutid;
                if ($plain == "on") {
                    $data["plaintext"] = 1;
                } else {
                    $data["plaintext"] = 0;
                }
                $db->update("tbl_emailtemplates", $data, "id=" . $oid["id"]);
                $load = $oid["id"];
                $data = NULL;
            } else {
                $data["type"] = "newsletter";
                $data["subject"] = $subject;
                $data["message"] = html_entity_decode($body);
                $data["fromname"] = $fromname;
                $data["fromemail"] = $frommail;
                $data["newsletter_default"] = "1";
                $data["name"] = "Default";
                $data["custom"] = 1;
                $data["layoutid"] = $layoutid;
                $data["id"] = 1000;
                if ($plain == "on") {
                    $data["plaintext"] = 1;
                }
                $load = $db->insert("tbl_emailtemplates", $data);
                $data = NULL;
            }
        }
        include_once ROOTDIR . "/includes/mail.fun.php";
        $data = NULL;
        $data["message"] = sendMail(1000, "", "", "", "", "", "", "", "nomail@nodomain.com", "", "", "", "", "", true);
        $mdi = $db->insert("tbl_massmail", $data);
        $data = NULL;
    } else {
        $sql = mysqli_fetch_assoc(dquery("SELECT * FROM \n        tbl_emailtemplates WHERE newsletter_default='1'"));
        $subject = $sql["subject"];
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
    if ($config["mail_sending_type"] == 1) {
        $limit = 1000;
    } else {
        $limit = $_SESSION["batch"] ? $_SESSION["batch"] : 25;
    }
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
        if ($_SESSION["SUBSRC"] == 3) {
            $WHERE .= " AND `news_letter`='0'";
        } else {
            if ($_SESSION["SUBSRC"] == 1) {
                $WHERE .= " AND `news_letter`='1'";
            } else {
                $WHERE .= "";
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
        if ($_SESSION["CLNTGRP"] != "") {
            $WHERE .= " AND `client_group`='" . $_SESSION["CLNTGRP"] . "'";
        }
        $WHERE .= " and guest=0";
        $tot = dquery("SELECT `id`,`username`,`email` FROM\n        tblUsers " . $WHERE);
        $sql = dquery("SELECT `id`,`username`,`email` FROM tblUsers " . $WHERE . " LIMIT " . $start . "," . $limit);
        while ($m = mysqli_fetch_assoc($sql)) {
        }
        $sql = mysqli_num_rows($tot);
        if ($start + $limit < $sql) {
            $start = $start + $limit;
            echo "<div id='notification1' class='successbox'>\n                        Your Batch is in Process wait for 15 Sec.\n                        <a href=\"javascript:reloadcurrent('sendMail','&send&start=";
            echo $start;
            echo "&limit=";
            echo $limit;
            echo "')\">Click Here to go to Next Batch</a> </div>\n                ";
            if ($config["mail_sending_type"] == 1) {
                sleep(2);
            } else {
                sleep(15);
            }
            echo "                    <script>\n                        reloadcurrent('sendMail','&send&start='+";
            echo $start;
            echo ");\n                    </script>\n                    ";
        } else {
            unset($_SESSION["CUST"]);
            echo "<script>\n                        reloadcurrent('sendMail','&send2=ok&start='+";
            echo $start;
            echo ");\n                    </script>  ";
        }
    } else {
        if ($_SESSION["CUST"] == 2) {
            $supllier = true;
            $tot = dquery("SELECT `id`,`username`,`email` FROM tbl_supplier");
            $sql = dquery("SELECT `id`,`username`,`email` FROM tbl_supplier LIMIT " . $start . "," . $limit);
        } else {
            if ($_SESSION["CUST"] == 4) {
                $newsletter = true;
                $tot = dquery("SELECT `id`,`name`,`email` FROM tbl_newsletter where active='1' AND pid=''");
                $sql = dquery("SELECT `id`,`name`,`email` FROM tbl_newsletter where active='1' AND pid='' LIMIT " . $start . "," . $limit);
            } else {
                if ($_SESSION["CUST"] == 8) {
                    $tot = dquery("SELECT `id`,`username`,`email` \n        FROM tblUsers where  client_group in (" . $gid . ") and userstatus=0");
                    $sql = dquery("SELECT `id`,`username`,`email` \n        FROM tblUsers where  client_group IN (" . $gid . ")  and userstatus=0 LIMIT " . $start . "," . $limit);
                } else {
                    if ($_SESSION["CUST"] == 5) {
                        $newsletter = true;
                        $tot = dquery("SELECT `id`,`name`,`email` FROM tbl_newsletter where active='1' AND ( pid LIKE '" . $pid . "' \n\t\t\t\t\t\t\t\t\t\t\t\t\tOR pid LIKE '" . $pid . ",%'\n\t\t\t\t\t\t\t\t\t\t\t\t\tOR pid LIKE '%," . $pid . "'\n\t\t\t\t\t\t\t\t\t\t\t\t\tOR pid LIKE '%," . $pid . ",%')");
                        $sql = dquery("SELECT `id`,`name`,`email` FROM tbl_newsletter where active='1' AND  ( pid LIKE '" . $pid . "' \n\t\t\t\t\t\t\t\t\t\t\t\t\tOR pid LIKE '" . $pid . ",%'\n\t\t\t\t\t\t\t\t\t\t\t\t\tOR pid LIKE '%," . $pid . "'\n\t\t\t\t\t\t\t\t\t\t\t\t\tOR pid LIKE '%," . $pid . ",%') LIMIT " . $start . "," . $limit);
                    } else {
                        $QUERY = "SELECT `id`,`username`,`email` FROM tblUsers WHERE \n\t\t\t\t\tid IN (" . $_SESSION["pickeduser"] . ")";
                        $tot = dquery($QUERY);
                        $sql = dquery($QUERY . "  LIMIT " . $start . "," . $limit);
                    }
                }
            }
        }
    }
    if ($m["email"] && preg_match("/^([a-zA-Z0-9])+([\\.a-zA-Z0-9+_-])*@([a-zA-Z0-9_-])+(\\.[a-zA-Z0-9_-]+)*\\.([a-zA-Z]{2,6})\$/", $m["email"])) {
        if ($newsletter) {
            $toemails = NULL;
            $toemails[] = ["to" => $m["email"]];
            if (!sendMail($tid, "", "", "", true, "", "", "", $toemails)) {
            }
        } else {
            if ($supllier) {
                sendMail($tid, "", "", "", true, "", "", $m["id"]);
            } else {
                sendMail($tid, $m["id"], "", "", true);
            }
        }
        echo "Username : " . $m["username"] . " E-mail : " . $m["email"] . " <br/>";
    } else {
        echo "Username : " . $m["username"] . " E-mail : " . $m["email"] . " Sending Fail.....<br/>";
    }
} else {
    echo "            <script>\n                function checkblank(ob){\n                    if(ob.subject.value==\"\"){\n                        alert(\"Subject should not blank\");\n                        return false;\n                    }else{\n                        return true;\n                    }\n                }\n            </script>\n\n\n            <form id=\"mails\" name=\"mails\" method=\"post\" onsubmit=\"return checkblank(this)\">\n                <script>\n                    function showPID(ob){\n                        var vals=ob.value;\n                        if(ob.checked && vals==5){\n                            document.getElementById('pid').style.display='';\n                        }else{\n                            document.getElementById('pid').style.display='none';\n                        }\n                        if(ob.checked && vals==8){\n                            document.getElementById('ugid').style.display='';\n                        }else{\n                            document.getElementById('ugid').style.display='none';\n                        }\n                    }\n                </script>\n\n                <div  class=\"groupstabes\" >\n                    <h2>\n                        <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n                        <span class=\"groupstabesheadertext\">Mail Setting</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n                    </h2>\n                    <div class=\"groupstabescontant\">\n                        ";
    if ($load) {
        $selectedtmep = mysqli_fetch_assoc(dquery("SELECT * FROM tbl_emailtemplates WHERE id='" . $load . "'"));
    }
    echo "                        <table class=\"form\"  cellpadding=\"5\">\n\n                            <tr>\n                                <td class=\"fieldlabel\" width=\"15%\">Load ";
    echo $LNG["template"];
    echo "</td>\n                                <td class=\"fieldarea\"><span>\n    <select name=\"template\" class=\"chosen\"\n            onchange=\"javascript:reloadcurrent('massmailmain&laoddefaultpage=sendMail.php','&load='+this.value)\">\n    <option value=\"\">";
    echo $LNG["select"];
    echo "</option>\n    ";
    if ($OnlyEcommerce) {
        $s = dquery("select `type` from tbl_emailtemplates where \n        `type`!='imeiorder' and `type`!='serverorder' and `type`!='fileorder'\n        and `type`!='imeiorderbulk' and type!='resellerstore' group by `type`");
        while ($rs = mysqli_fetch_assoc($s)) {
        }
        echo "    </select>\n    </span> <a  href=\"#\" onclick=\"load_subpage('main2.php?page=mailsetting&laoddefaultpage=emailtemplate.add.php','";
        echo $LNG["addemailtemplate"];
        echo " ');\">";
        echo $LNG["addemailtemplate"];
        echo " </a></td>\n                            </tr>\n\n\n                            <tr>\n                                <td class=\"fieldlabel\" >\n                                    ";
        echo $LNG["mail"];
        echo " ";
        echo $LNG["server"];
        echo "                                </td>\n                                <td class=\"fieldarea\">\n                                    <select  name=\"mailserv\" >\n                                        <option value=\"\">";
        echo $LNG["default"];
        echo " ";
        echo $LNG["server"];
        echo "</option>\n                                        <option  ";
        if ($selectedtmep["mailserv"] == 1) {
            echo "selected";
        }
        echo " value=\"1\">";
        echo $LNG["mail"];
        echo " ";
        echo $LNG["server"];
        echo " 1</option>\n                                        <option  ";
        if ($selectedtmep["mailserv"] == 2) {
            echo "selected";
        }
        echo " value=\"2\">";
        echo $LNG["mail"];
        echo " ";
        echo $LNG["server"];
        echo " 2</option>\n                                    </select>\n                                </td>\n                            </tr>\n\n\n                            <tr>\n                                <td class=\"fieldlabel\">\n                                    ";
        echo $LNG["template"];
        echo " Layout\n                                </td>\n                                <td class=\"fieldarea\">\n                                    <select name=\"layoutid\" id=\"layoutid\">\n                                        <option value=\"\">No Layout</option>\n                                        ";
        $ql = dquery("select id,name from tbl_email_layout");
        while ($rl = mysqli_fetch_assoc($ql)) {
            $selected = "";
            if ($rl["id"] == $selectedtmep["layoutid"]) {
                $selected = "selected";
            }
            echo "                                            <option value=\"";
            echo $rl["id"];
            echo "\" ";
            echo $selected;
            echo " >";
            echo $rl["name"];
            echo "</option>\n                                            ";
        }
        echo "                                    </select> &nbsp; <a href=\"#\" data-target=\"emailtemplate.layout\" data-target-header=\"";
        echo $LNG["add"];
        echo " ";
        echo $LNG["template"];
        echo " layout\" onclick=\"AddnewInpopup(this);\">";
        echo $LNG["add"];
        echo " ";
        echo $LNG["template"];
        echo " layout</a>\n                                </td>\n                            </tr>\n\n\n                            ";
        if ($config["mail_sending_type"] != 1) {
            echo "                                <tr>\n                                    <td class=\"fieldlabel\" >\n                                        No. of Mail Per Batch\n                                    </td>\n                                    <td class=\"fieldarea\">\n                                        <input type=\"text\" value=\"25\" name=\"batch\" class=\"txt small\" />\n                                    </td>\n                                </tr>\n                                ";
        }
        echo "\n                        </table>\n\n                    </div></div>\n\n                ";
        echo generate_token("form");
        echo "\n                <div  class=\"groupstabes\" >\n                    <h2>\n                        <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n                        <span class=\"groupstabesheadertext\">Select recipient</span>\n                    </h2>\n                    <div class=\"groupstabescontant\">\n\n                        <table class=\"form\" cellpadding=\"5\">\n                            <tbody>\n                            ";
        if ($load) {
            $temp = mysqli_fetch_assoc(dquery("SELECT * FROM tbl_emailtemplates WHERE id='" . $load . "'"));
        } else {
            $temp = NULL;
        }
        echo "                            <tr>\n                                <td class=\"fieldlabel\">";
        echo $LNG["fromname"];
        echo "</td>\n                                <td class=\"fieldarea\">\n    <span><input type=\"text\"\n                 class=\"txt medium\" name=\"fromname\" value=\"\" /></span></td>\n                            </tr>\n                            <tr>\n                                <td class=\"fieldlabel\">";
        echo $LNG["frommail"];
        echo "</td>\n                                <td class=\"fieldarea\"><span><input type=\"text\"  class=\"txt medium\" name=\"frommail\" value=\"\" /></span></td>\n                            </tr>\n\n                            <tr>\n                                <td class=\"fieldlabel\" width=\"15%\"><strong>";
        echo $LNG["mail"];
        echo " ";
        echo $LNG["to"];
        echo "</strong></td>\n                                <td class=\"fieldarea\">\n                                </td>\n                            </tr>\n\n                            <tr class=\"hightlight\">\n                                <td class=\"fieldlabel\" width=\"15%\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo $LNG["user"];
        echo "</td>\n                                <td class=\"fieldarea\">\n                                    <input type=\"radio\" onclick='showPID(this)' id=\"ab\" name=\"users\" value=\"1\" checked />\n                                    <label for=\"ab\">";
        echo $LNG["user"];
        echo "s</label>\n\n                                    <input type=\"radio\" onclick='showPID(this)'  onblur='showPID(this)' id=\"ugs\" name=\"users\" value=\"8\" />\n                                    <label for=\"ugs\">";
        echo $LNG["user"];
        echo " ";
        echo $LNG["group"];
        echo "</label>\n                                    ";
        if (!$OnlyEcommerce) {
            echo "                                        <input type=\"radio\" onclick='showPID(this)' id=\"cd\" name=\"users\" value=\"2\" />\n                                        <label for=\"cd\">";
            echo $LNG["supplier"];
            echo "</label>\n                                        ";
        }
        echo "                                    <input type=\"radio\" onclick='showPID(this)' id=\"cd3\" name=\"users\" value=\"4\" />\n                                    <label for=\"cd3\">";
        echo $LNG["newsletter"];
        echo "</label>\n                                    ";
        if (!$IsFileOnly) {
            echo "                                        <input type=\"radio\" onclick='showPID(this)'  onblur='showPID(this)' id=\"cd5\" name=\"users\" value=\"5\" />\n                                        <label for=\"cd5\">";
            echo $LNG["product"];
            echo " ";
            echo $LNG["notification"];
            echo "</label>\n                                        ";
        }
        echo "                                    <input type=\"radio\" onclick='showPID(this)' id=\"abc\" name=\"users\" value=\"3\" />\n                                    <label for=\"abc\">";
        echo $LNG["pickeduser"];
        echo "</label>\n                                    &nbsp;&nbsp; <a href=\"javascript: load_subpage('includes/pages/pickuser.php','";
        echo $LNG["select_"] . " " . $LNG["user"];
        echo "')\">Pick User</a> </td>\n                            </tr>\n\n                            <tr id='ugid' style=\"display:none;\"  class=\"hightlight\">\n                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <td class=\"fieldlabel\" >\n                                    ";
        echo $LNG["group"];
        echo "                                </td><td  class=\"fieldarea\">\n                                    ";
        $cvr = mysqli_fetch_assoc(dquery("select * from tbl_client_group limit 1"));
        echo "                                    <input type=\"hidden\" name=\"gid\" id=\"selected\" value=\"";
        echo $cvr["id"];
        echo "\" />\n                                    <select name=\"imei\" id=\"imei\" multiple=\"multiple\" style=\"width: 200px;\" size=\"5\" onchange=\"loopSelected();\">\n                                        <option value=\"0\">";
        echo $LNG["default"];
        echo "</option>\n                                        ";
        $cg = dquery("select * from tbl_client_group order by displayorder asc");
        while ($rg = mysqli_fetch_assoc($cg)) {
            echo "                                            <option value=\"";
            echo $rg["id"];
            echo "\">";
            echo $rg["groupname"];
            echo "</option>\n                                            ";
        }
        echo "                                    </select>\n                                </td>\n                            </tr>\n                            <tr  class=\"hightlight\">\n                                <td class=\"fieldlabel\" >\n                                    &nbsp;\n                                </td>\n                                <td class=\"fieldarea\">\n                                    <input type=\"checkbox\" id=\"rts\" name=\"resellersu\" value=\"1\" checked=\"checked\" />\n                                    <label for=\"rts\">";
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
        echo "</label>\n                                </td>\n                            </tr>\n\n                            <tr id='pid' style=\"display:none;\"  class=\"hightlight\">\n                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <td class=\"fieldlabel\" >\n                                    ";
        echo $LNG["product"];
        echo "                                </td>\n                                <td  class=\"fieldarea\">\n                                    <select name='pid'>\n                                        ";
        $sql = dquery("select id,service_name from tbl_products");
        while ($row = mysqli_fetch_assoc($sql)) {
            echo "                                            <option value=\"";
            echo $row["id"];
            echo "\">";
            echo $row["service_name"];
            echo "</option>\n                                            ";
        }
        echo "                                    </select>\n                                </td>\n                            </tr>\n                            <tr  class=\"hightlight\">\n                                <td class=\"fieldlabel\" >\n                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo $LNG["userstatus"];
        echo "                                </td>\n                                <td class=\"fieldarea\">\n                                    <input type=\"radio\" name=\"type\" id=\"uu\" value=\"3\" checked />\n                                    <label for=\"uu\">";
        echo $LNG["all"];
        echo " ";
        echo $LNG["user"];
        echo "</label>\n                                    <input type=\"radio\" id=\"ee\" name=\"type\" value=\"1\"  />\n                                    <label for=\"ee\">";
        echo $LNG["active"];
        echo " ";
        echo $LNG["user"];
        echo "</label>\n                                    <input type=\"radio\" id=\"dd\" name=\"type\" value=\"2\"  />\n                                    <label for=\"dd\">";
        echo $LNG["inactive"];
        echo " ";
        echo $LNG["user"];
        echo "</label>\n                                </td>\n                            </tr>\n\n                            ";
        if (!$OnlyEcommerce) {
            echo "                                <tr  class=\"hightlight\">\n                                    <td class=\"fieldlabel\" >\n                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ";
            echo $LNG["client"];
            echo " ";
            echo $LNG["group"];
            echo "                                    </td>\n                                    <td class=\"fieldarea\">\n                                        <select  name=\"clientgrp\" >\n                                            <option value=\"\">";
            echo $LNG["select_"];
            echo " ";
            echo $LNG["group"];
            echo "</option>\n                                            <option value=\"0\">";
            echo $LNG["default"];
            echo "</option>\n                                            ";
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
            echo "                                        </select> &nbsp; <a href=\"#\" data-target=\"clientgroup\" data-target-header=\"";
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
            echo "</a>\n                                    </td>\n                                </tr>\n                                <tr  class=\"hightlight\">\n                                    <td class=\"fieldlabel\" >\n                                        &nbsp;\n                                    </td>\n                                    <td class=\"fieldarea\">\n                                        <input type=\"checkbox\" id=\"rts\" name=\"resellersu\" value=\"1\" checked=\"checked\" />\n                                        <label for=\"rts\">";
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
            echo "</label>\n                                    </td>\n                                </tr>\n                                ";
        }
        echo "                            <tr  class=\"hightlight\">\n                                <td class=\"fieldlabel\" >\n                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo $LNG["usertype"];
        echo "                                </td>\n                                <td class=\"fieldarea\">\n\n                                    <input type=\"radio\" checked=\"checked\" name=\"subscr\" value=\"1\" />\n                                    <label > Newsletter Subscribed User\n                                    </label>\n\n                                    <input type=\"radio\" name=\"subscr\" value=\"2\" />\n                                    <label > All User\n                                    </label>\n\n                                    <input type=\"radio\" name=\"subscr\" value=\"3\" />\n                                    <label > Users except Newsletter Subscriber\n                                    </label>\n                                </td>\n                            </tr>\n\n\n\n\n\n                            <tr>\n                                <td class=\"fieldlabel\">";
        echo $LNG["subject"];
        echo "</td>\n                                <td class=\"fieldarea\"><span><input type=\"text\"  class=\"txt large\" style=\"width: 400px;\" name=\"subject\"  value=\"";
        echo $temp["subject"];
        echo "\" /></span></td>\n                            </tr>\n                            ";
        if (!$load) {
            echo "                                <tr>\n                                    <td class=\"fieldlabel\">";
            echo $LNG["body"];
            echo "</td>\n                                    <td class=\"fieldarea\"><textarea name='body' id=\"message\">";
            echo nl2br($temp["message"]);
            echo "</textarea></td>\n                                </tr>\n\n                                <tr>\n                                    <td class=\"fieldlabel\">";
            echo $LNG["saveastemplate"];
            echo "</td>\n                                    <td class=\"fieldarea\"><span><input type=\"text\"  class=\"txt medium\" name=\"savetemplate\" /> ( ";
            echo $LNG["optional"];
            echo " )</span></td>\n                                </tr>\n                                <tr>\n                                    <td class=\"fieldlabel\"></td>\n                                    <td class=\"fieldarea\"><span><input type=\"checkbox\" name=\"plain\" id=\"plain\" /> <label for=\"plain\">";
            echo $LNG["plaintext"];
            echo "</label></span>\n\n                                        <span style=\"float: right;\">\n\n    <a style=\"text-decoration: none;\" class=\"default_dg_a2\" href=\"javascript: void(0)\"\n       onclick=\"window.open('includes/pages/evariablesimei.php?id=";
            echo $id;
            echo "',\n           'windowname1',\n           'width=400, height=400');\n           return false;\">";
            echo $LNG["variable"];
            echo "</a>\n\n&nbsp;&nbsp;&nbsp;&nbsp;\n\n       <a style=\"text-decoration: none;\" class=\"default_dg_a2\" href=\"javascript: void(0)\"\n          onclick=\"window.open('includes/pages/surveylink.php?id=";
            echo $id;
            echo "',\n              'windowname1',\n              'width=400, height=400');\n              return false;\">";
            echo $LNG["survey"];
            echo " ";
            echo $LNG["link"];
            echo "</a>\n\n  </span>\n\n\n\n                                    </td>\n                                </tr>\n                                ";
        } else {
            if ($temp["plaintext"]) {
                echo "                                    <input type=\"hidden\" name=\"plain\" value=\"on\" />\n                                    ";
            }
            echo "                                <tr>\n                                    <td class=\"fieldlabel\">";
            echo $LNG["body"];
            echo "</td>\n                                    <td class=\"fieldarea\"><textarea rows=\"10\" cols=\"100\" name='body' id=\"message\">";
            echo $temp["message"];
            echo "</textarea>\n                                        <span style=\"float: right;\">\n\n    <a  class=\"default_dg_a2\" href=\"javascript: void(0)\"\n        onclick=\"window.open('includes/pages/evariablesimei.php?id=";
            echo $id;
            echo "',\n            'windowname1',\n            'width=1000, height=600');\n            return false;\">";
            echo $LNG["variable"];
            echo "</a>\n\n|\n\n       <a  class=\"default_dg_a2\" href=\"javascript: void(0)\"\n           onclick=\"window.open('includes/pages/surveylink.php?id=";
            echo $id;
            echo "',\n               'windowname1',\n               'width=1000, height=600');\n               return false;\">";
            echo $LNG["survey"];
            echo " ";
            echo $LNG["link"];
            echo "</a>\n  </span>\n\n\n                                    </td>\n                                </tr>\n                                ";
        }
        echo "                            </tbody></table>\n                        <p align=\"center\" class=\"fixedbtn\">\n\n                            <input type=\"submit\" name=\"send\"\n                                   id=\"sendmai\" class=\"btn\"  value=\"";
        echo $LNG["send"];
        echo " ";
        echo $LNG["mail"];
        echo "\"  />\n\n                            <input type=\"submit\" name=\"sendbackground\"\n                                   id=\"sendbac\" class=\"btn\"  value=\"";
        echo $LNG["send"];
        echo " ";
        echo $LNG["in"];
        echo " ";
        echo $LNG["background"];
        echo "\"  />\n\n\n                            <input type=\"button\" name=\"preview\"\n                                   onclick=\"mailpreview();\"\n                                   id=\"preview\" class=\"btn\"  value=\"";
        echo $LNG["preview"];
        echo "\"  />\n\n\n                        </p>\n\n                    </div></div>\n\n            </form></div></div>\n    ";
    } else {
        if ($IsFileOnly) {
            $s = dquery("select `type` from tbl_emailtemplates where \n        `type`!='imeiorder' and `type`!='serverorder' and `type`!='product'\n         and `type`!='imeiorderbulk' group by `type`");
        } else {
            $s = dquery("select `type` from tbl_emailtemplates group by `type`");
        }
    }
    echo "        <optgroup  label=\"";
    echo $rs["type"];
    echo "\">\n        ";
    $temp = dquery("SELECT `id`,`name` FROM tbl_emailtemplates\n         where type='" . $rs["type"] . "'");
    while ($t = mysqli_fetch_assoc($temp)) {
        if ($t["name"] != "") {
            $selected = "";
            if ($selectedtmep["id"] == $t["id"]) {
                $selected = "selected";
            }
            echo "<option  value=\"";
            echo $t["id"];
            echo "\" ";
            echo $selected;
            echo " >";
            echo $t["name"];
            echo "</option>\n                ";
        }
    }
    echo "</optgroup>\n        ";
}
$fileverioncheck = "6.1.0";

?>