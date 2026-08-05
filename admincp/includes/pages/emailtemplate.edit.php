<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 23;
checkPagePermission($pageid);
echo " \n<script>\nfunction showPreview(id,lang)\n{\n    \n    window.open('includes/pages/mailpreview.php?id='+id+\"&lang=\"+lang,\n\t  'windowname1', \n\t  'width=500, height=500'); \n\t \n}\nfunction showDefaultPreview(id,lang)\n{\n\n    window.open('includes/pages/mailpreview.php?id='+id+\"&default=1&lang=\"+lang,\n        'windowname1',\n        'width=500, height=500');\n\n}\nfunction translator(lang){\n     \$(\"#main_loader\").show();\n   \$.post(\"includes/pages/emailtemplate.lang.php\", {language: lang,id: ";
echo $id;
echo "},\n        function(data){\n        if(data){\n            data=data.split('+++');\n            document.getElementById('subject').value=data[0];\n            if(document.getElementById('message_tbl')!=null){\n                tinyMCE.activeEditor.setContent(data[1]);\n            }else{\n                document.getElementById('message').innerHTML=data[1];\n            }\n        }else{\n            alert(\"Translation Failed !\");\n        }\n         \$(\"#main_loader\").hide();\n      \n   });\n}\nfunction change()\n{\n    var tplain;\n    tplain=document.getElementById('plain').checked;\n   \$.post(\"includes/pages/emailtemplate.save.php\", { id: ";
echo $id;
echo ", plain: tplain },\n        function(data){\n        location.reload(true);\n   });\n}\n</script>\n<ul id=\"tabmenu\"> \n";
$handle = opendir("../" . $languagedirectorypath);
while (false !== ($file = readdir($handle))) {
    if ($file != "." && $file != ".." && $file != "") {
        $file = explode(".", $file);
        if ($file[0] && $file[1] == "txt") {
            echo "<li><a href=\"javascript: load_subpage('main2.php?page=emailtemplate.edit&id=";
            echo $id;
            echo "&oid=";
            echo $oid;
            echo "&files=";
            echo $file[0];
            echo "','Edit Mail Template');\" id=\"tab1\" ";
            if ($file[0] == $files) {
                echo "class='tabmenu_active'";
            } else {
                if ($file[0] == "English" && $files == "") {
                    echo "class='tabmenu_active'";
                }
            }
            echo ">";
            echo $file[0];
            echo "</a></li>\n ";
        }
    }
}
echo "<div style=\"clear: both;\"></div>\n</ul>  \n<div id=\"tabcontent\"> \n";
if ($laoddefaultpage == "emailtemplate.add.php") {
    foreach ($_POST as $k => $v) {
        if ($k == "message") {
            $v = base64_encode($v);
        }
        $buff .= "&" . $k . "=" . $v;
    }
    $buff .= "&vadhare=true";
    echo "   <script>\ngetContect('#tab1','main2.php?page=emailtemplate.add";
    echo $buff;
    echo "','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');   \n   </script>\n   ";
}
if ($save) {
    checkDemoMode(false);
    $data = NULL;
    if ($layoutid == 1) {
        $plain = "";
    }
    $data["plaintext"] = $plain;
    $data["fromname"] = $fromname;
    $data["fromemail"] = $frommail;
    $data["copyto"] = $copyto;
    $data["mailserv"] = $mailserv;
    $data["layoutid"] = $layoutid;
    if ($name) {
        $data["name"] = $name;
    }
    if ($config["mail_sending_type"] == 1) {
        $data["scheduled"] = $scheduled;
    }
    if ($files != "English") {
        $el = dquery("select id from tbl_emailtemplate_language where template_id='" . $id . "'\n        and language='" . $files . "'");
        if (mysqli_num_rows($el)) {
            $dat["subject"] = $subject;
            $dat["message"] = html_entity_decode($message);
            $db->update("tbl_emailtemplate_language", $dat, "template_id='" . $id . "' and language='" . $files . "'");
            $dat = NULL;
        } else {
            $dat["language"] = $files;
            $dat["template_id"] = $id;
            $dat["subject"] = $subject;
            $dat["message"] = html_entity_decode($message);
            $db->insert("tbl_emailtemplate_language", $dat);
            $dat = NULL;
        }
    } else {
        if ($message) {
            $data["subject"] = $subject;
            $data["message"] = str_replace("&nbsp;", " ", html_entity_decode($message));
        }
    }
    if ($status == "0") {
        $data["disabled"] = 0;
    } else {
        $data["disabled"] = 1;
    }
    $db->update("tbl_emailtemplates", $data, "id='" . $id . "'");
    $data = NULL;
    echo "<div id='notification1' class='successbox'>" . $LNG["templateupdate"] . "</div>";
}
if ($reset) {
    checkDemoMode(false);
    $data = NULL;
    $detail = mysqli_fetch_assoc(dquery("select * from tbl_emailtemplates_backup\n    where id='" . $id . "'"));
    $detail["message"] = html_entity_decode($detail["message"]);
    $data = $detail;
    $db->update("tbl_emailtemplates", $data, "id='" . $id . "'");
    $data = NULL;
    echo "<div id='notification1' class='successbox'>" . $LNG["template"] . " " . $LNG["reset"] . " " . $LNG["successfully"] . "</div>";
}
$templatedetail = mysqli_fetch_assoc(dquery("SELECT * FROM \n   `tbl_emailtemplates` WHERE `id`='" . $id . "'"));
if ($files != "English" && $files != "") {
    $ds = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_emailtemplate_language`\n    WHERE `template_id`='" . $id . "' and language='" . $files . "'"));
    $templatedetail["subject"] = $ds["subject"];
    $templatedetail["message"] = $ds["message"];
}
if (!$templatedetail["plaintext"]) {
    include_once "includes/3rdparty/editor/editor.php";
}
echo "\n\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\"> \n<form method=\"post\" name=\"frmeditemailtemplate\" id=\"frmeditemailtemplate\">\n<input type=\"hidden\" name=\"files\" value=\"";
echo $files != "" ? $files : "English";
echo "\" />\n    ";
echo generate_token("form");
echo "  \n    <input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n    <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n    <tbody>\n    <tr><td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["name"];
echo "</td><td class=\"fieldarea\">\n\n            ";
if ($id <= 1000) {
    echo "                ";
    echo $templatedetail["name"];
    echo "                ";
} else {
    echo "                <input type=\"text\" name=\"name\" value=\"";
    echo $templatedetail["name"];
    echo "\" />\n                ";
}
echo "            ";
if ($config["googlelanguageapi"]) {
    echo " \n    \n<input style=\"float: right; right: 5px !important; margin: 0 !important;  \" type=\"button\" name=\"google\" onclick=\"translator('";
    echo $files;
    echo "','";
    echo $id;
    echo "');\" \nvalue=\"";
    echo $LNG["translate"];
    echo " ";
    echo $LNG["from"];
    echo " ";
    echo $LNG["google"];
    echo "\" />\n      ";
}
echo "      </td></tr> \n";
if ($config["mail_sending_type"] == 1) {
    echo "  \n     <tr><td class=\"fieldlabel\" width=\"15%\">Scheduled</td><td class=\"fieldarea\">\n     <input type=\"checkbox\" class=\"onoff {labelOn: 'Scheduled', labelOff: 'Instant'}\" \n     name=\"scheduled\" value=\"1\" ";
    if ($templatedetail["scheduled"]) {
        echo "checked";
    }
    echo " \n     id=\"essd\" /><label for=\"essd\"></label>     \n      </td></tr>\n";
}
echo "      \n     <tr>\n     <td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["status"];
echo "</td><td class=\"fieldarea\">\n     <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" \n     name=\"status\" value=\"0\" ";
if (!$templatedetail["disabled"]) {
    echo "checked";
}
echo " \n     id=\"es\" /><label for=\"es\"></label>     \n     </td>\n     </tr>\n \n     <tr>\n     <td class=\"fieldlabel\" width=\"15%\">Mail ";
echo $LNG["server"];
echo "</td><td class=\"fieldarea\">\n     <select name=\"mailserv\" >\n<option value=\"\">Default Mail Server</option>\n<option  ";
if ($templatedetail["mailserv"] == "1") {
    echo "selected";
}
echo "  value=\"1\">Mail Server1</option>\n<option  ";
if ($templatedetail["mailserv"] == "2") {
    echo "selected";
}
echo " value=\"2\">Mail Server2</option>        \n     </select>    \n     </td>\n     </tr>\n\n     <tr>\n     <td class=\"fieldlabel\" width=\"15%\">Mail Layout</td><td class=\"fieldarea\">\n     <select name=\"layoutid\" onchange=\"javascript: if(this.value==1) { \$('#plainmail').hide(); } else { \$('#plainmail').show(); }\" >\n<option value=\"\">No Layout</option>\n";
$ql = dquery("select id,name from tbl_email_layout");
while ($rl = mysqli_fetch_assoc($ql)) {
    echo "    <option value=\"";
    echo $rl["id"];
    echo "\" ";
    if ($templatedetail["layoutid"] == $rl["id"]) {
        echo "selected";
    }
    echo "  >";
    echo $rl["name"];
    echo "</option>\n    ";
}
echo "     </select>   &nbsp; <a href=\"#\" data-target=\"emailtemplate.layout\" data-target-header=\"";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["email"];
echo " layout\" onclick=\"AddnewInpopup(this);\">";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["email"];
echo " layout</a>  \n     </td>\n     </tr>                \n    <tr><td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["fromname"];
echo "</td>\n    <td class=\"fieldarea\"> <input type=\"text\"  name=\"fromname\"  value=\"";
echo $templatedetail["fromname"];
echo "\" size=\"100\"/> </td></tr>\n    \n        \n    <tr><td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["frommail"];
echo "</td>\n    <td class=\"fieldarea\"> <input type=\"text\"  name=\"frommail\" value=\"";
echo $templatedetail["fromemail"];
echo "\"  size=\"100\"/> </td></tr>\n    \n        \n    <tr><td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["copyto"];
echo "</td>\n    <td class=\"fieldarea\"> <input type=\"text\"  name=\"copyto\" value=\"";
echo $templatedetail["copyto"];
echo "\"  size=\"100\"/> </td></tr>\n  \n      <tr><td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["subject"];
echo "</td>\n      <td class=\"fieldarea\" colspan=\"2\" > <input type=\"text\" id=\"subject\" value=\"";
echo $templatedetail["subject"];
echo "\" name=\"subject\"  size=\"100\"/>      \n      </td></tr>\n\n    <tr id=\"\"><td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["message"];
echo "</td><td colspan=\"2\" class=\"fieldarea\">\n    <textarea name=\"message\" id=\"message\"  class=\"\" rows=\"25\" style=\"width:100%;\"> ";
echo $templatedetail["message"];
echo " </textarea>\n            ";
if ($templatedetail["id"] == 76) {
    echo "                <br />\n                ";
    echo $LNG["new"];
    echo " ";
    echo $LNG["variable"];
    echo " :<span><strong>{\$imeilist}</strong> for bulk order, <strong>{\$model}</strong> - Model Name, <strong>{\$provider}</strong> - Provider Name ,\n                    <strong>{\$note}</strong> - Order Note, <strong>{\$mep}</strong> - MEP,\n                    <strong>{\$pin}</strong> - PIN, <strong>{\$kbh}</strong> - KBH, <strong>{\$prd}</strong> - PRD,\n                    <strong>{\$type}</strong> - Type, <strong>{\$reference}</strong> - Reference </span>\n                , <strong>{\$order}</strong> - Order ID </span>, <strong>{\$credit}</strong> - Credit </span>\n            ";
} else {
    if ($templatedetail["id"] == 8) {
        echo "                <br />\n                ";
        echo $LNG["new"];
        echo " ";
        echo $LNG["variable"];
        echo " :\n                <span><strong>{\$transactionid}</strong> Transaction ID,\n                    <strong>{\$usernote}</strong> - User Notes</span>\n                ";
    } else {
        if ($templatedetail["id"] == 31) {
            echo "                <br />\n                ";
            echo $LNG["new"];
            echo " ";
            echo $LNG["variable"];
            echo " :\n                <span><strong>{\$referenceid}</strong> Reference ID\n                ";
        }
    }
}
echo "    </td></tr>\n    \n     <tr><td class=\"fieldlabel\"></td><td class=\"fieldarea\">\n";
if ($templatedetail["layoutid"] != 1) {
    echo "     \n<span id=\"plainmail\">\n    <input name=\"plain\"  value=\"1\" type=\"checkbox\" id=\"plain\" onClick=\"change(); \"\n     ";
    if ($templatedetail["plaintext"]) {
        echo "checked";
    }
    echo " /> <label for=\"plain\">";
    echo $LNG["plaintext"];
    echo "</label>\n</span>\n";
} else {
    echo "    <input name=\"plain\"  value=\"\" type=\"hidden\" />\n";
}
echo "     \n     \n     \n       <a style=\"text-decoration: none;\" class=\"default_dg_a2\" href=\"javascript: void(0)\" \n       onclick=\"window.open('includes/pages/evariablesimei.php?id=";
echo $id;
echo "', \n\t  'windowname1', \n\t  'width=400, height=400'); \n\t   return false;\">";
echo $LNG["variable"];
echo "</a>\n \n       <a style=\"text-decoration: none;\" class=\"default_dg_a2\" href=\"javascript: void(0)\" \n       onclick=\"window.open('includes/pages/surveylink.php?id=";
echo $id;
echo "', \n\t  'windowname1', \n\t  'width=400, height=400'); \n\t   return false;\">";
echo $LNG["survey"];
echo " ";
echo $LNG["link"];
echo "</a>\n       \n             \n       </td>\n     </tr>\n           \n    </tbody> \n</table>\n    <br /> <br /> <br />\n    \n    <p class=\"fixedbtn\">\n               <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnditemailtemplate\" name=\"save\"\n         class=\"btn btn-primary\" type=\"submit\"  />\n         \n          <input value=\"";
echo $LNG["preview"];
echo "\" name=\"prev\" onclick=\"showPreview('";
echo $templatedetail["id"];
echo "','";
echo $files ? $files : "";
echo "');\"\n         class=\"btn btn-default\" type=\"button\"  />\n        <input value=\"";
echo $LNG["default"];
echo " ";
echo $LNG["preview"];
echo "\" name=\"prev\" onclick=\"showDefaultPreview('";
echo $templatedetail["id"];
echo "','";
echo $files ? $files : "";
echo "');\"\n               class=\"btn btn-default\" type=\"button\"  />\n\n";
if ($templatedetail["custom"] != 1) {
    echo "       \n   <input value=\"";
    echo $LNG["reset"];
    echo " ";
    echo $LNG["default"];
    echo "\" \n    name=\"reset\"\n     class=\"btn btn-default\" type=\"submit\"  />\n";
}
echo "    </p>\n    \n</form>\n</div>\n</div> </div>\n";
$fileverioncheck = "6.1.0";

?>