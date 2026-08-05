<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"notification\"></div>\r\n";
if (!licince\checkSupport()) {
    echo "<div id='notification1' class='errorbox' > Support and Maintenance Required for this features</div>";
    exit;
}
$fromcampaign = true;
include "includes/3rdparty/editor/editor.php";
$pageid = 334;
checkPagePermission($pageid);
define("MASSMAIL", true);
echo "\r\n<script>\r\n    function previewd()\r\n    {\r\n        window.open('includes/pages/preview.php','Preview','height=600,width=550');\r\n\r\n    }\r\n    function setNews(val){\r\n        if(val==2){\r\n            \$(\".otherclient\").hide();\r\n        }else{\r\n            \$(\".otherclient\").show();\r\n        }\r\n    }\r\n    function calculateUser(){\r\n        var user=\$(\"#users\").val();\r\n        var usertype=\$(\"#usertype\").val();\r\n        var clientgroup=\$(\"#clientgroup\").val();\r\n        var userstatus=\$(\"#userstatus\").val();\r\n        var unsubscriber=0;\r\n        if(\$(\"#unsubscriber\").is(\":checked\")){\r\n            unsubscriber=1;\r\n        }\r\n        \$.post(\"includes/pages/campaignremove.php?user=\"+user+\"&usertype=\"+usertype+\"&clientgroup=\"+clientgroup+\"&unsubscriber=\"+unsubscriber+'&userstatus='+userstatus, function( data ) {\r\n            \$( \"#totalmsg\" ).html( data );\r\n        });\r\n    }\r\n    calculateUser();\r\n</script>\r\n\r\n<div id=\"content\">\r\n    ";
if ($publish) {
    echo "        <div id=\"notification1\" class=\"info\">Create Cron Job : /usr/bin/wget -O - -q -t 1 ";
    echo $config["site_address"];
    echo "includes/cron2.php?action=campaign";
    echo $config["cronpassword"] ? "?cronpasscode=" . $config["cronpassword"] : "";
    echo "</div>\r\n    ";
}
echo "    <div id=\"content_padded\">\r\n        <div  class=\"groupstabes\" >\r\n            <h2>\r\n                <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\r\n                ";
if ($next == 3) {
    echo "                    <span class=\"groupstabesheadertext\">Add Recipients</span>&nbsp;<font\r\n                            class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\r\n                    ";
} else {
    if ($next == 2) {
        echo "                    <span class=\"groupstabesheadertext\">Compose Message</span>&nbsp;<font\r\n                        class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\r\n                    ";
    } else {
        echo "                    <span class=\"groupstabesheadertext\">Create ";
        echo $LNG["campaign"];
        echo "</span>&nbsp;<font\r\n                            class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\r\n                    ";
    }
}
echo "            </h2>\r\n            <div class=\"groupstabescontant\">\r\n                ";
if ($next == 3) {
    if ($edit) {
        $campo = mysqli_fetch_assoc(dquery("select * from tbl_campaign where id='" . $edit . "'"));
        $users = json_decode($campo["users"], true);
    }
    echo "                <form id=\"mails\" name=\"mails\" method=\"post\">\r\n                    <input type=\"hidden\" name=\"next\" value=\"3\"/>\r\n                    ";
    if ($edit) {
        echo "            <input type=\"hidden\" name=\"edit\" value=\"";
        echo $edit;
        echo "\" />\r\n                        ";
    }
    echo "                    <input type=\"hidden\" name=\"campid\" value=\"";
    echo $campid;
    echo "\" />\r\n                    ";
    echo generate_token("form");
    echo "                    <table class=\"form\" cellpadding=\"5\">\r\n\r\n<tr>\r\n<td class=\"fieldlabel\">Users From</td>\r\n<td class=\"fieldlarea\">\r\n    <select name=\"users\" id=\"users\" onchange=\"setNews(this.value); calculateUser();\">\r\n        <option value=\"1\" ";
    if ($users["users"] == 1) {
        echo "selected";
    }
    echo ">Site Users</option>\r\n        <option value=\"2\" ";
    if ($users["users"] == 2) {
        echo "selected";
    }
    echo ">Newsletter</option>\r\n    </select>\r\n</td>\r\n<tr class=\"otherclient\">\r\n    <td class=\"fieldlabel\">User Type</td>\r\n    <td class=\"fieldlarea\">\r\n    <select name=\"usertype\" onchange=\"calculateUser();\" id=\"usertype\">\r\n        <option value=\"\">All User</option>\r\n        <option value=\"1\" ";
    if ($users["usertype"] == 1) {
        echo "selected";
    }
    echo ">Reseller</option>\r\n        <option value=\"0\" ";
    if ($users["usertype"] == 0) {
        echo "selected";
    }
    echo ">User</option>\r\n    </select>\r\n    </td>\r\n</tr>\r\n<tr class=\"otherclient\">\r\n<td class=\"fieldlabel\"> Client Group </td>\r\n<td class=\"fieldlarea\">\r\n    <select name=\"clientgroup\"  onchange=\"calculateUser();\"  id=\"clientgroup\">\r\n        <option value=\"\" >All Group</option>\r\n        ";
    $dq = dquery("select id,groupname from tbl_client_group");
    while ($r = mysqli_fetch_assoc($dq)) {
        echo "                <option  ";
        if ($users["clientgroup"] == $r["id"]) {
            echo "selected";
        }
        echo " value=\"";
        echo $r["id"];
        echo "\">";
        echo $r["groupname"];
        echo "</option>\r\n        ";
    }
    echo "    </select>\r\n</td>\r\n</tr>\r\n<tr class=\"otherclient\">\r\n    <td class=\"fieldlabel\"> User Status</td>\r\n    <td class=\"fieldlarea\">\r\n    <select name=\"userstatus\"  onchange=\"calculateUser();\"  id=\"userstatus\">\r\n        <option value=\"\">All User</option>\r\n        <option value=\"1\" ";
    if ($users["userstatus"] == 1) {
        echo "selected";
    }
    echo ">Active</option>\r\n        <option value=\"2\" ";
    if ($users["userstatus"] == 2) {
        echo "selected";
    }
    echo ">In-Active</option>\r\n    </select>\r\n\r\n</td>\r\n</tr>\r\n    <tr class=\"otherclient\">\r\n        <td class=\"fieldlabel\"> </td>\r\n        <td class=\"fieldlarea\">\r\n<lable><input type=\"checkbox\" onclick=\"calculateUser();\" name=\"unsubscriber\" id=\"unsubscriber\"\r\n        ";
    if ($users["unsubscriber"]) {
        echo "checked='checked'";
    }
    echo "              checked=\"checked\" value=\"1\" />Dont send users opt-out from subscription</lable>\r\n        </td>\r\n    </tr>\r\n<tr>\r\n    <td></td>\r\n    <td id=\"totalmsg\"></td>\r\n</tr>\r\n<tr>\r\n    <td class=\"fieldlabel\"></td>\r\n    <td class=\"fieldlarea\">\r\n        <input type=\"text\" name=\"testemail\" value=\"\" placeholder=\"Test Email\" />\r\n        <input type=\"button\" id=\"sendtest\" name=\"sendtest\" value=\"";
    echo $LNG["send"];
    echo " Test ";
    echo $LNG["email"];
    echo "\"\r\n               onclick=\"SubmitForm('#publish','campaigntest','#mails','#notification','true','#main_loader');\"\r\n        />\r\n\r\n    </td>\r\n</tr>\r\n<tr>\r\n<td class=\"fieldlabel\"></td>\r\n<td class=\"fieldlarea\">\r\n    <input type=\"button\" id=\"next3\" name=\"next3\" value=\"";
    echo $LNG["save"];
    echo " as draft\"\r\n           onclick=\"javascript: SubmitForm('#next3','campaign','#mails','#notification','true','#main_loader'); \$('#closesubpage').trigger('click');\"\r\n    />\r\n    <input type=\"button\" id=\"publish\" name=\"publish\" value=\"";
    echo $LNG["publish"];
    echo "\"\r\n     onclick=\"SubmitForm('#publish','campaignpublish','#mails','#notification','true','#main_loader');\"\r\n    />\r\n\r\n</td>\r\n</tr>\r\n\r\n                    </table>\r\n                </form>\r\n                    ";
    unset($_SESSION["preview"]);
} else {
    if ($next == 2 || $edit) {
        if ($edit) {
            $camp = mysqli_fetch_assoc(dquery("select * from tbl_campaign where id='" . $edit . "'"));
            $temp["title"] = $camp["title"];
            $temp["subject"] = $camp["subject"];
            $temp["message"] = base64_decode($camp["message"]);
            $temp["mailserver"] = $camp["mailserver"];
            $template = 0;
        } else {
            if ($template) {
                $temp = mysqli_fetch_assoc(dquery("select * from tbl_emailtemplates where id='" . $template . "'"));
                if ($temp[layoutid]) {
                    $layout = mysqli_fetch_assoc(dquery("select * from tbl_email_layout where id='" . $temp["layoutid"] . "'"));
                }
            }
        }
        echo "                <form id=\"mails\" name=\"mails\" method=\"post\">\r\n                    <input type=\"hidden\" name=\"next\" value=\"2\"/>\r\n                    ";
        if ($edit) {
            echo "                        <input type=\"hidden\" name=\"edit\" value=\"";
            echo $edit;
            echo "\" />\r\n                    ";
        }
        echo "                    <input type=\"hidden\" name=\"template\" value=\"";
        echo $template;
        echo "\" />\r\n                    ";
        echo generate_token("form");
        echo "                    <table class=\"form\" cellpadding=\"5\">\r\n                        <tr>\r\n                            <td class=\"fieldlabel\">";
        echo $LNG["campaign"];
        echo " ";
        echo $LNG["name"];
        echo "</td>\r\n                            <td class=\"fieldlarea\">\r\n                                <input type=\"text\" size=\"50\" name=\"title\" value=\"";
        echo $temp["title"];
        echo "\"/>\r\n                            </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td class=\"fieldlabel\">";
        echo $LNG["subject"];
        echo "</td>\r\n                            <td class=\"fieldlarea\">\r\n                                <input type=\"text\" size=\"50\" name=\"subject\" value=\"";
        echo $temp["subject"];
        echo "\"/>\r\n                            </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td class=\"fieldlabel\">";
        echo $LNG["message"];
        echo "</td>\r\n                            <td class=\"fieldlarea\">\r\n                                <input type=\"hidden\" name=\"email\" id=\"email\" />\r\n                    <textarea name='body'  id=\"message\">";
        echo $layout["header"] . nl2br($temp["message"]) . $layout["footer"];
        echo "</textarea>                            </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td class=\"fieldlabel\">";
        echo $LNG["mail"];
        echo " ";
        echo $LNG["server"];
        echo "</td>\r\n                            <td class=\"fieldlarea\">\r\n                                <select name=\"mailserver\">\r\n                                    <option value=\"\">Default Mail Server</option>\r\n                                    <option value=\"1\" ";
        if ($temp["mailserver"] == 1) {
            echo "selected";
        }
        echo " >Mail Server1</option>\r\n                                    <option value=\"2\" ";
        if ($temp["mailserver"] == 2) {
            echo "selected";
        }
        echo ">Mail Server2</option>\r\n                                </select>\r\n                            </td>\r\n                        </tr>\r\n\r\n                        <tr>\r\n                            <td class=\"fieldlabel\"><br/><br/></td>\r\n                            <td class=\"fieldlarea\">\r\n                                <input type=\"button\" id=\"next2\" name=\"next2\" value=\"";
        echo $LNG["next"];
        echo "\"\r\n onclick=\"document.getElementById('email').value= tinyMCE.get('message').getContent();SubmitForm('#next2','campaign','#mails','#notification','true','#main_loader');\"\r\n                                />\r\n            <input type=\"button\" name=\"preview\"\r\n                   onclick=\"previewd();\"\r\n                   value=\"";
        echo $LNG["preview"];
        echo "\" />\r\n                            </td>\r\n                        </tr>\r\n                    </table>\r\n                </form>\r\n\r\n                    ";
        $_SESSION["preview"] = $layout["header"] . nl2br($temp["message"]) . $layout["footer"];
    } else {
        echo "                    <form id=\"mails\" name=\"mails\" method=\"post\">\r\n                        <input type=\"hidden\" name=\"next\" value=\"1\"/>\r\n                        ";
        echo generate_token("form");
        echo "\r\n                        <table class=\"form\" cellpadding=\"5\">\r\n\r\n\r\n\r\n                            <tr>\r\n                                <td class=\"fieldlabel\" width=\"15%\">Load ";
        echo $LNG["from"];
        echo " ";
        echo $LNG["template"];
        echo "</td>\r\n                                <td class=\"fieldarea\">\r\n\r\n                                    <select name=\"template\" class=\"chosen\">\r\n                                        <option value=\"\">";
        echo $LNG["select"];
        echo "</option>\r\n                                        ";
        $s = dquery("select `type` from tbl_emailtemplates where `custom`=1 or `type`='other' group by `type`");
        while ($rs = mysqli_fetch_assoc($s)) {
            echo "                                            <optgroup label=\"";
            echo $rs["type"];
            echo "\">\r\n                                                ";
            $temp = dquery("SELECT `id`,`name` FROM tbl_emailtemplates\r\n         where type='" . $rs["type"] . "' and custom=1 ");
            while ($t = mysqli_fetch_assoc($temp)) {
                if ($t["name"] != "") {
                    $selected = "";
                    if ($selectedtmep["id"] == $t["id"]) {
                        $selected = "selected";
                    }
                    echo "                                                        <option\r\n                                                        value=\"";
                    echo $t["id"];
                    echo "\" ";
                    echo $selected;
                    echo " >";
                    echo $t["name"];
                    echo "</option>\r\n                                                        ";
                }
            }
            echo "</optgroup>\r\n                                            ";
        }
        echo "                                    </select>\r\n                                </td>\r\n                            </tr>\r\n\r\n\r\n                            <tr>\r\n                                <td class=\"fieldlabel\"\r\n                                </td>\r\n                                <td class=\"fieldlarea\">\r\n                                    OR\r\n                                </td>\r\n                            </tr>\r\n\r\n                            <tr>\r\n                                <td class=\"fieldlabel\"></td>\r\n                                <td class=\"fieldlarea\">\r\n                                    ";
        echo $LNG["create"];
        echo " ";
        echo $LNG["new"];
        echo " with empty ";
        echo $LNG["content"];
        echo "                                    <br/>\r\n                                </td>\r\n                            </tr>\r\n\r\n                            <tr>\r\n                                <td class=\"fieldlabel\"><br/><br/></td>\r\n                                <td class=\"fieldlarea\">\r\n                                    <input type=\"button\" id=\"next1\" name=\"next1\" value=\"";
        echo $LNG["next"];
        echo "\"\r\n                                           onclick=\"SubmitForm('#next1','campaign','#mails','#notification','true','#main_loader');\"      />\r\n                                </td>\r\n                            </tr>\r\n                        </table>\r\n                    </form>\r\n                    ";
    }
}
$fileverioncheck = "6.1.0";
echo "    </div>\r\n</div>\r\n";

?>