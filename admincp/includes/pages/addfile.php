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
if ($add && ($_FILES["file"]["error"] <= 0 || $external)) {
    if ($DEMOMODE) {
        echo "<div id='notification1' class='errorbox'>This function not enabled in demo mode</div>";
    } else {
        $data["filename"] = $filename != "" ? $filename : $_FILES["file"]["name"];
        if (deregi(".", $filename) && !preg_match("/[^a-zA-Z0-9-_\\.]/", $filename) || !$filename) {
            if ($_FILES["file"]["error"] <= 0) {
                $fext = substr($_FILES["file"]["name"], strrpos($_FILES["file"]["name"], "."));
                $finename = str_replace($fext, "", $_FILES["file"]["name"]);
                $filename = md5($finename . time()) . $fext;
                move_uploaded_file($_FILES["file"]["tmp_name"], ROOTDIR . "/" . $donloaddirpath . "/" . $filename);
            }
            $data["file"] = $filename;
            $data["description"] = $info;
            $data["group_id"] = $group_id;
            $data["reqlogin"] = $reqlogin;
            $data["forproduct"] = $forproduct;
            $data["external"] = $external;
            $data["donotshow"] = $donotshow;
            $data["date"] = $date;
            $data["size"] = round($_FILES["file"]["size"] / 1024 / 1024, 2);
            $db->insert("tbl_download", $data);
            $data = NULL;
            echo "<div id='notification1' class='successbox'>" . $LNG["download"] . " " . $LNG["file"] . " " . $LNG["added"] . " " . $LNG["successfully"] . "</div>";
        } else {
            echo "<div id='notification1' class='errorbox'>" . $LNG["wrong"] . " " . $LNG["name"] . " " . $LNG["format"] . "</div>";
        }
    }
} else {
    if ($add) {
        echo "<div id='notification1' class='errorbox'>" . $LNG["check"] . " " . $LNG["uploaded"] . " " . $LNG["file"] . "</div>";
    }
}
echo "\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" enctype=\"multipart/form-data\" method=\"post\">\n<input type=\"hidden\" name=\"loaddefaultpage\" value=\"addfile.php\" />\n";
echo generate_token("form");
echo "\n    <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n    <tbody>\n\n    <tr>\n        <td class=\"fieldlabel\">";
echo $LNG["file"];
echo " *</td>\n        <td class=\"fieldarea\"><input name=\"file\"  value=\"\" type=\"file\"/></td>\n    </tr>\n    <tr>\n        <td></td><td>OR</td>\n    </tr>\n    <tr>\n        <td class=\"fieldlabel\">External ";
echo $LNG["link"];
echo " *</td>\n        <td class=\"fieldarea\">\n        <input name=\"external\"  size=\"50\" value=\"\" type=\"text\"/></td>\n    </tr>\n\n    <tr>\n        <td class=\"fieldlabel\">";
echo $LNG["category"];
echo " </td>\n        <td class=\"fieldarea\">\n        <select name=\"group_id\">\n        ";
$cat = dquery("select id,category from tbl_downloadcat where mid=0");
while ($r = mysqli_fetch_assoc($cat)) {
    echo "        <option value=\"";
    echo $r["id"];
    echo "\">";
    echo $r["category"];
    echo "</option>\n        ";
    $catg = dquery("select id,category from\n             tbl_downloadcat where mid=" . $r["id"]);
    while ($rg = mysqli_fetch_assoc($catg)) {
        echo "        <option value=\"";
        echo $rg["id"];
        echo "\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo $rg["category"];
        echo "</option>\n                ";
    }
}
echo "        </select> &nbsp; <a href=\"#\" data-target=\"downloadmain\" data-target-header=\"";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["category"];
echo "\" onclick=\"AddnewInpopup(this);\">";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["category"];
echo "</a>\n        </td>\n    </tr>\n    <tr>\n        <td class=\"fieldlabel\">";
echo $LNG["file"];
echo " ";
echo $LNG["name"];
echo "</td>\n        <td class=\"fieldarea\"><input type=\"text\" name=\"filename\" /> <small>e.g downloads.zip</small></td>\n    </tr>\n\n    <tr>\n        <td class=\"fieldlabel\">";
echo $LNG["description"];
echo " </td>\n        <td class=\"fieldarea\"><textarea name=\"info\" ></textarea></td>\n    </tr>\n\n    <tr>\n        <td class=\"fieldlabel\">";
echo $LNG["required"];
echo " ";
echo $LNG["login"];
echo "</td>\n        <td class=\"fieldarea\"><input type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" name=\"reqlogin\" id=\"sa\" value=\"1\" /> <label for=\"sa\" ></label></td>\n    </tr>\n\n    <tr>\n        <td class=\"fieldlabel\">";
echo $LNG["for"];
echo " ";
echo $LNG["productsservices"];
echo "</td>\n        <td class=\"fieldarea\"><input type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" name=\"forproduct\" id=\"fa\" value=\"1\" /><label for=\"fa\"></label></td>\n    </tr>\n\n    <tr>\n        <td class=\"fieldlabel\">";
echo $LNG["donotshowclient"];
echo "</td>\n        <td class=\"fieldarea\"><input type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" name=\"donotshow\" id=\"lo\" value=\"1\" /><label for=\"lo\"></label></td>\n    </tr>\n    <tr>\n        <td class=\"fieldlabel\">";
echo $LNG["available"];
echo " ";
echo $LNG["till"];
echo " ";
echo $LNG["date"];
echo "</td>\n        <td class=\"fieldarea\">\n        <input name=\"date\" id=\"date\"  class=\"datepicker\"  placeholder=\"yyyy-mm-dd\"  size=\"10\" value=\"\" type=\"text\"/>\n        <small>Leave blank for keep live</small>\n        </td>\n    </tr>\n    <tr>\n        <td></td>\n        <td class=\"fieldarea\"><input value=\"";
echo $LNG["add"];
echo "\" name=\"add\" id=\"btnaddgroup\"  class=\"btn save\" type=\"submit\"/> </td>\n    </tr>\n    </tbody>\n    </table>\n\n</form>\n</div></div>\n";
$fileverioncheck = "6.1.0";

?>