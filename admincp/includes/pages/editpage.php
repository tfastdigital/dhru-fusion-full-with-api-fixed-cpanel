<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
echo "<script>\nfunction rSp(val){\n    document.getElementById('page').value =val.replace(/[^a-zA-Z0-9]+/g,'');\n}\n</script>\n<style>\n#tabmenu a{text-decoration: none; color: #666}\n#tabmenu{border-radius:0}\n</style>\n\n<div class=\"outertabdiv\"> \n<ul id=\"tabmenu\"> \n";
if ($plain && $id) {
    checkDemoMode(false);
    if ($plain == "Disable Editor") {
        dquery("update tbl_cms_pages set plain=1 where id='" . $id . "'");
    } else {
        dquery("update tbl_cms_pages set plain=0 where id='" . $id . "'");
    }
    $gid = $id;
} else {
    if ($oid) {
        $gid = $oid;
    } else {
        $gid = $id;
    }
}
echo "<script>\nfunction translator(lang){\n     \$(\"#main_loader\").show();\n   \$.post(\"includes/pages/cms.lang.php\", {language: lang,id: ";
echo $gid;
echo "},\n        function(data){\n        if(data){\n            if(document.getElementById('body_tbl')!=null){\n                tinyMCE.activeEditor.setContent(data);\n            }else{\n                document.getElementById('body').innerHTML=data;\n            }\n        }else{\n            alert(\"Translation Failed !\");\n        }\n        \$(\"#main_loader\").hide();\n   });\n}\n</script>\n";
$page = mysqli_fetch_assoc(dquery("SELECT plain FROM `tbl_cms_pages` WHERE  `id`='" . $gid . "'"));
if (!$page["plain"]) {
    require_once "includes/3rdparty/editor/editor.php";
}
if ($id) {
    $oid = $id;
    $files = $config["language"];
}
$handle = opendir("../" . $languagedirectorypath);
while (false !== ($file = readdir($handle))) {
    if ($file != "." && $file != ".." && $file != "") {
        $file = explode(".", $file);
        if ($file[0] && $file[1] == "txt") {
            echo "     <li><a href=\"main2.php?page=editpage&oid=";
            echo $oid;
            echo "&files=";
            echo $file[0];
            echo "\" id=\"tab1\" ";
            if ($file[0] == $files) {
                echo "class='tabmenu_active'";
            }
            echo ">";
            echo $file[0];
            echo "</a></li>\n ";
        }
    }
}
echo "<div style=\"clear: both;\"></div>\n</ul> \n\n\n<div id=\"tabcontent1\"> \n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\" class=\"groupstabescontant\">\n";
if ($oid && $files && $edit) {
    checkDemoMode(false);
    $obj = dquery("SELECT * FROM tbl_cms_page_language WHERE `relid`='" . $oid . "' AND `language`='" . $files . "'");
    if (mysqli_num_rows($obj)) {
        $editor = mysqli_fetch_assoc($obj);
        $data["title"] = $title;
        $data["breadcrumb"] = $breadcrumb;
        $data["body"] = $body;
        if ($db->update("tbl_cms_page_language", $data, "id=" . $editor["id"])) {
            $data = NULL;
            $data["urlname"] = $urlname;
            $data["meta_desc"] = $meta_desc;
            if ($iframe) {
                $data["iframe"] = $iframe;
            } else {
                $data["iframe"] = 0;
            }
            if ($fullwidth) {
                $data["fullwidth"] = 1;
            } else {
                $data["fullwidth"] = 0;
            }
            if ($login_req) {
                $data["login_req"] = 1;
            } else {
                $data["login_req"] = 0;
            }
            $data["status"] = $status ? "published" : "";
            $db->update("tbl_cms_pages", $data, "id=" . $oid);
            echo "<div id=notification1 class=successbox>  " . $LNG["savesuccessfully"] . " </div>";
        } else {
            echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
        }
        $data = NULL;
    } else {
        $data["title"] = $title;
        $data["breadcrumb"] = $breadcrumb;
        $data["body"] = $body;
        $data["language"] = $files;
        $data["relid"] = $oid;
        if ($db->insert("tbl_cms_page_language", $data)) {
            echo "<div id=notification1 class=successbox>  " . $LNG["savesuccessfully"] . " </div>";
        } else {
            echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
        }
        $data = NULL;
    }
}
if ($oid && $files) {
    $cms = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_cms_page_language` WHERE  `relid`='" . $oid . "' AND `language`='" . $files . "'"));
    $page = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_cms_pages` WHERE  `id`='" . $oid . "'"));
    echo "<script>\nfunction changeEdt(ids)\n{\n  \t\t\$.post(\"includes/pages/editpage.save.php\", { id: ids},\n\t\t  function(data) {\n\t\t  \n\t\t    location.reload();\n   });\n }\n</script>\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"edit\" value=\"true\" />\n";
    echo generate_token("form");
    echo "<input type=\"hidden\"  name=\"oid\" value=\"";
    echo $oid;
    echo "\"/>\n<input type=\"hidden\" name=\"files\" value=\"";
    echo $files;
    echo "\"/>\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\" style=\"width: 100%;\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["page"];
    echo " </td>\n    <td class=\"fieldarea\">\n    ";
    if ($oid < 5) {
        echo "        <input name=\"urlname\"   id=\"page\" value=\"";
        echo $page["urlname"];
        echo "\" type=\"hidden\"/>\n        ";
        echo $page["urlname"];
        echo "    ";
    } else {
        echo "    <input name=\"urlname\"  onkeyup=\"rSp(this.value)\" onblur=\"rSp(this.value)\" id=\"page\" value=\"";
        echo $page["urlname"];
        echo "\" type=\"text\"  class=\"txt medium\"/>\n    ";
    }
    echo "    \n     ";
    if ($config["googlelanguageapi"]) {
        echo "     \n        <input style=\"float: right; right: 5px !important; margin: 0 !important;  \" type=\"button\" name=\"google\" onclick=\"translator('";
        echo $files;
        echo "');\" value=\"";
        echo $LNG["translate"];
        echo " ";
        echo $LNG["from"];
        echo " ";
        echo $LNG["google"];
        echo "\" />\n      ";
    }
    echo "   \n      \n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["title"];
    echo " </td>\n    <td class=\"fieldarea\"><input name=\"title\"  value=\"";
    echo $cms["title"];
    echo "\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["breadcrumb"];
    echo " </td>\n    <td class=\"fieldarea\"><input name=\"breadcrumb\"  value=\"";
    echo $cms["breadcrumb"];
    echo "\" type=\"text\"  class=\"txt large\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["metakeywords"];
    echo " </td>\n    <td class=\"fieldarea\"><input name=\"meta_desc\"  value=\"";
    echo $page["meta_desc"];
    echo "\" type=\"text\"  class=\"txt large\"/>   \n     </td>\n</tr>\n<tr>\n    <td colspan=\"2\" style=\"padding: 10px 0;\">     \n        <textarea class=\"textarea large\" name='body' \n     id=\"message\">";
    echo $cms["body"];
    echo "</textarea>           \n    </td>\n</tr>\n\n<tr>   \n     <td class=\"fieldlabel\"> Page Property </td>\n    <td class=\"fieldarea\">\n    <input type='checkbox' name='iframe' id=\"ei\" value='1' ";
    if ($page["iframe"]) {
        echo "checked";
    }
    echo " /><label for=\"ei\" >";
    echo $LNG["show"];
    echo " ";
    echo $LNG["in"];
    echo " ";
    echo $LNG["iframe"];
    echo "</label> &nbsp;&nbsp;&nbsp;\n    <input type='checkbox' name='fullwidth' id=\"fsi\" value='1' ";
    if ($page["fullwidth"]) {
        echo "checked";
    }
    echo " /> <label for=\"fsi\" >";
    echo $LNG["show"];
    echo " ";
    echo $LNG["in"];
    echo " ";
    echo $LNG["full"];
    echo " ";
    echo $LNG["width"];
    echo "</label>&nbsp;&nbsp;&nbsp;\n    <input type='checkbox' name='login_req' id=\"lei\" value='1' ";
    if ($page["login_req"]) {
        echo "checked";
    }
    echo " /> <label for=\"lei\" >";
    echo $LNG["login"];
    echo " ";
    echo $LNG["required"];
    echo "</label>&nbsp;&nbsp;&nbsp;\n    <input type=\"checkbox\" id=\"inr\" ";
    if ($page["status"] == "published") {
        echo "checked='checked'";
    }
    echo " value=\"1\" name=\"status\" /> <label for=\"inr\">";
    echo $LNG["published"];
    echo "</label>&nbsp;&nbsp;&nbsp;\n    <input style=\"float: right;\" type='button' id='plain' name='plain' onclick='javascript: changeEdt(";
    echo $oid;
    echo ");'  value='";
    if ($page["plain"]) {
        echo "Enable Editor";
    } else {
        echo "Disable Editor";
    }
    echo "' />\n    <div class=\"clear\"></div>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\"> Page URL </td>\n    <td class=\"fieldarea\">        \n        ";
    $cms = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_cms_pages` WHERE  `id`='" . $oid . "'"));
    echo _url("pages/" . $cms["urlname"], true);
    echo "    </td>\n</tr>\n \n</tbody>\n</table>\n\n<div class=\"fixedbtn\">\n    <input value=\"";
    echo $LNG["save"];
    echo "\" id=\"btnoverview\" \n        class=\"btn save\" type=\"submit\"   />  \n</div>\n\n\n\n</form>\n";
}
echo "</div></div>\n </div> </div>\n";
$fileverioncheck = "6.1.0";

?>