<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 144;
checkPagePermission($pageid);
if (!$id) {
    $id = $_SESSION["adminid"];
}
$row = mysqli_fetch_assoc(dquery("select username from tbl_admin where id='" . $admn . "'"));
echo "    \n <script>  \n    subheader2_txt('[";
echo $LNG["edit"];
echo " : ";
echo $row["username"];
echo "]');\n </script>\n";
if (isset($htsave)) {
    if ($DEMOMODE) {
        echo "<div id='notification1' class='errorbox'>This Function not enabled in Demo Mode.</div>";
    } else {
        if ($htpass == $htconfirm && $htpass != "") {
            $htacess = file_get_contents(".htaccess");
            if (!strpos($htacess, "AuthUserFile") !== false) {
                $htacess = $htacess . "\n\n" . "AuthName \"Admin Only\"" . "\n" . "AuthType Basic" . "\n" . "AuthName \"Password Protected Area\"" . "\n" . "AuthUserFile " . $_SERVER["DOCUMENT_ROOT"] . "/" . $admindirpath . "/.htpasswd\nRequire valid-user";
                $fh = fopen(".htaccess", "w+");
                fwrite($fh, $htacess);
                fclose();
            }
            $pwd = "";
            if (is_file(".htpasswd")) {
                $pwd = file_get_contents(".htpasswd");
                $pwdline = explode("\n", $pwd);
                $flags = true;
                foreach ($pwdline as $p) {
                    $up = explode(":", $p);
                    if (trim($up[0]) == $row["username"]) {
                        $p = $up[0] . ":" . crypt($htpass);
                        $flags = false;
                    }
                    $buff .= $p . "\n";
                }
                if ($flags) {
                    $fh = fopen(".htpasswd", "w+");
                    fwrite($fh, $buff . $row["username"] . ":" . crypt($htpass));
                    fclose();
                } else {
                    $fh = fopen(".htpasswd", "w+");
                    fwrite($fh, $buff);
                    fclose();
                }
            } else {
                $fh = fopen(".htpasswd", "w+");
                fwrite($fh, $row["username"] . ":" . crypt($htpass));
                fclose();
            }
            echo "<div id='notification1' class='errorbox'>Password set successfully</div>";
        } else {
            echo "<div id='notification1' class='errorbox'>Both Password not match</div>";
        }
    }
}
if (isset($apisave)) {
    if ($DEMOMODE) {
        echo "<div id='notification1' class='errorbox'>This Function not enabled in Demo Mode.</div>";
    } else {
        $data = NULL;
        $data["api_key"] = $api_key;
        $data["api_access"] = $api_access;
        $data["api_ip"] = $api_ip;
        $db->update("tbl_admin", $data, "id=" . $admn);
        echo "<div id='notification1' class='successbox'>" . $LNG["datasavesuccessfully"] . "</div>";
    }
}
$admin_info = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_admin` WHERE `id`='" . $admn . "' "));
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form method=\"post\" name=\"frmeditadmin\" id=\"frmeditadmin\"  accept-charset='ISO-8859-15'>\n<input type=\"hidden\" name=\"admn\" value=\"";
echo $admn;
echo "\" />\n<input type=\"hidden\" name=\"pageid\" value=\"";
echo $pageid;
echo "\" />\n";
echo generate_token("form");
echo "<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<div  class=\"groupstabes\" >\n          <h2>            \n            <span class=\"groupstabesheadertext\">";
echo $LNG["admin"];
echo " ";
echo $LNG["profile"];
echo "</span>\n          </h2>\n          <div class=\"groupstabescontant\">\n<table   class=\"form\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["username"];
echo "</td>\n    <td class=\"fieldarea\">";
echo $admin_info["username"];
echo "</td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["firstname"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"firstname\"  value=\"";
echo $admin_info["firstname"];
echo "\" type=\"text\"  class=\"txt medium\" /></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["lastname"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"lastname\" value=\"";
echo $admin_info["lastname"];
echo "\" type=\"text\"  class=\"txt medium\" /></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["contact"];
echo " ";
echo $LNG["no"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"contact\"  value=\"";
echo $admin_info["contact"];
echo "\" type=\"text\"  class=\"txt medium\" /></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["email"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"email\" value=\"";
echo $admin_info["email"];
echo "\" type=\"text\"  class=\"txt medium\" /></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["assignrole"];
echo "</td>\n    <td class=\"fieldarea\"><select name=\"group_name\">\n ";
$query = "SELECT * FROM `tbl_admin_access_group`";
$result = dquery($query);
while ($noticia = mysqli_fetch_assoc($result)) {
    echo "<option value=\"";
    echo $noticia["id"];
    echo "\" ";
    if ($admin_info["group_id"] == $noticia["id"]) {
        echo "selected=selected";
    }
    echo ">";
    echo $noticia["group_name"];
    echo "</option>\n";
}
echo "</select>\n &nbsp; <a href=\"#\" data-target=\"adminroles\" data-target-header=\"";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " role\" onclick=\"AddnewInpopup(this);\">";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " role</a>\n</td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["my"];
echo " ";
echo $LNG["warehouse"];
echo "</td>\n    <td class=\"fieldarea\"><select name=\"mywarehouse\">\n    <option value=\"\">";
echo $LNG["select"];
echo "</option>\n    ";
$query = "SELECT * FROM `tbl_warehouse`";
$result = dquery($query);
while ($noticia = mysqli_fetch_assoc($result)) {
    echo "<option value=\"";
    echo $noticia["id"];
    echo "\" ";
    if ($admin_info["mywarehouse"] == $noticia["id"]) {
        echo "selected=selected";
    }
    echo ">";
    echo $noticia["name"];
    echo "</option>\n";
}
echo "</select> &nbsp; <a href=\"#\" data-target=\"warehouselist\" data-target-header=\"";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " warehouse\" onclick=\"AddnewInpopup(this);\">";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " warehouse</a>\n</td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["status"];
echo "</td>\n    <td class=\"fieldarea\"><input type=\"radio\" name=\"status\" value=\"0\" id=\"active\" ";
if ($admin_info["status"] == "0") {
    echo "checked";
}
echo "/><label for=\"active\">";
echo $LNG["active"];
echo "</label> <input type=\"radio\" name=\"status\" id=\"inactive\" value=\"1\" ";
if ($admin_info["status"] == "1") {
    echo "checked";
}
echo "/><label for=\"inactive\">";
echo $LNG["inactive"];
echo "</label></td></tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["language"];
echo "</td>\n    <td class=\"fieldarea\">\n";
echo str_replace("Language:", "", getLanguageDropdown($admin_info["language"]));
echo "    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["template"];
echo "</td>\n    <td class=\"fieldarea\">\n \n<select name=\"template\">\n";
$handle = opendir("templates");
while (($file = readdir($handle)) !== false) {
    if ($file != "." && $file != "..") {
        if (!($file != "default" && $file != "default.mobile")) {
            if ($admin_info["template"] == $file) {
                $selected = "selected=selected";
            } else {
                $selected = "";
            }
            if ($file != "mobile2") {
                echo "<option value=" . $file . " " . $selected . ">" . $file . "</option>";
            }
        }
    }
}
closedir($handle);
echo "   \n</select></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["theme"];
echo "</td>\n    <td class=\"fieldarea\">\n        <select name=\"theme\">\n            <option ";
if ($admin_info["theme"] == "dark") {
    echo "selected";
}
echo " value=\"dark\">Dark</option>\n            <option ";
if ($admin_info["theme"] == "light") {
    echo "selected";
}
echo " value=\"light\">Light</option>\n        </select>\n    </td>\n</tr>\n    ";
if (in_array(55, explode(",", $_SESSION["page_access"]))) {
    echo "\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["support"];
    echo " ";
    echo $LNG["department"];
    echo "</td>\n    <td class=\"fieldarea\">\n    ";
    $acc = explode(",", $admin_info["support_department"]);
    $sql = dquery("SELECT id,department from tbl_support_department");
    while ($row = mysqli_fetch_assoc($sql)) {
        $chekced = "";
        foreach ($acc as $a) {
            if ($a == $row["id"]) {
                $chekced = "checked='checked'";
            }
        }
        echo "        <input type=\"checkbox\" ";
        echo $chekced;
        echo "  name=\"department[";
        echo $row["id"];
        echo "]\" id=\"";
        echo $row["id"];
        echo "\" />&nbsp;&nbsp;\n        <label for=\"";
        echo $row["id"];
        echo "\">";
        echo $row["department"];
        echo "</label><br />     \n    ";
    }
    echo "    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["livehelp"];
    echo " ";
    echo $LNG["department"];
    echo "</td>\n    <td class=\"fieldarea\">\n    ";
    $acc = explode(",", $admin_info["chatdepartment"]);
    $sql = dquery("SELECT id,department from tbl_support_department");
    while ($row = mysqli_fetch_assoc($sql)) {
        $chekced = "";
        foreach ($acc as $a) {
            if ($a == $row["id"]) {
                $chekced = "checked='checked'";
            }
        }
        echo "        <input type=\"checkbox\" ";
        echo $chekced;
        echo "  name=\"chatdepartment[";
        echo $row["id"];
        echo "]\" id=\"d";
        echo $row["id"];
        echo "\" />&nbsp;&nbsp;\n        <label for=\"d";
        echo $row["id"];
        echo "\">";
        echo $row["department"];
        echo "</label><br />     \n    ";
    }
    echo "    </td>\n</tr>\n";
}
echo "<tr>\n    <td class=\"fieldlabel\">Allow Reject order after success</td>\n    <td class=\"fieldarea\">\n        <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\"  name=\"rejectaftersuccess\" value=\"1\" id=\"ref\" ";
if ($admin_info["rejectorder"] == 1) {
    echo "checked";
}
echo " /><label for=\"ref\"></label>\n\n    </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["daily"];
echo " ";
echo $LNG["sales"];
echo " ";
echo $LNG["report"];
echo " ";
echo $LNG["in"];
echo " ";
echo $LNG["email"];
echo "</td>\n    <td class=\"fieldarea\">\n        <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\"  name=\"salesreport\" value=\"1\" id=\"see\" ";
if ($admin_info["salesreport"] == 1) {
    echo "checked";
}
echo " /><label for=\"see\"></label>\n\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">\n    ";
echo $LNG["support"];
echo " ";
echo $LNG["ticket"];
echo " Signature</td>\n    <td class=\"fieldarea\">\n   <textarea name=\"signature\" cols=\"45\">";
echo $admin_info["signature"];
echo "</textarea>\n    </td>\n</tr>\n <tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btneditadmin\" class=\"btn save\" type=\"button\"  onclick=\"SubmitForm ('#btneditadmin','editadmin','#frmeditadmin','#notification','true','#main_loader');\"/></td>\n</tr>\n\n</tbody>\n</table>\n</div></div>\n</form>\n\n\n<form method=\"post\" id=\"frmpss\">\n    <input type=\"hidden\" name=\"adminid\" value=\"";
echo $admn;
echo "\" />\n<div  class=\"groupstabes\" >\n          <h2>\n            <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n            <span class=\"groupstabesheadertext\">.htaccess Protection</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n          </h2>\n          <div class=\"groupstabescontant\">\n<table class=\"form\">\n<tbody>\n<input type=\"hidden\" name=\"loaddefault\" value=\"editadmin.php\" />\n<tr>\n    <td class=\"fieldlabel\">New Password</td>\n    <td class=\"fieldarea\"><input type=\"text\" base64encode=\"true\"  class=\"txt medium\" name=\"htpass\"\n    value=\"\" /></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">Confirm Password</td>\n    <td class=\"fieldarea\"><input type=\"text\"  class=\"txt medium\"  base64encode=\"true\"\n                                 name=\"htconfirm\" value=\"\" /></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnhtpass\"\nonclick=\"SubmitFormNew('#btnhtpass','adminhtaccess','#frmpss','#notification','true','#main_loader');\"\n    class=\"btn save\" name=\"htsave\" type=\"button\" /></td>\n</tr>\n\n</tbody>\n</table>\n</div></div>\n</form>\n\n\n\n\n";
if (in_array(55, explode(",", $_SESSION["page_access"]))) {
    echo "<form method=\"post\">\n<div  class=\"groupstabes\" >\n          <h2>\n            <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n            <span class=\"groupstabesheadertext\">";
    echo $LNG["api"];
    echo " ";
    echo $LNG["setting"];
    echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n          </h2>\n          <div class=\"groupstabescontant\">\n<table  class=\"form\">\n<tbody>\n<input type=\"hidden\" name=\"loaddefault\" value=\"editadmin.php\" />\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["api"];
    echo " ";
    echo $LNG["key"];
    echo "</td>\n    <td class=\"fieldarea\"><input type=\"text\"  class=\"txt medium\" name=\"api_key\" value=\"";
    echo $admin_info["api_key"];
    echo "\" /></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["api"];
    echo " ";
    echo $LNG["ip"];
    echo "</td>\n    <td class=\"fieldarea\"><input type=\"text\"  class=\"txt medium\" name=\"api_ip\" value=\"";
    echo $admin_info["api_ip"];
    echo "\" /></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["api"];
    echo " ";
    echo $LNG["allow"];
    echo "</td>\n    <td class=\"fieldarea\">\n    <input type='radio' name='api_access' value='1' id=\"a\" ";
    if ($admin_info["api_access"]) {
        echo "checked";
    }
    echo " /><label for=\"a\">";
    echo $LNG["enable"];
    echo "</label>\n    <input type='radio' name='api_access' value='0' id=\"b\" ";
    if (!$admin_info["api_access"]) {
        echo "checked";
    }
    echo " /><label for=\"b\">";
    echo $LNG["disable"];
    echo "</label>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\"><input value=\"";
    echo $LNG["save"];
    echo "\" id=\"btneditadmin\" class=\"btn save\" name=\"apisave\" type=\"submit\" /></td>\n</tr>\n\n</tbody>\n</table>\n</div></div>\n</form>\n";
}
echo "\n";
$fileverioncheck = "6.1.0";

?>